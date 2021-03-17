<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BankAcconut;
use App\Models\ChannelActivation;
use App\Models\ServiceBooking;
use App\Models\Specialization;
use App\Models\UserIdentity;
use App\Models\UserInvitation;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use App\Traits\ZestLogTrait;
use Illuminate\Support\Facades\DB;
use PragmaRX\Countries\Package\Countries;
use function Symfony\Component\VarDumper\Dumper\esc;

class FreelanceAccountSetting extends Controller
{
    use ZestLogTrait;

    /**
     * this is used to get Freelance specialist profile data
     * @param $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($userId)
    {
        if ($userId) {
            $user = User::find($userId);
            $age = $user->getAgeAttribute();
            $channelActivations = ChannelActivation::select('specialization_id','specialization_number','education_certificate','s.name as specialization_name',
                'education_title', 'education_from', 'education_certificate', 'introduction','is_verify')
                ->join('specializations as s','s.id','=','channel_activations.specialization_id')
                ->where('user_id', $userId)
                ->get()->toArray();

            $specializations = ['' => 'Select'] + Specialization::pluck('name', 'id')->toArray();
            $channelActivations = array_column($channelActivations,null,'specialization_number');
            $identityDetail = UserIdentity::select('user_id','id_photo', 'first_name', 'middle_name', 'last_name', 'birthday', 'is_identity_verified')
                ->where('user_id', $userId)
                ->first();
            if ($user) {
                $user = $user->toArray();
                if (!empty($age) && $age <500) {
                    $user['age'] = $age;
                } else {
                    $user['age'] = 0;
                }
                $countryName = null;
                $bankAccountDetails = BankAcconut::where('user_id', $userId)->first();
                if (!empty($bankAccountDetails)) {
                    $c = new Countries();
                    $countries = $c->all();
                    $countryName = $countries[$bankAccountDetails->country]->name->common;
                }

                return view('admin.freelance.freelance-profile-edit', compact('user','bankAccountDetails', 'identityDetail','specializations','channelActivations','countryName'));
            }

        }
    }

    /**
     * this is used to save identity details of user by super admin through AJAX call
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function saveIdentityData(Request $request)
    {
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
                $obj->is_identity_verified = $identity_data['verified1'];
                $obj->identity_verified_by = $superAdminId;
                $obj->first_name = $identity_data['first_name'];
                $obj->middle_name = $identity_data['middle_name'];
                $obj->last_name = $identity_data['last_name'];
                $obj->birthday = databaseDateFromat($identity_data['birthday']);
                $obj->save();
                $this->success = true;
                $this->message = 'User identity saved successfully';
                User::where('id', $userId)->update([
                    'is_identity_verified' => $identity_data['verified1'],
                    'first_name' => $identity_data['first_name'],
                    'last_name' => $identity_data['last_name'],
                    'middle_name' => $identity_data['middle_name'],
                    'birthday' => databaseDateFromat($identity_data['birthday']),
                ]);
                $middleName = '';
                if (!empty($identity_data['middle_name']))
                    $middleName = $identity_data['middle_name'] . ' ';
                ServiceBooking::where('client_id', $userId)->update([
                    'first_name' => $identity_data['first_name'],
                    'last_name' => $identity_data['last_name'],
                    'middle_name' => $identity_data['middle_name'],
                    'full_name' => $identity_data['first_name'] . ' ' . $middleName . '' . $identity_data['last_name'],
                ]);
                $UserData = User::where('id', $userId)->first();
                if (!empty($UserData)) {
                    $age = $UserData->getAgeAttribute();
                    $UserData = $UserData->toArray();
                    $UserData['full_name_display'] = $UserData['first_name'] . ' ' . $UserData['last_name'];
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
        return response()->json(['success' => $this->success, 'message' => $this->message, 'data'=>$this->data]);
    }
    /**
     * this is used to save user education verify status by super admin through AJAX call
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveEducationVerifyStatus(Request $request)
    {
        $superAdminId = loginId();
        $educationVerifyDetail = $request->input('is_education_verify');
        $specializationDetails = $request->input('SpecializationDetails');
        $dropDownFilters = $request->input('dropDownFilters');
        $userId = $request->input('user_id');
        $isEducationOneVerified = false;
        if(!empty($educationVerifyDetail)){
            foreach ($educationVerifyDetail as $key => $row) {
                if ($key == 1) {
                    $isEducationOneVerified = true;
                }
            }
        }
        $user = User::find($userId);
        if (!empty($user)) {
            try {
                DB::beginTransaction();
                foreach ($educationVerifyDetail as $key => $row) {
                    $obj = ChannelActivation::where('user_id', $userId)
                        ->where('specialization_number', $key)
                        ->first();
                    if ($obj) {
                        $obj->is_verify = $row;
                        $obj->verify_by_Admin_id = $superAdminId;
                        $obj->education_title = $specializationDetails['education_title_' . $key];
                        $obj->education_from = $specializationDetails['education_from_' . $key];
                        if (isset($dropDownFilters['specialization_id_' . $key]) && !empty($dropDownFilters['specialization_id_' . $key]))
                            $obj->specialization_id = $dropDownFilters['specialization_id_' . $key];
                        $obj->save();
                    }
                }
                if ($isEducationOneVerified) {
                    $user->is_education_verified = 1;
                    $user->save();
                }

                if ($isEducationOneVerified) {
                    $coach1 = UserInvitation::select('invited_code', 'invited_user_id')
                        ->where('user_id', $userId)
                        ->first();
                    if ($coach1) {
                        $invitedCode = $coach1->invited_code;
                        $invitedUserId = $coach1->invited_user_id;
                        $invitedCoaches = UserInvitation::select('invited_code', 'user_id')
                            ->where('invited_code', $invitedCode)
                            ->get()->toArray();
                        if (count($invitedCoaches) >= 1) {
                            $invitedCoaches = array_column($invitedCoaches, 'user_id');
                            $users = User::select('eduction_certificate_upload_date', 'is_education_verified')
                                ->whereIn('id', $invitedCoaches)
                                ->where('eduction_certificate_upload_date', '!=', null)
                                ->where('is_education_verified', 1)
                                ->get()->toArray();
                            $count = 0;
                            $invitedUser = User::select('created_at')
                                ->where('id', $invitedUserId)
                                ->first();
                            foreach ($users as $row) {
                                $educationdate = new \DateTime($row['eduction_certificate_upload_date']);
                                if (!empty($invitedUser)) {
                                    $interval = $educationdate->diff($invitedUser->created_at);
                                    $days = $interval->format('%a');
                                    if ($days <= 14) {
                                        $count++;
                                    }
                                }
                            }
                            if (count($users) >= 1) {
                                if ($count >= 1) {
                                    User::where('id', $invitedUserId)->update(['is_3i_partner' => 1]);
                                }
                            }
                        }
                    }
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
            $this->success = true;
            $this->message = 'user verified successfully';
        } else {
            $this->message = 'User record not found';
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * this is sued to edit mobile and email of partners and endusers
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editMobileNumber(Request $request)
    {
        $userId = $request->input('user_id');
        $mobileNumber = $request->input('mobile_number');
        $email = $request->input('email');
        $countryCode = $request->input('country_code');
        if (!empty($countryCode)) {
            $countryCode = explode('+', $countryCode);
            $count = count($countryCode);
            $countryCode = ($count == 1 ? $countryCode[0] : $countryCode[1]);
        }
        $obj = User::where('id', $userId)->first();
        if (!empty($obj)) {
            $obj->mobile_number = (!empty($mobileNumber) ? $mobileNumber : $obj->mobile_number);
            $obj->email = (!empty($email) ? $email : $obj->email);
            $obj->extension = (!empty($countryCode) ? $countryCode : $obj->extension);
            $obj->save();
            $this->success = true;
        }
        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    public function educationCertificate(Request $request)
    {
        $imagId = $request->input('id');
        $view = view('admin.freelance.partials._education_certificate_image', compact('imagId'))->render();

        return response()->json(['success' => true, 'message' => $this->message, 'view' => $view]);
    }
}
