<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AgeCategory;
use App\User;
use Illuminate\Http\Request;
use App\Traits\ZestLogTrait;
use Carbon\Carbon;
use App\Models\Goal;
use PragmaRX\Countries\Package\Countries;
class EndUsersController extends Controller
{
    use ZestLogTrait;

    /**
     * This is used to show end users data
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->data['total_users'] = User::where('user_type', '!=', '1')->where('is_verify', '=', 1)->count();
        $this->data['signup_yesterday'] = User::where('user_type', '!=', '1')->where('is_verify', '=', 1)->whereDate('created_at', '>=', Carbon::now()->subdays(1))->count();
        $this->data['signup_last_week'] = User::where('user_type', '!=', '1')->where('is_verify', '=', 1)->whereDate('created_at', '>=', Carbon::today()->subDays(7))->count();
        $this->data['signup_last_month'] = User::where('user_type', '!=', '1')->where('is_verify', '=', 1)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();
        $this->data['goals'] = ['' => 'Select'] + Goal::pluck('name', 'id')->toArray();
        $this->data['status'] = ['' => 'Select', '1' => 'Active', '2' => 'Deactive'];
        $countryList = User::select('country', 'country_id')
            ->where('user_type', 2)
            ->groupBy('country')
            ->get()->toArray();
        $age = ['' => 'All'] + AgeCategory::pluck('name', 'id')->toArray();
        $countryList = array_column($countryList, null, 'country_id');
        $countries = [
            '' => 'Select'
        ];
        foreach ($countryList as $key => $row) {
            $countries[$key] = $row['country'];
        }
        $cities = [
            '' => 'Select'
        ];
        $this->data['countries'] = $countries;
        $this->data['cities'] = $cities;
        $this->data['age'] = $age;

        return view('admin.endusers.index',$this->data);
    }

    /**
     * This is used to get end users data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserData(Request $request)
    {
        $this->params = [
            'perPage' => 100,
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'sortColumn' => $request->input('sortColumn'),
            'sortType' => $request->input('sortType'),
            'dropDownFilters' => $request->input('dropDownFilters'),
            'accountRegDate'=>$request->input('accountRegDate'),
            'lastLogin'=>$request->input('lastLogin'),
            'birthDay'=>$request->input('birthDay'),
            'bmi'=>$request->input('bmi'),
            'timeSpent'=>$request->input('timeSpent'),
            'searchUserName'=>$request->input('searchUserName'),
        ];
        $this->data = User::getEndUsersData($this->params);

        return response()->json($this->data);
    }
}
