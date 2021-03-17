<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\UserIdentity;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EndUserAccountSetting extends Controller
{
    //
    public  function index($userId){
        if($userId){
            $user = User::find($userId);
            $age = $user->getAgeAttribute();
            $userProfile = User::select('display_name','first_name','last_name','user_name','country','city','birthday','gender','mobile_number','email','is_verify','profile_pic_upload')
            ->where('id',$userId)
                ->first();

            $identityDetail = UserIdentity::select('id_photo', 'first_name', 'middle_name', 'last_name', 'birthday', 'is_identity_verified')
                ->where('user_id', $userId)
                ->first();

            if($identityDetail){
                $identityDetail = $identityDetail->toArray();
            }
            $userStatus = ['' => 'Select', '1' => 'Active', '2' => 'Deactive'];
            if($userProfile){
                $userProfile = $userProfile->toArray();
                if (isset($userProfile['birthday']))
                    $userProfile['birthday'] = date("Y-m-d", strtotime($userProfile['birthday']));
                if (!empty($age) && $age < 500) {
                    $userProfile['age'] = $age;
                } else{
                    $userProfile['age'] = 0;
                }
            }

        }
        return view('admin.endusers.enduser-profile',compact('userProfile','identityDetail','user','userStatus'));
    }

    public  function endUserSaveIdentityData(Request $request){
        $superAdminId = loginId();
        $identity_data = $request->input('identity_data');

        $userId = $request->input('user_id');
        $user = User::find($userId);
        if (!empty($user)) {
            try {
                DB::beginTransaction();
                $obj = UserIdentity::where('user_id', $userId)->first();
                if (empty($obj)) {
                    $obj = new UserIdentity();
                    $obj->user_id = $userId;
                }
                $obj->is_identity_verified = $identity_data['is_identity_verify'];
                $obj->identity_verified_by = $superAdminId;
                $obj->first_name = $identity_data['first_name'];
                $obj->middle_name = $identity_data['middle_name'];
                $obj->last_name = $identity_data['last_name'];
                $obj->birthday = date("Y-m-d", strtotime($identity_data['birthday']));
                $obj->save();

                $this->success = true;
                $this->message = 'User identity saved successfully';
                User::where('id',$userId)->update([
                    'is_identity_verified'=>$identity_data['is_identity_verify'],
                    'first_name'=>$identity_data['first_name'],
                    'last_name'=>$identity_data['last_name'],
                    'middle_name'=>$identity_data['middle_name'],
                    'birthday'=>databaseDateFromat($identity_data['birthday']),
                ]);
                $UserData = User::where('id', $userId)->first();
                if (!empty($UserData)) {
                    $age = $UserData->getAgeAttribute();
                    $UserData = $UserData->toArray();
                    $UserData['full_name_display'] = $UserData['first_name'].' '.$UserData['last_name'];
                    if (!empty($age) && $age < 500) {
                        $UserData['user-age'] = $age;
                    } else {
                        $UserData['user-age'] = 0;
                    }
                    $this->data = $UserData;
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        } else {
            $this->message = 'User record not found';
        }
        return response()->json(['success' => $this->success, 'message' => $this->message,'data'=>$this->data]);
    }
}
