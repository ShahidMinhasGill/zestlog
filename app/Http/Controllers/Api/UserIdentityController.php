<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChannelActivation;
use App\Models\UserIdentity;
use App\Models\UserInvitation;
use App\Models\UserNotifications;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use App\Traits\ZestLogTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class UserIdentityController extends Controller
{
    use ZestLogTrait;

    /**
     * this is used o get suer identity
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserIdentity(Request $request)
    {
        $this->setUserId($request);
        try {
            DB::beginTransaction();
            $dataRequest = $request->all();
            $validations = [
                'user_id' => 'required|integer',
            ];
            $validator = \Validator::make($dataRequest, $validations);
            if ($validator->fails()) {
                $this->message = formatErrors($validator->errors()->toArray());
            } else {
                $user = User::find($this->userId);
                if ($user) {
                    $age = getAgeFromBirthday($user->birthday);
                    $obj = UserIdentity::where('user_id', $this->userId)
                        ->first();
                    if (!$obj) {
                        $obj = new UserIdentity();
                        $obj['user_id'] = $this->userId;
                        $obj['is_identity_verified'] = 2;
                        $obj['first_name'] = '';
                        $obj['middle_name'] = '';
                        $obj['last_name'] = '';
                        $obj['birthday'] = '';
                        $obj['id_photo'] = '';
                        $obj['ids_type'] = '';
                        $obj->save();
                    }
                    $objChannel = ChannelActivation::where('user_id', $this->userId)
                        ->first();
                    if (!$objChannel) {
                        $objChannel = new ChannelActivation();
                        $objChannel['user_id'] = $this->userId;
                        $objChannel->save();
                    }
                    $obj = $obj->toArray();
                    $obj['birthday'] = scheduleDateTimeFormat($obj->birthday);
                    $obj['age'] = $age;
                    if (!empty($obj['id_photo'])) {
                        $obj['id_photo'] = asset(MobileUserIdentityImagePath . '/' . $obj['id_photo']);
                    }
                    $this->success = true;
                    if ($obj['is_identity_verified'] == 1) {
                        $this->message = 'verified';
                    } else if ($obj['is_identity_verified'] == 0) {
                        $this->message = 'Pending';
                    } else if ($obj['is_identity_verified'] == 2) {
                        $this->message = 'not verified';
                    }
                    unset($obj['created_at']);
                    unset($obj['updated_at']);
                    unset($obj['identity_verified_by']);
                    unset($obj['id']);
                    $this->data = $obj;
                } else {
                    $this->message = 'User record not found';
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message]);
    }
    public function uploadIdentityImage(Request $request)
    {
        $this->setUserId($request);
        $image = $request->input('image');
        $dataRequest = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'image' => 'required',
        ];
        $validator = \Validator::make($dataRequest, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $user = User::find($this->userId);
            if ($user) {
                try {
                    DB::beginTransaction();
                    $obj = UserIdentity::where('user_id', $this->userId)->first();
                    if (!$obj) {
                        $obj = new UserIdentity();
                        $obj->user_id = $this->userId;
                        $obj->is_identity_verified = 2;
                    }
                    if (!empty($image)) {
                        $image = preg_replace('/^data:image\/\w+;base64,/i', '', $request->input('image'));
                        $image = str_replace(' ', '+', $image);
                        $fileName = createImageUniqueName('jpg');
                        $destinationPath = public_path(MobileUserIdentityImagePath);
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true);
                        }
                        $tempFile = $destinationPath . '/' . $fileName;
                        file_put_contents($tempFile, base64_decode($image));
                        $obj->id_photo = $fileName;
                        $obj->is_identity_verified = 0;

                        if ($obj->save()) {
                            $this->data['id_Image'] = asset(MobileUserIdentityImagePath . '/' . $obj->id_photo);
                            $this->success = true;
                            $this->message = 'Image uploaded successfully';
                        } else {
                            $this->message = 'There is some problem to upload image';
                        }

                        $user->is_identity_verified = 0;
                        $user->save();
                    } else {
                        $this->message = 'Please provide image';
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                }
            }else{
                $this->message = 'User not exist';
            }
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message]);
    }

    /**
     * this is used to get user notifications
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserNotifications(Request $request)
    {
        $this->setUserId($request);
        $dataRequest = $request->all();
        $validations = [
            'user_id' => 'required|integer',
        ];
        $validator = \Validator::make($dataRequest, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $user = User::find($this->userId);
            if ($user) {
                $obj = UserNotifications::where('user_id', $this->userId)
                    ->first();
                if ($obj) {
                    $obj = $obj->toArray();
                    $this->success = true;
                    unset($obj['id']);
                    unset($obj['created_at']);
                    unset($obj['updated_at']);
                    $this->data = $obj;
                } else {
                    $this->message = 'User record not found';
                    $this->data = (object)[];
                }
            } else {
                $this->message = 'User not found';
                $this->data = (object)[];
            }

            return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message]);
        }
    }

    public  function saveUserNotifications(Request $request){
        $this->setUserId($request);
        $dataRequest = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'is_coach_appointment_reminder' => 'required|integer',
            'is_exercise_reminder' => 'required|integer',
            'is_chat_and_call' => 'required|integer',
            'is_you_received_a_follow_request' => 'required|integer',
            'is_your_follow_request_is_accepted' => 'required|integer',
            'is_someone_you_may_know' => 'required|integer',
        ];
        $validator = \Validator::make($dataRequest, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            if (isset($dataRequest['user_id']))
                unset($dataRequest['user_id']);
            $user = User::find($this->userId);
            if ($user) {
                UserNotifications::updateOrCreate(['user_id' => $this->userId], $dataRequest);
                $this->success = true;
                $this->message = 'notification updated successfully';
            } else {
                $this->message = 'User not found';
            }

            return response()->json(['success' => $this->success, 'message' => $this->message]);
        }
    }
    public  function lastUserLogin(Request $request){
        $this->setUserId($request);
        $user = User::find($this->userId);

//        $date = new DateTime();
//
//        $dateformat = $date->format("d-m-y");
        if($user){
            $obj = User::select('last_login')
                ->where('user_id',$this->userId)
            ->first();
        }
    }

    public function checkInvitationCodeValidity(Request $request){
        $invitationCode = $request->input('invitation_code');
        $dataRequest = $request->all();
        $validations = [
//            'invitation_code' => 'required',
        ];
        $validator = \Validator::make($dataRequest, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = UserInvitation::select('user_id','u.profile_pic_upload','u.first_name','u.last_name','u.user_name')
                ->join('users as u','u.id','user_invitations.user_id')
                ->where('invitation_code', $invitationCode)
                ->first();
            $arr = [];
            if (!empty($obj)) {
                $arr['user_id'] = $obj->user_id;
                if (isset($obj->profile_pic_upload))
                    $arr['profile_pic_upload'] = asset(MobileUserImagePath . '/' . $obj->profile_pic_upload);
                else
                    $arr['profile_pic_upload'] = null;
                $arr['first_name'] = $obj->first_name;
                $arr['last_name'] = $obj->last_name;
                $arr['user_name'] = $obj->user_name;
                $this->success = true;
                $this->message = 'Valid invitation code';
            } else {
                $this->message = "Invalid invitation code";
                $arr = (object)[];
            }
            $this->data['user_detail'] = $arr;

            return response()->json(['success' => $this->success, 'message' => $this->message, 'data' => $this->data]);
        }
    }
    public  function checkUserNamePublic(Request $request){
        $this->setUserId($request);
        $isPublic = $request->input('is_username_public');
        $dataRequest = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'is_username_public' => 'required|integer',
        ];
        $validator = \Validator::make($dataRequest, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $user = User::where('id', $this->userId)->update(['is_username_public' => $isPublic]);
            $this->success = true;
        }
        return response()->json(['success' => $this->success]);

     }

    public function deleteIdentityImage(Request $request)
    {
        $this->setUserId($request);
        $dataRequest = $request->all();
        $validations = [
            'user_id' => 'required|integer',
        ];
        $validator = \Validator::make($dataRequest, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {

            try {
                DB::beginTransaction();
                $objUserIdentity = UserIdentity::select('id_photo')->where('user_id', $this->userId)->first();
                if ($objUserIdentity) {
                    if (!empty($objUserIdentity->id_photo)) {
                        $Path = MobileUserIdentityImagePath . '/' . $objUserIdentity->id_photo;
                        if (file_exists($Path)) {
                            unlink($Path);
                        }
                        UserIdentity::where('user_id', $this->userId)->update(['is_identity_verified' => 2,
                            'id_photo' => ''
                        ]);
                        User::where('id', $this->userId)->update(['is_identity_verified' => 2]);
                        $this->success = true;
                        $this->message = 'Identity image deleted successfully';
                    }
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }


    public function getUserInvetationCode(Request $request)
    {
        $userId = $request->input('user_id');
        $dataRequest = $request->all();

        $validations = [
            'user_id' => 'required|integer',
        ];
        $validator = \Validator::make($dataRequest, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $user = User::find($userId);
            if (!empty($user)) {
                $invitationCode = UserInvitation::select('invitation_code')
                    ->where('user_id', $userId)->first();
                $this->data = $invitationCode;
                $this->success = true;
            } else {
                $this->data = (object)[];
            }
        }
        return response()->json(['success' => $this->success, 'data' => $this->data]);
    }
}
