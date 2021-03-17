<?php

namespace App\Http\Controllers\Client;

use App\Models\DraftEquipmentPlan;
use App\Models\DraftPlan;
use App\Models\DraftPlanDragDropStructure;
use App\Models\DraftPlanTrainingComment;
use App\Models\DraftPlanTrainingOverviewWeek;
use App\Models\DraftPlanWeekTrainingSetup;
use App\Models\DraftPlanWeekTrainingSetupPosition;
use App\Models\DraftTempTrainingSetup;
use App\Models\EquipmentPlan;
use Arr;
use DB;
use App\Models\Day;
use App\Models\Goal;
use App\Models\Plan;
use App\Models\DayPlan;
use App\Models\BodyPart;
use App\Models\Equipment;
use function GuzzleHttp\Promise\all;
use function GuzzleHttp\Psr7\str;
use http\Env\Response;
use Illuminate\View\View;
use App\Models\TrainingAge;
use App\Models\AgeCategory;
use App\Models\TrainingDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PlanWeekTrainingSetup;
use App\Models\PlanTrainingOverviewWeek;
use App\Models\TrainingPlanStructure;
use App\Traits\ZestLogTrait;
use App\Models\Set;
use App\Models\Rep;
use App\Models\Duration;
use App\Models\Note;
use App\Models\Form;
use App\Models\Stage;
use App\Models\Wr;
use App\Models\Rm;
use App\Models\Tempo;
use App\Models\Rest;
use App\Models\Exercise;
use App\Models\PlanDragDropStructure;
use App\Models\PlanTrainingComment;
use App\Models\WorkoutTypeSet;
use App\Models\PlanWeekTrainingSetupPosition;
use App\Models\TempTrainingSetup;
class PlanController extends Controller
{
    use ZestLogTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->isEmptyAll = true;
        $this->getPlanFilters();
        $planType = 2;
        $isImportRender = 0;
        if ($request->input('type') === 'onedayplan') {
            $planType = 1;
            $isImportRender = 1;
        }
        $this->data['planType'] = $planType;
        $this->data['isImportRender'] = $isImportRender;

