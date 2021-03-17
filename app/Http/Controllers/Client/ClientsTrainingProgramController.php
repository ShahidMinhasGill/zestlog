<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BodyPartExercise;
use App\Models\Booking;
use App\Models\Client\ClientPlanTrainingComment;
use App\Models\Client\ClientPlanWeekTrainingSetupPosition;
use App\Models\Client\ClientTempTrainingSetup;
use App\Models\Client\ClientWeekPlan;
use App\Models\Client\PlanDragDropStructure;
use App\Models\ClientPlan;
use App\Models\ClientSelectedEquipment;
use App\Models\Day;
use App\Models\Duration;
use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\FinalPayment;
use App\Models\Form;
use App\Models\Note;
use App\Models\Plan;
use App\Models\RefundPayment;
use App\Models\Rep;
use App\Models\Rest;
use App\Models\Rm;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Models\Set;
use App\Models\Stage;
use App\Models\TargetMuscle;
use App\Models\Tempo;
use App\Models\TempTrainingSetup;
use App\Models\TrainingForm;
use App\Models\TrainingProgramPrice;
use App\Models\TrainingProgramPriceSetup;
use App\Models\Wr;
use App\User;
use function Composer\Autoload\includeFile;
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
use App\Models\TrainingPlanStructure;

class ClientsTrainingProgramController extends Controller
{
    use ZestLogTrait;

    /**
     * this is used to display clients data
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $id)
    {
        $uniqueId = $id;
        $id = \Auth::user()->id;
        $c = new Countries();
        $allCountries = $c->all();
        $countries = [
            '' => 'Select'
        ];
        foreach ($allCountries as $country) {
            $countries[$country->cca3] = $country->name->common;
        }
        $this->data['endUser'] = User::find($id);

        $this->getUserId();
        $this->isEquipmentEmptySelect = false;
        $this->isEmptySelect = true;
        $this->getPlanFilters();
        $this->isEmptyAll = true;
        $this->isEmptySelect = false;
        $this->emptySelect();
        $this->getExerciseFilter();
//        $this->getClientEquipmentDropDown($uniqueId);
        $workoutTypeSet = WorkoutTypeSet::pluck('set_exercises', 'key_value')->toArray();
        $this->data['workoutTypeSet'] = json_encode($workoutTypeSet);
        $this->isEmptyAll = true;
        $this->getPlanFilters();
        $this->data['unique_id'] = $uniqueId;
        $data = $this->data;

        return view('client.clients-training-program', compact(  'data'));
    }

    public function clientGetExercises(Request $request)
    {
        $unqiueId = $request->input('unique_id');
        $equipmentsIds = $this->getClientEquipmentDropDown($unqiueId);
        $this->params = [
            'perPage' => 10,
            'page' =>   $request->input('page'),
            'search' => $request->input('search'),
            'sortType' => $request->input('sortType'),
            'dropDownFilters' => $request->input('dropDownFilters'),
            'exercise_equipments' => $equipmentsIds
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
    public function getClientTrainingPrograms(Request $request)
    {
        $uniqueId = $request->input('unique_id');
//        $clientEquipments =  $this->getClientEquipmentDropDown($uniqueId);
        $clientEquipments = Equipment::pluck('id')->toArray();
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
        $data = Plan::getClientPlansWeb($this->params,$clientEquipments);
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

}
