<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BlockTimeSlot;
use App\Models\Booking;
use App\Models\Day;
use App\Models\DeleteOrEditBlockSlot;
use App\Models\MySchedule;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\TrainingSessionLocation;
use DateTime;
use http\Env\Response;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ZestLogTrait;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;
use phpDocumentor\Reflection\Types\Object_;

class ScheduleController extends Controller
{
    use ZestLogTrait;

    /**
     * This is used to display Schedule View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [];
        $data['timeSlots'] = [];
        $data['days'] = [];
        $data['scheduleData'] = [];
        $data['scheduleDataDays'] = [];
        $data['blockTimeSlots'] = [];
        $data['startTimeSlots'] = TimeSlot::pluck('time_slot_drop', 'id')->toArray();
        $timeSlots = TimeSlot::pluck('time_slot_drop', 'id')->toArray();
        $firstIndex = $timeSlots[1];
        unset($timeSlots[1]);
        $timeSlots = $timeSlots + [1 => $firstIndex];
        $data['endTimeSlots'] = $timeSlots;
        $totalWeekInYear = $this->getIsoWeeksInYear(date('Y'));
        $emptySelect[''] = 'All';
        $services = $emptySelect + Service::pluck('name', 'id')->toArray();
        $data['services'] = $services;
        $data['services-meeting'] = $services;
        unset($data['services-meeting'][1],$data['services-meeting'][2]);
        unset($data['services'][3],$data['services'][4]);
        $emptySelect['0'] = 'Online';
        $data['trainingLocations'] = $emptySelect + TrainingSessionLocation::join('training_program_price_setups as tp', 'tp.id', 'training_session_locations.training_program_price_setup_id')
                ->where('tp.user_id', loginId())
                ->pluck('training_session_locations.address_name', 'training_session_locations.id')->toArray();

        return view('client.schedule', compact('data', 'totalWeekInYear'));
    }

    /**
     * thuis is used to update schedule details
     * @param Request $request
     * @return Response
     */
    public function updateSchedule(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->getUserId();
            $weekId = $request->input('weekId');
            $year = $request->input('selectedWeekYear');
            $isWholeWeekBlock = (int)$request->input('isWholeWeekBlock');
            $blockDayId = $request->input('blockDayId');
            $blockDayId = explode('_', $blockDayId)[2];
            $IsBlockDayTrue = (int)$request->input('isBlockDayTrue');
            $isChangeType = (int)$request->input('isChangeType');
            if (!empty($isChangeType)) { // it means change in whole week block
                $blockDayId = null;
                $IsBlockDayTrue = 0;
                if ($isWholeWeekBlock) {
                    MySchedule::where(['week_id' => $weekId, 'client_id' => $this->userId])->whereNotNull('day_id')->delete();
                }
                $obj = MySchedule::where(['week_id' => $weekId, 'client_id' => $this->userId])->whereNull('day_id')->first();
            } else {
                $obj = MySchedule::where(['week_id' => $weekId, 'client_id' => $this->userId, 'day_id' => $blockDayId])->first();
            }
            if (empty($obj)) {
                $obj = new MySchedule();
            }
            $obj->week_id = $weekId;
            $obj->client_id = $this->userId;
            $obj->day_id = $blockDayId;
            $obj->is_block_whole_week = $isWholeWeekBlock;
            $obj->is_block_whole_day = $IsBlockDayTrue;
            $obj->year = $year;
            $obj->save();
            $this->success = true;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json(['success' => $this->success, 'message' => $this->message,]);
    }

    /**\
     * this is used to block specific time slot using AJAX
     * @param Request $request
     * @return \Illuminate\Http\JsonRespons
     *
     */

