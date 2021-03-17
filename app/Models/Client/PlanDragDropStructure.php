<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class PlanDragDropStructure extends Model
{
    protected $table = 'client_plan_drag_drop_structures';
    protected $fillable = ['client_plan_id', 'day_id', 'structure_id', 'exercise_id', 'workout_counter', 'workout_sub_counter', 'workout_type', 'workout_set_type_id', 'position', 'position_id', 'set_id', 'rep_id', 'duration_id', 'note_id', 'rm_id', 'tempo_id', 'rest_id', 'form_id', 'stage_id', 'wr_id'];

    public $timestamps = true;
    /*
    |--------------------------------------------------------------------------
    | Eloquent Relations
    |--------------------------------------------------------------------------
    */
    public function Set()
    {
        return $this->BelongsTo(Set::class)->select('id', 'value');
    }

    /**
     * This is used to get Rep
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Rep()
    {
        return $this->BelongsTo(Rep::class)->select('id', 'value');
    }

    /**
     * This is used to get duration
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Duration()
    {
        return $this->BelongsTo(Duration::class)->select('id', 'value');
    }

    /**
     * This is used to get Note
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Note()
    {
        return $this->BelongsTo(Note::class)->select('id', 'value');
    }

    /**
     * This is used to get RM value
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Rm()
    {
        return $this->BelongsTo(Rm::class)->select('id', 'value');
    }

    /**
     * This is used to get tempo values
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Tempo()
    {
        return $this->BelongsTo(Tempo::class)->select('id', 'value');
    }

    /**
     * This is used to get rest values
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Rest()
    {
        return $this->BelongsTo(Rest::class)->select('id', 'value');
    }

    /**
     * This is used to get form values
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Form()
    {
        return $this->BelongsTo(Form::class)->select('id', 'value');
    }

    /**
     * This is used to get stage values
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Stage()
    {
        return $this->BelongsTo(Stage::class)->select('id', 'value');
    }

    /**
     * This is used to get wr values
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Wr()
    {
        return $this->BelongsTo(Wr::class)->select('id', 'value');
    }

    /**
     * This is used to get training plan exercise data by day
     *
     * @param $params
     * @return mixed
     */
    public static function getTrainPlanExercisesByDay($params)
    {
        $sql = \DB::table('client_plan_drag_drop_structures as pd');
        $sql->select('pd.id as training_plan_id', 'pd.workout_type', 'e.name', 'pd.rep_id', 'pd.rm_id', 'e.id as exercise_id');
        $sql->join('exercises as e', 'e.id', '=', 'pd.exercise_id');
        $sql->where('pd.client_plan_id', '=', $params['plan_id']);
        $sql->where('pd.day_id', '=', $params['day_id']);
        $sql->where('pd.structure_id', '=', $params['structure_id']);
        if (isMainWorkout($params['structure_id'])) {
            $sql->addSelect('wts.name as set_type', 'wts.key_value', 'pd.workout_set_type_id', 'pd.workout_counter');
            $sql->join('workout_type_sets as wts', 'wts.id', '=', 'pd.workout_set_type_id');
            $sql->orderBy('wts.position');
        }

        return $sql->get()->toArray();
    }

    /**
     * This is used to get training exercises data
     *
     * @param $params
     */
    public static function getTrainingExercisesByPlan($params)
    {
        $sql = \DB::table('client_plan_drag_drop_structures as pd');
        $sql->select('pd.id as training_plan_id', 'pd.day_id','pd.structure_id', 'tps.name as structure_name',
            'pd.workout_type', 'e.name', 'pd.set_id', 'pd.rep_id', 'pd.rm_id', 'pd.duration_id'
            ,'pd.note_id', 'pd.tempo_id', 'pd.rest_id', 'pd.form_id', 'pd.stage_id', 'pd.wr_id',
            'e.id as exercise_id', 'pd.position as drop_position', 'e.male_illustration', 'e.female_illustration'
        );
        $sql->join('exercises as e', 'e.id', '=', 'pd.exercise_id');
        $sql->join('training_plan_structures as tps', 'tps.id', '=', 'pd.structure_id');
        $sql->where('pd.client_plan_id', '=', $params['plan_id']);
        if (!empty($params['structure_id']) && $params['structure_id'] == 2) {
            $sql->addSelect('wts.name as set_type', 'wts.key_value', 'pd.workout_set_type_id', 'pd.workout_counter',
                'pd.workout_sub_counter', 'pwtsp.position as drop_position_main', 'pwtsp.id');
            $sql->join('workout_type_sets as wts', 'wts.id', '=', 'pd.workout_set_type_id');
            $sql->join('client_plan_week_training_setups as cpwts', function($join) use ($params) {
                $join->on('cpwts.client_plan_id', '=', 'pd.client_plan_id');
                $join->where('cpwts.day_id', '=', $params['day_id']);

            });
            $sql->join('client_plan_week_training_setup_positions as pwtsp', function($join) {
                $join->on('pwtsp.client_plan_week_training_setup_id', '=', 'cpwts.id');
                $join->on('pwtsp.workout_type_set_id', '=', 'pd.workout_set_type_id');
                $join->on('pwtsp.id', '=', 'pd.position_id');
            });
            $sql->where('pd.structure_id', $params['structure_id']);
            $sql->orderBy('pwtsp.position', 'asc');
        } else {
            $sql->addSelect('tts.position as drop_position_main', 'tts.id');
            $sql->join('client_temp_training_setups as tts', function($join) use ($params) {
                $join->on('tts.id', '=', 'pd.position_id');
                $join->where('pd.workout_set_type_id', '=', 0);
            });
            $sql->where('pd.structure_id', $params['structure_id']);
            $sql->orderBy('tts.position', 'asc');
        }
        $sql->where('pd.day_id', '=', $params['day_id']);

        return $sql->get();
    }

    /**
     * This is used to get exercises detail
     *
     * @param $params
     * @return mixed
     */
    public static function getExercisesDetail($params)
    {
        $sql = \DB::table('client_plan_drag_drop_structures as pd');
        $sql->select('pd.id as training_plan_id', 'pd.day_id', 'pd.structure_id', 'tps.name as structure_name',
            'pd.workout_type', 'e.name', 'pd.set_id', 'pd.rep_id', 'pd.rm_id', 'pd.duration_id'
            , 'pd.note_id', 'pd.tempo_id', 'pd.rest_id', 'pd.form_id', 'pd.stage_id', 'pd.wr_id',
            'e.id as exercise_id', 'pd.position as drop_position', 'e.male_illustration', 'e.female_illustration'
        );
        $sql->join('exercises as e', 'e.id', '=', 'pd.exercise_id');
        $sql->join('training_plan_structures as tps', 'tps.id', '=', 'pd.structure_id');
        $sql->addSelect('wts.name as set_type', 'wts.key_value', 'pd.workout_set_type_id', 'pd.workout_counter');
        $sql->leftjoin('workout_type_sets as wts', 'wts.id', '=', 'pd.workout_set_type_id');
        $sql->whereIn('pd.id', $params['training_plan_id']);

        return $sql->get();
    }

    /**
     * This is used to get plan drag and drop data
     *
     * @param $params
     * @return mixed
     */
    public static function getDragDropData($params)
    {
        $sql = \DB::table('client_plan_drag_drop_structures as pd');
        $sql->select('pd.id','e.name', 'pd.set_id', 'pd.rep_id', 'pd.duration_id', 'pd.note_id', 'pd.rm_id',
            'pd.tempo_id', 'pd.rest_id', 'pd.form_id', 'pd.stage_id', 'pd.wr_id', 'e.male_illustration');
        $sql->where('pd.client_plan_id', '=', $params['planId']);
        $sql->where('pd.day_id', '=', $params['dayId']);
        $sql->where('pd.structure_id', '=', $params['structureId']);
        $sql->where('pd.workout_counter', '=', $params['workoutCounter']);
        $sql->where('pd.workout_sub_counter', '=', $params['workoutSubCounter']);
        $sql->where('pd.workout_set_type_id', '=', $params['workoutSetTypeId']);
        $sql->join('exercises as e', 'e.id', '=', 'pd.exercise_id');

        return $sql->first();
    }

    /**
     * This is used to get equipments
     *
     * @param $params
     * @return mixed
     */
    public static function getEquipments($params)
    {
        $sql = \DB::table('client_plan_drag_drop_structures as pd');
        $sql->selectRaw('Distinct(eq.id)');
        $sql->where('pd.client_plan_id', '=', $params['planId']);
        $sql->where('pd.day_id', '=', $params['dayId']);
        $sql->join('exercises as e', 'e.id', '=', 'pd.exercise_id');
        $sql->join('equipment as eq', 'eq.id', '=', 'e.equipment_id');

        return $sql->get()->toArray();
    }
}
