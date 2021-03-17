<?php
define('clientImagePath', 'user/profile');
define('subscriberImagePath', 'user/profile');
define('adminImagePath', 'admin/profile');
define('exerciseImagePathMale', 'exercise/male/images');
define('exerciseGifPathMale', 'exercise/male/gif');
define('exerciseVideoPathMale', 'exercise/male/videos');
define('exerciseImagePathFemale', 'exercise/female/images');
define('exerciseGifPathFemale', 'exercise/female/gif');
define('exerciseVideoPathFemale', 'exercise/female/videos');

define('MobileUserImagePath', 'user/profile');
define('MobileUserIdentityImagePath', 'user/profile/Identity');

define('MobileUserLogImagePath', 'user/log');
define('MobileUserLogImagePathTemp', 'user/templogs');
define('MobileAccountChannelActivation', 'account/channelactivation');
define('malePlanImage', 'planimages/male');
define('femalePlanImage', 'planimages/female');

use App\Models\PlanDragDropStructure;
use App\Models\Client\PlanDragDropStructure as ClientPlanDragDropStructure;
use App\User;
use App\Models\Service;
use Illuminate\Support\Env;
use mikehaertl\wkhtmlto\Pdf;

/**
 *
 * sent email to users
 *
 * @param    data,tmplatename
 * @return    result
 *
 */
function mailSend($data, $templateName)
{
    $final = [];
    if ($data && $templateName) {
        //send email
        \Mail::send($templateName, array('data' => $data), function ($message) use ($data, $final) {
            $message->to($data['email'], 'ZestLog')->subject($data['subject']);

            if (isset($data['cc_email']) && !empty($data['cc_email'])) {
                $message->cc($data['cc_email']);
            }

        });
        //end here
    }
}

function sendMail($params)
{
    $data = array('verification_code'=> $params['message']);
    \Mail::send(['text'=> $params['view']], $data, function($message) use ($params) {
        $message->to($params['to_email'], 'Email')
            ->subject($params['subject']);
        $message->from('noreply@zestlog.com','Zestlog');
    });
}

/**
 * This function returns unique image name
 *
 * @param $extension
 * @return string
 */
function createImageUniqueName($extension)
{
    $uniqueId = time() . uniqid(rand());
    $imageName = $uniqueId . '.' . $extension;

    return $imageName;
}

/**
 * This is used to get current date time
 *
 * @return string
 */
function currentDateTime()
{
    $time = \Carbon\Carbon::now();

    return $time->toDateTimeString();
}

/**
 * This is used to preapre seeder data
 *
 * @param $data
 * @param string $keyVal
 * @param bool $isMeta
 * @return array
 */
function prepareSeederData($data, $keyVal='value', $isMeta = true)
{
    $arrSet = [];
    foreach ($data as $key => $row) {
        $arrSet[$key][$keyVal] = $row;
        if(!empty($isMeta)) {
            $arrSet[$key]['meta_data'] = '';
            $arrSet[$key]['meta_description'] = '';
        }
        $arrSet[$key]['created_at'] = date("Y-m-d h:i:s");
        $arrSet[$key]['updated_at'] = date("Y-m-d h:i:s");
    }

    return $arrSet;
}

/**
 * This is used to get training plan set up
 *
 * @param $id
 * @return array
 */
function getTrainingPlanSetupColumns($id)
{
    switch ($id) {
        case 1:
            $arr = ['Set', 'Rep', 'Duration', 'Notes'];
            break;
        case 2:
            $arr = ['Set', 'Rep', '1RM%', 'Tempo', 'Rest'];
            break;
        case 3:
            $arr = ['Form', 'Stage', 'W:R', 'Rep', 'Duration'];
            break;
        default:
            $arr = ['Set', 'Rep', 'Duration', 'Notes'];
    }

    return $arr;
}

/**
 * make_complete_pagination_block
 * @param $obj
 * @param string $type | three possible values 1)short (for short paragraph) 2)long (for long paragraph) 3) null (for no paragraph) .
 * @return  complete pagination block
 */
