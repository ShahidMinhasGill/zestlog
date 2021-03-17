<?php


namespace App\Traits;
use App\Models\ClientCurrency;
use App\Models\ClientSelectedEquipment;
use App\Models\DraftEquipmentPlan;
use App\Models\DraftPlan;
use App\Models\DraftPlanDragDropStructure;
use App\Models\DraftPlanTrainingComment;
use App\Models\DraftPlanTrainingOverviewWeek;
use App\Models\DraftPlanWeekTrainingSetup;
use App\Models\DraftPlanWeekTrainingSetupPosition;
use App\Models\DraftTempTrainingSetup;
use App\Models\EquipmentPlan;
use App\Models\PricingDiscount;
use App\Models\RepeatProgramPurchase;
use App\Models\RepeatProgramPurchaseBooking;
use App\Models\ServiceBooking;
use App\Models\TrainingPlan;
use App\Models\TrainingProgramPrice;
use App\Models\TrainingProgramPriceSetup;
use App\Models\WeekProgram;
use App\User;
use function Couchbase\defaultDecoder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use function Matrix\identity;
use Twilio\Rest\Client;
use App\Models\Goal;
use App\Models\DayPlan;
use App\Models\BodyPart;
use App\Models\BodyPartExercise;
use App\Models\Equipment;
use Illuminate\View\View;
use App\Models\TrainingAge;
use App\Models\AgeCategory;
use App\Models\TrainingDay;
use App\Models\Plan;
use App\Models\DownloadProgram;
use App\Models\PlanTrainingOverviewWeek;
use App\Models\TrainingPlanStructure;
use App\Models\Exercise;
use App\Models\PlanDragDropStructure;
use Intervention\Image\Facades\Image as Image;
use App\Models\PlanWeekTrainingSetup;
use App\Models\Day;
use App\Models\TargetMuscle;
use App\Models\TrainingForm;
use App\Models\Discipline;
use App\Models\Level;
use App\Models\Priority;
use App\Models\UserMainWorkoutPlan;
use PragmaRX\Countries\Package\Countries;
use Edujugon\PushNotification\PushNotification;
use App\Models\ServiceAvailableBooking;
use App\Models\Service;
use App\Models\TrainingSessionLocation;
use App\Models\TrainingCoachingSession;
use App\Models\TrainingCoachingSessionLength;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use App\Models\Notification;
use App\Models\PlanWeekTrainingSetupPosition;
use App\Models\TempTrainingSetup;
use App\Models\PlanTrainingComment;
use App\Models\Client\ClientTempTrainingSetup;
use App\Models\Client\ClientPlanTrainingComment;

trait ZestLogTrait
{
    public $userId;
    public $data = [];
    public $dataDiet = [];
    public $params = [];
    public $message = '';
    public $success = false;
    public $statusCode = 200;
    private $successCode = 200;
    private $errorCode = 200;
    public $planId = 0;
    public $dayId = 0;
    public $dayPlanId = 0;
    public $structureId = 0;
    public $exerciseId   = 0;
    public $file = '';
    public $uploadPath = '';
    public $fileName = '';
    public $isEmptySelect = '';
    public $isEmptyAll = false;
    public $isEquipmentEmptySelect = true;
    Private $emptySelect = [];
    private $perPage = 10;
    public $isMainWorkout = false;
    public $trainingPlanId = 0;
    public $workoutSetTypeId = 0;
    public $error = false;
    public $isRedirect = false;
    public $dragDropId = 0;
    public $isTrainingDay = false;
    public $finalPricesDb = false;
    public $type = '0';
    protected $deviceTokens = [];
    protected $deviceType = '';
    protected $notificationTitle = '';
    protected $notificationMessage = '';
    protected $extraPayLoad = [];
    protected $logMessage = '';
    protected $badge = 0;
    protected $discountTotalPercentage = 0;
    protected $discountTotalAmount = 0;
    protected $requiredImageWidth = 640;
    protected $requiredImageHeight = 640;
    protected $originalImageWidth = 0;
    protected $originalImageHeight = 0;
    protected $newImageWidth = 0;
    protected $newImageHeight = 0;
    protected $oneDayId = 8;
    protected $passportToken = '';
    protected $isEdit = 0;

    /**
     * This is used to set user id
     */
    public function getUserId()
    {
        if (empty($this->userId)) {
            $this->userId = \Auth::user()->id;
        }
    }

    /**
     * This is used to set user id
     *
     * @param $request
     */
    public function setUserId($request)
    {
        $this->userId = $request->user()->id;
    }

    /**
     * This is used to add empty select in filters
     */
    public function emptySelect()
    {
        if ($this->isEmptySelect) {
            $this->emptySelect[''] = 'Select';
        } else if($this->isEmptyAll) {
            $this->emptySelect[''] = 'All';
        }
    }
/*
 * this is use to get Exercise Filters
 */
    public function getExerciseFilters(){
        $this->emptySelect();
        $this->data['body_parts'] = $this->emptySelect + BodyPartExercise::pluck('name', 'id')->toArray();
        $this->data['target_muscles'] = $this->emptySelect + TargetMuscle::pluck('name', 'id')->toArray();
        $this->data['equipment'] = $this->emptySelect + Equipment::pluck('name', 'id')->toArray();
        $this->data['training_forms'] = $this->emptySelect + TrainingForm::pluck('name', 'id')->toArray();
        $this->data['discipline'] = $this->emptySelect + Discipline::pluck('name', 'id')->toArray();
        $this->data['level'] = $this->emptySelect + Level::pluck('name', 'id')->toArray();
        $this->data['priority'] = $this->emptySelect + Priority::pluck('name', 'id')->toArray();
    }
/*
 * this is use to get Exercise filters without All
 */
    public function getFilters(){
        $this->data['body_parts'] =  BodyPartExercise::pluck('name', 'id')->toArray();
        $this->data['target_muscles'] = TargetMuscle::pluck('name', 'id')->toArray();
        $this->data['equipment'] =  Equipment::pluck('name', 'id')->toArray();
        $this->data['training_forms'] =  TrainingForm::pluck('name', 'id')->toArray();
        $this->data['discipline'] = Discipline::pluck('name', 'id')->toArray();
        $this->data['level'] =  Level::pluck('name', 'id')->toArray();
        $this->data['priority'] = Priority::pluck('name', 'id')->toArray();
    }
    /**
     * This is used to get plan filters
     */
    public function getPlanFilters()
    {
        $this->emptySelect();
        $this->data['goals'] = $this->emptySelect + Goal::pluck('name', 'id')->toArray();
        $this->data['training_days'] = [''] + TrainingDay::pluck('name', 'id')->toArray();
//        $this->data['equipments'] = (($this->isEquipmentEmptySelect) ? $this->emptySelect : []) + Equipment::pluck('name', 'id')->toArray();//older code
        $this->data['equipments'] = $this->emptySelect + Equipment::pluck('name', 'id')->toArray();
        $this->data['training_ages'] = $this->emptySelect + TrainingAge::pluck('name', 'id')->toArray();
        $this->data['age_categories'] = $this->emptySelect + AgeCategory::pluck('name', 'id')->toArray();
        $this->data['body_parts'] = $this->emptySelect + BodyPart::pluck('name', 'id')->toArray();
        $this->data['day_plans'] = $this->emptySelect + DayPlan::pluck('name', 'id')->toArray();
        $this->data['target_muscles'] = $this->emptySelect + TargetMuscle::pluck('name', 'id')->toArray();
        $this->data['training_forms'] = $this->emptySelect + TrainingForm::pluck('name', 'id')->toArray();
        $this->data['days'] = Day::pluck('name', 'id')->toArray();

        $gender = $accessType = [];
        $accessType['private'] = 'Private';
        $accessType['public'] = 'Public';
        $this->data['access_type'] = $this->emptySelect + $accessType;

        $gender['male'] = 'Male';
        $gender['female'] = 'Female';
        $this->data['gender'] = $this->emptySelect + $gender;
    }

    /**
     * This is used to get exercises filter
     */
    public function getExerciseFilter()
    {
        $this->emptySelect();
        $this->data['exercise_body_parts'] = $this->emptySelect + BodyPartExercise::pluck('name', 'id')->toArray();
        $this->data['exercise_target_muscles'] = $this->emptySelect + TargetMuscle::pluck('name', 'id')->toArray();
        $this->data['exercise_equipments'] = $this->emptySelect + Equipment::pluck('name', 'id')->toArray();
        $this->data['exercise_training_forms'] = $this->emptySelect + TrainingForm::pluck('name', 'id')->toArray();
    }

    /**
     * This is used to get end users filters
     */
    public function getEndUserFilters()
    {
        $this->emptySelect();
        $this->data['training_days'] = $this->emptySelect + TrainingDay::pluck('name', 'id')->toArray();
        $this->data['equipments'] = $this->emptySelect + Equipment::pluck('name', 'id')->toArray();
        $this->data['training_ages'] = $this->emptySelect + TrainingAge::pluck('name', 'id')->toArray();
        $this->data['age_categories'] = $this->emptySelect + AgeCategory::pluck('name', 'id')->toArray();
        $this->data['body_parts'] = $this->emptySelect + BodyPart::pluck('name', 'id')->toArray();
        $this->data['day_plans'] = $this->emptySelect + DayPlan::pluck('name', 'id')->toArray();
        $this->data['days'] = $this->emptySelect + Day::pluck('name', 'id')->toArray();

        $gender = $accessType = [];
        $accessType[1] = 'Private';
        $accessType[0] = 'Public';
        $this->data['access_type'] = $this->emptySelect + $accessType;

        $gender['male'] = 'Male';
        $gender['female'] = 'Female';
        $this->data['gender'] = $this->emptySelect + $accessType;
    }


    /**
     * This is used to get search filters for plans
     */
    public function getPlanSearchFilters()
    {
        $this->data['goals'] = Goal::select('id', 'name as value')->get()->toArray();
        $this->data['training_days'] = TrainingDay::select('id', 'name as value')->get()->toArray();

        $this->data['equipments'] = Equipment::select('id', 'name as value')->get()->toArray();

        $this->data['training_ages'] = TrainingAge::select('id', 'name as value')->get()->toArray();

        $this->data['age_categories'] = AgeCategory::select('id', 'name as value')->get()->toArray();

        $this->data["gender"][0]["id"] = "m";
        $this->data["gender"][0]["value"] = "Male";
        $this->data["gender"][1]["id"] = "f";
        $this->data["gender"][1]["value"] = "Female";
    }

    /**
     * @param $message
     * @param $recipients
     * @return \Twilio\Rest\Api\V2010\Account\MessageInstance
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function sendMessage($message, $recipients)
    {
        return 1;
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $flag = $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);

        return $flag;
    }

    /**
     * This is used to get download program data
     */
    public function getDownloadProgramData()
    {
        $this->params['plan_id'] = $this->planId;
        $this->params['day_id'] = $this->dayId;
        $data = DownloadProgram::getDownloadProgramData($this->params);
        $this->data = json_decode(json_encode($data), true);
        $bodyParts = BodyPart::pluck('name', 'id')->toArray();
        if ($this->data) {
            foreach ($this->data as $key => $row) {
                if(!empty($bodyParts[$row['body_part_1']])) {
                    $this->data[$key]['body_parts'] = $bodyParts[$row['body_part_1']];
                    if (!empty($bodyParts[$row['body_part_2']]))
                        $this->data[$key]['body_parts'] .= ',' . $bodyParts[$row['body_part_2']];
                    if (!empty($bodyParts[$row['body_part_3']]))
                        $this->data[$key]['body_parts'] .= ',' . $bodyParts[$row['body_part_3']];
                } else {
                    $this->data[$key]['body_parts'] = '';
                }
                $this->data[$key]['profile_pic_upload'] = getUserImagePath($row['profile_pic_upload']);
                unset($this->data[$key]['body_part_1'], $this->data[$key]['body_part_2'], $this->data[$key]['body_part_3']);
            }
        }
    }

    public function uploadImage($file,$exercisePath)
    {
        $extension = $file->guessExtension();
        $fileName = createImageUniqueName($extension);

        $img = Image::make($file);

        $destinationPath = public_path($exercisePath);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $img->resize(null, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $fileName);
        $this->success = true;
        return $fileName;
    }
    public function uploadVedio($file,$exercisePath){
        $extension = $file->guessExtension();
        $fileName = createImageUniqueName($extension);
        $destinationPath = public_path($exercisePath);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        return $fileName;
    }

