<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AgeCategory;
use App\Models\Booking;
use App\Models\Client\ClientPlanTrainingComment;
use App\Models\Client\ClientPlanWeekTrainingSetupPosition;
use App\Models\Client\ClientTempTrainingSetup;
use App\Models\Client\ClientWeekPlan;
use App\Models\Client\PlanDragDropStructure;
use App\Models\ClientCurrency;
use App\Models\ClientPlan;
use App\Models\ClientSelectedEquipment;
use App\Models\Day;
use App\Models\Duration;
use App\Models\Exercise;
use App\Models\FinalPayment;
use App\Models\Form;
use App\Models\Note;
use App\Models\Plan;
use App\Models\RattingFreelanceAndZestlog;
use App\Models\RefundAmountDetail;
use App\Models\RefundPayment;
use App\Models\Rep;
use App\Models\Rest;
use App\Models\Rm;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Models\Set;
use App\Models\Stage;
use App\Models\Tempo;
use App\Models\TempTrainingSetup;
use App\Models\TrainingProgramPrice;
use App\Models\TrainingProgramPriceSetup;
use App\Models\Wr;
use App\User;
use function Composer\Autoload\includeFile;
use DateInterval;
use DatePeriod;
use DateTime;
use Edujugon\PushNotification\Facades\PushNotification;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\DeclareDeclare;
use PragmaRX\Countries\Package\Countries;
use App\Traits\ZestLogTrait;
use App\Models\WorkoutTypeSet;
use App\Models\Client\PlanTrainingOverviewWeek;
use App\Models\Client\PlanWeekTrainingSetup;
use App\Models\DayPlan;
use App\Models\BodyPart;
use App\Models\Goal;
use App\Models\Equipment;
use App\Models\TrainingPlanStructure;

