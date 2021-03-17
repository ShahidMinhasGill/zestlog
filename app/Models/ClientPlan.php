<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClientPlan extends Model
{
    protected $fillable = ['user_id', 'client_id', 'unique_id', 'week_id', 'year'];

    /**
     * This is used to get download programs data
     *
     * @param $params
     * @return mixed
     */
    public static function getDownloadProgramData($params)
    {
        $assetUrl = $params['assetUrl'];

        $sql = \DB::table('client_plans as p');
        $sql->select('cwp.id as client_week_plan_id','cwp.is_confirmed','cwp.week_count as week_of_program',
            'cwp.week_id as week_of_year','cwp.year','p.id as plan_id', 'd.name as day', 'dtow.day_id',
            'dpl.name as day_plan', 'dtow.body_part_1', 'dtow.body_part_2', 'dtow.body_part_3',
            'u.is_identity_verified','p.client_id as client_id',
            DB::raw("CONCAT( u.first_name,  ' ', u.last_name ) as full_name"),
            DB::raw("CONCAT('$assetUrl','/',u.profile_pic_upload) as profile_pic_upload")
        );
        $sql->join('client_plan_training_overview_weeks as dtow', 'dtow.client_plan_id', '=', 'p.id');
        $sql->join('days as d', 'd.id', '=', 'dtow.day_id');
        $sql->join('day_plans as dpl', 'dpl.id', '=', 'dtow.day_plan_id');
        $sql->join('client_week_plans as cwp', 'cwp.client_plan_id', '=', 'p.id');
        $sql->join('users as u', 'u.id', '=', 'cwp.client_id');
        $sql->where(['p.user_id' => $params['user_id'], 'p.client_id' => $params['client_id'], 'cwp.week_id' => $params['week_id'], 'cwp.year' => $params['year'], 'p.is_publish' => 1]);
        if (!empty($params['day_id'])) {
            $sql->where('dtow.day_id', '=', $params['day_id']);
        }
        if (!empty($params['plan_id'])) {
            $sql->where('p.id', '=', $params['plan_id']);
        }
        $sql->groupBy('p.id', 'dtow.day_id');

        return $sql->get();
    }

    /**
     * Upcoming Schedules
     * @param $params
     * @return array
     */
    public static function getUpcomingSessionsData($params)
    {
        $date = new DateTime();
        $week = $date->format("W");
        $year = $date->format("Y");
        $clientId = loginId();
        $sql = DB::table('client_plans as cp');
        $sql->select('cp.id', 's.name as service', 'cp.is_publish as publish',
            'u.user_name as user_name', 'cwp.week_count as week_of_program', 'cwp.is_new as new_repeat', 'fp.unique_id',
            DB::raw("CONCAT('week ',cwp.week_id,  ',', cwp.year) as week_of_year"),
            DB::raw("CONCAT('Upcoming ') as status"),
            DB::raw("CONCAT('Booking ') as booking_form")
        );
        $sql->join('final_payments as fp', 'fp.unique_id', '=', 'cp.unique_id');
        $sql->join('service_bookings as sb', 'sb.unique_id', '=', 'cp.unique_id');
        $sql->join('services as s', 's.id', '=', 'sb.service_id');
        $sql->join('client_week_plans as cwp', 'cwp.client_plan_id', '=', 'cp.id');
        $sql->join('users as u', 'u.id', '=', 'cp.user_id');
        $sql->where('sb.service_id', '=', 1); // for training program
        $sql->where('sb.client_id', '=', $clientId);
        $sql->where('fp.status', '=', 1);
        $orWhere = 'orWhere';
        $isPublish = 0;
        $isPublishFilter = 0;
        if (!empty($params['is_publish'])) {
            $orWhere = 'Where';
            $isPublish = 1;
        }
        if (isset($params['is_publish'])) {
            $isPublishFilter = 1;
        }
        $sql->where(function ($query) use ($week, $year, $isPublish, $orWhere, $isPublishFilter) {
            $query->Where(function ($query) use ($year, $week, $isPublish, $isPublishFilter) {
                $query->Where(function ($query) use ($year, $week, $isPublish, $isPublishFilter) {
                    $query->where('cwp.week_id', '>', $week)
                        ->where('cwp.year', '>=', $year);
                    if (!empty($isPublishFilter)) {
                        $query->where('cwp.is_publish', '=', $isPublish);
                    }
                })->orWhere(function ($query) use ($year, $week, $isPublish, $isPublishFilter) {
                    $query->where('cwp.week_id', '<', $week)
                        ->where('cwp.year', '>', $year);
                    if (!empty($isPublishFilter)) {
                        $query->where('cwp.is_publish', '=', $isPublish);
                    }
                });
            })->orWhere(function ($query) use ($year, $week, $isPublish) {
                $query->where('cwp.is_publish', '=', $isPublish)
                    ->where('cwp.week_id', '<=', $week)
                    ->where('cwp.year', '<', $year);
            })->$orWhere(function ($query) use ($year, $week, $isPublish) {
                $query->where('cwp.is_publish', '=', $isPublish);
            });
            $query->orderBy('cwp.week_id')->orderBy('cwp.year');
        });
//        $sql->groupBy('fp.unique_id');

        // search filters

        if (!empty($params['search']) && $params['search'] != null) {
            $userName = '%' . $params['search'] . '%';
            $sql->where('u.user_name', 'like', $userName);
        }
        if (!empty($params['week_of_program']) && $params['week_of_program'] != null) {
            $sql->where('cwp.week_count', '=', $params['week_of_program']);
        }
        if (!empty($params['service']) && $params['service'] != null) {
            $service = $params['service'];
            $sql->where('sb.service_id', '=', $service);
        }
        if (!empty($params['repeat_program']) && $params['repeat_program'] != null || $params['repeat_program'] == '0') {
            $repeatProgram = $params['repeat_program'];
            $sql->where('cwp.is_new', '=', $repeatProgram);
        }
        if (!empty($params['week_of_year']) && $params['week_of_year'] != null) {
            $sql->where('cwp.week_id', '=', $params['week_of_year']);
        }
        $sql->orderBy('cwp.week_count');
        $grid = [];
        $grid['query'] = $sql;
        $grid['perPage'] = $params['perPage'];
        $grid['page'] = $params['page'];
        $grid['gridFields'] = self::gridFieldsUpcomingSessions();

        return \Grid::runSql($grid);
    }

    /**
     * This is used to get upcoming session grid fields
     *
     * @return array
     */
    public static function gridFieldsUpcomingSessions()
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
            'week_of_year' => [
                'name' => 'week_of_year',
                'isDisplay' => true,
            ],
            'week_of_program' => [
                'name' => 'week_of_program',
                'isDisplay' => true
            ],
            'service' => [
                'name' => 'service',
                'isDisplay' => true
            ],
            'publish' => [
                'name' => 'publish',
                'isDisplay' => true
            ],
            'new_repeat' => [
                'name' => 'new_repeat',
                'isDisplay' => true
            ],
            'user_name' => [
                'name' => 'user_name',
                'isDisplay' => true,
                'custom' => [
                    'isAnchor' => true,
                    'url' => ''
                ]
            ],
            'booking_form' => [
                'name' => 'booking_form',
                'isDisplay' => true,
            ],
            'status' => [
                'name' => 'status',
                'isDisplay' => true
            ],
        ];

        if (isLightVersion()) {
            unset($arrFields['new_repeat']);
        }

        return $arrFields;
    }

    /**
     * This is used to get upcoming meeting data
     *
     * @param $params
     * @return array
     */
    public static function getUpcomingMeeting($params)
    {
        $clientId = loginId();
        $date = new DateTime();
        $date = $date->format("Y-m-d");
        $sql = DB::table('bookings as b');
        $sql->select('s.name as service','b.unique_id','u.user_name as user_name','sb.training_session_location as location',
            DB::raw("CONCAT('Upcoming') as status"),
            DB::raw("CONCAT(DATE_FORMAT(b.booking_date, '%a, %b %d, %Y '),b.start_time , '-',b.end_time) as booking_date")
        );
        $sql->join('services as s', 's.id', '=', 'b.service_id');
        $sql->join('service_bookings as sb', function ($join) {
            $join->on('sb.unique_id', '=', 'b.unique_id');
            $join->on('sb.service_id', '=', 'b.service_id');
        });
        $sql->join('final_payments as fp', 'fp.unique_id', '=', 'sb.unique_id');
        $sql->join('users as u', 'u.id', '=', 'fp.user_id');
        $sql->where('b.booking_date', '>', $date);
        $sql->where('fp.is_payment', '=', 1);
        $sql->where('b.service_id', '!=', 1);
        $sql->where('b.service_id', '!=', 2);
        $sql->where('b.client_id',$clientId);
        $sql->where('fp.status', '=', 1);
        $sql->orderBy('b.booking_date');
        $sql->orderBy('b.start_time');
        $sql->orderBy('u.user_name');

//         search filters
        if (!empty($params['dropDownFilters'])) {
            if (isset($params['dropDownFilters']['meeting_service_id'])) {
                $sql->where('b.service_id', '=', $params['dropDownFilters']['meeting_service_id']);
            } elseif (isset($params['dropDownFilters']['location'])) {
                if ($params['dropDownFilters']['location'] == '0') {
                    $sql->where('sb.training_session_location', '=', 'Online');
                } elseif (!empty($params['dropDownFilters']['location'])) {
                    $sql->where('sb.training_session_location_id', '=', $params['dropDownFilters']['location']);
                }
            }
        }

        if (!empty($params['search_user']) && $params['search_user'] != null) {
            $userName = '%' . $params['search_user'] . '%';
            $sql->where('u.user_name', 'like', $userName);
        }

        if (!empty($params['schedule_date']) && $params['schedule_date'] != null) {
            $scheduleDate = $params['schedule_date'];
            $sql->where('b.booking_date', '=', $scheduleDate);
        }
//                echo $sql->toSql();exit();
        $grid = [];
        $grid['query'] = $sql;
        $grid['perPage'] = $params['perPage'];
        $grid['page'] = $params['page'];
        $grid['gridFields'] = self::gridFieldsUpcomingMeetings();

        return \Grid::runSql($grid);
    }

    /**
     * This is used to get upcoming meetings grid fields
     *
     * @return array
     */
    public static function gridFieldsUpcomingMeetings()
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
            'booking_date' => [
                'name' => 'booking_date',
                'isDisplay' => true,
            ],
            'service' => [
                'name' => 'service',
                'isDisplay' => true
            ],
            'location' => [
                'name' => 'location',
                'isDisplay' => true
            ],
            'user_name' => [
                'name' => 'user_name',
                'isDisplay' => true,
                'custom' => [
                    'isAnchor' => true,
                    'url' => ''
                ]
            ],
            'booking_form' => [
                'name' => 'booking_form',
                'isDisplay' => true,
            ],
            'status' => [
                'name' => 'status',
                'isDisplay' => true
            ],
        ];

        return $arrFields;
    }

}