function make_complete_pagination_block($obj, $type = null, $is_simple = null,$totalRecord)
{
    $info = get_pager_info_paragraph($obj, $type,$is_simple,$totalRecord);

    return view('partials._pager', compact('info', 'obj'))->render();
}

/**
 * get_pager_info_paragraph | it will a paginator object provided by laravel paginate method and will return a paragraph line item with the info about total records and showing records range according to the current page.
 * @param array $obj | paginator object provided by laravel paginate method
 * @param string $type | three possible values 1)short (for short paragraph) 2)long (for long paragraph) 3) null (for no paragraph) .
 * @return returns string | returns a string (paragraph line with star end and total records according to the current page.)
 *
 */
function get_pager_info_paragraph($obj, $type = null, $is_simple,$totalRecord)
{
    $info = "";
    $end = $obj->currentPage() * $obj->perPage();
    $start = $end - ($obj->perPage() - 1);
    $current_page = $obj->currentPage();
    $total = $totalRecord;
    if (!empty($is_simple)) {
        $last_page = ($total - 1) * $obj->perPage();
    } else {
        $last_page = $obj->lastPage();
    }
    if ($start < 1) {
        $start = 1;
    }
    if ($end > $total) {
        $end = $total;
    }
    $type = 'long';
    if ($type) {
        if ($total > 0) {
            if ($type == 'long') {
                $info = "<div class='pager-info'><p>Showing $start to $end of $total Records.</p><div class='clr'></div></div>";
            } else {
                $info = "<div class='pager-info'><p>Side $current_page of $last_page </p><div class='clr'></div></div>";
            }
        }
    }

    return $info;
}

/**
 * This function returns login user id
 *
 * @return mixed
 */
function loginId()
{
    $id = 0;
    if (\Auth::check())
        $id = \Auth::user()->id;

    return $id;
}

/**
 * This is used to get week names
 *
 * @return array
 */
function weeksName()
{
    return $arr = [1, 4, 8, 12, 24, 48];
}

/**
 * This is used to check user is admin or not
 *
 * @param string $user
 * @return bool
 */
function isAdmin($user = '')
{
    $isAdmin = false;
    if ($user) {
        if ($user->user_type == 1) {
            $isAdmin = true;
        }
    } else if (\Auth::check() && \Auth::user()->user_type == 1) {
        $isAdmin = true;
    }

    return $isAdmin;
}

/**
 * This is used to get login name
 *
 * @return string
 */
function loginName()
{
    $name = '';
    if (\Auth::check())
        $name = \Auth::user()->first_name.' '.\Auth::user()->last_name;

    return $name;
}

/**
 * This is used to get login user device token
 *
 * @return string
 */
function getDeviceToken()
{
    $token = '';
    if (\Auth::check())
        $token = \Auth::user()->device_token;

    return $token;
}

//function sendEmail($params)
//{
//    \Mail::send('emails.'.$params['template'], ['data' => $params['data']], function ($message) use ($params)
//    {
//        $message->from('no-reply@scotch.io');
//        $message->to($params['toEmail']);
//        $message->subject($params['subject']);
//    });
//}


function databaseDateFromat($date)
{
    return date_format(new \DateTime($date), 'Y-m-d');
}

function viewDateFormat($date)
{
    return date_format(new \DateTime($date), 'd/m/Y');
}

function manipulateStr($input)
{
    return strrev(ucwords(strrev(ucwords(strtolower($input)))));
}

/**
 * This is used to changed date picker to date time
 *
 * @param $date
 * @return false|string
 */
function databaseDateTimeFromat($date)
{
    return date_format(new \DateTime($date), 'Y-m-d h:i');
}

/**
 * This is used to changed date picker to date time
 *
 * @param $date
 * @return false|string
 */
