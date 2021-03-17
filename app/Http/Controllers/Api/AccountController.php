<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\OldPasswords;
use App\Models\UserIdentity;
use App\Models\UserInvitation;
use function GuzzleHttp\Psr7\str;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

use Monolog\Handler\SyslogUdp\UdpSocket;
use Validator;
use App\User;
use App\Traits\ZestLogTrait;
use App\Models\UserFollower;
use App\Models\Specialization;
use App\Models\ChannelActivation;
use App\Models\AssessmentsQuestion;
use App\Models\AssessmentsAnswer;


class AccountController extends Controller
{
    use ZestLogTrait;

    
     /**
     * get log api
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    public function getSpecializations(){
        $specializationObj = Specialization::get();
        if (!empty($specializationObj)) {
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->data['specializations'] = $specializationObj;
        }else {
            $this->message = Lang::get('messages.logCategoryInvalid');
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * Method to add channel
     */
    public function addChannelActivation(Request $request){
        $this->setUserId($request);
        $isCoachChannel = $request->input('is_coach_channel');
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'specialization_one' => 'required|integer'

        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            if ($this->checkUser($this->userId)) {
                $this->saveChannelData($request);
                $this->success = true;
                $this->statusCode = $this->successCode;
                $this->message = Lang::get('messages.dataSave');
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    public function saveChannelData($request)
    {
        $userId = $request->input('user_id');
        $specialization_one = $request->input('specialization_one');
        $specialization_two = $request->input('specialization_two');
        $specialization_three = $request->input('specialization_three');
        $introduction = $request->input('introduction');
        if (!empty($specialization_one)) {
            $specialization_number = 1;
            $specialization_id = $request->input('specialization_one');
            $education_title = $request->input('education_one_title');
            $education_form = $request->input('education_one_from');
            $education_certificate = $request->input('education_one_certificate');
            $this->saveSpecializations($specialization_number, $userId, $request,
                $specialization_id, $education_title, $education_form, $education_certificate, $introduction);
        }
        if (!empty($specialization_two)) {
            $specialization_number = 2;
            $specialization_id = $request->input('specialization_two');
            $education_title = $request->input('education_two_title');
            $education_form = $request->input('education_two_from');
            $education_certificate = $request->input('education_two_certificate');
            $this->saveSpecializations($specialization_number, $userId, $request,
                $specialization_id, $education_title, $education_form, $education_certificate, $introduction);
        }
        if (!empty($specialization_three)) {
            $specialization_number = 3;
            $specialization_id = $request->input('specialization_three');
            $education_title = $request->input('education_three_title');
            $education_form = $request->input('education_three_from');
            $education_certificate = $request->input('education_three_certificate');
            $this->saveSpecializations($specialization_number, $userId, $request,
                $specialization_id, $education_title, $education_form, $education_certificate, $introduction);
        }
    }

    public function saveSpecializations($specialization_number, $userId, $request, $specialization_id,
                                        $education_title, $education_form, $education_certificate, $introduction)
    {
        try {
            DB::beginTransaction();
            $isCoachChannel = $request->input('is_coach_channel');
            $modelObj = ChannelActivation::where('user_id', $userId)
                ->where('specialization_number', $specialization_number)
                ->first();
            if (empty($modelObj)) {
                $modelObj = new ChannelActivation();
                $modelObj->user_id = $userId;
            }
            if (!empty($request->input('health_fitness')))
                $modelObj->health_fitness = $request->input('health_fitness');
            if (!empty($specialization_number))
                $modelObj->specialization_number = $specialization_number;
            if (!empty($specialization_id))
                $modelObj->specialization_id = $specialization_id;
            if ($specialization_id != 4) {
                if (!empty($education_title))
                    $modelObj->education_title = $education_title;
                if (!empty($education_form))
                    $modelObj->education_from = $education_form;
                if (!empty($education_certificate))
                    $modelObj->education_certificate = $this->storeCertificate($education_certificate, $userId);
            }
            if (!empty($request->input('is_coach_channel')))
                $modelObj->is_coach_channel = $request->input('is_coach_channel');
            if (!empty($introduction)) {
                User::where('id', $userId)->update(['introduction' => $introduction]);
            }
            if (isset($isCoachChannel)) {
                ChannelActivation::where('user_id', $userId)->update(['is_coach_channel' => $isCoachChannel]);
            }

            $modelObj->save();
            if($specialization_number == 1){
               $user = User::where('id',$userId)
               ->where('eduction_certificate_upload_date','=',null)
                   ->first();
               if(!empty($user)){
                   $user->eduction_certificate_upload_date = currentDateTime();
                   $user->save();
               }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->message = 'Something went wrong';
            $this->success = false;
        }
    }
    public function storeCertificate($columnVal, $userId){
//        $fileName = createImageUniqueName('jpg');
        if (!empty($columnVal)){
            $destinationPath = public_path(MobileAccountChannelActivation);
            return $this->uploadFile($columnVal, $destinationPath);
        }
        return null;
    }
     /**
     * check user
     * @return \Illuminate\Http\Response
     */
    public function checkUser($userId){
        $obj = User::where('status','1')->find($userId);
        if (empty($obj)) {
            $this->message = Lang::get('messages.userInvalid');
            return false;
        }
        return true;
    }

    /**
     * Method to upload certificate
     */
    public function uploadFile($columnVal, $destinationPath){
        $image = preg_replace('/^data:image\/\w+;base64,/i', '', $columnVal);
        $encoded_string = str_replace(' ', '+', $image);
        $decoded_file = base64_decode($encoded_string); // decode the file
        $mime_type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_MIME_TYPE); // extract mime type
        $extension = $this->mime2ext($mime_type); // extract extension from mime type
        $fileName = createImageUniqueName($extension);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $tempFile = $destinationPath . '/' . $fileName;
        file_put_contents($tempFile, base64_decode($image));
        return $fileName;
    }
    
    /**
     * Method to update user privacy type
     */
    public function savePrivacyType(Request $request){
        $this->setUserId($request);
        $privacy_type = $request->input('privacy_type');
        $modelObj = User::where('id', $this->userId)->update(['privacy_type' => $privacy_type]);
        if ($modelObj) {
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->message = Lang::get('messages.dataupdate');
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * Method to update chat status
     */
    public function updateChatStatus(Request $request)
    {
        $this->setUserId($request);
        $chat_status = $request->input('chat_status');
        $modelObj = User::where('id', $this->userId)->update(['chat_status' => $chat_status]);
        if ($modelObj) {
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->message = Lang::get('messages.dataupdate');
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * Method to update user profile description
     */
    public function profileDescription(Request $request)
    {
        $this->setUserId($request);
        $profile_description = $request->input('profile_description');
        $modelObj = User::where('id', $this->userId)->update(['profile_description' => $profile_description]);
        if ($modelObj) {
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->message = Lang::get('messages.dataupdate');
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

   /**
    * Method to deactivate user
    */
    public function userDeactive(Request $request)
    {
        $this->setUserId($request);
        $modelObj = User::where('id', $this->userId)->update(['status' => 2]);
        if ($modelObj) {
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->message = Lang::get('messages.dataupdate');
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
    /*
     * Method to delete user
     */
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUserAccount(Request $request)
    {
        $this->setUserId($request);
        $userId = $this->userId;
        if (!empty($userId)) {
            $obj = User::where('id', $userId)->where('user_type','!=',1)->delete();
            if ($obj) {
                $this->success = true;
                $this->message = 'User deleted successfully';
            } else {
                $this->message = 'User not found';
            }

        } else {
            $this->message = 'User not found';
        }

        return response()->json(['success' => $this->success, 'message' => $this->message], $this->statusCode);
    }
    
   /**
    * Method to activate user
    */
    public function userActive(Request $request)
    {
        $this->setUserId($request);
        $modelObj = User::where('id', $this->userId)->update(['status' => 1]);
        if ($modelObj) {
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->message = Lang::get('messages.dataupdate');
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
    
    /**
     * Method to get user info
     */
    public function getUserInfo($userId){
        $user = User::where('id', $userId)->first();
        if(!empty($user->profile_pic_upload)){
            $user->user_profile_pic =  asset(MobileUserImagePath.'/'.$user->profile_pic_upload);
        }else{
            $user->user_profile_pic = null;
        }
        unset($user->password);
        $userData['user_id'] = $user->id;
        $userData['first_name'] = $user->first_name;
        $userData['last_name'] = $user->last_name;
        $userData['email'] = $user->email;
        $userData['user_profile_pic'] = $user->user_profile_pic;
        $userData['profile_description'] = $user->profile_description;
        $userData['user_name'] = $user->user_name;
        $userData['city'] = $user->city;
        $userData['country'] = $user->country;
        $userData['privacy_type'] = $user->privacy_type;
        $userData['chat_status'] = $user->chat_status;
        $userData['is_identity_verified'] = $user->is_identity_verified;
        $userData['is_education_verified'] = $user->is_education_verified;
        $userData['is_username_public'] = $user->is_username_public;
        $userData['is_coach_channel'] = $user->is_coach_channel;
        $this->data = $userData;
        $this->success = true;
        $this->statusCode = $this->successCode;
//        $this->message = Lang::get('messages.dataupdate');
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * Assessment Question
     */
    public function assessmentsQuestions($userId)
    {
        $data = '';
        $assessmentsQuestionData = AssessmentsQuestion::where(['status'=>1])
                                    ->where('parent_id',null)
                                    ->get()
                                    ->toArray();
        $parentKey = "";
        foreach($assessmentsQuestionData as $key=>$value){                        
            $questions[$value['title']] = AssessmentsQuestion::where(['status'=>1])
                                    ->where('parent_id',$value['id'])
                                    ->get()
                                    ->toArray();
            $i = 0;
            foreach($questions[$value['title']] as $k=>$val){
                $data[$value['title']][$i] = $val;
                $data[$value['title']][$i]['answer'] = AssessmentsQuestion::getAssessmentsAnswer($userId,$val['id']);
                if(empty($data[$value['title']][$i]['answer'])){
                    $data[$value['title']][$i]['answer'] = (object)[];
                }
                $i++;
            }
            
        }                           
        
        $this->data = $data;
        $this->success = true;
        $this->statusCode = $this->successCode;
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * Method to save assessment answers
     */
    public function assessmentsAnswers(Request $request){
        $postData = $request->toArray();
        foreach($postData as $key=>$value){
            $this->saveAssessmentAswer($value);
        }
        $this->success = true;
        $this->statusCode = $this->successCode;
        $this->message = Lang::get('messages.answersave');
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
    
    /**
     * Method to get channel activation
     */
    public function getChannelActivation(Request $request){
        $this->userId = $request->input('user_id');
        $userId = $this->userId;
        $arr = [];
        $channelObj = ChannelActivation::select('s.name as specialization_name','channel_activations.specialization_id',
            'channel_activations.education_title','channel_activations.education_from','channel_activations.education_certificate',
            'channel_activations.is_verify',
            'channel_activations.user_id','u.introduction','channel_activations.specialization_number')
            ->join('specializations as s','s.id','=','channel_activations.specialization_id')
            ->join('users as u','u.id','=','channel_activations.user_id')
            ->where('user_id',$userId)
            ->get()->toArray();
        if($channelObj){
            array_multisort(array_column($channelObj, "specialization_number"), SORT_ASC, $channelObj);
            $channelObj = array_column($channelObj, null, 'specialization_number');
            foreach ($channelObj as $key =>$row){
//                if($row['specialization_id'] != 4){
                    $arr['user_id'] = $row['user_id'];
                    $arr['introduction'] = $row['introduction'];
                    $tempArray = [];
                    if ($key == 1) { // for specialization one
                        $specKey = 'specialization_one';
                    } else if ($key == 2) { // for specialization two
                        $specKey = 'specialization_two';
                    } else if ($key == 3) { // for specialization three
                        $specKey = 'specialization_three';
                    }
                    $tempArray['specialization_type'] = $specKey;
                    $tempArray['specialization_tab'] = $key;
                    $tempArray['specialization_id'] = $row['specialization_id'];
                    $tempArray['specialization_name'] = $row['specialization_name'];
                    $tempArray['education_title'] = $row['education_title'];
                    $tempArray['education_from'] = $row['education_from'];
                    $educationCertificate = null;
                    if (isset($row['education_certificate']) && !empty($row['education_certificate'])) {
                        $educationCertificate = asset(MobileAccountChannelActivation . '/' . $row['education_certificate']);
                    }
                    $tempArray['education_certificate'] = $educationCertificate;
                    $tempArray['is_verify'] = $row['is_verify'];
                    $arr['specialization'][] = $tempArray;
//                }
            }
        }else{
            $this->message = 'User record not found';
        }
        $this->success = true;
        if(empty($arr)){
            $arr = (array)[];
        }
        $this->data = (object)$arr;
        $this->statusCode = $this->successCode;
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * Method to get channel details
     */
    public function getUserChannelDetails(Request $request)
    {
//        $this->setUserId($request);
        $this->userId = $request->input('user_id');
        $this->params['user_id'] = $this->userId;
        $countChannel = User::getUserChannelDetails($this->params);
        $arr = [];
        $obj = User::find($this->userId);
        if ($obj) {
            $arr['user_id'] = $obj->id;
            $arr['first_name'] = $obj->first_name;
            $arr['last_name'] = $obj->last_name;
            $arr['city'] = $obj->city;
            $arr['country'] = $obj->country;
            if (!empty($obj->profile_pic_upload))
                $arr['profile_image'] = asset(MobileUserImagePath . '/' . $obj->profile_pic_upload);
            else
                $arr['profile_image'] = null;
            $objChannel = ChannelActivation::where('user_id', $this->userId)->first();
            if ($objChannel) {
                $arr['is_coach_channel'] = $objChannel->is_coach_channel;
                $objIdentity = UserIdentity::where('user_id', $this->userId)->first();
                if ($objIdentity) {
                    $arr['is_identity_verified'] = $objIdentity->is_identity_verified;
                } else {
                    $this->message = 'User Record not found';
                }
                $this->success = true;
                $this->statusCode = $this->successCode;
            } else {
                $this->message = 'User Record not found';
            }
            if (!empty($countChannel)) {
                $arr['is_all_conditions_true'] = 1;
            } else {
                $arr['is_all_conditions_true'] = 0;
            }
        } else {
            $this->message = 'User not found';
        }
        if (empty($arr)) {
            $arr = (object)[];
        }
        $this->data = $arr;

        return response()->json(['success' => $this->success, 'data' => $this->data], $this->statusCode);
    }
    /**
     * Method to save assessment Answer
     */
    public function saveAssessmentAswer($data){
        $modelObj =  AssessmentsAnswer::where('user_id', $data['user_id'])
                        ->where('assess_que_id', $data['assess_que_id'])->first();
        if(empty($modelObj)){
            $modelObj =  new AssessmentsAnswer();
        }
        foreach($data as $k=>$val){
            $modelObj->$k = $val;    
        }
        $modelObj->save();
    }
    
    /**
     * Method to get assessment answer
     */
    public function getAssessmentAnswers($userId){
        $modelObj =  AssessmentsAnswer::where('user_id', $userId)->get()->toArray();
        $this->success = true;
        $this->data = $modelObj;
        $this->statusCode = $this->successCode;
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    
    }

    /**
     * Method to change password
     */
    public function changePassword(Request $request)
    {
        $this->setUserId($request);
        $newPassword = $request->input('new_password');
        $repeatNewPassword = $request->input('repeat_new_password');
        $dataRequest = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'current_password' => 'required',
            'new_password' => 'required',
            'new_password' => 'required',
        ];
        $validator = \Validator::make($dataRequest, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $user = User::find($this->userId);
            if ($user) {
                $vaildpassword = \Hash::check($request->input('current_password'), $user->password);
                if ($vaildpassword) {
                    if ($newPassword == $repeatNewPassword) {
                        $newpassword = \Hash::make($request->input('new_password'));
                        $user->password = $newpassword;
                        $user->save();
                        $this->success = true;
                        $this->statusCode = $this->successCode;
                        $this->message = 'password changed successfully';
                    } else {
                        $this->message = 'new password and repeat new password must be same';
                    }
                } else {
                    $this->message = 'wrong current password';
                }
            } else {
                $this->message = 'User not found';
            }
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * Method to verify username
     */
    public function forgotPassword(Request $request){
        $userName = $request->input('user_name');
        $user = User::where('user_name', $userName)->first();
        if(!empty($user)){
            $number = '+' . $user->extension . $user->mobile_number;
            $otpCode = mt_rand(1000, 9999);
            $otp_message = 'Your OTP for Zestlog Forgot Password is ' . $otpCode;
            $this->sendMessage($otp_message, $number);
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->message = Lang::get('messages.usernamevaild');
        }else{
            $this->message = Lang::get('messages.usernameinvaild');
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);

    }
    public function updatePasswordOnForget(Request $request){
        $mobileNumber = $request->input('mobile_number');
        $extension = $request->input('extension');
        $newPassword = $request->input('new_password');
        $repeatNewPassword = $request->input('repeat_new_password');
        $dataRequest = $request->all();
        $validations = [
            'mobile_number' => 'required',
            'extension' => 'required|integer',
            'new_password' => 'required',
            'repeat_new_password' => 'required',
        ];
        $validator = \Validator::make($dataRequest, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            try {
                DB::beginTransaction();
                    $user = User::where('mobile_number',$mobileNumber)
                    ->where('extension',$extension)
                    ->first();
                    if ($user) {
                        if ($newPassword == $repeatNewPassword) {
                            OldPasswords::insert(['user_id' => $user->id, 'password' => $user->password]);
                            $newpassword = \Hash::make($request->input('new_password'));
                            $user->password = $newpassword;
                            $user->save();
                            $this->success = true;
                            $this->statusCode = $this->successCode;
                            $this->message = 'password changed successfully';
                        } else {
                            $this->message = 'new password and repeat new password must be same';
                        }
                    } else {
                        $this->message = 'User not found';
                    }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);

    }
}
?>
