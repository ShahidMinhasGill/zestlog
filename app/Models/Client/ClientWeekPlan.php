<?php

namespace App\Models\Client;

use App\Models\BankAcconut;
use App\Models\ClientCurrency;
use App\Models\PayoutHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use IlluminateAgnostic\Arr\Support\Carbon;
use Symfony\Component\Console\Input\Input;

class ClientWeekPlan extends Model
{
    protected $fillable = ['client_plan_id', 'week_id', 'user_id', 'unique_id', 'year',
        'week_count', 'is_new', 'is_confirmed', 'is_publish',
        'client_id', 'amount', 'is_paid_to_client', 'payout_month','payout_date'];


    /**
     * Coach funds
     * @param $params
     * @return array
     */
    public static function getCoachFunds($params)
    {
        $coachId = loginId();
//        $clientCurrency = ClientCurrency::select('c.code')
//            ->join('currencies as c','c.id','=','client_currencies.currency_id')
//            ->where('client_currencies.client_id',$coachId)->first();

        $clientWeekPlan = DB::table("client_week_plans as cwp")->select("cwp.id","s.name as service_id",
            DB::raw("CONCAT('week ',cwp.week_id,',',cwp.year) as week_of_year"),
            "cwp.week_count as week_of_program",
            DB::raw("CONCAT(cwp.amount,' ','GBP') as amount"),
            DB::raw('(CASE WHEN cwp.is_confirmed = "1" THEN "Confirmed" WHEN cwp.is_confirmed = "2" THEN "Pending"
            ELSE "Not Confirmed" END) AS is_confirmed'),
            'u.user_name',
            DB::raw("CONCAT(' ') as time"),
            DB::raw("DATE_FORMAT(cwp.payout_month, '%d %b, %Y') as payout_month"),
            'cwp.unique_id',
            'cwp.week_id',
            'cwp.year',
            'cwp.created_at'
        );
        $clientWeekPlan->join('users as u', 'u.id', '=', 'cwp.user_id');
        $clientWeekPlan->join('final_payments as fp', 'fp.unique_id', '=', 'cwp.unique_id');
        $clientWeekPlan->join('services as s', 's.id', '=', 'cwp.service_id');
        $clientWeekPlan->where("cwp.client_id", "=", $coachId);
        $clientWeekPlan->where("fp.status", "=", 1);
        if($params['action_freelance'] == 'pending'){
            $clientWeekPlan->addSelect(DB::raw("CONCAT('Fund') as status"));
            $clientWeekPlan->where("cwp.is_confirmed", "<>", 1);
            $clientWeekPlan->where("cwp.is_paid_to_client", "=", 0);
        }elseif($params['action_freelance'] == 'confirmed'){
            $clientWeekPlan->addSelect(DB::raw("CONCAT('Earned') as status"));
            $clientWeekPlan->where("cwp.is_confirmed", "=", 1);
            $clientWeekPlan->where("cwp.is_paid_to_client", "=", 0);
        }elseif($params['action_freelance'] == 'payouts'){
            $clientWeekPlan->addSelect(DB::raw("CONCAT('Paid out') as status"));
            $clientWeekPlan->where("cwp.is_confirmed", "=", 1);
            $clientWeekPlan->where("cwp.is_paid_to_client", "=", 1);
        }
        if (!empty($params['search'])) {
            $search = '%' . $params['search'] . '%';
            $clientWeekPlan->where('user_name', 'like', $search);
        }
        if (!empty($params['dropDownFilters'])) {
            $alias = 'cwp';
            foreach ($params['dropDownFilters'] as $filterKey => $filter) {
                if (!empty($filterKey) && $filter != null) {
                    $clientWeekPlan->where($alias . '.' . $filterKey, '=', $filter);
                }
            }
        }

        $bookings = DB::table("bookings as b")->select("b.id", "s.name as service_id",
            DB::raw("CONCAT('week ',b.week_id,',',b.year) as week_of_year"),
            DB::raw("CONCAT('') as week_of_program"),
            DB::raw("CONCAT(b.amount,' ','GBP') as amount"),
            DB::raw('(CASE WHEN b.is_confirmed = "1" THEN "Confirmed" WHEN b.is_confirmed = "2" THEN "Pending"
            ELSE "Not Confirmed" END) AS is_confirmed'),
            "u.user_name",
            DB::raw("CONCAT(DATE_FORMAT(b.booking_date, '%a, %b %d, %Y '),b.start_time , '-',b.end_time) as time"),
            DB::raw("DATE_FORMAT(b.payout_month, '%d %b, %Y') as payout_month"),
            'b.unique_id',
            'b.week_id',
            'b.year',
            'b.created_at'
        )
            ->join('users as u','u.id','=','b.user_id')
            ->join('services as s', 's.id', '=', 'b.service_id')
            ->join('final_payments as fp', 'fp.unique_id', '=', 'b.unique_id')
            ->where("b.client_id", "=", $coachId)
            ->where("fp.status", "=", 1)
            ->union($clientWeekPlan);
        if ($params['action_freelance'] == 'pending') {
            $bookings->addSelect(DB::raw("CONCAT('Fund') as status"));
            $bookings->where("b.is_confirmed", "<>", 1);
            $bookings->where("b.is_paid_to_client", "=", 0);
        } elseif ($params['action_freelance'] == 'confirmed') {
            $bookings->addSelect(DB::raw("CONCAT('Earned') as status"));
            $bookings->where("b.is_confirmed", "=", 1);
            $bookings->where("b.is_paid_to_client", "=", 0);
        } elseif ($params['action_freelance'] == 'payouts') {
            $bookings->addSelect(DB::raw("CONCAT('Paid out') as status"));
            $bookings->where("b.is_confirmed", "=", 1);
            $bookings->where("b.is_paid_to_client", "=", 1);
        }
        if (!empty($params['search'])) {
            $search = '%' . $params['search'] . '%';
            $bookings->where('user_name', 'like', $search);
        }
        if (!empty($params['dropDownFilters'])) {
            $alias = 'b';
            foreach ($params['dropDownFilters'] as $filterKey => $filter) {
                if (!empty($filterKey) && $filter != null) {
                    $bookings->where($alias . '.' . $filterKey, '=', $filter);
                }
            }
        }

        $bookings->orderBy('year')->orderBy('week_id')->orderBy('created_at');
        $grid = [];
        $grid['query'] = $bookings;
        $grid['perPage'] = $params['perPage'];
        $grid['page'] = $params['page'];
        $grid['gridFields'] = self::gridFieldsCoachFunds($params['action_freelance']);

        return \Grid::runSql($grid);
    }