function scheduleDateTimeFormat($date)
{
    return date_format(new \DateTime($date), 'd/m/Y');
}
/**
 * This is used to format errors
 *
 * @param $data
 *     array:2 [
 * "email" => array:1 [
 * 0 => "The email has already been taken."
 * ]
 * "mobile_number" => array:1 [
 * 0 => "The mobile number has already been taken."
 * ]
 * ]
 * @return array
 *
 * array:2 [
 * 0 => "The email has already been taken."
 * 1 => "The mobile number has already been taken."
 * ]
 */
function formatErrors($data)
{
    $errors = [];
    if (!empty($data)) {
        foreach ($data as $row) {
            if ($row) {
                foreach ($row as $value) {
                    $errors[] = $value;
                }
            }
        }
    }

    return $errors;
}

/**
 * This is used to return random password
 *
 * @return string
 */
function randomPassword($length, $count, $characters)
{

// $length - the length of the generated password
// $count - number of passwords to be generated
// $characters - types of characters to be used in the password

// define variables used within the function
    $symbols = array();
    $passwords = array();
    $used_symbols = '';
    $pass = '';

// an array of different character types
    $symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
    $symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $symbols["numbers"] = '1234567890';
//    $symbols["special_symbols"] = '!?~@#-_+<>[]{}';

    $characters = explode(",", $characters); // get characters types to be used for the passsword
    foreach ($characters as $key => $value) {
        $used_symbols .= $symbols[$value]; // build a string with all characters
    }
    $symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1
    $pass = '';
    for ($p = 0; $p < $count; $p++) {
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $symbols_length); // get a random character from the string with all characters
            $pass .= $used_symbols[$n]; // add the character to the password string
        }
        $passwords[] = $pass;
    }

    return $pass; // return the generated password
}

function generateRandomString($length = 5)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function arrayToObject($d)
{
    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return (object)array_map(__FUNCTION__, $d);
    } else {
        // Return object
        return $d;
    }
}

/**
 * This is used to download file/ force to open file in browser
 *
 * @param $fileName
 * @param $fileUrl
 * @param string $attachment
 *      1) attachment:force download file
 *      2) inline: force open in browser
 */
function downloadFile($fileName, $fileUrl, $attachment = 'attachment')
{

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Type: application/octet-stream');
    if ($attachment == 'inline') {
        header("Content-type: application/pdf");
    }
    header("Content-Transfer-Encoding: Binary");
    header("Content-Disposition: $attachment; filename=\"" . $fileName . "\"");
    ob_end_flush();
    readfile($fileUrl);
    exit;
}

/**
 * This is used to generate number
 *
 * @return array
 */
function generateNumberDropDown($prefix)
{
    $numbers = range(0, 120);
    unset($numbers[0]);

    return array_merge([0 => _lang('select') . ' ' . $prefix . ' ' . _lang('range')], $numbers);
}

/**
 * take_assoc_transpose | it will take a multidimensional associative array and will return a transpose of that array
 * @param array $data | take a multidimensional associative array
 * @return it will return transposed multidimensional array of the input array
 *
 */
function take_assoc_transpose($data)
{
    $first_column = array_keys($data[0]);
    array_unshift($data, null);
    $rest_of_columns = call_user_func_array('array_map', $data);
    foreach ($first_column as $key => $val) {
        array_unshift($rest_of_columns[$key], $val);
    }
    return $rest_of_columns;
}


function get_lang()
{
    $return = 'english';
    if (!empty(session()->get('lang')) && session()->get('lang') != 'english') {
        $return = 'dutch';
    }
    return $return;
}

/**
 * This is language conversion
 *
 * @param $array
 * @return array
 */
function loop_lang_convert($array)
{
    $data = [];
    if (count($array) > 0) {
        if (get_lang() == 'english') {
            return $array;
        } else {
            foreach ($array as $key => $value) {
                $data[$key] = _lang(trim($value));
            }
        }
    } else {
        $data = $array;
    }
    return $data;
}

/**
 * This is used to get drag and drop exercise data
 *
 * @param $extraId
 * @param $planId
 * @param $workoutTypeSetId
 * @param $counter
 * @param $subCounter
 * @return mixed
 */
