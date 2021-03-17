<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Booking;
use App\Models\ChannelActivation;
use App\Models\Client\ClientWeekPlan;
use App\Models\ClientPlan;
use App\Models\FinalPayment;
use App\Models\OauthAccessToken;
use App\Models\ServiceBooking;
use App\Models\UserIdentity;
use App\Models\UserInvitation;
use Carbon\Carbon;
use function Complex\negative;
use DateTime;
use function GuzzleHttp\Psr7\str;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mail;
use Monolog\Handler\SyslogUdp\UdpSocket;
use Nette\Utils\Random;
use test\Mockery\ReturnTypeObjectTypeHint;
use Validator;
use App\User;
use App\Traits\ZestLogTrait;
use App\Http\Requests\AuthenticateRequest;
use App\Http\Requests\PersonalizeRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\Goal;
use App\Models\DownloadProgram;
use App\Models\TrainingProgramPriceSetup;
use App\Models\Notification;

class AuthenticateController extends Controller
{
    use SendsPasswordResetEmails;
    use ZestLogTrait;

    /**
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login(Request $request)
    {
        $input = $request->all();
        $validations = [
            'extension' => 'required',
            'identifier' => 'required',
            'password' => 'required',
            'device_token' => 'required',
            'device_type' => 'required'
        ];
        $validator = \Validator::make($input, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $extension = $request->input('extension');
            $user = User::findForPassport($request->input('identifier'),$extension);
            $this->statusCode = $this->errorCode;
            $this->message = 'Invalid phone number';
            if (!empty($user)) {
                $this->message = 'User is not verified';
                if (!empty($user->is_verify)) {
                    $this->message = 'Password does not match';
//                if (Auth::attempt(['user_name' => $user->user_name, 'password' => $request->input('password')])) {
                    if (\Hash::check($request->input('password'), $user->password)) {
                        $user = User::find($user->id);
                        $user->last_login = currentDateTime();
                        $user->device_token = $request->input('device_token');
                        $user->device_type = $request->input('device_type');
                        $user->save();

                        $this->data['token'] = $user->createToken('MyApp')->accessToken;
                        $obj = DownloadProgram::where('user_id', '=', $user->id)->first();
                        if (!empty($obj))
                            $this->planId = $obj->plan_id;
                        $goalName = $profilePic = '';
                        if (!empty($user->goal_id)) {
                            $objGoal = Goal::find($user->goal_id);
                            if (!empty($objGoal)) {
                                $goalName = $objGoal->name;
                            }
                        }
                        if(!empty($user->profile_pic_upload)) {
                            $profilePic = asset(MobileUserImagePath.'/'.$user->profile_pic_upload);
                        }
                        $user->goal_name = $goalName;
                        $user->profile_pic_upload = $profilePic;
                        $user->plan_id = $this->planId;
                        $birthday = $user->birthday;
                        $user->birthday = (string) dateFormat($user->birthday);
                        $user = $user->toArray();
                        $user['f_s_key'] = '9ZESTMfTAS68NRV2T262012MA';
                        $age = [];
                        if ($user['birthday'] != '00/00/0000') {
                            $age = getAgeFromBirthday($birthday);
                        }
                        if (!empty($age)) {
                            $user['age'] = $age;
                        } else {
                            $user['age'] = '';
                        }
                        $this->data['user'] =  $user;
                        $this->success = true;
                        $this->statusCode = $this->successCode;
                        $this->message = Lang::get('messages.loginSuccess');
                    }
                }
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /** 
     * signup api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function signup(Request $request)
    {
        $birthday = $request->input('date_of_birth');
        $date = str_replace('/', '-', $birthday);
        $date1 = date("Y-m-d", strtotime($date));
        $date2 = date("Y-m-d", strtotime(currentDateTime()));
        $diff = abs(strtotime($date2) - strtotime($date1));
        $age = (int)floor($diff / (365 * 60 * 60 * 24));
        $birthday = $date1;
        if($age >= 13 ){
            $input = $request->all();
            $validations = [
                'first_name' => 'required',
                'last_name' => 'required',
                'password' => 'required',
                'extension' => 'required',
                'date_of_birth' => 'required',
                'mobile_number' => 'required|unique:users,mobile_number,{$id},id,deleted_at,NULL',
                'device_token' => 'required',
                'device_type' => 'required'
            ];
            $validator = \Validator::make($input, $validations);
            if ($validator->fails()) {
                $this->message = formatErrors($validator->errors()->toArray());
            } else {
                $input['password'] = \Hash::make($input['password']);

                $input['otp_code'] = 4444;
                $input['otp_send_time'] = currentDateTime();
//        $input['otp_code'] = mt_rand(1000, 9999);
                $number = "+" . $input['extension'] . $input['mobile_number'];
                try {
                    $otp_message = 'Your OTP for zestlog signup is ' . $input['otp_code'];
                    $this->sendMessage($otp_message, $number);
                    try {
                        DB::beginTransaction();
                        $now = Carbon::now();
                        $userCountObj = User::where('first_name',strtolower($request->input('first_name')))
                            ->where('last_name',strtolower($request->input('last_name')))
                            ->count('id');
                        if(!empty($userCountObj)){
                            $userCountObj = $userCountObj+1;
                            $userNameUnique = strtolower($request->input('first_name')).'.'.strtolower($request->input('last_name')).$userCountObj;
                        }else{
                            $userNameUnique = strtolower($request->input('first_name')).'.'.strtolower($request->input('last_name'));
                        }
                        $j = true;
                        while ($j== true){
                            $obj = User::where('user_name',$userNameUnique)->first();
                            if (empty($obj)) {
                                $j = false;
                            } else {
                                $userCountObj = $userCountObj + 1;
                                $userNameUnique = strtolower($request->input('first_name')) . '.' . strtolower($request->input('last_name')) . $userCountObj;
                            }
                        }
                        $input['user_type'] = 2;
                        $input['user_name'] = $userNameUnique;
                        $input['birthday'] = (string) databaseDateFromat($birthday);
                        $user = User::create($input);
                        if ($user) {
                            $invitationCodemonth = $now->format('sihdm');
                            $firstname =  substr($user->first_name,0,1);
                            $lastname =  substr($user->last_name,0,1);
                            $i = true;
                            $randomStrNew = '';
                            while ($i== true){
                                $randomStr = generateRandomString(1);
                                $randomStrNew = $firstname.$lastname.$invitationCodemonth.$randomStr;
                                $obj = UserInvitation::where('invitation_code',$randomStrNew)->first();
                                if(empty($obj)){
                                    $i = false;
                                }
                            }
                            $arr['user_id'] = $user->id;
                            $arr['invitation_code'] = $randomStrNew;
                            if (!empty($request->input('invited_code')))
                                $arr['invited_code'] = $input['invited_code'];
                            if (!empty($request->input('invited_user_id')))
                                $arr['invited_user_id'] = $input['invited_user_id'];
                            $arr['created_at'] = currentDateTime();
                            $arr['updated_at'] = currentDateTime();

                            UserInvitation::insert($arr);
                            DB::commit();


                            $this->data['token'] = $user->createToken('zestlog')->accessToken;
                            $this->data['user_name'] = $user->user_name;
                            $this->data['device_token'] = $request->input('device_token');
                            $this->data['device_type']  = $request->input('device_type');
                            $this->data['user_id'] = $user->id;
                            $this->data['otp_code'] = $input['otp_code'];
                            $this->data['mobile_number'] = $user->mobile_number;
                            $this->data['extension'] = $user->extension;
                            $this->success = true;
                            $this->statusCode = $this->successCode;
                            $this->message = Lang::get('messages.otpSentSuccess');

                            $arr['title'] = 'Sign up Verification';
                            $arr['message'] = $otp_message;
                            $arr['device_token'] = $this->data['device_token'];
//                        $this->sendPushNotifications($arr);
                        }
                    } catch (\Illuminate\Database\QueryException $e) {
                        $this->message = $e->errorInfo[2];
                        DB::rollback();
                    }
                } catch (\Twilio\Exceptions\RestException $e) {
                    $this->message = $e->getMessage();
                    $this->success = false;
                    $this->data = (object)[];
                }
            }
        }else{
            $this->success = false;
            $this->message = 'You must be 13 or older';
            $this->data = (object)[];
        }


        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to check username exist or not
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function isUniqueName(Request $request)
    {
        $userName = strtolower($request->input('user_name'));
        $this->message = 'Please provide User Name';
        if (!empty($userName)) {
            $obj = User::where('user_name', '=', $userName)->first();
            if ($obj) {
                $this->message = 'User is already exist';
                $this->statusCode = $this->errorCode;
            } else {
                $this->statusCode = $this->successCode;
                $this->message = 'User Name is Unique';
                $this->success = true;
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to check mobile number is unique or not
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function isUniqueNumber(Request $request)
    {
        $mobileNumber = $request->input('mobile_number');
        $extension = $request->input('extension');
        $this->message = 'Please provide Mobile Number';
        if (!empty($mobileNumber) && !empty($extension)) {
            $obj = User::where('mobile_number', '=', $mobileNumber)->where('extension', '=', $extension)->first();
            if ($obj) {
                $this->message = 'Mobile Number is already exist';
                $this->statusCode = $this->errorCode;
            } else {
                $this->statusCode = $this->successCode;
                $this->message = 'Mobile Number is Unique';
                $this->success = true;
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used test otp
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyOtp(Request $request)
    {
        $input = $request->all();
        $this->userName = $input['user_name'];
        $this->otpCode = $input['otp_code'];

        if ($this->userName && $this->otpCode) {
            $objUser = User::where('user_name', $this->userName)->first();
            if ($objUser !== null) {
                if ($input['otp_code'] == 1) {
                    $objUser->is_verify = 1;
                    $objUser->otp_code = null;
                    $objUser->otp_send_time = null;
                    if ($objUser->save()) {
                        $this->success = true;
                        $this->message = 'User is verified successfully';
                        $this->statusCode = $this->successCode;
                    } else {
                        $this->message = 'Error while verifying user in DB.';
                    }
                } else {
                    $this->message = 'User Not verify';
                }
            } else {
                $this->message = 'User does not exist';
            }
        } else {
            $this->message = 'Please provide user_name and otp_code';
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to update mobile number
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMobileNumber(Request $request)
    {
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'otp_code' => 'required',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $this->setUserId($request);
            $objUser = User::find($this->userId);
            if ($objUser) {
                if ((int)$objUser->otp_code === (int)$data['otp_code']) {
                    $objUser->mobile_number = $objUser->temp_mobile_number;
                    $objUser->temp_mobile_number = null;
                    $objUser->otp_code = null;
                    if ($objUser->save()) {
                        $this->success = true;
                        $this->message = 'Mobile Number is changed successfully';
                    } else {
                        $this->message = ['Error while verifying user in DB.'];
                    }
                } else {
                    $this->message = ['Invalid OTP code.'];
                }
            } else {
                $this->message = ['User does not exist'];
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /*
     * This is used to change email adress
     */
    public function changeEmailAddress(Request $request)
    {
        $this->setUserId($request);
        if ($this->userId) {
            $objUser = User::find($this->userId);
            if ($objUser) {
                $data = $request->all();
                $validations = [
                    'email' => 'required|unique:users,email,' . $this->userId,
//                    'extension' => 'required|integer'
                ];
                $validator = \Validator::make($data, $validations);
                if ($validator->fails()) {
                    $this->message = formatErrors($validator->errors()->toArray());
                } else {
                    $data['otp_code'] = mt_rand(1000, 9999);
//                    $input['otp_code'] = mt_rand(1000, 9999);
                    try {
                        $otp_message = 'Your email verification code is ' . $data['otp_code'];
//                        $this->sendMessage($otp_message, $email);
                        try {
                            $arr = [];
                            $arr['message'] = $otp_message;
                            $arr['view'] = 'mail';
                            $arr['to_email'] = $data['email'];
                            $arr['subject'] = 'Email verification code';
                            sendMail($arr);
                            $objUser->otp_code = $data['otp_code'];
                            $objUser->temp_email_address = $data['email'];
                            $objUser->save();
                            $this->message = 'OTP is sent for email verification';
                            $this->success = true;
                        } catch (\Illuminate\Database\QueryException $e) {
                            if (!empty($e->errorInfo[2]))
                                $this->message = [$e->errorInfo[2]];
                            else
                                $this->message = 'Something went wrong';
                        }
                    } catch (\Twilio\Exceptions\RestException $e) {
                        $this->message = [$e->getMessage()];
                        $this->success = false;
                    }
                }
            } else {
                $this->message = [Lang::get('messages.userNotFound')];
            }
        } else {
            $this->message = [Lang::get('messages.userNotFound')];
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);


    }
    /*
     * this is used to update email adress
     */