    /**
     * This is used to check main workout
     */
    public function isMainWorkOut()
    {
        if ($this->structureId == 2) {
            $this->isMainWorkout = true;
        }
    }

    /**
     * This is used to get day plan id
     */
    public function getDayPlanId()
    {
        $this->dayPlanId = DayPlan::where('key_value', 'like', 'training')->first()->id;
    }

    /**
     * This is used to check training day or not
     */
    public function isTrainingDay()
    {
        $this->isTrainingDay = false;
        $obj = DayPlan::find($this->dayPlanId);
        if ($obj && $obj->key_value == 'training') {
            $this->isTrainingDay = true;
        }
    }


    public function insertPlanData()
    {
        exit;
        $age_categories = [
            [
                'name' => 'Below 20',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '20 - 29',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '30 - 39',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '40 - 49',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '50 - 59',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'name' => '60 & Above',
                'meta_data' => '',
                'meta_description' => '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ]
        ];
        DB::table('age_categories')->insert($age_categories);

        $this->data[0]['user_id'] = 133;
        $this->data[0]['plan_id'] = 1;
        $this->data[0]['training_plan_id'] = 14;
        $this->data[0]['workout_set_type_id'] = 1;
        $this->data[0]['data']['rep_id']= 1;
        $this->data[0]['data']['rm_id'] = 1;
        $this->data[0]['data']['rep_value'] = 10;
        $this->data[0]['data']['rm_value'] = 30;
        $this->data[0]['data']['workout_counter'] = 1;
        $this->data[0]['data']['workout_sub_counter'] = 1;

        $this->data[1]['user_id'] = 133;
        $this->data[1]['plan_id'] = 1;
        $this->data[1]['training_plan_id'] = 13;
        $this->data[1]['workout_set_type_id'] = 1;
        $this->data[1]['data']['rep_id']= 2;
        $this->data[1]['data']['rm_id'] = 3;
        $this->data[1]['data']['rep_value'] = 15;
        $this->data[1]['data']['rm_value'] = 60;
        $this->data[1]['data']['workout_counter'] = 2;
        $this->data[1]['data']['workout_sub_counter'] = 1;


        echo json_encode($this->data); exit;
//        UserMainWorkoutPlan::
    }
    /*
     * Update Users Profiles
     */
    public function updateProfiles($request,$id,$imagePath){
        $obj = User::find($id);
        if ($obj) {
            //todo need to add backend validation for images and other fields
            $this->data = $request->all();
            if (empty($request->input('password'))) {
                unset($this->data['password']);
            } else {
                $this->data['password'] = \Hash::make($request->input('password'));
            }
            if (!empty($this->data['profile_pic_upload'])) {
                $file = $this->data['profile_pic_upload'];
                $extension = $file->guessExtension();
                $fileName = createImageUniqueName($extension);
                $img = Image::make($file);
                $destinationPath = public_path($imagePath);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $img->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $fileName);
                //todo need to delete existing image
                $this->data['profile_pic_upload'] = $fileName;
                $this->success = true;
            }
            unset($this->data['email']);
            $obj->update($this->data);
            \Session::flash('success', 'Account has been updated successfully.');
            \Session::flash('alert-class', 'alert-success');
        }

        return ;
    }
    public function editProfiles($id,$imagePath){
        $user = User::find($id);
        $c = new Countries();
        $allCountries = $c->all();
        $countries = [];
        foreach ($allCountries as $country) {
            $countries[$country->cca3] = $country->name->common;
        }
        $cities = [];
        if (!empty($user->country)) {
            $record = $c->where('cca3', $user->country)
                ->first()
                ->hydrate('cities')
                ->cities->toArray();
            $record = array_values($record);
            foreach ($record as $city) {
                $cities[$city['ne_id']] = $city['name'];
            }

        }
        if (!empty($user->profile_pic_upload)) {
            $user->profile_pic_upload = \URL::to('/') . '/' . $imagePath . '/' . $user->profile_pic_upload;
        }
        return [$user,$countries,$cities];
    }

    /**
     * This is used to get start dates from week id and year
     *
     * @param $week
     * @param $year
     * @return array
     */
    public function getStartAndEndDate($week, $year)
    {
        $arr = [];
        $dto = new \DateTime();
        $dto->setISODate($year, $week);
        $startDate = $dto->format('Y/m/d');
        $arr[] = $startDate;
        for ($i = 1; $i <= 6; $i++) {
            $dto->modify('+1 days');
            $arr[] = date('Y/m/d', strtotime($startDate . ' +' . $i . ' days'));
        }
        return $arr;
    }

    /**
     * this is used to get final price From Training Programme Setup
     * @param $clientId
     * @param $serviceId
     * @param $weekProgramId
     * @param $trainingPlanId
     * @return mixed
     */
    public function getFinalServicePrice($clientId, $serviceId, $weekProgramId, $trainingPlanId)
    {
        $finalPrice = 0;
        $dayDiscount = 0;
        $weekDiscount = 0;
        $weekProgram = 0;
        $trainingplan = 0;
        $trainingProgramPriceSetupId = TrainingProgramPriceSetup::
        where('user_id', '=', $clientId)
            ->where('type', '=', $serviceId)
            ->first();
        if(!empty($trainingProgramPriceSetupId)){
            $finalPrices = TrainingProgramPrice::where('training_program_price_setup_id', '=', $trainingProgramPriceSetupId->id)
                ->where('type', '=', $serviceId)
                ->where('training_plan_id', '=', $trainingPlanId)
                ->first();
            $finalPrice = $finalPrices['final_price_' . $weekProgramId];
            $discountDayObj = PricingDiscount::select('discount')
            ->where('training_program_price_setup_id', '=', $trainingProgramPriceSetupId->id)
                ->where('type', '=', $serviceId)
                ->where('training_plan_id', '=', $trainingPlanId)
                ->where('is_checked', '=', 1)
                ->where('discount_type', '=', 2)
                ->first();
            $discountWeekObj = PricingDiscount::select('discount')
                ->where('training_program_price_setup_id', '=', $trainingProgramPriceSetupId->id)
                ->where('type', '=', $serviceId)
                ->where('day_week_id', '=', $weekProgramId)
                ->where('is_checked', '=', 1)
                ->where('discount_type', '=', 1)
                ->first();
            if (!empty($discountDayObj)) {
                $discountDayObj = $discountDayObj->toArray();
                if (isset($discountDayObj['discount'])) {
                    $dayDiscount = $discountDayObj['discount'];
                }
            }
            if (!empty($discountWeekObj)) {
                $discountWeekObj = $discountWeekObj->toArray();
                if (isset($discountWeekObj['discount'])) {
                    $weekDiscount = $discountWeekObj['discount'];
                }
            }
            $this->discountTotalPercentage = ($dayDiscount)+($weekDiscount);
            $objWeekData = WeekProgram::select('meta_data')
                ->where('id',$weekProgramId)
                ->first();
            if ($objWeekData) {
                $objWeekData = $objWeekData->toArray();
                $weekProgram = $objWeekData['meta_data'];
            }
            $objPlanData = TrainingPlan::select('days_value')
                ->where('id', $trainingPlanId)
                ->first();
            if ($objPlanData) {
                $objPlanData = $objPlanData->toArray();
                $trainingplan = $objPlanData['days_value'];
            }

            $totalPlans = ($weekProgram * $trainingplan);
            if (!empty($trainingProgramPriceSetupId))
                $beforeDiscountAmount = ($totalPlans * $trainingProgramPriceSetupId->base_price);
            $this->discountTotalAmount = roundValue($beforeDiscountAmount - $finalPrice);
        }

       $finalPrice = roundValue($finalPrice);
        return $finalPrice;
    }

    /**
     * this is used to get final price From Training Programme Setup
     * @param $clientId
     * @param $serviceId
     * @param $weekProgramId
     * @param $trainingPlanId
     * @return mixed
     */
    public function getFinalServicePriceUsingFormulas($clientId, $serviceId, $uniqueId, $userId)
    {
        $totalPrice = 0;
        $trainingProgramPriceSetupId = TrainingProgramPriceSetup::
        where('user_id', '=', $clientId)
            ->where('type', '=', $serviceId)
            ->first();
        if(!empty($trainingProgramPriceSetupId)){
            $basePriceOnePlan = $trainingProgramPriceSetupId->base_price;                                       // a
            $weekRepeatUseCostPercentage = $trainingProgramPriceSetupId->repeat_percentage_value;               // d
            $basePriceOneWeekPlan = $repeatPurchaseOneBooking = $discountNumberPurchaseRepeat = 0;
            $pricingWeekDataObj = PricingDiscount::where('training_program_price_setup_id', $trainingProgramPriceSetupId->id)
                ->where('discount_type', 1)// 1 for week data from pricing discount table
                ->get()->toArray();

            if(!empty($pricingWeekDataObj)){
                $serviceBookingObj = ServiceBooking::select('tp.days_value',
                    'wp.meta_data as training_week_length',
                    'wp.id as week_length_id',
                    'ctp.meta_data as change_training_plan',
                    'wp.meta_data as change_week_program')
                    ->join('training_plans as tp', 'tp.id', '=', 'service_bookings.training_plan_id')
                    ->join('change_training_plans as ctp', 'ctp.id', '=', 'service_bookings.change_training_plan_id')
                    ->join('week_programs as wp', 'wp.id', '=', 'service_bookings.week_id')
                    ->where('user_id', $userId)
                    ->where('client_id', $clientId)
                    ->where('unique_id', $uniqueId)
                    ->where('service_id', $serviceId)
                    ->first();
                if (!empty($serviceBookingObj)) {
                    $basePriceOneWeekPlan = $basePriceOnePlan * ($serviceBookingObj->days_value); // c = (a*b) days_value = b
                    $changeTrainingPlan = $serviceBookingObj->change_training_plan;             // g
                    $trainingWeekLength = $serviceBookingObj->training_week_length;               // f
                    if($changeTrainingPlan == '1'){
                        $repeatPurchaseOneBooking = ($trainingWeekLength/$trainingWeekLength);     // h = f/f     when no change selected
                    }else{
                        $repeatPurchaseOneBooking = ($trainingWeekLength / $changeTrainingPlan);     // h = f/g
                    }
                    $objRepeatProgramPurchaseId = RepeatProgramPurchase::select('id')
                        ->where('meta_data', $repeatPurchaseOneBooking)
                        ->first();
                    if(!empty($objRepeatProgramPurchaseId)){
                        $objRepeatPurchaseBooking = RepeatProgramPurchaseBooking::select('discount_' . $objRepeatProgramPurchaseId->id)
                            ->where('user_id', $clientId)
                            ->where('training_program_price_setup_id', $trainingProgramPriceSetupId->id)
                            ->where('type',$serviceId)
                            ->first();
                        if (!empty($objRepeatPurchaseBooking)) {
                            $objRepeatPurchaseBooking = $objRepeatPurchaseBooking->toArray();
                            $discountNumberPurchaseRepeat = $objRepeatPurchaseBooking['discount_' . $objRepeatProgramPurchaseId->id]; // i
                            $discountNumberOfPurchase = ($basePriceOneWeekPlan * $discountNumberPurchaseRepeat) / 100;                   // j = c*i%
                            $oneWeekProgramBasePriceAfterDiscount = ($basePriceOneWeekPlan - $discountNumberOfPurchase);          // k =c-j
                            $weeklyRepeatUseCost = (($weekRepeatUseCostPercentage / 100) * $oneWeekProgramBasePriceAfterDiscount);            // e =d*k
                            $totalPriceBeforeLengthDiscount = ($oneWeekProgramBasePriceAfterDiscount * $repeatPurchaseOneBooking) + ($weeklyRepeatUseCost * ($trainingWeekLength - $repeatPurchaseOneBooking));  // l=(k*h)+(e*(f-h))
                            $pricingWeekDataObjArrayCoulm = array_column($pricingWeekDataObj, null, 'day_week_id');
                            $discountForLengthOfProgramPercentage = $pricingWeekDataObjArrayCoulm[$serviceBookingObj->week_length_id]['discount']; // m
                            $discountForLengthOfProgram = ($totalPriceBeforeLengthDiscount * ($discountForLengthOfProgramPercentage / 100));  // n = L * m  // 100 for percentage
                            $totalPrice = ($totalPriceBeforeLengthDiscount - $discountForLengthOfProgram); // o = L - n

                            $this->discountTotalPercentage = $discountNumberPurchaseRepeat + $discountForLengthOfProgramPercentage;
                            $this->discountTotalAmount = roundValue($discountNumberOfPurchase + $discountForLengthOfProgram) ;
                        }
                    }

                }
            }

        }

        $totalPrice = roundValue($totalPrice);

        return $totalPrice;
    }