function getMainworkoutData($extraId, $planId, $workoutTypeSetId, $counter, $subCounter, $isClientPlan = false, $isEdit = 0)
{
    $extraId = explode('_', $extraId);
    $params = [
        'planId' => $planId,
        'dayId' => $extraId[0],
        'structureId' => $extraId[1],
        'workoutSetTypeId' => $workoutTypeSetId,
        'workoutCounter' => $counter,
        'workoutSubCounter' => $subCounter,
        'isEdit' => $isEdit
    ];

    if (!empty($isClientPlan)) {
        $data = ClientPlanDragDropStructure::getDragDropData($params);
    } else {
        $data = PlanDragDropStructure::getDragDropData($params);
    }

    return $data;
}

/**
 * This is used to check main workout or not
 *
 * @param $id
 * @return bool
 */
function isMainWorkout($id)
{
    $isMainWorkout = false;
    if ($id == 2) {
        $isMainWorkout = true;
    }

    return $isMainWorkout;
}

/**
 * This is used to check rest or active rest
 *
 * @param $key
 * @return bool
 */
function isRestOrActiveRest($key)
{
    $isRest = false;
    if ($key == 'rest' || $key == 'active_rest') {
        $isRest = true;
    }

    return $isRest;
}

/**
 * This is string to decimal conversion
 *
 * @param $string
 * @return string
 */
function stringToDecimalConversion($string)
{
    return number_format((float)$string, 2, '.', '');
}

/**
 * Sort one by key by oject
 *
 * @param array $array
 * @param $key
 * @param bool $asc
 * @return array
 */
function sortByOneKeyObject(array $array, $key, $asc = true)
{
    $result = array();
    $values = array();
    $array = json_decode(json_encode($array), true);
    foreach ($array as $id => $value) {
        $values[$id] = isset($value[$key]) ? $value[$key] : '';
    }
    if ($asc) {
        asort($values, SORT_NATURAL | SORT_FLAG_CASE);
    } else {
        arsort($values, SORT_NATURAL | SORT_FLAG_CASE);
    }
    foreach ($values as $index => $value) {
        $result[$index] = (object)$array[$index];
    }

    return $result;
}

/**
 * This is used to prepare plan numbers
 *
 * @param int $count
 * @return array
 */
