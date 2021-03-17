<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\BankAcconut;
use App\Models\BankAccountPreviousData;
use App\Models\RattingFreelanceAndZestlog;
use App\Models\UserMainWorkoutPlan;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use PragmaRX\Countries\Package\Countries;

use Monolog\Handler\SyslogUdp\UdpSocket;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Validator;
use App\User;
use App\Traits\ZestLogTrait;
use App\Models\UserFollower;
use App\Models\UserBlock;


class UserController extends Controller
{
    use ZestLogTrait;

    
     /**
     * add follower api
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    
    public function addFollower(Request $request){
        try {
            DB::beginTransaction();
            $follower = $request->input('follower');
            $following = $request->input('following');
            if ($this->checkUser($following)) {
                $userBlock = UserBlock::checkBlockUser($follower, $following);
                if (empty($userBlock)) {
                    $userFollow = UserFollower::where('follower', $follower)
                        ->where('following', $following)
                        ->first();
                    if (empty($userFollow)) {
                        $userFollowObj = new UserFollower();
                        $this->success = true;
                        $this->statusCode = $this->successCode;
                        $userFollowObj->follower = $follower;
                        $userFollowObj->following = $following;
                        $userFollowObj->save();
                        $this->message = Lang::get('messages.addFollower');
                        $objUser = User::find($following);
                        $objfollower = User::find($follower);
                        $firstName = '';
                        $lastName = '';
                        $objFollowerId = '';
                        if (!empty($objfollower)) {
                            $firstName = $objfollower->first_name;
                            $lastName = $objfollower->last_name;
                            $objFollowerId = $objfollower->id;
                        }
                        if ($objUser) {
                            $arrPush = [];
                            $arrPush['title'] = 'Follower';
                            $arrPush['message'] = $firstName . ' ' . $lastName . ' ' . 'has started following you.';
                            $arrPush['notification_message'] = $firstName . ' ' . $lastName . ' has started following you.';
                            $arrPush['device_token'] = $objUser->device_token;
                            $arrPush['user_id'] = $objUser->id;
                            $arrPush['notification_user_id'] = $objFollowerId;
                            $this->sendPushNotifications($arrPush);
                        }
                    } else {
                        $this->message = Lang::get('messages.resultExist');
                    }
                } else {
                    $this->message = Lang::get('messages.blockExist');
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * remove follower api
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    public function removeFollower(Request $request)
    {
        try {
            DB::beginTransaction();
            $follower = $request->input('follower');
            $following = $request->input('following');
            $userFollow = UserFollower::where('follower', $follower)
                ->where('following', $following)
                ->delete();
            if (!empty($userFollow)) {
                $this->success = true;
                $this->statusCode = $this->successCode;
                $this->message = Lang::get('messages.removeFollower');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->success = false;
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);

   }

    /**
     * get followers api
     * @param type $userid
     * @return \Illuminate\Http\Response
     */
    public function getFollowers($userid = "", $type=""){
        $assetUrl = asset(MobileUserImagePath);
        $userFollow = UserFollower::select('u.user_name','user_followers.follower','user_followers.following',
            DB::raw("CONCAT( u.first_name,  ' ', u.last_name ) as user_name"),
            DB::raw("CONCAT('$assetUrl','/',u.profile_pic_upload) as user_profile_pic"),
            'u.id as f_userid'
        )
            ->join('users as u', 'u.id', 'user_followers.follower')
            ->where('following', $userid)
            ->get();
            $this->data['userFollow'] = $userFollow;
            $this->success = true;
            $this->statusCode = $this->successCode;

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
   }

   /**
     * get following api
     * @param type $userid
     * @return \Illuminate\Http\Response
     */
    public function getFollowings($userid = "", $type=""){
        $assetUrl = asset(MobileUserImagePath);
        $userFollow = UserFollower::select('u.user_name', 'user_followers.follower', 'user_followers.following',
            DB::raw("CONCAT( u.first_name,  ' ', u.last_name ) as user_name"),
            DB::raw("CONCAT('$assetUrl','/',u.profile_pic_upload) as user_profile_pic"),
            'u.id as f_userid'
        )
            ->where('follower', $userid)
            ->join('users as u', 'u.id', 'user_followers.following')
            ->get();

            $this->data['userFollow'] = $userFollow;
            $this->success = true;
            $this->statusCode = $this->successCode;

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
   }

