<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BankAcconut;
use App\Models\ChannelActivation;
use App\Models\ClientCurrency;
use App\Models\ClientSelectedEquipment;
use App\Models\Day;
use App\Models\Equipment;
use App\Models\FinalPayment;
use App\Models\Log;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Models\Specialization;
use App\Models\UserIdentity;
use DateTime;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use PragmaRX\Countries\Package\Countries;
use function GuzzleHttp\Promise\all;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Traits\ZestLogTrait;
use Stripe;
class AccountController extends Controller
{
    use ZestLogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * this is used to get Freelance specialist profile data
     * @param $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $userId = loginId();
        $earning = [];
        $user = User::find($userId);
        $serviceBookingObj = ServiceBooking::select('fp.total_price', 'fp.status', 'service_bookings.created_at', 'service_bookings.starting_date', 'week_id', 'wp.meta_data as weeks', 'fp.unique_id')
            ->where('service_bookings.client_id', $userId)
            ->join('final_payments as fp', 'fp.unique_id', 'service_bookings.unique_id')
            ->join('week_programs as wp', 'wp.id', 'service_bookings.week_id')
            ->groupBy('service_bookings.unique_id')
            ->where(['fp.status' => 1])
            ->get()->toArray();
        $dt = new DateTime();
        $currentDate = $dt->format('Y/m/d');
        if (!empty($serviceBookingObj)) {
            foreach ($serviceBookingObj as $key => $row) {
                if (!empty($row['weeks'])) {
                    $createdDate = new DateTime($row['created_at']);
                    $dt = new DateTime($row['starting_date']);
                    $date = $dt->format('Y/m/d');
                    $incremetWeek = '+' . $row['weeks'];
                    $programEndDate = date('Y/m/d', strtotime($incremetWeek . ' week', strtotime($date)));
                    $earning[$key] = $row;
                    if (strtotime($programEndDate) > strtotime($currentDate)) {
                        $earning[$key]['status'] = 'Pending';
                    } else {
                        $earning[$key]['status'] = 'Earned';
                    }
                    $earning[$key]['created_at'] = $createdDate->format('Y/m/d');
                    $earning[$key]['program_type'] = 'Booking';
                }
            }
        }
        $age = $user->getAgeAttribute();
        $channelActivations = ChannelActivation::select('specialization_id', 'specialization_number', 'education_certificate', 's.name as specialization_name',
            'education_title', 'education_from', 'education_certificate', 'introduction', 'is_verify')
            ->join('specializations as s', 's.id', '=', 'channel_activations.specialization_id')
            ->where('user_id', $userId)
            ->get()->toArray();
        $specializations = ['' => 'Select'] + Specialization::pluck('name', 'id')->toArray();
        $channelActivations = array_column($channelActivations, null, 'specialization_number');
        $identityDetail = UserIdentity::select('id_photo', 'first_name', 'middle_name', 'last_name', 'birthday', 'is_identity_verified')
            ->where('user_id', $userId)
            ->first();
        if ($user) {
            $user = $user->toArray();
            if (!empty($age) && $age < 500) {
                $user['age'] = $age;
            } else {
                $user['age'] = 0;
            }
            $countryName = null;
            $bankAccountDetails = BankAcconut::where('user_id', $userId)->first();
            if (!empty($bankAccountDetails)) {
                $c = new Countries();
                $countries = $c->all();
                $countryName = $countries[$bankAccountDetails->country]->name->common;
            }
            return view('client.account.freelance-profile-edit', compact('user', 'bankAccountDetails', 'identityDetail', 'specializations', 'channelActivations', 'earning','countryName'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->editProfiles($id, clientImagePath);
        $user = $data[0];
        $countries = $data[1];
        $cities = $data[2];
        $rout = 'account.update';
        return view('client.account.edit', compact('user', 'countries', 'cities', 'rout'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->updateProfiles($request, $id, clientImagePath);
        return redirect()->route('account.edit', $id);
    }

    /**
     * This is used to get city by country
     *
     * @param Request $request
     * @return array
     */
    public function getCityByCountry(Request $request)
    {
        $res = [
            'code' => '',
            'msg' => ''
        ];
        try {
            $cca3 = $request['cca3'];
            $c = new Countries();
            $cities = $c->where('cca3', $cca3)
                ->first()
                ->hydrate('cities')
                ->cities->toArray();
            $cities = array_values($cities);
            $cityList = array();
            foreach ($cities as $city) {
                array_push($cityList, array('code' => $city['name'], 'city' => $city['name']));
            }
            if (count($cityList) > 0) {
                $res['cityList'] = $cityList;
                $res['msg'] = "City found!";
                $res['code'] = 200;
            } else {
                $res['msg'] = "No city found!";
                $res['code'] = 404;
            }
        } catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = $e->getCode();

        }

        return $res;

    }

    /**
     * this is used to bank account information
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bankInformation(Request $request)
    {

        $userId = loginId();
        $accountHolder = $request->input('account_holder');
        $accountNumber = $request->input('account_number');
        $BicCode = $request->input('bic_code');
        $Swift = $request->input('swift');
        $accountName = $request->input('account_name');

        $obj = BankAcconut::find($userId);
        if (empty($obj)) {
            $obj = new BankAcconut();
            $obj->user_id = $userId;
        }
        $obj->bank_holder = $accountHolder;
        $obj->account_number = $accountNumber;
        $obj->bic_code = $BicCode;
        $obj->swift = $Swift;
        $obj->bank_name = $accountName;
        $obj->save();
        $this->success = true;

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * This is used to show accept or reject popup
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */


    public function userBookingInformations(Request $request)
    {
        $clientId = \Auth::user()->id;
        $uniqueId = $request->input('id');
        $userId = 0;
        $data['key_pairs'] = FinalPayment::select('u.id as user_id', 's.key_pair as key_pair', 's.id as service_id', 'final_payments.unique_id')
            ->where('final_payments.unique_id', '=', $request->input('id'))
            ->join('users as u', 'u.id', '=', 'final_payments.user_id')
            ->join('service_bookings as sb', 'sb.user_id', '=', 'final_payments.user_id')
            ->join('services as s', 's.id', 'sb.service_id')
            ->get()->toArray();
        if (isset($data['key_pairs'][0])) {
            $userId = $data['key_pairs'][0]['user_id'];
            if (!empty($data['key_pairs'])) {
                $data['unique_id'] = $uniqueId;
                $data['personalInformation'] = User::select('users.first_name', 'users.last_name', 'users.gender', 'users.bmi', 'users.waist', 'users.more_info', 'users.additional_details', 'users.birthday', 'ta.name as training_age', 'g.name as goal')
                    ->where('users.id', $userId)
                    ->leftjoin('goals as g', 'g.id', 'users.goal_id')
                    ->leftjoin('training_ages as ta', 'ta.id', 'users.training_age_id')
                    ->first();
                $obj = User::where('id', $userId)->first();
                $age = $obj->getAgeAttribute();
                $data['age'] = $age;
            }
            if (!empty($data['key_pairs'])) {
                $services = array_column(Service::get()->toArray(), null, 'id');
                $record = array_column($data['key_pairs'], null, 'service_id');
                $data['bookingDuration'] = ServiceBooking::select('tp.name as training_plan', 'w.name as week', 'service_bookings.days_id',
                    'tp.id as training_plan_id', 'tp.days_value', 'w.id as week_id', 'w.name as week_name', 'sl.value as session_length',
                    'service_bookings.service_id', 'service_bookings.training_session_location', 'cp.name as change_training_plan', 'service_bookings.starting_date')
                    ->where('user_id', $userId)
                    ->where('client_id', $clientId)
                    ->where('unique_id', $request->input('id'))
                    ->join('training_plans as tp', 'tp.id', 'service_bookings.training_plan_id')
                    ->join('week_programs as w', 'w.id', 'service_bookings.week_id')
                    ->leftjoin('training_coaching_session_lengths as sl', 'sl.id', 'service_bookings.session_length')
                    ->leftjoin('change_training_plans as cp', 'cp.id', 'service_bookings.change_training_plan_id')
                    ->orderby('service_id')
                    ->get()->toArray();
                foreach ($data['bookingDuration'] as $row) {
                    if (!empty($row['days_id'])) {
                        $days = explode(',', $row['days_id']);
                        sort($days);
                        foreach ($days as $dayId) {
                            $data['days'][$dayId] = Day::where('id', $dayId)
                                ->pluck('name')
                                ->first();
                        }
                    }
                }
                $index = array_keys(array_column($data['bookingDuration'], null, 'service_id'));
                foreach ($data['bookingDuration'] as $key => $row) {
                    if (!empty($record[$row['service_id']])) {
                        $data['bookingDuration'][$key]['user_id'] = $record[$row['service_id']]['user_id'];
                        $data['bookingDuration'][$key]['key_pair'] = $record[$row['service_id']]['key_pair'];
                        $weekValue = explode('-', $row['week_name'])[0];
                        $data['bookingDuration'][$key]['total_sessions'] = getTotalSessions($weekValue, $row['days_value']);
                    } else if (!empty($services[$row['service_id']])) {
                        $data['bookingDuration'][$key]['key_pair'] = $services[$row['service_id']]['key_pair'];
                        $weekValue = explode('-', $row['week_name'])[0];
                        $data['bookingDuration'][$key]['total_sessions'] = getTotalSessions($weekValue, $row['days_value']);
                    }
                }
                $value = 0;
                $clientAmount = FinalPayment::select('client_f_amount')->where('unique_id', $uniqueId)->first();
                if (!empty($clientAmount)) {
                    $value = $clientAmount->client_f_amount;
                }
                $data['finalPrice'] = roundValue($value, 2);
                $currencyObj = ClientCurrency::select('c.code')
                    ->where('client_id', $clientId)
                    ->join('currencies as c', 'c.id', '=', 'client_currencies.currency_id')
                    ->first();
                $currency = 'GBP';
                if (!empty($currencyObj)) {
                    $currency = $currencyObj->code;
                }
                $data['currency'] = $currency;
            }

        }
        $equipments = ClientSelectedEquipment::select('equipment_id')
            ->where('client_id', $clientId)
            ->where('unique_id', $uniqueId)
            ->first();
        $equipmentIds = [];
        if (!empty($equipments)) {
            $equipments = $equipments->toArray();
            $equipmentIds = explode(',', $equipments['equipment_id']);
        }
        $arrEquipemntsName = [];
        $countEquipments = Equipment::count();
        if ($countEquipments != count($equipmentIds)) {
            if (!empty($equipmentIds)) {
                foreach ($equipmentIds as $row) {
                    $arrEquipemntsName[] = Equipment::find($row)->name;
                }
            }
        } else {
            $arrEquipemntsName[] = 'Almost all (I have access to a gym)';
        }

        $view = view('client.account.partials._booking-information', compact('data','arrEquipemntsName'))->render();

        return response()->json(['success' => true, 'message' => '', 'view' => $view]);
    }

    public function createConnectAccount(Request $request)
    {
        exit;
        $stripe = Stripe\Stripe::setApiKey(getenv('STRIPE_KEY'));
        ini_set('max_execution_time', '0');
//        \Stripe\Stripe::setApiKey('sk_test_51HrGK2K5gIoAxl14lsafi4GxqaHvXBbrT5FHrk0Ep1K9JIoA4gWxkCwR2lcyxT6AvaxIvcLSl1l0xYamFoj2J4mT00pRnaQ4EF');
//        \Stripe\Stripe::setApiKey('sk_test_51HsLGTEK4cpWZi1hCRkOfsxT5BsbUGtSliyVcVucUR1bXKoj3v0IYw5X4IuYoWmT9ZwbpmLaFQDUegZZ6166KPyO00GbtapHoT');
//        $user = \Stripe\Account::create(array(
//            "type" => "custom",
//            "country" => "GB",
//            "email" => 'rayyan@zestlog.com',
//            "business_type" => "individual",
//            "individual" => [
//                'first_name' => 'waqar',
//                'last_name' => 'khalid',
//                'phone' => '+44 1717 111222',
//                'email' => 'ari@gmail.com',
//                'dob' => array(
//                    'day' => 01,
//                    'month' => 12,
//                    'year' => 1950
//                ),
//                'address' => array(
//                    'line1' => "1 Main St",
//                    'line2' => "Suite 111",
//                    'city' => "Liverpool",
//                    'state' => "North West, England",
//                    'country' => "GB",
//                    'postal_code' => "PO16 7GZ"
//                ),
//            ],
//            "tos_acceptance" => array(
//                'date' => time(),
//                "ip" => $_SERVER['REMOTE_ADDR']
//            ),
//            'capabilities' => [
//                'card_payments' => [
//                    'requested' => true,
//                ],
//                'transfers' => [
//                    'requested' => true,
//                ],
//            ],
//            'business_profile' => [
//                'mcc' => '8011',
//                'url' => 'www.zestlog.com'
//            ],
//            'bank_account' => [
//                'country' => 'GB',
//                'currency' => 'gbp',
//                'account_holder_name' => 'aaaaa',
//                'account_holder_type' => 'individual',
//                'account_number' => '00012345',
//                'routing_number'=> '108800'
//            ],
//        ));
//        $token_id = $user->id;
//        $fileId = \Stripe\File::create([
//            'purpose' => 'identity_document',
//            'file' => fopen('F:\Xammp\htdocs\web-app\public\user\profile\15930713673013272415ef45707e05a8.jpg', 'r'),
//        ], [
//            'stripe_account' => $token_id,
//        ]);
//        $fileId2 = \Stripe\File::create([
//            'purpose' => 'identity_document',
//            'file' => fopen('F:\Xammp\htdocs\web-app\public\user\profile\15930713673013272415ef45707e05a8.jpg', 'r'),
//        ], [
//            'stripe_account' => $token_id,
//        ]);
        $account = \Stripe\Account::retrieve('acct_1I14n12clX84LNg3');
        $account->settings['payouts']['schedule']['interval'] = 'manual';
        $obj = $account->save();
    }

    public function transferAmount(Request $request)
    {
//        $stripe = Stripe\Stripe::setApiKey(getenv('STRIPE_KEY'));

         exit;
//        $account = \Stripe\Account::retrieve($user->s_a_id);
//
//        $account->delete();

//        $payout = \Stripe\Payout::create([
//            'amount' => 100,
//            'currency' => 'gbp',
//            'method' => 'instant',
//        ], [
//            'stripe_account' => 'acct_1I1CBB2eqqMvkcHK',
//        ]);
//

//        $obj = $stripe->transfers->create([
//            'amount' => 100,
//            'currency' => 'gbp',
//            'destination' => 'acct_1I1CBB2eqqMvkcHK',
//            'transfer_group' => 'test transfer',
//        ]);

    }
    /**
     * This is used to update partners score
     */
    public function updateClientScore()
    {
        $currentdate = new \DateTime();
        $currentdate =  $currentdate->modify('-30 minutes');
        $userObj = User::select('id', 'is_3i_partner', 'is_education_verified', 'is_identity_verified', 'total_bookings', 'total_rejected_bookings',
            \DB::raw("TIMESTAMPDIFF(Day, DATE(users.created_at), current_date) AS total_days"),
            \DB::raw("TIMESTAMPDIFF(Day, DATE(users.last_log_created_at), current_date) AS latest_log_days")
        )
            ->where('user_type', 0)
            ->where('id',4)
//            ->where('updated_at','>=', $currentdate)
            ->get()->toArray();
        $arr = [];
        foreach ($userObj as $key => $row) {
            $is3iPartnerFactor = 0;
            $isEducationVerifiedFactor = 0;
            $isIdentityVerifiedFactor = 0;
            $activeDaysFactor = 0;
            $rejectBookingsFactor = 0;
            if ($row['is_3i_partner'] == 1) {
                $is3iPartnerFactor = 1;
            }
            if ($row['is_education_verified'] == 1) {
                $isEducationVerifiedFactor = 1;
            }
            if ($row['is_identity_verified'] == 1) {
                $isIdentityVerifiedFactor = 1;
            }
            if ($row['latest_log_days'] === 0) {
                $row['latest_log_days'] = 1;
            }
            if ($row['total_days'] === 0) {
                $row['total_days'] = 1;
            }

            if (!empty($row['latest_log_days'])) {
                $activeDaysFactor = round(($row['latest_log_days'] / $row['total_days']), 3);
            }
            if (!empty($row['total_bookings']) && !empty($row['total_rejected_bookings'])) {
                $rejectBookingsFactor = ($row['total_rejected_bookings'] / $row['total_bookings']);
            }

            $totalAcceptedBookings = $row['total_bookings'] - $row['total_rejected_bookings'];
            $totalBookingsFactor = $this->bookingsFactorConditions($totalAcceptedBookings);

            if(isLightVersion()){
                $is3iPartnerFactor = ($is3iPartnerFactor * 0);
                $isEducationVerifiedFactor = ($isEducationVerifiedFactor * 0.30);
                $isIdentityVerifiedFactor = ($isIdentityVerifiedFactor * 0.10);
                $activeDaysFactor = ($activeDaysFactor * 0);
                $totalBookingsFactor = ($totalBookingsFactor * 0.60);

                $rejectBookingsFactor = ($rejectBookingsFactor * 0); // to decrease upto 50 %, will change later
            }else{
                $is3iPartnerFactor = ($is3iPartnerFactor * 0.40);
                $isEducationVerifiedFactor = ($isEducationVerifiedFactor * 0.15);
                $isIdentityVerifiedFactor = ($isIdentityVerifiedFactor * 0.1);
                $activeDaysFactor = ($activeDaysFactor * 0);
                $totalBookingsFactor = ($totalBookingsFactor * 0.35);

                $rejectBookingsFactor = ($rejectBookingsFactor * 0.5); // to decrease upto 50 %, will change later
            }



            $totalScore = ($is3iPartnerFactor + $isEducationVerifiedFactor + $isIdentityVerifiedFactor + $activeDaysFactor + $totalBookingsFactor);
            $totalScore = ($totalScore - $rejectBookingsFactor);
            $arr[$key]['id'] = $row['id'];
            $arr[$key]['coach_score'] = $totalScore;

            echo 'is 1ipartner ='.$row['is_3i_partner'].'<br>';
            echo 'total days signup ='.$row['total_days'].'<br>';
            echo 'days with one log ='.$row['latest_log_days'].'<br>';
            echo 'total Received Bookings ='.$row['total_bookings'].'<br>';
            echo 'total accepted Bookings ='.$totalAcceptedBookings.'<br>';
            echo 'total Rejected Bookings ='.$row['total_rejected_bookings'].'<br>';
            echo 'education verified ='.$row['is_education_verified'].'<br>';
            echo 'identity verified ='.$row['is_identity_verified'].'<br>';

            echo 'total Bookings ='.$row['total_bookings'].'<br><br><br>';




            echo '1iPartnerFactor ='.$is3iPartnerFactor.'<br>';
            echo 'active Days Factor ='.$activeDaysFactor.'<br>';
            echo 'total Bookings Factor ='.$totalBookingsFactor.'<br>';

            echo 'Education Verified Factor ='.$isEducationVerifiedFactor.'<br>';
            echo 'isIdentity Verified Factor ='.$isIdentityVerifiedFactor.'<br>';
            echo 'reject Bookings Factor ='.$rejectBookingsFactor.'<br>';

            echo '<Strong>'.'total Score ='.$totalScore.'</strong>'.'<br>';
            exit();

        }
//        $userInstance = new User;
//        \Batch::update($userInstance, $arr, 'id');


        }

    public function updateBookings()
    {
        $userObj = User::where('user_type', 0)
            ->get();
        foreach ($userObj as $key => $obj) {
            $objPayment = FinalPayment::where('client_id', $obj->id)
                ->where('is_payment', '<>', 0)
                ->count();
            User::where('id', $obj->id)->update(['total_bookings' => $objPayment]);

            $objreject = FinalPayment::where('client_id', $obj->id)
                ->where('is_payment', '=', 2)
                ->count();
            User::where('id', $obj->id)->update(['total_rejected_bookings' => $objreject]);
        }

        dd(44);
    }

}