function preparePlanNumbers($count = 1)
{
    $arr = [];
    for ($i = 1; $i <= 7; $i++) {
        for ($j = 1; $j <= 9; $j++) {
            switch ($i) {
                case 1:
                    if ($j == 1) {
                        $val = '';
                    } else if ($j == 2) {
                        $val = '';
                    } else if ($j == 3) {
                        $val = 1;
                    } else if ($j == 4) {
                        $val = 2;
                    } else if ($j == 5) {
                        $val = 3;
                    } else if ($j == 6) {
                        $val = 4;
                    } else if ($j == 7) {
                        $val = 5;
                    } else if ($j == 8) {
                        $val = 6;
                    } else if ($j == 9) {
                        $val = 7;
                    }
                    $arr[$i][$j] = $val;
                    break;
                case 2:
                    if ($j == 1) {
                        $val = '';
                    } else if ($j == 2) {
                        $val = 1;
                    } else if ($j == 3) {
                        $val = 2;
                    } else if ($j == 4) {
                        $val = 4;
                    } else if ($j == 5) {
                        $val = 6;
                    } else if ($j == 6) {
                        $val = 8;
                    } else if ($j == 7) {
                        $val = 10;
                    } else if ($j == 8) {
                        $val = 12;
                    } else if ($j == 9) {
                        $val = 14;
                    }
                    $arr[$i][$j] = $val;
                    break;
                case 3:
                    if ($j == 1) {
                        $val = 1;
                    } else if ($j == 2) {
                        $val = 2;
                    } else if ($j == 3) {
                        $val = 4;
                    } else if ($j == 4) {
                        $val = 8;
                    } else if ($j == 5) {
                        $val = 12;
                    } else if ($j == 6) {
                        $val = 16;
                    } else if ($j == 7) {
                        $val = 20;
                    } else if ($j == 8) {
                        $val = 24;
                    } else if ($j == 9) {
                        $val = 28;
                    }
                    $arr[$i][$j] = $val;
                    break;
                case 4:
                    if ($j == 1) {
                        $val = 2;
                    } else if ($j == 2) {
                        $val = 4;
                    } else if ($j == 3) {
                        $val = 8;
                    } else if ($j == 4) {
                        $val = 16;
                    } else if ($j == 5) {
                        $val = 24;
                    } else if ($j == 6) {
                        $val = 32;
                    } else if ($j == 7) {
                        $val = 40;
                    } else if ($j == 8) {
                        $val = 48;
                    } else if ($j == 9) {
                        $val = 56;
                    }
                    $arr[$i][$j] = $val;
                    break;
                case 5:
                    if ($j == 1) {
                        $val = 3;
                    } else if ($j == 2) {
                        $val = 6;
                    } else if ($j == 3) {
                        $val = 12;
                    } else if ($j == 4) {
                        $val = 24;
                    } else if ($j == 5) {
                        $val = 36;
                    } else if ($j == 6) {
                        $val = 48;
                    } else if ($j == 7) {
                        $val = 60;
                    } else if ($j == 8) {
                        $val = 72;
                    } else if ($j == 9) {
                        $val = 84;
                    }
                    $arr[$i][$j] = $val;
                    break;
                case 6:
                    if ($j == 1) {
                        $val = 6;
                    } else if ($j == 2) {
                        $val = 12;
                    } else if ($j == 3) {
                        $val = 24;
                    } else if ($j == 4) {
                        $val = 48;
                    } else if ($j == 5) {
                        $val = 72;
                    } else if ($j == 6) {
                        $val = 96;
                    } else if ($j == 7) {
                        $val = 120;
                    } else if ($j == 8) {
                        $val = 144;
                    } else if ($j == 9) {
                        $val = 168;
                    }
                    $arr[$i][$j] = $val;
                    break;
                default:
                    if ($j == 1) {
                        $val = 12;
                    } else if ($j == 2) {
                        $val = 26;
                    } else if ($j == 3) {
                        $val = 52;
                    } else if ($j == 4) {
                        $val = 104;
                    } else if ($j == 5) {
                        $val = 156;
                    } else if ($j == 6) {
                        $val = 208;
                    } else if ($j == 7) {
                        $val = 260;
                    } else if ($j == 8) {
                        $val = 312;
                    } else if ($j == 9) {
                        $val = 364;
                    }
                    $arr[$i][$j] = $val;
            }

        }
    }

    return $arr;
}

/**
 * This is used to get plan numbers
 *
 * @param int $j
 * @param int $key
 * @param $array
 * @return string
 */
function getPlanNumbers($j = 1, $key = 1, $array)
{
    $val = '';
    if (!empty($array[$key][$j])) {
        $val = $array[$key][$j];
    }

    return $val;
}

/**
 * Round any fractional value to whole number
 */
function roundValue($val, $precision = 0)
{
  return round($val, $precision);
}


/**
 * This is used to get final price value
 *
 * @param $array
 * @param $index
 * @param $key
 * @return string
 */
function getFinalPrice($array, $index, $key)
{
    $val = '';
    if (!empty($array[$index])) {
        $val = $array[$index]['final_price_' . $key];
    }
    if ($val == 0) {
        $val = '';
    }

    return $val;
}
/*
 * get Total Plans
 */
function getWeekDays($key, $keyDay)
{
    $val = 0;
    $arr = [
        '1' => '1',
        '2' => '4',
        '3' => '8',
        '4' => '12',
        '5' => '24',
        '6' => '48'
    ];
    if (!empty($arr[$key])) {
        $val = $arr[$key];
    }

    return $keyDay * $val;
}