   /**
     * add block api
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    public function blockUser(Request $request)
    {
        $this->setUserId($request);
        $userId = $this->userId;
        $blockUserId = $request->input('block_user_id');
        if ($this->checkUser($blockUserId)) {
            $userBlock = UserBlock::where('user_id',$userId)
                ->where('block_user_id',$blockUserId)->first();
            if (empty($userBlock)) {
                try {
                    DB::beginTransaction();
                    UserFollower::where('follower', $blockUserId)
                        ->where('following', $userId)
                        ->delete();
                    UserFollower::where('follower', $userId)
                        ->where('following', $blockUserId)
                        ->delete();
                    $userBlockObj = new UserBlock();
                    $this->success = true;
                    $this->statusCode = $this->successCode;
                    $userBlockObj->user_id = $userId;
                    $userBlockObj->block_user_id = $blockUserId;
                    $userBlockObj->save();
                    $this->message = Lang::get('messages.addblockuser');
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                }
            } else {
                $this->message = 'Already blocked';
            }
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * add unblock api
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    public function UnblockUser(Request $request){
        $this->setUserId($request);
        $blockUserId= $request->input('block_user_id');
        $userBlock = UserBlock::where('user_id', $this->userId)
                    ->where('block_user_id', $blockUserId)
                    ->delete();
        if(!empty($userBlock)){
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->message = Lang::get('messages.unblockuser');
        }else{
            $this->message = Lang::get('messages.resultNotFound');
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);

    }

    /**
     * list block api
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    public function listUserblock($id, $type = "")
    {
        $assetUrl = asset(MobileUserImagePath);
        $userBlock = UserBlock::select('user_id', 'block_user_id',
            DB::raw("CONCAT( u.first_name,  ' ', u.last_name ) as user_name"),
            DB::raw("CONCAT('$assetUrl','/',u.profile_pic_upload) as user_profile_pic")
        )
            ->join('users as u', 'u.id', 'user_blocks.block_user_id')
            ->where('user_id', $id)
            ->get();
        $this->success = true;
        $this->data['userBlock'] = $userBlock;

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);

    }

    /**
    * Method to get count of user follower, following and blocked
    */
    public function getUserCount($id)
    {
        try {
            $this->success = true;
            $this->data['follower'] = UserFollower::where('following', $id)->count();
            $this->data['following'] = UserFollower::where('follower', $id)->count();
            $this->data['blockuser'] = UserBlock::where('user_id', $id)->count();
        }catch (\Exception $e){

        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);

    }

