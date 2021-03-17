<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use IlluminateAgnostic\Arr\Support\Carbon;

class Booking extends Model
{
    protected $fillable = ['unique_id','client_id', 'user_id', 'service_id',
        'start_time', 'end_time', 'booking_date','status','is_payment',
        'is_confirmed','amount','is_paid_to_client','payout_month','week_id','year','payout_date'];


    /**
     * Freelance User Data
     * @param $params
     * @return array
     */
    public static function getPartnerBookings($params)
    {
        $currentDate = currentDateTime();
        $sql = DB::table('users as u');
        $sql->select('u.id', 'u.country','u.user_name',
            'u.state', 'u.city', 'u.bmi', 'u.display_name','u.bmi','u.gender',
            DB::raw("CONCAT( u.first_name,  ' ', u.last_name ) as name"),
            DB::raw("TIMESTAMPDIFF(YEAR, DATE(u.birthday), current_date) AS user_age"),
            DB::raw("DATE_FORMAT(u.birthday, '%m/%d/%Y - %H:%i %p') as birthday")
        );

        // search filters
        if (!empty($params['action_freelance'])) {
            $sql->join('service_bookings as sb', 'sb.user_id', '=', 'u.id');
            $sql->addSelect(
                'b.id as booking_id', 'fp.unique_id', 'fp.total_price as subTotal', 'fp.status as booking_status',
                DB::raw("DATE_FORMAT(sb.created_at, '%a, %b %d, %Y - %H:%i %p') as booking"),
                DB::raw("DATE_FORMAT(fp.created_at, '%a, %b %d, %Y - %H:%i %p') as created_at"),
                DB::raw('(CASE WHEN fp.status = "1" THEN "Completed" ELSE "Rejected" END) AS reason_rejected'),
                DB::raw('(CASE WHEN fp.status = "1" THEN "Active"WHEN fp.status = "0" THEN "Waiting" ELSE "Archived" END) AS booking_status'),
                DB::raw("(select CONCAT( uc.first_name,' ', uc.last_name ) from users as uc where uc.id = sb.client_id) as `partner_name`")
            );

//            $sql->where('u.user_type', '=', 2);
            $sql->leftjoin('bookings as b', 'b.user_id', '=', 'u.id');
            $sql->join('final_payments as fp', 'fp.unique_id', '=', 'sb.unique_id');
            if ($params['action_freelance'] == 'active') {
                $sql->where(['fp.status' => 1, 'fp.is_payment' => 1]);
                $sql->where('fp.end_date', '>=', $currentDate);
                $sql->addSelect(DB::raw("'1' as actionColumn"));
            } else if ($params['action_freelance'] == 'waiting') {
                $sql->addSelect(DB::raw("'2' as actionColumn"));
                $sql->where(['fp.status' => 0, 'fp.is_payment' => 1]);
            } else if ($params['action_freelance'] == 'archived') {
                $sql->addSelect(DB::raw("'3' as actionColumn"));
                $sql->where(function ($query) use ($currentDate) {
                    $query->where('fp.status', '=', 2);
                    $query->orwhere(function ($query) use ($currentDate) {
                        $query->where('fp.status', 1)->Where('fp.end_date', '<', $currentDate);
                    });
                });
            }
            $sql->groupBy('fp.unique_id');
        } else {
            $sql->where('u.user_type', '=', 2);
            $sql->addSelect(DB::raw("DATE_FORMAT(u.created_at, '%a, %b %d, %Y - %H:%i %p') as created_at"));
        }
        if (!empty($params['dropDownFilters'])) {
            $alias = 'u';
            foreach ($params['dropDownFilters'] as $filterKey => $filter) {
                if (!empty($filterKey) && $filter != null || $filter == '0') {
                    if($filterKey == 'reason_archiving') {
                        $sql->where('fp.status', '=', $filter);
                    }
                    if ($filterKey == 'age') {
                        $date = Carbon::now();
                        $currentDate = $date->format('d-m-Y');
                        if ($filter == '1') {
                            $age = date('Y-m-d', strtotime($currentDate . " -20 year"));
                            $sql->where('u.birthday', '>', $age);
                        } else if ($filter == '2') {
                            $ageGreater20 = date('Y-m-d', strtotime($currentDate . " -20 year"));
                            $ageLess29 = date('Y-m-d', strtotime($currentDate . " -29 year"));
                            $sql->where('u.birthday', '<', $ageGreater20);
                            $sql->where('u.birthday', '>', $ageLess29);
                        } else if ($filter == '3') {
                            $ageGreater30 = date('Y-m-d', strtotime($currentDate . " -30 year"));
                            $ageLess39 = date('Y-m-d', strtotime($currentDate . " -39 year"));
                            $sql->where('u.birthday', '<', $ageGreater30);
                            $sql->where('u.birthday', '>', $ageLess39);
                        } else if ($filter == '4') {
                            $ageGreater40 = date('Y-m-d', strtotime($currentDate . " -40 year"));
                            $ageLess49 = date('Y-m-d', strtotime($currentDate . " -49 year"));
                            $sql->where('u.birthday', '<', $ageGreater40);
                            $sql->where('u.birthday', '>', $ageLess49);
                        } else if ($filter == '5') {
                            $ageGreater50 = date('Y-m-d', strtotime($currentDate . " -50 year"));
                            $ageLess59 = date('Y-m-d', strtotime($currentDate . " -59 year"));
                            $sql->where('u.birthday', '<', $ageGreater50);
                            $sql->where('u.birthday',  '>', $ageLess59);
                        } else if ($filter == '6') {
                            $ageGreater60 = date('Y-m-d', strtotime($currentDate . " -60 year"));
                            $sql->where('u.birthday', '<', $ageGreater60);
                        }
                    }
                    if ($filterKey == 'gender') {
                        if ($filter == 'male') {
                            $sql->where('u.gender', '=', 'male');
                        } else if ($filter == 'female') {
                            $sql->where('u.gender', '=', 'female');
                        }
                    }
                    if ($filterKey == 'bmi') {
                        if ($filter == '1') {
                            $sql->where('u.bmi', '<', 18.5);
                        } else if ($filter == '2') {
                            $sql->where('u.bmi', '>=', 18.5);
                            $sql->where('u.bmi', '<=', 24.9);
                        }
                        else if ($filter == '3') {
                            $sql->where('u.bmi', '>=', 25);
                            $sql->where('u.bmi', '<=', 29.9);
                        }else if ($filter == '4') {
                            $sql->where('u.bmi', '>', 30);
                        }
                    }
                    if ($filterKey == 'country') {
                        $sql->where('u.country_id', '=',$filter );
                    }
                    if ($filterKey == 'cityList') {
                        $sql->where('u.city', '=',$filter );
                    }
                }
            }
        }
        if (!empty($params['bookingSubmission']) && $params['bookingSubmission'] != null) {
            $submission = '%' . $params['bookingSubmission'] . '%';
            $sql->where('sb.created_at', 'like', $submission);
        }
        if (!empty($params['search'])) {
            $search = '%' . $params['search'] . '%';
            $sql->where(function ($query) use ($search) {
                $query->where('u.first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('u.last_name', 'LIKE', '%' . $search . '%');
                $query->orWhere(\DB::raw("CONCAT( u.first_name,  ' ', u.last_name )"), 'LIKE', '%' . $search . '%');
            });
        }
        if (!empty($params['userName']) && $params['userName'] != null) {
            $userName = '%' . $params['userName'] . '%';
            $sql->where('u.user_name', 'like', $userName);
        }
        if (!empty($params['partner']) && $params['partner'] != null) {
            $partnerName = '%' . $params['partner'] . '%';
            $sql->where(function ($query) use ($partnerName) {
                $query->where('sb.first_name', 'LIKE', '%' . $partnerName . '%')
                    ->orWhere('sb.last_name', 'LIKE', '%' . $partnerName . '%');
                $query->orWhere(\DB::raw("CONCAT( sb.first_name,  ' ', sb.last_name )"), 'LIKE', '%' . $partnerName . '%');
            });

        }
        $sql->orderBy('u.created_at', 'desc');
//        echo $sql->toSql(); exit;
        $grid = [];
        $grid['query'] = $sql;
        $grid['perPage'] = $params['perPage'];
        $grid['page'] = $params['page'];
        $grid['gridFields'] = self::gridFieldsClients($params['action_freelance']);
//        echo $sql->toSql();exit();
        return \Grid::runSql($grid);
    }

    public static function gridFieldsClients($action)
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
            'name' => [
                'name' => 'name',
                'isDisplay' => true,
                'custom' => [
                    'isAnchor' => true,
                    'url' => ''
                ]
            ],
            'user_name' => [
                'name' => 'user_name',
                'isDisplay' => true
            ],
            'partner_name' => [
                'name' => 'partner_name',
                'isDisplay' => true
            ],
            'user_age' => [
                'name' => 'user_age',
                'isDisplay' => true
            ],
            'gender' => [
                'name' => 'gender',
                'isDisplay' => true
            ],
            'bmi_category' => [   // Bmi category not available
                'name' => 'bmi',
                'isDisplay' => true
            ],
            'booking' => [
                'name' => 'booking',
                'isDisplay' => true
            ],
            'subTotal' => [
                'name' => 'subTotal',
                'isDisplay' => true
            ],
            'country' => [
                'name' => 'country',
                'isDisplay' => true
            ],
            'city' => [
                'name' => 'city',
                'isDisplay' => true
            ],
        ];
        if ($action === 'archived') {
            $arrFields = $arrFields + ['reason_rejected' => ['name' => 'reason_rejected', 'isDisplay' => true]];
        }
        $arrFields = $arrFields + ['booking_status' => ['name' => 'booking_status', 'isDisplay' => true]];

        return $arrFields;
    }


}
