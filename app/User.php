<?php

namespace App;

use App\Models\ClientService;
use App\Models\OauthAccessToken;
use App\Models\Service;
use Carbon\Traits\Date;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use DB;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use Billable;

//    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = true;
    protected $fillable = [
        'first_name', 'middle_name', 'last_name','email', 'user_name', 'specialization_id', 'title', 'user_type', 'display_name', 'email_verified_at',
        'password', 'gender', 'image', 'birthday', 'mobile_number', 'temp_mobile_number', 'temp_email_address'
        ,'extension', 'address_line_one', 'address_line_two', 'city', 'zip_code', 'state', 'country','country_id', 'device_type',
        'device_token', 'otp_code', 'otp_send_time', 'is_verify', 'goal_id', 'height', 'weight',
        'bmi','height_units', 'weight_units', 'waist', 'waist_units','training_age_id','more_info',
        'additional_details','profile_pic_upload','active_status','status','client_status','is_coach_channel','is_education_verified',
        'is_3i_partner','is_username_public','is_identity_verified','eduction_certificate_upload_date','coach_score','last_login','time_spent',
        'is_new','deleted_at','stripe_id','card_brand','card_last_four','trial_ends_at','last_log_created_at','total_bookings',
        'total_rejected_bookings', 'is_client_show','total_earning_with_fee','total_earning','total_spending','client_g_value','introduction','s_a_id','postal_code','coach_popup_status'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * This is used to access oath token
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function AauthAcessToken()
    {
        return $this->hasMany('\App\Models\OauthAccessToken');
    }

    /**
     * 1:n zu access token, we need to logout users
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accessTokens()
    {
        return $this->hasMany(OauthAccessToken::class);
    }

    /**
     * @param $params
     * Get all end Users Data
     * @return array
     */
    public static function getEndUsersData($params)
    {
        $sql = DB::table('users as u');
        $sql->select('u.id', 'u.gender', 'u.bmi', 'g.name as goal_name',
            'u.country', 'u.state', 'u.time_spent', 'u.status','u.user_name','u.city',
            \DB::raw('(CASE WHEN u.is_3i_partner = "1" THEN "1iPartner" ELSE "Not 1iPartner" END) AS is_3i_partner'),
            'user_type',
            'ui.is_identity_verified','u.is_coach_channel as is_coach_verify',
//            DB::raw("u.display_name as name"),
            DB::raw("CONCAT( u.first_name,  ' ', u.last_name ) as name"),
            DB::raw("DATE_FORMAT(u.created_at, '%a, %b %d, %Y - %H:%i %p') as created_at"),
            DB::raw("DATE_FORMAT(u.birthday, '%a, %b %d, %Y - %H:%i %p') as birthday"),
            DB::raw("DATE_FORMAT(u.last_login, '%a, %b %d, %Y - %H:%i %p') as last_login"),
            DB::raw('(select count(fp.user_id) from final_payments as fp where fp.user_id = u.id and fp.is_payment = 1) as total_bookings'),
            DB::raw('(select count(l.user_id) from logs as l where l.user_id = u.id) as `total_logs`')
        );
        $sql->leftjoin('goals as g', 'g.id', '=', 'u.goal_id');
        $sql->join('user_identities as ui', 'ui.user_id', '=', 'u.id');
//        $sql->join('channel_activations as ca', 'ca.user_id', '=', 'u.id');
//        $sql->where('u.user_type', '=', 2);
        $sql->where('u.is_verify', '=', 1);
//        $sql->groupBy('ca.user_id');

        // search filters
        if (!empty($params['dropDownFilters'])) {
            $alias = 'u';
            foreach ($params['dropDownFilters'] as $filterKey => $filter) {
                if (!empty($filter) && $filter != null || $filter == '0') {
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
                            $sql->where('u.birthday', '>', $ageLess59);
                        } else if ($filter == '6') {
                            $ageGreater60 = date('Y-m-d', strtotime($currentDate . " -60 year"));
                            $sql->where('u.birthday', '<', $ageGreater60);
                        }
                    } elseif ($filterKey == 'identity') {
                        if ($filter == '0') {
                            $sql->where('ui.is_identity_verified', '=', 0);
                        } elseif ($filter == '1') {
                            $sql->where('ui.is_identity_verified', '=', 1);
                        } elseif ($filter == '2') {
                            $sql->where('ui.is_identity_verified', '=', 2);
                        }
                    } elseif ($filterKey == 'coach_channel') {
                        if ($filter == '0') {
                            $sql->where('u.is_coach_channel', '=', 0);
                        } elseif ($filter == '1') {
                            $sql->where('u.is_coach_channel', '=', 1);
                        }
                    } elseif ($filterKey == 'no_of_booking') {
                        if ($filter == '0') {
                            $sql->havingRaw("total_bookings = 0");
                        } elseif ($filter == '1') {
                            $sql->havingRaw('total_bookings = 1');
                        } elseif ($filter == '2') {
                            $sql->havingRaw('total_bookings BETWEEN 2 AND 5');
                        } elseif ($filter == '3') {
                            $sql->havingRaw('total_bookings BETWEEN 6 AND 10');
                        } elseif ($filter == '4') {
                            $sql->havingRaw('total_bookings > 10');
                        }
                    } elseif ($filterKey == 'no_of_log') {
                        if ($filter == '0') {
                            $sql->havingRaw("total_logs = 0");
                        } elseif ($filter == '1') {
                            $sql->havingRaw('total_logs BETWEEN 1 AND 10');
                        } elseif ($filter == '2') {
                            $sql->havingRaw('total_logs BETWEEN 11 AND 100');
                        } elseif ($filter == '3') {
                            $sql->havingRaw("total_logs > 100");
                        }
                    }
                    else {
                        $sql->where($alias . '.' . $filterKey, '=', $filter);
                    }
                }
            }
        }
        if (!empty($params['accountRegDate']) && $params['accountRegDate'] != null) {
            $search = '%' . $params['accountRegDate'] . '%';
            $sql->where('u.created_at', 'like', $search);
        }
        if (!empty($params['lastLogin']) && $params['lastLogin'] != null) {
            $search = '%' . $params['lastLogin'] . '%';
            $sql->where('u.last_login', 'like', $search);
        }
        if (!empty($params['birthDay']) && $params['birthDay'] != null) {
            $search = '%' . $params['birthDay'] . '%';
            $sql->where('u.birthday', 'like', $search);
        }
        if (!empty($params['bmi']) && $params['bmi'] != null) {
            $search = $params['bmi'];
            $sql->where('u.bmi', '=', $search);
        }
        if (!empty($params['timeSpent']) && $params['timeSpent'] != null) {
            $search = $params['timeSpent'];
            $sql->where('u.time_spent', '=', $search);
        }
        if (!empty($params['search'])) {
            $search = '%' . $params['search'] . '%';
            $sql->where('u.first_name', 'like', $search);
            $sql->orwhere('u.last_name', 'like', $search);
        }
        if (!empty($params['searchUserName'])) {
            $search = '%' . $params['searchUserName'] . '%';
            $sql->where('u.user_name', 'like', $search);

        }

        $sql->orderBy('u.created_at', 'desc');

