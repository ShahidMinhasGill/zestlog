<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientPlan;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Self_;

class UpcomingProgramController extends Controller
{
    /**
     * @param Request $request
     */
    public function getUpcomingProgram(Request $request)
    {
        $route = $request->input('is_meeting_route');
        if ($route == 1) {
            self::getUpcomingMeeting($request);
            return response()->json($this->data);
        }
        $this->params = [
            'perPage' => 100,
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'sortColumn' => $request->input('sortColumn'),
            'sortType' => $request->input('sortType'),
            'dropDownFilters' => $request->input('dropDownFilters'),
            'week_of_program' => $request->input('week_of_program'),
            'is_publish' => $request->input('is_publish'),
            'service' => $request->input('is_service'),
            'repeat_program' => $request->input('repeat_program'),
            'week_of_year' => $request->input('week_of_year'),
        ];
        $this->data = ClientPlan::getUpcomingSessionsData($this->params); // used to get upcoming session data

        return response()->json($this->data);
    }

    /**
     * This is used To get upcoming Meetings
     * @param $request
     */
    public  function getUpcomingMeeting($request){
        $this->params = [
            'perPage' => 100,
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'sortColumn' => $request->input('sortColumn'),
            'sortType' => $request->input('sortType'),
            'dropDownFilters' => $request->input('dropDownFilters'),
            'service' => $request->input('meeting_service_id'),
            'schedule_date' => $request->input('schedule_date'),
            'search_user' => $request->input('search_user'),
        ];

        $this->data = ClientPlan::getUpcomingMeeting($this->params);
    }
}
