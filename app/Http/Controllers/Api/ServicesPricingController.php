<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Client\ClientWeekPlan;
use App\Models\ClientCurrency;
use App\Models\ClientPlan;
use App\Models\ClientSelectedEquipment;
use App\Models\ClientService;
use App\Models\ConfirmedAmount;
use App\Models\Equipment;
use App\Models\FinalPayment;
use App\Models\PaymentSecretKeyDetails;
use App\Models\RattingFreelanceAndZestlog;
use App\Models\RepeatProgramPurchase;
use App\Models\RepeatProgramPurchaseBooking;
use App\Models\ServiceBooking;
use App\Models\TrainingCoachingSessionLength;
use App\Models\TrainingProgramPrice;
use App\Models\TrainingSessionLocation;
use App\Models\UserBlock;
use DateTime;
use Illuminate\Http\Request;
use App\User;
use App\Traits\ZestLogTrait;
use App\Models\TrainingAge;
use App\Models\Service;
use Illuminate\Support\Facades\Lang;
use App\Models\PricingDiscount;
use App\Models\TrainingProgramPriceSetup;
use App\Models\WeekProgram;
use App\Models\TrainingPlan;
use App\Models\Day;
use App\Models\ChangeTrainingPlan;
use App\Models\TrainingCoachingSession;
use DB;

class ServicesPricingController extends Controller
{
    use ZestLogTrait;