    public function blockTimeSlotClients(Request $request)
    {
        try {
            DB::beginTransaction();
            ini_set('max_execution_time', '0');
            $startDate = $request->input('date');
            $endDate = $request->input('repeatDate');
            $startTime = TimeSlot::find($request->input('startTime'))->time_slot;
            $endTime = '24:00';
            if ((int)$request->input('endTime') > 1)
                $endTime = TimeSlot::find($request->input('endTime'))->time_slot;
            if (empty($endDate)) {
                $endDate = $startDate;
            }
            $repeatId = $request->input('repeatId');
            if (empty($repeatId))
                $repeatId = 1;
            $repeatName = ' days';
            if ($repeatId) {
                $startDate = str_replace('/', '-', $startDate);
                $endDate = str_replace('/', '-', $endDate);
                $uniqueId = time().'_'.loginId().'_'.generateRandomString().rand(10,100);
                if ($repeatId == 1) {
                    $startDate = databaseDateFromat($startDate);
                    $date = new DateTime($startDate);
                    $weekNumber = $date->format("W");
                    $dayNumber = $date->format("N");
                    $YearNumber = $date->format("Y");
                    $this->repeatTimeSlotBlock($weekNumber, $dayNumber, $YearNumber, $startTime, $endTime, $repeatId, $startDate,$uniqueId);
                } else {
                    if ($repeatId == 2) {
                        $repeatName = ' days';
                    }
                    if ($repeatId == 3) {
                        $repeatName = ' week';
                    } else if ($repeatId == 4) {
                        $repeatName = ' months';
                    }
                    $i = strtotime($startDate);
                    $inc = 0;
                    while ($i <= strtotime($endDate)) {
                        $date = new DateTime(date('Y-m-d', $i));
                        $weekNumber = $date->format("W");
                        $dayNumber = $date->format("N");
                        $YearNumber = $date->format("Y");
                        $this->repeatTimeSlotBlock($weekNumber, $dayNumber, $YearNumber, $startTime, $endTime, $repeatId, $date,$uniqueId);
                        $inc++;
                        $i = strtotime(date('Y-m-d', strtotime($startDate . ' + ' . $inc . $repeatName)));
                    }
                }
                $this->success = true;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * this is used to save repeat time slot block
     * @param $weekId
     * @param $blockDayId
     * @param $year
     */
    public function repeatTimeSlotBlock($weekId, $blockDayId, $year, $startTime, $endTime, $repeatId, $startDate,$uniqueId)
    {
        $clientId = loginId();
        if (!empty($startTime) && !empty($endTime)) {
            $obj = BlockTimeSlot::where('week_id', '=', $weekId)->where('year', '=', $year)
                ->where('day_id', '=', $blockDayId)
                ->where('start_time', '=', $startTime)
                ->where('end_time', '=', $endTime)
                ->first();
            if (empty($obj)) {
                $obj = new BlockTimeSlot();
                $obj->unique_id = $uniqueId;
            }
            $obj->week_id = $weekId;
            $obj->day_id = $blockDayId;
            $obj->year = $year;
            $obj->client_id = $clientId;
            $obj->start_time = $startTime;
            $obj->end_time = $endTime;
            $obj->start_date = $startDate;
            $obj->end_date = $startDate; // because block in same day
            $obj->repeat_id = $repeatId;
            $obj->save();
        }
    }
    function getIsoWeeksInYear($year) {
        $date = new DateTime;
        $date->setISODate($year, 53);
        return ($date->format("W") === "53" ? 53 : 52);
    }
     /**
     * this is used to get schedule data through AJAX
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getScheduleData(Request $request)
    {
        $this->getUserId();
        $weekId = $request->input('weekId');
        $selectedWeekYear = $request->input('selectedWeekYear');
        if ($weekId == 53) {
            $selectedWeekYear = 2020;
        }
        $arrWeek = $this->getStartAndEndDate($weekId,$selectedWeekYear);
        $startDate = reset($arrWeek);
        $endDate = end($arrWeek);
        $startYear = date("Y", strtotime($startDate));
        $endYear = date("Y", strtotime($endDate));
        $selectedWeekYear = array_unique([$startYear, $endYear]);

        $data = [];
        $data['timeSlots'] = TimeSlot::get()->toArray();
        $data['days'] = Day::pluck('name', 'id')->toArray();
        $data['scheduleData'] = MySchedule::where(['week_id' => $weekId, 'client_id' => $this->userId])->first();
        $arr = MySchedule::where('week_id', '=', $weekId)
            ->where('client_id',$this->userId)
            ->get()->toArray();
        $data['scheduleDataDays'] = array_column($arr, null, 'day_id');
        $arrBlockTimeSlots = BlockTimeSlot::where(['week_id' => $weekId, 'client_id' => $this->userId])->whereIn('year', $selectedWeekYear)
            ->get()->toArray();
        $arrPreparedBlockSlots = [];
        if (!empty($arrBlockTimeSlots)) {
            foreach ($arrBlockTimeSlots as $row) {
                $arrPreparedBlockSlots[$row['day_id']][] = $row;
            }
        }

        $arrBooking = Booking::where('client_id',$this->userId)->whereBetween('booking_date', [$startDate, $endDate])->get()->toArray();
        $data['blockTimeSlots'] = $arrPreparedBlockSlots;
        $view = view('client.partials._schedule-table', compact('data', 'arrWeek', 'arrBooking'))->render();
        return response()->json(['success' => true, 'message' => $this->message, 'view' => $view]);
    }
    /**
     * this is used to block draged slot
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function blockDragSlot(Request $request)
    {
        $weekId = $request->input('week_id');
        $selectedDaYDate = $request->input('selected_day_date');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $obj = TimeSlot::where('id', $startTime)
            ->orWhere('id', $endTime)
            ->get()->toArray();
        $obj = array_column($obj, null, 'id');
        $data = [];
        foreach ($obj as $key => $row) {
            if ($key == $startTime) {
                $data['start_time'] = $request->input('start_time');
            } else if ($key == $endTime) {
                $data['end_time'] = $request->input('end_time');
            }
        }
        $selectedDaYDate = date("d/m/Y", strtotime($selectedDaYDate));
        $data['selectedDaYDate'] = $selectedDaYDate;
        $data['timeSlotsPopup'] = TimeSlot::pluck('time_slot_drop', 'id')->toArray();
        $timeSlots = TimeSlot::pluck('time_slot_drop', 'id')->toArray();
        $firstIndex = $timeSlots[1];
        unset($timeSlots[1]);
        $timeSlots = $timeSlots + [1 => $firstIndex];
        $data['endTimeSlots'] = $timeSlots;
        $view = view('client.partials._block-slot-popup', compact('data'))->render();
        return response()->json(['success' => true, 'message' => $this->message, 'view' => $view]);
    }

    /**
     * this is used to  block draged slot using AJAX
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveBlockDragSlot(Request $request){
        $this->getUserId();
        $startDate = $request->input('date');
        $startDate = str_replace('/', '-', $startDate);
        $startDate = databaseDateFromat($startDate);
        $endDate = $startDate;
        $startTime = TimeSlot::find($request->input('start_time_drag'))->time_slot;
        $endTime = '24:00';
        $uniqueId = time().'_'.loginId().'_'.generateRandomString().rand(10,100);
        if ($request->input('end_time_drag') > 1)
            $endTime = TimeSlot::find($request->input('end_time_drag'))->time_slot;
        $weekNumber = $request->input('week_id');
        $currentYear = $request->input('select_year');
        $repeatId = $request->input('repeatId');
        $blockDayId = date('N', strtotime($startDate));
        $obj = BlockTimeSlot::where('client_id', $this->userId)
            ->where('start_time', $startTime)
            ->where('end_time', $endTime)
            ->where('start_date', $startDate)
            ->where('end_date', $endDate)
            ->where('repeat_id', $repeatId)
            ->first();
        if (!$obj) {
            $obj = new BlockTimeSlot();
            $obj->client_id = $this->userId;
            $obj->unique_id = $uniqueId;
        }
        $obj->start_time = $startTime;
        $obj->end_time = $endTime;
        $obj->start_date = $startDate;
        $obj->end_date = $endDate;
        $obj->week_id = $weekNumber;
        $obj->year = $currentYear;
        $obj->repeat_id = $repeatId;
        $obj->day_id = $blockDayId;
        $obj->save();
        $this->success = true;

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * to show edit and delete popup using AJAX
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getBlockSlotData(Request $request)
    {
        $dbId = $request->input('value');
        $date = $request->input('day_date');
        $obj = BlockTimeSlot::where('id', $dbId)
            ->first();
        $data = [];
        if ($obj) {
            $data ['start_time'] = TimeSlot::where('time_slot', '=', $obj->start_time)->first()->id;
            $endTime = $obj->end_time;
            if ($obj->end_time == '24:00')
                $endTime = '00:00';
            $data ['end_time'] = TimeSlot::where('time_slot', '=', $endTime)->first()->id;
            $data ['id'] = $obj->id;
            $data ['repeat_id'] = $obj->repeat_id;
            $data ['unique_id'] = $obj->unique_id;
        }
        $selectedDaYDate = date("d/m/Y", strtotime($date));
        $data['selectedDaYDate'] = $selectedDaYDate;
        $data['startTimeSlots'] = TimeSlot::pluck('time_slot_drop', 'id')->toArray();
        $timeSlots = TimeSlot::pluck('time_slot_drop', 'id')->toArray();
        $firstIndex = $timeSlots[1];
        unset($timeSlots[1]);
        $timeSlots = $timeSlots + [1 => $firstIndex];
        $data['endTimeSlots'] = $timeSlots;

        $view = view('client.partials._blocked-slot-popup', compact('data'))->render();

        return response()->json(['success' => true, 'message' => $this->message, 'view' => $view, 'start_value' => $data['start_time']]);
    }

    /**
     * this is used to edit block slot using AJAX
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editBlockSlotSaved(Request $request)
    {
        $id = $request->input('selected_id');
        $startTime = $request->input('start_time_block_slot');
        $uniqueIdSlots = $request->input('unique_id_slots');
        $startTime = TimeSlot::find($startTime)->time_slot;
        $endTime = '24:00';
        if ((int)$request->input('end_time_block_slot') > 1)
            $endTime = TimeSlot::find($request->input('end_time_block_slot'))->time_slot;
        if (empty($uniqueIdSlots)) {
            $obj = BlockTimeSlot::find($id);
            if ($obj) {
                $obj->start_time = $startTime;
                $obj->end_time = $endTime;
                $obj->save();
                $this->success = true;
            }
        } elseif (!empty($uniqueIdSlots)) {
            BlockTimeSlot::where('unique_id', $uniqueIdSlots)->update([
                'start_time' => $startTime,
                'end_time' => $endTime
            ]);
            $this->success = true;
        } else {
            $this->message = 'Slot record not found';
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }
    /**
     * this is used to delete slot using Ajax
     */
    public function slotDelete(Request $request){
        $id = $request->input('selected_id');
        $uniqueIdSlots = $request->input('unique_id_slots');
        if ($id) {
            if (!empty($uniqueIdSlots)) {
                $obj = BlockTimeSlot::where('unique_id', $uniqueIdSlots)->delete();
            } else {
                $obj = BlockTimeSlot::where('id', $id)->delete();
            }
            if ($obj) {
                $this->success = true;
                $this->message = 'slot deleted successfuly';
            }

        } else {
            $this->message = 'Slot record not found';
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }
}