//        echo $sql->toSql();exit();
        $grid = [];
        $grid['query'] = $sql;
        $grid['perPage'] = $params['perPage'];
        $grid['page'] = $params['page'];
        $grid['gridFields'] = self::gridFieldsEndUsers();

        return \Grid::runSql($grid, 'un_prepared');
    }

    /**
     * Freelance User Data
     * @param $params
     * @return array
     */
    public static function getFreelanceUsersData($params)
    {
        $sql = DB::table('users as u');
        $sql->select('u.id', 'u.created_at', 'u.title', 's.name as specialization', 'u.country', 'u.state', 'u.city', 'u.last_login', 'u.status',
            DB::raw("CONCAT( u.first_name,  ' ', u.last_name ) as name"),
            DB::raw("DATE_FORMAT(u.created_at, '%a, %b %d, %Y - %H:%i %p') as created_at"),
            DB::raw("DATE_FORMAT(u.last_login, '%a, %b %d, %Y - %H:%i %p') as last_login")
        );
        $sql->leftjoin('specializations as s', 's.id', '=', 'u.specialization_id');
        $sql->where('u.user_type', '=', 0);
        // search filters
        if (!empty($params['action_freelance'])) {
            if ($params['action_freelance'] == 'active') {
                $sql->where('u.status', '=', 1);
                $sql->orwhere('u.status', '=', 0);
            } else
                $sql->whereNotNull('u.deleted_at');
        }

        if (!empty($params['dropDownFilters'])) {
            $alias = 'u';
            foreach ($params['dropDownFilters'] as $filterKey => $filter) {
                if (!empty($filterKey) && $filter != null) {
                    $sql->where($alias . '.' . $filterKey, '=', $filter);
                }
            }
        }
        if (!empty($params['search'])) {
            $search = '%' . $params['search'] . '%';
            $sql->where('u.first_name', 'like', $search);
        }

        if (!empty($params['accountRegDate']) && $params['accountRegDate'] != null) {
            $search = '%' . $params['accountRegDate'] . '%';
            $sql->where('u.created_at', 'like', $search);
        }
        if (!empty($params['lastLogin']) && $params['lastLogin'] != null) {
            $search = '%' . $params['lastLogin'] . '%';
            $sql->where('u.last_login', 'like', $search);
        }
        $sql->orderBy('u.created_at', 'desc');

        $grid = [];
        $grid['query'] = $sql;
        $grid['perPage'] = $params['perPage'];
        $grid['page'] = $params['page'];
        $grid['gridFields'] = self::gridFieldsFreelanceUsers();

        return \Grid::runSql($grid);
    }
    /**
     * Freelance User Data
     * @param $params
     * @return array
     */
    public static function getClientsData($params)
    {
        $currentDate = currentDateTime();
        $clientId  = loginId();
        $sql = DB::table('users as u');
        $sql->select('u.id', 'u.country','u.user_name',
            'u.state', 'u.city', 'u.bmi', 'u.display_name','u.bmi','u.gender',
            DB::raw("CONCAT( u.first_name,  ' ', u.last_name ) as name"),
            DB::raw("TIMESTAMPDIFF(YEAR, DATE(u.birthday), current_date) AS user_age"),
            DB::raw("DATE_FORMAT(u.birthday, '%a, %b %d, %Y - %H:%i %p') as birthday")
        );

        // search filters
        if (!empty($params['action_freelance'])) {
            $sql->addSelect(
                'b.id as booking_id','fp.unique_id','fp.client_f_amount as subTotal', 'fp.status as status',
                DB::raw("DATE_FORMAT(sb.created_at, '%a, %b %d, %Y - %H:%i %p') as booking"),
                DB::raw("DATE_FORMAT(fp.created_at, '%a, %b %d, %Y - %H:%i %p') as created_at"),
                \DB::raw('(CASE WHEN fp.status = "1" THEN "Completed" ELSE "Rejected" END) AS reason_rejected')
            );
            $sql->join('service_bookings as sb', 'sb.user_id', '=', 'u.id');
            $sql->where('sb.client_id', '=',$clientId);

//            $sql->where('u.user_type', '=', 2);
            $sql->leftjoin('bookings as b', 'b.user_id', '=', 'u.id');
            $sql->join('final_payments as fp', 'fp.unique_id', '=', 'sb.unique_id');
            if ($params['action_freelance'] == 'active') {
                $sql->where(['fp.status' => 1, 'fp.is_payment' => 1]);
                $sql->where('fp.end_date','>=',$currentDate);
                $sql->addSelect(DB::raw("'1' as actionColumn"));
            } else if ($params['action_freelance'] == 'waiting') {
                $sql->addSelect(DB::raw("'2' as actionColumn"));
                $sql->where(['fp.status' => 0, 'fp.is_payment' => 1]);
            } else if ($params['action_freelance'] == 'archived') {
                $sql->addSelect(DB::raw("'3' as actionColumn"));
                $sql->where(function($query)use($currentDate) {
                    $query->where('fp.status', '=', 2);
                    $query->orwhere(function($query)use($currentDate) {
                        $query->where('fp.status', 1)->Where('fp.end_date','<',$currentDate);
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
                                $sql->where('u.birthday', '>', $ageLess59);
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
            $sql->where('u.first_name', 'like', $search);
        }
        if (!empty($params['userName']) && $params['userName'] != null) {
            $userName = '%' . $params['userName'] . '%';
            $sql->where('u.user_name', 'like', $userName);
        }
        $sql->orderBy('u.created_at', 'desc');

        $grid = [];
        $grid['query'] = $sql;
        $grid['perPage'] = $params['perPage'];
        $grid['page'] = $params['page'];
        $grid['gridFields'] = self::gridFieldsClients($params['action_freelance']);
        $removeAction = true;
        if (!empty($params['action_freelance']) && $params['action_freelance'] == 'waiting') {
            $removeAction = false;
        }
        if (!empty($removeAction)) {
            unset($grid['gridFields']['action_column']);
        }

        return \Grid::runSql($grid);
    }

    /**
     * @return array
     */
    public static function gridFieldsEndUsers()
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
                    'url' => \URL::route('subscriber-profile.index')
                ]
            ],
            'user_name' => [
                'name' => 'user_name',
                'isDisplay' => true
            ],
            'created_at' => [
                'name' => 'created_at',
                'isDisplay' => true
            ],
            'birthday' => [
                'name' => 'birthday',
                'isDisplay' => true
            ],
            'gender' => [
                'name' => 'gender',
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
            'is_3i_partner' => [
                'name' => 'is_3i_partner',
                'isDisplay' => true
            ],
            'is_identity_verified' => [
                'name' => 'is_identity_verified',
                'isDisplay' => true
            ],
            'is_coach_verify' => [
                'name' => 'is_coach_verify',
                'isDisplay' => true
            ],
            'total_bookings' => [
                'name' => 'total_bookings',
                'isDisplay' => true
            ],
            'total_logs' => [
                'name' => 'total_logs',
                'isDisplay' => true
            ],
            'last_login' => [
                'name' => 'last_login',
                'isDisplay' => true
            ],
            'time_spent' => [
                'name' => 'time_spent',
                'isDisplay' => true
            ],
            'status' => [
                'name' => 'status',
                'isDisplay' => true
            ],
        ];

        return $arrFields;
    }

    public static function gridFieldsFreelanceUsers()
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
                    'url' => \URL::route('subscriber-profile.index')
                ]
            ],
            'created_at' => [
                'name' => 'created_at',
                'isDisplay' => true
            ],
            'title' => [
                'name' => 'title',
                'isDisplay' => true
            ],
            'specialization' => [
                'name' => 'specialization',
                'isDisplay' => true
            ],
            'country' => [
                'name' => 'country',
                'isDisplay' => true
            ],
            'state' => [
                'name' => 'state',
                'isDisplay' => true
            ],
            'city' => [
                'name' => 'city',
                'isDisplay' => true
            ],
            'active_client' => [
                'name' => 'active_client',
                'isDisplay' => true
            ],
            'waiting_client' => [
                'name' => 'waiting_client',
                'isDisplay' => true
            ],
            'archived_client' => [
                'name' => 'archived_client',
                'isDisplay' => true
            ],
            'payments' => [
                'name' => 'payments',
                'isDisplay' => true
            ],
            'last_login' => [
                'name' => 'last_login',
                'isDisplay' => true
            ],
            'status' => [
                'name' => 'status',
                'isDisplay' => true
            ],
        ];

        return $arrFields;
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
            'action_column' => [
                'name' => 'action_column',
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
            'user_age' => [
                'name' => 'user_age',
                'isDisplay' => true
            ],
            'gender' => [
                'name' => 'gender',
                'isDisplay' => true
            ],
//            'created_at' => [
//                'name' => 'created_at',
//                'isDisplay' => true
//            ],
//            'bmi' => [
//                'name' => 'bmi',
//                'isDisplay' => true
//            ],
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
//            'status' => [
//                'name' => 'status',
//                'isDisplay' => true
//            ],
        ];
        if (isLightVersion()) {
            unset($arrFields['subTotal']);
        }

        if ($action === 'archived') {
            $arrFields = $arrFields + ['reason_rejected' => ['name' => 'reason_rejected', 'isDisplay' => true]];
        }

        return $arrFields;
    }

    /**
     * This is used to check user exist or not by identifier
     *
     * @param $identifier
     * @return mixed
     */
    public static function findForPassport($identifier, $extension = '')
    {
        return User::orWhere(function ($query) use ($identifier, $extension) {
            return $query->where('mobile_number', '=', $identifier)
                ->where('extension', '=', $extension);
        })
            ->orWhere('user_name', $identifier)
            ->first();
    }

    /**
     * This is used to get
     *
     * @param $params
     * @return mixed
     */
    public static function getSpecialists($params)
    {
        $assetUrl = $params['assetUrl'];
        $sql = DB::table('users as u');
        $sql->select('u.id as client_id','u.first_name','u.last_name', 'u.created_at', 'u.title','u.profile_pic_upload',
            'u.gender', 'u.birthday','sab.service_id', 'tps.base_price',
            'tsl.address_name', 'ui.is_identity_verified', 'u.is_education_verified','is_username_public',
            DB::raw("CONCAT( u.first_name,  ' ', u.last_name ) as name"),
            DB::raw("DATE_FORMAT(u.created_at, '%a, %b %d, %Y - %H:%i %p') as created_at"),
            DB::raw("CONCAT('$assetUrl','/',u.profile_pic_upload) as profile_pic_upload"),
            DB::raw('(CASE WHEN u.is_username_public = "0" THEN "" ELSE u.user_name END) AS user_name')
        );
        $sql->leftjoin('specializations as s', 's.id', '=', 'u.specialization_id');
        $sql->join('training_program_price_setups as tps','tps.user_id','u.id');
        $sql->join('user_identities as ui','ui.user_id','u.id');
        $sql->leftJoin('training_session_locations as tsl', 'tsl.training_program_price_setup_id', '=', 'tps.id');
        $sql->join('service_available_bookings as sab', function ($join) {
            $join->on('sab.user_id', '=', 'u.id')
                ->on('sab.service_id', '=', 'tps.type')
                ->where('sab.is_checked', '=', 1);
        });
        $search = '%' . $params['search'] . '%';
        if (!empty($params['search'])) {
            $sql->where(function ($query) use ($search) {
                $query->where('u.first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('u.last_name', 'LIKE', '%' . $search . '%');
                $query->orWhere(\DB::raw("CONCAT( u.first_name,  ' ', u.last_name )"), 'LIKE', '%' . $search . '%');
            });
        }
        if(!empty($params['blockUser'])){
            $sql->whereNotIn('u.id',$params['blockUser']);
        }
        if(!empty($params['user_id'])){
            $sql->where('u.id','!=',$params['user_id']);
        }
        $sql->where('u.user_type', '=', 0);
        $sql->where('u.is_coach_channel', '=', 1);
        if (!isLightVersion()) {
            $sql->where('u.is_client_show', '=', 1);
        }
        $sql->where('u.status', '=', 1);
        $sql->orderBy('u.coach_score','desc');
        $sql->orderBy('u.created_at');
        // search filters

        $sql->groupBy('u.id');

        return $sql->get()->toArray();
    }

    public function services()
    {
        return $this->hasMany(ClientService::class);
    }

    /**
     * this is used to get Age from Birthday
     * @return int
     */
    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birthday'])->age;
    }

    /**
     * This is used to get user channel details
     *
     * @param $params
     * @return mixed
     */
    public static function getUserChannelDetails($params)
    {
        $sql = DB::table('users as u');
        $sql->select('u.id as client_id', 'u.first_name', 'u.last_name', 'u.created_at', 'u.title', 'u.profile_pic_upload',
            'u.gender', 'u.birthday', 'sab.service_id', 'tps.base_price',
            'tsl.address_name', 'ui.is_identity_verified', 'u.is_education_verified', 'is_username_public',
            DB::raw('(CASE WHEN u.is_username_public = "0" THEN "" ELSE u.user_name END) AS user_name')
        );
        $sql->leftjoin('specializations as s', 's.id', '=', 'u.specialization_id');
        $sql->join('training_program_price_setups as tps', 'tps.user_id', 'u.id');
        $sql->join('user_identities as ui', 'ui.user_id', 'u.id');
        $sql->leftJoin('training_session_locations as tsl', 'tsl.training_program_price_setup_id', '=', 'tps.id');
        $sql->join('service_available_bookings as sab', function ($join) {
            $join->on('sab.user_id', '=', 'u.id')
                ->on('sab.service_id', '=', 'tps.type')
                ->where('sab.is_checked', '=', 1);
        });

        $sql->where('u.user_type', '=', 0);
        $sql->where('u.is_coach_channel', '=', 1);
        if (!isLightVersion()) {
            $sql->where('u.is_client_show', '=', 1);
        }
        $sql->where('u.status', '=', 1);
        $sql->where('u.id', '=', $params['user_id']);

        // search filters

        $sql->groupBy('u.id');

        return $sql->count();
    }

}