    public static function adminCoachFunds($params)
    {
        $clientWeekPlan = DB::table("client_week_plans as cwp")->select("cwp.id","s.name as service_id",
            DB::raw("CONCAT('week ',cwp.week_id,',',cwp.year) as week_of_year"),
            "cwp.week_count as week_of_program",
            DB::raw("CONCAT(cwp.amount,' ','GBP') as amount"),
            DB::raw('(CASE WHEN cwp.is_confirmed = "1" THEN "Confirmed" WHEN cwp.is_confirmed = "2" THEN "Pending"
            ELSE "Not Confirmed" END) AS is_confirmed'),
            'u.user_name',
            DB::raw("CONCAT(' ') as time"),
            DB::raw("DATE_FORMAT(cwp.payout_month, '%d %b, %Y') as payout_month"),
            'cwp.unique_id',
            'cwp.week_id',
            'cwp.year',
            'cwp.created_at'
        );
        $clientWeekPlan->join('users as u', 'u.id', '=', 'cwp.client_id');
        $clientWeekPlan->join('services as s', 's.id', '=', 'cwp.service_id');
        $clientWeekPlan->join('final_payments as fp', 'fp.unique_id', '=', 'cwp.unique_id');
        $clientWeekPlan->where('fp.status', '=',1);
        if($params['action_freelance'] == 'pending'){
            $clientWeekPlan->addSelect(DB::raw("CONCAT('Fund') as status"));
            $clientWeekPlan->where("cwp.is_confirmed", "<>", 1);
            $clientWeekPlan->where("cwp.is_paid_to_client", "=", 0);
        }elseif($params['action_freelance'] == 'confirmed'){
            $clientWeekPlan->addSelect(DB::raw("CONCAT('Earned') as status"));
            $clientWeekPlan->where("cwp.is_confirmed", "=", 1);
            $clientWeekPlan->where("cwp.is_paid_to_client", "=", 0);
        }elseif($params['action_freelance'] == 'payouts'){
            $clientWeekPlan->addSelect(DB::raw("CONCAT('Paid out') as status"));
            $clientWeekPlan->where("cwp.is_confirmed", "=", 1);
            $clientWeekPlan->where("cwp.is_paid_to_client", "=", 1);
        }
        if (!empty($params['search'])) {
            $search = '%' . $params['search'] . '%';
            $clientWeekPlan->where('user_name', 'like', $search);
        }
        if (!empty($params['dropDownFilters'])) {
            $alias = 'cwp';
            foreach ($params['dropDownFilters'] as $filterKey => $filter) {
                if (!empty($filterKey) && $filter != null) {
                    $clientWeekPlan->where($alias . '.' . $filterKey, '=', $filter);
                }
            }
        }
        $bookings = DB::table("bookings as b")->select("b.id", "s.name as service_id",
            DB::raw("CONCAT('week ',b.week_id,',',b.year) as week_of_year"),
            DB::raw("CONCAT('') as week_of_program"),
            DB::raw("CONCAT(b.amount,' ','GBP') as amount"),
            DB::raw('(CASE WHEN b.is_confirmed = "1" THEN "Confirmed" WHEN b.is_confirmed = "2" THEN "Pending"
            ELSE "Not Confirmed" END) AS is_confirmed'),
            "u.user_name",
            DB::raw("CONCAT(DATE_FORMAT(b.booking_date, '%a, %b %d, %Y '),b.start_time , '-',b.end_time) as time"),
            DB::raw("DATE_FORMAT(b.payout_month, '%d %b, %Y') as payout_month"),
            'b.unique_id',
            'b.week_id',
            'b.year',
            'b.created_at'
        )
            ->join('users as u','u.id','=','b.client_id')
            ->join('services as s', 's.id', '=', 'b.service_id')
            ->join('final_payments as fp', 'fp.unique_id', '=', 'b.unique_id')
            ->where('fp.status', '=',1)
            ->union($clientWeekPlan);
        if ($params['action_freelance'] == 'pending') {
            $bookings->addSelect(DB::raw("CONCAT('Fund') as status"));
            $bookings->where("b.is_confirmed", "<>", 1);
            $bookings->where("b.is_paid_to_client", "=", 0);
        } elseif ($params['action_freelance'] == 'confirmed') {
            $bookings->addSelect(DB::raw("CONCAT('Earned') as status"));
            $bookings->where("b.is_confirmed", "=", 1);
            $bookings->where("b.is_paid_to_client", "=", 0);
        } elseif ($params['action_freelance'] == 'payouts') {
            $bookings->addSelect(DB::raw("CONCAT('Paid out') as status"));
            $bookings->where("b.is_confirmed", "=", 1);
            $bookings->where("b.is_paid_to_client", "=", 1);
        }
        if (!empty($params['search'])) {
            $search = '%' . $params['search'] . '%';
            $bookings->where('user_name', 'like', $search);
        }
        if (!empty($params['dropDownFilters'])) {
            $alias = 'b';
            foreach ($params['dropDownFilters'] as $filterKey => $filter) {
                if (!empty($filterKey) && $filter != null) {
                    $bookings->where($alias . '.' . $filterKey, '=', $filter);
                }
            }
        }
        $bookings->orderBy('year')->orderBy('week_id')->orderBy('created_at');
        $grid = [];
        $grid['query'] = $bookings;
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
            'service_id' => [
                'name' => 'service_id',
                'isDisplay' => true
            ],
            'week_of_year' => [
                'name' => 'week_of_year',
                'isDisplay' => true
            ],
            'week_of_program' => [
                'name' => 'week_of_program',
                'isDisplay' => true
            ],
            'time' => [
                'name' => 'time',
                'isDisplay' => true
            ],
            'earning' => [
                'name' => 'amount',
                'isDisplay' => true
            ],

            'is_confirmed' => [
                'name' => 'is_confirmed',
                'isDisplay' => true
            ],
            'status' => [
                'name' => 'status',
                'isDisplay' => true
            ]
        ];
        if ($action === 'confirmed' || $action === 'payouts') {
            $arrFields = $arrFields + ['payout_month' => ['name' => 'payout_month', 'isDisplay' => true]];
        }
        $arrFields = $arrFields + ['name' => ['name' => 'user_name', 'isDisplay' => true]];
        $arrFields = $arrFields + ['booking_form' => ['name' => 'booking_form', 'isDisplay' => true]];