/*
 * Convert Decimal To integer day plan ids
 */
function getDayParseId($key)
{
    if ($key == 0.25)
        $key = 250;
    if ($key == 0.5)
        $key = 500;

    return (int)$key;
}

/**
 * This is used to check if decimal number
 *
 * @param $val
 * @return bool
 */
function is_decimal( $val )
{
    return is_numeric( $val ) && floor( $val ) != $val;
}

/**
 * This is used to check block time slot
 *
 * @param $blockTimeSlots
 * @param $dayId
 * @param $currentTimeStamp
 * @return bool
 */
function isBlockTimeSlot($blockTimeSlots, $dayId, $currentTimeStamp, $currentDate, $isArray = false, &$arrUniqueBlockedSlots = [])
{
    $isBlocked = false;
    $arrTemp = $arrReturn = $blockTimeSlotsRows = [];
    $startTime = strtotime('23:45');
    $endTime = strtotime('00:00');
    if(!empty($blockTimeSlots[$dayId])) {
        $blockTimeSlotsRows = $blockTimeSlots[$dayId];
        foreach ($blockTimeSlotsRows as $row) {
            if (strtotime($currentDate) >= strtotime($row['start_date']) && strtotime($currentDate) <= strtotime($row['end_date']) && ($currentTimeStamp >= strtotime($row['start_time']) && $currentTimeStamp < strtotime($row['end_time']) || ($currentTimeStamp == $startTime && strtotime($row['start_time']) == $startTime && strtotime($row['end_time']) == $endTime))) {
                $isBlocked = true;
                break;
            }
        }
    }

    if (!empty($isBlocked) && !empty($isArray)) {
        if(empty($arrUniqueBlockedSlots[$row['id']][$dayId])) {
            $arrTemp['day_id'] = $row['day_id'];
            $arrTemp['start_time'] = $row['start_time'];
            $arrTemp['end_time'] = $row['end_time'];
            $arrUniqueBlockedSlots[$row['id']][$dayId] = $arrTemp;
            $rowSpan = (((strtotime($row['end_time']) - strtotime($row['start_time'])) / 60) / 15) + 1;
            $isText = 'Click here to edit or delete';
        } else {
            $rowSpan = 0;
            $isText = '';
        }
        $arrReturn['is_blocked'] = $isBlocked;
        $arrReturn['row_span'] = $rowSpan;
        $arrReturn['id'] = $row['id'];
        $arrReturn['is_text'] = $isText;
    }
    if (!empty($isArray)) {
        return $arrReturn;
    }



    return $isBlocked;
}

/**
 * This is used to check client booked by user
 *
 * @param $arrBooking
 * @param $currentTimeStamp
 * @param $currentDate
 * @return string
 */
function isBookedTimeSlot($arrBooking, $currentTimeStamp, $currentDate, &$arrBookingSlot)
{
    $booking = $color = '';
    $rowSpan = 0;
    if (!empty($arrBooking)) {
        $services = Service::pluck('name', 'id')->toArray();
        foreach ($arrBooking as $row) {
            if (strtotime($row['booking_date']) == strtotime($currentDate) && $currentTimeStamp >= strtotime($row['start_time']) && $currentTimeStamp < strtotime($row['end_time'])) {
                if (empty($arrBookingSlot[$row['id']])) {
                    $arrBookingSlot[$row['id']]['id'] = $row['id'];
                    $arrBookingSlot[$row['id']]['is_show'] = true;
                    $booking .= $services[$row['service_id']] . '<br/>';
                    $booking .= 'Time: '.$row['start_time'] . '-' . $row['end_time'] . '<br/>';
                    $booking .= 'Date: '.dateFormat($row['booking_date']).'<br/>';
                    $firstName = $lastName = '';
                    $objUser = User::find($row['user_id']);
                    if (!empty($objUser)) {
                        $firstName = $objUser->first_name;
                        $lastName = $objUser->last_name;
                    }
                    $booking .= 'Client: '.$firstName.' '.$lastName;
                } elseif (!empty($arrBookingSlot[$row['id']]) && $arrBookingSlot[$row['id']]['is_show'] == true) {
                    $arrBookingSlot[$row['id']]['is_show'] = false;
                }
                $color = 'yes';
            }
        }
    }

    return compact('booking', 'rowSpan', 'color');
}

