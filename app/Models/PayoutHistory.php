<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PayoutHistory extends Model
{
    protected $fillable = ['client_id','unique_id','date_of_transfer',
        'amount','transfer_to','earning_month','transfer_id','destination_id','currency',
        'object','week_plan_id','booking_id'];

    public static function getPayoutHistory($params)
    {
        $coachId = loginId();
        $payoutHistory = DB::table("payout_histories as ph")->select("ph.id",
            DB::raw("DATE_FORMAT(ph.date_of_transfer, '%d/%b/%Y ') as dateOfTransfer"),
            "ph.amount",
            "ph.transfer_to",
            DB::raw("DATE_FORMAT(ph.earning_month, '%b/%Y ') as earning_month"),
            DB::raw("CONCAT('download') as download_receipt"),
            'ph.transfer_id'
            )
        ->where('client_id',$coachId)
        ->orderBy('id','desc');
        $grid = [];
        $grid['query'] = $payoutHistory;
        $grid['perPage'] = $params['perPage'];
        $grid['page'] = $params['page'];
        $grid['gridFields'] = self::gridFieldsCoachFunds($params['action_freelance']);

        return \Grid::runSql($grid);
    }

    public static function gridFieldsCoachFunds($action)
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
            'dateOfTransfer' => [
                'name' => 'dateOfTransfer',
                'isDisplay' => true
            ],
            'amount' => [
                'name' => 'amount',
                'isDisplay' => true
            ],
            'transfer_to' => [
                'name' => 'transfer_to',
                'isDisplay' => true
            ],
            'earning_month' => [
                'name' => 'earning_month',
                'isDisplay' => true
            ],
            'download_receipt' => [
                'name' => 'download_receipt',
                'isDisplay' => true
            ],

        ];
//        $arrFields = $arrFields + ['id' => ['name' => 'id', 'isDisplay' => true]];

        return $arrFields;
    }

    public static function getPayDetails($params,$currentMonth,$currentYear)
    {
        $currentDate = currentDateTime();
        $result = DB::table('confirmed_amounts as ca')->select('u.user_name as name', 'ca.client_id',
            \DB::raw('(CASE WHEN u.s_a_id = "0" THEN "no" ELSE "yes" END) AS s_a_id'),
            DB::raw("SUM(ca.amount) as amount")
        )
            ->join('users as u', 'u.id', '=', 'ca.client_id')
            ->where('ca.is_confirmed', '=', 1)
            ->where('ca.is_paid_to_client', '=', 0)
            ->whereDate('ca.payout_date','<=',$currentDate)
//            ->Where(function ($query) use ($currentMonth, $currentYear) {
//                $query->whereMonth('ca.payout_month', '<=', $currentMonth)
//                    ->orWhereYear('ca.payout_month', '<', $currentYear);
//            })
            ->orderBy('ca.amount', 'desc')
            ->groupBy('ca.client_id'); // important to get seperate all coaches amounts
        if (!empty($params['coach_search'])) {
            $search = '%' . $params['coach_search'] . '%';
            $result->where('u.user_name', 'like', $search);
        }
        $grid = [];
        $grid['query'] = $result;
        $grid['perPage'] = $params['perPage'];
        $grid['page'] = $params['page'];

        $grid['gridFields'] = self::gridFieldsCoachFundsDetail($params['action_freelance']);

        return \Grid::runSql($grid);
    }

    public static function gridFieldsCoachFundsDetail()
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
                'isDisplay' => true
            ],
            'amount' => [
                'name' => 'amount',
                'isDisplay' => true
            ],
            's_a_id' => [
                'name' => 's_a_id',
                'isDisplay' => true
            ],
        ];

        return $arrFields;
    }
}
