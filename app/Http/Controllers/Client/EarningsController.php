<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BankAcconut;
use App\Models\Booking;
use App\Models\Client\ClientWeekPlan;
use App\Models\PayoutHistory;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class EarningsController extends Controller
{
    /**
     * index function to display earnings
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $emptySelect[''] = 'All';
        $services = $emptySelect + Service::pluck('name', 'id')->toArray();
        if (empty(isHide()))
            unset($services[2]);

        return view('earnings', compact('services'));
    }

    /**
     * this is sued to get coaches Earnings
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCoachFunds(Request $request)
    {
        $actionFreelance = $request->input('action_freelance');
        $this->params = [
            'perPage' => 10,
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'sortColumn' => $request->input('sortColumn'),
            'sortType' => $request->input('sortType'),
            'dropDownFilters' => $request->input('dropDownFilters'),
            'action_freelance' => $request->input('action_freelance'),
        ];
        if ($actionFreelance == 'history') {
            $data = PayoutHistory::getPayoutHistory($this->params);
        } else {
            $data = ClientWeekPlan::getCoachFunds($this->params);
        }

        return response()->json($data);
    }

    public function testClientEarning(Request $request)
    {

        dd(55);
        $currentDate = currentDateTime();
        $currentMonth =date('m',strtotime($currentDate));
        $currentYear = date('Y',strtotime($currentDate));
        $coachId = loginId();

        $dataAmount = ClientWeekPlan::autoPayoutCoachEarnings($currentMonth,$currentYear,$coachId);

        $data = ClientWeekPlan::updateTransferAmountStatus($currentMonth,$currentYear,$coachId);

    }

    public function getCoachReceipt(Request $request, $id)
    {
        $coachId = loginId();
        $payOut = $id;
        $arr = [];
        $bankObj = BankAcconut::select('bank_holder', 'account_number', 'bic_code')
            ->where('user_id', $coachId)
            ->first();

        $payOutHistoryObj = PayoutHistory::select('transfer_id', 'created_at', 'earning_month', 'amount', 'week_plan_id', 'booking_id')
            ->where('id', $payOut)
            ->first();
        $weekPlanIdsArr = [];
        $bookingIdsArr = [];
        if (!empty($payOutHistoryObj)) {
            $payOutHistoryObj = $payOutHistoryObj->toArray();
            $weekPlanIds = $payOutHistoryObj['week_plan_id'];
            $bookingIds = $payOutHistoryObj['booking_id'];
            if (!empty($weekPlanIds)) {
                $weekPlanIdsArr = explode(',', $weekPlanIds);
            }
            if (!empty($bookingIds)) {
                $bookingIdsArr = explode(',', $bookingIds);
            }
        }

        $clientWeekPlan = DB::table("client_week_plans as cwp")->select("cwp.id", "s.name as service_id",
            "cwp.week_id",
            "cwp.week_count as week_of_program",
            DB::raw("CONCAT(cwp.amount,' ','GBP') as amount"),
            'u.user_name',
            DB::raw("CONCAT(' ') as time"),
            DB::raw("DATE_FORMAT(cwp.payout_month, '%b, %Y') as payout_month"),
            'cwp.reference_number'
        )
            ->join('users as u', 'u.id', '=', 'cwp.user_id')
            ->join('services as s', 's.id', '=', 'cwp.service_id')
            ->whereIn("cwp.id", $weekPlanIdsArr);
        $bookings = DB::table("bookings as b")->select("b.id", "s.name as service_id",
            DB::raw("CONCAT('') as week_of_year"),
            DB::raw("CONCAT('') as week_of_program"),
            DB::raw("CONCAT(b.amount,' ','GBP') as amount"),
            "u.user_name",
            DB::raw("CONCAT(DATE_FORMAT(b.booking_date, '%b %d, %Y '),b.start_time , '-',b.end_time) as time"),
            DB::raw("DATE_FORMAT(b.payout_month, '%b, %Y') as payout_month"),
            'b.reference_number'
        )
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->join('services as s', 's.id', '=', 'b.service_id')
            ->whereIn("b.id", $bookingIdsArr)
            ->union($clientWeekPlan)
            ->get()->toArray();
        $bookingsData = (array)($bookings);
        $pdf = PDF::loadView('receipt', compact('bankObj', 'payOutHistoryObj', 'bookingsData'));
        $receiptName = $payOutHistoryObj['earning_month'].'.pdf';
        return $pdf->download($receiptName);
//        $html =  view('receipt', compact('bankObj','payOutHistoryObj','bookingsData'))->render();
    }
    public function getPdfReceipt(Request $request){
//        $pdf = PDF::loadView('receipt');
//        $receiptName = generateRandomString(9).'.pdf';
//        return $pdf->download($receiptName);
    }
}