    public function getClientCurrency($clientId)
    {
        $objClientCurrency = ClientCurrency::select('c.code','c.name','c.id')
            ->where('client_id',$clientId)
            ->join('currencies as c', 'c.id', '=', 'client_currencies.currency_id')
            ->first();
        if ($objClientCurrency) {
            $objClientCurrency = $objClientCurrency->toArray();
            return $objClientCurrency;
        }
    }

    /**
     * this is used to send push notification
     */
    public function sendNotification()
    {
        if (empty($this->extraPayLoad)) {
            $this->extraPayLoad['sender_id'] = loginId();
        }
        if (!empty($this->deviceTokens)) {
            if ($this->deviceType == 'ios') {
                $push = new PushNotification('apn');
                $response = $push->setMessage([
                    'aps' => [
                        'alert' => [
                            'title' => $this->notificationTitle,
                            'body' => $this->notificationMessage
                        ],
                        'sound' => 'default',
                        'badge' => (int)$this->badge
                    ],
                    'data' => $this->extraPayLoad
                ])
                    ->setDevicesToken($this->deviceTokens)
                    ->send();
            } else {
                $push = new PushNotification('fcm');
                $response = $push->setMessage([
                    'notification' => [
                        'title' => $this->notificationTitle,
                        'body' => $this->notificationMessage,
                        'sound' => 'default'
                    ],
                    'data' => $this->extraPayLoad
                ])
                    ->setApiKey('AAAANcUPD-4:APA91bG7gGZBKT3UziPA5owpOqkz9q1lb6TEsFuxYSTg9IO14c3F5fPlRwG2W5KXXDculBNTAeHaY-G5vqcwBH9a41c2D29TaYGyJdKfDWr3e75Yx2MwrvbswhTPpzpF995vY0cJ2np-')
                    ->setConfig(['dry_run' => false])
                    ->setDevicesToken('151515abcabc')
                    ->send();
            }
            if (!empty($response->getFeedback()->success)) {
                $this->success = true;
                $this->message = _lang('Push notification is sent successfully');
            } else {
                if (empty($this->isApi))
                    $this->success = false;
                $this->message = 'There is problem to send push notification';
            }
        }

    }
    /*
        to take mime type as a parameter and return the equivalent extension
        Method by Vimal Patel 
    */
    public function mime2ext($mime){
        $all_mimes = '{"png":["image\/png","image\/x-png"],"bmp":["image\/bmp","image\/x-bmp",
        "image\/x-bitmap","image\/x-xbitmap","image\/x-win-bitmap","image\/x-windows-bmp",
        "image\/ms-bmp","image\/x-ms-bmp","application\/bmp","application\/x-bmp",
        "application\/x-win-bitmap"],"gif":["image\/gif"],"jpeg":["image\/jpeg",
        "image\/pjpeg"],"xspf":["application\/xspf+xml"],"vlc":["application\/videolan"],
        "wmv":["video\/x-ms-wmv","video\/x-ms-asf"],"au":["audio\/x-au"],
        "ac3":["audio\/ac3"],"flac":["audio\/x-flac"],"ogg":["audio\/ogg",
        "video\/ogg","application\/ogg"],"kmz":["application\/vnd.google-earth.kmz"],
        "kml":["application\/vnd.google-earth.kml+xml"],"rtx":["text\/richtext"],
        "rtf":["text\/rtf"],"jar":["application\/java-archive","application\/x-java-application",
        "application\/x-jar"],"zip":["application\/x-zip","application\/zip",
        "application\/x-zip-compressed","application\/s-compressed","multipart\/x-zip"],
        "7zip":["application\/x-compressed"],"xml":["application\/xml","text\/xml"],
        "svg":["image\/svg+xml"],"3g2":["video\/3gpp2"],"3gp":["video\/3gp","video\/3gpp"],
        "mp4":["video\/mp4"],"m4a":["audio\/x-m4a"],"f4v":["video\/x-f4v"],"flv":["video\/x-flv"],
        "webm":["video\/webm"],"aac":["audio\/x-acc"],"m4u":["application\/vnd.mpegurl"],
        "pdf":["application\/pdf","application\/octet-stream"],
        "pptx":["application\/vnd.openxmlformats-officedocument.presentationml.presentation"],
        "ppt":["application\/powerpoint","application\/vnd.ms-powerpoint","application\/vnd.ms-office",
        "application\/msword"],"docx":["application\/vnd.openxmlformats-officedocument.wordprocessingml.document"],
        "xlsx":["application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application\/vnd.ms-excel"],
        "xl":["application\/excel"],"xls":["application\/msexcel","application\/x-msexcel","application\/x-ms-excel",
        "application\/x-excel","application\/x-dos_ms_excel","application\/xls","application\/x-xls"],
        "xsl":["text\/xsl"],"mpeg":["video\/mpeg"],"mov":["video\/quicktime"],"avi":["video\/x-msvideo",
        "video\/msvideo","video\/avi","application\/x-troff-msvideo"],"movie":["video\/x-sgi-movie"],
        "log":["text\/x-log"],"txt":["text\/plain"],"css":["text\/css"],"html":["text\/html"],
        "wav":["audio\/x-wav","audio\/wave","audio\/wav"],"xhtml":["application\/xhtml+xml"],
        "tar":["application\/x-tar"],"tgz":["application\/x-gzip-compressed"],"psd":["application\/x-photoshop",
        "image\/vnd.adobe.photoshop"],"exe":["application\/x-msdownload"],"js":["application\/x-javascript"],
        "mp3":["audio\/mpeg","audio\/mpg","audio\/mpeg3","audio\/mp3"],"rar":["application\/x-rar","application\/rar",
        "application\/x-rar-compressed"],"gzip":["application\/x-gzip"],"hqx":["application\/mac-binhex40",
        "application\/mac-binhex","application\/x-binhex40","application\/x-mac-binhex40"],
        "cpt":["application\/mac-compactpro"],"bin":["application\/macbinary","application\/mac-binary",
        "application\/x-binary","application\/x-macbinary"],"oda":["application\/oda"],
        "ai":["application\/postscript"],"smil":["application\/smil"],"mif":["application\/vnd.mif"],
        "wbxml":["application\/wbxml"],"wmlc":["application\/wmlc"],"dcr":["application\/x-director"],
        "dvi":["application\/x-dvi"],"gtar":["application\/x-gtar"],"php":["application\/x-httpd-php",
        "application\/php","application\/x-php","text\/php","text\/x-php","application\/x-httpd-php-source"],
        "swf":["application\/x-shockwave-flash"],"sit":["application\/x-stuffit"],"z":["application\/x-compress"],
        "mid":["audio\/midi"],"aif":["audio\/x-aiff","audio\/aiff"],"ram":["audio\/x-pn-realaudio"],
        "rpm":["audio\/x-pn-realaudio-plugin"],"ra":["audio\/x-realaudio"],"rv":["video\/vnd.rn-realvideo"],
        "jp2":["image\/jp2","video\/mj2","image\/jpx","image\/jpm"],"tiff":["image\/tiff"],
        "eml":["message\/rfc822"],"pem":["application\/x-x509-user-cert","application\/x-pem-file"],
        "p10":["application\/x-pkcs10","application\/pkcs10"],"p12":["application\/x-pkcs12"],
        "p7a":["application\/x-pkcs7-signature"],"p7c":["application\/pkcs7-mime","application\/x-pkcs7-mime"],"p7r":["application\/x-pkcs7-certreqresp"],"p7s":["application\/pkcs7-signature"],"crt":["application\/x-x509-ca-cert","application\/pkix-cert"],"crl":["application\/pkix-crl","application\/pkcs-crl"],"pgp":["application\/pgp"],"gpg":["application\/gpg-keys"],"rsa":["application\/x-pkcs7"],"ics":["text\/calendar"],"zsh":["text\/x-scriptzsh"],"cdr":["application\/cdr","application\/coreldraw","application\/x-cdr","application\/x-coreldraw","image\/cdr","image\/x-cdr","zz-application\/zz-winassoc-cdr"],"wma":["audio\/x-ms-wma"],"vcf":["text\/x-vcard"],"srt":["text\/srt"],"vtt":["text\/vtt"],"ico":["image\/x-icon","image\/x-ico","image\/vnd.microsoft.icon"],"csv":["text\/x-comma-separated-values","text\/comma-separated-values","application\/vnd.msexcel"],"json":["application\/json","text\/json"]}';
        $all_mimes = json_decode($all_mimes,true);
        foreach ($all_mimes as $key => $value) {
            if(array_search($mime,$value) !== false) return $key;
        }
        return false;
    }
    public function clientDiscountPercentageCalculate($clientId,$serviceId,$weekId,$trainingDayId){

    }
    public function getClientEquipmentDropDown($uniqueId){
        $clientEquipmentsObj = ClientSelectedEquipment::select('equipment_id')
            ->where('unique_id', $uniqueId)
            ->get()
            ->first();
        $equipments = [];
        if (!empty($clientEquipmentsObj)) {
            $clientEquipmentsObj = $clientEquipmentsObj->toArray();
            $clientEquipmentsObj = explode(',', $clientEquipmentsObj['equipment_id']);
            $equipments = Equipment::whereIn('id', $clientEquipmentsObj)
                ->pluck('name', 'id')
                ->toArray();
        } else {
            $clientEquipmentsObj = [];
        }
        $this->data['exercise_equipments'] = $this->emptySelect + $equipments;
        return $clientEquipmentsObj;
    }

    public function defaultUserData()
    {
        $services = Service::select('id as service_id')->whereIn('key_pair', ['training_program','online_coaching','personal_training'])->get()->toArray();
        foreach ($services as $key => $row){
            $services[$key]['is_checked'] = 1;
            $services[$key]['user_id'] = $this->userId;
            $services[$key]['created_at'] = date("Y-m-d H:i:s");
            $services[$key]['updated_at'] = date("Y-m-d H:i:s");
        }
        ServiceAvailableBooking::where('user_id',$this->userId)->delete();
        ServiceAvailableBooking::insert($services);
        ClientCurrency::updateOrCreate(['client_id' => $this->userId,], ['currency_id' => 1]);
        $this->saveTrainingPlanDataByDefault();
        $this->saveProgramTrainingPriceByDefault($this->userId,3);
        $this->saveProgramTrainingPricePersonalTrainingByDefault($this->userId,4);

    }

    /**
     * this is used to save training plan data BY DEFAULT
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveTrainingPlanDataByDefault(){

        $daysIds = ['1'=> 0, '2'=> 0, '3'=> 0, '4'=> 0, '5'=> 0, '6'=> 0, '7'=> 0,];
        $weekIdValues = ['1'=> 0, '2'=>2.5, '3'=>5, '4'=>7.5, '5'=>15, '6'=>30,];
        $bookingIdValues = ['1'=> 0, '2'=>2.5, '3'=>5, '4'=>7.5, '5'=>12.5, '6'=>20,];
        $repeatPercentage = "10";
        $isRepeatUseDefaultChecked = "1";
        $isUseDefaultCheckedLengthProgram = "1";
        $isUseDefaultCheckedRepeatProgram = "1";

        $userId = $this->userId;
        $this->type = 1; // for training program
        $basePrice = 0;

        $obj = TrainingProgramPriceSetup::where('user_id', '=', $userId)->where('type', '=', $this->type)->first();
        if (!$obj) {
            $obj = new TrainingProgramPriceSetup();
        }
        $obj->user_id = $userId;
        $obj->repeat_percentage_value = $repeatPercentage;
        $obj->is_use_default_week_repeat = $isRepeatUseDefaultChecked;
        $obj->is_use_default_length_program_booking = $isUseDefaultCheckedLengthProgram;                                                                                                                                                        ;
        $obj->is_use_default_repeat_purchase_booking = $isUseDefaultCheckedRepeatProgram;                                                                                                                                                        ;
        $obj->base_price = $basePrice;
        $obj->type = $this->type;
        $obj->save();
        $id = $obj->id;
        $weekArray = [];
        $dayArray = [];
        if(!empty($weekIdValues)){
            foreach ($weekIdValues as $key => $weekData) {
                $weekArray[$key]['discount'] = $weekData;
                $weekArray[$key]['type'] = $this->type;
                $weekArray[$key]['discount_type'] = 1;
                $weekArray[$key]['training_program_price_setup_ id'] = $id;
                $weekArray[$key]['day_week_id'] = $key;
                $weekArray[$key]['is_checked'] = 1;
            }
        }if(!empty($daysIds)){
            foreach ($daysIds as $key => $daysData) {
                $dayArray[$key]['discount'] = $daysData;
                $dayArray[$key]['type'] = $this->type;
                $dayArray[$key]['discount_type'] = 2;
                $dayArray[$key]['training_program_price_setup_id'] = $id;
                $dayArray[$key]['training_plan_id'] = $key;
                $dayArray[$key]['day_week_id'] = $key;
                $dayArray[$key]['is_checked'] = 1;
            }
        }
        $weekArray = array_values($weekArray);
        $dayArray = array_values($dayArray);
        $arrPrice = array_merge($weekArray, $dayArray);
        PricingDiscount::where('training_program_price_setup_id', '=', $id)->delete();
        $TrainingPrograme = TrainingProgramPriceSetup::find($id);
        $TrainingPrograme->prices()->createMany($arrPrice);
        $arrBooking = [];
        if(!empty($bookingIdValues)){
            foreach ($bookingIdValues as $key =>$bookingdata){
                $arrBooking['discount_'.$key] = $bookingdata;
            }
            $arrBooking['type'] = $this->type;
            $arrBooking['user_id'] = $userId;
            RepeatProgramPurchaseBooking::updateorCreate([
                'training_program_price_setup_id'=>$id
            ],$arrBooking);
        }
//        $this->message = 'data save successfully';
        return ;

    }

    /**
     * This is used to save training price BY default
     *
     * @param Request $request
     */
    public function saveProgramTrainingPriceByDefault($userId,$type)
    {
        $this->userId = $userId;

        $this->type = $type;
        $isDiscountCheck = 'true';
        $finalPricesList = [];
        $arr = [1,2,3,4,5,6,7];
        $index = 1;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);
        $arr = [500];
        $index = 2;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);
        $arr = [1,2,3,4,5,6,7];
        $index = 2;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);
        $arr = [250];
        $index = 3;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);
        $arr = [500];
        $index = 3;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);
        $arr = [1,2,3,4,5,6,7];
        $index = 3;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);
        $arr = [250];
        $index = 4;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);
        $arr = [500];
        $index = 4;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);
        $arr = [1,2,3,4,5,6,7];
        $index = 4;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);
        $arr = [250];
        $index = 5;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);
        $arr = [500];
        $index = 5;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);
        $arr = [1,2,3,4,5,6,7];
        $index = 5;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);
        $arr = [250];
        $index = 6;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);
        $arr = [500];
        $index = 6;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);
        $arr = [1,2,3,4,5,6,7];
        $index = 6;
        $value = 0;
        preparedArray($arr, $index, $value, $finalPricesList);

        $basePrice = 0;
        $planData = ['1' => '5', '2' => '7.5', '3' => '10', '4' => '12.5', '5' => '15', '6' => '17.5', '7' => '20', '250' => '0', '500' => '2.5',];
        $isDiscountBaseCheck = '1';
        $weekDiscount = ['1' => '0', '2' => '2.5', '3' => '5', '4' => '7.5', '5' => '15', '6' => '30',];
        $checkboxDayCheckedList = ['250_9' => '250', '500_10' => '500', '1_11' => '1', '2_12' => '2', '3_13' => '3', '4_14' => '4', '5_15' => '5', '6_16' => '6', '7_17' => '7',];
        $checkboxWeekCheckedList = ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6',];

        $obj = TrainingProgramPriceSetup::where('user_id', '=', $userId)->where('type', '=', $this->type)->first();
        if (!$obj) {
            $obj = new TrainingProgramPriceSetup();
        }
        $obj->user_id = $userId;
        $obj->base_price = $basePrice;
        $obj->type = $this->type;
        $obj->is_auto_calculate_discount = $isDiscountBaseCheck;
        $obj->save();
        $id = $obj->id;
        $weekArray = [];
        $dayArray = [];
        foreach ($checkboxWeekCheckedList as $key => $checkedWeek) {
            if (isset($weekDiscount[$checkedWeek]) || $isDiscountCheck == 'false') {
                $weekDiscountValue = $weekDiscount[$checkedWeek];
                $weekArray[$checkedWeek]['discount'] = $weekDiscountValue;
            }
            $weekArray[$checkedWeek]['type'] = $this->type;
            $weekArray[$checkedWeek]['discount_type'] = 1;
            $weekArray[$checkedWeek]['training_program_price_setup_id'] = $id;
            $weekArray[$checkedWeek]['day_week_id'] = $checkedWeek;
            $weekArray[$checkedWeek]['is_checked'] = 1;
        }
        foreach ($checkboxDayCheckedList as $key => $checkedDays) {
            if (isset($planData[$checkedDays]) || $isDiscountCheck == 'false') {
                $dayDiscountValue = $planData[$checkedDays];
                $dayArray[$checkedDays]['discount'] = $dayDiscountValue;
            }
            $checkedDaysId = explode('_',$key);
            $dayArray[$checkedDays]['type'] = $this->type;
            $dayArray[$checkedDays]['discount_type'] = 2;
            $dayArray[$checkedDays]['training_program_price_setup_id'] = $id;
            $dayArray[$checkedDays]['training_plan_id'] = $checkedDaysId[1];
            $dayArray[$checkedDays]['day_week_id'] = $checkedDaysId[0];
            $dayArray[$checkedDays]['is_checked'] = 1;

        }
        $weekArray = array_values($weekArray);
        $dayArray = array_values($dayArray);
        $arrPrice = array_merge($weekArray, $dayArray);
        PricingDiscount::where('training_program_price_setup_id', '=', $id)->delete();
        $TrainingPrograme = TrainingProgramPriceSetup::find($id);
        $TrainingPrograme->prices()->createMany($arrPrice);
        $arr = [];
        TrainingProgramPrice::where('training_program_price_setup_id', '=', $id)->delete();
        foreach ($checkboxDayCheckedList as $daysId => $key) {
            $TrainingDayId = explode('_',$daysId)[1];
            $arr['final_price_1'] = (!empty($finalPricesList[$key . '_1'])) ? $finalPricesList[$key . '_1'] : 0;
            $arr['final_price_2'] = (!empty($finalPricesList[$key . '_2'])) ? $finalPricesList[$key . '_2'] : 0;
            $arr['final_price_3'] = (!empty($finalPricesList[$key . '_3'])) ? $finalPricesList[$key . '_3'] : 0;
            $arr['final_price_4'] = (!empty($finalPricesList[$key . '_4'])) ? $finalPricesList[$key . '_4'] : 0;
            $arr['final_price_5'] = (!empty($finalPricesList[$key . '_5'])) ? $finalPricesList[$key . '_5'] : 0;
            $arr['final_price_6'] = (!empty($finalPricesList[$key . '_6'])) ? $finalPricesList[$key . '_6'] : 0;
            $arr['final_price_7'] = (!empty($finalPricesList[$key . '_7'])) ? $finalPricesList[$key . '_7'] : 0;
            TrainingProgramPrice::updateorCreate(['training_program_price_setup_id' => $id, 'training_plan_id' => $TrainingDayId, 'type' => $this->type], $arr);
        }

        $this->insertDefaultSessionLocation($type, $id);

        return;
    }

    /**
     * This is used to save personal training by default
     *
     * @param $userId
     * @param $type
     */
    public function saveProgramTrainingPricePersonalTrainingByDefault($userId,$type)
    {
        $this->userId = $userId;
        $this->type = $type;
        $isDiscountCheck = "true";
        $finalPricesList = [
            '1_1' => '0', '2_1' => '0', '3_1' => '0', '4_1' => '0', '5_1' => '0', '6_1' => '0', '7_1' => '0', '500_2' => '0', '1_2' => '0', '2_2' => '0',
            '3_2' => '0', '4_2' => '0', '5_2' => '0', '6_2' => '0', '7_2' => '0', '250_3' => '0', '500_3' => '0', '1_3' => '0', '2_3' => '0', '3_3' => '0',
            '4_3' => '0', '5_3' => '0', '6_3' => '0', '7_3' => '0', '250_4' => '0', '500_4' => '0', '1_4' => '0', '2_4' => '0', '3_4' => '0', '4_4' => '0',
            '5_4' => '0', '6_4' => '0', '7_4' => '0', '250_5' => '0', '500_5' => '0', '1_5' => '0', '2_5' => '0', '3_5' => '0', '4_5' => '0', '5_5' => '0',
            '6_5' => '0', '7_5' => '0', '250_6' => '0', '500_6' => '0', '1_6' => '0', '2_6' => '0', '3_6' => '0', '4_6' => '0', '5_6' => '0', '6_6' => '0',
            '7_6' => '0',
        ];
        $basePrice = 0;
        $planData = ['1' => '0', '2' => '2.5', '3' => '5', '4' => '7.5', '5' => '10', '6' => '12.5', '7' => '15', '250' => '0', '500' => '0'];
        $isDiscountBaseCheck = '1';
        $weekDiscount = ['1' => '0', '2' => '2.5', '3' => '5', '4' => '7.5', '5' => '15', '6' => '30'];
        $checkboxDayCheckedList = [
            '250_18' => '250', '500_19' => '500', '1_20' => '1', '2_21' => '2', '3_22' => '3', '4_23' => '4', '5_24' => '5', '6_25' => '6', '7_26' => '7'];
        $checkboxWeekCheckedList = [
            '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6',];
        $obj = TrainingProgramPriceSetup::where('user_id', '=', $userId)->where('type', '=', $this->type)->first();
        if (!$obj) {
            $obj = new TrainingProgramPriceSetup();
        }
        $obj->user_id = $userId;
        $obj->base_price = $basePrice;
        $obj->type = $type;
        $obj->is_auto_calculate_discount = $isDiscountBaseCheck;
        $obj->save();
        $id = $obj->id;
        $weekArray = [];
        $dayArray = [];
        foreach ($checkboxWeekCheckedList as $key => $checkedWeek) {
            if (isset($weekDiscount[$checkedWeek]) || $isDiscountCheck == 'false') {
                $weekDiscountValue = $weekDiscount[$checkedWeek];
                $weekArray[$checkedWeek]['discount'] = $weekDiscountValue;
            }
            $weekArray[$checkedWeek]['type'] = $this->type;
            $weekArray[$checkedWeek]['discount_type'] = 1;
            $weekArray[$checkedWeek]['training_program_price_setup_id'] = $id;
            $weekArray[$checkedWeek]['day_week_id'] = $checkedWeek;
            $weekArray[$checkedWeek]['is_checked'] = 1;
        }
        foreach ($checkboxDayCheckedList as $key => $checkedDays) {
            if (isset($planData[$checkedDays]) || $isDiscountCheck == 'false') {
                $dayDiscountValue = $planData[$checkedDays];
                $dayArray[$checkedDays]['discount'] = $dayDiscountValue;
            }
            $checkedDaysId = explode('_',$key);
            $dayArray[$checkedDays]['type'] = $this->type;
            $dayArray[$checkedDays]['discount_type'] = 2;
            $dayArray[$checkedDays]['training_program_price_setup_id'] = $id;
            $dayArray[$checkedDays]['training_plan_id'] = $checkedDaysId[1];
            $dayArray[$checkedDays]['day_week_id'] = $checkedDaysId[0];
            $dayArray[$checkedDays]['is_checked'] = 1;

        }
        $weekArray = array_values($weekArray);
        $dayArray = array_values($dayArray);
        $arrPrice = array_merge($weekArray, $dayArray);
        PricingDiscount::where('training_program_price_setup_id', '=', $id)->delete();
        $TrainingPrograme = TrainingProgramPriceSetup::find($id);
        $TrainingPrograme->prices()->createMany($arrPrice);
        $arr = [];
        TrainingProgramPrice::where('training_program_price_setup_id', '=', $id)->delete();
        foreach ($checkboxDayCheckedList as $daysId => $key) {
            $TrainingDayId = explode('_',$daysId)[1];
            $arr['final_price_1'] = (!empty($finalPricesList[$key . '_1'])) ? $finalPricesList[$key . '_1'] : 0;
            $arr['final_price_2'] = (!empty($finalPricesList[$key . '_2'])) ? $finalPricesList[$key . '_2'] : 0;
            $arr['final_price_3'] = (!empty($finalPricesList[$key . '_3'])) ? $finalPricesList[$key . '_3'] : 0;
            $arr['final_price_4'] = (!empty($finalPricesList[$key . '_4'])) ? $finalPricesList[$key . '_4'] : 0;
            $arr['final_price_5'] = (!empty($finalPricesList[$key . '_5'])) ? $finalPricesList[$key . '_5'] : 0;
            $arr['final_price_6'] = (!empty($finalPricesList[$key . '_6'])) ? $finalPricesList[$key . '_6'] : 0;
            $arr['final_price_7'] = (!empty($finalPricesList[$key . '_7'])) ? $finalPricesList[$key . '_7'] : 0;
            TrainingProgramPrice::updateorCreate(['training_program_price_setup_id' => $id, 'training_plan_id' => $TrainingDayId, 'type' => $this->type], $arr);
        }

//        $result = [];
//        $arr = ['SATS 21, 44 Street, Oslo', 'SATS 15, Alf Street, Oslo', 'Private at home'];
//        foreach ($arr as $key => $row) {
//            $result[$key]['training_program_price_setup_id'] = $id;
//            $result[$key]['address_name'] = $row;
//            $result[$key]['is_listing'] = 1;
//            $result[$key]['price_changed'] = 1;
//        }
//        $objLocation = new TrainingSessionLocation();
//        $objLocation->insert($result);

        $this->insertDefaultSessionLocation($type, $id);

        return;
    }

    /**
     * This is used to insert default session location
     *
     * @param $type 3 or 4
     * @param $id training plan setup id
     */
    private function insertDefaultSessionLocation($type, $id)
    {
        $data = TrainingCoachingSessionLength::where('type', '=', $type)->get()->toArray();
        $array = [];
        foreach ($data as $key => $row) {
            $array[$key]['training_program_price_setup_id'] = $id;
            $array[$key]['type'] = $type;
            $array[$key]['session_length_id'] = $row['id'];
            $array[$key]['is_listing'] = 1;
        }

        TrainingCoachingSession::insert($array);
    }

    /**
     * This is common function to send push notifications
     *
     * @param $params
     * 
     * @throws \LaravelFCM\Message\Exceptions\InvalidOptionsException
     */
    public function sendPushNotifications($params)
    {
        try {
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60 * 20);

            $notificationBuilder = new PayloadNotificationBuilder($params['title']);
            $notificationBuilder->setBody($params['notification_message'])
                ->setSound('default');

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData(['a_data' => 'my_data']);

            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();

            $token = $params['device_token'];
            $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
            $downstreamResponse->numberSuccess();
            $downstreamResponse->numberFailure();
            $downstreamResponse->numberModification();
        } catch (\Exception $e) {

        }
        $obj = new Notification();
        $obj->user_id = $params['user_id'];
        $obj->notification_user_id = $params['notification_user_id'];
        $obj->notification = $params['message'];
        $obj->save();
    }

    public function saveNotification($params)
    {
//        $obj = new Notification();
//        $obj->user_id = $params['user_id'];
//        $obj->notification = $params['notification'];
//        $obj->save();
    }

    public function bookingsFactorConditions($bookings)
    {
        $factor = 0;
        if ($bookings == 0) {
            $factor = 0;
        } elseif ($bookings == 1) {
            $factor = 0.1;
        } elseif ($bookings == 2) {
            $factor = 0.2;
        } elseif ($bookings == 3) {
            $factor = 0.3;
        } elseif ($bookings == 4) {
            $factor = 0.4;
        } elseif ($bookings == 5) {
            $factor = 0.5;
        } elseif ($bookings == 6) {
            $factor = 0.6;
        } elseif ($bookings == 7) {
            $factor = 0.7;
        } elseif ($bookings == 8) {
            $factor = 0.8;
        } elseif ($bookings == 9) {
            $factor = 0.9;
        } elseif ($bookings >= 10) {
            $factor = 1.0;
        }

        return $factor;

    }

    /**
     * This is used to update client show or not
     */
    public function isClientShow()
    {
        $isClientShow = 0;
        $data = TrainingProgramPriceSetup::select('training_program_price_setups.base_price', 'training_program_price_setups.type', 'tsl.address_name', 'sab.is_checked')
            ->join('service_available_bookings as sab', function ($join){
                $join->on('sab.user_id', '=', 'training_program_price_setups.user_id');
                $join->on('sab.service_id', 'training_program_price_setups.type');
            })
            ->leftJoin('training_session_locations as tsl', 'tsl.training_program_price_setup_id', '=', 'training_program_price_setups.id')
        ->where(['training_program_price_setups.user_id' =>  $this->userId, 'sab.is_checked' => 1])->orderBy('training_program_price_setups.type')->groupBy('training_program_price_setups.id')->get();
        if (!empty($data)) {
            $data = sortByOneKeyObject($data->toArray(), 'type');
            foreach ($data as $item) {
                if ($item->type == 1 && (float) $item->base_price > 0) {
                    $isClientShow = 1;
                } elseif (($item->type == 3 && empty((float)$item->base_price)) || ($item->type == 4 && (empty((float)$item->base_price) || $item->address_name == null))) {
                    $isClientShow = 0;
                }
            }
        }

        User::find($this->userId)->update(['is_client_show' => $isClientShow]);
    }

    /**
     * This function is used to calculate image dimensions
     */
    private function calculateImageDimension()
    {
        $widthRatio = $this->requiredImageWidth / $this->originalImageWidth;
        $heightRatio = $this->requiredImageHeight / $this->originalImageHeight;
        $ratio = $widthRatio;
        if ($heightRatio < $widthRatio) {
            $ratio = $heightRatio;
        }
        $this->newImageWidth = ceil($this->originalImageWidth * $ratio);
        $this->newImageHeight = ceil($this->originalImageHeight * $ratio);
    }

    /**
     * This is used to save new plan
     *
     * @param $params
     */
    public function saveAsNewPlan($params)
    {
        try {
            DB::beginTransaction();
            $this->dayId = $params['dayId'];
            $importDayId = $this->dayId;
//            $objPlan = Plan::where(['old_plan_id' => $params['planId'], 'plan_day_id' => $params['dayId']])->first();
//            if (empty($objPlan)) {
                $objPlan = new plan();
//            }
            $objPlan->title = $params['title'];
            $objPlan->description = $params['description'];
            $objPlan->goal_id = $params['goalId'];
            $objPlan->old_plan_id = $params['planId'];
            $objPlan->plan_day_id = $this->dayId;
            $objPlan->plan_type = 1;
            $objPlan->is_completed = 1;
            $objPlan->user_id = loginId();
            $objPlan->duration = 'one day';
            $objPlan->save();
            $newPlanId = $objPlan->id;
            $toAddDataPlanId = $params['planId'];
            $objPlan->Equipments()->sync($params['equipmentIds']);
            $model = 'PlanTrainingOverviewWeek';
            if (!empty($this->isEdit)) {
                $model = 'DraftPlanTrainingOverviewWeek';
            }
            $model = '\\App\Models\\' . $model;
            $planOverviewWeekObj = $model::where(['plan_id' => $toAddDataPlanId, 'day_id' => $importDayId])
                ->get([
                    'plan_id', 'day_id', 'day_plan_id', 'body_part_1', 'body_part_2', 'body_part_3'])
                ->toArray();
            foreach ($planOverviewWeekObj as $key => $row) {
                $planOverviewWeekObj[$key]['plan_id'] = $newPlanId;
                $planOverviewWeekObj[$key]['day_id'] = $this->oneDayId;
            }
            PlanTrainingOverviewWeek::where('plan_id', $newPlanId)
                ->where('day_id', $this->oneDayId)
                ->delete();
            PlanTrainingOverviewWeek::insert($planOverviewWeekObj);
            // Plan Week Training setup
            $model = 'PlanWeekTrainingSetup';
            if (!empty($this->isEdit)) {
                $model = 'DraftPlanWeekTrainingSetup';
            }
            $model = '\\App\Models\\' . $model;
            $planTrainingSetupObj = $model::where('plan_id', $toAddDataPlanId)
                ->where('day_id', $importDayId)
                ->get([
                    'id', 'plan_id', 'day_id', 'plan_training_overview_week_id',
                    'warm_up', 'main_workout', 'cardio', 'cool_down', 'is_main_workout_top'])
                ->toArray();
            $objPlanTrainingOverviewIds = PlanTrainingOverviewWeek::select('id')->where('plan_id', $newPlanId)
                ->where('day_id', $this->oneDayId)
                ->get()->toArray();
            foreach ($planTrainingSetupObj as $key => $row) {
                $planTrainingSetupObj[$key]['plan_id'] = $newPlanId;
                $planTrainingSetupObj[$key]['plan_training_overview_week_id'] = $objPlanTrainingOverviewIds[$key]['id'];
                $planTrainingSetupObj[$key]['id'] = '';
                $planTrainingSetupObj[$key]['day_id'] = $this->oneDayId;
            }
            PlanWeekTrainingSetup::where('plan_id', $newPlanId)
                ->where('day_id', $this->oneDayId)
                ->delete();
            PlanWeekTrainingSetup::insert($planTrainingSetupObj);

            // plan week training setup position
            $model = 'PlanWeekTrainingSetup';
            if (!empty($this->isEdit)) {
                $model = 'DraftPlanWeekTrainingSetup';
            }
            $model = '\\App\Models\\' . $model;
            $planSetupId = $model::select('id','day_id')->where('plan_id', $toAddDataPlanId)
                ->where('day_id', $importDayId)
                ->get()->toArray();
            $planSetupId = array_column($planSetupId, null, 'day_id');
            $clientPlanSetupTrainingObjIds = PlanWeekTrainingSetup::where('plan_id', $newPlanId)
                ->where('day_id', $this->oneDayId)
                ->get()->toArray();
            $clientPlanSetupTrainingObjIds = array_column($clientPlanSetupTrainingObjIds, null, 'day_id');
            $model = 'PlanWeekTrainingSetupPosition';
            if (!empty($this->isEdit)) {
                $model = 'DraftPlanWeekTrainingSetupPosition';
            }
            $model = '\\App\Models\\' . $model;

            foreach ($planSetupId as $key => $setupId) {
                $planWeekTrainingSetupPositionObj = $model::where('plan_week_training_setup_id', $setupId['id'])
                    ->get(['plan_week_training_setup_id', 'workout_type_set_id',
                        'workout_main_counter', 'position', 'exercise_set'])
                    ->toArray();
//                PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', $clientPlanSetupTrainingObjIds[$key]['id'])->delete();
                if ($planWeekTrainingSetupPositionObj) {
                    foreach ($planWeekTrainingSetupPositionObj as $item) {
                        $item['plan_week_training_setup_id'] = $clientPlanSetupTrainingObjIds[$this->oneDayId]['id'];
                        PlanWeekTrainingSetupPosition::insert($item);
                    }
                }
            }
            // temp table
            $model = 'TempTrainingSetup';
            if (!empty($this->isEdit)) {
                $model = 'DraftTempTrainingSetup';
            }
            $model = '\\App\Models\\' . $model;
            $tempTrainingSetupObj = $model::where(['plan_id' => $toAddDataPlanId, 'day_id' => $importDayId])
                ->get(['plan_id', 'day_id', 'structure_id', 'workout_main_counter', 'position'])
                ->toArray();

            foreach ($tempTrainingSetupObj as $key => $row) {
                $tempTrainingSetupObj[$key]['plan_id'] = $newPlanId;
                $tempTrainingSetupObj[$key]['day_id'] = $this->oneDayId;
            }

            TempTrainingSetup::where('plan_id', $newPlanId)
                ->where('day_id', $this->oneDayId)
                ->delete();
            TempTrainingSetup::insert($tempTrainingSetupObj);
            // drag drop table

            $clientTempTrainingSetupObj = TempTrainingSetup::where(['plan_id' => $newPlanId, 'day_id' => $importDayId])->get()->toArray();
            $arrTemp = [];
            foreach ($clientTempTrainingSetupObj as $row) {
                $arrTemp[$toAddDataPlanId][$row['day_id']][$row['structure_id']][$row['workout_main_counter']] = $row['id'];
            }

            $model = 'PlanDragDropStructure';
            if (!empty($this->isEdit)) {
                $model = 'DraftPlanDragDropStructure';
            }
            $model = '\\App\Models\\' . $model;

            $planDragDropStructureObj = $model::where(['plan_id' => $toAddDataPlanId, 'day_id' => $importDayId])
                ->get(['plan_id', 'day_id', 'structure_id', 'exercise_id', 'workout_counter', 'workout_sub_counter',
                    'workout_type', 'workout_set_type_id', 'position', 'position_id', 'set_id', 'rep_id', 'duration_id',
                    'note_id', 'rm_id', 'tempo_id', 'rest_id', 'form_id', 'stage_id', 'wr_id'])
                ->toArray();
            foreach ($planDragDropStructureObj as $key => $row) {
                $planDragDropStructureObj[$key]['plan_id'] = $newPlanId;
                $planDragDropStructureObj[$key]['day_id'] = $this->oneDayId;
            }

            $clientWeekTrainingSetup = PlanWeekTrainingSetup::select('day_id', 'cp.id', 'workout_type_set_id', 'workout_main_counter')
                ->where('plan_id', '=', $newPlanId)
                ->join('plan_week_training_setup_positions as cp', 'cp.plan_week_training_setup_id', '=', 'plan_week_training_setups.id')
                ->get()->toArray();
            $arrTempPlan = [];
            foreach ($clientWeekTrainingSetup as $row) {
                $arrTempPlan[$toAddDataPlanId][$row['day_id']][$row['workout_type_set_id']][$row['workout_main_counter']] = $row['id'];
            }
            foreach ($planDragDropStructureObj as $key => $row) {
                $planDragDropStructureObj[$key]['plan_id'] = $newPlanId;
                if ($row['structure_id'] != 2 && !empty($arrTemp[$toAddDataPlanId][$row['day_id']][$row['structure_id']][$row['workout_counter']])) {
                    $planDragDropStructureObj[$key]['position_id'] = $arrTemp[$toAddDataPlanId][$row['day_id']][$row['structure_id']][$row['workout_counter']];
                } elseif ($row['structure_id'] == 2 && !empty($arrTempPlan[$toAddDataPlanId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']])) {
                    $planDragDropStructureObj[$key]['position_id'] = $arrTempPlan[$toAddDataPlanId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']];
                }
            }
            PlanDragDropStructure::where('plan_id', $newPlanId)
                ->where('day_id', $this->oneDayId)
                ->delete();
            PlanDragDropStructure::insert($planDragDropStructureObj);
            // plan comment table
            $model = 'PlanTrainingComment';
            if (!empty($this->isEdit)) {
                $model = 'DraftPlanTrainingComment';
            }
            $model = '\\App\Models\\' . $model;
            $planTrainingCommentObj = $model::where('plan_id', $toAddDataPlanId)
                ->get(['plan_id', 'day_id', 'comment'])
                ->toArray();
            foreach ($planTrainingCommentObj as $key => $row) {
                $planTrainingCommentObj[$key]['plan_id'] = $newPlanId;
                $planTrainingCommentObj[$key]['day_id'] = $this->oneDayId;
            }
            PlanTrainingComment::where('plan_id', $newPlanId)
                ->where('day_id', $this->oneDayId)
                ->delete();
            PlanTrainingComment::insert($planTrainingCommentObj);
            DB::commit();
            $this->success = true;
            $this->message = "The training plan is saved as a new One-day plan in your list";
        } catch (\Exception $e) {
           $this->message = $e->getMessage();
            DB::rollback();
            $this->message = 'There is some problem to create new plan';
        }
    }

    /**
     * This is used to save new plan
     *
     * @param $params
     */
    public function saveAsNewPlanFromBooking($params)
    {
        try {
            DB::beginTransaction();
            $this->dayId = $params['dayId'];
            $importDayId = $this->dayId;
//            $objPlan = Plan::where(['old_plan_id' => $params['uniqueId'], 'plan_day_id' => $params['dayId']])->first();
//            if (empty($objPlan)) {
                $objPlan = new plan();
//            }
            $objPlan->title = $params['title'];
            $objPlan->description = $params['description'];
            $objPlan->goal_id = $params['goalId'];
            $objPlan->old_plan_id = $params['uniqueId'];
            $objPlan->plan_day_id = $this->dayId;
            $objPlan->plan_type = 1;
            $objPlan->is_completed = 1;
            $objPlan->user_id = loginId();
            $objPlan->duration = 'one day';
            $objPlan->save();
            $newPlanId = $objPlan->id;
            $toAddDataPlanId = $params['planId'];
            $equipmentIds = $this->params['equipmentIds'];
            $objPlan->Equipments()->sync($equipmentIds);

            $planOverviewWeekObj = \App\Models\Client\PlanTrainingOverviewWeek::where(['client_plan_id' => $toAddDataPlanId, 'day_id' => $importDayId])
                ->get([
                    'client_plan_id as plan_id', 'day_id', 'day_plan_id', 'body_part_1', 'body_part_2', 'body_part_3'])
                ->toArray();
            foreach ($planOverviewWeekObj as $key => $row) {
                $planOverviewWeekObj[$key]['plan_id'] = $newPlanId;
                $planOverviewWeekObj[$key]['day_id'] = $this->oneDayId;
            }
            PlanTrainingOverviewWeek::where('plan_id', $newPlanId)
                ->where('day_id', $this->oneDayId)
                ->delete();
            PlanTrainingOverviewWeek::insert($planOverviewWeekObj);
            // Plan Week Training setup
            $planTrainingSetupObj = \App\Models\Client\PlanWeekTrainingSetup::where('client_plan_id', $toAddDataPlanId)
                ->where('day_id', $importDayId)
                ->get([
                    'id', 'client_plan_id as plan_id', 'day_id', 'client_plan_training_overview_week_id as plan_training_overview_week_id',
                    'warm_up', 'main_workout', 'cardio', 'cool_down', 'is_main_workout_top'])
                ->toArray();
            $objPlanTrainingOverviewIds = PlanTrainingOverviewWeek::select('id')->where('plan_id', $newPlanId)
                ->where('day_id', $this->oneDayId)
                ->get()->toArray();
            foreach ($planTrainingSetupObj as $key => $row) {
                $planTrainingSetupObj[$key]['plan_id'] = $newPlanId;
                $planTrainingSetupObj[$key]['plan_training_overview_week_id'] = $objPlanTrainingOverviewIds[$key]['id'];
                $planTrainingSetupObj[$key]['id'] = '';
                $planTrainingSetupObj[$key]['day_id'] = $this->oneDayId;
            }
            PlanWeekTrainingSetup::where('plan_id', $newPlanId)
                ->where('day_id', $this->oneDayId)
                ->delete();
            PlanWeekTrainingSetup::insert($planTrainingSetupObj);

            // plan week training setup position
            $planSetupId = \App\Models\Client\PlanWeekTrainingSetup::select('id')->where('client_plan_id', $toAddDataPlanId)
                ->where('day_id', $importDayId)
                ->get()->toArray();

            $clientPlanSetupTrainingObjIds = PlanWeekTrainingSetup::where('plan_id', $newPlanId)
                ->where('day_id', $this->oneDayId)
                ->get()->toArray();
            foreach ($planSetupId as $key => $setupId) {
                $planWeekTrainingSetupPositionObj = \App\Models\Client\ClientPlanWeekTrainingSetupPosition::where('client_plan_week_training_setup_id', $setupId['id'])
                    ->get(['client_plan_week_training_setup_id', 'workout_type_set_id',
                        'workout_main_counter', 'position', 'exercise_set'])
                    ->toArray();
                PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', $clientPlanSetupTrainingObjIds[$key]['id'])->delete();

                if ($planWeekTrainingSetupPositionObj) {
                    foreach ($planWeekTrainingSetupPositionObj as $item) {
                        $item['plan_week_training_setup_id'] = $clientPlanSetupTrainingObjIds[$key]['id'];
                        unset($item['client_plan_week_training_setup_id']);
                        PlanWeekTrainingSetupPosition::insert($item);
                    }
                }
            }
            // temp table
            $tempTrainingSetupObj = \App\Models\Client\ClientTempTrainingSetup::where(['client_plan_id' => $toAddDataPlanId, 'day_id' => $importDayId])
                ->get(['client_plan_id as plan_id', 'day_id', 'structure_id', 'workout_main_counter', 'position'])
                ->toArray();

            foreach ($tempTrainingSetupObj as $key => $row) {
                $tempTrainingSetupObj[$key]['plan_id'] = $newPlanId;
                $tempTrainingSetupObj[$key]['day_id'] = $this->oneDayId;
            }
            TempTrainingSetup::where('plan_id', $newPlanId)
                ->where('day_id', $this->oneDayId)
                ->delete();
            TempTrainingSetup::insert($tempTrainingSetupObj);
            // drag drop table

            $clientTempTrainingSetupObj = TempTrainingSetup::where(['plan_id' => $newPlanId, 'day_id' => $this->oneDayId])->get()->toArray();
            $arrTemp = [];
            foreach ($clientTempTrainingSetupObj as $row) {
                $arrTemp[$toAddDataPlanId][$row['day_id']][$row['structure_id']][$row['workout_main_counter']] = $row['id'];
            }

            $planDragDropStructureObj = \App\Models\Client\PlanDragDropStructure::where(['client_plan_id' => $toAddDataPlanId, 'day_id' => $importDayId])
                ->get(['client_plan_id as plan_id', 'day_id', 'structure_id', 'exercise_id', 'workout_counter', 'workout_sub_counter',
                    'workout_type', 'workout_set_type_id', 'position', 'position_id', 'set_id', 'rep_id', 'duration_id',
                    'note_id', 'rm_id', 'tempo_id', 'rest_id', 'form_id', 'stage_id', 'wr_id'])
                ->toArray();
            foreach ($planDragDropStructureObj as $key => $row) {
                $planDragDropStructureObj[$key]['plan_id'] = $newPlanId;
                $planDragDropStructureObj[$key]['day_id'] = $this->oneDayId;
            }

            $clientWeekTrainingSetup = PlanWeekTrainingSetup::select('day_id', 'cp.id', 'workout_type_set_id', 'workout_main_counter')
                ->where('plan_id', '=', $newPlanId)
                ->join('plan_week_training_setup_positions as cp', 'cp.plan_week_training_setup_id', '=', 'plan_week_training_setups.id')
                ->get()->toArray();
            $arrTempPlan = [];
            foreach ($clientWeekTrainingSetup as $row) {
                $arrTempPlan[$toAddDataPlanId][$row['day_id']][$row['workout_type_set_id']][$row['workout_main_counter']] = $row['id'];
            }
            foreach ($planDragDropStructureObj as $key => $row) {
                $planDragDropStructureObj[$key]['plan_id'] = $newPlanId;
                if ($row['structure_id'] != 2 && !empty($arrTemp[$toAddDataPlanId][$row['day_id']][$row['structure_id']][$row['workout_counter']])) {
                    $planDragDropStructureObj[$key]['position_id'] = $arrTemp[$toAddDataPlanId][$row['day_id']][$row['structure_id']][$row['workout_counter']];
                } elseif ($row['structure_id'] == 2 && !empty($arrTempPlan[$toAddDataPlanId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']])) {
                    $planDragDropStructureObj[$key]['position_id'] = $arrTempPlan[$toAddDataPlanId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']];
                }
            }
            PlanDragDropStructure::where('plan_id', $newPlanId)
                ->where('day_id', $this->oneDayId)
                ->delete();
            PlanDragDropStructure::insert($planDragDropStructureObj);
            // plan comment table
            $planTrainingCommentObj = \App\Models\Client\ClientPlanTrainingComment::where(['client_plan_id' => $toAddDataPlanId, 'day_id' => $importDayId])
                ->get(['client_plan_id as plan_id', 'day_id', 'comment'])
                ->toArray();
            foreach ($planTrainingCommentObj as $key => $row) {
                $planTrainingCommentObj[$key]['plan_id'] = $newPlanId;
                $planTrainingCommentObj[$key]['day_id'] = $this->oneDayId;
            }
            PlanTrainingComment::where('plan_id', $newPlanId)
                ->where('day_id', $this->oneDayId)
                ->delete();
            PlanTrainingComment::insert($planTrainingCommentObj);
            DB::commit();
            $this->success = true;
            $this->message = "The training plan is saved as a new One-day plan in your list";
        } catch (\Exception $e) {
            $this->message = $e->getMessage();
            DB::rollback();
        }
    }

    /**
     * this is used to import week plan from main table to draft tables
     * @param $planId
     * @return bool
     */
    public function importWeekPlanOnEdit($planId){
        $this->planId = $planId;
        try {
            DB::beginTransaction();
            $objPlan = Plan::find($planId);
            Plan::where('id', $this->planId)->update(['training_day_id' => $objPlan->training_day_id]);
            if (!empty($objPlan)) {
                $draftPlanData = $objPlan->toArray();
                DraftPlan::insert($draftPlanData);
//            dd($draftPlanData);
            }
            $equipments = EquipmentPlan::select('plan_id', 'equipment_id')->where('plan_id', $planId)->get()->toArray();
            DraftEquipmentPlan::where('plan_id', $planId)->delete();
            DraftEquipmentPlan::insert($equipments);
            // Plan training Overview Week
            $planOverviewWeekObj = \App\Models\PlanTrainingOverviewWeek::where('plan_id', $planId)
                ->groupBy('day_id')
                ->get([
                    'plan_id', 'day_id', 'day_plan_id', 'body_part_1', 'body_part_2', 'body_part_3'])
                ->toArray();
            foreach ($planOverviewWeekObj as $key => $row) {
                $planOverviewWeekObj[$key]['plan_id'] = $this->planId;
            }
            DraftPlanTrainingOverviewWeek::where('plan_id', $this->planId)->delete();
            DraftPlanTrainingOverviewWeek::insert($planOverviewWeekObj);

            // Plan Week Training setup
            $arrayPlanTrainingSetup = [];
            $planTrainingSetupObj = \App\Models\PlanWeekTrainingSetup::where('plan_id', $planId)
                ->get([
                    'plan_id', 'day_id', 'plan_training_overview_week_id',
                    'warm_up', 'main_workout', 'cardio', 'cool_down', 'is_main_workout_top'])
                ->toArray();
            array_multisort(array_column($planTrainingSetupObj, 'day_id'), SORT_ASC, $planTrainingSetupObj);
            $objPlanTrainingOverviewIds = DraftPlanTrainingOverviewWeek::select('id')->where('plan_id', $this->planId)->orderBy('day_id')->get()->toArray();
            foreach ($planTrainingSetupObj as $key => $row) {
                $planTrainingSetupObj[$key]['plan_id'] = $this->planId;
                $planTrainingSetupObj[$key]['plan_training_overview_week_id'] = $objPlanTrainingOverviewIds[$key]['id'];
//                $planTrainingSetupObj[$key]['id'] = '';
            }

            $ids = DraftPlanWeekTrainingSetup::select('id')->where('plan_id', '=', $this->planId)->get();
            if (!empty($ids)) {
                $ids = array_column($ids->toArray(), 'id');
                DraftPlanWeekTrainingSetupPosition::whereIn('plan_week_training_setup_id', $ids)->delete();
            }

            DraftPlanWeekTrainingSetup::where('plan_id', $this->planId)->delete();
            DraftPlanWeekTrainingSetup::insert($planTrainingSetupObj);
//            echo '<pre>'; print_r($planTrainingSetupObj); exit;

            // plan week training setup position
            $planSetupId = \App\Models\PlanWeekTrainingSetup::select('id', 'day_id')->where('plan_id', $planId)->orderBy('day_id')->get()->toArray();
            $data = [];
            $clientPlanSetupTrainingObjIds = DraftPlanWeekTrainingSetup::where('plan_id', $this->planId)->get()->toArray();
            $clientPlanSetupTrainingObjIds = array_column($clientPlanSetupTrainingObjIds, null, 'day_id');
            $planSetupId = array_column($planSetupId, null, 'day_id');
            $data[]['draft'] = $clientPlanSetupTrainingObjIds;
            foreach ($planSetupId as $key => $setupId) {
                $data[$key]['setup_id'] = $setupId;
                $planWeekTrainingSetupPositionObj = \App\Models\PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', $setupId['id'])
                    ->get(['plan_week_training_setup_id', 'workout_type_set_id',
                        'workout_main_counter', 'position', 'exercise_set'])
                    ->toArray();

//                DraftPlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', $clientPlanSetupTrainingObjIds[$key]['id'])->delete();
                if ($planWeekTrainingSetupPositionObj) {
                    if (!empty($clientPlanSetupTrainingObjIds[$key])) {
                        foreach ($planWeekTrainingSetupPositionObj as $item) {
                            $item['plan_week_training_setup_id'] = $clientPlanSetupTrainingObjIds[$key]['id'];
                            $data[] = $item;
                            DraftPlanWeekTrainingSetupPosition::insert($item);
                        }
                    }
                }
            }
//            dd($data);
            // temp table
            $tempTrainingSetupObj = \App\Models\TempTrainingSetup::where('plan_id', $planId)
                ->get(['plan_id', 'day_id', 'structure_id', 'workout_main_counter', 'position'])
                ->toArray();
            foreach ($tempTrainingSetupObj as $key => $row) {
                $tempTrainingSetupObj[$key]['plan_id'] = $this->planId;
            }
            DraftTempTrainingSetup::where('plan_id', $this->planId)->delete();
            DraftTempTrainingSetup::insert($tempTrainingSetupObj);
            // drag drop table

            $clientTempTrainingSetupObj = DraftTempTrainingSetup::where('plan_id', $this->planId)->get()->toArray();
            $arrTemp = [];
            foreach ($clientTempTrainingSetupObj as $row) {
                $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_main_counter']] = $row['id'];
            }
            $planDragDropStructureObj = \App\Models\PlanDragDropStructure::where('plan_id', $planId)
                ->get(['plan_id', 'day_id', 'structure_id', 'exercise_id', 'workout_counter', 'workout_sub_counter',
                    'workout_type', 'workout_set_type_id', 'position', 'position_id', 'set_id', 'rep_id', 'duration_id',
                    'note_id', 'rm_id', 'tempo_id', 'rest_id', 'form_id', 'stage_id', 'wr_id'])
                ->toArray();

            $clientWeekTrainingSetup = DraftPlanWeekTrainingSetup::select('day_id', 'cp.id', 'workout_type_set_id', 'workout_main_counter')
                ->where('plan_id', '=', $this->planId)
                ->join('draft_plan_week_training_setup_positions as cp', 'cp.plan_week_training_setup_id', '=', 'draft_plan_week_training_setups.id')
                ->get()->toArray();
            $arrTempPlan = [];
            foreach ($clientWeekTrainingSetup as $row) {
                $arrTempPlan[$planId][$row['day_id']][$row['workout_type_set_id']][$row['workout_main_counter']] = $row['id'];
            }
            foreach ($planDragDropStructureObj as $key => $row) {
                $planDragDropStructureObj[$key]['plan_id'] = $this->planId;
                if ($row['structure_id'] != 2 && !empty($arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']])) {
                    $planDragDropStructureObj[$key]['position_id'] = $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']];
                } elseif ($row['structure_id'] == 2 && !empty($arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']])) {
                    $planDragDropStructureObj[$key]['position_id'] = $arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']];
                }
            }
            DraftPlanDragDropStructure::where('plan_id', $this->planId)->delete();
            DraftPlanDragDropStructure::insert($planDragDropStructureObj);

            // plan comment table
            $planTrainingCommentObj = \App\Models\PlanTrainingComment::where('plan_id', $planId)
                ->get(['plan_id', 'day_id', 'comment'])
                ->toArray();
            foreach ($planTrainingCommentObj as $key => $row) {
                $planTrainingCommentObj[$key]['plan_id'] = $this->planId;
            }
            DraftPlanTrainingComment::where('plan_id', $this->planId)->delete();
            DraftPlanTrainingComment::insert($planTrainingCommentObj);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
        }


    }

    /**
     * this is used to import draft plan into main plan tables
     * @param $planId
     */
    public function importDraftToMainPlan($planId){
        try{
            DB::beginTransaction();
            $obj = Plan::find($planId);
            PlanTrainingOverviewWeek::where('plan_id', '=', $planId)->delete();
            $ids = PlanWeekTrainingSetup::select('id')->where('plan_id', '=', $planId)->get();
            if (!empty($ids)) {
                $ids = array_column($ids->toArray(), 'id');
                PlanWeekTrainingSetupPosition::whereIn('plan_week_training_setup_id', $ids)->delete();
            }
            TempTrainingSetup::where('plan_id', '=', $planId)->delete();
            PlanDragDropStructure::where('plan_id', '=', $planId)->delete();
            PlanWeekTrainingSetup::where('plan_id', '=', $planId)->delete();
            PlanTrainingComment::where('plan_id',$planId)->delete();

            $this->planId = $planId;

            // Plan training Overview Week
            $planOverviewWeekObj = \App\Models\DraftPlanTrainingOverviewWeek::where('plan_id', $planId)
                ->groupBy('day_id')
                ->get([
                    'plan_id', 'day_id', 'day_plan_id', 'body_part_1', 'body_part_2', 'body_part_3'])
                ->toArray();
            foreach ($planOverviewWeekObj as $key => $row) {
                $planOverviewWeekObj[$key]['plan_id'] = $this->planId;
            }
            PlanTrainingOverviewWeek::where('plan_id', $this->planId)->delete();
            PlanTrainingOverviewWeek::insert($planOverviewWeekObj);

            // Plan Week Training setup
            $arrayPlanTrainingSetup = [];
            $planTrainingSetupObj = \App\Models\DraftPlanWeekTrainingSetup::where('plan_id', $planId)
                ->get([
                    'plan_id', 'day_id', 'plan_training_overview_week_id',
                    'warm_up', 'main_workout', 'cardio', 'cool_down', 'is_main_workout_top'])
                ->toArray();
            array_multisort(array_column($planTrainingSetupObj, 'day_id'), SORT_ASC, $planTrainingSetupObj);
            $objPlanTrainingOverviewIds = PlanTrainingOverviewWeek::select('id')->where('plan_id', $this->planId)->get()->toArray();

            foreach ($planTrainingSetupObj as $key => $row) {
                $planTrainingSetupObj[$key]['plan_id'] = $this->planId;
                $planTrainingSetupObj[$key]['plan_training_overview_week_id'] = $objPlanTrainingOverviewIds[$key]['id'];
//                $planTrainingSetupObj[$key]['id'] = '';
            }
            PlanWeekTrainingSetup::where('plan_id', $this->planId)->delete();
            PlanWeekTrainingSetup::insert($planTrainingSetupObj);
//            echo '<pre>'; print_r($planTrainingSetupObj); exit;

            // plan week training setup position
            $planSetupId = \App\Models\DraftPlanWeekTrainingSetup::select('id', 'day_id')->where('plan_id', $planId)->get()->toArray();
            $clientPlanSetupTrainingObjIds = PlanWeekTrainingSetup::where('plan_id', $this->planId)->get()->toArray();

            $planSetupId = array_column($planSetupId, null, 'day_id');
            $clientPlanSetupTrainingObjIds = array_column($clientPlanSetupTrainingObjIds, null, 'day_id');
            foreach ($planSetupId as $key => $setupId) {
                $planWeekTrainingSetupPositionObj = \App\Models\DraftPlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', $setupId['id'])
                    ->get(['plan_week_training_setup_id', 'workout_type_set_id',
                        'workout_main_counter', 'position', 'exercise_set'])
                    ->toArray();
                if ($planWeekTrainingSetupPositionObj) {
                    if (!empty($clientPlanSetupTrainingObjIds[$key])) {
                        foreach ($planWeekTrainingSetupPositionObj as $item) {
                            $item['plan_week_training_setup_id'] = $clientPlanSetupTrainingObjIds[$key]['id'];
                            PlanWeekTrainingSetupPosition::insert($item);
                        }
                    }
                }
            }

            // temp table
            $tempTrainingSetupObj = \App\Models\DraftTempTrainingSetup::where('plan_id', $planId)
                ->get(['plan_id', 'day_id', 'structure_id', 'workout_main_counter', 'position'])
                ->toArray();
            foreach ($tempTrainingSetupObj as $key => $row) {
                $tempTrainingSetupObj[$key]['plan_id'] = $this->planId;
            }
            TempTrainingSetup::where('plan_id', $this->planId)->delete();
            TempTrainingSetup::insert($tempTrainingSetupObj);
            // drag drop table

            $clientTempTrainingSetupObj = TempTrainingSetup::where('plan_id', $this->planId)->get()->toArray();
            $arrTemp = [];
            foreach ($clientTempTrainingSetupObj as $row) {
                $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_main_counter']] = $row['id'];
            }
            $planDragDropStructureObj = \App\Models\DraftPlanDragDropStructure::where('plan_id', $planId)
                ->get(['plan_id','day_id', 'structure_id', 'exercise_id', 'workout_counter', 'workout_sub_counter',
                    'workout_type', 'workout_set_type_id', 'position', 'position_id', 'set_id', 'rep_id', 'duration_id',
                    'note_id', 'rm_id', 'tempo_id', 'rest_id', 'form_id', 'stage_id', 'wr_id'])
                ->toArray();

            $clientWeekTrainingSetup = PlanWeekTrainingSetup::select('day_id', 'cp.id', 'workout_type_set_id', 'workout_main_counter')
                ->where('plan_id', '=', $this->planId)
                ->join('plan_week_training_setup_positions as cp', 'cp.plan_week_training_setup_id', '=', 'plan_week_training_setups.id')
                ->get()->toArray();
            $arrTempPlan = [];
            foreach ($clientWeekTrainingSetup as $row) {
                $arrTempPlan[$planId][$row['day_id']][$row['workout_type_set_id']][$row['workout_main_counter']] = $row['id'];
            }
            foreach ($planDragDropStructureObj as $key => $row) {
                $planDragDropStructureObj[$key]['plan_id'] = $this->planId;
                if ($row['structure_id'] != 2 && !empty($arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']])) {
                    $planDragDropStructureObj[$key]['position_id'] = $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']];
                } elseif ($row['structure_id'] == 2 && !empty($arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']])) {
                    $planDragDropStructureObj[$key]['position_id'] = $arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']];
                }
            }
            PlanDragDropStructure::where('plan_id', $this->planId)->delete();
            PlanDragDropStructure::insert($planDragDropStructureObj);

            // plan comment table
            $planTrainingCommentObj = \App\Models\DraftPlanTrainingComment::where('plan_id', $planId)
                ->get(['plan_id', 'day_id', 'comment'])
                ->toArray();
            foreach ($planTrainingCommentObj as $key => $row) {
                $planTrainingCommentObj[$key]['plan_id'] = $this->planId;
            }
            PlanTrainingComment::where('plan_id', $this->planId)->delete();
            PlanTrainingComment::insert($planTrainingCommentObj);

            DraftPlanTrainingOverviewWeek::where('plan_id', '=', $planId)->delete();
            $ids = DraftPlanWeekTrainingSetup::select('id')->where('plan_id', '=', $planId)->get();
            if (!empty($ids)) {
                $ids = array_column($ids->toArray(), 'id');
                DraftPlanWeekTrainingSetupPosition::whereIn('plan_week_training_setup_id', $ids)->delete();
            }
            DraftTempTrainingSetup::where('plan_id', '=', $planId)->delete();
            DraftPlanDragDropStructure::where('plan_id', '=', $planId)->delete();
            DraftPlanWeekTrainingSetup::where('plan_id', '=', $planId)->delete();
            DraftPlanTrainingComment::where('plan_id',$planId)->delete();
            DraftEquipmentPlan::where('plan_id',$planId)->delete();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
        }
        return true;
    }

    /**
     * this is used to import day plan from main table to draft tables
     * @param $planId
     */
    public function importDayPlanOnEdit($planId){
        $importDayId = 8;
        $this->planId = $planId;
        try {

            DB::beginTransaction();
            $objPlan = Plan::find($planId);
            Plan::where('id', $this->planId)->update(['training_day_id' => $objPlan->training_day_id]);
            if (!empty($objPlan)) {
                $draftPlanData = $objPlan->toArray();
                DraftPlan::insert($draftPlanData);
//            dd($draftPlanData);
            }
            $equipments = EquipmentPlan::select('plan_id', 'equipment_id')->where('plan_id', $planId)->get()->toArray();
            DraftEquipmentPlan::where('plan_id', $planId)->delete();
            DraftEquipmentPlan::insert($equipments);

            $planOverviewWeekObj = \App\Models\PlanTrainingOverviewWeek::where(['plan_id' => $planId, 'day_id' => 8])
                ->get([
                    'plan_id', 'day_id', 'day_plan_id', 'body_part_1', 'body_part_2', 'body_part_3'])
                ->toArray();
            foreach ($planOverviewWeekObj as $key => $row) {
                $planOverviewWeekObj[$key]['plan_id'] = $this->planId;
                $planOverviewWeekObj[$key]['day_id'] = $importDayId;
            }
            $arrOverViewWeek = [];
            for ($i = 0; $i < 7; $i++) {
                $arrOverViewWeek[$i + 1]['day_id'] = $i + 1;
                $arrOverViewWeek[$i + 1]['day_plan_id'] = 2;
                $arrOverViewWeek[$i + 1]['plan_id'] = $this->planId;
                $arrOverViewWeek[$i + 1]['body_part_1'] = '';
                $arrOverViewWeek[$i + 1]['body_part_2'] = '';
                $arrOverViewWeek[$i + 1]['body_part_3'] = '';
            }
            $mergArray = array_merge($arrOverViewWeek, $planOverviewWeekObj);
            $mergeOverview = array_column($mergArray, null, 'day_id');
            DraftPlanTrainingOverviewWeek::where('plan_id', $this->planId)
                ->where('day_id', $importDayId)
                ->delete();
            $testOverview = DraftPlanTrainingOverviewWeek::select('id')->where('plan_id', $this->planId)
                ->where('day_plan_id', 1)//  for Training
                ->get();
//                    if(!$testOverview->isEmpty()){
//                        PlanTrainingOverviewWeek::insert($planOverviewWeekObj);
//                    }else{
//                        PlanTrainingOverviewWeek::insert($mergeOverview);
//                    }
            DraftPlanTrainingOverviewWeek::insert($planOverviewWeekObj);
            // Plan Week Training setup
            $planTrainingSetupObj = \App\Models\PlanWeekTrainingSetup::where('plan_id', $planId)
                ->get([
                    'id', 'plan_id', 'day_id', 'plan_training_overview_week_id',
                    'warm_up', 'main_workout', 'cardio', 'cool_down', 'is_main_workout_top'])
                ->toArray();
            $objPlanTrainingOverviewIds = DraftPlanTrainingOverviewWeek::select('id')->where('plan_id', $this->planId)
                ->where('day_id', $importDayId)
                ->get()->toArray();
            foreach ($planTrainingSetupObj as $key => $row) {
                $planTrainingSetupObj[$key]['plan_id'] = $this->planId;
                $planTrainingSetupObj[$key]['plan_training_overview_week_id'] = $objPlanTrainingOverviewIds[$key]['id'];
                $planTrainingSetupObj[$key]['id'] = '';
                $planTrainingSetupObj[$key]['day_id'] = $importDayId;
            }
            DraftPlanWeekTrainingSetup::where('plan_id', $this->planId)
                ->where('day_id', $importDayId)
                ->delete();
            DraftPlanWeekTrainingSetup::insert($planTrainingSetupObj);

            $ids = DraftPlanWeekTrainingSetup::select('id')->where('plan_id', '=', $this->planId)->get();
            if (!empty($ids)) {
                $ids = array_column($ids->toArray(), 'id');
                DraftPlanWeekTrainingSetupPosition::whereIn('plan_week_training_setup_id', $ids)->delete();
            }
            // plan week training setup position
            $planSetupId = \App\Models\PlanWeekTrainingSetup::select('id', 'day_id')->where('plan_id', $planId)->get()->toArray();
            $clientPlanSetupTrainingObjIds = DraftPlanWeekTrainingSetup::where('plan_id', $this->planId)
                ->where('day_id', $importDayId)
                ->get()->toArray();

            $clientPlanSetupTrainingObjIds = array_column($clientPlanSetupTrainingObjIds, null, 'day_id');
            $planSetupId = array_column($planSetupId, null, 'day_id');

            foreach ($planSetupId as $key => $setupId) {
                $planWeekTrainingSetupPositionObj = \App\Models\PlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', $setupId['id'])
                    ->get(['plan_week_training_setup_id', 'workout_type_set_id',
                        'workout_main_counter', 'position', 'exercise_set'])
                    ->toArray();
//                DraftPlanWeekTrainingSetupPosition::where('plan_week_training_setup_id', $clientPlanSetupTrainingObjIds[$key]['id'])->delete();
                if ($planWeekTrainingSetupPositionObj) {
                    if (!empty($clientPlanSetupTrainingObjIds[$key])) {
                        foreach ($planWeekTrainingSetupPositionObj as $item) {
                            $item['plan_week_training_setup_id'] = $clientPlanSetupTrainingObjIds[$key]['id'];
                            DraftPlanWeekTrainingSetupPosition::insert($item);
                        }
                    }
                }
            }
            // temp table
            $tempTrainingSetupObj = \App\Models\TempTrainingSetup::where('plan_id', $planId)
                ->get(['plan_id', 'day_id', 'structure_id', 'workout_main_counter', 'position'])
                ->toArray();

            foreach ($tempTrainingSetupObj as $key => $row) {
                $tempTrainingSetupObj[$key]['plan_id'] = $this->planId;
                if ($tempTrainingSetupObj[$key]['day_id'] == 8)
                    $tempTrainingSetupObj[$key]['day_id'] = $importDayId;
            }

            DraftTempTrainingSetup::where('plan_id', $this->planId)
                ->where('day_id', $importDayId)
                ->delete();
            DraftTempTrainingSetup::insert($tempTrainingSetupObj);
            // drag drop table

            $clientTempTrainingSetupObj = DraftTempTrainingSetup::where('plan_id', $this->planId)->get()->toArray();
            $arrTemp = [];
            foreach ($clientTempTrainingSetupObj as $row) {
                $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_main_counter']] = $row['id'];
            }

            $planDragDropStructureObj = \App\Models\PlanDragDropStructure::where('plan_id', $planId)
                ->get(['plan_id', 'day_id', 'structure_id', 'exercise_id', 'workout_counter', 'workout_sub_counter',
                    'workout_type', 'workout_set_type_id', 'position', 'position_id', 'set_id', 'rep_id', 'duration_id',
                    'note_id', 'rm_id', 'tempo_id', 'rest_id', 'form_id', 'stage_id', 'wr_id'])
                ->toArray();
            foreach ($planDragDropStructureObj as $key => $row) {
                $planDragDropStructureObj[$key]['plan_id'] = $this->planId;
                $planDragDropStructureObj[$key]['day_id'] = $importDayId;
            }

            $clientWeekTrainingSetup = DraftPlanWeekTrainingSetup::select('day_id', 'cp.id', 'workout_type_set_id', 'workout_main_counter')
                ->where('plan_id', '=', $this->planId)
                ->join('draft_plan_week_training_setup_positions as cp', 'cp.plan_week_training_setup_id', '=', 'draft_plan_week_training_setups.id')
                ->get()->toArray();
            $arrTempPlan = [];
            foreach ($clientWeekTrainingSetup as $row) {
                $arrTempPlan[$planId][$row['day_id']][$row['workout_type_set_id']][$row['workout_main_counter']] = $row['id'];
            }
            foreach ($planDragDropStructureObj as $key => $row) {
                $planDragDropStructureObj[$key]['plan_id'] = $this->planId;
                if ($row['structure_id'] != 2 && !empty($arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']])) {
                    $planDragDropStructureObj[$key]['position_id'] = $arrTemp[$planId][$row['day_id']][$row['structure_id']][$row['workout_counter']];
                } elseif ($row['structure_id'] == 2 && !empty($arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']])) {
                    $planDragDropStructureObj[$key]['position_id'] = $arrTempPlan[$planId][$row['day_id']][$row['workout_set_type_id']][$row['workout_counter']];
                }
            }
            DraftPlanDragDropStructure::where('plan_id', $this->planId)
                ->where('day_id', $importDayId)
                ->delete();
            DraftPlanDragDropStructure::insert($planDragDropStructureObj);

            // plan comment table
            $planTrainingCommentObj = \App\Models\PlanTrainingComment::where('plan_id', $planId)
                ->get(['plan_id', 'day_id', 'comment'])
                ->toArray();
            foreach ($planTrainingCommentObj as $key => $row) {
                $planTrainingCommentObj[$key]['plan_id'] = $this->planId;
                $planTrainingCommentObj[$key]['day_id'] = $importDayId;
            }
            DraftPlanTrainingComment::where('plan_id', $this->planId)
                ->where('day_id', $importDayId)
                ->delete();
            DraftPlanTrainingComment::insert($planTrainingCommentObj);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
        return true;
    }
}