        return $arrFields;
    }

    /**
     * this is used to auto calculate payouts
     * @param $params
     * @return array
     */
    public static function autoPayoutCoachEarnings($currentMonth,$currentYear,$coachId)
    {
        $currentDate = currentDateTime();
        $clientWeekPlan = DB::table("client_week_plans as cwp")
            ->select('cwp.id'
            )
            ->where("cwp.is_confirmed", "=", 1)
            ->where("cwp.is_paid_to_client", "=", 0)
            ->where("cwp.client_id", "=", $coachId)
            ->whereDate('cwp.payout_date','<=',$currentDate);
//            ->Where(function ($query)use($currentMonth,$currentYear) {
//                $query->whereMonth('cwp.payout_month','<=',$currentMonth)
//                    ->orWhereYear('cwp.payout_month','<',$currentYear);
//            });
        $weekTableSum = $clientWeekPlan->sum('cwp.amount');
        $clientWeekPlan->groupBy('cwp.id');
        $weekPlanIds = $clientWeekPlan->get()->toArray();
        $bookings = DB::table("bookings as b")
            ->select('b.id'
            )
            ->where("b.is_confirmed", "=", 1)
            ->where("b.is_paid_to_client", "=", 0)
            ->where("b.client_id", "=", $coachId)
            ->whereDate('b.payout_date','<=',$currentDate);
//            ->Where(function ($query)use($currentMonth,$currentYear) {
//                $query->whereMonth('b.payout_month','<=',$currentMonth)
//                    ->orWhereYear('b.payout_month','<',$currentYear);
//            });
        $bookingTableSum = $bookings->sum('b.amount');
        $bookings->groupBy('b.id');
        $bookingIds = $bookings->get()->toArray();

        $arr['client_week_plan'] = $weekPlanIds;
        $arr['bookings'] = $bookingIds;
        $arr['amount'] = ($weekTableSum + $bookingTableSum);

        return $arr;
    }

    public static function updateTransferAmountStatus($weekPlanIds,$bookingIds,$transferAmount,$coachId,$currentDate,$newDate,$user)
    {
        $date = strtotime(currentDateTime());
        $newDate = date("Y-m-d", strtotime("-1 month", $date));
        try {
            DB::beginTransaction();
            DB::table("client_week_plans as cwp")
                ->whereIn('cwp.id', $weekPlanIds)
                ->update(['cwp.is_paid_to_client' => 1]);
            DB::table("bookings as b")
                ->whereIn('b.id', $bookingIds)
                ->update(['b.is_paid_to_client' => 1]);
            DB::table("confirmed_amounts as ca")
                ->whereIn('ca.client_week_plan_id', $weekPlanIds)
                ->update(['ca.is_paid_to_client' => 1]);
            DB::table("confirmed_amounts as ca")
                ->whereIn('ca.booking_id', $bookingIds)
                ->update(['ca.is_paid_to_client' => 1]);
            $bankAcountNumber = BankAcconut::where('user_id', $coachId)->first();
            $transferAmount = roundValue($transferAmount,2);
            $tAmount = ($transferAmount * 100);
            $stripe = new \Stripe\StripeClient(
                getenv('STRIPE_KEY')
            );
            $objTransfer = $stripe->transfers->create([
                'amount' => $tAmount,     // transfer amount be multiple by 100
                'currency' => 'gbp',
                'destination' => $user->s_a_id,
                'transfer_group' => 'Payouts for services',
                'description' => 'Payment from Zestlog',
            ]);
            $weekPlanIds = implode(',',$weekPlanIds);
            $bookingIds = implode(',',$bookingIds);
            PayoutHistory::insert([
                'client_id' => $coachId,
                'date_of_transfer' => $currentDate,
                'amount' => $transferAmount,
                'transfer_to' => $bankAcountNumber->account_number,
                'earning_month' => $newDate,
                'transfer_id' => $objTransfer->id,
                'destination_id' => $objTransfer->destination,
                'currency' => $objTransfer->currency,
                'object' => $objTransfer,
                'week_plan_id' => $weekPlanIds,
                'booking_id' => $bookingIds,
                'created_at' => currentDateTime(),
                'updated_at' => currentDateTime(),
            ]);
            DB::commit();
        } catch (\Stripe\Exception\CardException $e) {
            DB::rollback();
            dd($e->getError()->message);
        } catch (\Stripe\Exception\RateLimitException $e) {
            DB::rollback();
            dd($e->getError()->message);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            DB::rollback();
            dd($e->getError()->message);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            DB::rollback();
            dd($e->getError()->message);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            DB::rollback();
            dd($e->getError()->message);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            DB::rollback(); // need to remove before add crone job
            dd($e->getError()->message);
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getError()->message); // need to remove before add crone job
        }

     return true;
    }

}
