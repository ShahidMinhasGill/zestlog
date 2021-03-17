<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientCurrency;
use App\Models\Currency;
use App\Models\PricingDiscount;
use App\Models\RepeatProgramPurchase;
use App\Models\RepeatProgramPurchaseBooking;
use App\Models\Service;
use App\Models\ServiceAvailableBooking;
use App\Models\TrainingCoachingSession;
use App\Models\TrainingPlan;
use App\Models\TrainingProgramPrice;
use App\Models\TrainingProgramPriceSetup;
use App\Models\WeekProgram;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use App\Traits\ZestLogTrait;
use PhpParser\Node\Stmt\DeclareDeclare;
use PhpParser\Node\Stmt\Return_;
use function PHPSTORM_META\type;
use SebastianBergmann\Environment\Console;
use App\Models\TrainingCoachingSessionLength;
use App\Models\GroupOnlineCoaching;
use App\Models\TrainingSessionLocation;
use Illuminate\Support\Facades\DB;

class ServicesPricingController extends Controller
{
    use ZestLogTrait;

    /*
     * Display Service Pricing
     */
    public function index()
    {
        $clientId = \Auth::user()->id;
        $data = [];
        $data['dayName'] = TrainingPlan::all()->where('type', 1)->toArray();
        $data['services'] = Service::select('services.name', 'services.key_pair', 'services.id', 'sab.is_checked')
            ->leftJoin('service_available_bookings as sab', function ($join) use ($clientId) {
                $join->on('sab.service_id', '=', 'services.id');
                $join->where('sab.user_id', '=', $clientId);
            })
            ->orderBy('services.id', 'asc')->get()->toArray();
        $data['weekName'] = WeekProgram::all()->toArray();
        $repeatPurchase['repeatPurchaseBooking'] = RepeatProgramPurchase::all()->toArray();
        $training = $diet = $online = $personal = false;
        foreach ($data['services'] as $row) {
            if ($row['key_pair'] == 'training_program') {
                $training = $row['is_checked'];
            } else if ($row['key_pair'] == 'diet_program') {
                $diet = $row['is_checked'];
            } else if ($row['key_pair'] == 'online_coaching') {
                $online = $row['is_checked'];
            } else {
                $personal = $row['is_checked'];
            }
        }

        $addSelect = [''=>'select'];
        $objCurrency = $addSelect + Currency::pluck('code','id')->toArray();
        $objClientCurrency = ClientCurrency::select('currency_id')->where('client_id',$clientId)->first();
//        $objClientCurrency =  $this->getClientCurrency($clientId);
        RepeatProgramPurchaseBooking::where('user_id',loginId())->first();

        return view('client.servicesandprices.settings', compact('data', 'training', 'diet', 'online', 'personal','objCurrency','objClientCurrency'));
    }

