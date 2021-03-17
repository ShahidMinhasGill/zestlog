<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrainingPlanStructure;
use DateTime;
use Illuminate\Http\Request;
use App\Traits\ZestLogTrait;
use App\Models\ClientPlan;
use App\User;
use App\Models\BodyPart;
use App\Models\Client\PlanDragDropStructure;
use App\Models\Exercise;

use App\Models\Duration;
use App\Models\Form;
use App\Models\Note;
use App\Models\Rep;
use App\Models\Rest;
use App\Models\Rm;
use App\Models\Set;
use App\Models\Stage;
use App\Models\Tempo;
use App\Models\Wr;
use Illuminate\Support\Facades\DB;

use App\Models\Client\UserMainWorkoutPlan;
use App\Models\Client\PlanWeekTrainingSetup;

class ClientPlanController extends Controller
{
    use ZestLogTrait;

    /**
     * This is used to get plan data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPlan(Request $request)
    {
        $this->setUserId($request);
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'client_id' => 'required|integer',
            'week_number' => 'required',
            'year' => 'required|integer'
        ];
        $result = (object)[];
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
                $this->params['user_id'] = $this->userId;
                $this->params['client_id'] = $request->input('client_id');
                $this->params['week_id'] = $weekId;
                $this->params['year'] = $request->input('year');
                $this->data = ClientPlan::getDownloadProgramData($this->params);
                $this->data = json_decode(json_encode($this->data), true);
                $this->message = '';
                if ($this->data) {
                    $bodyParts = BodyPart::pluck('name', 'id')->toArray();
                    foreach ($this->data as $key => $row) {
                        if(!empty($bodyParts[$row['body_part_1']])) {
                            $this->data[$key]['body_parts'] = $bodyParts[$row['body_part_1']];
                            if (!empty($bodyParts[$row['body_part_2']]))
                                $this->data[$key]['body_parts'] .= ',' . $bodyParts[$row['body_part_2']];
                            if (!empty($bodyParts[$row['body_part_3']]))
                                $this->data[$key]['body_parts'] .= ',' . $bodyParts[$row['body_part_3']];
                        } else {
                            $this->data[$key]['body_parts'] = '';
                        }
                        unset($this->data[$key]['body_part_1'], $this->data[$key]['body_part_2'], $this->data[$key]['body_part_3']);
                    }
                    $this->success = true;
                } else {
                    $this->message = 'No record exist';
                }
            }

        }

        return response()->json(['success' => $this->success,'week_of_year'=>$weekId, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
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
            'client_id' => 'required|integer',
            'plan_id' => 'required|integer',
            'day_id' => 'required|integer',
            'week_number' => 'required',
            'year' => 'required|integer'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $date = $request->input('week_number'); // used week_number param for date
            try{
                $date = new DateTime($date);
                $weekNumber = (int)$date->format("W");
            }catch (\Exception $e){
                $weekNumber = $request->input('week_number');
            }
            $this->success = true;
            $this->message = '';
            $this->setUserId($request);
            $this->params['user_id'] = $this->userId;
            $this->params['client_id'] = $request->input('client_id');
            $this->params['week_id'] = $weekNumber;
            $this->params['year'] = $request->input('year');
            $this->params['day_id'] = $request->input('day_id');
            $this->params['plan_id'] = $request->input('plan_id');
            $this->params['assetUrl'] =  asset(MobileUserImagePath);
            $this->data = ClientPlan::getDownloadProgramData($this->params);
            $this->data = json_decode(json_encode($this->data), true);
            if ($this->data) {
                $bodyParts = BodyPart::pluck('name', 'id')->toArray();
                foreach ($this->data as $key => $row) {
                    if(!empty($bodyParts[$row['body_part_1']])) {
                        $this->data[$key]['body_parts'] = $bodyParts[$row['body_part_1']];
                        if (!empty($bodyParts[$row['body_part_2']]))
                            $this->data[$key]['body_parts'] .= ',' . $bodyParts[$row['body_part_2']];
                        if (!empty($bodyParts[$row['body_part_3']]))
                            $this->data[$key]['body_parts'] .= ',' . $bodyParts[$row['body_part_3']];
                    } else {
                        $this->data[$key]['body_parts'] = '';
                    }
                    unset($this->data[$key]['body_part_1'], $this->data[$key]['body_part_2'], $this->data[$key]['body_part_3']);
                }
                $this->data = $this->data[0];
                $this->data['training_plan_structure'] = TrainingPlanStructure::select('id', 'name', 'key_value')->get()->toArray();
                $clientPlanStructure = [];
                $record = PlanWeekTrainingSetup::planSetup($request->input('plan_id'), $request->input('day_id'))->first();
                if (!empty($record)) {
                    $record = $record->toArray();
                    foreach ($this->data['training_plan_structure'] as $row) {
                        if ($record[$row['key_value']] == 1) {
                            $clientPlanStructure[] = $row;
                        }
                    }
                    if (empty($record['is_main_workout_top']) && $record['main_workout'] == 1 && $record['cardio'] == 1) {
                        [$clientPlanStructure[1], $clientPlanStructure[2]] = [$clientPlanStructure[2], $clientPlanStructure[1]];
                    }
                }
                $this->data['client_training_plan_structure'] = $clientPlanStructure;
                $record = $this->data;
                $this->data = [];
                $this->data[] = $record;

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
            $this->params['plan_id'] = $request->input('plan_id');
            $this->params['day_id'] = $request->input('day_id');
            $this->params['structure_id'] = $request->input('structure_id');
            $mainWorkoutData = [];
            $data = PlanDragDropStructure::getTrainingExercisesByPlan($this->params);
            if (!empty($data)) {
                foreach ($data as $row) {
                    if (!empty($row->male_illustration))
                        $row->male_illustration = asset(exerciseImagePathMale . '/' . $row->male_illustration);
                    if (!empty($row->female_illustration))
                        $row->female_illustration = asset(exerciseImagePathFemale . '/' . $row->female_illustration);
                    $mainWorkoutData[$row->day_id.'_'.$row->structure_id][] = $row;
                }
            }
            if (!empty($mainWorkoutData)) {
                $record = $mainWorkoutData;
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
            $trainingPlanIds = explode(',', $request->input('training_plan_id'));
            $this->message = 'No Record Found';
            $this->params['training_plan_id'] = $trainingPlanIds;
            $record = PlanDragDropStructure::getExercisesDetail($this->params);
            if ($record) {
                foreach ($record as $key => $row) {
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
                        $this->data[$key]['rep']['value'] = $reps->value;

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
                DB::beginTransaction();
                foreach ($this->data['data'] as $row) {
                    if (!empty($row['meta_data'])) {
                        $data = $row['meta_data'];
                        if (isset($row['position']))
                            $data['position'] = $row['position'];
                        if (!empty($data)) {
                            $this->userId = $row['user_id'];
                            $this->planId = $row['plan_id'];
                            $this->trainingPlanId = $row['training_plan_id'];
                            $this->workoutSetTypeId = $row['workout_set_type_id'];
                            $this->structureId = $row['structure_id'];
                            $workoutCounter = $data['workout_counter'];
                            $workoutSubCounter = $data['workout_sub_counter'];
                            unset($data['workout_counter']);
                            unset($data['workout_sub_counter']);
                            UserMainWorkoutPlan::updateorCreate(
                                ['user_id' => $this->userId, 'plan_id' => $this->planId, 'structure_id' => $this->structureId, 'week_number' => $row['week_number'], 'year' => $row['year'], 'training_plan_id' => $this->trainingPlanId, 'workout_set_type_id' => $this->workoutSetTypeId
                                    ,'workout_counter' => $workoutCounter, 'workout_sub_counter' => $workoutSubCounter]
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
            $this->success = true;
            $this->setUserId($request);
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

}