/**
 * This is used to get total sessions
 *
 * @param $week
 * @param $dayValue
 * @return int
 */
function getTotalSessions($week,$dayValue){

    return (int)($week * $dayValue);
}

/**
 * This is used to change date format
 *
 * @param $date
 * @return false|string 
 */
function dateFormat($date)
{
   $dateReturn = '00/00/0000';
    if (!empty($date) && strtotime($date) > 0 && $date !== '0000-00-00') {
        $dateReturn = date_format(new \DateTime($date), 'd/m/Y');
    }
    return $dateReturn;
}

/**
 * This is used to prepared array
 *
 * @param $array
 * @param $index
 * @param $value
 * @param $finalPricesList
 */
function preparedArray($array, $index, $value, &$finalPricesList)
{
    foreach ($array as $row) {
        $finalPricesList[$row . '_' . $index] = $value;
    }
}

/**
 * This is used to get pay pal details key
 *
 * @return array
 */
function payPalDetails()
{
    $arr = [];
    $arr['sandbox_client_id'] = getenv('SANDBOX_CLIENT_ID');
    $arr['live_client_id'] = getenv('LIVE_CLIENT_ID');

    return $arr;
}
function getAgeFromBirthday($birthday){

    $arr = [];
    $birthday = new DateTime($birthday);
    $currentDate =  new DateTime();
    $interval = date_diff($birthday, $currentDate);
    $arr['years'] =  $interval->format('%y');
    $arr['months'] =  $interval->format('%m');
    $age = $arr['years'] . ' years & ' . $arr['months'] . ' months';
    return $age;
}
function getAge($dob,$condate){
    $birthdate = new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $dob))))));
    $today= new DateTime(date("Y-m-d",  strtotime(implode('-', array_reverse(explode('/', $condate))))));
    $age = $birthdate->diff($today)->y;

    return $age;
}
function getKgToPound($weightPrevious,$weightPreviousUnit,$weightUnit,$weight){
    $newWeight = $weight;
    if(!empty($weightPrevious)){
        if (strtolower($weightUnit) == 'kg') {
            if ($weightPreviousUnit == 'lb') {
                $newWeight = ($weightPrevious / 2.20462);
            }
        } else if (strtolower($weightUnit) == 'lb') {
            if ($weightPreviousUnit == 'kg') {
                $newWeight = ($weightPrevious * 2.20462);
            }
        }
    }

    return $newWeight;
}
function getServicePercentage(){
    return 0.12;
}

function getLoginUserImage()
{
    $image = null;
    if (\Auth::check())
        $image = clientImagePath . '/' . \Auth::user()->profile_pic_upload;

    return $image;
}

/**
 * This is used to check user have access or not of entity
 *
 * @param $firstId
 * @param $secondId
 * @return bool
 */
function isAccess($firstId, $secondId)
{
    $access = false;
    if ($firstId === $secondId) {
        $access = true;
    }

    return $access;
}

/**
 * This is used to check whether have to display data or not on the production server
 *
 * @return bool
 */
function isHide()
{
    $isHide = 1;
    $environment = getenv('APP_ENV');
    if ($environment == 'production') {
        $isHide = 0;
    }
    return $isHide;
}
function getFirstAndLastName($fullName){
    $name = explode(' ', $fullName);
    $arr = [];
    $arr['first_name'] = '';
    $arr['last_name'] = '';
    if (!empty($name)) {
        $arr['first_name'] = $name[0];
        if (count($name) >= 2) {
            for ($i = 1; $i < count($name); $i++) {
                if ($i == 1) {
                    $arr['last_name'] = $name[$i];
                } else {
                    $arr['last_name'] = $arr['last_name'] . ' ' . $name[$i];
                }
            }
        }
    }
    return $arr;
}

