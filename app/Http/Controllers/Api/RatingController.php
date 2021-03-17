<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Day;
use App\Models\FinalPayment;
use App\Models\PricingDiscount;
use App\Models\PrivateReviewCategorie;
use App\Models\RattingFreelanceAndZestlog;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Models\TrainingPlan;
use App\Models\TrainingProgramPriceSetup;
use App\User;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use App\Traits\ZestLogTrait;
use Illuminate\Support\Facades\DB;
use test\Mockery\ReturnTypeObjectTypeHint;
use App\Models\ClientCurrency;

class RatingController extends Controller
{
    use ZestLogTrait;
    /**
     * this is used to rate the app and coach
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function RatingCoachAndZestlog(Request $request){
        $this->setUserId($request);
        $clientId = $request->input('client_id');
        $uniqueId = $request->input('unique_id');
        $startCoachAndProgram = $request->input('star_coach_and_program');
        $experienceAboutCoach = $request->input('experience_about_coach');
        $experienceZestlog = $request->input('experience_zestlog');
        $starZestlog = $request->input('star_zestlog');
        $coachReviewId = $request->input('coach_review_id');
        $zestlogReviewId = $request->input('zestlog_review_id');

        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'client_id' => 'required|integer',
            'unique_id' => 'required',
            'star_coach_and_program' => 'required',
            'experience_about_coach' => 'required',
            'experience_zestlog' => 'required',
//            'star_zestlog' => 'required',
            'coach_review_id' => 'required|integer',
            'zestlog_review_id' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = RattingFreelanceAndZestlog::where('client_id',$clientId)
                ->where('user_id',$this->userId)
                ->where('unique_id',$uniqueId)
                ->first();
            if(!$obj){
                $obj = new RattingFreelanceAndZestlog();
                $obj->user_id = $this->userId;
                $obj->client_id = $clientId;
                $obj->unique_id = $uniqueId;
            }
            $obj->star_coach_and_program = $startCoachAndProgram;
            $obj->experience_about_coach = $experienceAboutCoach;
            $obj->experience_zestlog = $experienceZestlog;
            $obj->star_zestlog = $starZestlog;
            $obj->star_zestlog = $starZestlog;
            $obj->private_review_categories_coach_id = $coachReviewId;
            $obj->private_review_categories_zestlog_id = $zestlogReviewId;
            $obj->save();
            $this->success = true;
            $this->message = 'Rating added successfully';
        }

        return response()->json(['success' => $this->success,'message' => $this->message]);

    }

    /**
     * this is used to get already purchased programs
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAlreadyPurchasedDetail(Request $request)
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
            $obj = ServiceBooking::select('service_bookings.created_at as submission_date',
                'service_bookings.unique_id',
                'u.first_name','u.last_name','u.id',
                'u.profile_pic_upload as profile_image',
                'fp.status',
                'wp.meta_data','service_bookings.starting_date', 'service_bookings.service_id', 'fp.end_date')
                ->where('service_bookings.user_id',$this->userId)
                ->join('users as u','u.id','service_bookings.client_id')
                ->join('final_payments as fp','fp.unique_id','service_bookings.unique_id')
                ->join('week_programs as wp','wp.id','service_bookings.week_id')
//                ->groupBy('service_bookings.client_id')
                ->groupBy('fp.unique_id')
                ->where('fp.status','!=',2)
                ->where('fp.is_payment', '=', 1)
                ->get()->toArray();
            $arr = [];
            foreach ($obj as $key =>$row) {
                $name = 'PastBooking';
                $arr[$name][$key]['client_id'] = $obj[$key]['id'];
                $arr[$name][$key]['unique_id'] = $obj[$key]['unique_id'];
                $arr[$name][$key]['first_name'] = $obj[$key]['first_name'];
                $arr[$name][$key]['last_name'] = $obj[$key]['last_name'];
                $arr[$name][$key]['submission_date'] = $obj[$key]['submission_date'];
                $arr[$name][$key]['end_date'] = $obj[$key]['end_date'];
                $arr[$name][$key]['service_id'] = $obj[$key]['service_id'];
                if (!empty($row['profile_image'])) {
                    $arr[$name][$key]['profile_image'] = asset(clientImagePath . '/' . $obj[$key]['profile_image']);
                } else {
                    $arr[$name][$key]['profile_image'] = null;
                }

                $type = 'disabled';
                $currentDate = date('Y/m/d');
                if (strtotime($currentDate) > strtotime($row['end_date'])) {
                    $availableDate = date('Y-m-d', strtotime($row['end_date'] . ' + 14 days'));
                    if (strtotime($availableDate) >= strtotime($currentDate)) {
                        $type = 'available';
                    }
                    $arr[$name][$key]['status'] = 'Completed';
                } else {
                    if ($row['status'] == 1) {
                        $arr[$name][$key]['status'] = 'Ongoing';
                    } else if ($row['status'] == 0) {
                        $arr[$name][$key]['status'] = 'Pending';
                    }
                }
                $arr[$name][$key]['type'] = $type;
            }
            if (empty($arr)) {
                $this->data['PastBooking'] = (array)$arr;
            } else {
                $this->data = (array)$arr;
            }
            $this->success = true;
        }

         return response()->json(['success' => $this->success,'data' => $this->data,'message' => $this->message]);
    }

    /**
     * this is used to get programs detail and prices
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reviewProgram(Request $request)
    {
        $this->setUserId($request);
        $clientId = $request->input('client_id');
        $uniqueId = $request->input('unique_id');
        $value = 0;
        $dataRequest = $request->all();
        $validations = [
            'client_id' => 'required|integer',
            'unique_id' => 'required',
            'user_id' => 'required|integer',
        ];
        $validator = \Validator::make($dataRequest, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $userId = $this->userId;
            $data['services'] = FinalPayment::select('u.id as user_id', 's.name as service_name', 's.id as service_id', 'final_payments.unique_id','final_payments.reference_number')
                ->where('final_payments.unique_id', '=', $uniqueId)
                ->join('users as u', 'u.id', '=', 'final_payments.user_id')
                ->join('service_bookings as sb', 'sb.user_id', '=', 'final_payments.user_id')
                ->join('services as s', 's.id', 'sb.service_id')
                ->where('sb.client_id', $clientId)
                ->where('sb.user_id', $this->userId)
                ->where('sb.unique_id', $uniqueId)
                ->get()->toArray();
            if (!empty($data['services'])) {
                $services = array_column(Service::get()->toArray(), null, 'id');
                $record = array_column($data['services'], null, 'service_id');
                $data['bookingDuration'] = ServiceBooking::select('tp.name as training_plan', 'w.name as week', 'service_bookings.days_id',
                    'tp.id as training_plan_id', 'tp.days_value', 'w.id as week_id', 'w.name as week_name', 'sl.value as session_length',
                    'service_bookings.service_id', 'service_bookings.training_session_location', 'cp.name as change_training_plan', 'service_bookings.starting_date')
                    ->where('service_bookings.user_id', $this->userId)
                    ->where('service_bookings.client_id', $clientId)
                    ->where('service_bookings.unique_id', $uniqueId)
                    ->join('training_plans as tp', 'tp.id', 'service_bookings.training_plan_id')
                    ->join('week_programs as w', 'w.id', 'service_bookings.week_id')
                    ->leftjoin('training_coaching_session_lengths as sl', 'sl.id', 'service_bookings.session_length')
                    ->leftjoin('change_training_plans as cp', 'cp.id', 'service_bookings.change_training_plan_id')
                    ->orderby('service_id')
                    ->get()->toArray();
                $objFinalPayment = FinalPayment::where('user_id',$userId)
                    ->where('client_id',$clientId)
                    ->where('unique_id',$uniqueId)
                    ->first();
                $totalPrice = $serviceFee = $totalAmount = 0;
                if (!empty($objFinalPayment)) {
                    $totalPrice = $objFinalPayment->total_price;
                    $serviceFee = $objFinalPayment->service_fee;
                    $totalAmount = $objFinalPayment->total_amount;
                    $index = array_keys(array_column($data['services'], null, 'service_id'));
                    $arrServiceNames = ['1' => 'f_tp_amount', '3' => 'f_oc_amount', '4' => 'f_pt_amount'];
                    $objFinalPayment = $objFinalPayment->toArray();
                    foreach ($index as $key => $row) {
                        $name = $arrServiceNames[$row];
                        $data['services'][$key]['prices'] = (!empty($objFinalPayment[$name]) ? $objFinalPayment[$name] : 0);
                    }
                }
                if ($totalPrice <= 0) {
                    $index = array_keys(array_column($data['bookingDuration'], null, 'service_id'));
                    if (isset($data['bookingDuration'])) {
                        foreach ($data['bookingDuration'] as $key => $row) {
                            if (!empty($record[$row['service_id']])) {
                                $data['bookingDuration'][$key]['user_id'] = $record[$row['service_id']]['user_id'];
                                $weekValue = explode('-', $row['week_name'])[0];
                                $data['bookingDuration'][$key]['total_sessions'] = getTotalSessions($weekValue, $row['days_value']);
                            } else if (!empty($services[$row['service_id']])) {
                                $data['bookingDuration'][$key]['service_name'] = $services[$row['service_id']]['service_name'];
                                $weekValue = explode('-', $row['week_name'])[0];
                                $data['bookingDuration'][$key]['total_sessions'] = getTotalSessions($weekValue, $row['days_value']);
                            }
                        }
                        $data['bookingDuration'] = array_column($data['bookingDuration'], null, 'service_id');

                        if (!empty($data['services'])) {
                            $index = array_keys(array_column($data['services'], null, 'service_id'));
                            foreach ($index as $key => $serviceId) {
                                if ($serviceId == 1 || $serviceId == 2) {
                                    if ($serviceId == 1)// 1 for training program
                                    {
                                        $data['services'][$key]['prices'] = $this->getFinalServicePriceUsingFormulas($clientId, $serviceId, $uniqueId, $userId);
                                        $value = $value + $data['services'][$key]['prices'];
                                    } else {
                                        $data['services'][$key]['prices'] = 0;
                                    }
                                } else {
                                    if (isset($data['bookingDuration'][$serviceId])) {
                                        $data['services'][$key]['prices'] = $this->getFinalServicePrice($clientId, $serviceId, $data['bookingDuration'][$serviceId]['week_id'], $data['bookingDuration'][$serviceId]['training_plan_id']);
                                        $value = ($value + $data['services'][$key]['prices']);
                                    } else {
                                        $data['services'][$key]['prices'] = 0;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $this->success = true;
            if (isset($data['bookingDuration']))
                unset($data['bookingDuration']);
            if ($totalPrice <= 0) {
                $data['sub_total'] = $value;
                $data['service_fee'] = round(($value * getServicePercentage()), 2);
                if ($data['service_fee'] <= 10) {
                    $data['service_fee'] = 10;
                }
                if (isset($data['service_fee']))
                    $data['total'] = round(($value + $data['service_fee']), 2);
            } else {
                $data['sub_total'] = $totalPrice;
                $data['service_fee'] = $serviceFee;
                $data['total'] = $totalAmount;
            }

            // add client currency
            $data['currency'] = ClientCurrency::getCurrency(['client_id' => $request->input('client_id')]);
            $data['reference_number'] = null;
            if (!empty($data['services'][0])) {
                $data['reference_number'] = $data['services'][0]['reference_number'];
            }

            $data['sandbox_client_id'] = getenv("SANDBOX_CLIENT_ID");
            $data['live_client_id'] = getenv("LIVE_CLIENT_ID");
            $this->data = $data;
        }

//        $data['services'][$key]['prices'] = 0;

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message]);
    }

    /**
     * this is used to get personal information
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPersonalInformation(Request $request){
        $this->setUserId($request);
        $data = [];
        $dataRequest = $request->all();
        $validations = [
            'user_id' => 'required|integer',
        ];
        $validator = \Validator::make($dataRequest, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = User::select( DB::raw("CONCAT(users.first_name,  ' ', users.last_name ) as display_name"),
                'users.gender', 'users.bmi', 'users.waist',
                'users.more_info', 'users.additional_details', 'users.birthday', 'ta.name as training_age', 'g.name as goal')
                ->where('users.id', $this->userId)
                ->leftjoin('goals as g', 'g.id', 'users.goal_id')
                ->leftjoin('training_ages as ta', 'ta.id', 'users.training_age_id')
                ->first();
            if ($obj) {
                $data['personal_information'] = $obj->toArray();
                $birthday = currentDateTime();
                if(!empty($obj->birthday)){
                    $birthday = $obj->birthday;
                }
                $age = getAgeFromBirthday($birthday);
                $data['personal_information']['age'] = $age;
                $this->data = $data;
                $this->success = true;
            } else {
                $this->message = 'User data not found';
            }
        }
        return response()->json(['success' => $this->success,'data' => $this->data,'message' => $this->message]);
    }

    /**
     * this is used to get programs details
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServicesReview(Request $request)
    {

        $clientId = $request->input('client_id');
        $uniqueId = $request->input('unique_id');
        $serviceId = $request->input('service_id');
        $this->message = 'Record not found';
        $dataRequest = $request->all();
        $validations = [
            'client_id' => 'required|integer',
            'unique_id' => 'required',
            'service_id' => 'required|integer',
        ];
        $validator = \Validator::make($dataRequest, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $data['key_pairs'] = FinalPayment::select('u.id as user_id', 's.key_pair as key_pair', 's.id as service_id', 'final_payments.unique_id')
                ->where('final_payments.unique_id', '=', $uniqueId)
                ->join('users as u', 'u.id', '=', 'final_payments.user_id')
                ->join('service_bookings as sb', 'sb.user_id', '=', 'final_payments.user_id')
                ->join('services as s', 's.id', 'sb.service_id')
                ->get()->toArray();
            if (isset($data['key_pairs'][0])) {
                $userId = $data['key_pairs'][0]['user_id'];
                if (!empty($data['key_pairs'])) {
                    $services = array_column(Service::get()->toArray(), null, 'id');
                    $record = array_column($data['key_pairs'], null, 'service_id');

                    $data['Service'] = ServiceBooking::select('tp.name as Days_per_week', 'w.name as Duration', 'service_bookings.days_id',
                        'tp.id as training_plan_id', 'tp.days_value', 'w.id as week_id', 'w.name as week_name', 'sl.value as session_length',
                        'service_bookings.service_id', 'service_bookings.training_session_location', 'cp.name as change_training_plan',
                        DB::raw("DATE_FORMAT(service_bookings.starting_date, '%d/%m/%Y') as start_date")
                    )
                        ->where('user_id', $userId)
                        ->where('client_id', $clientId)
                        ->where('service_id', $serviceId)
                        ->where('unique_id', $uniqueId)
                        ->join('training_plans as tp', 'tp.id', 'service_bookings.training_plan_id')
                        ->join('week_programs as w', 'w.id', 'service_bookings.week_id')
                        ->leftjoin('training_coaching_session_lengths as sl', 'sl.id', 'service_bookings.session_length')
                        ->leftjoin('change_training_plans as cp', 'cp.id', 'service_bookings.change_training_plan_id')
                        ->orderby('service_id')
                        ->get()->toArray();

                    if (!empty($data['Service'])) {
                        foreach ($data['Service'] as $row) {
                            if (!empty($row['days_id'])) {
                                $days = explode(',', $row['days_id']);
                                sort($days);
                                foreach ($days as $dayId) {
                                    $data['days'][$dayId] = Day::where('id', $dayId)
                                        ->pluck('name')
                                        ->first();
                                }
                            }
                        }
                        $index = array_keys(array_column($data['Service'], null, 'service_id'));
                        foreach ($data['Service'] as $key => $row) {
                            if (!empty($record[$row['service_id']])) {
                                $data['Service'][$key]['user_id'] = $record[$row['service_id']]['user_id'];
                                $data['Service'][$key]['Program_name'] = $record[$row['service_id']]['key_pair'];
                                $weekValue = explode('-', $row['week_name'])[0];
                                $data['Service'][$key]['total_sessions'] = getTotalSessions($weekValue, $row['days_value']);
                            } else if (!empty($services[$row['service_id']])) {
                                $data['Service'][$key]['Program_name'] = $services[$row['service_id']]['key_pair'];
                                $weekValue = explode('-', $row['week_name'])[0];
                                $data['Service'][$key]['total_sessions'] = getTotalSessions($weekValue, $row['days_value']);
                            }
                        }
                        unset($data['key_pairs']);
                        $this->data = $data;
                        $this->success = true;
                        $this->message = '';
                    }
                }
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message]);
    }

    /**
     * this function is use to get clients reviews
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getClientReview(Request $request)
    {
        $clientId = $request->input('client_id');
        $dataRequest = $request->all();
        $validations = [
            'client_id' => 'integer|required',
        ];
        $validator = \Validator::make($dataRequest, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = RattingFreelanceAndZestlog::select('star_coach_and_program', 'experience_about_coach as review_text',
                'u.first_name','u.last_name','u.user_name','u.profile_pic_upload', 'u.id', 'unique_id', 'ratting_freelance_and_zestlogs.updated_at')
                ->where('client_id', $clientId)
                ->join('users as u', 'u.id', 'ratting_freelance_and_zestlogs.user_id')
                ->orderBy('ratting_freelance_and_zestlogs.created_at','desc')
                ->get()->toArray();
//            $obj = array_column($obj, null, 'id');
            $arrWeeksData = [];
            if ($obj) {
                foreach ($obj as $key => $row) {
                    $arrRatings = [];
                    $objServiceBooking = ServiceBooking::select('wp.name as week_name', 's.name as service_name','service_bookings.end_date')
                        ->where('service_bookings.user_id', $row['id'])
                        ->where('service_bookings.client_id', $clientId)
                        ->where('service_bookings.unique_id', $row['unique_id'])
                        ->join('week_programs as wp', 'wp.id', 'service_bookings.week_id')
                        ->join('final_payments as fp', 'fp.unique_id', 'service_bookings.unique_id')
                        ->join('services as s', 's.id', 'service_bookings.service_id')
                        ->where('fp.status',1)
                        ->get()->toArray();
                    foreach ($objServiceBooking as $index => $data) {
                        $arrRatings['first_name'] = $row['first_name'];
                        $arrRatings['last_name'] = $row['last_name'];
                        $arrRatings['user_name'] = $row['user_name'];
                        if (!empty($row['profile_pic_upload'])) {
                            $arrRatings['profile_pic_upload'] = asset(MobileUserImagePath) . '/' . $row['profile_pic_upload'];
                        } else {
                            $arrRatings['profile_pic_upload'] = '';
                        }
                        $arrRatings['coach_stars'] = $row['star_coach_and_program'];
                        $arrRatings['review_text'] = $row['review_text'];
                        $date = databaseDateFromat(currentDateTime());
                        $arrRatings['review_date'] = date_format(new \DateTime($row['updated_at']), 'd.M.Y');
                        if(strtotime($data['end_date']) >= strtotime($date)){
                            $arrRatings['status'] = 'ongoing';
                        }else{
                            $arrRatings['status'] = '';
                        }
                        $weeks = (explode(' ', $data['week_name'])[0]);
                        $preArr = [];
                        $preArr['service_name'] = $data['service_name'];
                        $preArr['no_of_week'] = $weeks;
                        $arrRatings['service'][] = $preArr;
                        $arrRatings[$index] =  $weeks. ' ' . $data['service_name'];

                    }
                    if (!empty($arrRatings))
                        $arrWeeksData[] = $arrRatings;
                }
                $this->success = true;
            }
            $this->data = $arrWeeksData;
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message]);
    }

    /**
     * this function is use to get already coaching and training program services details
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getPurchasedServices(Request $request)
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
            $obj = ServiceBooking::select('service_bookings.created_at as submission_date',
                'service_bookings.unique_id',
                'tcsl.value',
                'u.first_name','u.last_name','u.id',
                'u.profile_pic_upload as profile_image',
                'fp.status',
                'wp.meta_data','service_bookings.starting_date', 'service_bookings.service_id', 'fp.end_date')
                ->where('service_bookings.user_id',$this->userId)
                ->where(function($q) {
                    $q->where('service_id', 3)
                        ->orWhere('service_id', 4);
                })
                ->join('users as u','u.id','service_bookings.client_id')
                ->join('training_coaching_session_lengths as tcsl','tcsl.id','service_bookings.session_length')
                ->join('final_payments as fp','fp.unique_id','service_bookings.unique_id')
                ->join('week_programs as wp','wp.id','service_bookings.week_id')
//                ->groupBy('service_bookings.client_id')
                ->groupBy('fp.unique_id')
                ->where('fp.status','!=',2)
                ->get()->toArray();
            $trainingPlans = TrainingPlan::pluck('name', 'id')->toArray();
            foreach ($obj as $key =>$row) {
                $name = 'PastBooking';
               $objTrainingProgramSetup = TrainingProgramPriceSetup::where(['user_id' => $obj[$key]['id'], 'type' => $obj[$key]['service_id']])->first();
                $objPricingDiscount = PricingDiscount::where('training_program_price_setup_id', '=', $objTrainingProgramSetup->id)
                    ->where('type', '=', $obj[$key]['service_id'])
                    ->get()->toArray();
                foreach ($objPricingDiscount as $key1=>$row1)
                {
                    if ($row1['discount_type'] != 1)
                    {
                        $arr[$name][$key]['frequency'] = $trainingPlans[$row1['training_plan_id']];
                        $arr[$name][$key]['coaching_session'] = (int)explode(' ', $trainingPlans[$row1['training_plan_id']])[0];
                        if ($row1['training_plan_id'] == 9 || $row1['training_plan_id'] == 18) {
                            $arr[$name][$key]['session_in_week'] = 4;
                        } else if ($row1['training_plan_id'] == 10 || $row1['training_plan_id'] == 19) {
                            $arr[$name][$key]['session_in_week'] = 2;
                        } else {
                            $arr[$name][$key]['session_in_week'] = 1;
                        }
                    }
                }
                $arr[$name][$key]['client_id'] = $obj[$key]['id'];
                $arr[$name][$key]['unique_id'] = $obj[$key]['unique_id'];
                $arr[$name][$key]['first_name'] = $obj[$key]['first_name'];
                $arr[$name][$key]['last_name'] = $obj[$key]['last_name'];
                $arr[$name][$key]['submission_date'] = $obj[$key]['submission_date'];
                $arr[$name][$key]['service_id'] = $obj[$key]['service_id'];
                $arr[$name][$key]['length'] = $obj[$key]['value'];
                if (!empty($row['profile_image'])) {
                    $arr[$name][$key]['profile_image'] = asset(clientImagePath . '/' . $obj[$key]['profile_image']);
                } else {
                    $arr[$name][$key]['profile_image'] = null;
                }
                if (strtotime(currentDateTime()) > strtotime($row['end_date'])) {
                    $arr[$name][$key]['status'] = 'Completed';
                } else {
                    if ($row['status'] == 1) {
                        $arr[$name][$key]['status'] = 'Ongoing';
                    } else if ($row['status'] == 0) {
                        $arr[$name][$key]['status'] = 'Pending';
                    }
                }
            }
            if (empty($arr)) {
                $this->data['PastBooking'] = (array)[];
            } else {
                $this->data = (array)$arr;
            }
            $this->success = true;
        }

        return response()->json(['success' => $this->success,'data' => $this->data,'message' => $this->message]);
    }

    /**
     * this is used to get Rating details
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRatingDetails(Request $request)
    {
        $obj = PrivateReviewCategorie::get()->toArray();
        $arr = [];
        $obj = array_column($obj, null, 'id');
        $tempArr = [];
        $tempArray = [];
        $tempArryZestlog = [];
        foreach ($obj as $key => $row) {
            if ($row['type'] == 0) {
                $arr['id'] = $row['id'];
                $arr['Name'] = $row['name'];
                $tempArray[] = $arr;
            }
            if ($row['type'] == 1) {
                $arr['id'] = $row['id'];
                $arr['Name'] = $row['name'];
                $tempArryZestlog[] = $arr;
            }
        }
        $tempArr['coach_review'] = $tempArray;
        $tempArr['zestlog_review'] = $tempArryZestlog;
        $this->success = true;
        $this->data = $tempArr;

        return response()->json(['success' => $this->success, 'data' => $this->data]);
    }

}