    /**
     * This is used to get specialists data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSpecialists(Request $request)
    {
        $this->setUserId($request);
        $this->params['search'] = $request->input('search');
        $this->params['assetUrl'] =  asset(MobileUserImagePath);
        $this->params['user_id'] = $this->userId;
        if (!empty($this->userId)) {
            $blockUser = UserBlock::select('block_user_id')
                ->where('user_id', $this->userId)
                ->get()->toArray();
            $blockUser = array_column($blockUser, 'block_user_id');
            $blocked = UserBlock::select('user_id')
                ->where('block_user_id', $this->userId)
                ->get()->toArray();
            $blocked = array_column($blocked, 'user_id');
            $blockUser = array_merge($blockUser, $blocked);
            $this->params['blockUser'] = $blockUser;
        }
        $this->data = User::getSpecialists($this->params);

        return response()->json(['success' => true, 'message' => '', 'data' => $this->data]);
    }

    /**
     * This is used to get training ages data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function getTrainingAges(Request $request)
   {
       $this->data = TrainingAge::select('id', 'name')->get()->toArray();

       return response()->json(['success' => true, 'message' => '', 'data' => $this->data]);
   }

    /**
     * This is used to get services
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServices(Request $request)
    {
        $this->data = Service::select('services.id as service_id', 'services.name', 'sab.is_checked')
            ->join('service_available_bookings as sab', 'sab.service_id', '=', 'services.id')
            ->where('sab.user_id', '=', $request->input('client_id'))
            ->where('sab.is_checked', '=', 1)
            ->get();

        return response()->json(['success' => true, 'message' => '', 'data' => $this->data]);
    }

    /**
     * this is used to update endUser data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEndUsersData(Request $request)
    {
        $date = str_replace('/', '-', $request->input('birthday'));
        $date1 = date("Y-m-d", strtotime($date));
        $date2 = date("Y-m-d", strtotime(currentDateTime()));
        $diff = abs(strtotime($date2) - strtotime($date1));
        $age = (int)floor($diff / (365 * 60 * 60 * 24));
        $birthday = $date1;
        if ($age >= 13) {
            $this->setUserId($request);
//            $this->userId = $request->input('user_id');
            $data = $request->all();
            $validations = [
                'user_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'user_name' => 'required',
                'gender' => 'required',
                'birthday' => 'required',
                'training_age_id' => 'required'
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
                        if (isset($arrData['birthday']) && !empty($arrData['birthday'])) {
                            $arrData['birthday'] = databaseDateFromat($birthday);
                        }
                        $obj->update($arrData);
                        $userObj = User::where('id', $this->userId)->where('user_type', 0)->first();
                        if (!empty($userObj)) {
                            ServiceBooking::where('client_id', $userObj->id)->update([
                                'first_name' => $userObj->first_name,
                                'middle_name' => $userObj->middle_name,
                                'last_name' => $userObj->last_name,
                                'user_name' => $userObj->user_name,
                            ]);
                        }
                        $this->data[] = $obj->toArray();
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
            $this->success = false;
            $this->message = 'You must be 13 or older';
            $this->data = (object)[];
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
    /**
     * this is used to add endUser services
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addEndUserServices(Request $request)
    {
        $this->setUserId($request);
        $data = $request->all();
        $validations = [
            'user_id' => 'required',
            'client_id' => 'required',
            'service_id' => 'required',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = User::where(['id' => $this->userId])->first();
            if ($obj) {
                try {
                    DB::beginTransaction();
                    $value = explode(',', $request->input('service_id'));
                    ClientService::where(['user_id' => $this->userId, 'client_id' => $request->input('client_id')])->delete();
                    $arr = [];
                    foreach ($value as $key => $row) {
                        $arr[$key]['user_id'] = $this->userId;
                        $arr[$key]['service_id'] = $row;
                        $arr[$key]['client_id'] = $request->input('client_id');
                        $arr[$key]['created_at'] = currentDateTime();
                        $arr[$key]['updated_at'] = currentDateTime();
                    }
                    ClientService::insert($arr);
                    $this->success = true;
                    $this->message = Lang::get('messages.recordUpdatedSuccess');
                    $this->data['unique_id'] = time().'_'.$this->userId.'_'.generateRandomString().rand(10,100);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    $data = @unserialize($e->getMessage());
                    if (empty($data))
                        $data = $e->getMessage();
                    $message = 'Please fix the following issues:';
                    if ($data && is_array($data)) {
                        foreach ($data as $row) {
                            $message .= '<br>' . $row;
                        }
                        $this->message = $message;
                    } else {
                        $this->message = $data;
                    }
                    $this->success = false;
                }
            } else {
                $this->statusCode = $this->errorCode;
                $this->message = [Lang::get('messages.resultNotFound')];
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * this is used to delete client service
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteEndUserServices(Request $request){
        $this->setUserId($request);
        $serviceId = $request->input('service_id');
        $uniqueId = $request->input('unique_id');
        $data = $request->all();
        $validations = [
            'user_id' => 'required',
            'client_id' => 'required',
            'service_id' => 'required',
            'unique_id' => 'required',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = User::where(['id' => $this->userId, 'user_type' => 2])->first();
            if ($obj) {
                try {
                    DB::beginTransaction();
                    ClientService::where(['user_id' => $this->userId, 'service_id' => $serviceId, 'client_id' => $request->input('client_id')])
                        ->delete();
                    ServiceBooking::where('user_id', $this->userId)
                        ->where('client_id', $request->input('client_id'))
                        ->where('service_id', $serviceId)
                        ->where('unique_id', $uniqueId)
                        ->delete();
                    Booking::where('client_id', $request->input('client_id'))
                        ->where('user_id', $this->userId)
                        ->where('service_id', $serviceId)
                        ->where('unique_id', $uniqueId)
                        ->delete();
                    $this->success = true;
                    $this->message = Lang::get('messages.recordUpdatedSuccess');
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    $data = @unserialize($e->getMessage());
                    if (empty($data))
                        $data = $e->getMessage();
                    $message = 'Please fix the following issues:';
                    if ($data && is_array($data)) {
                        foreach ($data as $row) {
                            $message .= '<br>' . $row;
                        }
                        $this->message = $message;
                    } else {
                        $this->message = $data;
                    }
                    $this->success = false;
                }
            } else {
                $this->statusCode = $this->errorCode;
                $this->message = [Lang::get('messages.resultNotFound')];
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);

    }
    /**
     * This is used to get services detail
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServicesDetail(Request $request)
    {
//        $sessions = ['Every week', 'Every 2 weeks', 'Every 4 weeks', 'Every 8 weeks', 'Every 12 weeks'];
//        $arrSessions = prepareSeederData($sessions, 'name', false);
//        \DB::table('change_training_plans')->insert($arrSessions);

        $data = $request->all();
        $validations = [
            'client_id' => 'required|integer',
            'service_id' => 'required|integer'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $serviceId = $request->input('service_id');
            $weekDiscounts = $dayDiscounts = $arrDays = $changeTrainingWeeks = $arrSessions = $arrSessionLocation =  [];
            $obj = TrainingProgramPriceSetup::where(['user_id' => $request->input('client_id'), 'type' => $request->input('service_id')])->first();
            if (!empty($obj)) {
                $weekPrograms = WeekProgram::pluck('name', 'id')->toArray();
                $weekProgramsId = WeekProgram::pluck('id')->toArray();
                $trainingPlans = TrainingPlan::pluck('name', 'id')->toArray();
                $data = PricingDiscount::where('training_program_price_setup_id', '=', $obj->id)
                    ->where('type', '=', $serviceId)->get()->toArray();
                if ($data) {
                    foreach ($data as $row) {
                        $arrTemp = [];
                        if ($row['discount_type'] == 1) {
                            $arrTemp['length_training_program_id'] = $weekProgramsId[$row['day_week_id']-1];
                            $arrTemp['name'] = $weekPrograms[$row['day_week_id']];
                            $weekDiscounts[] = $arrTemp;
                        } else {
                            $arrTemp['days_week_to_train_id'] = $row['training_plan_id'];
                            $arrTemp['name'] = $trainingPlans[$row['training_plan_id']];
                            $arrTemp['coaching_session'] = (int)explode(' ', $trainingPlans[$row['training_plan_id']])[0];
                            if ($row['training_plan_id'] == 9 || $row['training_plan_id'] == 18) {
                                $arrTemp['session_in_week'] = 4;
                            } else if ($row['training_plan_id'] == 10 || $row['training_plan_id'] == 19) {
                                $arrTemp['session_in_week'] = 2;
                            } else {
                                $arrTemp['session_in_week'] = 1;
                            }
                            $dayDiscounts[] = $arrTemp;
                        }
                    }
                    $weekDiscounts = array_column($weekDiscounts, null, 'day_week_id');
                    $dayDiscounts = array_column($dayDiscounts, null, 'day_week_id');
                    $days = Day::pluck('name', 'id')->toArray();
                    $arrDays = [];
                    if ($serviceId == 1 || $serviceId == 2) {
                        foreach ($days as $key => $day) {
                            $arrDays[$key]['day_id'] = $key;
                            $arrDays[$key]['name'] = $day[0];
                        }
                        $plans = ChangeTrainingPlan::pluck('name', 'id')->toArray();
                        foreach ($plans as $key => $row) {
                            $changeTrainingWeeks[$key]['change_training_plan_id'] = $key;
                            $changeTrainingWeeks[$key]['name'] = $row;
                        }
                    }
                }
                if ($serviceId == 3 || $serviceId == 4) {
                    $sessionLength = TrainingCoachingSession::select('tcsl.id', 'tcsl.value')->join('training_program_price_setups as tpps', 'tpps.id', '=', 'training_coaching_sessions.training_program_price_setup_id')
                        ->join('training_coaching_session_lengths as tcsl', 'tcsl.id', '=', 'training_coaching_sessions.session_length_id')
                        ->where(['tcsl.type' => $serviceId, 'training_coaching_sessions.is_listing' => 1, 'tpps.user_id' => $request->input('client_id')])
                        ->orderBy('tcsl.id')->get()->toArray();
                    foreach ($sessionLength as $key => $row) {
                        $arrSessions[$key]['id'] = $row['id'];
                        $arrSessions[$key]['value'] = $row['value'];
                    }
                    $sessionLocation = TrainingSessionLocation::select('training_session_locations.id', 'address_name')->join('training_program_price_setups as tpps', 'tpps.id', '=', 'training_session_locations.training_program_price_setup_id')->where(['tpps.user_id' => $request->input('client_id')])
                        ->orderBy('training_session_locations.id')->get()->toArray();
                    foreach ($sessionLocation as $key => $row) {
                        $arrSessionLocation[$key]['id'] = $row['id'];
                        $arrSessionLocation[$key]['address_name'] = $row['address_name'];
                    }
                }
                $this->data['length_training_program'] = $weekDiscounts;
                $this->data['days_week_to_train'] = $dayDiscounts;
                if ($serviceId == 1) {
                    $this->data['days'] = array_values($arrDays);
                    $this->data['change_training_weeks'] = array_values($changeTrainingWeeks);
                }else if ($serviceId ==2){
                    $this->data['change_training_weeks'] = array_values($changeTrainingWeeks);
                }else if ($serviceId ==3){
                    $this->data['session_length'] = $arrSessions;
                }else if ($serviceId ==4){
                    $this->data['address_name'] = $arrSessionLocation;
                    $this->data['session_length'] = $arrSessions;
                }
                $this->success = true;
            } else {
                $this->message = 'No record Found';
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * this is used to save endUsers Services details
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveServicesDetail(Request $request)
    {
        $this->setUserId($request);
        $userId = $this->userId;
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'service_id' => 'required|integer',
            'client_id' =>'required|integer',
            'unique_id' =>'required'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            try {
                DB::beginTransaction();
                $data = [
                    'lengthTrainingProgramme' => PricingDiscount::find($request->input('length_training_program_id')),
                    'daysWeekToTrain' => PricingDiscount::find($request->input('days_week_to_train'))
                ];
                $obj = ServiceBooking::where('service_id', '=', $request->input('service_id'))
                    ->where('user_id', '=', $userId)
                    ->where('client_id', '=', $request->input('client_id'))
                    ->where('unique_id', '=', $request->input('unique_id'))
                    ->first();
                if (!$obj) {
                    $obj = new ServiceBooking();
                }
                $weekId = WeekProgram::select('meta_data')->where('id', $request->input('length_training_program_id'))->first();
                $endDate = '';
                if (!empty($weekId)) {
                    $endDate = date('Y-m-d', strtotime('+' . $weekId->meta_data . ' week', strtotime(databaseDateFromat($request->input('start_date')))));
                    $date = new DateTime($endDate);
                    $week = $date->format("W");
                    $year = $date->format("Y");
                    $record = $this->getStartAndEndDate($week, $year);
                    $endDate = end($record);
                }
                $clientInfo = User::find($request->input('client_id'));
                $obj->user_id = $userId;
                $obj->service_id = $request->input('service_id');
                $obj->client_id = $request->input('client_id');
                $obj->training_plan_id = $request->input('days_week_to_train');
                $obj->week_id = $request->input('length_training_program_id');
                $obj->unique_id = $request->input('unique_id');
                $obj->pricing_discount_data = json_encode($data);
                $obj->starting_date = databaseDateFromat($request->input('start_date'));
                $obj->end_date = databaseDateFromat($endDate);
                $obj->first_name = $clientInfo->first_name;
                $obj->middle_name = $clientInfo->middle_name;
                $obj->last_name = $clientInfo->last_name;
                if (!empty($clientInfo->middle_name))
                    $clientInfo->middle_name = $clientInfo->middle_name . ' ';
                $obj->full_name = $clientInfo->first_name.' '.$clientInfo->middle_name.''.$clientInfo->last_name;
                $obj->user_name = $clientInfo->user_name;
                if ($request->input('service_id') == 1 || $request->input('service_id') == 2) {
                    $obj->days_id = $request->input('days');
                    $obj->change_training_plan_id = $request->input('change_training_weeks');
                } else {
                    $obj->days_id = $request->input('days');
                    $obj->session_length = $request->input('training_coaching_session_length_id');
                }
                if ($request->input('service_id') == 4) {
                    $obj->training_session_location_id = $request->input('training_session_location_id');
                    $location = TrainingSessionLocation::select('address_name')->where('id', $request->input('training_session_location_id'))->first();
                    if (isset($location['address_name']))
                        $obj->training_session_location = $location['address_name'];
                } elseif ($request->input('service_id') == 3) {
                    $obj->training_session_location = 'Online';
                }
                $obj->save();
                $insertedId = FinalPayment::updateorCreate(
                    [
                        'user_id' => $userId,
                        'unique_id' => $request->input('unique_id'),
                        'client_id' => $request->input('client_id')
                    ],
                    ['starting_date' => databaseDateFromat($request->input('start_date')),
                        'end_date' => databaseDateFromat($endDate),
                    ]
                )->id;
                $countPayment = FinalPayment::whereDate('updated_at', now())->orderBy('id')->count();
                $dt = new DateTime();
                $date = $dt->format('dmy');
                $counter = 000000000;
                if ($countPayment > 1) {
                    $objFinalPayment = FinalPayment::select('counter')->where('id', '<', $insertedId)->orderBy('id', 'desc')->first();
                    $counter = $objFinalPayment->counter;
                }
                $c = sprintf('%09d', $counter + 1);
                $referenceNumber = $date . $c;
                FinalPayment::where('unique_id', $request->input('unique_id'))
                    ->update([
                        'reference_number' => $referenceNumber,
                        'counter' => $c
                    ]);
                $this->success = true;
                $this->message = 'Data saved Successfully';
                DB::commit();
            } catch (\Illuminate\Database\QueryException $e) {
                $this->message = $e->errorInfo[2];
                DB::rollback();
            }
    }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * this is used to get final prices
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFinalPrices(Request $request)
    {
        $this->setUserId($request);
        $userId = $this->userId;
        $clientId = $request->input('client_id');
        $serviceId = (int)$request->input('service_id');
        $uniqueId = $request->input('unique_id');
        $data = $request->all();
        $arr = [];
        $this->type = $serviceId;
        $validations = [
            'user_id' => 'required|integer',
            'service_id' => 'required|integer',
            'client_id' => 'required|integer',
            'unique_id' => 'required'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {

            $this->data['total_price'] = 0;
            $this->data['discount_percentage'] = 0;
            $this->data['discount_amount'] =  0;
            $obj = ServiceBooking::select('week_id', 'training_plan_id as days_week_to_train')
                ->where('client_id', $clientId)
                ->where('user_id', $userId)
                ->where('unique_id', $uniqueId)
                ->where('service_id', $serviceId)
                ->first();
            if ($obj) {
                $obj = $obj->toArray();
                if ($serviceId != 1 && $serviceId != 2) {
                    $this->data['total_price'] = $this->getFinalServicePrice($request->input('client_id'), $request->input('service_id'),
                        $obj['week_id'], $obj['days_week_to_train']);
                    $this->data['discount_percentage'] = $this->discountTotalPercentage;
                    $dicountAmount = '-' . $this->discountTotalAmount;
                    if ((double)$dicountAmount != -0)
                        $this->data['discount_amount'] = (double)$dicountAmount;
                    $this->success = true;
                } else if ($serviceId == 1) {
                    $this->data['total_price'] = $this->getFinalServicePriceUsingFormulas($clientId, $serviceId, $uniqueId, $userId);
                    $this->data['discount_percentage'] = $this->discountTotalPercentage;
                    $dicountAmount = '-' . $this->discountTotalAmount;
                    if ((double)$dicountAmount != -0)
                        $this->data['discount_amount'] = (double)$dicountAmount;
                    $this->success = true;
                }
            }
            $objCurrency = $this->getClientCurrency($clientId);
            if ($objCurrency) {
                $this->data['currency'] = $objCurrency;
            } else {
                $this->data['currency'] = [];
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * this is used to get final prices
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFinalTotalPrices(Request $request)
    {
        $this->setUserId($request);
        $userId = $this->userId;
        $uniqueId = $request->input('unique_id');
        $clientId = $request->input('client_id');
        $data = $request->all();
        $arr = [];
        $validations = [
            'user_id' => 'required|integer',
            'client_id' => 'required|integer',
            'unique_id' => 'required'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = ServiceBooking::
            where('user_id', $userId)
                ->where('client_id', $request->input('client_id'))
                ->where('unique_id', $uniqueId)
                ->get()->toArray();

            $value = 0;
            foreach ($obj as $row) {
                if (isset($row['service_id'])) {
                    if ($row['service_id'] == 1) {
                        $value += $this->getFinalServicePriceUsingFormulas($request->input('client_id'), $row['service_id'],
                            $uniqueId, $userId);
                    } else {
                        $value += $this->getFinalServicePrice($request->input('client_id'), $row['service_id'],
                            $row['week_id'], $row['training_plan_id']);
                    }
                }
            }
            $this->data['final_price'] = roundValue($value);

            $objCurrency = $this->getClientCurrency($clientId);
            if($objCurrency)
            {
                $this->data['currency'] = $objCurrency;
            }
            else
            {
                $this->data['currency']= [];
            }

            $this->success = true;
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * this is used to change payment status after payment
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function savePayment(Request $request)
    {
        $data = $request->all();
        $validations = [
            'client_id' => 'required|integer',
            'user_id' => 'required|integer',
            'unique_id' => 'required'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            try {
                DB::beginTransaction();
                $serviceBookingObject = ServiceBooking::select('starting_date', 'ctp.meta_data as change_training_plan_id',
                    'wp.meta_data as week_id')
                    ->leftjoin('change_training_plans as ctp', 'ctp.id', '=', 'service_bookings.change_training_plan_id')
                    ->join('week_programs as wp', 'wp.id', '=', 'service_bookings.week_id')
                    ->where('client_id', $data['client_id'])
                    ->where('user_id', $data['user_id'])
                    ->where('unique_id', $data['unique_id'])
                    ->where('service_id', 1)
                    ->first();
                if ($serviceBookingObject) {
                    $serviceBookingObject = $serviceBookingObject->toArray();
                    $weekIncrementValue = $serviceBookingObject['change_training_plan_id'];
                    $startYear = date('Y', strtotime($serviceBookingObject['starting_date']));
                    $startWeekId = date('W', strtotime($serviceBookingObject['starting_date']));
                    $yearStartBooking = $startYear;
                    $startDate = $serviceBookingObject['starting_date'];
                    $weekId = $serviceBookingObject['week_id'];

                    if (isLightVersion()) {
                        if (empty($weekIncrementValue)) {
                            $weekIncrementValue = 1;
                        }
                    }
                    if ($weekIncrementValue == 1) {
                        if (isLightVersion()) {
                            $divideWeekIdByChangeTrainingId = ($weekId / 1);
                        } else {
                            $divideWeekIdByChangeTrainingId = ($weekId / $weekId);
                        }

                    } else {
                        $divideWeekIdByChangeTrainingId = ($weekId / $weekIncrementValue);
                    }
                    $count = 1;
                    for ($j = 1; $j <= $divideWeekIdByChangeTrainingId; $j++) {
                        $objClient = ClientPlan::updateorCreate(
                            [
                                'user_id' => (int)$request->input('user_id'),
                                'client_id' => (int)$request->input('client_id'),
                                'unique_id' => $request->input('unique_id'),
                                'week_id' => $startWeekId,
                                'year' => $startYear
                            ], ['created_at' => currentDateTime(),
                                'updated_at' => currentDateTime()
                            ]
                        );
                        $arrClientPlan = [];
                        if($weekIncrementValue == 1){
                            if(isLightVersion()){
                                $weekEnd = $startWeekId + 1;
                            }else{
                                $weekEnd = $startWeekId + $weekId;
                            }
                        }else{
                            $weekEnd = ((int)$weekIncrementValue + (int)$startWeekId);
                        }
                        $totalWeekInYear = $this->getIsoWeeksInYear($startYear);
                        $is_new = $objClient->id;
                        for ($i = $startWeekId; $i < $weekEnd;$i++) {
                            $arrClientPlan[$i]['client_plan_id'] = $objClient->id;
                            $arrClientPlan[$i]['user_id'] = (int)$request->input('user_id');
                            $arrClientPlan[$i]['client_id'] = (int)$request->input('client_id');
                            $arrClientPlan[$i]['unique_id'] = $request->input('unique_id');
                            $arrClientPlan[$i]['week_id'] = $i;
                            $arrClientPlan[$i]['week_count'] = $count;
                            if ($is_new == $objClient->id) {
                                $arrClientPlan[$i]['is_new'] = 1;
                            } else {
                                $arrClientPlan[$i]['is_new'] = 0;
                            }
                            $arrClientPlan[$i]['year'] = $startYear;
                            $arrClientPlan[$i]['created_at'] = currentDateTime();
                            $arrClientPlan[$i]['updated_at'] = currentDateTime();
                            $count++;
                            $is_new++;
                            if ($i >= $totalWeekInYear) {
                                if ($i > $totalWeekInYear) {
                                    $weekEnd = (($weekEnd - $totalWeekInYear) - 1);
                                } else {
                                    $weekEnd = ($weekEnd - $totalWeekInYear);
                                }
                                $i = 0;
                                if ($startWeekId != 53) {
                                    $startYear++;
                                }
                            }
                        }
                        ClientWeekPlan::where('client_plan_id', $objClient->id)->delete();
                        ClientWeekPlan::insert($arrClientPlan);
                        $weekAddition = '+' . $weekIncrementValue . ' week';
                        if ($j != 1) {
                            $startDate = date('Y-m-d', strtotime($weekAddition, strtotime($startDate)));
                        }
                        $startYear = date('Y', strtotime($weekAddition, strtotime($startDate)));
                        $startWeekId = date('W', strtotime($weekAddition, strtotime($startDate)));

                    }
                }
                $objServiceBooking = ServiceBooking::select('service_bookings.training_plan_id',
                    'service_bookings.week_id','service_bookings.service_id','tp.days_value','wp.meta_data as length')
                    ->where('service_bookings.user_id', $request->input('user_id'))
                    ->where('service_bookings.client_id', $request->input('client_id'))
                    ->where('service_bookings.unique_id', $request->input('unique_id'))
                    ->join('training_plans as tp', 'tp.id', '=', 'service_bookings.training_plan_id')
                    ->join('week_programs as wp', 'wp.id', '=', 'service_bookings.week_id')
                    ->get()->toArray();
                $objServiceBooking = array_column($objServiceBooking,null,'service_id');
                $duration = 0;
                $tOS = 0;
                $tTp = 0;
                if(!empty($objServiceBooking)){
                    if (isset($objServiceBooking[1]['length'])) {
                        $duration = $objServiceBooking[1]['length'];
                    }
                    if (isset($objServiceBooking[3]['length'])) {
                        $tOS = (int)($objServiceBooking[3]['length'] * $objServiceBooking[3]['days_value']);
                    }
                    if (isset($objServiceBooking[4]['length'])) {
                        $tTp = (int)($objServiceBooking[4]['length'] * $objServiceBooking[4]['days_value']);
                    }
                }
                $value = 0;
                $valueWithG = 0;
                $trainingProgramPrice = 0;
                $onlineCoachingPrice = 0;
                $personalTrainingPrice = 0;
                $clientGValue = User::find($request->input('client_id'))->client_g_value;
                foreach ($objServiceBooking as $row) {
                    $singleProgramAmount = 0;
                    if (isset($row['service_id'])) {
                        if ($row['service_id'] == 1) {
                            $trainingProgramPrice = $this->getFinalServicePriceUsingFormulas($request->input('client_id'), $row['service_id'],
                                $request->input('unique_id'), $request->input('user_id'));
                            $value += $trainingProgramPrice;
                            $valueWithG += ($trainingProgramPrice * $clientGValue);
                        } else {
                            $singleProgramAmount = $this->getFinalServicePrice($request->input('client_id'), $row['service_id'],
                                $row['week_id'], $row['training_plan_id']);
                            if ($row['service_id'] == 3) {
                                $onlineCoachingPrice = $singleProgramAmount;
                            } else {
                                $personalTrainingPrice = $singleProgramAmount;
                            }
                            $value += $singleProgramAmount;
                            $valueWithG += ($singleProgramAmount * $clientGValue);
                        }
                    }
                }
                $dt = new DateTime();
                $date = $dt->format('dmy');
                $serviceValue = getServicePercentage();
                $serviceAmount = round(($value * $serviceValue), 2);
                if ($serviceAmount <= 10) {
                    $serviceAmount = 10;
                }
                $aTrainingAmount = ($clientGValue * $trainingProgramPrice);
                $bOcAmount = ($clientGValue * $onlineCoachingPrice);
                $cTpAmount = ($clientGValue * $personalTrainingPrice);
                $totalAmountWithService = round(($value + $serviceAmount), 2);
                $pricePerTrainingProgram = $pricePerOnlineSession = $pricePerPersonalTraining = 0;
                if (!empty($duration))
                    $pricePerTrainingProgram = ($aTrainingAmount / $duration);
                if (!empty($tOS))
                    $pricePerOnlineSession = ($bOcAmount / $tOS);
                if (!empty($tTp))
                    $pricePerPersonalTraining = ($cTpAmount / $tTp);

                if(isLightVersion()){
                    $personalTrainingPrice = 0;
                    $onlineCoachingPrice = 0;
                    $trainingProgramPrice = 0;
                    $pricePerPersonalTraining = 0;
                    $pricePerOnlineSession = 0;
                    $pricePerTrainingProgram = 0;
                    $valueWithG = 0;
                    $cTpAmount = 0;
                    $bOcAmount = 0;
                    $aTrainingAmount = 0;
                    $totalAmountWithService = 0;
                    $value = 0;
                    $serviceAmount = 0;
                }
                    $updateArr = ['is_payment' => 1,
                        'total_price' => $value,
                        'service_fee' => $serviceAmount,
                        'service_fee_from_coach' => ($value - $valueWithG),
                        'total_service_fee' => ($serviceAmount + ($value - $valueWithG)),
                        'total_amount' => $totalAmountWithService,
                        'Training_Program_amount' => $aTrainingAmount,
                        'Online_Coaching_amount' => $bOcAmount,
                        'Personal_Training_amount' => $cTpAmount,
                        'client_f_amount' => $valueWithG,
                        'earning_week_program' => $pricePerTrainingProgram,
                        'earning_oc_session' => $pricePerOnlineSession,
                        'earning_pt_session' => $pricePerPersonalTraining,
                        'f_tp_amount' => $trainingProgramPrice,
                        'f_oc_amount' => $onlineCoachingPrice,
                        'f_pt_amount' => $personalTrainingPrice,

                    ];
                    $obj = FinalPayment::where('unique_id', $request->input('unique_id'))
                        ->update($updateArr);
                $referenceNumber = FinalPayment::where('unique_id',$request->input('unique_id'))->first();
                $perBookingAmount = $pricePerOnlineSession;
                if(empty($perBookingAmount)){
                    $perBookingAmount = $pricePerPersonalTraining; // later on wew ill change it according to service id
                }
                if(isLightVersion()){
                    $perBookingAmount = 0;
                    $pricePerTrainingProgram = 0;
                }
                Booking::where('user_id', $request->input('user_id'))
                    ->where('client_id', $request->input('client_id'))
                    ->where('unique_id', $request->input('unique_id'))
                    ->update([
                        'is_payment' => 1,
                        'amount' => $perBookingAmount,
                        'reference_number' => $referenceNumber->reference_number
                    ]);
                ClientWeekPlan::where('user_id', $request->input('user_id'))
                    ->where('client_id', $request->input('client_id'))
                    ->where('unique_id', $request->input('unique_id'))
                    ->update([
                        'amount' => $pricePerTrainingProgram,
                        'reference_number' => $referenceNumber->reference_number
                    ]);
                RattingFreelanceAndZestlog::updateOrCreate([
                    'client_id' => $request->input('client_id'),
                    'user_id' => $request->input('user_id'),
                    'unique_id' => $request->input('unique_id'),
                ]);
                if (!$obj) {
                    $this->message = 'Record not found';
                    DB::rollback();
                } else {
                    $objUser = User::find($request->input('client_id'));
                    $objUser->increment('total_bookings');
                    $arrPush = [];
                    $arrPush['title'] = 'New Booking';
                    $arrPush['message'] = 'You have received new booking. Go to your coach panel on www.zestlog.com to accept it';
                    $arrPush['notification_message'] = 'You have received new booking. Go to your coach panel on www.zestlog.com to accept it';
                    $arrPush['device_token'] = $objUser->device_token;
                    $arrPush['user_id'] = $objUser->id;
                    $arrPush['notification_user_id'] = $request->input('user_id');
                    $this->sendPushNotifications($arrPush);
                    $this->message = 'Payment save successfully';
                    $this->success = true;
                    DB::commit();
                }
            } catch (\Exception $e) {
                DB::rollback();
                $this->message = 'Something went wrong';
            }
        }


        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * this is used to get week change details using week length
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function weekChange(Request $request)
    {
        $lengthTrainingProgramId = $request->input('length_training_program_id');
        $data = $request->all();
        $arr = [];
        $validations = [
            'length_training_program_id' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            if ($lengthTrainingProgramId == 1 || $lengthTrainingProgramId == 2) {
                $arr = [[
                    "change_training_plan_id" => 1,
                    "name" => "No change"
                ]];
            } elseif ($lengthTrainingProgramId == 3 || $lengthTrainingProgramId == 4) {
                $arr = [
                    [
                        "change_training_plan_id" => 1,
                        "name" => "No change"
                    ],
                    [
                        "change_training_plan_id" => 2,
                        "name" => "Every 4 weeks"
                    ]
                ];

            } elseif ($lengthTrainingProgramId == 5 || $lengthTrainingProgramId == 6) {
                $arr = [
                    [
                        "change_training_plan_id" => 1,
                        "name" => "No change"
                    ],
                    [
                        "change_training_plan_id" => 2,
                        "name" => "Every 4 weeks"
                    ],
                    [
                        "change_training_plan_id" => 3,
                        "name" => "Every 8 weeks"
                    ],
                    [
                        "change_training_plan_id" => 4,
                        "name" => "Every 12 weeks"
                    ]

                ];

            }
            $preparedArray['change_training_weeks'] = $arr;
            $this->data = $preparedArray;
            $this->success = true;
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
    /**
     * this is used to get equipments
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEquipment (Request $request){

        $obj = Equipment::select('id','name')->get()->toArray();
        $eq['equipment'] = $obj;
        $this->success = true;
        $this->data = $eq;

        return response()->json(['success' => $this->success, 'data' => $this->data], $this->statusCode);
    }

    /**
     * this is used to add users's selected equipments
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clientSelectedEquipments(Request $request){
        $equipmentId = $request->input('equipment_id');
        $clientId = $request->input('client_id');
        $uniqueId = $request->input('unique_id');
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'equipment_id' => 'required',
            'client_id' => 'required|integer',
            'unique_id' => 'required'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $this->setUserId($request);
            $user = User::find($this->userId);
            if (!empty($user)) {
                $client = User::find($clientId);
                if (!empty($client)) {
                    $obj = ClientSelectedEquipment::where('user_id', $this->userId)
                        ->where('client_id', $clientId)
                        ->where('unique_id', $uniqueId)
                        ->first();
                    if (empty($obj)) {
                        $obj = new ClientSelectedEquipment();
                        $obj->user_id = $this->userId;
                        $obj->client_id = $clientId;
                        $obj->unique_id = $uniqueId;
                    }
                    $obj->equipment_id = $equipmentId;
                    $obj->save();
                    $this->success = true;
                    $this->message = 'Equipment save successfully';
                } else {
                    $this->message = "Client not found";
                }
            } else {
                $this->message = "User not found";
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * generate secret key for payment
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paymentSecretKey(Request $request)
    {
        $this->setUserId($request);
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        try {
            \Stripe\Stripe::setApiKey(getenv('STRIPE_KEY'));
            $intent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
            ]);
            $client_secret = $intent->client_secret;
            PaymentSecretKeyDetails::updateOrCreate([
                'user_id' => $this->userId,
                'currency' => $currency,
                'amount' => $amount,
                'secret_key' => $client_secret
            ]);
            $this->data['secret_key'] = $client_secret;
            $this->success = true;
        } catch (\Exception $e) {
            $this->data['secret_key'] = '';
        }

        return response()->json(['success' => $this->success, 'data' => $this->data], $this->statusCode);
    }

    function getIsoWeeksInYear($year) {
        $date = new DateTime;
        $date->setISODate($year, 53);
        return ($date->format("W") === "53" ? 53 : 52);
    }

    public function serviceReceived(Request $request){

//        $newDate = getIncremetMonthDate();
        $day = date('d',strtotime(currentDateTime()));
        if($day>14){
            $date = new DateTime('now');
            $date->modify('first day of next month');
            $payoutDate = $date->format('Y-m-d');
        }else{
            $dayIncrement = '+ '.(15-$day).' day';
            $payoutDate = date('Y-m-d', strtotime(currentDateTime(). $dayIncrement));
        }
        $clientWeekPlanId = $request->input('client_week_plan_id');
        $isConfirmed = $request->input('is_confirmed');
        $data = $request->all();
        $validations = [
            'client_week_plan_id' => 'required|integer',
            'is_confirmed' => 'required',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            try {
                DB::beginTransaction();
                $obj = ClientWeekPlan::where('id', $clientWeekPlanId)
                    ->first();
                $obj->is_confirmed = $isConfirmed;
                $obj->payout_month = $payoutDate;
                $obj->payout_date = $payoutDate;
                $obj->save();
                ConfirmedAmount::updateOrCreate([
                    'client_week_plan_id' => $clientWeekPlanId
                ],
                    [
                        'client_id' => $obj->client_id,
                        'is_confirmed' => $isConfirmed,
                        'payout_month' => $payoutDate,
                        'payout_date' => $payoutDate,
                        'amount' => $obj->amount,
                    ]
                );
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
            if (!empty($obj)) {
                $this->success = true;
                $this->message = 'Record updated successfully';
            }
        }

        return response()->json(['success' => $this->success,'message' => $this->message], $this->statusCode);
    }

    public function bookingReceived(Request $request)
    {
//        $newDate = getIncremetMonthDate();
        $day = date('d',strtotime(currentDateTime()));
        if($day>14){
            $date = new DateTime('now');
            $date->modify('first day of next month');
            $payoutDate = $date->format('Y-m-d');
        }else{
            $dayIncrement = '+ '.(15-$day).' day';
            $payoutDate = date('Y-m-d', strtotime(currentDateTime(). $dayIncrement));
        }
        $isConfirmed = $request->input('is_confirmed');
        $bookingId = $request->input('booking_id');
        $data = $request->all();
        $validations = [
            'is_confirmed' => 'required',
            'booking_id' => 'required'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = [];
            try {
                DB::beginTransaction();
                $obj = Booking::where('id', $bookingId)
                    ->first();
                $obj->is_confirmed = $isConfirmed;
                $obj->payout_month = $payoutDate;
                $obj->payout_date = $payoutDate;
                $obj->save();
                ConfirmedAmount::updateOrCreate([
                    'booking_id' => $bookingId
                ],
                    [
                        'client_id' => $obj->client_id,
                        'is_confirmed' => $isConfirmed,
                        'payout_month' => $payoutDate,
                        'payout_date' => $payoutDate,
                        'amount' => $obj->amount,
                    ]
                );
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
            if (!empty($obj)) {
                $this->success = true;
                $this->message = 'Record updated successfully';
            }
        }
        return response()->json(['success' => $this->success, 'message' => $this->message], $this->statusCode);
    }

}