/**
 * This is used to save pdf for transactions in folder
 *
 * @param $fileName
 * @param $htmlForPdfs
 * @return string
 */
function createPdf($fileName, $htmlForPdfs)
{
    $dir = public_path('data/receipt/');
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    $fileName = 'test.pdf';
    $fileFullPathWithName = $dir . $fileName;


    $pdf = new Pdf(array(
        'no-outline',         // Make Chrome not complain
        'page-size' => 'A4',
//        'margin-top'    => 10,
//        'margin-right'  => 10,
//        'margin-bottom' => 10,
//        'margin-left'   => 10,
//        'page-size'     => 'letter',
//        'zoom'          => 0.6667,
//        'page-height'     => 279.4,
        'encoding' => 'UTF-8',

        // Default page options
        'disable-smart-shrinking',
    ));
//    $pdf->binary = 'C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe';
//    if (!\App::isLocal()) {
//        $pdf->binary = '/usr/bin/wkhtmltopdf';
//    }
// Add a page. To override above page defaults, you could add
// another $options array as second argument.
//    echo $htmlForPdfs; exit;

    $pdf->addPage($htmlForPdfs);

    if (!$pdf->send()) {
        $error = $pdf->getError();
    }

    return $fileName;
}

function uniqueFileName($path, $fileName)
{
    if ($pos = strrpos($fileName, '.')) {
        $name = substr($fileName, 0, $pos);
        $ext = substr($fileName, $pos);
    } else {
        $name = $fileName;
    }
    $fileName = str_replace(' ', '_', $fileName);
    $newPath = $path . '/' . $fileName;
    $newName = $fileName;
    $counter = 0;
    while (file_exists($newPath)) {
        $newName = $name . '_' . $counter . $ext;
        $newPath = $path . '/' . $newName;
        $counter++;
    }

    return $newName;
}
function getIncremetMonthDate(){
    $date = strtotime(currentDateTime());
    $month = date("m", strtotime(currentDateTime()));
    $year = date("Y", strtotime(currentDateTime()));
    if ($month == 12) {
        $month = 0;
    }
    $month++;
    $arrMonths = ['1' => 31, '2' => 28, '3' => 31, '4' => 30, '5' => 31, '6' => 30, '7' => 31, '8' => 31, '9' => 30, '10' => 31, '11' => 30, '12' => 31];
    $incrementDyasValue = $arrMonths[(int)$month];
    if ($year % 4 == 0) {
        if ($month == 2) {
            $incrementDyasValue = 29;
        }
    }
    $incrementDays = '+' . $incrementDyasValue . ' days';
    $newDate = date("Y-m-d", strtotime($incrementDays, $date));

    return $newDate;
}

/**
 * This is used to get user image path
 *
 * @param $image
 * @param bool $isShowDefault
 * @return string
 */
function getUserImagePath($image, $isShowDefault = true)
{
    $url = asset('assets/images/profile-pic.png');
    if (!empty($image) && !empty($isShowDefault)) {
        $url = asset(MobileUserImagePath . '/' . $image);
    }

    return $url;
}

/**
 * This is used to get version
 *
 * @return int
 */
function version()
{
    return 23;
}

/**
 * This is used to check which version is using
 *
 * @return int
 */
function isLightVersion()
{
    $isLightVersion = 0;
    $environment = getenv('APP_ENV');
//    $environment = 'staging';
    if ($environment == 'staging' || $environment == 'production') {
        $isLightVersion = 1;
    }

    return $isLightVersion;
}
function getStartAndEndDate($week, $year) {
    $dto = new DateTime();
    $dto->setISODate($year, $week);
    for ($i = 1;$i<=7;$i++){
        $ret[$i] = $dto->format('Y-m-d');
        $dto->modify('+1 days');
    }

    return $ret;
}
