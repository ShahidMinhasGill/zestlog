<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------

| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Api\AuthenticateController@login')->middleware('SecureKey');
Route::post('signup', 'Api\AuthenticateController@signup')->middleware('SecureKey');
Route::get('app/version', 'Api\AuthenticateController@getAppVersion')->middleware('SecureKey');
Route::post('check/invitation/code/validity', 'Api\UserIdentityController@checkInvitationCodeValidity')->middleware('SecureKey');
Route::post('check-unique-number', 'Api\AuthenticateController@isUniqueNumber')->middleware('SecureKey');
Route::post('update/password/on/forget', 'Api\AccountController@updatePasswordOnForget')->middleware('SecureKey');

Route::group([
    'middleware' => ['auth:api', 'SecureKey']
], function() {
    Route::post('logout','Api\AuthenticateController@logout');
    Route::post('change-password', 'Api\AuthenticateController@changePassword');
    Route::post('forgot-password', 'Api\AuthenticateController@forgotPassword');
    Route::post('verify-otp', 'Api\AuthenticateController@verifyOtp');
    Route::post('personalize-program', 'Api\AuthenticateController@personalize_program');
    Route::get('goals', 'Api\AuthenticateController@goals');
    Route::post('check-unique-name', 'Api\AuthenticateController@isUniqueName');
    Route::post('resend-otp', 'Api\AuthenticateController@resendOTP');
    Route::post('update/user/channel/status', 'Api\AuthenticateController@updateUserChannelStatus');
    Route::post('get/user/channel/status', 'Api\AuthenticateController@checkUserChannelStatus');
    Route::post('delete/user/data', 'Api\AuthenticateController@deleteUserData');

//user data
    Route::post('user-info', 'Api\AuthenticateController@userInfo');
    Route::post('user-data-update', 'Api\AuthenticateController@userDataUpdate');
    Route::post('coach/popup/status', 'Api\AuthenticateController@coachPopUpStatus');

    Route::post('change-mobile-number', 'Api\AuthenticateController@changeMobileNumber');
    Route::post('update-mobile-number', 'Api\AuthenticateController@updateMobileNumber');
    Route::post('update-new-mobile-number', 'Api\AuthenticateController@updateNewMobileNumber');
    Route::post('change-email-address', 'Api\AuthenticateController@changeEmailAddress');
    Route::post('update-email-address', 'Api\AuthenticateController@updateEmailAddress');
    Route::post('change-user-name', 'Api\AuthenticateController@changeUserName');
    Route::post('image-upload', 'Api\AuthenticateController@imageUpload');

// plans routes
    Route::post('plan-search-filters', 'Api\PlanController@planSearchFilters');
    Route::post('plans', 'Api\PlanController@plans');

    Route::post('download-plan', 'Api\PlanController@downloadPlans');
    Route::post('is/plan/exist/week', 'Api\PlanController@isProgramExistInWeek');
    Route::post('get-my-plan', 'Api\PlanController@getMyPlan');
    Route::post('get-training-plan-structure', 'Api\PlanController@getTrainingPlanStructure');
    Route::post('get-exercises-training-plan', 'Api\PlanController@getExercisesByTrainingPlan');
    Route::post('get-exercise-detail', 'Api\PlanController@getExerciseDetail');
    Route::post('save-training-plan', 'Api\PlanController@saveWorkoutStructure');
    Route::post('get/save/training/plan', 'Api\PlanController@getWorkoutStructure');


//exercise data
Route::post('exercise', 'Api\PlanController@getExerciseData');
Route::get('get/country', 'Api\PlanController@getCountry');
Route::post('get/city', 'Api\PlanController@getCity');
Route::get('exercise-info-update/{id}', 'Api\ExerciseController@exerciseDataUpdatonee');
Route::post('add/rest/comment', 'Api\PlanController@saveRestComment');
Route::post('get/rest/content', 'Api\PlanController@getDayPlan');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('get/equipment', 'Api\ServicesPricingController@getEquipment');

Route::post('client/selected/equipment', 'Api\ServicesPricingController@clientSelectedEquipments');


// services and pricing routes
Route::post('get/specialists/', 'Api\ServicesPricingController@getSpecialists');
Route::post('get/training/ages/', 'Api\ServicesPricingController@getTrainingAges');
Route::post('get/services/', 'Api\ServicesPricingController@getServices');
Route::post('user/update', 'Api\ServicesPricingController@updateEndUsersData');
Route::post('add/services', 'Api\ServicesPricingController@addEndUserServices');
Route::post('delete/client/services', 'Api\ServicesPricingController@deleteEndUserServices');
Route::post('get/services/detail', 'Api\ServicesPricingController@getServicesDetail');
Route::post('save/service/detail', 'Api\ServicesPricingController@saveServicesDetail');
Route::post('get/final/price', 'Api\ServicesPricingController@getFinalPrices');
Route::post('get/total/final/price', 'Api\ServicesPricingController@getFinalTotalPrices');
Route::post('save/payment', 'Api\ServicesPricingController@savePayment');
Route::post('get/change/week/program', 'Api\ServicesPricingController@weekChange');
Route::post('service/received/status', 'Api\ServicesPricingController@serviceReceived');
Route::post('booking/received/status', 'Api\ServicesPricingController@bookingReceived');

//schedule rout
Route::post('get/session/frequency/coaching/length', 'Api\ScheduleController@getCoachingFrequencyAndLength');
Route::post('get/pt/selected/days', 'Api\ScheduleController@getPersonalTrainingSelectedDays');

Route::post('get/blocked/slots', 'Api\ScheduleController@getBlockedTimeSlots');
Route::post('booking', 'Api\ScheduleController@booking');
Route::post('delete/booking', 'Api\ScheduleController@deleteBooking');
Route::post('delete/reserve/booking', 'Api\ScheduleController@deleteReserveBooking');
Route::post('delete/user/all/reserved/bookings', 'Api\ScheduleController@deleteUserAllReserveBooking');
Route::post('get/weeks/booking/status', 'Api\ScheduleController@getWeeksBookingStatus');


//Start for Log
Route::post('add-log', 'Api\LogController@addLog');
Route::post('add-log-details', 'Api\LogController@addLogDetails');
Route::post('edit-log', 'Api\LogController@editLog');
Route::get('get-log/{id}', 'Api\LogController@getLog');
Route::get('get-log-categories', 'Api\LogController@getLogCategories');
Route::get('get-log-users/{uid}', 'Api\LogController@getUserLog');
Route::get('get-all-logs/{authuid}', 'Api\LogController@getAllLogs');
Route::get('get-category-logs/{authuid}/{categoryid}', 'Api\LogController@getAllLogs');
Route::put('delete-log', 'Api\LogController@deleteLog');
Route::put('filter-log', 'Api\LogController@getFilterLog');
Route::post('remove-image', 'Api\LogController@removeImage');
Route::post('get/privacy/list', 'Api\LogController@getPrivacyList');

//End for log module
//Start for Follower
Route::post('add-follower', 'Api\UserController@addFollower');
Route::post('remove-follower', 'Api\UserController@removeFollower');
Route::get('get-followers/{uid}', 'Api\UserController@getFollowers');
Route::get('get-followings/{uid}', 'Api\UserController@getFollowings');
Route::post('block-user', 'Api\UserController@blockUser');
Route::post('unblock-user', 'Api\UserController@UnblockUser');
Route::get('list-userblock/{uid}', 'Api\UserController@listUserblock');
Route::get('get-user-count/{uid}', 'Api\UserController@getUserCount');
Route::get('get-specializations', 'Api\AccountController@getSpecializations');
Route::post('add-channel-activation', 'Api\AccountController@addChannelActivation');
Route::post('save-privacy-type', 'Api\AccountController@savePrivacyType');
Route::post('update-chat-status', 'Api\AccountController@updateChatStatus');
Route::post('profile-description', 'Api\AccountController@profileDescription');
Route::post('user-deactive', 'Api\AccountController@userDeactive');
Route::get('get-userinfo/{uid}', 'Api\AccountController@getUserInfo');
Route::get('get-log-without-me/{uid}', 'Api\LogController@getLogsWithoutMe');
Route::post('user-active', 'Api\AccountController@userActive');
Route::post('delete/user/account', 'Api\AccountController@deleteUserAccount');
//End for Follower

//End for Follower

// start get client plans
Route::post('client/get/plan', 'Api\ClientPlanController@getPlan');
Route::post('client/get/training/plan/structure', 'Api\ClientPlanController@getTrainingPlanStructure');
Route::post('client/get/exercises/training/plan', 'Api\ClientPlanController@getExercisesByTrainingPlan');
Route::post('client/get/exercise/detail', 'Api\ClientPlanController@getExerciseDetail');
Route::post('client/save/training/plan', 'Api\ClientPlanController@saveWorkoutStructure');
Route::post('client/get/save/training/plan', 'Api\ClientPlanController@getWorkoutStructure');

//start assessment
Route::get('assessments-questions/{uid}', 'Api\AccountController@assessmentsQuestions');
//end assessment

// chanels route
Route::get('get-channel-activation', 'Api\AccountController@getChannelActivation');
Route::get('get/channel/details', 'Api\AccountController@getUserChannelDetails');
Route::post('check-block-user', 'Api\UserController@userBlock');
Route::post('check-following-user', 'Api\UserController@checkFollowing');
Route::post('assessments-answers', 'Api\AccountController@assessmentsAnswers');
Route::get('get-assessments-answers/{uid}', 'Api\AccountController@getAssessmentAnswers');
Route::post('update-new-password', 'Api\AccountController@changePassword');
Route::post('rating/coach/zestlog', 'Api\RatingController@RatingCoachAndZestlog');
Route::post('get/rating/details', 'Api\RatingController@getRatingDetails');
Route::post('get/already/purchased/detail', 'Api\RatingController@getAlreadyPurchasedDetail');
Route::post('get/purchased/services', 'Api\RatingController@getPurchasedServices');
Route::post('review/program', 'Api\RatingController@reviewProgram');
Route::post('get/personal/information', 'Api\RatingController@getPersonalInformation');
Route::post('get/review/services', 'Api\RatingController@getServicesReview');
Route::post('get/client/review', 'Api\RatingController@getClientReview');
Route::post('get/upcoming/schedules', 'Api\ScheduleController@getUpComingSchedules');
Route::post('get/archived/schedules', 'Api\ScheduleController@getArchivedSchedules');
Route::post('get/schedule/week/data', 'Api\ScheduleController@getScheduleWeekData');
Route::post('get/select/week/detail', 'Api\ScheduleController@getSelectWeekDetail');
Route::post('/get/select/week/session/details', 'Api\ScheduleController@getSelectWeekSessionDetail');
Route::post('check/week/publish', 'Api\ScheduleController@checkWeekPublish');
Route::post('get/coach', 'Api\ScheduleController@getCoach');
Route::post('get/dates/weeks', 'Api\ScheduleController@getDateAndWeeks');


// identity route
Route::post('get/user/identity', 'Api\UserIdentityController@getUserIdentity');
Route::post('upload/user/identity/image', 'Api\UserIdentityController@uploadIdentityImage');
Route::post('delete/user/identity/image', 'Api\UserIdentityController@deleteIdentityImage');
Route::post('get/user/notifications', 'Api\UserIdentityController@getUserNotifications');
Route::post('save/user/notifications', 'Api\UserIdentityController@saveUserNotifications');
Route::post('last/user/login', 'Api\UserIdentityController@lastUserLogin');
Route::post('test', 'Api\AuthenticateController@test');
Route::get('test', 'Api\AuthenticateController@test');

Route::post('users/list', 'Api\UserController@userList');
Route::post('save/bank/account/information', 'Api\UserController@saveBankAccountInformation');
Route::post('get/user/bank/account/detail', 'Api\UserController@getUserBankAccountDetail');
Route::post('check/username/public', 'Api\UserIdentityController@checkUserNamePublic');

Route::post('get/user/invitation/code', 'Api\UserIdentityController@getUserInvetationCode');


Route::post('get/notifications', 'Api\AuthenticateController@getNotification');
Route::post('user/read/notifications', 'Api\AuthenticateController@readNotification');
Route::post('checked/user/notifications', 'Api\AuthenticateController@checkedNotification');
Route::post('get/latest/notifications/count', 'Api\AuthenticateController@countNotification');
Route::post('get/terms/policy', 'Api\AuthenticateController@getTermPolicy');
Route::post('get/payment/secret/key', 'Api\ServicesPricingController@paymentSecretKey');
Route::post('save/stripe/payment', 'SubscriptionController@savePaymentStripe');
Route::post('save/weight/unit', 'Api\UserController@saveWeightUnit');

});

