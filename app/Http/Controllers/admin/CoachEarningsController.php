<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BankAcconut;
use App\Models\Client\ClientWeekPlan;
use App\Models\PayoutHistory;
use App\Models\Service;
use App\User;
use BankAccount;
use Illuminate\Http\Request;

class CoachEarningsController extends Controller
{
    public function index()
    {
        \Stripe\Stripe::setApiKey(getenv('STRIPE_KEY'));
        $balance = \Stripe\Balance::retrieve();
        $currency = ($balance->available[0]->currency);
        $balance = ($balance->available[0]->amount)/100;
        $emptySelect[''] = 'All';
        $services = $emptySelect + Service::pluck('name', 'id')->toArray();
        if (empty(isHide()))
            unset($services[2]);
        return view('admin.earnings', compact('services','balance','currency'));
    }
    public function getCoachFunds(Request $request)
    {
        $currentDate = currentDateTime();
        $currentMonth =date('m',strtotime($currentDate));
        $currentYear = date('Y',strtotime($currentDate));
        $actionFreelance = $request->input('action_freelance');
        $this->params = [
            'perPage' => 10,
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'coach_search' => $request->input('coach_search'),
            'sortColumn' => $request->input('sortColumn'),
            'sortType' => $request->input('sortType'),
            'dropDownFilters' => $request->input('dropDownFilters'),
            'action_freelance' => $request->input('action_freelance'),
        ];

        if ($actionFreelance == 'history') {
            $data = PayoutHistory::getPayDetails($this->params,$currentMonth,$currentYear);
        } else {
            $data = ClientWeekPlan::adminCoachFunds($this->params);
        }
        return response()->json($data);
    }
    public function coachPay(Request $request){
        $coachId = $request->input('coach_id');
        $user = User::find($coachId);
        if (!empty($user->s_a_id)) {
            $currentDate = currentDateTime();
            $currentMonth = date('m', strtotime($currentDate));
            $currentYear = date('Y', strtotime($currentDate));
            $data = ClientWeekPlan::autoPayoutCoachEarnings($currentMonth, $currentYear, $coachId);
            $weekPlanIds = [];
            $bookingIds = [];
            $transferAmount = 0;
            if (!empty($data['client_week_plan'])) {
                $weekPlanIds = array_column($data['client_week_plan'], 'id', null);
            }
            if (!empty($data['bookings'])) {
                $bookingIds = array_column($data['bookings'], 'id', null);
            }
            if (!empty($data['amount'])) {
                $transferAmount = $data['amount'];
            }
            $data = ClientWeekPlan::updateTransferAmountStatus($weekPlanIds, $bookingIds, $transferAmount, $coachId, $currentDate, $currentDate, $user);
        }

        \Stripe\Stripe::setApiKey(getenv('STRIPE_KEY'));
        $balance = \Stripe\Balance::retrieve();
        $balance = ($balance->available[0]->amount)/100;
        return response()->json($balance);
    }

}
