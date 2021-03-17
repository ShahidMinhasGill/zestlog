<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'title', 'user_id', 'day_plan_id', 'goal_id', 'training_day_id', 'equipment_id', 'training_age_id',
        'age_category_id', 'access_type', 'description', 'gender', 'is_completed','plan_type','duration','old_plan_id','plan_day_id'
    ];

    /**
     * This is used to get equipments of plans
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Equipments()
    {
        return $this->belongsToMany('App\Models\Equipment')->withTimestamps()->withPivot('plan_id', 'equipment_id');
    }
    /**
     * This is used to get all plans data
     *
     * @param $params
     * @return mixed
     */
    public static function getPlans($params)
    {
        $sql = \DB::table('plans as p');
        $sql->select('p.id', 'p.title as plan_name', 'dp.name as day_plan_name', 'g.name as goal','p.description', 'u.profile_pic_upload',
            'ta.name as training_age', 'td.name as training_day', 'ac.name as age_category', 'p.gender','p.access_type','p.user_id as client_id',
            \DB::raw("CONCAT( u.first_name,  ' ', u.last_name ) as designed_by")
        );
        $sql->join('users as u', 'u.id', '=', 'p.user_id');
        $sql->join('day_plans as dp', 'dp.id', '=', 'p.day_plan_id');
        $sql->join('goals as g', 'g.id', '=', 'p.goal_id');
        $sql->join('training_ages as ta', 'ta.id', '=', 'p.training_age_id');
        $sql->join('training_days as td', 'td.id', '=', 'p.training_day_id');
        $sql->join('age_categories as ac', 'ac.id', '=', 'p.age_category_id');
        $sql->where('is_completed', '=', 1);
        $sql->where('p.access_type', '=','public');
        if(!empty($params['client_id'])){
            $sql->where('p.user_id', '=', $params['client_id']);
        }
        // search filters
        if (!empty($params['goal'])) {
            $sql->where('p.goal_id', '=', $params['goal']);
        }
        if (!empty($params['training_day'])) {
            $sql->where('p.training_day_id', '=', $params['training_day']);
        }
        if (!empty($params['training_age'])) {
            $sql->where('p.training_age_id', '=', $params['training_age']);
        }
        if (!empty($params['equipment'])) {
            $sql->join('equipment_plan as eq', 'eq.plan_id', 'p.id');
            $equipments = explode(',',$params['equipment']);
            $sql->whereIn('eq.equipment_id', $equipments);
        }
        if (!empty($params['age_category'])) {
            $sql->where('p.age_category_id', '=', $params['age_category']);
        }
        if (!empty($params['gender'])) {
            $value = '';
            if ($params['gender'] == 'f')
                $value = 'female';
            else if ($params['gender'] == 'm')
                $value = 'male';
            if (!empty($value))
                $sql->where('p.gender', '=', $value);
        }

        return $sql->paginate($params['perPage'])->toArray();
    }

    /**
     * this is used to get web plans
     *
     * @return array
     */
    public static function getPlansWeb($params)
    {
        $sql = \DB::table('plans as p');
        $sql->select('p.id', 'p.title as plan_name', 'dp.name as day_plan_name', 'p.duration', 'p.access_type', 'g.name as goal','p.description',
            'ta.name as training_age', 'td.name as training_day', 'ac.name as age_category', 'p.gender',
            \DB::raw("CONCAT( u.first_name,  ' ', u.last_name ) as designed_by")
        );
        $sql->join('users as u', 'u.id', '=', 'p.user_id');
        $sql->join('day_plans as dp', 'dp.id', '=', 'p.day_plan_id');
        $sql->join('goals as g', 'g.id', '=', 'p.goal_id');
        $sql->join('training_ages as ta', 'ta.id', '=', 'p.training_age_id');
        $sql->join('training_days as td', 'td.id', '=', 'p.training_day_id');
        $sql->join('age_categories as ac', 'ac.id', '=', 'p.age_category_id');
        $sql->where('p.is_completed', '=', 1);
        if (!empty($params['userId']))
            $sql->where('p.user_id', '=', $params['userId']);

        if (!empty($params['plan_type'])) {
            if ($params['plan_type'] == "1") {
                $sql->where('p.plan_type', '=', 1); //  for day plan type
            } else if ($params['plan_type'] == "2") {
                $sql->where('p.plan_type', '=', 0); // for week plan
            }
        }
        // search filters
        if (!empty($params['dropDownFilters'])) {
            $alias = 'p';
            foreach ($params['dropDownFilters'] as $filterKey => $filter) {
                if (!empty($filter)) {
                    $sql->where($alias . '.' . $filterKey, '=', $filter);
                }
            }
        }
        if (!empty($params['search'])) {
            $search = '%'.$params['search'].'%';
            $sql->where('p.title', 'like', $search);
        }

        $grid = [];
        $grid['query'] = $sql;
        $grid['perPage'] = $params['perPage'];
        $grid['page'] = $params['page'];
        $grid['gridFields'] = self::gridFields();

        return \Grid::runSql($grid);
    }
    /**
     * this is used to get day web plans
     *
     * @return array
     */
    public static function getDayPlansWeb($params)
    {
        $sql = \DB::table('plans as p');
        $sql->select('p.id', 'p.title as plan_name', 'dp.name as day_plan_name', 'p.duration', 'p.access_type', 'g.name as goal','p.description',
            \DB::raw("CONCAT( u.first_name,  ' ', u.last_name ) as designed_by"),
            \DB::raw("CONCAT('1') as training_day")
        );
        $sql->join('users as u', 'u.id', '=', 'p.user_id');
        $sql->join('day_plans as dp', 'dp.id', '=', 'p.day_plan_id');
        $sql->join('goals as g', 'g.id', '=', 'p.goal_id');
        $sql->where('p.is_completed', '=', 1);
        if (!empty($params['userId']))
            $sql->where('p.user_id', '=', $params['userId']);

        if (!empty($params['plan_type'])) {
            if ($params['plan_type'] == "1") {
                $sql->where('p.plan_type', '=', 1); //  for day plan type
            } else if ($params['plan_type'] == "2") {
                $sql->where('p.plan_type', '=', 0); // for week plan
            }
        }
        // search filters
        if (!empty($params['dropDownFilters'])) {
            $alias = 'p';
            foreach ($params['dropDownFilters'] as $filterKey => $filter) {
                if (!empty($filter)) {
                    $sql->where($alias . '.' . $filterKey, '=', $filter);
                }
            }
        }
        if (!empty($params['search'])) {
            $search = '%'.$params['search'].'%';
            $sql->where('p.title', 'like', $search);
        }

        $grid = [];
        $grid['query'] = $sql;
        $grid['perPage'] = $params['perPage'];
        $grid['page'] = $params['page'];
        $grid['gridFields'] = self::gridDayFields();

        return \Grid::runSql($grid);
    }

    /**
     * This is used to return cammp grid fields
     *
     * @return array
     */
    public static function gridFields()
    {
        $arrFields = [
            'id' => [
                'name' => 'id',
                'isDisplay' => true
            ],
            'checkbox' => [
                'name' => 'checkbox',
                'isDisplay' => true
            ],
            'action_column' => [
                'name' => 'action_column',
                'isDisplay' => true
            ],
            'plan_name' => [
                'name' => 'plan_name',
                'isDisplay' => true
            ],
            'day_plan_name' => [
                'name' => 'day_plan_name',
                'isDisplay' => true
            ],
            'duration' => [
                'name' => 'duration',
                'isDisplay' => true
            ],
            'designed_by' => [
                'name' => 'designed_by',
                'isDisplay' => true
            ],
            'access_type' => [
                'name' => 'access_type',
                'isDisplay' => true
            ],
            'goal' => [
                'name' => 'goal',
                'isDisplay' => true
            ],
            'training_day' => [
                'name' => 'training_day',
                'isDisplay' => true
            ],
            'equipment' => [
                'name' => 'equipment',
                'isDisplay' => true
            ],
            'training_age' => [
                'name' => 'training_age',
                'isDisplay' => true
            ],
            'age_category' => [
                'name' => 'age_category',
                'isDisplay' => true
            ],
            'gender' => [
                'name' => 'gender',
                'isDisplay' => true
            ],
            'description' => [
                'name' => 'description',
                'isDisplay' => true
            ],
        ];

        return $arrFields;
    }
    /**
     * This is used to return cammp grid fields
     *
     * @return array
     */
    public static function gridDayFields()
    {
        $arrFields = [
            'id' => [
                'name' => 'id',
                'isDisplay' => true
            ],
            'checkbox' => [
                'name' => 'checkbox',
                'isDisplay' => true
            ],
            'action_column' => [
                'name' => 'action_column',
                'isDisplay' => true
            ],
            'plan_name' => [
                'name' => 'plan_name',
                'isDisplay' => true
            ],
            'day_plan_name' => [
                'name' => 'day_plan_name',
                'isDisplay' => true
            ],
            'duration' => [
                'name' => 'duration',
                'isDisplay' => true
            ],
            'designed_by' => [
                'name' => 'designed_by',
                'isDisplay' => true
            ],
            'access_type' => [
                'name' => 'access_type',
                'isDisplay' => true
            ],
            'goal' => [
                'name' => 'goal',
                'isDisplay' => true
            ],
            'training_day' => [
                'name' => 'training_day',
                'isDisplay' => true
            ],
            'equipment' => [
                'name' => 'equipment',
                'isDisplay' => true
            ],
            'description' => [
                'name' => 'description',
                'isDisplay' => true
            ],
        ];

        return $arrFields;
    }

    public static function getClientPlansWeb($params,$clientEquipments)
    {
        $sql = \DB::table('plans as p')
            ->select('p.id',
                \DB::raw('group_concat(eq.equipment_id) as ids'));
         $sql->join('equipment_plan as eq', function ($join) {
             $join->on('eq.plan_id', '=', 'p.id');
         });
        $sql->where('p.is_completed', '=', 1);
        if (!empty($params['userId']))
            $sql->where('p.user_id', '=', $params['userId']);
        if (!empty($params['plan_type'])) {
            if ($params['plan_type'] == "1") {
                $sql->where('p.plan_type', '=', 1); //  for day plan type
            } else if ($params['plan_type'] == "2") {
                $sql->where('p.plan_type', '=', 0); // for week plan
            }
        }
        $sql->groupBy('eq.plan_id');
        $data = $sql->get();
        $planIds = [];
        if(!empty($data) && !empty($clientEquipments)) {
            $data = $data->toArray();
            foreach ($data as $row) {
                $ids = explode(',', $row->ids);
                $diff = array_diff($ids, $clientEquipments);
                if (empty($diff)) {
                    $planIds[] = $row->id;
                }
            }
        }

        $sql = \DB::table('plans as p');
        $sql->select('p.id', 'p.title as plan_name', 'dp.name as day_plan_name', 'p.duration', 'p.access_type', 'g.name as goal','p.description',
            'ta.name as training_age', 'td.name as training_day', 'ac.name as age_category', 'p.gender',
            \DB::raw("CONCAT( u.first_name,  ' ', u.last_name ) as designed_by")
        );
        $sql->join('users as u', 'u.id', '=', 'p.user_id');
        $sql->join('day_plans as dp', 'dp.id', '=', 'p.day_plan_id');
        $sql->join('goals as g', 'g.id', '=', 'p.goal_id');

        $leftJoin = 'join';
        if (!empty($params['plan_type'])) {
            if ($params['plan_type'] == "1") {
                $leftJoin = 'leftJoin';
            }
        }
        $sql->$leftJoin('training_ages as ta', 'ta.id', '=', 'p.training_age_id');
        $sql->$leftJoin('training_days as td', 'td.id', '=', 'p.training_day_id');
        $sql->$leftJoin('age_categories as ac', 'ac.id', '=', 'p.age_category_id');
        $sql->where('p.is_completed', '=', 1);
        if (!empty($planIds)) {
            $sql->whereIn('p.id', $planIds);
        }
        $sql->join('equipment_plan as eq', function ($join) use ($clientEquipments) {
            $join->on('eq.plan_id', '=', 'p.id');
            $join->whereIn('eq.equipment_id', $clientEquipments);
        });

        if (!empty($params['userId']))
            $sql->where('p.user_id', '=', $params['userId']);
        if (!empty($params['plan_type'])) {
            if ($params['plan_type'] == "1") {
                $sql->where('p.plan_type', '=', 1); //  for day plan type
            } else if ($params['plan_type'] == "2") {
                $sql->where('p.plan_type', '=', 0); // for week plan
            }
        }
        // search filters
        if (!empty($params['dropDownFilters'])) {
            foreach ($params['dropDownFilters'] as $filterKey => $filter) {
                if (!empty($filter)) {
                    $alias = 'p';
                    if ($filterKey == 'equipment_id') {
                        $alias = 'eq';
                    }
                    $sql->where($alias . '.' . $filterKey, '=', $filter);
                }
            }
        }
        if (!empty($params['search'])) {
            $search = '%'.$params['search'].'%';
            $sql->where('p.title', 'like', $search);
        }

        $sql->groupBy('p.id');
//        echo '<pre>';
//        echo $sql->toSql(); exit;
        $grid = [];
        $grid['query'] = $sql;
        $grid['perPage'] = $params['perPage'];
        $grid['page'] = $params['page'];
        $grid['gridFields'] = self::gridClientFields($params['plan_type']);

        return \Grid::runSql($grid);
    }
    /**
     * This is used to return cammp grid fields
     *
     * @return array
     */
    public static function gridClientFields($planType)
    {
        if($planType == '1'){
            $arrFields = [
                'id' => [
                    'name' => 'id',
                    'isDisplay' => true
                ],
                'radio_box' => [
                    'name' => 'radio_box',
                    'isDisplay' => true
                ],
                'plan_name' => [
                    'name' => 'plan_name',
                    'isDisplay' => true
                ],
                'day_plan_name' => [
                    'name' => 'day_plan_name',
                    'isDisplay' => true
                ],
                'duration' => [
                    'name' => 'duration',
                    'isDisplay' => true
                ],
                'designed_by' => [
                    'name' => 'designed_by',
                    'isDisplay' => true
                ],
                'access_type' => [
                    'name' => 'access_type',
                    'isDisplay' => true
                ],
                'goal' => [
                    'name' => 'goal',
                    'isDisplay' => true
                ],
                'training_day' => [
                    'name' => 'training_day',
                    'isDisplay' => true
                ],
                'equipment' => [
                    'name' => 'equipment',
                    'isDisplay' => true
                ],

            ];
        }else{
            $arrFields = [
                'id' => [
                    'name' => 'id',
                    'isDisplay' => true
                ],
                'checkbox' => [
                    'name' => 'checkbox',
                    'isDisplay' => true
                ],
                'plan_name' => [
                    'name' => 'plan_name',
                    'isDisplay' => true
                ],
                'day_plan_name' => [
                    'name' => 'day_plan_name',
                    'isDisplay' => true
                ],
                'duration' => [
                    'name' => 'duration',
                    'isDisplay' => true
                ],
                'designed_by' => [
                    'name' => 'designed_by',
                    'isDisplay' => true
                ],
                'access_type' => [
                    'name' => 'access_type',
                    'isDisplay' => true
                ],
                'goal' => [
                    'name' => 'goal',
                    'isDisplay' => true
                ],
                'training_day' => [
                    'name' => 'training_day',
                    'isDisplay' => true
                ],
                'equipment' => [
                    'name' => 'equipment',
                    'isDisplay' => true
                ],
                'training_age' => [
                    'name' => 'training_age',
                    'isDisplay' => true
                ],
                'age_category' => [
                    'name' => 'age_category',
                    'isDisplay' => true
                ],
                'gender' => [
                    'name' => 'gender',
                    'isDisplay' => true
                ],

            ];
        }


        return $arrFields;
    }
}