     /**
     * check user
     * @return \Illuminate\Http\Response
     */
    public function checkUser($userId){
        $obj = User::find($userId);
        if (empty($obj)) {
            $this->message = Lang::get('messages.userInvalid');
            return false;
        }
        return true;
    }
    /**
     * Method to check user block or not
     */
    public function userBlock(Request $request){
        $this->setUserId($request);
        $user_id = $this->userId;
        $block_user_id = $request->input('block_user_id');
        $userBlock = UserBlock::checkBlockUser($user_id, $block_user_id);
        $this->success = true;
        $this->statusCode = $this->successCode;
        if (empty($userBlock)) {
            $this->message = Lang::get('messages.notBlock');
        } else {
            $this->message = Lang::get('messages.block');
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * Method to check Following User
     */
    public function checkFollowing(Request $request){
        $userId = $request->user_id;
        $following = $request->following;
        $followingData = UserFollower::checkFollower($userId,$following);
        if(!empty($followingData)){
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->message = '1';
        }else{
            $this->message = '0';
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    public function userList(Request $request){
        try {
            $this->setUserId($request);
            $userName = $request->input('name');
            $data = $request->all();
            $url = asset(MobileUserImagePath);
            $validations = [
                'user_id' => 'required|integer',
            ];
            $validator = \Validator::make($data, $validations);
            if ($validator->fails()) {
                $this->message = formatErrors($validator->errors()->toArray());
            } else {
                $blockUser = [];
                if (!empty($this->userId)) {
                    $blockUser = UserBlock::select('block_user_id')
                        ->where('user_blocks.user_id', $this->userId)
                        ->get()->toArray();
                    $blocked = UserBlock::select('user_id')
                        ->where('block_user_id', $this->userId)
                        ->get()->toArray();
                    $blocked = array_column($blocked, 'user_id');
                    $blockUser = array_merge($blockUser, $blocked);
                }
                $sql = \DB::table('users as u');
                $sql->select('u.id as user_id', 'profile_description', 'u.first_name', 'u.last_name',
                    'u.user_name', 'is_username_public', 'u.is_identity_verified',
                    DB::raw("CONCAT('$url','/',u.profile_pic_upload) as profile_pic_upload"),
                    'device_token'
                );
                if (!empty($userName)) {
                    $sql->where(function ($query) use ($userName) {
                        $query->where('first_name', 'LIKE', '%' . $userName . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $userName . '%');
                        $query->orWhere(\DB::raw("CONCAT( u.first_name,  ' ', u.last_name )"), 'LIKE', '%' . $userName . '%');
                    });
                }
                $sql->where('u.is_verify', 1);
                $sql->whereNotIn('u.id', $blockUser);
                $users = $sql->get();
                foreach ($users as $key => $row) {
                    if (empty($row->is_username_public))
                        $users[$key]->user_name = '';
                }
                $users = $users->toArray();
                $this->data = $users;
                $this->success = true;
            }
        } catch (\Exception $e) {
        }
        return response()->json(['success' => $this->success, 'data' => $this->data,], $this->statusCode);
    }

    public function saveBankAccountInformation(Request $request)
    {
        $this->setUserId($request);
        $bankHolder = $request->input('bank_holder');
        $accountNumber = $request->input('account_number');
        $bicCode = $request->input('bic_code');
        $birthday = $request->input('birthday');
        $email = $request->input('email');
        $addressLineOne = $request->input('address_line_one');
        $addressLineTwo = $request->input('address_line_two');
        $city = $request->input('city');
        $postalCode = $request->input('postal_code');
        $country = $request->input('country');

        $userBirthday = $birthday;
        $swift = $request->input('swift');
        $bankName = $request->input('bank_name');
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            ini_set('max_execution_time', '0');
            $user = User::find($this->userId);
            $dateE = explode('/', $birthday);
            $name = getFirstAndLastName($bankHolder);
            if (!empty($dateE)) {
                $year = $dateE[2];
                $month = $dateE[1];
                $day = $dateE[0];
            }
            $userBirthday = databaseDateFromat($month.'/'.$day.'/'.$year);
            if (!empty($user)) {
                try {
                    DB::beginTransaction();
                    BankAcconut::updateOrCreate([
                        'user_id' => $this->userId,
                    ],
                        ['created_at' => currentDateTime(),
                            'updated_at' => currentDateTime(),
                            'bank_holder' => $bankHolder,
                            'account_number' => $accountNumber,
                            'bic_code' => $bicCode,
                            'email' => $email,
                            'birthday' => $userBirthday,
                            'address_line_one' => $addressLineOne,
                            'address_line_two' => $addressLineTwo,
                            'city' => $city,
                            'postal_code' => $postalCode,
                            'country' => $country,
                        ]);
                    BankAccountPreviousData::updateOrCreate([
                        'user_id' => $this->userId,
                        'bank_holder' => $bankHolder,
                        'account_number' => $accountNumber,
                        'bic_code' => $bicCode,
                    ],
                        [
                            'created_at' => currentDateTime(),
                            'updated_at' => currentDateTime(),
                            'swift' => $swift,
                            'bank_name' => $bankName,
                        ]);
                    $stripe = \Stripe\Stripe::setApiKey(getenv('STRIPE_KEY'));
                    $country = str_split($country, 2)[0];
                    if (empty($user->s_a_id)) {
                          $userStripe = \Stripe\Account::create(array(
                            "type" => "custom",
                            "country" => $country,
                            "email" => $email,
                            "business_type" => "individual",
                            "individual" => [
                                'first_name' => $name['first_name'],
                                'last_name' => $name['last_name'],
                                'phone' => '+' . $user->extension . $user->mobile_number,
//                                 'phone' => '+441717111222',
                                'email' => $email,
                                'dob' => array(
                                    'day' => $day,
                                    'month' => $month,
                                    'year' => $year
                                ),
                                'address' => array(
                                    'line1' => $addressLineOne,
                                    'line2' => $addressLineTwo,
                                    'city' => $city,
                                    'country' => $country,
                                    'postal_code' => $postalCode
                                ),
                            ],
                            "tos_acceptance" => array(
                                'date' => time(),
                                "ip" => $_SERVER['REMOTE_ADDR']
                            ),
                            'capabilities' => [
                                'card_payments' => [
                                    'requested' => true,
                                ],
                                'transfers' => [
                                    'requested' => true,
                                ],
                            ],
                            'business_profile' => [
                                'mcc' => '8999',
                                'url' => 'https://www.zestlog.com/'
                            ],
                            'bank_account' => [
                                'country' => $country,
                                'currency' => 'gbp',
                                'account_holder_name' => $bankHolder,
                                'account_holder_type' => 'individual',
                                'account_number' => $accountNumber,
                                'routing_number' => $bicCode
                            ],
                        ));
                        $token_id = $userStripe->id;
                        $user->s_a_id = $token_id;
                        $user->save();
                    }else{
                        \Stripe\Account::update(
                            $user->s_a_id,
                            [
                                "individual" => [
                                    'first_name' => $name['first_name'],
                                    'last_name' => $name['last_name'],
                                    'phone' => '+' . $user->extension . $user->mobile_number,
//                            'phone' => '+441717111222',
                                    'email' => $email,
                                    'dob' => array(
                                        'day' => $day,
                                        'month' => $month,
                                        'year' => $year
                                    ),
                                    'address' => array(
                                        'line1' => $addressLineOne,
                                        'line2' => $addressLineTwo,
                                        'city' => $city,
                                        'country' => $country,
                                        'postal_code' => $postalCode
                                    ),
                                ],
                                'bank_account' => [
                                    'country' => $country,
                                    'currency' => 'gbp',
                                    'account_holder_name' => $bankHolder,
                                    'account_holder_type' => 'individual',
                                    'account_number' => $accountNumber,
                                    'routing_number' => $bicCode
                                ]
                            ]
                        );
                    }
                    DB::commit();
                    $this->success = true;
                    $this->message = 'Bank information was saved successfully';
                } catch (\Stripe\Exception\CardException $e) {
                    $this->message = $e->getError()->message;
                    DB::rollback();
                } catch (\Stripe\Exception\RateLimitException $e) {
                    DB::rollback();
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    $this->message = $e->getError()->message;
                    DB::rollback();
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    $this->message = $e->getError()->message;
                    DB::rollback();
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    $this->message = $e->getError()->message;
                    DB::rollback();
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $this->message = $e->getError()->message;
                    DB::rollback();

                } catch (Exception $e) {
                    $this->message = $e->getError()->message;
                    DB::rollback();
                }
            } else {
                $this->message = "User not found";
            }
        }

        if ($this->message == "We couldn't find that sort code") {
            $this->message = "Invalid sort code";
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    public function getUserBankAccountDetail(Request $request)
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
            $user = User::find($this->userId);
            if (!empty($user)) {
                try {

                    $arr = [];
                    DB::beginTransaction();
                    $obj = BankAcconut::select('user_id', 'bank_holder', 'account_number', 'bic_code','bank_acconuts.birthday',
                        'bank_acconuts.address_line_one', 'bank_acconuts.address_line_two',
                        'bank_acconuts.city', 'bank_acconuts.postal_code', 'bank_acconuts.country')
                        ->where('user_id', $this->userId)
                        ->first();
                    $c = new Countries();
                    $countries = $c->all();
                    $counter = 0;
                    $arr = [];
                    $countryName = null;
                    if(!empty($obj)){
                        $countryName = $countries[$obj->country]->name->common;
                    }
                    $arr['user_id'] = (!empty($obj->user_id) ? $obj->user_id : null);
                    $arr['bank_holder'] = (!empty($obj->bank_holder) ? $obj->bank_holder : null);
                    $arr['account_number'] = (!empty($obj->account_number) ? $obj->account_number : null);
                    $arr['bic_code'] = (!empty($obj->bic_code) ? $obj->bic_code : null);

                    $arr['email'] = (!empty($user->email) ? $user->email : null);
                    $arr['birthday'] = (!empty($obj->birthday) ? $obj->birthday : null);
                    if (!empty($arr['birthday'])) {
                        $arr['birthday'] = date_format(new \DateTime($arr['birthday']), 'd/m/Y');
                    }
                    $arr['address_line_one'] = (!empty($obj->address_line_one) ? $obj->address_line_one : null);
                    $arr['address_line_two'] = (!empty($obj->address_line_two) ? $obj->address_line_two : null);
                    $arr['city'] = (!empty($obj->city) ? $obj->city : null);
                    $arr['country'] = (!empty($obj->country) ? $obj->country : null);
                    $arr['country_name'] = $countryName;
                    $arr['country_code'] = (!empty($obj->country) ? $obj->country : null);
                    $arr['postal_code'] = (!empty($obj->postal_code) ? $obj->postal_code : null);
                    $this->success = true;
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                }
                $this->data = $arr;
            } else {
                $this->message = "User not found";
                $this->data = (object)[];
            }

        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    public function saveWeightUnit(Request $request)
    {
        $this->setUserId($request);
        $weightUnit = $request->input('weight_unit');
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            try {
                DB::beginTransaction();
                $obj = User::where('id', $this->userId)
                    ->first();
                $weight = $obj->weight;
                $weightPrevious = $obj->weight;
                $weightPreviousUnit = $obj->weight_units;
                $weight = getKgToPound($weightPrevious, $weightPreviousUnit, $weightUnit, $weight);
                $obj->weight_units = strtolower($weightUnit);
                $obj->weight = $weight;
                $obj->save();
                if (strtolower($weightUnit) == 'kg') {
                    if ($weightPreviousUnit == 'lb') {
                        UserMainWorkoutPlan::select('rm_value', 'rm_unit')
                            ->where('user_id', $this->userId)
                            ->update(['rm_value' => DB::raw('rm_value / 2.20462'),
                                'rm_unit' => $weightUnit
                            ]);
                    }
                } else if (strtolower($weightUnit) == 'lb') {
                    if ($weightPreviousUnit == 'kg') {
                        UserMainWorkoutPlan::select('rm_value', 'rm_unit')
                            ->where('user_id', $this->userId)
                            ->update(['rm_value' => DB::raw('rm_value * 2.20462'),
                                'rm_unit' => $weightUnit
                            ]);
                    }
                }

                if (strtolower($weightUnit) == 'kg') {
                    if ($weightPreviousUnit == 'lb') {
                        \App\Models\Client\UserMainWorkoutPlan::select('rm_value', 'rm_unit')
                            ->where('user_id', $this->userId)
                            ->update(['rm_value' => DB::raw('rm_value / 2.20462'),
                                'rm_unit' => $weightUnit
                            ]);
                    }

                } else if (strtolower($weightUnit) == 'lb') {
                    if ($weightPreviousUnit == 'kg') {
                        \App\Models\Client\UserMainWorkoutPlan::select('rm_value', 'rm_unit')
                            ->where('user_id', $this->userId)
                            ->update(['rm_value' => DB::raw('rm_value * 2.20462'),
                                'rm_unit' => $weightUnit
                            ]);
                    }
                }
                DB::commit();
                $this->success = true;
            } catch (\Exception $e) {
                DB::rollback();
            }

        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
}
?>                                                                                                                                      