class ClientsController extends Controller
{
    use ZestLogTrait;
    /**
     * this is used to display clients data
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $id = \Auth::user()->id;
        $c = new Countries();
        $allCountries = $c->all();
        $countries = [
            '' => 'Select'
        ];
        foreach ($allCountries as $country) {
            $countries[$country->cca3] = $country->name->common;
        }
        $cities = ['' => 'Select'];
        $this->data['endUser'] = User::find($id);
        $age = ['' => 'All'] + AgeCategory::pluck('name', 'id')->toArray();

        $this->getUserId();
        $this->isEquipmentEmptySelect = false;
        $this->isEmptySelect = true;
        $this->getPlanFilters();
        $this->isEmptyAll = true;
        $this->isEmptySelect = false;
        $this->getExerciseFilter();
//        $this->getClientEquipmentDropDown($uniqueId);
        $workoutTypeSet = WorkoutTypeSet::pluck('set_exercises', 'key_value')->toArray();
        $this->data['workoutTypeSet'] = json_encode($workoutTypeSet);
        $startProgramDate = '1';
        $endProgramDate = '1';
        $this->isEmptyAll = true;
        $this->getPlanFilters();
        $data = $this->data;

        return view('client.clients', compact( 'countries', 'cities','data','age'));
    }

    /**
     * This is used to store/get overview data against plan id
     *
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|View
     */
    public function overViewStore(Request $request, $id = NULL)
    {
        try {
            DB::beginTransaction();
            if ($request->isMethod('get')) {
                $completeId = explode('-', $id);
                $id = $completeId[0];
                $unique_Id = $completeId[1];
                $this->isEmptySelect = true;
                $this->emptySelect();
                $data["days"] = Day::pluck('name', 'id')->toArray();
                $data['day_plans'] = DayPlan::pluck('name', 'id')->toArray();
                $data['body_parts'] = $this->emptySelect + BodyPart::pluck('name', 'id')->toArray();
                $overview['body_part_1'] = PlanTrainingOverviewWeek::plans($id)->pluck('body_part_1', 'day_id')->toArray();
                $overview['body_part_2'] = PlanTrainingOverviewWeek::plans($id)->pluck('body_part_2', 'day_id')->toArray();
                $overview['body_part_3'] = PlanTrainingOverviewWeek::plans($id)->pluck('body_part_3', 'day_id')->toArray();
                $overview['day_plan'] = PlanTrainingOverviewWeek::plans($id)->pluck('day_plan_id', 'day_id')->toArray();

                $objServiceBooking = ServiceBooking::select('days_id')->where('unique_id', $unique_Id)
                    ->where('service_id', 1)// for training program
                    ->first();
                if (!empty($objServiceBooking)) {
                    $objServiceBooking = $objServiceBooking->toArray();
                    if (isset($objServiceBooking['days_id'])) {
                        $daysIds = explode(',', $objServiceBooking['days_id']);
                        foreach ($daysIds as $key => $row) {
                            $arr[$row] = $row;
                        }
                    }
                }
                if(!isLightVersion()){
                    unset($data['day_plans'][1]);
                    $data['daysIds'] = $arr;
                }

                return view('client.overview-content', compact('data', 'overview'));
            }
            $uniqueId = $request->input('unique_id');
            $weekId = $request->input('week_id');
            $obj = ServiceBooking::select('user_id', 'client_id', 'starting_date')
                ->where('unique_id', $uniqueId)
                ->first();
            $date = new DateTime($obj->starting_date);
            $year = $date->format("Y");
            if ($obj) {
                $clientObj = ClientPlan::updateorCreate(
                    [
                        'user_id' => $obj->user_id,
                        'client_id' => $obj->client_id,
                        'unique_id' => $uniqueId,
                        'week_id' => $weekId,
                        'year' => $year
                    ]
                );
            }
//        $this->planId = $request->client_plan_id; // older
            if ($clientObj) {
                $this->planId = $clientObj->id;

                foreach ($request->day_plan_id as $key => $dayPlan) {
                    $this->dayId = $key;
                    $data['day_plan_id'] = $dayPlan;
                    $data['body_part_1'] = $request->body_part_1[$key] ?? NULL;
                    $data['body_part_2'] = $request->body_part_2[$key] ?? NULL;
                    $data['body_part_3'] = $request->body_part_3[$key] ?? NULL;
                    $obj = PlanTrainingOverviewWeek::updateorCreate(['client_plan_id' => $this->planId, 'day_id' => $this->dayId], $data);

                    $record = [];
                    $record['warm_up'] = 1;
                    $record['cool_down'] = 1;
                    $record['is_main_workout_top'] = 1;
                    $record['client_plan_training_overview_week_id'] = $obj->id;
                    PlanWeekTrainingSetup::updateOrCreate(['client_plan_id' => $this->planId, 'day_id' => $this->dayId], $record);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json(['status' => 200, 'id' => $this->planId]);
    }

    /**
     * This is used to show week training plan setup and add weekly plan
     *
     * @param Request $request
     * @param null $plan_id
     * @param null $day_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|View
     */
    public function TabContent(Request $request, $client_plan_id = NULL, $day_id = null)
    {
        $this->getDayPlanId();
        if ($request->isMethod('get')) {
            $plan = ClientPlan::find($client_plan_id);
            $days_data = Day::find($day_id)->name;
            $data = PlanWeekTrainingSetup::planSetup($client_plan_id, $day_id)->first();
            $isMainWorkoutTop = (isset($data->is_main_workout_top)) ? $data->is_main_workout_top : 1;
            $view = view('client.plan.tab-content', compact('days_data', 'plan', 'day_id', 'data', 'isMainWorkoutTop'))->render();

            return response()->json(['view' => $view, 'isMainWorkoutTop' => $isMainWorkoutTop]);
        }
        $planOverview = PlanTrainingOverviewWeek::planOverView($request->plan_id, $request->day_id)->first();
        if (!empty($planOverview)) {
            if ($planOverview->day_plan_id != $this->dayPlanId) {
                $this->message = 'First please select day plan as training';
            } else {
                $this->data['warm_up'] = 1;
                $this->data['cardio'] = $request->has('cardio') ? 1 : 0;
                $this->data['cool_down'] = 1;
                $this->data['main_workout'] = $request->has('main_workout') ? 1 : 0;
                $this->data['is_main_workout_top'] = $request->input('is_main_workout_top');
                $this->data['client_plan_training_overview_week_id'] = $planOverview->id;
                PlanWeekTrainingSetup::updateOrCreate(['client_plan_id' => $request->plan_id, 'day_id' => $request->day_id], $this->data);
                $this->success = true;
            }
        } else {
            $this->message = 'Please add/apply overview before add training plan structure';
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * This is used to get weekly training plan setup
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function planWeeklyTrainingSetup(Request $request)
    {
        $weekIncremnetValue = $request->input('week_increment_value');
        if(isLightVersion() && empty($weekIncremnetValue)){
           $weekIncremnetValue = 1;
        }
        $year = (int)$request->input('year');
        $weekId = $request->input('weekId');
        $uniqueId = $request->input('unique_id');
        $weekEnd = ((int)$weekIncremnetValue + (int)$weekId);
        $totalWeekInYear = $this->getIsoWeeksInYear($year);
        $objClient = ClientPlan::where(
            [
                'user_id' => (int)$request->input('user_id'),
                'client_id' => (int)$request->input('client_id'),
                'unique_id' => $uniqueId,
                'week_id' => $weekId,
                'year' => (int)$request->input('year')
            ]
        )->first();
        $id = 0;
        if($objClient){
            $id = $objClient->id;
        }
        $days = Day::pluck('name', 'id');
        $data = TrainingPlanStructure::pluck('name', 'id')->toArray();
        $this->getDayPlanId();
        $workoutSetupTypes = ['' => 'Select'] + WorkoutTypeSet::pluck('name', 'key_value')->toArray();
        $planStructures = [];
        foreach ($data as $key => $row) {
            $planStructures[$key]['name'] = $row;
            $planStructures[$key]['id'] = $key;
            $planStructures[$key]['id'] = $key;
            $planStructures[$key]['columns'] = getTrainingPlanSetupColumns($key);
        }
        foreach ($days as $key => $row) {
            $obj = PlanTrainingOverviewWeek::select('day_plan_id', 'pwts.warm_up', 'pwts.main_workout', 'pwts.cardio', 'pwts.cool_down', 'pwts.is_main_workout_top', 'body_part_1', 'body_part_2', 'body_part_3')
                ->Join('client_plan_week_training_setups as pwts', function($join) {
                    $join->on('pwts.client_plan_training_overview_week_id', '=', 'client_plan_training_overview_weeks.id');
                })
                ->where('client_plan_training_overview_weeks.client_plan_id', '=', $id)
                ->where('client_plan_training_overview_weeks.day_id','=',$key)
                ->where('client_plan_training_overview_weeks.day_plan_id', '=', $this->dayPlanId)
                ->first();
            $dayPlan = $bodyPart = $metaDescription = $dayPlanId = '';
            $isRest = false;
            if ($obj) {
                $dayPlan = DayPlan::find($obj->day_plan_id)->name;
                $dayPlanId = DayPlan::find($obj->day_plan_id)->id;
                $arrBodyParts = BodyPart::select('name')->whereIn('id', [$obj->body_part_1, $obj->body_part_2, $obj->body_part_3])->get();
                if ($arrBodyParts) {
                    foreach ($arrBodyParts as $index => $part) {
                        if ($index)
                            $bodyPart .= ', ';
                        $bodyPart .= $part->name;
                    }
                }
            } else {
                $objPlan = PlanTrainingOverviewWeek::select('dp.name', 'dp.meta_description', 'key_value')
                    ->join('day_plans as dp', 'dp.id', '=', 'day_plan_id')
                    ->where('client_plan_training_overview_weeks.client_plan_id', '=', $id)->where('client_plan_training_overview_weeks.day_id', '=', $key)
                    ->first();
                if ($objPlan) {
                    $dayPlan = $objPlan->name;
                    if (isRestOrActiveRest($objPlan->key_value)) {
                        $metaDescription = $objPlan->meta_description;
                        $isRest = true;
                    }
                }
            }

            $this->data[$key]['meta_description'] = $metaDescription;
            $this->data[$key]['is_rest'] = $isRest;
            $this->data[$key]['day_name'] = $row;
            $this->data[$key]['day_id'] = $key;
            $this->data[$key]['day_plan'] = $dayPlan;
            $this->data[$key]['day_plan_id'] = $dayPlanId;
            $this->data[$key]['body_parts'] = $bodyPart;
            $this->data[$key]['warm_up'] = (!empty($obj->warm_up)) ? $obj->warm_up : 0;
            $this->data[$key]['main_workout'] = (!empty($obj->main_workout)) ? $obj->main_workout : 0;
            $this->data[$key]['cardio'] = (!empty($obj->cardio)) ? $obj->cardio : 0;
            $this->data[$key]['cool_down'] = (!empty($obj->cool_down)) ? $obj->cool_down : 0;
            $this->data[$key]['is_main_workout_top'] = (isset($obj->is_main_workout_top)) ? $obj->is_main_workout_top : 1;
            $this->data[$key]['workoutSetupTypes'] = $workoutSetupTypes;
            $planStructuresData = $planStructures;
            if (empty($this->data[$key]['is_main_workout_top']))
                [$planStructuresData[2], $planStructuresData[3]] = [$planStructuresData[3], $planStructuresData[2]];
            $this->data[$key]['plan_structures'] = $planStructuresData;
            $arr = [];
            $objServiceBooking = ServiceBooking::select('days_id')->where('unique_id', $uniqueId)
                ->where('service_id', 1)// for training program
                ->first();

            if (!empty($objServiceBooking)) {
                $objServiceBooking = $objServiceBooking->toArray();
                if (isset($objServiceBooking['days_id'])) {
                    $daysIds = explode(',', $objServiceBooking['days_id']);
                    foreach ($daysIds as $key => $row) {
                        $arr[$row] = $row;
                    }
                }
            }
            $days = $arr;
        }
        $weekDates = getStartAndEndDate($weekId,$year);
        $this->success = true;
        $view = view('client.plan.partials._weekly-training-plan', ['data' => $this->data,'days'=>$days,'weekDates'=>$weekDates])->render();

        $result = [];
        $result['days'] = Day::pluck('name', 'id')->toArray();
//        $viewPopup = view('client.plan.partials._training-plan-popup', ['data' => $result])->render();

        $isPublishPlan = 0;
        if(!empty($objClient)){
            $isPublishPlan = $objClient->is_publish;
        }


        return response()->json(['success' => $this->success, 'data' => $view, 'message' => $this->message, 'id' => $id, 'is_publish' => $isPublishPlan], $this->statusCode);
    }

    /**
     * This is used to get drag and drop options
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getPlanDragDropOptions(Request $request)
    {
        $coachId  = loginId();
        $extraId = explode('_', $request->input('extraId'));
        $dayId = $extraId[0];
        $this->structureId = $extraId[1];
        $view = '_drag_drop_box';
        $arr['c_option']  = 'Add a new option';
        $this->data['sets'] = Set::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
        $this->data['reps'] = Rep::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
        $this->data['durations'] = Duration::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
        $countRow = $mainCounter = 1;
        $this->planId = $request->input('id');
        $objTempTraining = [];
        if ($this->structureId != 2) {
            $objTempTraining = ClientTempTrainingSetup::where(['client_plan_id' => $this->planId, 'day_id' => $dayId, 'structure_id' => $this->structureId])->orderBy('position', 'asc')->get();
            if (!empty($request->input('is_new'))) {
                $position = $counter = 1;
                if (count($objTempTraining)) {
                    $position = ClientTempTrainingSetup::where(['client_plan_id' => $this->planId, 'day_id' => $dayId, 'structure_id' => $this->structureId])->max('position') + 1;
                    $counter = ClientTempTrainingSetup::where(['client_plan_id' => $this->planId, 'day_id' => $dayId, 'structure_id' => $this->structureId])->max('workout_main_counter') + 1;
                }
                $objNew = ClientTempTrainingSetup::create(['client_plan_id' => $this->planId, 'day_id' => $dayId, 'structure_id' => $this->structureId, 'workout_main_counter' => $counter, 'position' => $position]);
                $objTempTraining = ClientTempTrainingSetup::where('id', '=', $objNew->id)->get();
            }
        }
        if ($this->structureId == 2) {
            $view = '_drag_drop_box_main_workout';
            $this->data['rms'] = Rm::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
            $this->data['tempos'] = Tempo::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
            $this->data['rests'] = Rest::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
            $objPlanWeekTrainingSetup = PlanWeekTrainingSetup::where('client_plan_id', '=', $this->planId)->where('day_id', '=', $dayId)->first();
            $this->data['training_setup'] = $objPlanWeekTrainingSetup;
            $this->params['id'] = $objPlanWeekTrainingSetup->id;
            $this->data['training_setup_position'] = ClientPlanWeekTrainingSetupPosition::getTrainingSetupData($this->params);
        } else if ($this->structureId == 3) {
            $view = '_drag_drop_box_cardio';
            $this->data['forms'] = Form::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
            $this->data['stages'] = Stage::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
            $this->data['wrs'] = Wr::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
        } else {
            $this->data['notes'] = Note::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
        }
        $this->data['extraId'] = $request->input('extraId');
        $this->data['countRow'] = $countRow;
        $this->data['isClientPlan'] = true;
        $this->data['objTempTraining'] = $objTempTraining;
        $this->data['planId'] = $this->planId;
        $this->data['isNew'] = $request->input('is_new');
        $this->data['structureId'] = $this->structureId;
        $this->success = true;
        $view = view('client.plan.partials.' . $view, $this->data)->render();

        return response()->json(['success' => $this->success, 'data' => $view, 'message' => $this->message, 'countRow' => $mainCounter, 'extraId' => $request->input('extraId')], $this->statusCode);
    }

    /**
     * this is used to get Mobile users data using AJAX
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getClientsData(Request $request){
        $this->params = [
            'perPage' => 100,
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'sortColumn' => $request->input('sortColumn'),
            'sortType' => $request->input('sortType'),
            'dropDownFilters' => $request->input('dropDownFilters'),
            'action_freelance' => $request->input('action_freelance'),
            'accountRegDate'=>$request->input('accountRegDate'),
            'bmi'=>$request->input('bmi'),
            'userName'=>$request->input('userName'),
            'bookingSubmission'=>$request->input('bookingSubmission'),
        ];
        $data = User::getClientsData($this->params);
        return response()->json($data);
    }

    /**
     * This is used to show accept or reject popup
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function acceptRejectBooking(Request $request)
    {
        $clientId = \Auth::user()->id;
        $uniqueId = $request->input('id');
        $userId =0;
        $data['key_pairs'] = FinalPayment::select('u.id as user_id','s.key_pair as key_pair',
            's.id as service_id','final_payments.unique_id','final_payments.client_f_amount')
            ->where('final_payments.unique_id', '=',$request->input('id'))
            ->join('users as u', 'u.id', '=', 'final_payments.user_id')
            ->join('service_bookings as sb', 'sb.user_id', '=', 'final_payments.user_id')
            ->join('services as s', 's.id', 'sb.service_id')
            ->get()->toArray();
        if(isset($data['key_pairs'][0])){
            $userId = $data['key_pairs'][0]['user_id'];

            if (!empty($data['key_pairs'])) {
                $data['unique_id'] = $uniqueId;
                $data['personalInformation'] = User::select('users.first_name','last_name', 'users.gender', 'users.bmi', 'users.waist', 'users.more_info', 'users.additional_details', 'users.birthday', 'ta.name as training_age', 'g.name as goal')
                    ->where('users.id', $userId)
                    ->leftjoin('goals as g', 'g.id', 'users.goal_id')
                    ->leftjoin('training_ages as ta', 'ta.id', 'users.training_age_id')
                    ->first();
                $obj = User::where('id', $userId)->first();
                $age = $obj->getAgeAttribute();
                $data['age'] = $age;
            }
            if (!empty($data['key_pairs'])) {
                $services = array_column(Service::get()->toArray(), null, 'id');
                $record = array_column($data['key_pairs'], null, 'service_id');
                $data['bookingDuration'] = ServiceBooking::select('tp.name as training_plan', 'w.name as week', 'service_bookings.days_id',
                    'tp.id as training_plan_id','tp.days_value', 'w.id as week_id','w.name as week_name', 'sl.value as session_length',
                    'service_bookings.service_id', 'service_bookings.training_session_location','cp.name as change_training_plan','service_bookings.starting_date')
                    ->where('user_id', $userId)
                    ->where('client_id', $clientId)
                    ->where('unique_id',$request->input('id'))
                    ->join('training_plans as tp', 'tp.id', 'service_bookings.training_plan_id')
                    ->join('week_programs as w', 'w.id', 'service_bookings.week_id')
                    ->leftjoin('training_coaching_session_lengths as sl', 'sl.id', 'service_bookings.session_length')
                    ->leftjoin('change_training_plans as cp', 'cp.id', 'service_bookings.change_training_plan_id')
                    ->orderby('service_id')
                    ->get()->toArray();
                foreach ($data['bookingDuration'] as $row) {
                    if (!empty($row['days_id'])) {
                        $days = explode(',', $row['days_id']);
                        $sortedDays = [];
                        foreach ($days as $dayId) {
                            $sortedDays[$dayId] = Day::where('id', $dayId)
                                ->pluck('name')
                                ->first();
                        }
                        ksort($sortedDays);
                        $data['days'] = $sortedDays;
                    }
                }
                $index = array_keys(array_column($data['bookingDuration'], null, 'service_id'));
                foreach ($data['bookingDuration'] as $key => $row) {
                    if (!empty($record[$row['service_id']])) {
                        $data['bookingDuration'][$key]['user_id'] = $record[$row['service_id']]['user_id'];
                        $data['bookingDuration'][$key]['key_pair'] = $record[$row['service_id']]['key_pair'];
                        $weekValue = explode('-',$row['week_name'])[0];
                        $data['bookingDuration'][$key]['total_sessions']= getTotalSessions($weekValue,$row['days_value']);
                    } else if(!empty($services[$row['service_id']])) {
                        $data['bookingDuration'][$key]['key_pair'] = $services[$row['service_id']]['key_pair'];
                        $weekValue = explode('-',$row['week_name'])[0];
                        $data['bookingDuration'][$key]['total_sessions']= getTotalSessions($weekValue,$row['days_value']);
                    }
                }
                $value = 0;
                $clientAmount = FinalPayment::select('client_f_amount')->where('unique_id',$uniqueId)->first();
                if(!empty($clientAmount)){
                    $value = $clientAmount->client_f_amount;
                }
                $data['finalPrice'] = roundValue($value,2);
            }
        }
        $equipments = ClientSelectedEquipment::select('equipment_id')
            ->where('client_id', $clientId)
            ->where('unique_id', $uniqueId)
            ->first();
        $equipmentIds = [];
        if (!empty($equipments)) {
            $equipments = $equipments->toArray();
            $equipmentIds = explode(',', $equipments['equipment_id']);
        }
        $arrEquipemntsName = [];
        $countEquipments = Equipment::count();
        if ($countEquipments != count($equipmentIds)) {
            if (!empty($equipmentIds)) {
                foreach ($equipmentIds as $row) {
                    $arrEquipemntsName[] = Equipment::find($row)->name;
                }
            }
        } else {
            $arrEquipemntsName[] = 'Almost all (I have access to a gym)';
        }
        $objClientCurrency = $this->getClientCurrency($clientId);

        $view = view('client.partials._accept-reject-booking', compact('data','objClientCurrency','arrEquipemntsName'))->render();

        return response()->json(['success' => true, 'message' => '', 'view' => $view]);
    }

    /**
     * this is used to accept booking
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookingConfirmation(Request $request)
    {
        $uniqueId = $request->input('id');
        $isRequestAccept = $request->input('isRequestAccept');
        $finalPrice = $request->input('finalPrice');
        $totalAmount = $finalPrice;
        try {
            DB::beginTransaction();
            $objUser = FinalPayment::select('u.device_token', 'u.id','total_amount','total_price','client_id')
                ->where('final_payments.unique_id', '=', $uniqueId)
                ->join('users as u', 'u.id', '=', 'final_payments.user_id')->first();
            if (!empty($objUser))
                $totalAmount = $objUser->total_amount;
            if ($isRequestAccept == 'true') {
                DB::table('bookings')
                    ->where('unique_id', $uniqueId)
                    ->update(['status' => 1]);
                DB::table('final_payments')
                    ->where('unique_id', $uniqueId)
                    ->update(['status' => 1]);

                if(!isLightVersion()){
                    DB::table('users')
                        ->where('id', $objUser->id)
                        ->update(['total_spending' => DB::raw('total_spending +' . $objUser->total_amount)]);
                    DB::table('users')
                        ->where('id', $objUser->client_id)
                        ->update(
                            [
                                'total_earning' => DB::raw('total_earning +' . $objUser->total_price),
                                'total_earning_with_fee' => DB::raw('total_earning_with_fee +' . $objUser->total_amount)
                            ]
                        );
                }
                $this->message = 'Booking accept successfully';
                $this->notificationMessage = 'Congratulation. ' . loginName() . ' accepted your booking. Your first program will soon be published.';
            } else {
                $isRefund = 0;
                DB::table('bookings')
                    ->where('unique_id', $uniqueId)
                    ->update([
                        'status' => 2,
                        'is_payment' => 2
                    ]);
                RefundPayment::updateorCreate(
                    ['unique_id' => $uniqueId],
                    ['payment_amount' => $totalAmount,
                        'reject_date' => currentDateTime()
                    ]);
                Booking::where('unique_id', $uniqueId)->delete();
                RattingFreelanceAndZestlog::where('unique_id', $uniqueId)->delete();
                User::where('id',loginId())->increment('total_rejected_bookings');
                $objFinalPayment = FinalPayment::select('charge_id', 'is_refund')->where('unique_id', $uniqueId)->first();
                if (!empty($objFinalPayment['charge_id']) && $objFinalPayment['is_refund'] == 0) {
                    $stripe = new \Stripe\StripeClient(
                        getenv('STRIPE_KEY')
                    );
                    $refundResponse = $stripe->refunds->create([
                        'charge' => $objFinalPayment['charge_id'],
                    ]);
                    if ($refundResponse->status == 'succeeded') {
                        $isRefund = 1;
                        RefundAmountDetail::updateOrCreate([
                            'unique_id' => $uniqueId,
                        ], ['object' => $refundResponse['object'],
                                'amount' => $refundResponse['amount'],
                                'transfer_reversal' => $refundResponse['transfer_reversal'],
                                'source_transfer_reversal' => $refundResponse['source_transfer_reversal'],
                                'status' => $refundResponse['status'],
                                'receipt_number' => $refundResponse['receipt_number'],
                                'reason' => $refundResponse['reason'],
                                'payment_intent' => $refundResponse['payment_intent'],
                                'metadata' => $refundResponse['metadata'],
                                'currency' => $refundResponse['currency'],
                                'created' => $refundResponse['created'],
                                'charge' => $refundResponse['charge'],
                                'balance_transaction' => $refundResponse['balance_transaction'],
                                'strip_id' => $refundResponse['id'],
                            ]
                        );
                    }
                }
                DB::table('final_payments')
                    ->where('unique_id', $uniqueId)
                    ->update([
                        'status' => 2,
                        'is_payment' => 2,
                        'is_refund' => $isRefund
                    ]);

//            ServiceBooking::where('unique_id',$uniqueId)->delete();
                $this->message = 'Booking reject successfully';
                $this->notificationMessage = 'Unfortunately, ' . loginName() . ' rejected your booking. You can find a new personal coach';
            }


            if (!empty($objUser) && !empty($objUser->device_token)) {
                $arrPush = [];
                $arrPush['title'] = 'Booking';
                $arrPush['message'] = $this->notificationMessage;
                $arrPush['notification_message'] = $this->notificationMessage;
                $arrPush['device_token'] = $objUser->device_token;
                $arrPush['user_id'] = $objUser->id;
                $arrPush['notification_user_id'] = loginId();
                $this->sendPushNotifications($arrPush);
            }
            $this->success = true;
            DB::commit();
        } catch (\Stripe\Exception\CardException $e) {
            $this->success = false;
            DB::rollback();
        } catch (\Exception $e) {
            DB::rollback();
            $this->success = false;
            $this->message = $e->getMessage();
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }
    /**
     * This is used to add weekly training setup
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addWeeklyTrainingSetup(Request $request)
    {
        try {
            DB::beginTransaction();
            $sets = $request->input('set');
            $column = $request->input('set_type');
//            $setType = $column . '_' . 'set';
//            $exerciseType = $column . '_exercise_set';
            $workoutTypeSetId = WorkoutTypeSet::where('key_value', '=', $column)->first()->id;
            $obj = PlanWeekTrainingSetup::where(['client_plan_id' => $request->input('id'), 'day_id' => $request->input('day_id')])->first();
//            $obj->$setType = $sets;
//            $obj->$exerciseType = $request->input('exercise_set');
            $obj->save();
//            PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', '=', $obj->id)->where('workout_type_set_id', '=', $workoutTypeSetId)->delete();
            $objPositionCount = ClientPlanWeekTrainingSetupPosition::where('client_plan_week_training_setup_id', '=', $obj->id)->max('position');
            $workoutMainCount = ClientPlanWeekTrainingSetupPosition::where('client_plan_week_training_setup_id', '=', $obj->id)->where('workout_type_set_id', '=', $workoutTypeSetId)->max('workout_main_counter');
            if (empty($objPositionCount))
                $objPositionCount = 0;
            if(empty($workoutMainCount))
                $workoutMainCount = 0;
            for ($i = 1; $i <= $sets; $i++) {
                $objPositionCount = $objPositionCount + 1;
                $workoutMainCount++;
                $this->data[$i - 1]['client_plan_week_training_setup_id'] = $obj->id;
                $this->data[$i - 1]['workout_type_set_id'] = $workoutTypeSetId;
                $this->data[$i - 1]['workout_main_counter'] = $workoutMainCount;
                $this->data[$i - 1]['exercise_set'] = $request->input('exercise_set');
                $this->data[$i - 1]['position'] = $objPositionCount;
                $this->data[$i - 1]['created_at'] = currentDateTime();
                $this->data[$i - 1]['updated_at'] = currentDateTime();
            }
            ClientPlanWeekTrainingSetupPosition::insert($this->data);
            $this->success = true;
            $this->message = 'Record is updated successfully';
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
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }
    /**
     * This is used to delete training plan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTrainingPlan(Request $request)
    {
        $deleteId = explode('_', $request->input('deleteId'));
        try {
            if (!empty($deleteId)) {
                DB::beginTransaction();
                $this->dayId = $deleteId[0];
                $this->structureId = $deleteId[1];
                $countRow = $deleteId[2];
                $this->planId = $request->input('id');
                $obj = PlanDragDropStructure::where(['client_plan_id' => $this->planId, 'day_id' => $this->dayId,
                    'structure_id' => $this->structureId, 'workout_counter' => $countRow
                ])->first();
                if ($obj) {
                    $obj->delete();
                }
                $objTemp = ClientTempTrainingSetup::where(['client_plan_id' => $this->planId, 'day_id' => $this->dayId,
                    'structure_id' => $this->structureId, 'workout_main_counter' => $countRow
                ])->first();
                if ($objTemp) {
                    $objTemp->delete();
                }
                $this->success = true;
                $this->message = 'Record is deleted successfully';
                DB::commit();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            $this->message = $e->errorInfo[2];
        }

        return response()->json(['success' => $this->success, 'message' => $this->message, 'id' => $request->input('deleteId')]);
    }
    /**
     * This is used to delete main training workout
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTrainingMainWorkout(Request $request)
    {
        $deleteId = $request->input('deleteId');
        $extraId = explode('_', $request->input('extraId'));
        $this->dayId = $extraId[2];
        $this->structureId = $extraId[3];
        $this->planId = $request->input('id');
        try {
            if (!empty($deleteId)) {
                DB::beginTransaction();
                $splitDeleteId = explode('_', $deleteId);
                $planWeekTrainingSetupId = $splitDeleteId[1];
                $workoutTypeSetId = $splitDeleteId[2];
                $pWorkoutMainMounter = $splitDeleteId[3];
                PlanDragDropStructure::where(['client_plan_id' => $this->planId, 'day_id' => $this->dayId,
                    'structure_id' => $this->structureId, 'workout_set_type_id' => $workoutTypeSetId, 'workout_counter' => $pWorkoutMainMounter
                ])->delete();

               ClientPlanWeekTrainingSetupPosition::where(['client_plan_week_training_setup_id' => $planWeekTrainingSetupId, 'workout_type_set_id' => $workoutTypeSetId, 'workout_main_counter' => $pWorkoutMainMounter])->delete();
                DB::commit();
                $this->success = true;
            }
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            $this->message = $e->errorInfo[2];
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }
    /**
     * This is used to update order workout
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrderWorkout(Request $request)
    {
        $idsInOrder = array_filter($request->input('idsInOrder'));
        try {
            if (!empty($idsInOrder)) {
                $count = 0;
                foreach ($idsInOrder as $key => $row) {
                    $count++;
                    $splitRow = explode('_', $row);
                    $type = $splitRow[0];
                    $this->data[$key]['id'] = (int) $splitRow[1];
                    $this->data[$key]['position'] = $count;
                }
                if ($type === 'sortable-wcc') {
                    $instance = new ClientTempTrainingSetup();
                } else {
                    $instance = new ClientPlanWeekTrainingSetupPosition();
                }
                $index = 'id';
                \Batch::update($instance, $this->data, $index);
                $this->success = true;
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->message = $e->errorInfo[2];
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }
    /**
     *
     *
     * @param Request $request
     */
    public function updatePlanDragAndDrop(Request $request)
    {
        $obj = PlanDragDropStructure::find($request->input('clickedDragAndDropId'));
        if ($obj) {
            $clickedId = $request->input('clickedId');
            $obj->$clickedId = (int)$request->input('clickedValue');
            $obj->save();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPlanComment(Request $request)
    {
        $this->planId = $request->input('id');
        $this->dayId = $request->input('dayId');
        $this->data['comment'] = $request->input('comment');
        ClientPlanTrainingComment::updateorCreate(
            ['client_plan_id' => $this->planId,
                'day_id' => $this->dayId]
            , $this->data);

        $this->success = true;
        $this->message = 'Comment is added successfully';

        return response()->json(['success' => $this->success, 'message' => $this->message, 'id' => $request->input('id')]);
    }

    public function addDragAndDropExercise(Request $request)
    {
        $this->planId = $request->input('id');
        $extraId = explode('_', $request->input('extraId'));
        $this->dayId = $extraId[0]; // dayid
        $this->structureId = $extraId[1]; // structure id
        $this->exerciseId = $request->input('exerciseId');
        $this->data = $request->input('dropDownFilters');
        $planName =ClientPlan::find($this->planId)->name;
        $dayName = Day::find($this->dayId)->name;
        $structureName = TrainingPlanStructure::find($this->structureId)->name;
        $this->isMainWorkout();
        $this->data['workout_set_type_id'] = 0;
        $this->data['exercise_id'] = $this->exerciseId;
        $this->data['position_id'] = $request->input('positionId');
        if (!empty($this->isMainWorkout)) {
            $this->data['workout_set_type_id'] = WorkoutTypeSet::where('key_value', '=', $request->input('workoutType'))->first()->id;
        }
        try {
            $obj = PlanDragDropStructure::updateorCreate(
                ['client_plan_id' => $this->planId, 'day_id' => $this->dayId, 'structure_id' => $this->structureId, 'workout_set_type_id' => $this->data['workout_set_type_id']
                    ,'workout_counter' => $request->input('workoutCounter'), 'workout_sub_counter' => $request->input('workoutSubCounter'), 'workout_type' => $request->input('workoutType')]
                , $this->data);
            $this->success = true;
            $this->dragDropId = $obj->id;
            $this->message = 'Exercise is added successfully on the plan '.$planName. 'of '.$dayName.' against '.$structureName;
        } catch (\Illuminate\Database\QueryException $e) {
            $this->message = $e->errorInfo[2];
        }
        $exerciseName = Exercise::find($this->exerciseId)->name;
        $exerciseImage = Exercise::find($this->exerciseId)->male_illustration;
        $exerciseImage = asset(exerciseImagePathMale.'/'.$exerciseImage);

        return response()->json(['success' => $this->success, 'message' => $this->message, 'id' => $this->planId, 'name' => $exerciseName,'exercise_image'=>$exerciseImage, 'dragDropId' => $this->dragDropId]);
    }

    /**
     * this is used to add client plan
     * @param Request $request
     */
    public function addClientWeeklyPlanProfile(Request $request)
    {
        $uniqueId = $request->input('id');
        $obj = ServiceBooking::select('user_id', 'client_id')
            ->where('unique_id', $uniqueId)
            ->first();
        if ($obj) {
            $clientObj = ClientPlan::updateorCreate(
                [
                    'user_id' => $obj->user_id,
                    'client_id' => $obj->client_id,
                    'unique_id' => $uniqueId
                ]
            );
            $this->message = 'client plan save successfully';
        } else {
            $this->message = 'client plan already exist';
        }
        $this->success = true;

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * this is used to get client information using AJAX
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSelectedClientInformation(Request $request)
    {
        $userId = $request->input('id');
        $uniqueId = $request->input('unique_id');
        $weekId = $request->input('week_id');
        $clientId = loginId();
        $clientPlanId = ClientPlan::select('id', 'is_publish')
            ->where('week_id',$weekId)
            ->where('user_id',$userId)
            ->where('client_id',$clientId)
            ->where('unique_id',$uniqueId)
            ->where('year',$request->input('year'))
            ->first();
        $obj = User::find($userId);
        $arr = [];
        $is_publish = 0;
        if($clientPlanId){
            $arr['client_plan_id'] = $clientPlanId->id;
            $is_publish = $clientPlanId->is_publish;
        }
        $arr['user_id'] = $userId;
        $arr['unique_id'] = $uniqueId;
        if ($obj) {
            $this->success = true;
            $arr['enduser_first_name'] = $obj->first_name;
            $arr['enduser_last_name'] = $obj->last_name;
            $arr['enduser_name'] = $obj->first_name.' '. $obj->last_name;
            $arr['enduser_birthday'] = $obj->birthday;
            $arr['enduser_age'] = $obj->age;
            $arr['enduser_bmi'] = $obj->bmi;
            $arr['enduser_lastlogin'] = $obj->last_login;
            $arr['profile_pic'] = asset('assets/images/profile-pic.png');
            if(!empty($obj->profile_pic_upload)) {
                $arr['profile_pic'] = asset(MobileUserImagePath.'/'.$obj->profile_pic_upload);
            }
        }
        $status = FinalPayment::select('status')
            ->where('unique_id',$uniqueId)
            ->first();
        $arr['enduser_status'] = $status->status;
        $join = 'join';
        if(isLightVersion()){
            $join  = 'leftjoin';
        }
        $serviceBookingsObj = ServiceBooking::select('service_bookings.starting_date', 'wp.name as week_name',
            'ctp.meta_data as change_week_value')
            ->join('week_programs as wp', 'wp.id', '=', 'service_bookings.week_id')
            ->$join('change_training_plans as ctp', 'ctp.id', '=', 'service_bookings.change_training_plan_id')
            ->where('unique_id', $uniqueId)
            ->where('service_id', 1)// this is used to get just training plan starting date
            ->first();
        if($serviceBookingsObj){
            $date = new DateTime($serviceBookingsObj->starting_date);
            $year = date('Y', strtotime($serviceBookingsObj->starting_date));
            $startWeek = $date->format("W");
            $weekname = explode('-',$serviceBookingsObj->week_name)[0];
            $weekIncrement = $serviceBookingsObj->change_week_value;
            if($weekIncrement == 1){
                $weekIncrement = $weekname;
            }
            if(isLightVersion() && empty($weekIncrement)){
                $weekIncrement = 1;
            }
            $startDate = $serviceBookingsObj->starting_date;
            $endWeek = $startWeek + $weekname;
            $createDate = new DateTime($startDate);
            $strip = $createDate->format('Y-m-d');
            $endDate = date('Y-m-d', strtotime($startDate . " +$weekname week"));
            $createDate = new DateTime($startDate);
            $startProgramDate = $createDate->format('Y-m-d');
            $objClientPlan = ClientPlan::where(['unique_id' => $uniqueId, 'user_id' => $userId, 'client_id' => $clientId, 'week_id' => $startWeek, 'year' => $year])->first();
            $id = 0;
            if (!empty($objClientPlan)) {
                $id = $objClientPlan->id;
            }
            $arr['start_week'] = $startWeek;
            $arr['start_date'] = $startDate;
            $arr['start_program_date'] = $startProgramDate;
            $arr['end_program_date'] = $endDate;

            $startTime = strtotime($startProgramDate);
            $endTime = strtotime($endDate);
            $weeks = array();
            $count = 1;
            while ($startTime < $endTime) {
                $weeks[$count][date('W', $startTime)]= date('Y', $startTime);
                $startTime += strtotime('+1 week', 0);
                $count++;
            }
            $arr['week_id'] = 'Week ' . $startWeek;
            $arr['end_week'] = $endWeek;
            $arr['id'] = $id;
            $arr['year'] = $year;
            $arr['unique_id'] = $uniqueId;
            $arr['client_id'] = $clientId;
            $arr['is_publish_plan'] = $is_publish;
            $arr['week_increment_value'] = $weekIncrement;
            $arr['weeks'] = $weeks;

        }
        $this->data = $arr;

        return response()->json(['success' => $this->success, 'data' => $this->data]);

    }
    /**
     * this is used to publish client plan
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function publishClientPlan(Request $request)
    {
        try {
            DB::beginTransaction();
            $clientId = loginId();
            $userId = $request->input('user_id');
            $uniqueId = $request->input('unique_id');
            $weekId = $request->input('week_id');
            $isPublish = $request->input('is_publish');
            $obj = ClientPlan::where('unique_id', $uniqueId)
                ->where('week_id', $weekId)
                ->where('user_id', $userId)
                ->where('client_id', $clientId)
                ->first();
            $obj->is_publish = $isPublish;
            $obj->save();
            $year = $obj->year;
            ClientWeekPlan::where('client_plan_id', $obj->id)
                ->update([
                    'is_publish' => $isPublish
                ]);
            if (!empty((int)$isPublish)) {
                $objUser = User::find($userId);
                $objCoach = User::find($clientId);
                if (!empty($objUser) && !empty($objCoach)) {
                    $arrPush = [];
                    $arrPush['title'] = 'Plan Publish';
                    $arrPush['message'] = 'Your personal coach ' . $objCoach->first_name . ' has just published your training program for week ' . $weekId . ',' . $year . '. Check it out.';
                    $arrPush['notification_message'] = 'Your personal coach ' . $objCoach->first_name . ' has just published your training program for week ' . $weekId . ',' . $year . '. Check it out.';
                    $arrPush['device_token'] = $objUser->device_token;
                    $arrPush['user_id'] = $objUser->id;
                    $arrPush['notification_user_id'] = $clientId;
                    $this->sendPushNotifications($arrPush);
                }
            }
            $prefix = 'Unpublished';
            if (!empty($isPublish)) {
                $prefix = 'Published';
            }
            if ($obj) {
                $this->message = 'Plan ' . $prefix . ' successfully';
                $this->success = true;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json(['success' => $this->success, 'is_publish' => $isPublish, 'message' => $this->message]);
    }

    /**
     * this is used to import plan from program database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function importPlan(Request $request)
    {
        $planType = $request->input('plan_type');
        $planId = $request->input('plan_id');
        $uniqueId = $request->input('unique_id');
        $clientId = loginId();
        $weekId = $request->input('week_id');
        if ($planType == "2") {
            $obj = ServiceBooking::select('user_id', 'client_id', 'starting_date')
                ->where('unique_id', $uniqueId)
                ->first();
            $date = new DateTime($obj->starting_date);
            $year = $date->format("Y");
            if ($obj) {
                $clientObj = ClientPlan::updateorCreate(
                    [
                        'user_id' => $obj->user_id,
                        'client_id' => $clientId,
                        'unique_id' => $uniqueId,
                        'week_id' => $weekId,
                        'year' => $year
                    ]
                );
            }
            if ($clientObj) {
                try {
                    DB::beginTransaction();
                    $this->planId = $clientObj->id;

                    // Plan training Overview Week
                    $planOverviewWeekObj = \App\Models\PlanTrainingOverviewWeek::where('plan_id', $planId)
                        ->get([
                            'plan_id as client_plan_id', 'day_id', 'day_plan_id', 'body_part_1', 'body_part_2', 'body_part_3'])
                        ->toArray();
                    foreach ($planOverviewWeekObj as $key => $row) {
                        $planOverviewWeekObj[$key]['client_plan_id'] = $this->planId;
                    }
                    PlanTrainingOverviewWeek::where('client_plan_id', $this->planId)->delete();
                    PlanTrainingOverviewWeek::insert($planOverviewWeekObj);

                    // Plan Week Training setup
                    $arrayPlanTrainingSetup = [];
                    $planTrainingSetupObj = \App\Models\PlanWeekTrainingSetup::where('plan_id', $planId)
                        ->get([
                            'id', 'plan_id as client_plan_id', 'day_id', 'plan_training_overview_week_id as client_plan_training_overview_week_id',
                            'warm_up', 'main_workout', 'cardio', 'cool_down', 'is_main_workout_top'])
                        ->toArray();
                    array_multisort(array_column($planTrainingSetupObj, 'day_id'), SORT_ASC, $planTrainingSetupObj);
                    $objPlanTrainingOverviewIds = PlanTrainingOverviewWeek::select('id')->where('client_plan_id', $this->planId)->get()->toArray();

                    foreach ($planTrainingSetupObj as $key => $row) {
                        $planTrainingSetupObj[$key]['client_plan_id'] = $this->planId;
                        $planTrainingSetupObj[$key]['client_plan_training_overview_week_id'] = $objPlanTrainingOverviewIds[$key]['id'];
                        $planTrainingSetupObj[$key]['id'] = '';
                    }
                    PlanWeekTrainingSetup::where('client_plan_id', $this->planId)->delete();
                    PlanWeekTrainingSetup::insert($planTrainingSetupObj);

                    // plan week training setup position
                    $planSetupId = \App\Models\PlanWeekTrainingSetup::select('id')->where('plan_id', $planId)->get()->toArray();
                    $clientPlanSetupTrainingObjIds = PlanWeekTrainingSetup::where('client_plan_id', $this->planId)->get()->toArray();

                    foreach ($planSetupId as $key => $setupId) {
                        $planWeekTrainingSetupPositionObj = \App\Models\PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', $setupId['id'])
                            ->get(['plan_week_training_setup_id as client_plan_week_training_setup_id', 'workout_type_set_id',
                                'workout_main_counter', 'position', 'exercise_set'])
                            ->toArray();

                        if ($planWeekTrainingSetupPositionObj) {
                            ClientPlanWeekTrainingSetupPosition::where('client_plan_week_training_setup_id', $clientPlanSetupTrainingObjIds[$key]['id'])->delete();
                            foreach ($planWeekTrainingSetupPositionObj as $item) {
                                $item['client_plan_week_training_setup_id'] = $clientPlanSetupTrainingObjIds[$key]['id'];
                                ClientPlanWeekTrainingSetupPosition::insert($item);
                            }
                        }
                    }
                    // temp table
                    $tempTrainingSetupObj = \App\Models\TempTrainingSetup::where('plan_id', $planId)
                        ->get(['plan_id as client_plan_id', 'day_id', 'structure_id', 'workout_main_counter', 'position'])
                        ->toArray();
                    foreach ($tempTrainingSetupObj as $key => $row) {
                        $tempTrainingSetupObj[$key]['client_plan_id'] = $this->planId;
                    }
                    ClientTempTrainingSetup::where('client_plan_id', $this->planId)->delete();
                    ClientTempTrainingSetup::insert($tempTrainingSetupObj);

                    // drag drop table
                    $clientTempTrainingSetupObj = ClientTempTrainingSetup::where('client_plan_id', $this->planId)->get()->toArray();
                    $arrTemp = [];
                    foreach ($clientTempTrainingSetupObj as $row) {
                        $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_main_counter']] = $row['id'];
                    }
                    $planDragDropStructureObj = \App\Models\PlanDragDropStructure::where('plan_id', $planId)
                        ->get(['plan_id as client_plan_id', 'day_id', 'structure_id', 'exercise_id', 'workout_counter', 'workout_sub_counter',
                            'workout_type', 'workout_set_type_id', 'position', 'position_id', 'set_id', 'rep_id', 'duration_id',
                            'note_id', 'rm_id', 'tempo_id', 'rest_id', 'form_id', 'stage_id', 'wr_id'])
                        ->toArray();
                    $clientWeekTrainingSetup = PlanWeekTrainingSetup::select('day_id', 'cp.id', 'workout_type_set_id', 'workout_main_counter')
                        ->where('client_plan_id', '=', $this->planId)
                        ->join('client_plan_week_training_setup_positions as cp', 'cp.client_plan_week_training_setup_id', '=', 'client_plan_week_training_setups.id')
                        ->get()->toArray();
                    $arrTempPlan = [];
                    foreach ($clientWeekTrainingSetup as $row) {
                        $arrTempPlan[$planId][$row['day_id']][$row['workout_type_set_id']][$row['workout_main_counter']] = $row['id'];
                    }
                    foreach ($planDragDropStructureObj as $key => $row) {
                        $planDragDropStructureObj[$key]['client_plan_id'] = $this->planId;
                        //todo need to verifiy this $arrTemp[$planId]
                        if ($row['structure_id'] != 2 && !empty($arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']])) {
                            $planDragDropStructureObj[$key]['position_id'] = $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']];
                        } elseif ($row['structure_id'] == 2 && !empty($arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']])) {
                            $planDragDropStructureObj[$key]['position_id'] = $arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']];
                        }
                    }
                    PlanDragDropStructure::where('client_plan_id', $this->planId)->delete();
                    PlanDragDropStructure::insert($planDragDropStructureObj);

                    // plan comment table
                    $planTrainingCommentObj = \App\Models\PlanTrainingComment::where('plan_id', $planId)
                        ->get(['plan_id as client_plan_id', 'day_id', 'comment'])
                        ->toArray();
                    foreach ($planTrainingCommentObj as $key => $row) {
                        $planTrainingCommentObj[$key]['client_plan_id'] = $this->planId;
                    }
                    ClientPlanTrainingComment::where('client_plan_id', $this->planId)->delete();
                    ClientPlanTrainingComment::insert($planTrainingCommentObj);
                    $this->success = true;
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                }
            }

        } else {
            $importDayId = (int)$request->input('import_day_id');
            $obj = ServiceBooking::select('user_id', 'client_id', 'starting_date')
                ->where('unique_id', $uniqueId)
                ->first();
            $date = new DateTime($obj->starting_date);
            $year = $date->format("Y");
            try {
                DB::beginTransaction();

                if ($obj) {
                    $clientObj = ClientPlan::updateorCreate(
                        [
                            'user_id' => $obj->user_id,
                            'client_id' => $clientId,
                            'unique_id' => $uniqueId,
                            'week_id' => $weekId,
                            'year' => $year
                        ]
                    );
                }
                if ($clientObj) {
                    $this->planId = $clientObj->id;
                    $ids = PlanWeekTrainingSetup::select('id')->where(['day_id' => $importDayId, 'client_plan_id' => $this->planId])->get()->toArray();
                    ClientPlanWeekTrainingSetupPosition::whereIn('client_plan_week_training_setup_id', $ids)->delete();

                    // Plan training Overview Week
                    $planOverviewWeekObj = \App\Models\PlanTrainingOverviewWeek::where(['plan_id' => $planId, 'day_id' => 8])
                        ->get([
                            'plan_id as client_plan_id', 'day_id', 'day_plan_id', 'body_part_1', 'body_part_2', 'body_part_3'])
                        ->toArray();
                    foreach ($planOverviewWeekObj as $key => $row) {
                        $planOverviewWeekObj[$key]['client_plan_id'] = $this->planId;
                        $planOverviewWeekObj[$key]['day_id'] = $importDayId;
                    }
                    $arrOverViewWeek = [];
                    for ($i = 0; $i < 7; $i++) {
                        $arrOverViewWeek[$i + 1]['day_id'] = $i + 1;
                        $arrOverViewWeek[$i + 1]['day_plan_id'] = 2;
                        $arrOverViewWeek[$i + 1]['client_plan_id'] = $this->planId;
                        $arrOverViewWeek[$i + 1]['body_part_1'] = '';
                        $arrOverViewWeek[$i + 1]['body_part_2'] = '';
                        $arrOverViewWeek[$i + 1]['body_part_3'] = '';
                    }
                    $mergArray = array_merge($arrOverViewWeek, $planOverviewWeekObj);
                    $mergeOverview = array_column($mergArray, null, 'day_id');
                    PlanTrainingOverviewWeek::where('client_plan_id', $this->planId)
                        ->where('day_id', $importDayId)
                        ->delete();
                    $testOverview = PlanTrainingOverviewWeek::select('id')->where('client_plan_id', $this->planId)
                        ->where('day_plan_id', 1)//  for Training
                        ->get();
//                    if (!$testOverview->isEmpty()) {
//                        PlanTrainingOverviewWeek::insert($planOverviewWeekObj);
//                    } else {
//                        PlanTrainingOverviewWeek::insert($mergeOverview);
//                    }
                    PlanTrainingOverviewWeek::insert($planOverviewWeekObj);
                    // Plan Week Training setup
                    $arrayPlanTrainingSetup = [];
                    $planTrainingSetupObj = \App\Models\PlanWeekTrainingSetup::where('plan_id', $planId)
                        ->get([
                            'id', 'plan_id as client_plan_id', 'day_id', 'plan_training_overview_week_id as client_plan_training_overview_week_id',
                            'warm_up', 'main_workout', 'cardio', 'cool_down', 'is_main_workout_top'])
                        ->toArray();
                    $objPlanTrainingOverviewIds = PlanTrainingOverviewWeek::select('id')->where('client_plan_id', $this->planId)
                        ->where('day_id', $importDayId)
                        ->get()->toArray();

                    foreach ($planTrainingSetupObj as $key => $row) {
                        $planTrainingSetupObj[$key]['client_plan_id'] = $this->planId;
                        $planTrainingSetupObj[$key]['client_plan_training_overview_week_id'] = $objPlanTrainingOverviewIds[$key]['id'];
                        $planTrainingSetupObj[$key]['id'] = '';
                        $planTrainingSetupObj[$key]['day_id'] = $importDayId;
                    }
                    PlanWeekTrainingSetup::where('client_plan_id', $this->planId)
                        ->where('day_id', $importDayId)
                        ->delete();
                    PlanWeekTrainingSetup::insert($planTrainingSetupObj);

                    // plan week training setup position
                    $planSetupId = \App\Models\PlanWeekTrainingSetup::select('id','day_id')->where('plan_id', $planId)->get()->toArray();
                    $planSetupId = array_column($planSetupId, null, 'day_id');
                    $clientPlanSetupTrainingObjIds = PlanWeekTrainingSetup::where('client_plan_id', $this->planId)
                        ->where('day_id', $importDayId)
                        ->get()->toArray();

                    $clientPlanSetupTrainingObjIds = array_column($clientPlanSetupTrainingObjIds, null, 'day_id');

                    foreach ($planSetupId as $key => $setupId) {
                        $planWeekTrainingSetupPositionObj = \App\Models\PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', $setupId['id'])
                            ->get(['plan_week_training_setup_id as client_plan_week_training_setup_id', 'workout_type_set_id',
                                'workout_main_counter', 'position', 'exercise_set'])
                            ->toArray();
//                        ClientPlanWeekTrainingSetupPosition::where('client_plan_week_training_setup_id', $clientPlanSetupTrainingObjIds[$key]['id'])->delete();
                        if ($planWeekTrainingSetupPositionObj) {
                            if (!empty($clientPlanSetupTrainingObjIds[$importDayId])) {
                                foreach ($planWeekTrainingSetupPositionObj as $item) {
                                    $item['client_plan_week_training_setup_id'] = $clientPlanSetupTrainingObjIds[$importDayId]['id'];
                                    ClientPlanWeekTrainingSetupPosition::insert($item);
                                }
                            }
                        }
                    }

                    // temp table
                    $tempTrainingSetupObj = \App\Models\TempTrainingSetup::where('plan_id', $planId)
                        ->get(['plan_id as client_plan_id', 'day_id', 'structure_id', 'workout_main_counter', 'position'])
                        ->toArray();

                    foreach ($tempTrainingSetupObj as $key => $row) {
                        $tempTrainingSetupObj[$key]['client_plan_id'] = $this->planId;
                        if ($tempTrainingSetupObj[$key]['day_id'] == 8)
                            $tempTrainingSetupObj[$key]['day_id'] = $importDayId;
                    }

                    ClientTempTrainingSetup::where('client_plan_id', $this->planId)
                        ->where('day_id', $importDayId)
                        ->delete();
                    ClientTempTrainingSetup::insert($tempTrainingSetupObj);
                    // drag drop table
                    $clientTempTrainingSetupObj = ClientTempTrainingSetup::where('client_plan_id', $this->planId)->get()->toArray();
                    $arrTemp = [];
                    foreach ($clientTempTrainingSetupObj as $row) {
                        $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_main_counter']] = $row['id'];
                    }
                    $planDragDropStructureObj = \App\Models\PlanDragDropStructure::where('plan_id', $planId)
                        ->get(['plan_id as client_plan_id', 'day_id', 'structure_id', 'exercise_id', 'workout_counter', 'workout_sub_counter',
                            'workout_type', 'workout_set_type_id', 'position', 'position_id', 'set_id', 'rep_id', 'duration_id',
                            'note_id', 'rm_id', 'tempo_id', 'rest_id', 'form_id', 'stage_id', 'wr_id'])
                        ->toArray();
                    foreach ($planDragDropStructureObj as $key => $row) {
                        $planDragDropStructureObj[$key]['client_plan_id'] = $this->planId;
                        $planDragDropStructureObj[$key]['day_id'] = $importDayId;
                    }
                    $clientWeekTrainingSetup = PlanWeekTrainingSetup::select('day_id', 'cp.id', 'workout_type_set_id', 'workout_main_counter')
                        ->where('client_plan_id', '=', $this->planId)
                        ->join('client_plan_week_training_setup_positions as cp', 'cp.client_plan_week_training_setup_id', '=', 'client_plan_week_training_setups.id')
                        ->get()->toArray();
                    $arrTempPlan = [];
                    foreach ($clientWeekTrainingSetup as $row) {
                        $arrTempPlan[$planId][$row['day_id']][$row['workout_type_set_id']][$row['workout_main_counter']] = $row['id'];
                    }
                    foreach ($planDragDropStructureObj as $key => $row) {
                        $planDragDropStructureObj[$key]['client_plan_id'] = $this->planId;
                        if ($row['structure_id'] != 2 && !empty($arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']])) {
                            $planDragDropStructureObj[$key]['position_id'] = $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']];
                        } elseif ($row['structure_id'] == 2 && !empty($arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']])) {
                            $planDragDropStructureObj[$key]['position_id'] = $arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']];
                        }
                    }
                    PlanDragDropStructure::where('client_plan_id', $this->planId)
                        ->where('day_id', $importDayId)
                        ->delete();
                    PlanDragDropStructure::insert($planDragDropStructureObj);

                    // plan comment table
                    $planTrainingCommentObj = \App\Models\PlanTrainingComment::where('plan_id', $planId)
                        ->get(['plan_id as client_plan_id', 'day_id', 'comment'])
                        ->toArray();
                    foreach ($planTrainingCommentObj as $key => $row) {
                        $planTrainingCommentObj[$key]['client_plan_id'] = $this->planId;
                        $planTrainingCommentObj[$key]['day_id'] = $importDayId;
                    }
                    ClientPlanTrainingComment::where('client_plan_id', $this->planId)
                        ->where('day_id', $importDayId)
                        ->delete();
                    ClientPlanTrainingComment::insert($planTrainingCommentObj);
                    $this->success = true;
                    DB::commit();
                }
            } catch (\Exception $e) {
                DB::rollback();
            }
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * This is used to get weeks in year
     *
     * @param $year
     * @return int
     */
    function getIsoWeeksInYear($year)
    {
        $date = new DateTime;
        $date->setISODate($year, 53);

        return ($date->format("W") === "53" ? 53 : 52);
    }

    /**
     * This is used to show popup of day plan save
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function dayPlanSave(Request $request)
    {
        $uniqueId = $request->input('unique_id');
        $obj = ClientPlan::where('unique_id', '=', $uniqueId)->first();
        $planId = $obj->id;
        $this->params['planId'] = $planId;
        $this->params['dayId'] = $request->input('dayId');
        $equipmentIds = PlanDragDropStructure::getEquipments($this->params);
        $equipmentIds = json_decode(json_encode($equipmentIds), true);
        $equipmentIds = array_column($equipmentIds, 'id');
        $this->getUserId();
        $equipmentIds = json_encode($equipmentIds);
        $this->isEmptySelect = true;
        $this->data['goals'] = $this->emptySelect + Goal::pluck('name', 'id')->toArray();
        $this->data['equipments'] = $this->emptySelect + Equipment::pluck('name', 'id')->toArray();
        $this->data['equipmentIds'] = $this->emptySelect + Equipment::pluck('name', 'id')->toArray();
        $this->data['plan'] = Plan::where(['old_plan_id' => $planId, 'plan_day_id' => $request->input('dayId')])->first();
        $view = view('client.plan.partials._one-day-popup', ['data' => $this->data])->render();

        return response()->json(['success' => true, 'message' => $this->message, 'view' => $view, 'equipmentIds' => $equipmentIds]);
    }

    /**
     * This is used to save one day plan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function oneDayPlanSave(Request $request)
    {
        $data = [];
        parse_str($request->input('data'), $data);
        $planId = ClientPlan::where('unique_id', '=', $request->input('unique_id'))->first()->id;
        $this->params['title'] = $data['title'];
        $this->params['description'] = $data['description'];
        $this->params['goalId'] = $request->input('goalId');
        $this->params['dayId'] = $request->input('dayId');
        $this->params['planId'] = $planId;
        $this->params['uniqueId'] = $request->input('unique_id');

        $equipmentIds = PlanDragDropStructure::getEquipments($this->params);
        $equipmentIds = json_decode(json_encode($equipmentIds), true);
        $this->params['equipmentIds'] = array_column($equipmentIds, 'id');

        $this->error = false;
        $this->getDayPlanId();
        $record = PlanTrainingOverviewWeek::where(['client_plan_id' => $planId, 'day_plan_id' => $this->dayPlanId, 'day_id' => $this->params['dayId']])->get();
        if (empty($record) || !count($record)) {
            $this->error = true;
        } else {
            $workoutKeys = TrainingPlanStructure::where('key_value', '=', 'main_workout')
                ->orwhere('key_value', '=', 'cardio')
                ->orwhere('key_value', '=', 'warm_up')
                ->orwhere('key_value', '=', 'cool_down')
                ->pluck('id')->toArray();
            foreach ($record as $row) {
                $countExercise = PlanDragDropStructure::where(['client_plan_id' => $row->client_plan_id, 'day_id' => $row->day_id])->whereIn('structure_id', $workoutKeys)->count();
                if (empty($countExercise)) {
                    $this->error = true;
                    break;
                }
            }
        }
        if (empty($this->error))
            $this->saveAsNewPlanFromBooking($this->params);
        else
            $this->message = 'Please add exercises against training day';

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }
}
