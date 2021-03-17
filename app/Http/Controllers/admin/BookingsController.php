<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AgeCategory;
use App\Models\Booking;
use App\Models\TrainingAge;
use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;

class BookingsController extends Controller
{
    public function index()
    {

        $age = ['' => 'Select'] + AgeCategory::pluck('name', 'id')->toArray();
        $c = new Countries();
        $allCountries = $c->all();
        $countries = [
            '' => 'Select'
        ];
        foreach ($allCountries as $country) {
            $countries[$country->cca3] = $country->name->common;
        }
        $cities = ['' => 'Select'];

        $gender = [
            '' => 'Select',
            'male' => 'Male',
            'female' => 'Female',
        ];

        return view('admin.bookings.index', compact( 'countries','cities','age','gender'));
    }
    public function getActiveUserData(Request $request)
    {
        $this->params = [
            'perPage' => 100,
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'sortColumn' => $request->input('sortColumn'),
            'sortType' => $request->input('sortType'),
            'dropDownFilters' => $request->input('dropDownFilters'),
            'action_freelance' => $request->input('action_freelance'),
            'accountRegDate'=>$request->input('accountRegDate'),
            'bmi'=>$request->input('bmi'),
            'userName'=>$request->input('userName'),
            'partner'=>$request->input('partner'),
            'bookingSubmission'=>$request->input('bookingSubmission'),

        ];
        $data = Booking::getPartnerBookings($this->params);
        return response()->json($data);
    }
}
