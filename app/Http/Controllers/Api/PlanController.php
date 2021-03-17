<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSaveRestCommentRequest;
use App\Models\Duration;
use App\Models\Exercise;
use App\Models\Form;
use App\Models\Note;
use App\Models\PlanDragDropStructure;
use App\Models\PlanTrainingOverviewWeek;
use App\Models\Rep;
use App\Models\Rest;
use App\Models\Rm;
use App\Models\Set;
use App\Models\Stage;
use App\Models\Tempo;
use App\Models\Wr;
use App\User;
use DateTime;
use DB;
use Illuminate\Http\Request;
use App\Traits\ZestLogTrait;
use App\Models\Plan;
use App\Models\DownloadProgram;
use App\Models\TrainingPlanStructure;
use App\Models\UserMainWorkoutPlan;
use App\Models\UserSaveRestComment;
use App\Models\DayPlan;
use Illuminate\Support\Facades\Storage;
use PragmaRX\Countries\Package\Countries;
use Illuminate\Support\Facades\Lang;
use App\Models\DownloadProgramData;
use Validator, Redirect, Response, File;
use App\Models\PlanWeekTrainingSetup;


class PlanController extends Controller
{
    use ZestLogTrait;
    private $metaDescription = '';

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function plans(Request $request)
    {
        $this-> params['perPage'] = (!empty($request->input('per_page'))) ?  $request->input('per_page') : 5;
        $this->params['page'] = (!empty($request->input('page'))) ?  $request->input('page') : 1;
        $this->params['goal'] = $request->input('goal');
        $this->params['training_day'] = $request->input('training_day');
        $this->params['training_age'] = $request->input('training_age');
        $this->params['equipment'] = $request->input('equipment');
        $this->params['age_category'] = $request->input('age_category');
        $this->params['gender'] = $request->input('gender');
        $this->params['client_id'] = $request->input('client_id');

        $this->data = Plan::getPlans($this->params);
        $maleCounter = 0;
        $femaleCounter = 0;
        foreach ($this->data['data'] as $key => $row) {
            $files = null;
            if ($row->gender == 'male') {
                $files = File::allFiles(public_path(malePlanImage));
                $randomFile = $files[$maleCounter];
                $this->data['data'][$key]->background_image = url(malePlanImage . '/' . $randomFile->getBasename());
                $maleCounter++;
                if ($maleCounter >= count($files)) {
                    $maleCounter = 0;
                }
            } else {
                $files = File::allFiles(public_path(femalePlanImage));
                $randomFile = $files[$femaleCounter];
                $this->data['data'][$key]->background_image = url(femalePlanImage . '/' . $randomFile->getBasename());
                $femaleCounter++;
                if ($femaleCounter >= count($files)) {
                    $femaleCounter = 0;
                }
            }
            if (empty($files)) {
                $this->data['data'][$key]->background_image = null;
            }
            $userImage = getUserImagePath($row->profile_pic_upload);
            $this->data['data'][$key]->gender = ucfirst($row->gender);
            $this->data['data'][$key]->profile_pic_upload = $userImage;
        }
        if (!empty($this->data['data'])) {
            $ids = array_column($this->data['data'], 'id');
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

            foreach ($this->data['data'] as $key => $row) {
                $this->data['data'][$key]->equipment = $equipments[$row->id];
            }
        }

        return response()->json(['success' => true, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to get plan search results
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function planSearchFilters(Request $request)
    {
        $this->getPlanSearchFilters();

        return response()->json(['success' => true, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to get download plans data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMyPlan(Request $request)
    {
        $this->setUserId($request);
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'week_number' => 'required',
            'year' => 'required|integer'
        ];
        $result = (object) [];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $date = $request->input('week_number'); // used week_number param for date
            try{
                $date = new DateTime($date);
                $weekId = (int)$date->format("W");
            }catch (\Exception $e){
                $weekId = $request->input('week_number');
            }
            $this->message = 'User Does not exist';
            if (User::find($this->userId)) {
                $this->message = 'Download program does not exist';
                $this->success = true;
                $obj = DownloadProgram::where(['user_id' => $this->userId, 'week_number' => $weekId, 'year' => $request->input('year')])->first();
                if ($obj) {
                    $this->planId = $obj->plan_id;
                    $record = DownloadProgramData::where(['user_id' => $this->userId, 'plan_id' => $this->planId, 'week_number' => $weekId, 'year' => $request->input('year')])->first();
                    if (!empty($record))
                        $result = (array) json_decode($record->download_program_data);
                    $this->message = '';
                }
            }
        }
        $this->data = $result;

        return response()->json(['success' => true, 'week_of_year' => $weekId, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to download a program against specific user
     *
     * @param Request $request
     */
    public function downloadPlans(Request $request)
    {
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'plan_id' => 'required|integer',
            'week_number' => 'required',
            'year' => 'required|integer'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $date = $request->input('week_number'); // used week_number param for date
            try {
                $date = new DateTime($date);
                $weekNumber = (int)$date->format("W");
            } catch (\Exception $e) {
                $weekNumber = $request->input('week_number');
            }
            try {
                $obj = DownloadProgram::where(['user_id' => $request->input('user_id'), 'week_number' => $weekNumber, 'year' => $request->input('year')])->first();
                $isStore = true;
                if (empty($obj)) {
                    $obj = new DownloadProgram();
                }
//                else {
//                    $date = strtotime(date('Y-m-d'));
//                    $storedDate = strtotime(date("Y-m-d", strtotime($obj->created_at)));
//                    $storedDate = date("W", $storedDate);
//                    $date = date("W", $date);
//                    if ((int) $storedDate !== (int) $date) {
//                        $isStore = false;
//                    }
//                }
                if ($isStore) {
                    $obj->user_id = $request->input('user_id');
                    $obj->plan_id = $request->input('plan_id');
                    $obj->week_number = $weekNumber;
                    $obj->year = $request->input('year');
                    $obj->save();
                    $obj->touch();
                    $this->planId = $obj->plan_id;

                    UserMainWorkoutPlan::where(['user_id' => $request->input('user_id'),'week_number' => $weekNumber, 'year' => $request->input('year')])->delete();

                    // prepare data to save as draft
                    $this->params['plan_id'] = $this->planId;
                    $this->params['structure_id'] = [2];
                    $this->params['is_main_workout'] = true;
                    $dropRecord = PlanDragDropStructure::getTrainingExercisesByPlan($this->params);
                    $mainWorkoutData = $dragDropStraight = [];
                    if (!empty($dropRecord)) {
                        foreach ($dropRecord as $row) {
                            if (!empty($row->male_illustration))
                                $row->male_illustration = asset(exerciseImagePathMale . '/' . $row->male_illustration);
                            if (!empty($row->female_illustration))
                                $row->female_illustration = asset(exerciseImagePathFemale . '/' . $obj->female_illustration);
                            $mainWorkoutData[$row->day_id.'_'.$row->structure_id][] = $row;
                            $dragDropStraight[$row->training_plan_id] =  (array) $row;
                        }
                    }

                    $this->params['is_main_workout'] = false;
                    $data = PlanDragDropStructure::getTrainingExercisesByPlan($this->params);
                    if (!empty($data)) {
                        foreach ($data as $row) {
                            if (!empty($row->male_illustration))
                                $row->male_illustration = asset(exerciseImagePathMale . '/' . $row->male_illustration);
                            if (!empty($row->female_illustration))
                                $row->female_illustration = asset(exerciseImagePathFemale . '/' . $obj->female_illustration);
                            $mainWorkoutData[$row->day_id.'_'.$row->structure_id][] = $row;
                            $dragDropStraight[$row->training_plan_id] =  (array) $row;
                        }
                    }
                    $this->getDownloadProgramData();
                    $downloadProgramData = array_column($this->data, null, 'day_id');
                    $this->data = (object) $downloadProgramData;
                    $record = [];
                    $planStructures = [];
                    $planTrainingSetups = PlanWeekTrainingSetup::where('plan_id', '=', $request->input('plan_id'))->get();
                    if (!empty($planTrainingSetups)) {
                        $planTrainingSetups = $planTrainingSetups->toArray();
                        $trainingPlanStructure= TrainingPlanStructure::select('id', 'name', 'key_value')->get()->toArray();
                        foreach ($planTrainingSetups as $result) {
                            foreach ($trainingPlanStructure as $row) {
                                if ($result[$row['key_value']] == 1) {
                                    $planStructures[$result['day_id']][] = $row;
                                }
                            }
                            if (empty($result['is_main_workout_top']) && $result['main_workout'] == 1 && $result['cardio'] == 1) {
                                [$planStructures[$result['day_id']][1], $planStructures[$result['day_id']][2]] = [$planStructures[$result['day_id']][2], $planStructures[$result['day_id']][1]];
                            }
                        }
                    }

                    $record['plan_drag_drop_structures'] = json_encode($mainWorkoutData);
                    $record['plan_training_overview_weeks'] = json_encode(PlanTrainingOverviewWeek::where('plan_id', '=', $this->planId)->get()->toArray());
                    $record['download_program_data'] = json_encode($downloadProgramData);
                    $record['training_plan_structure'] = json_encode($planStructures);
                    $record['plan_drag_drop_structures_straight'] = json_encode($dragDropStraight);
                    DownloadProgramData::updateorCreate(
                        ['plan_id' => $this->planId, 'user_id' => $obj->user_id, 'week_number' => $obj->week_number, 'year' => $request->input('year')]
                        , $record);
                    // end
                    $this->success = true;
                    $this->message = 'Program is downloaded successfully';
                } else {
                    $this->message = 'You do not allow to update this plan';
                }

            } catch (\Illuminate\Database\QueryException $e) {
                $this->message = $e->errorInfo[2];
            }
        }

        return response()->json(['success' => true, 'week_of_year' => $weekNumber, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This API is used to check whether program exist in week or not
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function isProgramExistInWeek(Request $request)
    {
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'week_number' => 'required|integer',
            'year' => 'required|integer'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $this->setUserId($request);
            $obj = DownloadProgram::where(['user_id' => $this->userId, 'week_number' => $request->input('week_number'), 'year' => $request->input('year')])->first();
            if ($obj) {
                $this->message = 'You have already download plan in this week';
            } else {
                $this->message = 'You can download program';
                $this->success = true;
            }
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to get training plan structure data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTrainingPlanStructure(Request $request)
    {
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'plan_id' => 'required|integer',
            'day_id' => 'required|integer',
            'week_number' => 'required|integer',
            'year' => 'required|integer'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $this->setUserId($request);
            $coachId = $request->input('user_id');
            $identity = User::find($this->userId)->is_identity_verified;
            $this->success = true;
            $this->message = '';
            $this->planId = $request->input('plan_id');
            $this->dayId = $request->input('day_id');

            $objDownloadProgram = DownloadProgramData::where(['user_id' => $this->userId, 'plan_id' => $this->planId, 'week_number' => $request->input('week_number'), 'year' => $request->input('year')])->first();
            $downloadProgramData = $trainingPlanStructure = [];
            if (!empty($objDownloadProgram)) {
                $record = (array)json_decode($objDownloadProgram->download_program_data);
                if (!empty($record[$this->dayId])) {
                    $downloadProgramData = (array)$record[$this->dayId];
                }
                $record = (array)json_decode($objDownloadProgram->training_plan_structure);
                $trainingPlanStructure['training_plan_structures'] = (!empty($record[$request->input('day_id')])) ? $record[$request->input('day_id')] : [];
               $downloadProgramData['is_identity_verified'] = $identity;
                if (empty($downloadProgramData['client_id']))
                    $downloadProgramData['client_id'] = null;
                $this->data[0] = array_merge($downloadProgramData, $trainingPlanStructure);
            }
        }

        return response()->json(['success' => true, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to get exercises by training plan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExercisesByTrainingPlan(Request $request)
    {
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'plan_id' => 'required|integer',
            'structure_id' => 'required|integer',
            'week_number' => 'required|integer',
            'year' => 'required|integer',
            'day_id' => 'required|integer'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $this->setUserId($request);
            $this->params['plan_id'] = $request->input('plan_id');
            $this->params['day_id'] = $request->input('day_id');
            $this->params['structure_id'] = $request->input('structure_id');
            $objDownload = DownloadProgramData::where(['user_id' => $this->userId, 'plan_id' => $this->params['plan_id'], 'week_number' => $data['week_number'], 'year' => $request->input('year')])->first();
            if ($objDownload) {
                $record = (array)json_decode($objDownload->plan_drag_drop_structures);
                $index = $this->params['day_id'] . '_' . $this->params['structure_id'];
                if (!empty($record[$index])) {
                    $dragDropData = $record[$index];
                    $record = [];
                    if (isMainWorkout($this->params['structure_id'])) {
                        foreach ($dragDropData as $row) {
                            $record[$row->key_value . '-' . $row->workout_counter][] = (object)$row;
                        }
                        foreach ($record as $key => $row) {
                            if(count($row) > 1) {
                                $record[$key] = array_values(sortByOneKeyObject($row, 'workout_sub_counter'));
                            }
                        }
                    } else {
                        foreach ($dragDropData as $key => $row) {
                            $record[$key][] = $row;
                        }
                    }
                    $this->data = (object)$record;
                }
            }

            $this->success = true;
            $this->message = '';
        }

        return response()->json(['success' => true, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to get exercise detail data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExerciseDetail(Request $request)
    {
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'plan_id' => 'required|integer',
            'week_number' => 'required|integer',
            'year' => 'required|integer',
            'training_plan_id' => 'required'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $this->setUserId($request);
            $trainingPlanIds = explode(',', $request->input('training_plan_id'));
            $this->message = 'Training Plan Not found';
            $record = DownloadProgramData::where(['user_id' => $this->userId, 'plan_id' => $request->input('plan_id'), 'week_number' => $request->input('week_number'), 'year' => $request->input('year')])->first();
            if($record) {
                $record = (array) json_decode($record->plan_drag_drop_structures_straight);
                $structureData = [];
                foreach ($trainingPlanIds as $row) {
                    if (!empty($record[$row]))
                        $structureData[] = $record[$row];
                }
                if (!empty($structureData)) {
                    foreach ($structureData as $key => $row) {
                        $structureId = $row->structure_id;
                        $this->data[$key]['name'] = $row->structure_name;
                        $this->data[$key]['exercise_name'] = Exercise::find($row->exercise_id)->name;
                        $this->data[$key]['exercise_id'] = $row->exercise_id;
                        $sets = Set::find($row->set_id);
                        $reps = Rep::find($row->rep_id);
                        $durations = Duration::find($row->duration_id);
                        $rms = Rm::find($row->rm_id);
                        $notes = Note::find($row->note_id);
                        $tempos = Tempo::find($row->tempo_id);
                        $rests = Rest::find($row->rest_id);
                        $forms = Form::find($row->form_id);
                        $stages = Stage::find($row->stage_id);
                        $wrs = Wr::find($row->wr_id);
                        if ($structureId == 1 || $structureId == 4) {
                            $set = $rep = $duration = $note = $setId = $repId = $durationId = $noteId = '';
                            if ($sets) {
                                $set = $sets->value;
                                $setId = $sets->id;
                            }
                            if ($reps) {
                                $rep = $reps->value;
                                $repId = $reps->id;
                            }
                            if ($durations) {
                                $duration = $durations->value;
                                $durationId = $durations->id;
                            }
                            if ($notes) {
                                $note = $notes->value;
                                $noteId = $notes->id;
                            }
                            $this->data[$key]['set_type'] = $row->workout_type;
                            $this->data[$key]['set']['id'] = $setId;
                            $this->data[$key]['set']['value'] = $set;
                            $this->data[$key]['rep']['id'] = $repId;
                            $this->data[$key]['rep']['value'] = $rep;
                            $this->data[$key]['duration']['id'] = $durationId;
                            $this->data[$key]['duration']['value'] = $duration;
                            $this->data[$key]['note']['id'] = $noteId;
                            $this->data[$key]['note']['value'] = $note;
                        } else if ($structureId == 2) {
                            $this->data[$key]['set_type'] = $row->set_type;

                            $this->data[$key]['set']['id'] = $sets->id;
                            $this->data[$key]['set']['value'] = $sets->value;

                            $this->data[$key]['rep']['id'] = $reps->id;
                            $this->data[$key]['rep']['value'] =$reps->value;

                            $this->data[$key]['rm']['id'] = $rms->id;
                            $this->data[$key]['rm']['value'] = $rms->value;

                            $this->data[$key]['tempo']['id'] = $tempos->id;
                            $this->data[$key]['tempo']['value'] = $tempos->value;

                            if (!empty($rests)) {
                                $this->data[$key]['rest']['id'] = $rests->id;
                                $this->data[$key]['rest']['value'] = $rests->value;
                            } else {
                                $this->data[$key]['rest']['id'] = '';
                                $this->data[$key]['rest']['value'] = '';
                            }
                        } else { // structure id 3
                            $form = $stage = $wr = $rep = $duration = $formId = $stageId = $wrId = $repId = $durationId = '';
                            if ($forms) {
                                $form = $forms->value;
                                $formId = $forms->id;
                            }
                            if ($stages) {
                                $stage = $stages->value;
                                $stageId = $stages->id;
                            }
                            if ($wrs) {
                                $wr = $wrs->value;
                                $wrId = $wrs->id;
                            }
                            if ($reps) {
                                $rep = $reps->value;
                                $repId = $reps->id;
                            }
                            if ($durations) {
                                $duration = $durations->value;
                                $durationId = $durations->id;
                            }
                            $this->data[$key]['form']['id'] = $formId;
                            $this->data[$key]['form']['value'] = $form;
                            $this->data[$key]['stage']['id'] = $stageId;
                            $this->data[$key]['stage']['value'] = $stage;
                            $this->data[$key]['wr']['id'] = $wrId;
                            $this->data[$key]['wr']['value'] = $wr;
                            $this->data[$key]['rep']['id'] = $repId;
                            $this->data[$key]['rep']['value'] = $rep;
                            $this->data[$key]['duration']['id'] = $durationId;
                            $this->data[$key]['duration']['value'] = $duration;
                        }
                        $this->success = true;
                        $this->message = '';
                    }
                }
            }
        }

        return response()->json(['success' => true, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to save workout main structure
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveWorkoutStructure(Request $request)
    {
        $this->data = json_decode($request->input('data'), true);
        if (!empty($this->data)) {
            try {
                $this->setUserId($request);
                DB::beginTransaction();
                foreach ($this->data['data'] as $row) {
                    if (!empty($row['meta_data'])) {
                        $data = $row['meta_data'];
                        if (isset($row['position']))
                            $data['position'] = $row['position'];
                        if (!empty($data)) {
                            $this->planId = $row['plan_id'];
                            $this->trainingPlanId = $row['training_plan_id'];
                            $this->workoutSetTypeId = $row['workout_set_type_id'];
                            $this->structureId = $row['structure_id'];
                            $workoutCounter = $data['workout_counter'];
                            $workoutSubCounter = $data['workout_sub_counter'];
                            unset($data['workout_counter']);
                            unset($data['workout_sub_counter']);
                            UserMainWorkoutPlan::updateorCreate(
                                [
                                    'user_id' => $this->userId,
                                    'plan_id' => $this->planId,
                                    'structure_id' => $this->structureId,
                                    'week_number' => $row['week_number'],
                                    'year' => $row['year'],
                                    'training_plan_id' => $this->trainingPlanId,
                                    'workout_set_type_id' => $this->workoutSetTypeId
                                    , 'workout_counter' => $workoutCounter,
                                    'workout_sub_counter' => $workoutSubCounter
                                ]
                                , $data);
                        }
                    }
                }
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
                $this->success = false;
            }
        } else {
            $this->message = 'Please provide valid data';
        }

        return response()->json(['success' => $this->success, 'data' => [], 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to get main workout structure data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWorkoutStructure(Request $request)
    {
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'plan_id' => 'required|integer',
            'structure_id' => 'required|integer',
            'week_number' => 'required|integer',
            'year' => 'required|integer',
            'training_plan_id' => 'required|integer',
            'workout_set_type_id' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $this->setUserId($request);
            $this->success = true;
            $this->data = UserMainWorkoutPlan::where(['user_id' => $this->userId,
                'plan_id' => $data['plan_id'],
                'structure_id' => $data['structure_id'],
                'week_number' => $data['week_number'],
                'year' => $data['year'],
                'training_plan_id' => $data['training_plan_id'],
                'workout_set_type_id' => $data['workout_set_type_id']])
                ->orderBy('position', 'asc')
                ->get()->toArray();
        }

        return response()->json(['success' => $this->success, 'data' =>  $this->data, 'message' => $this->message], $this->statusCode);
    }

    /*
     * add client comments
     */
    public function saveRestComment(UserSaveRestCommentRequest $request)
    {
        $this->data = $request->all();
        try {
            if (!empty($this->data)) {
                UserSaveRestComment::create($request->all());
                $this->message = "Comment has been Saved Successfully";
                $this->success = true;
            }
        } catch (\Exception $e) {
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
        return response()->json(['success' => true, 'data' => [], 'message' => $this->message], $this->statusCode);
    }
    /*
     * API for get day plan meta description
     */
    public function getDayPlan(Request $request)
    {
        $this->message = 'No record found';
        if (!empty($request->input('key_value'))) {
            $obj = DayPlan::where('key_value', '=', $request->input('key_value'))->first();
            if (!empty($obj)) {
                $this->data['meta_description'] = strip_tags($obj->meta_description);
                $this->success = true;
            }
        } else {
            $this->message = 'Please provide key value';
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExerciseData(Request $request)
    {
        $this->exerciseId = (int)$request->input('exercise_id');
        if ($this->exerciseId) {
            $obj = Exercise::find($this->exerciseId);
            if (!empty($obj)) {
                $this->data['name'] = $obj->name;
                $this->data['male_illustration'] = asset(exerciseImagePathMale . '/' . $obj->male_illustration);
                $this->data['male_gif'] = asset(exerciseGifPathMale . '/' . $obj->male_gif);
                $this->data['male_video'] = asset(exerciseVideoPathMale . '/' . $obj->male_video);
                $this->data['female_illustration'] = asset(exerciseImagePathFemale . '/' . $obj->female_illustration);
                $this->data['female_gif'] = asset(exerciseGifPathFemale . '/' . $obj->female_gif);
                $this->data['female_video'] = asset(exerciseVideoPathFemale . '/' . $obj->female_video);
                $this->success = true;
            } else {
                $this->message = Lang::get('messages.resultNotFound');
            }
        } else {
            $this->message = Lang::get('messages.reqiredFiledError', ['filedName' => 'ID']);
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
    /*
     * API for get Countries
     */
    public function getCountry(Request $request)
    {
        $c = new Countries();
        $countries = $c->all();
        $counter = 0;
        $arr = [];
        foreach ($countries as $row) {
            $arr[$counter]['id'] = $row->cca3;
            $arr[$counter]['value'] = $row->name->common;
            $counter++;
        }
        $this->data['countries'] = $arr;
        $this->success = true;

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
    /*
     * API for get City using Country key
     */
    public function getCity(Request $request)
    {
        $key = $request->input('country_code');
        if (!empty($key)) {
            try {
                $cca3 = $key;
                $c = new Countries();
                $cities = $c->where('cca3', $cca3)
                    ->first()
                    ->hydrate('cities')
                    ->cities->toArray();
                $cities = array_values($cities);
                $record = [];
                foreach ($cities as $key => $city) {
                    $record[$key]['id'] = $city['name'];
                    $record[$key]['value'] = $city['name'];
                }
                $this->data['cities'] = $record;
                $this->success = true;
            } catch (\Exception $e) {
                $this->message = Lang::get('messages.resultNotFound');
            }
        } else {
            $this->message = Lang::get('messages.reqiredFiledError', ['filedName' => 'Country Id']);
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
}
