<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Traits\ZestLogTrait;

use App\Models\Specialization;
use PragmaRX\Countries\Package\Countries;
class FreelancespecialistsController extends Controller
{
     use ZestLogTrait;
    /**
     * This is used to get freelance listing
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    use ZestLogTrait;

    /**
     * Display Freelance Specialist Users
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $specializations = ['' => 'Select'] + Specialization::pluck('name', 'id')->toArray();
        $c = new Countries();
        $allCountries = $c->all();
        $countries = [
            '' => 'Select'
        ];
        foreach ($allCountries as $country) {
            $countries[$country->cca3] = $country->name->common;
        }
        $cities = ['' => 'Select'];

        return view('admin.freelance.index', compact('specializations', 'countries','cities'));
    }
    /*
     * Get Freelance Users Data from Ajax Call
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFreelanceUserData(Request $request)
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
            'lastLogin'=>$request->input('lastLogin')
        ];
        $c = new Countries();
        $data = User::getFreelanceUsersData($this->params);
        if (!empty($data['result'])) {
            foreach ($data['result'] as $key => $row) {
                $country = $city = '';
                if (!empty($row->country)) {
                    $objCountry = $allCountries = $c->where('cca3', '=', $row->country)->first();
                    if (!empty($objCountry) && isset($objCountry->admin)) {
                        $country = $objCountry->admin;
                    }
                }
                $data['result'][$key]->country = $allCountries = $country;
            }
        }

        return response()->json($data);
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

}