        return view('client.plan.index', $this->data);
    }

    /**
     * This is used to get training programs
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTrainingPrograms(Request $request)
    {
        $planType = $request->input('plan_type');
        $this->getUserId();
        $this->params = [
            'perPage' => $this->perPage,
            'page' =>   $request->input('page'),
            'search' => $request->input('search'),
            'sortColumn' => $request->input('sortColumn'),
            'sortType' => $request->input('sortType'),
            'dropDownFilters' => $request->input('dropDownFilters'),
            'userId' => $this->userId,
            'plan_type' => $planType
        ];
        if ($planType == 1) {                    // for get day plan
            $data = Plan::getDayPlansWeb($this->params);
        } else {
            $data = Plan::getPlansWeb($this->params);
        }
        if (!empty($data['result'])) {
            $ids = array_column($data['result'], 'id');
            $plans = Plan::with(['Equipments' => function ($query) use ($ids) {
                $query->whereIn('plan_id', $ids);
            }])->get();
            $equipments = [];
            foreach ($plans as $row) {
                $equipment = '';
                foreach ($row->Equipments as $key => $equipmentRow) {
                    if ($key)
                        $equipment .= ', ';
                    $equipment .= $equipmentRow->name;
                }
                $equipments[$row->id] = $equipment;
            }

            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]->equipment = $equipments[$row->id];
            }
        }
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->getUserId();
        $this->isEquipmentEmptySelect = false;
        $this->isEmptySelect = true;
        $this->getPlanFilters();
        $this->isEmptyAll = true;
        $this->isEmptySelect = false;
        $this->getExerciseFilter();
        $objPlan = Plan::where('user_id', '=', $this->userId)->where('is_completed', '=', 0)->first();
        $workoutTypeSet = WorkoutTypeSet::pluck('set_exercises', 'key_value')->toArray();
        $equipmentIds = $trainingDayIds = [];
        if (!empty($objPlan)) {
            $this->planId = $objPlan->id;
            if (!empty($objPlan->training_day_id))
                $trainingDayIds[] = $objPlan->training_day_id;
            $equipmentIds = [];
            $objPlans = Plan::select('eq.equipment_id as id')
                ->where('plans.id', $this->planId)
                ->join('equipment_plan as eq', 'eq.plan_id', '=', 'plans.id')
                ->get()->toArray();
            foreach ($objPlans as $key => $row) {
                $equipmentIds[] = $row['id'];
            }
        }
        $this->data['id'] = $this->planId;
        $this->data['plan'] = $objPlan;
        $this->data['equipmentIds'] = json_encode($equipmentIds);
        $this->data['trainingDayIds'] = json_encode($trainingDayIds);
        $this->data['workoutTypeSet'] = json_encode($workoutTypeSet);
        $this->data['isEdit'] = false;

        return View('client.plan.create', ['data' => $this->data]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function oneDayPlanCreate()
    {
        $this->getUserId();
        $this->isEquipmentEmptySelect = false;
        $this->isEmptySelect = true;
        $this->getPlanFilters();
        $this->isEmptyAll = true;
        $this->isEmptySelect = false;
        $this->getExerciseFilter();
        $objPlan = Plan::where('user_id', '=', $this->userId)->where('is_completed', '=', 0)->first();
        $workoutTypeSet = WorkoutTypeSet::pluck('set_exercises', 'key_value')->toArray();
        $plan = $equipmentIds = [];
        if ($objPlan) {
            $this->planId = $objPlan->id;
            $plan = $objPlan->toArray();
            $equipments = $objPlan->with('Equipments')->first();
            foreach ($equipments->Equipments as $key => $row) {
                $equipmentIds[] = $row->id;
            }
        }
        $this->data['id'] = $this->planId;
        $this->data['plan'] = $plan;
        $this->data['equipmentIds'] = json_encode($equipmentIds);
        $this->data['workoutTypeSet'] = json_encode($workoutTypeSet);
        $this->data['isEdit'] = false;

        return View('client.plan.one-day-plan.index', ['data' => $this->data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isEdit = $request->input('is_edit');
        $planId = $request->input('id');
        try {
            DB::beginTransaction();
            $planType = $request->input('plan_type');
            $data = [];
            $equipmentIds = [];
            if (!empty($isEdit)) {
                $objExercises = DraftPlanDragDropStructure::select('eq.name', 'eq.id')
                    ->where('plan_id', $request->input('id'))
                    ->join('exercises as e', 'e.id', '=', 'draft_plan_drag_drop_structures.exercise_id')
                    ->join('equipment as eq', 'eq.id', '=', 'e.equipment_id')
                    ->groupBy('eq.id')
                    ->get()->toArray();
                foreach ($objExercises as $key => $row) {
                    $equipmentIds[] = $row['id'];
                }
            } else {
                $objExercises = PlanDragDropStructure::select('eq.name', 'eq.id')
                    ->where('plan_id', $request->input('id'))
                    ->join('exercises as e', 'e.id', '=', 'plan_drag_drop_structures.exercise_id')
                    ->join('equipment as eq', 'eq.id', '=', 'e.equipment_id')
                    ->groupBy('eq.id')
                    ->get()->toArray();
                foreach ($objExercises as $key => $row) {
                    $equipmentIds[] = $row['id'];
                }
            }
            parse_str($request->input('data'), $data);
            unset($data['equipment_id']);
            $this->getUserId();
            $this->getDayPlanId();

            if (!empty($request->input('is_save'))) {
                if (!empty($isEdit)) {
                    $record = DraftPlanTrainingOverviewWeek::where(['plan_id' => $request->input('id'), 'day_plan_id' => $this->dayPlanId])->get();
                } else {
                    $record = PlanTrainingOverviewWeek::where(['plan_id' => $request->input('id'), 'day_plan_id' => $this->dayPlanId])->get();
                }
                if (empty($record) || !count($record)) {
                    $this->error = true;
                } else {
                    $workoutKeys = TrainingPlanStructure::where('key_value', '=', 'main_workout')
                        ->orwhere('key_value', '=', 'cardio')
                        ->orwhere('key_value', '=', 'warm_up')
                        ->orwhere('key_value', '=', 'cool_down')
                        ->pluck('id')->toArray();
                    foreach ($record as $row) {
                        if (!empty($isEdit)) {
                            $countExercise = DraftPlanDragDropStructure::where(['plan_id' => $row->plan_id, 'day_id' => $row->day_id])->whereIn('structure_id', $workoutKeys)->count();
                        } else {
                            $countExercise = PlanDragDropStructure::where(['plan_id' => $row->plan_id, 'day_id' => $row->day_id])->whereIn('structure_id', $workoutKeys)->count();
                        }
                        if (empty($countExercise)) {
                            $this->error = true;
                            break;
                        }
                    }
                }
                if ($this->error) {
                    $this->message = 'Please add exercises against training days';
                } else {
                    $data['is_completed'] = 1;
                    $data['day_plan_id'] = $this->dayPlanId;
                    if ($planType == "1") {
                        $data['plan_type'] = 1;
                        $data['duration'] = 'One day';
                    }
                    $obj = Plan::find($request->input('id'));
                    $obj->update($data);
                    DraftPlan::where('id',$planId)->delete();
                    $this->message = 'Plan is updated successfully';
                    if (!empty($equipmentIds))
                        $obj->Equipments()->sync($equipmentIds);
                    $this->success = true;
                    $this->isRedirect = true;
                }
            } else {
                $data['user_id'] = $this->userId;
                $data['day_plan_id'] = $this->dayPlanId;
                if ($planType == "1") {
                    $data['plan_type'] = 1;
                    $data['duration'] = 'One day';
                }
                if (empty($request->input('id'))) {
                    $obj = Plan::create($data);
                    $this->message = 'Plan is created successfully';
                } else {
                    $obj = Plan::find($request->input('id'));
                    $obj->update($data);
                    DraftPlan::where('id',$planId)->delete();
                    $this->message = 'Plan is updated successfully';
                }
                if (!empty($equipmentIds))
                    $obj->Equipments()->sync($equipmentIds);
                $this->planId = $obj->id;
                $this->success = true;
            }
            if (empty($this->error) || empty($request->input('is_save'))) {
                if (!empty($isEdit)) {
                    $this->importDraftToMainPlan($planId);
                }
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json(['success' => $this->success, 'message' => $this->message, 'id' => $this->planId, 'isRedirect' => $this->isRedirect]);
    }

    /**
     * This is used to store/get overview data against plan id
     *
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|View
     */
    public function overViewStore(Request $request, $id = NULL, $isEdit = null)
    {
//        dd($request->all());
            try {
                DB::beginTransaction();
                if ($request->isMethod('get')) {
                    if (!empty($isEdit)) {
                        $ptModel = 'DraftPlanTrainingOverviewWeek';
                    } else {
                        $ptModel = 'PlanTrainingOverviewWeek';
                    }
                    $ptModel = '\\App\Models\\' . $ptModel;
                    $this->isEmptySelect = true;
                    $this->emptySelect();
                    $data["days"] = Day::pluck('name', 'id')->toArray();
                    $data['day_plans'] = DayPlan::pluck('name', 'id')->toArray();
                    $data['body_parts'] = $this->emptySelect + BodyPart::pluck('name', 'id')->toArray();
                    $overview['body_part_1'] = $ptModel::plans($id)->pluck('body_part_1', 'day_id')->toArray();
                    $overview['body_part_2'] = $ptModel::plans($id)->pluck('body_part_2', 'day_id')->toArray();
                    $overview['body_part_3'] = $ptModel::plans($id)->pluck('body_part_3', 'day_id')->toArray();
                    $overview['day_plan'] = $ptModel::plans($id)->pluck('day_plan_id', 'day_id')->toArray();

                    return view('client.plan.overview-content', compact('data', 'overview'));
                }

                $isEdit = $request->input('is_edit');
                $pmodel = 'PlanTrainingOverviewWeek';
                $tModel = 'PlanWeekTrainingSetup';
                $Model = 'Plan';
                if (!empty($isEdit)) {
                    $pmodel = 'DraftPlanTrainingOverviewWeek';
                    $tModel = 'DraftPlanWeekTrainingSetup';
                    $Model = 'DraftPlan';
                }
                $pmodel = '\\App\Models\\' . $pmodel;
                $tModel = '\\App\Models\\' . $tModel;
                $Model = '\\App\Models\\' . $Model;

                $this->planId = $request->plan_id;
                $dayId = $request->input('training_day_id');
                $Model::where('id', $this->planId)->update(['training_day_id' => $dayId]);
                foreach ($request->day_plan_id as $key => $dayPlan) {
                    $this->dayId = $key;
                    $data['day_plan_id'] = $dayPlan;
                    $data['body_part_1'] = $request->body_part_1[$key] ?? NULL;
                    $data['body_part_2'] = $request->body_part_2[$key] ?? NULL;
                    $data['body_part_3'] = $request->body_part_3[$key] ?? NULL;
                    $obj = $pmodel::updateorCreate(['plan_id' => $this->planId, 'day_id' => $this->dayId], $data);

                    $record = [];
                    $record['warm_up'] = 1;
                    $record['cool_down'] = 1;
                    $record['is_main_workout_top'] = 1;
                    $record['plan_training_overview_week_id'] = $obj->id;
                    $tModel::updateOrCreate(['plan_id' => $this->planId, 'day_id' => $this->dayId], $record);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }


        return response()->json(['status' => 200, 'id' => $this->planId]);
    }

    /**
     * This is used to store/get One day overview data against plan id
     *
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|View
     */
    public function oneDayOverViewStore(Request $request, $id = NULL, $isEdit = null)
    {
        try {
            DB::beginTransaction();
            if ($request->isMethod('get')) {
                if (!empty($isEdit)) {
                    $ptModel = 'DraftPlanTrainingOverviewWeek';
                } else {
                    $ptModel = 'PlanTrainingOverviewWeek';
                }
                $ptModel = '\\App\Models\\' . $ptModel;
                $this->isEmptySelect = true;
                $this->emptySelect();
                $data["days"] = ['8' => 'one day'];
                $data['day_plans'] = DayPlan::pluck('name', 'id')->toArray();
                $data['body_parts'] = $this->emptySelect + BodyPart::pluck('name', 'id')->toArray();
                $overview['body_part_1'] = $ptModel::plans($id)->pluck('body_part_1', 'day_id')->toArray();
                $overview['body_part_2'] = $ptModel::plans($id)->pluck('body_part_2', 'day_id')->toArray();
                $overview['body_part_3'] = $ptModel::plans($id)->pluck('body_part_3', 'day_id')->toArray();
                $overview['day_plan'] = $ptModel::plans($id)->pluck('day_plan_id', 'day_id')->toArray();

                return view('client.plan.one-day-plan.partials.overview-content', compact('data', 'overview'));
            }

            $isEdit = $request->input('is_edit');
            $model = 'PlanTrainingOverviewWeek';
            $tModel = 'PlanWeekTrainingSetup';
            if (!empty($isEdit)) {
                $model = 'DraftPlanTrainingOverviewWeek';
                $tModel = 'DraftPlanWeekTrainingSetup';
            }
            $model = '\\App\Models\\' . $model;
            $tModel = '\\App\Models\\' . $tModel;

            $this->planId = $request->plan_id;
            foreach ($request->day_plan_id as $key => $dayPlan) {
                // $this->dayId = $key;
                $this->dayId = 8;   //give a static id for test

                $data['day_plan_id'] = $dayPlan;
                $data['body_part_1'] = $request->body_part_1[$key] ?? NULL;
                $data['body_part_2'] = $request->body_part_2[$key] ?? NULL;
                $data['body_part_3'] = $request->body_part_3[$key] ?? NULL;
                $obj = $model::updateorCreate(['plan_id' => $this->planId, 'day_id' => $this->dayId], $data);

                $record = [];
                $record['warm_up'] = 1;
                $record['cool_down'] = 1;
                $record['is_main_workout_top'] = 1;
                $record['plan_training_overview_week_id'] = $obj->id;
                $tModel::updateOrCreate(['plan_id' => $this->planId, 'day_id' => $this->dayId], $record);
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
    public function TabContent(Request $request, $plan_id = NULL, $day_id = null, $isEdit = null)
    {

        $this->getDayPlanId();
        if ($request->isMethod('get')) {
            if (!empty($isEdit)) {
                $model = 'DraftPlan';
                $tModel = 'DraftPlanWeekTrainingSetup';
            } else {
                $model = 'Plan';
                $tModel = 'PlanWeekTrainingSetup';
            }
            $model = '\\App\Models\\' . $model;
            $tModel = '\\App\Models\\' . $tModel;
            $plan = $model::find($plan_id);
            if ($day_id == 8) {
                $days_data = 'One day';
            } else {
                $days_data = Day::find($day_id)->name;
            }
            $data = $tModel::planSetup($plan_id, $day_id)->first();
            $isMainWorkoutTop = (isset($data->is_main_workout_top)) ? $data->is_main_workout_top : 1;
            $view = view('client.plan.tab-content', compact('days_data', 'plan', 'day_id', 'data', 'isMainWorkoutTop'))->render();

            return response()->json(['view' => $view, 'isMainWorkoutTop' => $isMainWorkoutTop]);
        }

        $isEdit = $request->input('is_edit');
        $model = 'PlanTrainingOverviewWeek';
        $tModel = 'PlanWeekTrainingSetup';
        if (!empty($isEdit)) {
            $model = 'DraftPlanTrainingOverviewWeek';
            $tModel = 'DraftPlanWeekTrainingSetup';
        }
        $model = '\\App\Models\\' . $model;
        $tModel = '\\App\Models\\' . $tModel;
        $planOverview = $model::planOverView($request->plan_id, $request->day_id)->first();
        if (!empty($planOverview)) {
            if ($planOverview->day_plan_id != $this->dayPlanId) {
                $this->message = 'First please select day plan as training';
            } else {
                $this->data['warm_up'] = 1;
                $this->data['cardio'] = $request->has('cardio') ? 1 : 0;
                $this->data['cool_down'] = 1;
                $this->data['main_workout'] = $request->has('main_workout') ? 1 : 0;
                $this->data['is_main_workout_top'] = $request->input('is_main_workout_top');
                $this->data['plan_training_overview_week_id'] = $planOverview->id;
                $tModel::updateOrCreate(['plan_id' => $request->plan_id, 'day_id' => $request->day_id], $this->data);
                $this->success = true;
            }
        } else {
            $this->message = 'Please add/apply overview before add training plan structure';
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
        $isEdit = $request->input('is_edit');
        if (!empty($isEdit)){
            try {
                DB::beginTransaction();
                $sets = $request->input('set');
                $column = $request->input('set_type');
//            $setType = $column . '_' . 'set';
//            $exerciseType = $column . '_exercise_set';
                $workoutTypeSetId = WorkoutTypeSet::where('key_value', '=', $column)->first()->id;
                $obj = DraftPlanWeekTrainingSetup::where(['plan_id' => $request->input('id'), 'day_id' => $request->input('day_id')])->first();
//            $obj->$setType = $sets;
//            $obj->$exerciseType = $request->input('exercise_set');
                $obj->save();
//            PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', '=', $obj->id)->where('workout_type_set_id', '=', $workoutTypeSetId)->delete();
                $objPositionCount = DraftPlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', '=', $obj->id)->max('position');
                $workoutMainCount = DraftPlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', '=', $obj->id)->where('workout_type_set_id', '=', $workoutTypeSetId)->max('workout_main_counter');
                if (empty($objPositionCount))
                    $objPositionCount = 0;
                if(empty($workoutMainCount))
                    $workoutMainCount = 0;
                for ($i = 1; $i <= $sets; $i++) {
                    $objPositionCount = $objPositionCount + 1;
                    $workoutMainCount++;
                    $this->data[$i - 1]['plan_week_training_setup_id'] = $obj->id;
                    $this->data[$i - 1]['workout_type_set_id'] = $workoutTypeSetId;
                    $this->data[$i - 1]['workout_main_counter'] = $workoutMainCount;
                    $this->data[$i - 1]['exercise_set'] = $request->input('exercise_set');
                    $this->data[$i - 1]['position'] = $objPositionCount;
                    $this->data[$i - 1]['created_at'] = currentDateTime();
                    $this->data[$i - 1]['updated_at'] = currentDateTime();
                }
                DraftPlanWeekTrainingSetupPosition::insert($this->data);
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
        }
        else{
            try {
                DB::beginTransaction();
                $sets = $request->input('set');
                $column = $request->input('set_type');
//            $setType = $column . '_' . 'set';
//            $exerciseType = $column . '_exercise_set';
                $workoutTypeSetId = WorkoutTypeSet::where('key_value', '=', $column)->first()->id;
                $obj = PlanWeekTrainingSetup::where(['plan_id' => $request->input('id'), 'day_id' => $request->input('day_id')])->first();
//            $obj->$setType = $sets;
//            $obj->$exerciseType = $request->input('exercise_set');
                $obj->save();
//            PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', '=', $obj->id)->where('workout_type_set_id', '=', $workoutTypeSetId)->delete();
                $objPositionCount = PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', '=', $obj->id)->max('position');
                $workoutMainCount = PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', '=', $obj->id)->where('workout_type_set_id', '=', $workoutTypeSetId)->max('workout_main_counter');
                if (empty($objPositionCount))
                    $objPositionCount = 0;
                if(empty($workoutMainCount))
                    $workoutMainCount = 0;
                for ($i = 1; $i <= $sets; $i++) {
                    $objPositionCount = $objPositionCount + 1;
                    $workoutMainCount++;
                    $this->data[$i - 1]['plan_week_training_setup_id'] = $obj->id;
                    $this->data[$i - 1]['workout_type_set_id'] = $workoutTypeSetId;
                    $this->data[$i - 1]['workout_main_counter'] = $workoutMainCount;
                    $this->data[$i - 1]['exercise_set'] = $request->input('exercise_set');
                    $this->data[$i - 1]['position'] = $objPositionCount;
                    $this->data[$i - 1]['created_at'] = currentDateTime();
                    $this->data[$i - 1]['updated_at'] = currentDateTime();
                }
                PlanWeekTrainingSetupPosition::insert($this->data);
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
        }


        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * This is used to show edit page of plan creator
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function edit($id)
    {
        $planTypeMain = Plan::find($id)->plan_type;
        $editPlanId = $id;
        $objDraftPlan = DraftPlan::where('id',$editPlanId)->first();
        if (empty($objDraftPlan)) {
            if (empty($planTypeMain)) {
                $this->importWeekPlanOnEdit($editPlanId);
            } else {
                $this->importDayPlanOnEdit($editPlanId);
            }

        }
        $planType = '';
        $this->getUserId();
        $this->planId = $editPlanId;
        $this->isEquipmentEmptySelect = false;
        $this->isEmptySelect = true;
        $this->getPlanFilters();
        $this->isEmptyAll = true;
        $this->isEmptySelect = false;
        $this->getExerciseFilter();
        $obj = DraftPlan::find($this->planId);
        if (empty($obj) || empty(isAccess($this->userId, $obj->user_id))) {
            return redirect('plans');
        }
        $equipmentIds = $trainingDayIds = [];
        if ($obj) {
            $planType = $obj->plan_type;
            $trainingDayIds[] = $obj->training_day_id;
        }
        $workoutTypeSet = WorkoutTypeSet::pluck('set_exercises', 'key_value')->toArray();
        $objPlans = DraftPlan::select('eq.equipment_id as id')
            ->where('draft_plans.id',$id)
            ->join('draft_equipment_plans as eq','eq.plan_id','=','draft_plans.id')
            ->get()->toArray();
        foreach ($objPlans as $key => $row) {
            $equipmentIds[] = $row['id'];
        }
        $plan = $obj->toArray();
        $this->data['id'] = $this->planId;
        $this->data['plan'] = $plan;
        $this->data['equipmentIds'] = json_encode($equipmentIds);
        $this->data['trainingDayIds'] = json_encode($trainingDayIds);
        $this->data['workoutTypeSet'] = json_encode($workoutTypeSet);
        $this->data['isEdit'] = true;

        if ($planType == 0) {
            return View('client.plan.create', ['data' => $this->data]);
        } else if ($planType == 1) {
            return View('client.plan.one-day-plan.index', ['data' => $this->data]);
        }
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
        $isEdit = $request->input('is_edit');
        if (!empty($isEdit)) {
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
                $obj = DraftPlanTrainingOverviewWeek::select('day_plan_id', 'pwts.warm_up', 'pwts.main_workout', 'pwts.cardio', 'pwts.cool_down', 'pwts.is_main_workout_top', 'body_part_1', 'body_part_2', 'body_part_3')
                    ->Join('draft_plan_week_training_setups as pwts', function ($join) {
                        $join->on('pwts.plan_training_overview_week_id', '=', 'draft_plan_training_overview_weeks.id');
                        //todo need to be check
//                        $join->on('pwts.plan_id', '=', 'draft_plan_training_overview_weeks.plan_id');
//                        $join->on('pwts.day_id', '=', 'draft_plan_training_overview_weeks.day_id');
                    })
                    ->where('draft_plan_training_overview_weeks.plan_id', '=', $request->input('id'))
                    ->where('draft_plan_training_overview_weeks.day_id', '=', $key)
                    ->where('draft_plan_training_overview_weeks.day_plan_id', '=', $this->dayPlanId)
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
                    $objPlan = DraftPlanTrainingOverviewWeek::select('dp.name', 'dp.meta_description', 'key_value')
                        ->join('day_plans as dp', 'dp.id', '=', 'day_plan_id')
                        ->where('draft_plan_training_overview_weeks.plan_id', '=', $request->input('id'))
                        ->where('draft_plan_training_overview_weeks.day_id', '=', $key)
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
            }
        } else {
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
                    ->Join('plan_week_training_setups as pwts', function ($join) {
                        $join->on('pwts.plan_training_overview_week_id', '=', 'plan_training_overview_weeks.id');
                    })
                    ->where('plan_training_overview_weeks.plan_id', '=', $request->input('id'))->where('plan_training_overview_weeks.day_id', '=', $key)
                    ->where('plan_training_overview_weeks.day_plan_id', '=', $this->dayPlanId)
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
                        ->where('plan_training_overview_weeks.plan_id', '=', $request->input('id'))->where('plan_training_overview_weeks.day_id', '=', $key)
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
            }
        }
        $this->success = true;

        $view = view('client.plan.partials._weekly-training-plan', ['data' => $this->data])->render();

        return response()->json(['success' => $this->success, 'data' => $view, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to get weekly training plan setup
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function oneDayPlanWeeklyTrainingSetup(Request $request)
    {
        $isEdit = $request->input('is_edit');
        $days = ['8'=>'one day'];
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
            if (!empty($isEdit)) {
                $obj = DraftPlanTrainingOverviewWeek::select('day_plan_id', 'pwts.warm_up', 'pwts.main_workout', 'pwts.cardio', 'pwts.cool_down', 'pwts.is_main_workout_top', 'body_part_1', 'body_part_2', 'body_part_3')
                    ->Join('draft_plan_week_training_setups as pwts', function ($join) {
                        $join->on('pwts.plan_training_overview_week_id', '=', 'draft_plan_training_overview_weeks.id');
                    })
                    ->where('draft_plan_training_overview_weeks.plan_id', '=', $request->input('id'))->where('draft_plan_training_overview_weeks.day_id', '=', $key)
                    ->where('draft_plan_training_overview_weeks.day_plan_id', '=', $this->dayPlanId)
                    ->first();
            } else {
                $obj = PlanTrainingOverviewWeek::select('day_plan_id', 'pwts.warm_up', 'pwts.main_workout', 'pwts.cardio', 'pwts.cool_down', 'pwts.is_main_workout_top', 'body_part_1', 'body_part_2', 'body_part_3')
                    ->Join('plan_week_training_setups as pwts', function ($join) {
                        $join->on('pwts.plan_training_overview_week_id', '=', 'plan_training_overview_weeks.id');
                    })
                    ->where('plan_training_overview_weeks.plan_id', '=', $request->input('id'))->where('plan_training_overview_weeks.day_id', '=', $key)
                    ->where('plan_training_overview_weeks.day_plan_id', '=', $this->dayPlanId)
                    ->first();
            }
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
                $ptModel = 'PlanTrainingOverviewWeek';
                $prefix = 'plan_training_overview_weeks';
                if (!empty($isEdit)) {
                    $ptModel = 'DraftPlanTrainingOverviewWeek';
                    $prefix = 'draft_plan_training_overview_weeks';
                }
                $ptModel = '\\App\Models\\' . $ptModel;
                $objPlan = $ptModel::select('dp.name', 'dp.meta_description', 'key_value')
                    ->join('day_plans as dp', 'dp.id', '=', 'day_plan_id')
                    ->where($prefix.'.plan_id', '=', $request->input('id'))->where($prefix.'.day_id', '=', $key)
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
        }
        $this->success = true;

        $view = view('client.plan.one-day-plan.partials._day-training-plan', ['data' => $this->data])->render();

        return response()->json(['success' => $this->success, 'data' => $view, 'message' => $this->message], $this->statusCode);
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
        $coachId = loginId();
        $isEdit = $request->input('is_edit');
        if(!empty($isEdit)){
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
                $objTempTraining = DraftTempTrainingSetup::where(['plan_id' => $this->planId, 'day_id' => $dayId, 'structure_id' => $this->structureId])->orderBy('position', 'asc')->get();
                if (!empty($request->input('is_new'))) {
                    $position = $counter = 1;
                    if (count($objTempTraining)) {
                        $position = DraftTempTrainingSetup::where(['plan_id' => $this->planId, 'day_id' => $dayId, 'structure_id' => $this->structureId])->max('position') + 1;
                        $counter = DraftTempTrainingSetup::where(['plan_id' => $this->planId, 'day_id' => $dayId, 'structure_id' => $this->structureId])->max('workout_main_counter') + 1;
                    }
                    $objNew = DraftTempTrainingSetup::create(['plan_id' => $this->planId, 'day_id' => $dayId, 'structure_id' => $this->structureId, 'workout_main_counter' => $counter, 'position' => $position]);
                    $objTempTraining = DraftTempTrainingSetup::where('id', '=', $objNew->id)->get();
                }
            }
            if ($this->structureId == 2) {
                $view = '_drag_drop_box_main_workout';
                $this->data['rms'] = Rm::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
                $this->data['tempos'] = Tempo::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
                $this->data['rests'] = Rest::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
                $objPlanWeekTrainingSetup = DraftPlanWeekTrainingSetup::where('plan_id', '=', $this->planId)->where('day_id', '=', $dayId)->first();
                $this->data['training_setup'] = $objPlanWeekTrainingSetup;
                $this->params['id'] = $objPlanWeekTrainingSetup->id;
                $this->data['training_setup_position'] = DraftPlanWeekTrainingSetupPosition::getTrainingSetupData($this->params);
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
            $this->data['objTempTraining'] = $objTempTraining;
            $this->data['planId'] = $this->planId;
            $this->data['isNew'] = $request->input('is_new');
            $this->data['structureId'] = $this->structureId;
        }
        else{
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
                $objTempTraining = TempTrainingSetup::where(['plan_id' => $this->planId, 'day_id' => $dayId, 'structure_id' => $this->structureId])->orderBy('position', 'asc')->get();
                if (!empty($request->input('is_new'))) {
                    $position = $counter = 1;
                    if (count($objTempTraining)) {
                        $position = TempTrainingSetup::where(['plan_id' => $this->planId, 'day_id' => $dayId, 'structure_id' => $this->structureId])->max('position') + 1;
                        $counter = TempTrainingSetup::where(['plan_id' => $this->planId, 'day_id' => $dayId, 'structure_id' => $this->structureId])->max('workout_main_counter') + 1;
                    }
                    $objNew = TempTrainingSetup::create(['plan_id' => $this->planId, 'day_id' => $dayId, 'structure_id' => $this->structureId, 'workout_main_counter' => $counter, 'position' => $position]);
                    $objTempTraining = TempTrainingSetup::where('id', '=', $objNew->id)->get();
                }
            }
            if ($this->structureId == 2) {
                $view = '_drag_drop_box_main_workout';
                $this->data['rms'] = Rm::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
                $this->data['tempos'] = Tempo::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
                $this->data['rests'] = Rest::where('client_id',$coachId)->orWhereNull('client_id')->orderBy('created_at','desc')->orderBy('id')->pluck('value', 'id')->toArray() + $arr;
                $objPlanWeekTrainingSetup = PlanWeekTrainingSetup::where('plan_id', '=', $this->planId)->where('day_id', '=', $dayId)->first();
                $this->data['training_setup'] = $objPlanWeekTrainingSetup;
                $this->params['id'] = $objPlanWeekTrainingSetup->id;
                $this->data['training_setup_position'] = PlanWeekTrainingSetupPosition::getTrainingSetupData($this->params);
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
            $this->data['objTempTraining'] = $objTempTraining;
            $this->data['planId'] = $this->planId;
            $this->data['isNew'] = $request->input('is_new');
            $this->data['structureId'] = $this->structureId;
        }

        $this->data['isEdit'] = $isEdit;
        $this->success = true;
        $view = view('client.plan.partials.' . $view, $this->data)->render();

        return response()->json(['success' => $this->success, 'data' => $view, 'message' => $this->message, 'countRow' => $mainCounter, 'extraId' => $request->input('extraId')], $this->statusCode);
    }

    /**
     * This is used to get exercises data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getExercises(Request $request)
    {
        $this->params = [
            'perPage' => 10,
            'page' =>   $request->input('page'),
            'search' => $request->input('search'),
            'sortType' => $request->input('sortType'),
            'dropDownFilters' => $request->input('dropDownFilters')
        ];
        $this->data = Exercise::getExercises($this->params);
        $pager = '';
        if(!empty($this->data['pager'])) {
            $pager = $this->data['pager'];
        }
        $this->success = true;
        $view = view('client.plan.partials._exercises-data', ['data' => $this->data])->render();

        return response()->json(['success' => $this->success, 'data' => $view, 'message' => $this->message, 'pager' => $pager], $this->statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $splitId = explode('_', $id)[1];
        $obj = Plan::find($splitId);
        $this->message = 'There is problem to delete Plan';
        if ($obj && $obj->delete()) {
            $this->message = 'Plan is deleted successfully';
            $this->success = true;
        }

        return response()->json(['success' => $this->success, 'message' => $this->message, 'id' => $splitId]);
    }

    /**
     * This is used to add exercise in training plan setup
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addDragAndDropExercise(Request $request)
    {
        $isEdit = $request->input('is_edit');
        $this->planId = $request->input('id');
        $extraId = explode('_', $request->input('extraId'));
        $this->dayId = $extraId[0]; // dayid
        $this->structureId = $extraId[1]; // structure id
        $this->exerciseId = $request->input('exerciseId');
        $this->data = $request->input('dropDownFilters');
        $planName = Plan::find($this->planId)->name;

        if (!empty($isEdit)){
            if ($this->dayId == '8') {
                $dayName = 'One day';
            } else {
                $dayName = Day::find($this->dayId)->name;
            }
            $structureName = TrainingPlanStructure::find($this->structureId)->name;
            $this->isMainWorkout();
            $this->data['workout_set_type_id'] = 0;
            $this->data['exercise_id'] = $this->exerciseId;
            $this->data['position_id'] = $request->input('positionId');
            if (!empty($this->isMainWorkout)) {
                $this->data['workout_set_type_id'] = WorkoutTypeSet::where('key_value', '=', $request->input('workoutType'))->first()->id;
            }
            try {
                $obj = DraftPlanDragDropStructure::updateorCreate(
                    ['plan_id' => $this->planId, 'day_id' => $this->dayId, 'structure_id' => $this->structureId, 'workout_set_type_id' => $this->data['workout_set_type_id']
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
            $equipmentIds = [];
            $objExercises = DraftPlanDragDropStructure::select('eq.name','eq.id')
                ->where('plan_id',$this->planId)
                ->join('exercises as e','e.id','=','draft_plan_drag_drop_structures.exercise_id')
                ->join('equipment as eq','eq.id','=','e.equipment_id')
                ->groupBy('eq.id')
                ->get()->toArray();
//            dd($objExercises);
            foreach ($objExercises as $key => $row) {
                $equipmentData[$key]['equipment_id'] = $row['id'];
                $equipmentData[$key]['plan_id'] = $this->planId;
                $equipmentIds[] = $row['id'];
            }
            if(!empty($equipmentData)){
                DraftEquipmentPlan::where('plan_id',$this->planId)->delete();
                DraftEquipmentPlan::insert($equipmentData);
            }

//            dd($equipmentIds);
        }
        else{
            if ($this->dayId == '8') {
                $dayName = 'One day';
            } else {
                $dayName = Day::find($this->dayId)->name;
            }
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
                    ['plan_id' => $this->planId, 'day_id' => $this->dayId, 'structure_id' => $this->structureId, 'workout_set_type_id' => $this->data['workout_set_type_id']
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
            $equipmentIds = [];
            $objExercises = PlanDragDropStructure::select('eq.name','eq.id')
                ->where('plan_id',$this->planId)
                ->join('exercises as e','e.id','=','plan_drag_drop_structures.exercise_id')
                ->join('equipment as eq','eq.id','=','e.equipment_id')
                ->groupBy('eq.id')
                ->get()->toArray();
            foreach ($objExercises as $key => $row) {
                $equipmentIds[] = $row['id'];
            }
        }



        return response()->json(['success' => $this->success, 'message' => $this->message, 'id' => $this->planId, 'name' => $exerciseName,'exercise_image'=>$exerciseImage, 'dragDropId' => $this->dragDropId,'equipmentIds' => $equipmentIds]);
    }

    /**
     * This is used to delete training plan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTrainingPlan(Request $request)
    {
        $isEdit = $request->input('is_edit');
        $deleteId = explode('_', $request->input('deleteId'));
        try {
            if (!empty($isEdit)){
                if (!empty($deleteId)) {
                    DB::beginTransaction();
                    $this->dayId = $deleteId[0];
                    $this->structureId = $deleteId[1];
                    $countRow = $deleteId[2];
                    $this->planId = $request->input('id');
                    $obj = DraftPlanDragDropStructure::where(['plan_id' => $this->planId, 'day_id' => $this->dayId,
                        'structure_id' => $this->structureId, 'workout_counter' => $countRow
                    ])->first();
                    if ($obj) {
                        $obj->delete();
                    }
                    $objTemp = DraftTempTrainingSetup::where(['plan_id' => $this->planId, 'day_id' => $this->dayId,
                        'structure_id' => $this->structureId, 'workout_main_counter' => $countRow
                    ])->first();
                    if ($objTemp) {
                        $objTemp->delete();
                    }
                    $this->success = true;
                    $this->message = 'Record is deleted successfully';
                    DB::commit();
                    $this->success = true;
                }
            }
            else{
                if (!empty($deleteId)) {
                    DB::beginTransaction();
                    $this->dayId = $deleteId[0];
                    $this->structureId = $deleteId[1];
                    $countRow = $deleteId[2];
                    $this->planId = $request->input('id');
                    $obj = PlanDragDropStructure::where(['plan_id' => $this->planId, 'day_id' => $this->dayId,
                        'structure_id' => $this->structureId, 'workout_counter' => $countRow
                    ])->first();
                    if ($obj) {
                        $obj->delete();
                    }
                    $objTemp = TempTrainingSetup::where(['plan_id' => $this->planId, 'day_id' => $this->dayId,
                        'structure_id' => $this->structureId, 'workout_main_counter' => $countRow
                    ])->first();
                    if ($objTemp) {
                        $objTemp->delete();
                    }
                    $this->success = true;
                    $this->message = 'Record is deleted successfully';
                    DB::commit();
                    $this->success = true;
                }
            }

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            $this->message = $e->errorInfo[2];
        }

        return response()->json(['success' => $this->success, 'message' => $this->message, 'id' => $request->input('deleteId')]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPlanComment(Request $request)
    {
        $isEdit = $request->input('is_edit');
        $this->planId = $request->input('id');
        $this->dayId = $request->input('dayId');
        $this->data['comment'] = $request->input('comment');
        if (!empty($isEdit)){
            DraftPlanTrainingComment::updateorCreate(
                ['plan_id' => $this->planId, 'day_id' => $this->dayId]
                , $this->data);

            $this->success = true;
        }else{
            PlanTrainingComment::updateorCreate(
                ['plan_id' => $this->planId, 'day_id' => $this->dayId]
                , $this->data);

            $this->success = true;
        }

        $this->message = 'Comment is added successfully';

        return response()->json(['success' => $this->success, 'message' => $this->message, 'id' => $request->input('id')]);
    }

    /**
     *
     *
     * @param Request $request
     */
    public function updatePlanDragAndDrop(Request $request)
    {
        $isEdit = $request->input('is_edit');
        if (!empty($isEdit)) {
            $obj = DraftPlanDragDropStructure::find($request->input('clickedDragAndDropId'));
        } else {
            $obj = PlanDragDropStructure::find($request->input('clickedDragAndDropId'));
        }
        if ($obj) {
            $clickedId = $request->input('clickedId');
            $obj->$clickedId = (int)$request->input('clickedValue');
            $obj->save();
        }
    }

    /**
     * This is used to update order workout
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrderWorkout(Request $request)
    {
        $this->isEdit = $request->input('isEdit');
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
                    $model = 'TempTrainingSetup';
                    if (!empty($this->isEdit)) {
                        $model = 'DraftTempTrainingSetup';
                    }
                    $model = '\\App\Models\\' . $model;
                    $instance = new $model();

                } else {
                    $model = 'PlanWeekTrainingSetupPosition';
                    if (!empty($this->isEdit)) {
                        $model = 'DraftPlanWeekTrainingSetupPosition';
                    }
                    $model = '\\App\Models\\' . $model;
                    $instance = new $model();
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
     * This is used to delete main training workout
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTrainingMainWorkout(Request $request)
    {
        $isEdit = $request->input('is_edit');
        $deleteId = $request->input('deleteId');
        $extraId = explode('_', $request->input('extraId'));
        $this->dayId = $extraId[2];
        $this->structureId = $extraId[3];
        $this->planId = $request->input('id');
        try {
            if (!empty($isEdit)){
                if (!empty($deleteId)) {
                    DB::beginTransaction();
                    $splitDeleteId = explode('_', $deleteId);
                    $planWeekTrainingSetupId = $splitDeleteId[1];
                    $workoutTypeSetId = $splitDeleteId[2];
                    $pWorkoutMainMounter = $splitDeleteId[3];
                    DraftPlanDragDropStructure::where(['plan_id' => $this->planId, 'day_id' => $this->dayId,
                        'structure_id' => $this->structureId, 'workout_set_type_id' => $workoutTypeSetId, 'workout_counter' => $pWorkoutMainMounter
                    ])->delete();

                    DraftPlanWeekTrainingSetupPosition::where(['plan_week_training_setup_id' => $planWeekTrainingSetupId,
                        'workout_type_set_id' => $workoutTypeSetId, 'workout_main_counter' => $pWorkoutMainMounter])
                        ->delete();
                    DB::commit();
                    $this->success = true;
                }
            }
            else{
                if (!empty($deleteId)) {
                    DB::beginTransaction();
                    $splitDeleteId = explode('_', $deleteId);
                    $planWeekTrainingSetupId = $splitDeleteId[1];
                    $workoutTypeSetId = $splitDeleteId[2];
                    $pWorkoutMainMounter = $splitDeleteId[3];
                    PlanDragDropStructure::where(['plan_id' => $this->planId, 'day_id' => $this->dayId,
                        'structure_id' => $this->structureId, 'workout_set_type_id' => $workoutTypeSetId, 'workout_counter' => $pWorkoutMainMounter
                    ])->delete();

                    PlanWeekTrainingSetupPosition::where(['plan_week_training_setup_id' => $planWeekTrainingSetupId,
                        'workout_type_set_id' => $workoutTypeSetId, 'workout_main_counter' => $pWorkoutMainMounter])
                        ->delete();
                    DB::commit();
                    $this->success = true;
                }
            }

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            $this->message = $e->errorInfo[2];
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * This is used to get exercises video
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getExerciseVideo(Request $request)
    {
        $this->exerciseId = explode('_', $request->input('exerciseId'))[1];
        $obj = Exercise::find($this->exerciseId);
        $data = [
            'exerciseId' => $this->exerciseId,
            'name' => $obj->name,
            'source' => $obj->male_gif
        ];

        $view = view('client.plan.partials._exercise-popup', compact('data'))->render();

        return response()->json(['view' => $view, 'exerciseId' => $this->exerciseId]);
    }
    /**
     * this is used to import plan from program database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function importPlan(Request $request)
    {
        $this->isEdit = $request->input('is_edit');
        $planTableId = $request->input('plan_table_id');
        $planId = $request->input('plan_id');
        $clientId = loginId();
        $importDayId = (int)$request->input('import_day_id');
        $this->planId = $planTableId;
        $planType = Plan::select('plan_type')->
        where('id', $planId)
            ->first();
        try {
            DB::beginTransaction();
            if($this->planId != $planId) {
                if ($planType->plan_type == 1) {
                    if(!empty($this->isEdit))
                    {
                        $ids = DraftPlanWeekTrainingSetup::select('id')->where(['day_id' => $importDayId, 'plan_id' => $this->planId])->get()->toArray();
                            DraftPlanWeekTrainingSetupPosition::whereIn('plan_week_training_setup_id', $ids)->delete();

                        $planOverviewWeekObj = \App\Models\PlanTrainingOverviewWeek::where(['plan_id' => $planId, 'day_id' => 8])
                            ->get([
                                'plan_id', 'day_id', 'day_plan_id', 'body_part_1', 'body_part_2', 'body_part_3'])
                            ->toArray();
                        foreach ($planOverviewWeekObj as $key => $row) {
                            $planOverviewWeekObj[$key]['plan_id'] = $this->planId;
                            $planOverviewWeekObj[$key]['day_id'] = $importDayId;
                        }
                        $arrOverViewWeek = [];
                        for ($i = 0; $i < 7; $i++) {
                            $arrOverViewWeek[$i + 1]['day_id'] = $i + 1;
                            $arrOverViewWeek[$i + 1]['day_plan_id'] = 2;
                            $arrOverViewWeek[$i + 1]['plan_id'] = $this->planId;
                            $arrOverViewWeek[$i + 1]['body_part_1'] = '';
                            $arrOverViewWeek[$i + 1]['body_part_2'] = '';
                            $arrOverViewWeek[$i + 1]['body_part_3'] = '';
                        }
                        $mergArray = array_merge($arrOverViewWeek, $planOverviewWeekObj);
                        $mergeOverview = array_column($mergArray, null, 'day_id');
                        DraftPlanTrainingOverviewWeek::where('plan_id', $this->planId)
                            ->where('day_id', $importDayId)
                            ->delete();
                        $testOverview = DraftPlanTrainingOverviewWeek::select('id')->where('plan_id',$this->planId)
                            ->where('day_plan_id',1) //  for Training
                            ->get();
//                    if(!$testOverview->isEmpty()){
//                        PlanTrainingOverviewWeek::insert($planOverviewWeekObj);
//                    }else{
//                        PlanTrainingOverviewWeek::insert($mergeOverview);
//                    }
                        DraftPlanTrainingOverviewWeek::insert($planOverviewWeekObj);
                        // Plan Week Training setup
                        $planTrainingSetupObj = \App\Models\PlanWeekTrainingSetup::where('plan_id', $planId)
                            ->get([
                                'id', 'plan_id', 'day_id', 'plan_training_overview_week_id',
                                'warm_up', 'main_workout', 'cardio', 'cool_down', 'is_main_workout_top'])
                            ->toArray();
                        $objPlanTrainingOverviewIds = DraftPlanTrainingOverviewWeek::select('id')->where('plan_id', $this->planId)
                            ->where('day_id', $importDayId)
                            ->get()->toArray();
                        foreach ($planTrainingSetupObj as $key => $row) {
                            $planTrainingSetupObj[$key]['plan_id'] = $this->planId;
                            $planTrainingSetupObj[$key]['plan_training_overview_week_id'] = $objPlanTrainingOverviewIds[$key]['id'];
                            $planTrainingSetupObj[$key]['id'] = '';
                            $planTrainingSetupObj[$key]['day_id'] = $importDayId;
                        }
                        DraftPlanWeekTrainingSetup::where('plan_id', $this->planId)
                            ->where('day_id', $importDayId)
                            ->delete();
                        DraftPlanWeekTrainingSetup::insert($planTrainingSetupObj);

                        // plan week training setup position
                        $planSetupId = \App\Models\PlanWeekTrainingSetup::select('id','day_id')->where('plan_id', $planId)
                            ->orderBy('day_id')->get()->toArray();

                        $planSetupId = array_column($planSetupId, null, 'day_id');

                        $clientPlanSetupTrainingObjIds = DraftPlanWeekTrainingSetup::where('plan_id', $this->planId)
                            ->where('day_id', $importDayId)
                            ->orderBy('day_id')
                            ->get()->toArray();

                        $clientPlanSetupTrainingObjIds = array_column($clientPlanSetupTrainingObjIds, null, 'day_id');

                        foreach ($planSetupId as $key => $setupId) {
                            $planWeekTrainingSetupPositionObj = \App\Models\PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', $setupId['id'])
                                ->get(['plan_week_training_setup_id', 'workout_type_set_id',
                                    'workout_main_counter', 'position', 'exercise_set'])
                                ->toArray();
                            // todo need to enable this
//                            $ids = DraftPlanWeekTrainingSetup::select('id')->where(['day_id' => $importDayId, 'plan_id' => $this->planId])->get()->toArray();
//                            DraftPlanWeekTrainingSetupPosition::whereIn('plan_week_training_setup_id', $ids)->delete();
                            if ($planWeekTrainingSetupPositionObj) {
                                if (!empty($clientPlanSetupTrainingObjIds[$importDayId])) {
                                    foreach ($planWeekTrainingSetupPositionObj as $item) {
                                        $item['plan_week_training_setup_id'] = $clientPlanSetupTrainingObjIds[$importDayId]['id'];
                                        DraftPlanWeekTrainingSetupPosition::insert($item);
                                    }
                                }
                            }
                        }
                        // temp table
                        $tempTrainingSetupObj = \App\Models\TempTrainingSetup::where('plan_id', $planId)
                            ->get(['plan_id', 'day_id', 'structure_id', 'workout_main_counter', 'position'])
                            ->toArray();

                        foreach ($tempTrainingSetupObj as $key => $row) {
                            $tempTrainingSetupObj[$key]['plan_id'] = $this->planId;
                            if ($tempTrainingSetupObj[$key]['day_id'] == 8)
                                $tempTrainingSetupObj[$key]['day_id'] = $importDayId;
                        }

                        DraftTempTrainingSetup::where('plan_id', $this->planId)
                            ->where('day_id', $importDayId)
                            ->delete();
                        DraftTempTrainingSetup::insert($tempTrainingSetupObj);
                        // drag drop table

                        $clientTempTrainingSetupObj = DraftTempTrainingSetup::where('plan_id', $this->planId)->get()->toArray();
                        $arrTemp = [];
                        foreach ($clientTempTrainingSetupObj as $row) {
                            $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_main_counter']] = $row['id'];
                        }

                        $planDragDropStructureObj = \App\Models\PlanDragDropStructure::where('plan_id', $planId)
                            ->get(['plan_id', 'day_id', 'structure_id', 'exercise_id', 'workout_counter', 'workout_sub_counter',
                                'workout_type', 'workout_set_type_id', 'position', 'position_id', 'set_id', 'rep_id', 'duration_id',
                                'note_id', 'rm_id', 'tempo_id', 'rest_id', 'form_id', 'stage_id', 'wr_id'])
                            ->toArray();
                        foreach ($planDragDropStructureObj as $key => $row) {
                            $planDragDropStructureObj[$key]['plan_id'] = $this->planId;
                            $planDragDropStructureObj[$key]['day_id'] = $importDayId;
                        }

                        $clientWeekTrainingSetup = DraftPlanWeekTrainingSetup::select('day_id', 'cp.id', 'workout_type_set_id', 'workout_main_counter')
                            ->where('plan_id', '=', $this->planId)
                            ->join('draft_plan_week_training_setup_positions as cp', 'cp.plan_week_training_setup_id', '=', 'draft_plan_week_training_setups.id')
                            ->get()->toArray();
                        $arrTempPlan = [];
                        foreach ($clientWeekTrainingSetup as $row) {
                            $arrTempPlan[$planId][$row['day_id']][$row['workout_type_set_id']][$row['workout_main_counter']] = $row['id'];
                        }
                        foreach ($planDragDropStructureObj as $key => $row) {
                            $planDragDropStructureObj[$key]['plan_id'] = $this->planId;
                            if ($row['structure_id'] != 2 && !empty($arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']])) {
                                $planDragDropStructureObj[$key]['position_id'] = $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']];
                            } elseif ($row['structure_id'] == 2 && !empty($arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']])) {
                                $planDragDropStructureObj[$key]['position_id'] = $arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']];
                            }
                        }
                        DraftPlanDragDropStructure::where('plan_id', $this->planId)
                            ->where('day_id', $importDayId)
                            ->delete();
                        DraftPlanDragDropStructure::insert($planDragDropStructureObj);

                        // plan comment table
                        $planTrainingCommentObj = \App\Models\PlanTrainingComment::where('plan_id', $planId)
                            ->get(['plan_id', 'day_id', 'comment'])
                            ->toArray();
                        foreach ($planTrainingCommentObj as $key => $row) {
                            $planTrainingCommentObj[$key]['plan_id'] = $this->planId;
                            $planTrainingCommentObj[$key]['day_id'] = $importDayId;
                        }
                        DraftPlanTrainingComment::where('plan_id', $this->planId)
                            ->where('day_id', $importDayId)
                            ->delete();
                        DraftPlanTrainingComment::insert($planTrainingCommentObj);
                        $this->success = true;
                        $this->message = "Day plan imported successfully";

                    }
                    else {

                        $ids = PlanWeekTrainingSetup::select('id')->where(['day_id' => $importDayId, 'plan_id' => $this->planId])->get()->toArray();
                        PlanWeekTrainingSetupPosition::whereIn('plan_week_training_setup_id', $ids)->delete();

                        $planOverviewWeekObj = \App\Models\PlanTrainingOverviewWeek::where(['plan_id' => $planId, 'day_id' => 8])
                            ->get([
                                'plan_id', 'day_id', 'day_plan_id', 'body_part_1', 'body_part_2', 'body_part_3'])
                            ->toArray();
                        foreach ($planOverviewWeekObj as $key => $row) {
                            $planOverviewWeekObj[$key]['plan_id'] = $this->planId;
                            $planOverviewWeekObj[$key]['day_id'] = $importDayId;
                        }
                        $arrOverViewWeek = [];
                        for ($i = 0; $i < 7; $i++) {
                            $arrOverViewWeek[$i + 1]['day_id'] = $i + 1;
                            $arrOverViewWeek[$i + 1]['day_plan_id'] = 2;
                            $arrOverViewWeek[$i + 1]['plan_id'] = $this->planId;
                            $arrOverViewWeek[$i + 1]['body_part_1'] = '';
                            $arrOverViewWeek[$i + 1]['body_part_2'] = '';
                            $arrOverViewWeek[$i + 1]['body_part_3'] = '';
                        }
                        $mergArray = array_merge($arrOverViewWeek, $planOverviewWeekObj);
                        $mergeOverview = array_column($mergArray, null, 'day_id');
                        PlanTrainingOverviewWeek::where('plan_id', $this->planId)
                            ->where('day_id', $importDayId)
                            ->delete();
                        $testOverview = PlanTrainingOverviewWeek::select('id')->where('plan_id',$this->planId)
                            ->where('day_plan_id',1) //  for Training
                            ->get();
//                    if(!$testOverview->isEmpty()){
//                        PlanTrainingOverviewWeek::insert($planOverviewWeekObj);
//                    }else{
//                        PlanTrainingOverviewWeek::insert($mergeOverview);
//                    }
                        PlanTrainingOverviewWeek::insert($planOverviewWeekObj);
                        // Plan Week Training setup
                        $planTrainingSetupObj = \App\Models\PlanWeekTrainingSetup::where('plan_id', $planId)
                            ->where('day_id',8)
                            ->get([
                                'id', 'plan_id', 'day_id', 'plan_training_overview_week_id',
                                'warm_up', 'main_workout', 'cardio', 'cool_down', 'is_main_workout_top'])
                            ->toArray();
                        $objPlanTrainingOverviewIds = PlanTrainingOverviewWeek::select('id')->where('plan_id', $this->planId)
                            ->where('day_id', $importDayId)
                            ->orderBy('day_id')
                            ->get()->toArray();
                        foreach ($planTrainingSetupObj as $key => $row) {
                            $planTrainingSetupObj[$key]['plan_id'] = $this->planId;
                            $planTrainingSetupObj[$key]['plan_training_overview_week_id'] = $objPlanTrainingOverviewIds[$key]['id'];
                            $planTrainingSetupObj[$key]['id'] = '';
                            $planTrainingSetupObj[$key]['day_id'] = $importDayId;
                        }
                        PlanWeekTrainingSetup::where('plan_id', $this->planId)
                            ->where('day_id', $importDayId)
                            ->delete();
                        PlanWeekTrainingSetup::insert($planTrainingSetupObj);

                        // plan week training setup position
                        $planSetupId = \App\Models\PlanWeekTrainingSetup::select('id', 'day_id')->where('plan_id', $planId)->get()->toArray();
                        $clientPlanSetupTrainingObjIds = PlanWeekTrainingSetup::where('plan_id', $this->planId)
                            ->where('day_id', $importDayId)
                            ->get()->toArray();

                        $clientPlanSetupTrainingObjIds = array_column($clientPlanSetupTrainingObjIds, null, 'day_id');
                        $planSetupId = array_column($planSetupId, null, 'day_id');

                        foreach ($planSetupId as $key => $setupId) {
                            $planWeekTrainingSetupPositionObj = \App\Models\PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', $setupId['id'])
                                ->get(['plan_week_training_setup_id', 'workout_type_set_id',
                                    'workout_main_counter', 'position', 'exercise_set'])
                                ->toArray();
//                            PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', $clientPlanSetupTrainingObjIds[$key]['id'])->delete();
                            if ($planWeekTrainingSetupPositionObj) {
                                if (!empty($clientPlanSetupTrainingObjIds[$importDayId])) {
                                    foreach ($planWeekTrainingSetupPositionObj as $item) {
                                        $item['plan_week_training_setup_id'] = $clientPlanSetupTrainingObjIds[$importDayId]['id'];
                                        PlanWeekTrainingSetupPosition::insert($item);
                                    }
                                }
                            }
                        }
                        // temp table
                        $tempTrainingSetupObj = \App\Models\TempTrainingSetup::where('plan_id', $planId)
                            ->get(['plan_id', 'day_id', 'structure_id', 'workout_main_counter', 'position'])
                            ->toArray();

                        foreach ($tempTrainingSetupObj as $key => $row) {
                            $tempTrainingSetupObj[$key]['plan_id'] = $this->planId;
                            if ($tempTrainingSetupObj[$key]['day_id'] == 8)
                                $tempTrainingSetupObj[$key]['day_id'] = $importDayId;
                        }

                        TempTrainingSetup::where('plan_id', $this->planId)
                            ->where('day_id', $importDayId)
                            ->delete();
                        TempTrainingSetup::insert($tempTrainingSetupObj);
                        // drag drop table

                        $clientTempTrainingSetupObj = TempTrainingSetup::where('plan_id', $this->planId)->get()->toArray();
                        $arrTemp = [];
                        foreach ($clientTempTrainingSetupObj as $row) {
                            $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_main_counter']] = $row['id'];
                        }

                        $planDragDropStructureObj = \App\Models\PlanDragDropStructure::where('plan_id', $planId)
                            ->get(['plan_id', 'day_id', 'structure_id', 'exercise_id', 'workout_counter', 'workout_sub_counter',
                                'workout_type', 'workout_set_type_id', 'position', 'position_id', 'set_id', 'rep_id', 'duration_id',
                                'note_id', 'rm_id', 'tempo_id', 'rest_id', 'form_id', 'stage_id', 'wr_id'])
                            ->toArray();
                        foreach ($planDragDropStructureObj as $key => $row) {
                            $planDragDropStructureObj[$key]['plan_id'] = $this->planId;
                            $planDragDropStructureObj[$key]['day_id'] = $importDayId;
                        }

                        $clientWeekTrainingSetup = PlanWeekTrainingSetup::select('day_id', 'cp.id', 'workout_type_set_id', 'workout_main_counter')
                            ->where('plan_id', '=', $this->planId)
                            ->join('plan_week_training_setup_positions as cp', 'cp.plan_week_training_setup_id', '=', 'plan_week_training_setups.id')
                            ->get()->toArray();
                        $arrTempPlan = [];
                        foreach ($clientWeekTrainingSetup as $row) {
                            $arrTempPlan[$planId][$row['day_id']][$row['workout_type_set_id']][$row['workout_main_counter']] = $row['id'];
                        }
                        foreach ($planDragDropStructureObj as $key => $row) {
                            $planDragDropStructureObj[$key]['plan_id'] = $this->planId;
                            if ($row['structure_id'] != 2 && !empty($arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']])) {
                                $planDragDropStructureObj[$key]['position_id'] = $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']];
                            } elseif ($row['structure_id'] == 2 && !empty($arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']])) {
                                $planDragDropStructureObj[$key]['position_id'] = $arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']];
                            }
                        }
                        PlanDragDropStructure::where('plan_id', $this->planId)
                            ->where('day_id', $importDayId)
                            ->delete();
                        PlanDragDropStructure::insert($planDragDropStructureObj);

                        // plan comment table
                        $planTrainingCommentObj = \App\Models\PlanTrainingComment::where('plan_id', $planId)
                            ->get(['plan_id', 'day_id', 'comment'])
                            ->toArray();
                        foreach ($planTrainingCommentObj as $key => $row) {
                            $planTrainingCommentObj[$key]['plan_id'] = $this->planId;
                            $planTrainingCommentObj[$key]['day_id'] = $importDayId;
                        }
                        PlanTrainingComment::where('plan_id', $this->planId)
                            ->where('day_id', $importDayId)
                            ->delete();
                        PlanTrainingComment::insert($planTrainingCommentObj);
                        $this->success = true;
                        $this->message = "Day plan imported successfully";
                    }
                }
                else if ($planType->plan_type == 0) {
                    $objPlan = Plan::find($planId);
                    Plan::where('id',$this->planId)->update(['training_day_id' => $objPlan->training_day_id]);

                    // Plan training Overview Week
                    $planOverviewWeekObj = \App\Models\PlanTrainingOverviewWeek::where('plan_id', $planId)
                        ->groupBy('day_id')
                        ->get([
                            'plan_id', 'day_id', 'day_plan_id', 'body_part_1', 'body_part_2', 'body_part_3'])
                        ->toArray();
                    foreach ($planOverviewWeekObj as $key => $row) {
                        $planOverviewWeekObj[$key]['plan_id'] = $this->planId;
                    }
                    PlanTrainingOverviewWeek::where('plan_id', $this->planId)->delete();
                    PlanTrainingOverviewWeek::insert($planOverviewWeekObj);

                    // Plan Week Training setup
                    $arrayPlanTrainingSetup = [];
                    $planTrainingSetupObj = \App\Models\PlanWeekTrainingSetup::where('plan_id', $planId)
                        ->get([
                            'plan_id', 'day_id', 'plan_training_overview_week_id',
                            'warm_up', 'main_workout', 'cardio', 'cool_down', 'is_main_workout_top'])
                        ->toArray();
                    array_multisort(array_column($planTrainingSetupObj, 'day_id'), SORT_ASC, $planTrainingSetupObj);
                    $objPlanTrainingOverviewIds = PlanTrainingOverviewWeek::select('id')->where('plan_id', $this->planId)->get()->toArray();

                    foreach ($planTrainingSetupObj as $key => $row) {
                        $planTrainingSetupObj[$key]['plan_id'] = $this->planId;
                        $planTrainingSetupObj[$key]['plan_training_overview_week_id'] = $objPlanTrainingOverviewIds[$key]['id'];
//                $planTrainingSetupObj[$key]['id'] = '';
                    }
                    PlanWeekTrainingSetup::where('plan_id', $this->planId)->delete();
                    PlanWeekTrainingSetup::insert($planTrainingSetupObj);
//            echo '<pre>'; print_r($planTrainingSetupObj); exit;

                    // plan week training setup position
                    $planSetupId = \App\Models\PlanWeekTrainingSetup::select('id')->where('plan_id', $planId)->get()->toArray();
                    $clientPlanSetupTrainingObjIds = PlanWeekTrainingSetup::where('plan_id', $this->planId)->get()->toArray();

                    foreach ($planSetupId as $key => $setupId) {
                        $planWeekTrainingSetupPositionObj = \App\Models\PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', $setupId['id'])
                            ->get(['plan_week_training_setup_id', 'workout_type_set_id',
                                'workout_main_counter', 'position', 'exercise_set'])
                            ->toArray();

                        PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', $clientPlanSetupTrainingObjIds[$key]['id'])->delete();
                        if ($planWeekTrainingSetupPositionObj) {
                            foreach ($planWeekTrainingSetupPositionObj as $item) {
                                $item['plan_week_training_setup_id'] = $clientPlanSetupTrainingObjIds[$key]['id'];
                                PlanWeekTrainingSetupPosition::insert($item);
                            }
                        }
                    }

                    // temp table
                    $tempTrainingSetupObj = \App\Models\TempTrainingSetup::where('plan_id', $planId)
                        ->get(['plan_id', 'day_id', 'structure_id', 'workout_main_counter', 'position'])
                        ->toArray();
                    foreach ($tempTrainingSetupObj as $key => $row) {
                        $tempTrainingSetupObj[$key]['plan_id'] = $this->planId;
                    }
                    TempTrainingSetup::where('plan_id', $this->planId)->delete();
                    TempTrainingSetup::insert($tempTrainingSetupObj);
                    // drag drop table

                    $clientTempTrainingSetupObj = TempTrainingSetup::where('plan_id', $this->planId)->get()->toArray();
                    $arrTemp = [];
                    foreach ($clientTempTrainingSetupObj as $row) {
                        $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_main_counter']] = $row['id'];
                    }
                    $planDragDropStructureObj = \App\Models\PlanDragDropStructure::where('plan_id', $planId)
                        ->get(['plan_id','day_id', 'structure_id', 'exercise_id', 'workout_counter', 'workout_sub_counter',
                            'workout_type', 'workout_set_type_id', 'position', 'position_id', 'set_id', 'rep_id', 'duration_id',
                            'note_id', 'rm_id', 'tempo_id', 'rest_id', 'form_id', 'stage_id', 'wr_id'])
                        ->toArray();
                    $clientWeekTrainingSetup = PlanWeekTrainingSetup::select('day_id', 'cp.id', 'workout_type_set_id', 'workout_main_counter')
                        ->where('plan_id', '=', $this->planId)
                        ->join('plan_week_training_setup_positions as cp', 'cp.plan_week_training_setup_id', '=', 'plan_week_training_setups.id')
                        ->get()->toArray();
                    $arrTempPlan = [];
                    foreach ($clientWeekTrainingSetup as $row) {
                        $arrTempPlan[$planId][$row['day_id']][$row['workout_type_set_id']][$row['workout_main_counter']] = $row['id'];
                    }
                    foreach ($planDragDropStructureObj as $key => $row) {
                        $planDragDropStructureObj[$key]['plan_id'] = $this->planId;
                        if ($row['structure_id'] != 2 && !empty($arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']])) {
                            $planDragDropStructureObj[$key]['position_id'] = $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']];
                        } elseif ($row['structure_id'] == 2 && !empty($arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']])) {
                            $planDragDropStructureObj[$key]['position_id'] = $arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']];
                        }
                    }
                    PlanDragDropStructure::where('plan_id', $this->planId)->delete();
                    PlanDragDropStructure::insert($planDragDropStructureObj);

                    // plan comment table
                    $planTrainingCommentObj = \App\Models\PlanTrainingComment::where('plan_id', $planId)
                        ->get(['plan_id', 'day_id', 'comment'])
                        ->toArray();
                    foreach ($planTrainingCommentObj as $key => $row) {
                        $planTrainingCommentObj[$key]['plan_id'] = $this->planId;
                    }
                    PlanTrainingComment::where('plan_id', $this->planId)->delete();
                    PlanTrainingComment::insert($planTrainingCommentObj);
                    $this->success = true;
                    $this->message = "Day plan imported successfully";
                }
                // Plan training Overview Week
                DB::commit();
            } else {
                $this->success = true;
            }
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * this is used to create new plan on create plan button click
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPlanOnCreate(Request $request)
    {
        $planId = $request->input('plan_id');
        $obj = Plan::where(['is_completed' => 1, 'plan_type' => $request->input('plan_type')])
            ->where('id', $planId)
            ->first();
        if (!$obj) {
            $userId = loginId();
            $obj = Plan::where(['user_id' => $userId ,'is_completed' => 0, 'plan_type' => $request->input('plan_type')])
                ->first();

            if (!$obj) {
                $obj = new Plan();
            }
            $obj->user_id = $userId;
            $obj->is_completed = 0;
            $obj->plan_type = $request->input('plan_type');
            $obj->save();
        }
        $this->success = true;
        $this->data['id'] = $obj->id;

        return response()->json(['success' => $this->success, 'data' => $this->data]);
    }

    /**
     * This is used to delete draft. It will delete data from all tables
     *
     * @param Request $request
     */
    public function deleteDraftPlan(Request $request)
    {
        $this->planId = $request->input('plan_id');
        $isEdit = $request->input('is_edit');
        if (!empty($isEdit)) {
            try {
                DB::beginTransaction();
                DraftPlan::where('id', $this->planId)->delete();
                DraftPlanTrainingOverviewWeek::where('plan_id', '=', $this->planId)->delete();
                $ids = DraftPlanWeekTrainingSetup::select('id')->where('plan_id', '=', $this->planId)->get();
                if (!empty($ids)) {
                    $ids = array_column($ids->toArray(), 'id');
                    DraftPlanWeekTrainingSetupPosition::whereIn('plan_week_training_setup_id', $ids)->delete();
                }
                DraftTempTrainingSetup::where('plan_id', '=', $this->planId)->delete();
                DraftPlanDragDropStructure::where('plan_id', '=', $this->planId)->delete();
                DraftPlanWeekTrainingSetup::where('plan_id', '=', $this->planId)->delete();
                DraftEquipmentPlan::where('plan_id', $this->planId)->delete();
                DraftPlanTrainingComment::where('plan_id', $this->planId)->delete();
                $this->success = true;
                $this->message = 'Draft is deleted successfully';
                DB::commit();
            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                $this->success = false;
                $this->message = 'There is some problem to delete draft';
            }

        } else {
            $obj = Plan::where(['user_id' => loginId(), 'is_completed' => 0, 'id' => $this->planId])->first();
            if (!empty($obj)) {
                try {
                    DB::beginTransaction();
                    $this->planId = $obj->id;
                    PlanTrainingOverviewWeek::where('plan_id', '=', $this->planId)->delete();
                    $ids = PlanWeekTrainingSetup::select('id')->where('plan_id', '=', $this->planId)->get();
                    if (!empty($ids)) {
                        $ids = array_column($ids->toArray(), 'id');
                        PlanWeekTrainingSetupPosition::whereIn('plan_week_training_setup_id', $ids)->delete();
                    }
                    TempTrainingSetup::where('plan_id', '=', $this->planId)->delete();
                    PlanDragDropStructure::where('plan_id', '=', $this->planId)->delete();
                    PlanWeekTrainingSetup::where('plan_id', '=', $this->planId)->delete();
                    $obj->Equipments()->detach();
                    $obj->delete();
                    $this->success = true;
                    $this->message = 'Draft is deleted successfully';
                    DB::commit();
                } catch (\Illuminate\Database\QueryException $e) {
                    DB::rollback();
                    $this->success = false;
                    $this->message = 'There is some problem to delete draft';
                }
            }
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
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
        $planId = $request->input('planId');
        $this->isEdit = $request->input('is_edit');
        $this->getUserId();

        $this->params['planId'] = $planId;
        $this->params['dayId'] = $request->input('dayId');
        if (!empty($this->isEdit))
            $equipmentIds = DraftPlanDragDropStructure::getDraftEquipments($this->params);
        else
            $equipmentIds = PlanDragDropStructure::getEquipments($this->params);
        $equipmentIds = json_decode(json_encode($equipmentIds), true);
        $equipmentIds = array_column($equipmentIds, 'id');
        $equipmentIds = json_encode($equipmentIds);
        $this->isEmptySelect = true;
        $this->data['id'] = $this->planId;
        $this->data['plan'] = [];
        $this->data['goals'] = $this->emptySelect + Goal::pluck('name', 'id')->toArray();
        $this->data['equipments'] = $this->emptySelect + Equipment::pluck('name', 'id')->toArray();
        $this->data['plan'] = Plan::where(['old_plan_id' => $request->input('planId'), 'plan_day_id' => $request->input('dayId')])->first();
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
        $this->isEdit = $request->input('is_edit');
        $data = [];
        parse_str($request->input('data'), $data);
        $this->params['title'] = $data['title'];
        $this->params['description'] = $data['description'];
        $this->params['goalId'] = $request->input('goalId');
        $this->params['dayId'] = $request->input('dayId');
        $this->params['planId'] = $request->input('planId');
        $this->params['isEdit'] = $this->isEdit;
        if (!empty($this->isEdit))
            $equipmentIds = DraftPlanDragDropStructure::getDraftEquipments($this->params);
        else
            $equipmentIds = PlanDragDropStructure::getEquipments($this->params);
        $equipmentIds = json_decode(json_encode($equipmentIds), true);
        $this->params['equipmentIds'] = array_column($equipmentIds, 'id');
        $this->error = false;
        $this->getDayPlanId();
        $model = 'PlanTrainingOverviewWeek';
        $dModel = 'PlanDragDropStructure';
        if (!empty($this->isEdit)) {
            $model = 'DraftPlanTrainingOverviewWeek';
            $dModel = 'DraftPlanDragDropStructure';
        }
        $model = '\\App\Models\\' . $model;
        $dModel = '\\App\Models\\' . $dModel;
        $record = $model::where(['plan_id' => $this->params['planId'], 'day_plan_id' => $this->dayPlanId, 'day_id' => $this->params['dayId']])->get();
        if (empty($record) || !count($record)) {
            $this->error = true;
        } else {
            $workoutKeys = TrainingPlanStructure::where('key_value', '=', 'main_workout')
                ->orwhere('key_value', '=', 'cardio')
                ->orwhere('key_value', '=', 'warm_up')
                ->orwhere('key_value', '=', 'cool_down')
                ->pluck('id')->toArray();
            foreach ($record as $row) {
                $countExercise = $dModel::where(['plan_id' => $row->plan_id, 'day_id' => $row->day_id])->whereIn('structure_id', $workoutKeys)->count();
                if (empty($countExercise)) {
                    $this->error = true;
                    break;
                }
            }
        }
        if (empty($this->error))
            $this->saveAsNewPlan($this->params);
        else
            $this->message = 'Please add exercises against training day';

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    public function addCustomizeDropDown(Request $request)
    {
        $coachId = loginId();
        $customizeId = $request->input('table_id');
        $structureId = $request->input('structure_id');
        $tableName = explode('_', $customizeId)[0];
        $tableName = ucfirst($tableName);
        $model = '\\App\Models\\' . $tableName;
        $obj = $model::where('client_id', $coachId)->pluck('value', 'id')->toArray();
        $set = false;
        if (!empty($structureId)) {
            $name = TrainingPlanStructure::find($structureId)->name;
            if ($tableName == 'Rm') {
                $tableName = '1RM%';
            } else if ($tableName == 'Set') {
                $set = true;
            }
            $tableName = $name . ' / ' . $tableName;
        }

        $view = view('client.plan.partials._add_customize_options_popup',compact('set','customizeId','obj','tableName'))->render();
        return response()->json(['success' => true, 'message' => $this->message, 'view' => $view]);
    }
    public function saveCustomizeDropDown(Request $request)
    {
        $coachId = loginId();
        $customizeId = $request->input('table_id');
        $customizeValue = $request->input('customized_value');
        $tableName = explode('_', $customizeId)[0];
        $model = ucfirst($tableName);
        $model = '\\App\Models\\' . $model;
        $obj = new $model();
        $obj->client_id = $coachId;
        $obj->value = $customizeValue;
        $obj->is_customized = 1;
        $obj->created_at = currentDateTime();
        $obj->updated_at = currentDateTime();
        $obj->save();
        $this->data[$customizeId] = $obj->id;

//        dd($this->data);
        return response()->json(['success' => true, 'message' => $this->message,'data'=>$this->data]);
    }
    public function removeCustomizeDropDown(Request $request)
    {
        $customizeId = $request->input('table_id');
        $removeId = explode('_', $customizeId)[1];
        $tableName = explode('_', $customizeId)[2];
        $model = ucfirst($tableName);
        $model = '\\App\Models\\' . $model;
        $model::where('id', $removeId)->delete();

        return response()->json(['success' => true, 'message' => $this->message]);
    }

}
