<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadProgram extends Model
{
    protected $fillable = ['plan_id', 'use_id', 'week_number', 'year'];
    public $timestamps = true;

    /**
     * This is used to get download programs data
     *
     * @param $params
     * @return mixed
     */
    public static function getDownloadProgramData($params)
    {
        $sql = \DB::table('plans as p');
        $sql->select('p.title', 'p.id as plan_id', 'd.name as day', 'dtow.day_id', 'dpl.name as day_plan', 'dtow.body_part_1', 'dtow.body_part_2', 'dtow.body_part_3',
            'u.profile_pic_upload', 'u.id as client_id',
            \DB::raw("CONCAT( u.first_name,  ' ', u.last_name ) as full_name"));
        $sql->join('download_programs as dp', 'dp.plan_id', '=', 'p.id');
        $sql->join('plan_training_overview_weeks as dtow', 'dtow.plan_id', '=', 'p.id');
        $sql->join('days as d', 'd.id', '=', 'dtow.day_id');
        $sql->join('day_plans as dpl', 'dpl.id', '=', 'dtow.day_plan_id');
        $sql->join('users as u', 'u.id', '=', 'p.user_id');
        $sql->where('p.id', '=', $params['plan_id']);
        if (!empty($params['day_id'])) {
            $sql->where('dtow.day_id', '=', $params['day_id']);
        }
        $sql->groupBy('p.id', 'dtow.day_id');

        return $sql->get();
    }
}