    /**
     * This is used to save training price
     *
     * @param Request $request
     */
    public function saveProgramTrainingPrice(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->userId = loginId();
            $this->type = $request->input('type');
            $isDiscountCheck = $request->input('isDiscountCheck');
            $finalPricesList = $request->input('finalPrices');
            $basePrice = stringToDecimalConversion($request->input('basePrice'));
            $planData = $request->input('trainingPlanDiscounts');
            $isDiscountBaseCheck = $request->input('isDiscountBaseChecked');
            $weekDiscount = $request->input('trainingWeekDiscounts');
            $checkboxDayCheckedList = $request->input('checkboxDayCheckedList');
            $checkboxWeekCheckedList = $request->input('checkboxWeekCheckedList');
            $userId = loginId();
            $obj = TrainingProgramPriceSetup::where('user_id', '=', $userId)->where('type', '=', $this->type)->first();
            if (!$obj) {
                $obj = new TrainingProgramPriceSetup();
            }
            $obj->user_id = $userId;
            $obj->base_price = $basePrice;
            $obj->type = $this->type;
            $obj->is_auto_calculate_discount = $isDiscountBaseCheck;
            $obj->save();
            $id = $obj->id;
            $weekArray = [];
            $dayArray = [];
            foreach ($checkboxWeekCheckedList as $key => $checkedWeek) {
                if (isset($weekDiscount[$checkedWeek]) || $isDiscountCheck == 'false') {
                    $weekDiscountValue = $weekDiscount[$checkedWeek];
                    $weekArray[$checkedWeek]['discount'] = $weekDiscountValue;
                }
                $weekArray[$checkedWeek]['type'] = $this->type;
                $weekArray[$checkedWeek]['discount_type'] = 1;
                $weekArray[$checkedWeek]['training_program_price_setup_id'] = $id;
                $weekArray[$checkedWeek]['day_week_id'] = $checkedWeek;
                $weekArray[$checkedWeek]['is_checked'] = 1;
            }
            foreach ($checkboxDayCheckedList as $key => $checkedDays) {
                if (isset($planData[$checkedDays]) || $isDiscountCheck == 'false') {
                    $dayDiscountValue = $planData[$checkedDays];
                    $dayArray[$checkedDays]['discount'] = $dayDiscountValue;
                }
                $checkedDaysId = explode('_', $key);
                $dayArray[$checkedDays]['type'] = $this->type;
                $dayArray[$checkedDays]['discount_type'] = 2;
                $dayArray[$checkedDays]['training_program_price_setup_id'] = $id;
                $dayArray[$checkedDays]['training_plan_id'] = $checkedDaysId[1];
                $dayArray[$checkedDays]['day_week_id'] = $checkedDaysId[0];
                $dayArray[$checkedDays]['is_checked'] = 1;

            }
            $weekArray = array_values($weekArray);
            $dayArray = array_values($dayArray);
            $arrPrice = array_merge($weekArray, $dayArray);
            PricingDiscount::where('training_program_price_setup_id', '=', $id)->delete();
            $TrainingPrograme = TrainingProgramPriceSetup::find($id);
            $TrainingPrograme->prices()->createMany($arrPrice);
            $arr = [];
            TrainingProgramPrice::where('training_program_price_setup_id', '=', $id)->delete();
            foreach ($checkboxDayCheckedList as $daysId => $key) {
                $TrainingDayId = explode('_', $daysId)[1];
                $arr['final_price_1'] = (!empty($finalPricesList[$key . '_1'])) ? $finalPricesList[$key . '_1'] : 0;
                $arr['final_price_2'] = (!empty($finalPricesList[$key . '_2'])) ? $finalPricesList[$key . '_2'] : 0;
                $arr['final_price_3'] = (!empty($finalPricesList[$key . '_3'])) ? $finalPricesList[$key . '_3'] : 0;
                $arr['final_price_4'] = (!empty($finalPricesList[$key . '_4'])) ? $finalPricesList[$key . '_4'] : 0;
                $arr['final_price_5'] = (!empty($finalPricesList[$key . '_5'])) ? $finalPricesList[$key . '_5'] : 0;
                $arr['final_price_6'] = (!empty($finalPricesList[$key . '_6'])) ? $finalPricesList[$key . '_6'] : 0;
                $arr['final_price_7'] = (!empty($finalPricesList[$key . '_7'])) ? $finalPricesList[$key . '_7'] : 0;
                TrainingProgramPrice::updateorCreate(['training_program_price_setup_id' => $id, 'training_plan_id' => $TrainingDayId, 'type' => $this->type], $arr);
            }
            $this->isClientShow();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculatePrices(Request $request)
    {
        $this->userId = loginId();
        $this->type = $request->input('type');
        $basePrice = stringToDecimalConversion($request->input('basePrice'));
        $planData = $request->input('trainingPlanDiscounts');
        $weekDiscount = $request->input('trainingWeekDiscounts');
        if ($request->input('isDiscountCheck') == 'false') {
            if ($planData != [] && $weekDiscount != [] && $basePrice != '') {
                $arr = weeksName();
                foreach ($planData as $key => $row) {
                    foreach ($weekDiscount as $keydis => $week) {
                        if ($key == 250) {
                            $key = 0.25;
                        }
                        if ($key == 500) {
                            $key = 0.5;
                        }
                        $totalPlans = ($key * $arr[$keydis - 1]);
                        if ($key == 0.25) {
                            $key = 250;
                        }
                        if ($key == 0.5) {
                            $key = 500;
                        }
                        $finalPrice = $totalPlans * $basePrice;
                        $this->data[$keydis]['before_discount_' . $key . '_' . $keydis] = '---';
                        $this->data[$keydis]['total_discount_' . $key . '_' . $keydis] = '---';
                        $this->data[$keydis]['final_price_' . $key . '_' . $keydis] = roundValue($finalPrice, 1);
                    }
                }
            }
        } else {
            $this->calculateTrainingPrices($planData, $weekDiscount, $basePrice);
        }

        $this->success = true;


        return response()->json(['success' => $this->success, 'data' => $this->data]);
    }

    /*
     * calculate training Prices
     */
    public function calculateTrainingPrices($planData, $arrWeekDiscount, $basePrice)
    {
        if ($planData != [] && $arrWeekDiscount != [] && $basePrice != '') {
            $arr = weeksName();
            foreach ($planData as $key => $row) {
                foreach ($arrWeekDiscount as $keydis => $week) {
                    if ($key == 250) {
                        $key = 0.25;
                    }
                    if ($key == 500) {
                        $key = 0.5;
                    }
                    $totalPlans = ($key * $arr[$keydis - 1]);
                    if ($key == 0.25) {
                        $key = 250;
                    }
                    if ($key == 0.5) {
                        $key = 500;
                    }
                    $beforeDiscount = $basePrice * $totalPlans;
                    $totalDiscount = stringToDecimalConversion($row) + stringToDecimalConversion($arrWeekDiscount[$keydis]);
                    $finalPrice = $beforeDiscount - ($beforeDiscount * ($totalDiscount / 100));
                    $this->data[$keydis]['before_discount_' . $key . '_' . $keydis] = roundValue($beforeDiscount, 1);
                    $this->data[$keydis]['total_discount_' . $key . '_' . $keydis] = roundValue($totalDiscount, 1);
                    $this->data[$keydis]['final_price_' . $key . '_' . $keydis] = roundValue($finalPrice, 1);
                }
            }

        }

    }

    /**
     * This is used to save coaching session data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCoachingSession(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->input('data');
            $type = ($request->input('type')) ? 4 : 3;
            $keyIndex = $request->input('key');
            $keyVal = $request->input('keyVal');
            $obj = TrainingProgramPriceSetup::where('user_id', '=', loginId())->where('type', '=', $type)->first();
            $obj->$keyIndex = $keyVal;
            $obj->save();
            if (!empty($data)) {
                $record = [];
                foreach ($data as $key => $row) {
                    if ($row['name'] !== $keyIndex) {
                        $strSplit = explode('_', $row['name']);
                        $record[$strSplit[2]][$strSplit[0] . '_' . $strSplit[1]] = ($row['value'] == 'on') ? 1 : $row['value'];
                    }
                }
                foreach ($record as $key => $row) {
                    TrainingCoachingSession::updateorCreate(['training_program_price_setup_id' => $obj->id, 'session_length_id' => $key, 'type' => $type], $row);
                }
            }
            $this->success = true;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json(['success' => $this->success]);
    }

    /**
     * This is used to save group coaching session
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveGroupCoaching(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->input('data');
            $type = ($request->input('type')) ? 4 : 3;
            $keyIndex = $request->input('key');
            $keyVal = $request->input('keyVal');
            $obj = TrainingProgramPriceSetup::where('user_id', '=', loginId())->where('type', '=', $type)->first();
            $obj->$keyIndex = $keyVal;
            $obj->save();
            if (!empty($data)) {
                $record = [];
                foreach ($data as $key => $row) {
                    if ($row['name'] !== $keyIndex) {
                        $strSplit = explode('_', $row['name']);
                        $record[$strSplit[3]][$strSplit[1] . '_' . $strSplit[2]] = ($row['value'] == 'on') ? 1 : $row['value'];
                    }
                }
                foreach ($record as $key => $row) {
                    $row['type'] = $type;
                    GroupOnlineCoaching::updateorCreate(['id' => $key], $row);
                }
            }
            $this->success = true;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json(['success' => $this->success]);
    }

    /**
     * This is used to save pt locations
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function savePtLocations(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->userId = loginId();
            $data = $request->input('data');
            $keyIndex = $request->input('key');
            $keyVal = $request->input('keyVal');
            $obj = TrainingProgramPriceSetup::where('user_id', '=', $this->userId)->where('type', '=', 4)->first();
            $obj->$keyIndex = $keyVal;
            $obj->save();
            if (!empty($data)) {
                $record = [];
                foreach ($data as $key => $row) {
                    if ($row['name'] !== $keyIndex) {
                        $strSplit = explode('_', $row['name']);
                        $record[$strSplit[3]][$strSplit[1] . '_' . $strSplit[2]] = ($row['value'] == 'on') ? 1 : $row['value'];
                    }
                }
                foreach ($record as $key => $row) {
                    TrainingSessionLocation::updateorCreate(['id' => $key], $row);
                }
            }
            $this->success = true;
            $this->isClientShow();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json(['success' => $this->success]);
    }

    /**
     * This is used to add pt location
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function addPtLocations(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->userId = loginId();
            $obj = TrainingProgramPriceSetup::where('user_id', '=', $this->userId)->where('type', '=', 4)->first();
            $objLocation = new TrainingSessionLocation();
            $objLocation->training_program_price_setup_id = $obj->id;
            $objLocation->is_listing = 1;
            $objLocation->price_changed = 1;
            $objLocation->save();
            $ptSessionLocations = TrainingSessionLocation::where('id', '=', $objLocation->id)->get();
            $objCount = TrainingSessionLocation::where('training_program_price_setup_id', '=', $obj->id)->count();
            $this->isClientShow();

            $view = view('client.partials.setting-partials._common-pt-locations', compact('ptSessionLocations', 'objCount'))->render();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json(['success' => 'true', 'data' => $view]);
    }

    /**
     * This is used to delete pt locations
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyPtLocations(Request $request)
    {
        $this->userId = loginId();
        $id = $request->input('id');
        $splitId = explode('_', $id)[1];
        $obj = TrainingSessionLocation::find($splitId);
        $this->message = 'There is problem to delete Pt location sessions';
        if ($obj && $obj->delete()) {
            $this->isClientShow();
            $this->message = 'Pt location sessions is deleted successfully';
            $this->success = true;
        }

        return response()->json(['success' => $this->success, 'message' => $this->message, 'id' => $splitId]);
    }

    /**
     * This is used to render services program tab
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getServicesProgram(Request $request)
    {

        $id = $request->input('id');
        if ($id == 'nav-Training-program') {
            $view = '_training-program-pricing';
            $type = 1;
            $viewData = $this->getDiscountPrices($type,$view);
        } else if ($id == 'nav-diet-program') {
            $view = '_diet-program-pricing';
            $type = 2;
            $viewData = $this->getDiscountPrices($type,$view);
        } else if ($id == 'nav-coaching') {
            $view = '_online-coaching-pricing';
            $type = 3;
            $viewData = $this->getDiscountPrices($type,$view);
        } else if ($id == 'nav-p-training') {
            $view = '_personal-training-pricing';
            $type = 4;
            $viewData = $this->getDiscountPrices($type,$view);
        }

        return response()->json(['success' => true, 'id' => $request->input('id'), 'data' => $viewData]);
    }
    /**
     * calculate discounts
     *
     * @param $type
     * @param $view
     * @return array|string
     * @throws \Throwable
     */
    public function getDiscountPrices($type, $view)
    {
        $basePrice = $weekDiscounts = $dayDiscounts = $trainingData = $repeatPercentageValue = $repeatPurchase =[];
        $isAutoCalculateDiscount = $length_online_coaching_session = $group_online_coaching =
        $pt_session_location = $length_pt_session = $group_personal_training = 0;
        $objId = 0;
        $objRepeatBooking='';
        $obj = TrainingProgramPriceSetup::where('user_id', '=', loginId())->where('type', '=', $type)->first();
        if ($obj) {
            $basePrice['base_price'] = $obj->base_price;
            $basePrice['is_checked'] = $obj->is_auto_calculate_discount;
            $isAutoCalculateDiscount = $obj->is_auto_calculate_discount;
            $repeatPercentageValue['repeat_percentage_value'] = $obj->repeat_percentage_value;
            $repeatPercentageValue['is_use_default_week_repeat'] = $obj->is_use_default_week_repeat;
            $repeatPercentageValue['is_use_default_repeat_purchase_booking'] = $obj->is_use_default_repeat_purchase_booking;
            $repeatPercentageValue['is_use_default_length_program_booking'] = $obj->is_use_default_length_program_booking;
            $length_online_coaching_session = $obj->length_online_coaching_session;
            $group_online_coaching = $obj->group_online_coaching;
            $pt_session_location = $obj->pt_session_location;
            $length_pt_session = $obj->length_pt_session;
            $group_personal_training = $obj->group_personal_training;
            $objId = $obj->id;


            $arrBooking = [];
            $objRepeatBooking = RepeatProgramPurchaseBooking::select('discount_1', 'discount_2', 'discount_3',
                'discount_4', 'discount_5', 'discount_6')->where('user_id', loginId())
                ->where('training_program_price_setup_id', $objId)
                ->first();
            if($objRepeatBooking){
                $objRepeatBooking = $objRepeatBooking->toArray();
            }
        } else {
            $basePrice['base_price'] = '';
            $basePrice['is_checked'] = '1';
        }
        $data = PricingDiscount::where('training_program_price_setup_id', '=', $objId)
            ->where('type', '=', $type)->get()->toArray();
        if ($data) {
            foreach ($data as $row) {
                if ($row['discount_type'] == 1) {
                    $weekDiscounts[] = $row;
                } else {
                    $dayDiscounts[] = $row;
                }
            }
            $weekDiscounts = array_column($weekDiscounts, null, 'day_week_id');
            $dayDiscounts = array_column($dayDiscounts, null, 'day_week_id');

        }


        $trainingData = TrainingProgramPrice::where('training_program_price_setup_id', '=', $objId)->get()->toArray();
        if (!empty($trainingData)) {
            $trainingData = array_column($trainingData, null, 'training_plan_id');
        }
        $this->userId = loginId();
        $data = [];
        $data['dayName'] = TrainingPlan::where('type', $type)->get()->toArray();
        $data['weekName'] = WeekProgram::all()->toArray();

        $coachingSessions = $groupOnlineCoachings = $ptSessionLocations = [];
        if ($type == 3 || $type == 4) {
            $groupType = $type;
            if (empty($objId)) {
                $obj = new TrainingProgramPriceSetup();
                $obj->user_id = loginId();
                $obj->base_price = 0;
                $obj->type = $type;
                $obj->is_auto_calculate_discount = 0;
                $obj->save();
                $objId = $obj->id;
                $arr = [];
                for($i = 1; $i<=3;$i++) {
                    $arr[$i]['training_program_price_setup_id'] = $objId;
                    $arr[$i]['participant_count'] = $i;
                    $arr[$i]['type'] = $groupType;
                    $arr[$i]['is_listing'] = 1;
                    $arr[$i]['price_changed'] = 1;
                }
                $obj = new GroupOnlineCoaching();
                $obj->insert($arr);
            }
            $coachingSessions = TrainingCoachingSessionLength::select('training_coaching_session_lengths.value', 'training_coaching_session_lengths.id', 'tcs.id as tcs_id', 'tcs.is_listing',
                'tcs.price_changed', 'tcs.price_checked', 'tcs.rate_checked', 'tcs.price_up', 'tcs.price_down', 'tcs.rate_up', 'tcs.rate_down')
                 ->leftJoin('training_coaching_sessions as tcs', function ($join) use ($objId, $groupType) {
                    $join->on('training_coaching_session_lengths.id', '=', 'tcs.session_length_id');
                    $join->where(['tcs.training_program_price_setup_id' => $objId, 'tcs.type' => $groupType, 'training_coaching_session_lengths.type' => $groupType]);
                })->where(['training_coaching_session_lengths.type' => $groupType])
                ->orderBy('training_coaching_session_lengths.id', 'asc')->get();
//            $groupOnlineCoachings = GroupOnlineCoaching::where(['training_program_price_setup_id' => $objId, 'type' => $groupType])->get();
            if ($type == 4) {
                $ptSessionLocations = TrainingSessionLocation::where(['training_program_price_setup_id' => $objId])->get();
            }
        }
        $repeatPurchase['repeatPurchaseBooking'] = RepeatProgramPurchase::all()->toArray();
        Return view('client.partials.setting-partials.' . $view, compact('data', 'basePrice', 'dayDiscounts', 'weekDiscounts', 'trainingData',
            'isAutoCalculateDiscount', 'coachingSessions', 'groupOnlineCoachings', 'ptSessionLocations', 'length_online_coaching_session',
            'group_online_coaching', 'pt_session_location', 'length_pt_session', 'group_personal_training','objRepeatBooking',
            'repeatPercentageValue','repeatPurchase'))->render();
    }
    /*
     * Save Available Services Booking
     */
    public function saveServicesBooking(Request $request)
    {

        $userId = loginId();
        $id = $request->input('id');
        ServiceAvailableBooking::updateOrCreate(['user_id' => $userId, 'service_id' => $id], ['is_checked' => $request->input('is_checked')]);
        $this->userId = $userId;
        $this->isClientShow();
        $this->success = true;

        return response()->json(['success' => $this->success]);
    }

    /**
     * this is use to calculate training prices
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateTrainingPlanPrices(Request $request){
        $basePrice = $request->input('base_price');
        $daysId = $request->input('day_id');
        $arr = [];
        if ($daysId) {
            foreach ($daysId as $key => $row) {
                $arr['discount_' . $row] = $row * $basePrice;
            }
            $this->success = true;
        }
        $this->data = $arr;
        return response()->json(['success' => $this->success,'data'=>$this->data]);
    }

    /**
     * this is used to save training plan data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveTrainingPlanData(Request $request){
        try {
            DB::beginTransaction();
            $daysIds = $request->input('day_id');
            $weekIdValues = $request->input('week_id');
            $bookingIdValues = $request->input('booking_value');
            $repeatPercentage = $request->input('repeat_percentage');
            $isRepeatUseDefaultChecked = $request->input('is_default_checked_weekly_repeat');
            $isUseDefaultCheckedLengthProgram = $request->input('is_default_checked_length_program');
            $isUseDefaultCheckedRepeatProgram = $request->input('is_default_checked_repeat_program');
            $userId = loginId();
            $this->userId = $userId;
            $this->type = 1; // for training program
            $basePrice = stringToDecimalConversion($request->input('base_price'));
            $obj = TrainingProgramPriceSetup::where('user_id', '=', $userId)->where('type', '=', $this->type)->first();
            if (!$obj) {
                $obj = new TrainingProgramPriceSetup();
            }
            $obj->user_id = $userId;
            $obj->repeat_percentage_value = $repeatPercentage;
            $obj->is_use_default_week_repeat = $isRepeatUseDefaultChecked;
            $obj->is_use_default_length_program_booking = $isUseDefaultCheckedLengthProgram;;
            $obj->is_use_default_repeat_purchase_booking = $isUseDefaultCheckedRepeatProgram;;
            $obj->base_price = $basePrice;
            $obj->type = $this->type;
            $obj->save();
            // this is used to check whether we will show client on mobile side or not
            $this->isClientShow();
            $id = $obj->id;
            $weekArray = [];
            $dayArray = [];
            if (!empty($weekIdValues)) {
                foreach ($weekIdValues as $key => $weekData) {
                    $weekArray[$key]['discount'] = $weekData;
                    $weekArray[$key]['type'] = $this->type;
                    $weekArray[$key]['discount_type'] = 1;
                    $weekArray[$key]['training_program_price_setup_ id'] = $id;
                    $weekArray[$key]['day_week_id'] = $key;
                    $weekArray[$key]['is_checked'] = 1;
                }
            }
            if (!empty($daysIds)) {
                foreach ($daysIds as $key => $daysData) {
                    $dayArray[$key]['discount'] = $daysData;
                    $dayArray[$key]['type'] = $this->type;
                    $dayArray[$key]['discount_type'] = 2;
                    $dayArray[$key]['training_program_price_setup_id'] = $id;
                    $dayArray[$key]['training_plan_id'] = $key;
                    $dayArray[$key]['day_week_id'] = $key;
                    $dayArray[$key]['is_checked'] = 1;
                }
            }
            $weekArray = array_values($weekArray);
            $dayArray = array_values($dayArray);
            $arrPrice = array_merge($weekArray, $dayArray);
            PricingDiscount::where('training_program_price_setup_id', '=', $id)->delete();
            $TrainingPrograme = TrainingProgramPriceSetup::find($id);
            $TrainingPrograme->prices()->createMany($arrPrice);
            $arrBooking = [];
            if (!empty($bookingIdValues)) {
                foreach ($bookingIdValues as $key => $bookingdata) {
                    $arrBooking['discount_' . $key] = $bookingdata;
                }
                $arrBooking['type'] = $this->type;
                $arrBooking['user_id'] = $userId;
                RepeatProgramPurchaseBooking::updateorCreate([
                    'training_program_price_setup_id' => $id
                ], $arrBooking);
            }
            $this->message = 'data save successfully';
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json(['success' => true]);
    }

    public function saveClientCurrency(Request $request)
    {
        $userId = loginId();
        ClientCurrency::updateOrCreate(['client_id' => $userId,], ['currency_id' => $request->input('currency_id')]);
        $this->success = true;

        return response()->json(['success' => $this->success]);
    }
}