    public function updateEmailAddress(Request $request){
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'otp_code' => 'required',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $this->setUserId($request);
            $objUser = User::find($this->userId);
            if ($objUser) {
                if ((int)$objUser->otp_code === (int)$data['otp_code']) {
                    $objUser->email = $objUser->temp_email_address;
                    $objUser->temp_email_address = null;
                    $objUser->otp_code = null;
                    if ($objUser->save()) {
                        $this->success = true;
                        $this->message = 'Email is changed successfully';
                    } else {
                        $this->message = ['Error while verifying user in DB.'];
                    }
                } else {
                    $this->message = ['Invalid OTP code.'];
                }
            } else {
                $this->message = ['User does not exist'];
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);

    }

    /*
     * this is used to user name change
     */

    public  function changeUserName(Request $request){
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'user_name' => 'required|unique:users,user_name,{$id},id,deleted_at,NULL',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            try {
                DB::beginTransaction();
                $this->setUserId($request);
                $objUser = User::find($this->userId);
                if (!empty($objUser)) {
                    $objUser->user_name = $data['user_name'];
                    if ($objUser->save()) {
                        $userObj = User::where('id', $this->userId)->where('user_type', 0)->first();
                        if (!empty($userObj)) {
                            ServiceBooking::where('client_id', $userObj->id)->update([
                                'first_name' => $userObj->first_name,
                                'middle_name' => $userObj->middle_name,
                                'last_name' => $userObj->last_name,
                                'user_name' => $userObj->user_name,
                            ]);
                        }
                        $this->success = true;
                        $this->message = ['User Name is changed successfully'];
                    }

                } else {
                    $this->message = 'User does not exist';
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        }

        return response()->json(['success' => $this->success, 'message' => $this->message], $this->statusCode);

    }

        /**
     *
     * ForgotPassword API
     *
     * @param    email address
     * @return   result
     *
     */
    public function forgotPassword(Request $request)
    {
        $identifier = preg_replace('/[+]/', "", $request->input('identifier'));
        $user = User::findForPassport($identifier);
        $this->message = 'User Does not exist';
        if (!empty($user)) {
            $number = '+' . $user->extension . $user->mobile_number;
            try {
                $otpCode = 4444;
//                $otpCode = mt_rand(1000, 9999);
                $otp_message = 'Your OTP for Zestlog Forgot Password is ' . $otpCode;
                $this->sendMessage($otp_message, $number);
                try {
                    $user->otp_code = $otpCode;
                    if ($user->save()) {
                        $this->success = true;
                        $this->statusCode = $this->successCode;
                        $this->message = 'OTP code is sent successfully';
                        $this->data['user_name'] = $user->user_name;
                    }
                } catch (\Illuminate\Database\QueryException $e) {
                    $this->message = $e->errorInfo[2];
                }
            } catch (\Twilio\Exceptions\RestException $e) {
                $this->message = $e->getMessage();
                $this->success = false;
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to update password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $otp = (int)$request->input('otp');
        $identifier = $request->input('identifier');
        if (!empty($otp) && !empty($identifier) && !empty($request->input('password'))) {
            $this->message = 'User does not exist';
            $obj = User::findForPassport($identifier);
            if ($obj) {
                if ($otp == (int)$obj->otp_code) {
                    $this->message = 'There is some problem to update password. Please try again later';
                    $obj->password = \Hash::make($request->input('password'));
                    $obj->otp_code = null;
                    if ($obj->save()) {
                        $this->message = 'Password is updated successfully';
                        $this->success = true;
                        $this->statusCode = $this->successCode;
                    }
                } else {
                    $this->message = 'OTP does not match';
                }
            }
        } else {
            $this->message = 'Please provide all fields';
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to send resend OTP
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function resendOTP(Request $request)
    {
        $identifier = $request->input('identifier');
        $extension = $request->input('extension');
        $this->message = 'Please provide identifier';
        if (!empty($identifier)) {
            $this->message = 'User does not exist';
            $user = User::findForPassport($identifier,$extension);
            if ($user) {
                try {
                    $number = '+' . $user->extension . $user->mobile_number;
                    $otpCode = 4444;
//                    $otpCode = mt_rand(1000, 9999);
                    $oldMobileNumber = $user->mobile_number;
                    $oldExtension = $user->extension;
                    $otp_message = 'Your New Zestlog OTP is ' . $otpCode;
                    $this->sendMessage($otp_message, $number);
                    try {
                        $user->otp_code = $otpCode;
                        $user->otp_send_time = currentDateTime();
                        if ($user->save()) {
                            $arr['title'] = 'Change Mobile Number';
                            $arr['message'] = $otp_message;
                            $arr['device_token'] = $user->device_token;
//                            $this->sendPushNotifications($arr);

                            $this->success = true;
                            $this->statusCode = $this->successCode;
                            $this->message = 'OTP code is sent successfully';
                            $this->data['user_name'] = $user->user_name;
                            $this->data['old_mobile_number'] = $oldMobileNumber;
                            $this->data['old_extension'] = $oldExtension;
                        }
                    } catch (\Illuminate\Database\QueryException $e) {
                        $this->message = $e->errorInfo[2];
                    }
                } catch (\Twilio\Exceptions\RestException $e) {
                    $this->message = $e->getMessage();
                    $this->success = false;
                }
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * user personal info
     *
     * @param    user id
     * @return user data
     */
    public function userInfo(Request $request)
    {
        $this->setUserId($request);
        $id = $this->userId;
        if ($id) {
            $userResult = User::where(['id' => $id])->first();
            if (!empty($userResult)) {
                $this->data = $userResult->toArray();
                $this->data['birthday'] = (string) dateFormat($this->data['birthday']);
                unset($this->data['password']);
                $this->success = true;
                $this->statusCode = $this->successCode;
            } else {
                $this->statusCode = $this->errorCode;
                $this->message = Lang::get('messages.resultNotFound');
            }
        } else {
            $this->message = Lang::get('messages.reqiredFiledError', ['filedName' => 'ID']);
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * user personal info Update
     *
     * @param    user id
     * @return user data
     */
    public function userDataUpdate(Request $request)
    {

        $birthday = $request->input('birthday');
        $date = str_replace('/', '-', $birthday);
        $date1 = date("Y-m-d", strtotime($date));
        $date2 = date("Y-m-d", strtotime(currentDateTime()));
        $diff = abs(strtotime($date2) - strtotime($date1));
        $age = (int)floor($diff / (365 * 60 * 60 * 24));
        $birthday = $date1;
        if ($age >= 13) {
            $this->userId = $request->input('user_id');
            if ($this->userId) {
                $data = $request->all();
                $validations = [
//                'user_id' => 'required',
                    'user_name' => 'unique:users,user_name,' . $this->userId,
                    'email' => 'unique:users,email,' . $this->userId,
                    'height_units' => 'regex:/^[a-zA-Z]+$/u',
                    'weight_units' => 'regex:/^[a-zA-Z]+$/u'
                ];
                $validator = \Validator::make($data, $validations);
                if ($validator->fails()) {
                    $this->message = formatErrors($validator->errors()->toArray());
                } else {
                    try {
                        DB::beginTransaction();
                        $obj = User::where(['id' => $this->userId])->first();
                        if ($obj) {
                            $arrData = $request->all();
                            unset($arrData['password']);
                            unset($arrData['mobile_number']);
                            if (isset($arrData['birthday']) && !empty($arrData['birthday'])) {
                                $arrData['birthday'] = databaseDateFromat($birthday);
                            }
                            $obj->update($arrData);
                            $userObj = User::where('id',$this->userId)->where('user_type',0)->first();
                            if (!empty($userObj)) {
                                $objServiceBooking = ServiceBooking::where('client_id', $userObj->id)->update([
                                    'first_name' => $userObj->first_name,
                                    'middle_name' => $userObj->middle_name,
                                    'last_name' => $userObj->last_name,
                                    'user_name' => $userObj->user_name,
                                ]);
                            }
                            $obj->birthday = (string)dateFormat($obj->birthday);
                            $updateduser = User::where(['id' => $this->userId])->first();
                            $this->data[] = $updateduser->toArray();
                            $this->success = true;
                            $this->message = Lang::get('messages.recordUpdatedSuccess');
                        } else {
                            $this->statusCode = $this->errorCode;
                            $this->message = [Lang::get('messages.resultNotFound')];
                        }
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollback();
                    }
                }
            } else {
                $this->message = [Lang::get('messages.reqiredFiledError', ['filedName' => 'ID'])];
            }
        } else {
            $this->success = false;
            $this->message = 'You must be 13 or older';
            $this->data = (object)[];
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * signup api
     *
     * @return \Illuminate\Http\Response
     */
    public function personalize_program(PersonalizeRequest $request)
    {
        $input = $request->all();
        $input['user_name'] = $request->input('user_name');
        $this->statusCode = $this->errorCode;
        $this->message = Lang::get('messages.userNotFound');

        $user = User::where([
                    ['user_name' ,'=', $input['user_name']]
        ])->first();
        if (!empty($user)) {
                $dataArray = [];
                if (!empty($input['goal_id'])) {
                    $dataArray['goal_id'] = $input['goal_id'];
                }
                if (!empty($input['gender'])) {
                    $dataArray['gender'] = $input['gender'];
                }
                if (!empty($input['birthday'])) {
                    $dataArray['birthday'] = databaseDateFromat($input['birthday']);
                }
                if (!empty($input['height'])) {
                    $dataArray['height'] = $input['height'];
                }
                if (!empty($input['height_units'])) {
                    $dataArray['height_units'] = $input['height_units'];
                }
                if(!empty($input['weight'])) {
                    $dataArray['weight'] = $input['weight'];
                }
                if (!empty($input['weight_units'])) {
                    $dataArray['weight_units'] = $input['weight_units'];
                }

                $user->update($dataArray);
                $this->success = true;
                $this->statusCode = $this->successCode;
                $this->message = Lang::get('messages.personalizeSuccess');
                $user->birthday = (string) dateFormat($user->birthday);
                $this->data['user'] = $user;
        } else{
            $this->message = Lang::get('messages.userNotFound');
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    public function changeMobileNumber(Request $request)
    {
        $this->setUserId($request);
        if ($this->userId) {
            $objUser = User::find($this->userId);
            if ($objUser) {
                $data = $request->all();
                $validations = [
                    'mobile_number' => 'required|integer|unique:users,mobile_number,' . $this->userId,
                    'extension' => 'required|integer'
                ];
                $validator = \Validator::make($data, $validations);
                if ($validator->fails()) {
                    $this->message = formatErrors($validator->errors()->toArray());
                } else {
                    $data['otp_code'] = 4444;
                    //$input['otp_code'] = mt_rand(1000, 9999);
                    $number = "+" . $data['extension'] . $data['mobile_number'];
                    try {
                        $otp_message = 'Your OTP for zestlog change password is ' . $data['otp_code'];
                        $this->sendMessage($otp_message, $number);
                        try {
                            $objUser->otp_code = $data['otp_code'];
                            $objUser->temp_mobile_number = $data['mobile_number'];
                            $objUser->save();
                            $arr['title'] = 'Change Mobile Number';
                            $arr['message'] = $otp_message;
                            $arr['device_token'] = $objUser->device_token;
//                            $this->sendPushNotifications($arr);
                            $this->message = 'OTP is sent for mobile verification';
                            $this->success = true;
                        } catch (\Illuminate\Database\QueryException $e) {
                            if (!empty($e->errorInfo[2]))
                                $this->message = [$e->errorInfo[2]];
                            else
                                $this->message = 'Something went wrong';
                        }
                    } catch (\Twilio\Exceptions\RestException $e) {
                        $this->message = [$e->getMessage()];
                        $this->success = false;
                    }
                }
            } else {
                $this->message = [Lang::get('messages.userNotFound')];
            }
        } else {
            $this->message = [Lang::get('messages.userNotFound')];
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to return goals
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function goals()
    {
        return response()->json(['success' => true, 'data' => Goal::all()->toArray(), 'message' => $this->message], $this->successCode);
    }

    /**
     * image upload api
     *
     * @return \Illuminate\Http\Response
     */
    public function imageUpload(Request $request)
    {
        $this->setUserId($request);
        $obj = User::find($this->userId);
        if ($obj) {
            if (!empty($request->input('image'))) {
                $image = preg_replace('/^data:image\/\w+;base64,/i', '', $request->input('image'));
                $image = str_replace(' ', '+', $image);
                $fileName = createImageUniqueName('jpg');
                $destinationPath = public_path(MobileUserImagePath);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $tempFile = $destinationPath . '/' . $fileName;
                file_put_contents($tempFile, base64_decode($image));
                $obj->profile_pic_upload = $fileName;
                if ($obj->save()) {
                    $this->data['profile_pic_upload'] =  asset(MobileUserImagePath.'/'.$obj->profile_pic_upload);
                    $this->success = true;
                    $this->message = Lang::get('messages.imageUpload');
                } else {
                    $this->message = 'There is some problem to upload image';
                }
            } else {
                $this->message = 'Please provide image';
            }
        } else {
            $this->message = 'User does not exist';
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * this is use to update channel status
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserChannelStatus(Request $request)
    {
        $this->setUserId($request);
        $userId = $this->userId;
        $isCoachChannel = $request->input('is_coach_channel');
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'is_coach_channel' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            if ($isCoachChannel == '0') {
                $date = date('Y-m-d');
                $isProgram = false;
                $serviceBookingObj = ServiceBooking::select('fp.starting_date', 'wp.meta_data as week_id')
                    ->where('service_bookings.client_id', $userId)
                    ->join('final_payments as fp', 'fp.unique_id', '=', 'service_bookings.unique_id')
                    ->join('week_programs as wp', 'wp.id', '=', 'service_bookings.week_id')
                    ->where('fp.is_payment', 1)
                    ->get()->toArray();
                foreach ($serviceBookingObj as $key => $row) {
                    $weeks = '+' . $row['week_id'] . ' week';
                    $endPlanDate = date('Y-m-d', strtotime($weeks, strtotime($row['starting_date'])));
                    if (strtotime($endPlanDate) > strtotime($date)) {
                        $isProgram = true;
                        break;
                    }
                }
                if ($isProgram) {
                    $this->message = 'Your channel cannot be deactivated,because there are bookings in Waiting or Active list on your web panel.';
                    $this->success = false;
                    return response()->json(['success' => $this->success, 'message' => $this->message]);
                } else {
                    $this->message = 'Your channel is now deactivated.';
                }

            }
            $objchannel = ChannelActivation::where('user_id', $userId)
                ->get()->toArray();
            if ($objchannel) {
                try {
                    DB::beginTransaction();
                    DB::table('channel_activations')
                        ->where('user_id', $userId)
                        ->update(['is_coach_channel' => $isCoachChannel]);
                    if ($isCoachChannel == 1) {
                        $obj = User::where('id', $userId)
                            ->first();
                        if ($obj) {
                            $isNew = $obj->is_new;
                            $obj->user_type = 0;
                            $obj->is_coach_channel = 1;
                            if ($isNew == 1) {
                                $this->userId = $userId;
                                $this->defaultUserData();
                                $obj->is_new = 0;
                            }
                            $obj->save();
                        }
                    } elseif ($isCoachChannel == 0) {
                        $obj = User::where('id', $userId)
                            ->first();
                        if ($obj) {
                            $obj->user_type = 2;
                            $obj->is_coach_channel = 0;
                            $obj->save();
                        }
                    }
                    $this->success = true;
                    if ($isCoachChannel == '1') {
                        $this->message = 'Channel Activated Successfully';
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                }
            } else {
                $this->success = false;
                $this->message = 'Record not found';
            }
        }

        return response()->json(['success' => $this->success,'message' => $this->message]);
    }

    /**
     * this is use to check coach channel status
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUserChannelStatus(Request $request)
    {
        $userId = $request->input('user_id');;
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $objChannel = ChannelActivation::select('is_coach_channel')
                ->where('user_id', $userId)
                ->first();
            if ($objChannel) {
                $this->data['is_coach_channel'] = $objChannel->is_coach_channel;
                $this->success = true;
            } else {
                $this->data = (object)[];
                $this->message = 'Record not found';
            }
        }

        return response()->json(['success' => $this->success,'data' => $this->data,'message' => $this->message]);
    }

    /**
     * this is used to delete unverified user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUserData(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->setUserId($request);
            $userId = $this->userId;
            $data = $request->all();
            $validations = [
                'user_id' => 'required|integer',
            ];
            $validator = \Validator::make($data, $validations);
            if ($validator->fails()) {
                $this->message = formatErrors($validator->errors()->toArray());
            } else {
                $obj = User::where('user_type', '!=', 1)->where('id', $userId)->first();
                if ($obj) {
                    $objId = $obj->id;
                    UserInvitation::where('user_id', $objId)->delete();
                    UserIdentity::where('user_id', $objId)->delete();
                    ChannelActivation::where('user_id', $objId)->delete();
                    $obj->delete();
                    $this->message = 'User data deleted successfully';
                    $this->success = true;
                } else {
                    $this->message = 'User Not found';
                }
                $this->data = $obj;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json(['success' => $this->success, 'message' => $this->message, 'data' => $this->data]);
    }

    public function test()
    {
        echo getenv('STRIPE_KEY'); exit;
//        $fpRecord = FinalPayment::select('unique_id')->where('is_payment',0)->whereNull('counter')->whereDate('updated_at', now())->orderBy('id')->get()->toArray();
//        $fpRecord = array_column($fpRecord, 'unique_id');
//        echo $request->input('unique_id');
//        $index = array_search($request->input('unique_id'), $fpRecord);
//        $counter = 000000000;
//        $c = sprintf('%09d', $counter + $index + 1);

        $params = [
            'view' => 'mail',
            'to_email' => 'busharthussain@gmail.com',
             'subject' => 'test',
            'title' => 'test',
            'message' => 'testing live',
            'device_token' => 'dQykCpc0RTC8cuC0khQnFo:APA91bHrdSeRoDZ5XWossIeBmkTprzinWh6mdG5DCdHt46Cfm1Qf-BMWssXtVZpK3fggRHjF-Ir8L1qV4PAAFFFup8_eu0S_s_m0N7VHkYPsPxmOIn5XpP06qIALJrwBqpYA_-r8aCMY'
        ];
        sendMail($params);
        $params = [
          'title' => 'test',
          'message' => 'testing live',
           'device_token' => 'dQykCpc0RTC8cuC0khQnFo:APA91bHrdSeRoDZ5XWossIeBmkTprzinWh6mdG5DCdHt46Cfm1Qf-BMWssXtVZpK3fggRHjF-Ir8L1qV4PAAFFFup8_eu0S_s_m0N7VHkYPsPxmOIn5XpP06qIALJrwBqpYA_-r8aCMY'
        ];
        $this->sendPushNotifications($params);
    }

    /**
     * This is used to get notifications
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotification(Request $request)
    {
        $this->setUserId($request);
        $assetUrl = asset(MobileUserImagePath);
        $perPage = 20;
        if(!empty($request->input('per_page'))){
            $perPage = $request->input('per_page');
        }
        $record = Notification::select('notification', 'notifications.id','is_read','notifications.created_at',
            'u.id as user_id', 'u.first_name', 'u.last_name', 'u.user_name',
            DB::raw("CONCAT('$assetUrl','/',u.profile_pic_upload) as profile_pic_upload")
        )
            ->where('notifications.user_id', $this->userId)
            ->leftjoin('users as u', 'u.id', '=', 'notifications.notification_user_id')
            ->orderBy('notifications.created_at', 'desc')
            ->paginate($perPage)->setPageName('page');
        $result = [];
        $curentDate = new DateTime();
        if (!empty($record)) {
            $record = $record->toArray();
            foreach ($record['data'] as $key => $row) {
                $result[$key]['notification'] = $row['notification'];
                $result[$key]['notification_id'] = $row['id'];
                $result[$key]['user_id'] = $row['user_id'];
                $result[$key]['first_name'] = $row['first_name'];
                $result[$key]['last_name'] = $row['last_name'];
                $result[$key]['user_name'] =$row['user_name'];
                $result[$key]['profile_pic_upload'] = $row['profile_pic_upload'];
                $result[$key]['is_read'] = $row['is_read'];
                $createDate = new DateTime($row['created_at']);
                $interval = date_diff($createDate, $curentDate);
                $hours = $interval->format('%h');
                $minutes = $interval->format('%i');
                $days = $interval->format('%a');
                if ($days < 1) {
                    if ($hours < 1) {
                        $result[$key]['time'] = $minutes . ' minutes ago';
                    } else {
                        $result[$key]['time'] = $hours . ' hours ago';
                    }
                } elseif ($days < 30 && $days > 0) {
                    $result[$key]['time'] = $days . ' days ago';
                } else {
                    $result[$key]['time'] = date_format(new \DateTime($row['created_at']), ' F,d,Y h:i');
                }
            }
        }
        $this->data['notifications'] = $result;

        return response()->json(['success' => true, 'message' => $this->message, 'data' => $this->data]);
    }

    /**
     * This is used to update new mobile number
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateNewMobileNumber(Request $request){
        $this->setUserId($request);
        $userId = $this->userId;

        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'mobile_number' => 'required',
            'extension' => 'required',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $objUser = User::find($userId);
            if ($objUser) {
                $oldMobile = $objUser->mobile_number;
               $objUser->temp_mobile_number= $oldMobile;
               $objUser->mobile_number= $data['mobile_number'];
               $objUser->extension= $data['extension'];
               $objUser->save();
               $this->success = true;
               $this->message = 'Mobile Number is update successfully';
            } else {
                $this->message = 'User does not exist';
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message]);
    }

    /**
     * This is used to make notifications read notifications
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function readNotification(Request $request)
    {
        $this->setUserId($request);
        $notificationId = $request->input('notification_id');
        $data = $request->all();
        $validations = [
            'notification_id' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            Notification::where(['id' => $notificationId, 'user_id' => $this->userId])->update(['is_read' => 1]);
            $this->success = true;
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * This is used to checked notifications
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkedNotification(Request $request)
    {
        $this->setUserId($request);
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            Notification::where('user_id', $this->userId)->update(['is_checked' => 1]);
            $this->success = true;
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /** this used to coach status
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function coachPopUpStatus(Request $request)
    {
        $this->setUserId($request);
        $data = $request->all();
        $validations = [
//            'user_id' => 'required|integer',
            'coach_popup_status' => 'required',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            User::where('id', $this->userId)->update(['coach_popup_status' => 1]);
            $this->success = true;
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * This is used to count notification
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function countNotification(Request $request)
    {
        $this->setUserId($request);
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $notificationCounts = Notification::where('user_id', $this->userId)
                ->where('is_checked', 0)
                ->count();
            $this->success = true;
            $this->data['Notification'] = $notificationCounts;
        }

        return response()->json(['success' => $this->success, 'message' => $this->message,'data' => $this->data,]);
    }

    /**
     * This is used to get terms and policy url
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTermPolicy(Request $request)
    {
        $this->data['terms'] = getenv('APP_URL').'/terms-of-service';
        $this->data['policy'] = getenv('APP_URL'). '/privacy-policy';

        return response()->json(['success' => true, 'data' => $this->data, 'message' => '']);
    }

    /**
     * This is use to logout user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            //$request->user()->token()->delete();
            $this->message = 'User is logout successfully';
            $this->success = true;
        } catch (\Illuminate\Database\QueryException $e) {
            $this->message = $e->getMessage();
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message]);
    }

    /**
     * This is used to get version
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAppVersion()
    {
        $arr = [];
        $this->data['version'] = '1.0.20';
        $this->data['isdialogshow'] = true;
        $this->data['showupdatedialog'] = true;
//        $this->data['btntext'] = 'Uninstall';

//        $this->data['title'] = 'Zestlog needs an update';
//        $this->data['detail1'] = 'To continue using Zestlog';
//        $this->data['detail2'] = 'please uninstall & reinstall the app.';
        $this->data['btntext'] = 'Update';
        $this->data['title'] = 'Zestlog needs an update';
        $this->data['detail1'] = 'To continue using Zestlog';
        $this->data['detail2'] = 'please update the app.';

//        $this->data['btntext_update'] = 'Update';
//        $this->data['title_update'] = 'Zestlog needs an update';
//        $this->data['detail_update1'] = 'To continue using Zestlog';
//        $this->data['detail_update2'] = 'please update the app.';

        $arr[]['version'] = '1.0.23';
        $this->data['versionList'] = $arr;

        return response()->json(['success' => true, 'data' => $this->data, 'message' => $this->message]);
    }
}
