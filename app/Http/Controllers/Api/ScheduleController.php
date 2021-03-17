<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientPlan;
use App\Models\Equipment;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Models\TrainingCoachingSessionLength;
use App\Models\TrainingPlan;
use App\Models\WeekProgram;
use Illuminate\Http\Request;
use App\Models\MySchedule;
use App\Models\BlockTimeSlot;
use App\Traits\ZestLogTrait;
use App\Models\TimeSlot;
use App\Models\Booking;
use DateTime;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    use ZestLogTrait;

    public function getCoachingFrequencyAndLength(Request $request)
    {
        $this->setUserId($request);
        $userId = $this->userId;
        $clientId = $request->input('client_id');
        $serviceId = $request->input('service_id');
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'service_id' => 'required|integer',
            'client_id' => 'required|integer'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = ServiceBooking::where('user_id', '=', $userId)
                ->where('client_id', '=', $clientId)
                ->where('service_id', '=', $serviceId)
                ->first();
            if ($obj) {
                $this->data['SessionFrequencyId'] = $obj['training_plan_id'];
                $this->data['sessionFrequencyName'] = TrainingPlan::where('id', '=', $obj['training_plan_id'])
                    ->pluck('name')
                    ->first();
                $this->data['training_coaching_session_length_id'] = $obj['session_length'];
                $this->data['training_coaching_session_length_name'] = TrainingCoachingSessionLength::where('id', '=', $obj['session_length'])
                    ->where('type', $serviceId)
                    ->pluck('value')
                    ->first();
            }

            $this->success = true;
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to get personal training selected days
     * @param Request $request
     */


    public function getPersonalTrainingSelectedDays(Request $request)
    {
        $this->setUserId($request);
        $userId = $this->userId;
        $clientId = $request->input('client_id');
        $serviceId = $request->input('service_id');
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'service_id' => 'required|integer',
            'client_id' => 'required|integer'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = ServiceBooking::where('user_id', $userId)
                ->where('client_id', $clientId)
                ->where('service_id', $serviceId)
                ->pluck('days_id')
                ->first();
            $this->data['days_id'] = $obj;
            $this->success = true;
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to get blocked time slots data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBlockedTimeSlots(Request $request)
    {
        $data = $request->all();
        $validations = [
            'client_id' => 'required|integer',
//            'user_id' => 'required|integer',
            'week_id' => 'required',
            'year' => 'required|integer',
//            'service_id' => 'required|integer',
        ];
        $date = new DateTime($request->input('week_id'));
        $week = $date->format("W");
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $daysBlock = $arrBlockTimeSlots = $arrDay = $arrBookedTimeSlots = [];
            $this->success = true;
            $this->data['week_id'] = $week;
            $isWholeWeekBlock = MySchedule::where(['week_id' => $week, 'client_id' => $data['client_id'], 'is_block_whole_week' => 1])->whereNull('day_id')->first();
            $this->data['is_whole_week_block'] = (!empty($isWholeWeekBlock)) ? 1 : 0;
            if (empty($isWholeWeekBlock)) {
                $this->data['days_block'] = MySchedule::select('day_id')->where(['week_id' => $week, 'client_id' => $data['client_id'], 'is_block_whole_day' => 1])->whereNotNull('day_id')->get()->toArray();
                if (!empty($this->data['days_block'])) {
                    foreach ($this->data['days_block'] as $key => $row) {
                        $daysBlock[]['day_value'] = $row['day_id'];
                    }
                }
                $this->data['days_block'] = $daysBlock;
                $dates = $this->getStartAndEndDate($week, $data['year']);
                $startDate = reset($dates);
                $endDate = end($dates);

                $blockTimeSlotsData = BlockTimeSlot::where(['week_id' => $week, 'client_id' => $data['client_id'], 'year' => $data['year']])
                    ->get()->toArray();
                $blockTimeSlots = [];
                if (!empty($blockTimeSlotsData)) {
                    foreach ($blockTimeSlotsData as $row) {
                        $blockTimeSlots[$row['day_id']][] = $row;
                    }
                }
                if (!empty($blockTimeSlots)) {
                    foreach ($blockTimeSlots as $key => $row) {
                        $arrSlots = [];
                        foreach ($row as $item) {
                            $dayId = $item['day_id'];
                            $time = $item['start_time'];
                            $arrSlots[]['slot_value'] = $item['start_time'];
                            $intervals = (((strtotime($item['end_time']) - strtotime($item['start_time'])) / 60) / 15);
                            if ($intervals < 1) {
                                $intervals = 1;
                            }
                            for ($i = 1; $i <= $intervals; $i++) {
                                $time = date("H:i", strtotime('+15 minutes', strtotime($time)));
                                $arrSlots[]['slot_value'] = $time;
                            }
                        }
                        $arrBlockTimeSlots[$key]['week_value'] = $dayId;
                        $arrBlockTimeSlots[$key]['arr_slot'] = $arrSlots;
                    }
                    $arrBlockTimeSlots = array_values($arrBlockTimeSlots);
                }

                if (!empty($data['unique_id'])) {
                    $bookedTimeSlots = Booking::select('booking_date', 'start_time', 'end_time', 'fp.is_payment','bookings.unique_id')
                        ->where('bookings.unique_id', $request->input('unique_id'))
                        ->where('bookings.client_id', $request->input('client_id'))
                        ->leftJoin('final_payments as fp', 'fp.unique_id', '=', 'bookings.unique_id')
                        ->whereBetween('booking_date', [$startDate, $endDate])
                        ->get()->toArray();
                } else {
                    $bookedTimeSlots = Booking::select('booking_date', 'start_time', 'end_time','bookings.unique_id','fp.is_payment', 'bookings.user_id')
                        ->where('bookings.client_id', $request->input('client_id'))
                        ->leftJoin('final_payments as fp', 'fp.unique_id', '=', 'bookings.unique_id')
                        ->whereBetween('booking_date', [$startDate, $endDate])->get()->toArray();
                }
                if (!empty($bookedTimeSlots)) {
                    foreach ($bookedTimeSlots as $keySlots => $row) {
                        $dayOfWeek = (int) date("N", strtotime($row['booking_date']));
                        if (empty($dayOfWeek)) {
                            $dayOfWeek = 7;
                        }
                        $intervals = (((strtotime($row['end_time']) - strtotime($row['start_time'])) / 60) / 15);
                        $slots = [$row['start_time']];
                        $time = $row['start_time'];
                        for ($i = 1; $i <= $intervals; $i++) {
                            $time = date("H:i", strtotime('+15 minutes', strtotime($time)));
                            $slots[] = $time;
                        }
                        $arr = [];
                        foreach ($slots as $key => $rowSlots) {
                            $arr[]['slot_value'] = $rowSlots;
                        }
                        $arrBookedTimeSlots[$keySlots]['week_value'] = $dayOfWeek;
                        if (isset($row['is_payment'])) {
                            $isPayment = 1;
                            if (!empty($row['user_id']) && $row['user_id'] == $request->input('user_id') && $row['is_payment'] == 0) {
                                $isPayment = 0;
                            }
                            $arrBookedTimeSlots[$keySlots]['is_payment'] = $isPayment;
                        }
                        $arrBookedTimeSlots[$keySlots]['arr_slot'] = $arr;
                    }
                }
            } else {
                $this->data['days_block'] = 'all';
            }
            $this->data['arr_block_time_slots'] = $arrBlockTimeSlots;
            $this->data['arr_booked_time_slots'] = $arrBookedTimeSlots;
//            echo '<pre>'; print_r($arrBookedTimeSlots); exit;
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * This is used to add booking of user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function booking(Request $request)
    {
        $arr = [];
        $validations = [
            'user_id' => 'required|integer',
            'service_id' => 'required|integer',
            'client_id' => 'required|integer',
            'start_time' => 'required',
            'end_time' => 'required',
            'booking_date' => 'required',
            'unique_id' => 'required',
            'is_repeat' => 'integer',

        ];
        $validator = \Validator::make($request->all(), $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $this->setUserId($request);
            $data = [];
            $data['user_id'] = $this->userId;
            $data['service_id'] = $request->input('service_id');
            $data['client_id'] = $request->input('client_id');
            $data['start_time'] = $request->input('start_time');
            $data['end_time'] = $request->input('end_time');
            $data['booking_date'] = databaseDateFromat($request->input('booking_date'));
            $data['unique_id'] = $request->input('unique_id');
            $data['created_at'] = currentDateTime();
            $data['updated_at'] = currentDateTime();
            $objServiceBooking = ServiceBooking::select('wp.meta_data', 'starting_date', 'tp.days_value', 'training_session_location_id', 'training_session_location')
                ->where('user_id', $data['user_id'])
                ->where('unique_id', $data['unique_id'])
                ->where('service_id', $data['service_id'])
                ->where('client_id', $data['client_id'])
                ->join('week_programs as wp', 'wp.id', 'service_bookings.week_id')
                ->join('training_plans as tp', 'tp.id', 'service_bookings.training_plan_id')
                ->first();
            if (!empty($objServiceBooking)) {
                $objServiceBooking = $objServiceBooking->toArray();
                if ($request->input('service_id') == 3) {
                    $data['training_session_location_id'] = 0;
                } else {
                    $data['training_session_location_id'] = $objServiceBooking['training_session_location_id'];
                }
            }
            if ($request->input('is_repeat') == 1) {
                if ($objServiceBooking) {
                    $recordToAdd = [];
                    $weekName = $objServiceBooking['meta_data'];
                    $daysValue = $objServiceBooking['days_value'];
                    $startDate = $data['booking_date'];
                    $endDate = date('Y-m-d', strtotime($data['booking_date'] . " +$weekName week"));
                    $startTime = strtotime($startDate);
                    $dayId = date('N', $startTime);
                    $endTime = strtotime($endDate);
                    $count = 0;
                    $arrTime = [];
                    while ($startTime < $endTime) {
                        $arrTime[$count]['weekId'] = date('W', $startTime);
                        $arrTime[$count]['year'] = date('Y', $startTime);
                        $arrTime[$count]['booking_date'] = date('Y-m-d', $startTime);
                        if ($daysValue == 0.50) {
                            $startTime += strtotime('+2 week', 0);
                        } elseif ($daysValue == 0.25) {
                            $startTime += strtotime('+4 week', 0);
                        } else {
                            $startTime += strtotime('+1 week', 0);
                        }
                        $count++;
                    }
                    $weekIds = array_column($arrTime, 'weekId');
                    $years = array_column($arrTime, 'year');
                    $bookingDate = array_column($arrTime, 'booking_date');
                    $weekBlocksData = MySchedule::where(['client_id' => $data['client_id'], 'is_block_whole_week' => 1])
                        ->whereIn('week_id', $weekIds)
                        ->whereIn('year', $years)
                        ->whereNull('day_id') // will check it later
                        ->get()->toArray();
                    $daysBlockData = MySchedule::where(['client_id' => $data['client_id'], 'day_id' => $dayId,'is_block_whole_day'=>1])
                        ->where('is_block_whole_week',0)
                        ->whereIn('week_id', $weekIds)
                        ->whereIn('year', $years)
                        ->whereNotNull('day_id')
                        ->get()->toArray();
                    $weekBlocksData = array_merge($weekBlocksData,$daysBlockData);
                    if (!empty($weekBlocksData)) {
                        $weekBlocksData = array_column($weekBlocksData, null, 'week_id');
                    }
                    $blockTimeSlots = BlockTimeSlot::select('year', 'week_id','start_time', 'end_time')
                        ->where(['client_id' => $data['client_id'], 'day_id' => $dayId])
                        ->whereIn('week_id', $weekIds)
                        ->whereIn('year', $years)
                        ->get()->toArray();
                    $arrBlockTimeSlots = [];
                    if (!empty($blockTimeSlots)) {
                        $c = 0;
                        foreach ($blockTimeSlots as $key => $row) {
                            $arrBlockTimeSlots[$row['year']][$row['week_id']][$c]['start_time'] = $row['start_time'];
                            $arrBlockTimeSlots[$row['year']][$row['week_id']][$c]['end_time'] = $row['end_time'];
                            $c++;
                        }
                    }
                    $bookedSlots = Booking::select('start_time', 'end_time', 'booking_date')
//                        ->where('service_id', $request->input('service_id')) // removed this condition
                        ->where('client_id', $request->input('client_id'))
                        ->whereIn('booking_date', $bookingDate)
                        ->get()->toArray();
                    $arrBookedSlots = [];
                    if (!empty($bookedSlots)) {
                        $c = 0;
                        foreach ($bookedSlots as $key => $row) {
                            $arrBookedSlots[strtotime($row['booking_date'])][$c]['start_time'] = $row['start_time'];
                            $arrBookedSlots[strtotime($row['booking_date'])][$c]['end_time'] = $row['end_time'];
                            $c++;
                        }
                    }
                    foreach ($arrTime as $record) {
                        $data['booking_date'] = $record['booking_date'];
                        $weekId = (int)$record['weekId'];
                        $year = $record['year'];
                        $isWholeWeekBlock = false;
                        if (!empty($weekBlocksData[$weekId])) {
                            $isWholeWeekBlock = true;
                        }
                        if (empty($isWholeWeekBlock)) {
                            $isTimeSlotBlock = false;
                            $firstTime = strtotime("+1 minutes", strtotime($data['start_time']));
                            $secondTime = strtotime("-1 minutes", strtotime($data['end_time']));
                            if (!empty($arrBlockTimeSlots[$year][$weekId])) {
                                $blockTimeSlots = array_values($arrBlockTimeSlots[$year][$weekId]);
                                $isTimeSlotBlock = $this->isTimeSlotNotAvailable($firstTime, $secondTime, $blockTimeSlots);
                            }
                            if (!empty($arrBookedSlots[strtotime($record['booking_date'])]) && empty($isTimeSlotBlock)) {
                                $bookedTimeSlots = array_values($arrBookedSlots[strtotime($record['booking_date'])]);
                                $isTimeSlotBlock = $this->isTimeSlotNotAvailable($firstTime, $secondTime, $bookedTimeSlots);
                            }
                            if ($isTimeSlotBlock) {
                                $arr[]['week_id'] = $record['weekId'];
                            } else {
                                $data['week_id'] = $weekId;
                                $data['year'] = $year;
                                $recordToAdd[] = $data;
                            }
                        } else {
                            // when whole week block
                            $arr[]['week_id'] = $record['weekId'];
                            $count++;
                        }
                    }
                    $this->success = true;
                    $this->message = 'Time slot booked successfully';
                    if (!empty($arr)) {
                        $this->message = 'Time slot is not available on these date';
                        $this->data = $arr;
                    }
                    if (!empty($recordToAdd)) {
                        Booking::insert($recordToAdd);
                    }
                }
            } else {
                $obj = Booking::where('user_id', $this->userId)
                    ->where('service_id', $request->input('service_id'))
                    ->where('client_id', $request->input('client_id'))
                    ->where('booking_date', databaseDateFromat($data['booking_date']))
                    ->first();
                if (!$obj) {
                    $startDate =  $data['booking_date'];
                    $startTime = strtotime($startDate);
                    $data['week_id'] = date('W', $startTime);
                    $data['year'] = date('Y', $startTime);
                    Booking::Create($data);
                    $this->message = 'Time slot booked successfully';
                } else {
                    $this->message = 'This date already booked';
                }
                $this->success = true;
            }

        }

        return response()->json(['success' => $this->success, 'message' => $this->message, 'data' => $this->data], $this->statusCode);
    }

    /**
     * This function is used to check timeslot available or not
     *
     * @param $firstTime
     * @param $secondTime
     * @param $blockTimeSlots
     * @return bool
     */
    private function isTimeSlotNotAvailable($firstTime, $secondTime, $blockTimeSlots)
    {
        $isTimeSlotBlock = false;
        foreach ($blockTimeSlots as $key => $row) {
            $thirdTime = strtotime($row['start_time']);
            $fourthTime = strtotime($row['end_time']);
            if (($firstTime > $thirdTime && $firstTime < $fourthTime) || ($secondTime > $thirdTime && $secondTime < $fourthTime)) {
                $isTimeSlotBlock = true;
                break;
            }
        }

        return $isTimeSlotBlock;
    }

    /**
     * This is used to delete booking of user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteBooking(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $this->setUserId($request);
            $validations = [
                'user_id' => 'required|integer',
                'service_id' => 'required|integer',
                'client_id' => 'required|integer',
                'start_time' => 'required',
                'end_time' => 'required',
                'booking_date' => 'required',
                'unique_id' => 'required',
                'is_repeat' => 'required'
            ];
            $validator = \Validator::make($data, $validations);
            if ($validator->fails()) {
                $this->message = formatErrors($validator->errors()->toArray());
            } else {
                if ($data['is_repeat'] == 1) {
                    $objServiceBooking = ServiceBooking::select('wp.meta_data', 'starting_date', 'end_date', 'tp.days_value', 'training_session_location_id', 'training_session_location')
                        ->where('user_id', $this->userId)
                        ->where('unique_id', $data['unique_id'])
                        ->where('service_id', $data['service_id'])
                        ->where('client_id', $data['client_id'])
                        ->join('week_programs as wp', 'wp.id', 'service_bookings.week_id')
                        ->join('training_plans as tp', 'tp.id', 'service_bookings.training_plan_id')
                        ->first();
                    $this->message = 'No record Found';
                    if (!empty($objServiceBooking)) {
                        $objServiceBooking = $objServiceBooking->toArray();
                        $weekName = $objServiceBooking['meta_data'];
                        $startDate = $objServiceBooking['starting_date'];
                        $endDate = date('Y-m-d', strtotime($objServiceBooking['starting_date'] . " +$weekName week"));
                        $daysValue = $objServiceBooking['days_value'];
                        $dayId = date('N', strtotime($data['booking_date']));
                        $startTime = strtotime(databaseDateFromat($startDate));
                        $endTime = strtotime($endDate);
                        $arr = [];
                        while ($startTime < $endTime) {
                            $year = date('Y', $startTime);
                            $weekNumber = date('W', $startTime);
                            $gendate = new DateTime();
                            $gendate = $gendate->setISODate($year, $weekNumber, $dayId); //year , week num , day
                            $arr[] = databaseDateFromat($gendate->format('d-m-Y'));
                            if ($daysValue == 0.50) {
                                $startTime += strtotime('+2 week', 0);
                            } elseif ($daysValue == 0.25) {
                                $startTime += strtotime('+4 week', 0);
                            } else {
                                $startTime += strtotime('+1 week', 0);
                            }
                        }
                        $objBooking = Booking::where('user_id', $this->userId)
                            ->where('service_id', $request->input('service_id'))
                            ->where('client_id', $request->input('client_id'))
                            ->where('start_time', $request->input('start_time'))
                            ->where('end_time', $request->input('end_time'))
                            ->where('is_payment', '<>', 1)
                            ->whereIn('booking_date', $arr)
                            ->delete();
                        if ($objBooking) {
                            $this->success = true;
                            $this->message = 'Time slot deleted successfully';
                        } else {
                            $this->message = 'This slot does not exist';
                        }
                    }
                } else {
                    $obj = Booking::where('user_id', $this->userId)
                        ->where('service_id', $request->input('service_id'))
                        ->where('client_id', $request->input('client_id'))
                        ->where('start_time', $request->input('start_time'))
                        ->where('end_time', $request->input('end_time'))
                        ->where('is_payment', '<>', 1)
                        ->where('booking_date', databaseDateFromat($data['booking_date']))
                        ->delete();
                    if ($obj) {
                        $this->success = true;
                        $this->message = 'Time slot deleted successfully';
                    } else {
                        $this->message = 'This slot does not exist';
                    }
                }

            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * this is used to get upcoming schedules of end users
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUpComingSchedules(Request $request)
    {
        $this->setUserId($request);
        $currentDate = date("Y-m-d", strtotime(currentDateTime()));
        $currentTime = date("H:i", strtotime(currentDateTime()));
        $data = $request->all();
        $arr = [];
        $validations = [
            'user_id' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $data = Booking::select('bookings.id as booking_id','bookings.booking_date', 'bookings.start_time', 'bookings.end_time', 'u.id', 'u.first_name', 'u.last_name', 's.name as service_name', 'u.profile_pic_upload as profile_image')
                ->where('user_id', $this->userId)
                ->where('bookings.status','<>',2) // rejected not included
                ->where('booking_date', '>=', $currentDate)
                ->join('users as u', 'u.id', 'bookings.client_id')
                ->join('services as s', 's.id', 'bookings.service_id')
                ->orderBy('bookings.booking_date')
                ->orderBy('bookings.start_time')
                ->get()->toArray();
            if ($data) {
                foreach ($data as $key => $row) {
                    if (strtotime($row['end_time']) >= strtotime($currentTime) || strtotime($row['booking_date']) > strtotime($currentDate)) {
                        $arr[$key]['booking_id'] = $data[$key]['booking_id'];
                        $arr[$key]['client_id'] = $data[$key]['id'];
                        $arr[$key]['first_name'] = $data[$key]['first_name'];
                        $arr[$key]['last_name'] = $data[$key]['last_name'];
                        $arr[$key]['full_name'] = $data[$key]['first_name'] . ' ' . $data[$key]['last_name'];
                        $arr[$key]['start_time'] = $data[$key]['start_time'];
                        $arr[$key]['end_time'] = $data[$key]['end_time'];
                        $arr[$key]['booking_date'] = date("l d/F/Y", strtotime($data[$key]['booking_date']));
                        $arr[$key]['service_name'] = $data[$key]['service_name'];
                        if (!empty($row['profile_image'])) {
                            $arr[$key]['profile_image'] = asset(MobileUserImagePath . '/' . $data[$key]['profile_image']);
                        } else {
                            $arr[$key]['profile_image'] = null;
                        }
                    }
                }
               $arr = array_values($arr);
                $this->success = true;
            } else {
                $this->message = 'Record not found';
            }
        }
        if (empty($arr)) {
            $arr = (object)[];
        }
        $this->data = $arr;

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * this is used to get schedule weeks data of end user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getScheduleWeekData(Request $request)
    {
        $this->setUserId($request);
        $clientId = $request->input('client_id');
        $serviceId = $request->input('service_id');
        $uniqueId = $request->input('unique_id');
        $arr = [];
        $date = new DateTime();
        $currentWeek = $date->format("W");
        $currentYear = (int)$date->format("Y");
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'client_id' => 'required|integer',
            'service_id' => 'required|integer',
            'unique_id' => 'required',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = Booking::select('booking_date')
                ->where('client_id', $clientId)
                ->where('user_id', $this->userId)
                ->where('service_id', $serviceId)
                ->where('unique_id', $uniqueId)
                ->get()->toArray();
            if ($obj) {
                foreach ($obj as $key => $row) {
                    $Year = explode('-', $row['booking_date'])[0];
                    $date = new DateTime($row['booking_date']);
                    $week = $date->format("W");
                    $year = $date->format("Y");
                    if ($currentYear == $Year) {
                        if ($week < $currentWeek) {
                            $arr['disable_week']['week_number_' . $week] = $week;
                        } else {
                            $arr['enable_week']['week_number_' . $week] = $week;
                        }
                    } else {
                        $arr['enable_week']['week_number_' . $week] = $week;
                    }
                }

                $newArr = [];
                $count = 1;
                $counter=1;
                foreach ($arr as $key => $row) {
                    if ($key == 'disable_week') {
                        foreach ($row as $key1 => $item) {
                            $tempData = [];
                            $tempData['week_no'] = $counter;
                            $tempData['year'] = $year;
                            $tempData['week_value'] = $item;
                            $tempData['enable'] = false;
                            $newArr[] = $tempData;
                            $count++;
                            $counter++;
                        }
                    } else if ($key == 'enable_week') {
                        foreach ($row as $key1 => $item) {
                            $tempData = [];
                            $tempData['week_no'] = $count;
                            $tempData['year'] = $year;
                            $tempData['week_value'] = $item;
                            $tempData['enable'] = true;
                            $newArr[] = $tempData;
                            $count++;
                        }
                    }
                }

                $this->success = true;
            } else {
                $newArr = (object)[];
                $this->message = 'Record not found';
            }
        }
        $this->data = $newArr;

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * th is is used to get selected week details
     * get/select/week/detail
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSelectWeekDetail(Request $request)
    {
        $this->setUserId($request);
        $clientId = $request->input('client_id');
        $uniqueId = $request->input('unique_id');
        $serviceId = $request->input('service_id');
        $weekId = $request->input('week_id');
        $year = $request->input('year');
        $data = $request->all();
        $week_start = new DateTime();
        $startDate = $week_start->setISODate($year, $weekId, 1);
        $week_end = new DateTime();
        $endDate = $week_end->setISODate($year, $weekId, 7);
        $startDate = $startDate->format('Y-m-d');
        $endDate = $endDate->format('Y-m-d');
        $arr = [];
        $validations = [
            'user_id' => 'required|integer',
            'client_id' => 'required|integer',
            'unique_id' => 'required',
            'service_id' => 'required|integer',
            'week_id' => 'required|integer',
            'year' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = Booking::select('start_time', 'end_time', 'booking_date')
                ->where('bookings.client_id', $clientId)
                ->where('bookings.service_id', $serviceId)
                ->where('bookings.unique_id', $uniqueId)
                ->where('bookings.user_id', $this->userId)
                ->whereBetween('booking_date', [$startDate, $endDate])
                ->orderBy('bookings.booking_date')
                ->get()->toArray();
            if ($obj) {
                $objServiceBooking = ServiceBooking::select('tp.name as frequency')
                    ->join('training_plans as tp', 'tp.id', 'service_bookings.training_plan_id')
                    ->where('service_bookings.client_id', $clientId)
                    ->where('service_bookings.service_id', $serviceId)
                    ->where('service_bookings.unique_id', $uniqueId)
                    ->where('service_bookings.user_id', $this->userId)
                ->first();
                if($objServiceBooking){
                    $arr['frequency'] = $objServiceBooking->frequency;
                    foreach ($obj as $key => $row) {
                        $key = $key + 1;
                        $arr['session ' . $key]['start_time'] = $row['start_time'];
                        $arr['session ' . $key]['end_time'] = $row['end_time'];
                        $arr['session ' . $key]['session_date'] = date("l Y-F-d", strtotime($row['booking_date']));
                    }
                    $this->success = true;
                }

            } else {
                $this->message = 'Record not found';
            }
            $this->data = $arr;
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * get selected week session details
     * get/select/week/session/details
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSelectWeekSessionDetail(Request $request)
    {
        $this->setUserId($request);
        $clientId = $request->input('client_id');
        $uniqueId = $request->input('unique_id');
        $serviceId = $request->input('service_id');
        $weekId = $request->input('week_id');
        $year = $request->input('year');
        $week_start = new DateTime();
        $startDate = $week_start->setISODate($year, $weekId, 1);
        $week_end = new DateTime();
        $endDate = $week_end->setISODate($year, $weekId, 7);
        $startDate = $startDate->format('Y-m-d');
        $endDate = $endDate->format('Y-m-d');
        $data = $request->all();
        $date = new DateTime();
        $currentDate = $date->format("Y-m-d");
        $arr = [];
        $validations = [
            'user_id' => 'required|integer',
            'client_id' => 'required|integer',
            'unique_id' => 'required',
            'service_id' => 'required|integer',
            'week_id' => 'required|integer',
            'year' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = Booking::select('start_time', 'end_time', 'booking_date')
                ->where('bookings.client_id', $clientId)
                ->where('bookings.service_id', $serviceId)
                ->where('bookings.unique_id', $uniqueId)
                ->where('bookings.user_id', $this->userId)
                ->whereBetween('booking_date', [$startDate, $endDate])
                ->orderBy('bookings.booking_date')
                ->get()->toArray();
            if ($obj) {
                $objServiceBooking = ServiceBooking::select('tp.name as frequency')
                    ->join('training_plans as tp', 'tp.id', 'service_bookings.training_plan_id')
                    ->where('service_bookings.client_id', $clientId)
                    ->where('service_bookings.service_id', $serviceId)
                    ->where('service_bookings.unique_id', $uniqueId)
                    ->where('service_bookings.user_id', $this->userId)
                    ->first();
                if($objServiceBooking){
                    $arr['frequency'] = $objServiceBooking->frequency;

                    foreach ($obj as $key => $row) {
                        $key = $key + 1;
                        $tempData = [];
                        $tempData['start_time'] =  $row['start_time'];
                        $tempData['end_time'] =  $row['end_time'];
                        $tempData['session_value'] =  'session ' . $key;
                        $tempData['session_date'] =  date("l Y-F-d", strtotime($row['booking_date']));
                        $type = '';
                        if ($row['booking_date'] >= $currentDate) {
                            $type = 'upcoming_sessions';
                        } else if ($row['booking_date'] < $currentDate) {
                            $type = 'past_sessions';
                        }
                        $tempData['type'] = $type;
                        $arr['sessions'][] = $tempData;
                    }
                    $this->success = true;
                }
            } else {
                $this->message = 'Record not found';
            }
            $this->data = $arr;
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    public function checkWeekPublish(Request $request)
    {
        $this->setUserId($request);
        $clientId = $request->input('client_id');
        $uniqueId = $request->input('unique_id');
        $weekNumber = $request->input('week_id');
        $year = $request->input('year');
        $weekDays = [];
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'client_id' => 'required|integer',
            'unique_id' => 'required',
            'week_id' => 'required|integer',
            'year' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = ClientPlan::select('client_plans.is_publish', 'cwp.week_id')
                ->join('client_week_plans as cwp', 'cwp.client_plan_id', 'client_plans.id')
                ->where('client_plans.user_id', $this->userId)
                ->where('client_plans.client_id', $clientId)
                ->where('client_plans.unique_id', $uniqueId)
                ->where('cwp.week_id', $weekNumber)
                ->where('cwp.year', $year)
                ->first();
            if ($obj) {
                $obj = $obj->toArray();
                $this->success = true;
                $this->data = $obj;
            } else {
                $this->success = false;
                $this->message = 'You don not have a personal coach for this week';

            }

        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);

    }

    public function getCoach(Request $request)
    {
        $this->setUserId($request);
        $weekNumber = $request->input('week_id');
        $year = $request->input('year');
        $weekDays = [];
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'week_id' => 'required',
            'year' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $date = $request->input('week_id'); // used week_number param for date
            try{
                $date = new DateTime($date);
                $weekNumber = (int)$date->format("W");
            }catch (\Exception $e){
                $weekNumber = $request->input('week_id');
            }
            $url = asset(MobileUserImagePath);
            $obj = ClientPlan::select('client_plans.client_id', 'client_plans.unique_id', 'u.first_name', 'u.last_name',
                DB::raw("CONCAT('$url','/',u.profile_pic_upload) as profile_pic_upload")
                )
                ->join('client_week_plans as cwp', 'cwp.client_plan_id', 'client_plans.id')
                ->join('users as u', 'u.id', 'client_plans.client_id')
                ->join('final_payments as fp', 'fp.unique_id', '=', 'client_plans.unique_id')
                ->where('client_plans.user_id', $this->userId)
                ->where('cwp.week_id', $weekNumber)
                ->where('cwp.year', $year)
                ->where('fp.status', '=', 1)
                ->get()->toArray();
            if (!empty($obj)) {
                $this->success = true;
                $this->data = $obj;
            } else {
                $this->success = false;
                $this->message = 'You don not have a personal coach for this week';
            }

        }

        return response()->json(['success' => $this->success,'week_of_year'=>$weekNumber, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
    /**
     * This is used to delete booking of user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteReserveBooking(Request $request)
    {
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'service_id' => 'required|integer',
            'client_id' => 'required|integer',
            'unique_id' => 'required'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $this->setUserId($request);
            $obj = Booking::where('user_id', $this->userId)
                ->where('client_id', $request->input('client_id'))
                ->where('unique_id', $request->input('unique_id'))
                ->where('is_payment','<>',1)
                ->delete();
            if ($obj) {
                $this->message = 'Reserve slots deleted successfully';
            } else {
                $this->message = 'No slot available for this unique_id';
            }
            $this->success = true;
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
    /**
     * This is used to delete booking of user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWeeksBookingStatus(Request $request)
    {
        $this->setUserId($request);
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
            'service_id' => 'required|integer',
            'client_id' => 'required|integer',
            'unique_id' => 'required'
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $objServiceBooking = ServiceBooking::select('wp.meta_data','tp.days_value','service_bookings.starting_date')->where('user_id',$this->userId)
                ->where('service_id',$request->input('service_id'))
                ->where('client_id',$request->input('client_id'))
                ->where('unique_id',$request->input('unique_id'))
                ->join('week_programs as wp','wp.id','=','service_bookings.week_id')
                ->join('training_plans as tp','tp.id','=','service_bookings.training_plan_id')
                ->first();
            $arr = [];
            $preparedArr = [];
            if (!empty($objServiceBooking)) {
                $objServiceBooking = $objServiceBooking->toArray();
                $weeks = 1;
                $daysValue = '';
                $startingDate = '';
                if (isset($objServiceBooking['meta_data'])) {
                    $weeks = $objServiceBooking['meta_data'];
                    $daysValue = $objServiceBooking['days_value'];
                    $startingDate = $objServiceBooking['starting_date'];
                }
                $incrementedStartDate = $startingDate;
                for ($i = 1; $i <= $weeks;) {
                    if ($daysValue >= 1) {
                        $date = new DateTime($incrementedStartDate);
                        $currentWeek = $date->format("W");
                        $currentYear = $date->format("Y");
                        $dates = $this->getStartAndEndDate($currentWeek, $currentYear);
                        $startDate = reset($dates);
                        $endDate = end($dates);
                        $objBooking = Booking::where('user_id', $this->userId)
                            ->where('service_id', $request->input('service_id'))
                            ->where('client_id', $request->input('client_id'))
                            ->where('unique_id', $request->input('unique_id'))
                            ->whereBetween('booking_date', [$startDate, $endDate])
                            ->count();
                        if ($objBooking >= $daysValue) {
                            $arr['week_number'] = $i;
                            $arr['status'] = 'green';
                        } else {
                            $arr['week_number'] = $i;
                            $arr['status'] = 'grey';
                        }
                        $preparedArr['weeks'][] = $arr;
                        $i++;
                        $incrementedStartDate = date('Y-m-d', strtotime('+1 week', strtotime($incrementedStartDate)));
                    } else if ($daysValue == 0.50) {

                        $twoWeekIncrementedDate = date('Y-m-d', strtotime('+1 week', strtotime($incrementedStartDate)));
                        $date = new DateTime($incrementedStartDate);
                        $currentWeek = $date->format("W");
                        $currentYear = $date->format("Y");
                        $dates = $this->getStartAndEndDate($currentWeek, $currentYear);
                        $startDate = reset($dates);
                        $date = new DateTime($twoWeekIncrementedDate);
                        $currentWeek = $date->format("W");
                        $currentYear = $date->format("Y");
                        $dates = $this->getStartAndEndDate($currentWeek, $currentYear);
                        $endDate = end($dates);
                        $objBooking = Booking::where('user_id', $this->userId)
                            ->where('service_id', $request->input('service_id'))
                            ->where('client_id', $request->input('client_id'))
                            ->where('unique_id', $request->input('unique_id'))
                            ->whereBetween('booking_date', [$startDate, $endDate])
                            ->count();

                        if ($objBooking >= $daysValue) {
                            $val = $i;
                            for ($q = 1; $q <= 2; $q++) {
                                $arr['week_number'] = $val;
                                if ($q == 1)
                                    $arr['status'] = 'green';
                                else
                                    $arr['status'] = 'not active';
                                $preparedArr['weeks'][] = $arr;
                                $val++;
                            }
                        } else {
                            $val = $i;
                            for ($q = 1; $q <= 2; $q++) {
                                $arr['week_number'] = $val;
                                if ($q == 1)
                                    $arr['status'] = 'grey';
                                else
                                    $arr['status'] = 'not active';
                                $preparedArr['weeks'][] = $arr;
                                $val++;
                            }
                        }
                        $i = $i + 2;
                        $incrementedStartDate = date('Y-m-d', strtotime('+2 week', strtotime($incrementedStartDate)));
                    } else if ($daysValue == 0.25) {
                        $fourWeekIncrementedDate = date('Y-m-d', strtotime('+2 week', strtotime($incrementedStartDate)));
                        $date = new DateTime($incrementedStartDate);
                        $currentWeek = $date->format("W");
                        $currentYear = $date->format("Y");
                        $dates = $this->getStartAndEndDate($currentWeek, $currentYear);
                        $startDate = reset($dates);
                        $date = new DateTime($fourWeekIncrementedDate);
                        $currentWeek = $date->format("W");
                        $currentYear = $date->format("Y");
                        $dates = $this->getStartAndEndDate($currentWeek, $currentYear);
                        $endDate = end($dates);
                        $objBooking = Booking::where('user_id', $this->userId)
                            ->where('service_id', $request->input('service_id'))
                            ->where('client_id', $request->input('client_id'))
                            ->where('unique_id', $request->input('unique_id'))
                            ->whereBetween('booking_date', [$startDate, $endDate])
                            ->count();
                        if ($objBooking >= $daysValue) {
                            $val = $i;
                            for ($q = 1; $q <= 4; $q++) {
                                $arr['week_number'] = $val;
                                if ($q == 1)
                                    $arr['status'] = 'green';
                                else
                                    $arr['status'] = 'not active';
                                $preparedArr['weeks'][] = $arr;
                                $val++;
                            }
                        } else {
                            $val = $i;
                            for ($q = 1; $q <= 4; $q++) {
                                $arr['week_number'] = $val;
                                if ($q == 1)
                                    $arr['status'] = 'grey';
                                else
                                    $arr['status'] = 'not active';
                                $preparedArr['weeks'][] = $arr;
                                $val++;
                            }
                        }
                        $i = $i + 4;
                        $incrementedStartDate = date('Y-m-d', strtotime('+4 week', strtotime($incrementedStartDate)));
                    }
                }
            }
            $this->success = true;
            $this->data = (!empty($preparedArr)) ? $preparedArr : (object) $preparedArr;
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
    /**
     * This is used to delete user all  reserve slots
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUserAllReserveBooking(Request $request)
    {
        $this->setUserId($request);
        $data = $request->all();
        $validations = [
            'user_id' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $obj = Booking::where('user_id', $this->userId)
                ->where('is_payment', '<>', 1)
                ->delete();
            if ($obj) {
                $this->message = 'Reserve slots deleted successfully';
            } else {
                $this->message = 'No slot available for this User';
            }
            $this->success = true;
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
    public function getDateAndWeeks(Request $request){
        $data = $request->all();
        $weekId  = $request->input('week_id');

        $validations = [
            'week_id' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {

        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * this is used to get archived bookings of user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getArchivedSchedules(Request $request){
        $this->setUserId($request);
        $currentDate = date("Y-m-d", strtotime(currentDateTime()));
        $currentTime = date("H:i", strtotime(currentDateTime()));
        $data = $request->all();
        $arr = [];
        $validations = [
            'user_id' => 'required|integer',
        ];
        $validator = \Validator::make($data, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $data = Booking::select('bookings.is_confirmed','bookings.id as booking_id','bookings.booking_date',
                'bookings.start_time', 'bookings.end_time', 'u.id', 'u.first_name', 'u.last_name',
                's.name as service_name', 'u.profile_pic_upload as profile_image')
                ->where('user_id', $this->userId)
                ->where('bookings.status','<>',2) // rejected not included
                ->where('booking_date', '<=', $currentDate)
                ->join('users as u', 'u.id', 'bookings.client_id')
                ->join('services as s', 's.id', 'bookings.service_id')
                ->orderBy('bookings.booking_date','desc')
                ->orderBy('bookings.start_time','desc')
                ->get()->toArray();
            if ($data) {
                foreach ($data as $key => $row) {
                    if (strtotime($row['end_time']) < strtotime($currentTime) || strtotime($row['booking_date']) < strtotime($currentDate)) {
                        $arr[$key]['booking_id'] = $data[$key]['booking_id'];
                        $arr[$key]['client_id'] = $data[$key]['id'];
                        $arr[$key]['first_name'] = $data[$key]['first_name'];
                        $arr[$key]['last_name'] = $data[$key]['last_name'];
                        $arr[$key]['full_name'] = $data[$key]['first_name'] . ' ' . $data[$key]['last_name'];
                        $arr[$key]['start_time'] = $data[$key]['start_time'];
                        $arr[$key]['end_time'] = $data[$key]['end_time'];
                        $arr[$key]['booking_date'] = date("l d/F/Y", strtotime($data[$key]['booking_date']));
                        $arr[$key]['service_name'] = $data[$key]['service_name'];
                        $arr[$key]['is_confirmed'] = $data[$key]['is_confirmed'];
                        if (!empty($row['profile_image'])) {
                            $arr[$key]['profile_image'] = asset(MobileUserImagePath . '/' . $data[$key]['profile_image']);
                        } else {
                            $arr[$key]['profile_image'] = null;
                        }
                    }
                }
                $arr = array_values($arr);
                $this->success = true;
            } else {
                $this->message = 'Record not found';
            }
        }
        if (empty($arr)) {
            $arr = (object)[];
        }
        $this->data = $arr;

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
}
