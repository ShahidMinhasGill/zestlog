<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    public $timestamps = true;

/* This is used to get all plans data
*
* @param $params
* @return mixed
*/
    public static function getExercises($params)
    {
        $sql = \DB::table('exercises as e');
        $sql->select('e.id', 'e.second_part_id as exercise_id','e.male_illustration','e.male_gif','e.male_video', 'e.female_illustration', 'e.female_gif', 'e.female_video', 'e.name', 'b.name as body_part_name', 't.name as target_muscle_name', 'eq.name as equipment_name','tr.name as training_form_name',
            'd.name as discipline_name', 'l.name as level_name', 'p.name as priority_name', 'e.description','e.body_part_id','e.target_muscle_id','e.equipment_id','e.training_form_id','e.discipline_id','e.level_id','e.priority_id');
        $sql->join('body_part_exercises as b', 'b.id', '=', 'e.body_part_id');
        $sql->join('target_muscles as t', 't.id', '=', 'e.target_muscle_id');
        $sql->join('equipment as eq', 'eq.id', '=', 'e.equipment_id');
        $sql->join('training_forms as tr', 'tr.id', '=', 'e.training_form_id');
        $sql->join('disciplines as d', 'd.id', '=', 'e.discipline_id');
        $sql->join('levels as l', 'l.id', '=', 'e.level_id');
        $sql->join('priorities as p', 'p.id', '=', 'e.priority_id');
        // search filters
        if (!empty($params['search'])) {
            $search = '%' . $params['search'] . '%';
            $sql->where('e.name', 'like', $search);
        }
        if (!empty($params['dropDownFilters'])) {
            $alias = 'e';
            foreach ($params['dropDownFilters'] as $filterKey => $filter) {
                if (!empty($filter)) {
                    $sql->where($alias . '.' . $filterKey, '=', $filter);
                }
            }
        }
        if (!empty($params['body_part'])) {
            $sql->where('b.id', '=', $params['body_part']);
        }
        if (!empty($params['target_muscle'])) {
            $sql->where('t.id', '=', $params['target_muscle']);
        }
        if (!empty($params['equipment'])) {
            $sql->where('eq.id', '=', $params['equipment']);
        }
//        if (!empty($params['exercise_equipments'])) {
//            $sql->whereIn('e.equipment_id',$params['exercise_equipments']);
//        }
        if (!empty($params['training_form'])) {
            $sql->where('tr.id', '=', $params['training_form']);
        }
        if (!empty($params['dicipline'])) {
            $sql->where('d.id', '=', $params['dicipline']);
        }
        if (!empty($params['level'])) {
            $sql->where('l.id', '=', $params['level']);
        }
        if (!empty($params['priority'])) {
            $sql->where('p.id', '=', $params['priority']);
        }
//        echo $sql->toSql(); exit;
        $grid = [];
        $grid['query'] = $sql;
        $grid['perPage'] = $params['perPage'];
        $grid['page'] = $params['page'];
        return \Grid::runSql($grid);
    }
}
