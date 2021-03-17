 <?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

 if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
     error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
 }
Route::get('/', function () {
    return view('welcome');
});
//Route::get('/home', function () {
//    return view('home');
//});
Route::get('/account', function () {
    return view('account');
});
Route::get('/week-plans', function () {
    return view('program-database');
});
Route::get('/day-plans', function () {
    return view('client.plan.one-day-plan.index');
});
Route::get('/plan-creator', function () {
    return view('plan-creator');
});
//Route::get('/receipt', function () {
//    return view('receipt');
//});
 Route::get('/download/receipt', 'Client\EarningsController@getPdfReceipt');


Auth::routes();
Route::get('/login', 'Auth\LoginController@welcomePage');
Route::post('/login', 'Auth\LoginController@login')->name('login');

// Route::get('/home', 'HomeController@index')->name('home');
// account
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/ipartner', 'HomeController@iPartner')->name('iPartner');
Route::get('/test', 'HomeController@test')->name('test');
Route::post('/city', 'Client\AccountController@getCityByCountry')->name('city');
Route::post('/city', 'admin\FreelancespecialistsController@getCityByCountry')->name('city');
Route::get('/logout', 'Auth\LoginController@logout');
Route::resource('account', 'Client\AccountController');

///Plan-creation trainer
Route::group(['middleware' => ['auth']], function () {
    //plans

    Route::resource('plans', 'Client\PlanController');
    Route::get('one/day/plans', 'Client\PlanController@oneDayPlanCreate')->name('one.day.plan');
    Route::Post('day/plans/create', 'Client\PlanController@createPlanOnCreate')->name('create.plan.week');
    Route::match(['GET', 'POST'], '/tabs/{plan_id?}/{day_id?}/{is_edit?}', 'Client\PlanController@TabContent')->name('tab-content');
    Route::match(['GET', 'POST'], 'plans-overview/{id?}/{is_edit?}', 'Client\PlanController@overViewStore')->name('plans-overview');
    Route::match(['GET', 'POST'], 'one/day/plans-overview/{id?}/{is_edit?}', 'Client\PlanController@oneDayOverViewStore')->name('one.day.plans-overview');
    Route::post('plans-weekly-setup', 'Client\PlanController@weeklySetupStore')->name('plans-weekly-setup');
    Route::post('plan-weekly-training-setup', 'Client\PlanController@planWeeklyTrainingSetup')->name('plan-weekly-training-setup');
    Route::post('one-day-plan-weekly-training-setup', 'Client\PlanController@oneDayPlanWeeklyTrainingSetup')->name('one.day.plan-weekly-training-setup');
    Route::post('plan-get-drag-drop-options', 'Client\PlanController@getPlanDragDropOptions')->name('plan-get-drag-drop-options');
    Route::post('get-exercises', 'Client\PlanController@getExercises')->name('get-exercises');
    Route::post('client-get-exercises', 'Client\ClientsTrainingProgramController@clientGetExercises')->name('client-get-exercises');
    Route::post('add-drag-drop-exercise', 'Client\PlanController@addDragAndDropExercise')->name('plan.drag.drop.exercise');
    Route::post('delete-training-plan', 'Client\PlanController@deleteTrainingPlan')->name('delete.training.plan');
    Route::post('plan/add/comment', 'Client\PlanController@addPlanComment')->name('plan.add.comment');
    Route::post('plan/update/drag/drop', 'Client\PlanController@updatePlanDragAndDrop')->name('plan.update.drag.drop');
    Route::post('training/programs', 'Client\PlanController@getTrainingPrograms')->name('plan.get.training.programs');
    Route::post('training/programs/import', 'Client\PlanController@getTrainingPrograms')->name('import.plan.week');
    Route::post('/plan/import-day', 'Client\PlanController@importPlan')->name('import.plan.day');
    Route::post('/plan/import-week', 'Client\PlanController@importWeekPlan')->name('import.plan.week');
    Route::post('/day-plan-save', 'Client\PlanController@dayPlanSave')->name('day.plan.save');
    Route::post('/one-day-plan-save', 'Client\PlanController@oneDayPlanSave')->name('one.day.plan.save');

    Route::post('/add-customize-dropdown', 'Client\PlanController@addCustomizeDropDown')->name('add.customize.dropdown');
    Route::post('/save-customize-dropdown', 'Client\PlanController@saveCustomizeDropDown')->name('save.customize.dropdown');
    Route::post('/remove-customize-dropdown', 'Client\PlanController@removeCustomizeDropDown')->name('remove.customize.dropdown');

    Route::post('add/weekly/training/setup', 'Client\PlanController@addWeeklyTrainingSetup')->name('add.weekly.training.setup');
    Route::post('update/order/workout', 'Client\PlanController@updateOrderWorkout')->name('update.order.workout');
    Route::post('delete/main/workout', 'Client\PlanController@deleteTrainingMainWorkout')->name('delete.training.main.workout');
    Route::post('delete/weekly/workout', 'Client\PlanController@deleteTrainingMainWorkout')->name('delete.training.main.workout');
    Route::post('get/exercise/video', 'Client\PlanController@getExerciseVideo')->name('get.exercise.video');
    Route::post('delete/draft-plan', 'Client\PlanController@deleteDraftPlan')->name('delete.draft.plan');

    Route::get('settings', 'Client\ServicesPricingController@index');
    Route::post('get/services/program', 'Client\ServicesPricingController@getServicesProgram')->name('get.services.program');
    Route::post('save/training/price', 'Client\ServicesPricingController@saveProgramTrainingPrice')->name('save.training.price');
    Route::post('save/services/booking', 'Client\ServicesPricingController@saveServicesBooking')->name('save.services.booking');
    Route::post('calculate/prices', 'Client\ServicesPricingController@calculatePrices')->name('calculate.service.prices');
    Route::post('calculate/prices/diet', 'Client\ServicesPricingController@calculatePricesDiet')->name('calculate.service.diet.prices');
    Route::post('calculate/prices/online/coaching', 'Client\ServicesPricingController@calculatePricesOnlineCoaching')->name('calculate.service.online.coaching.prices');
    Route::post('save/client/currency', 'Client\ServicesPricingController@saveClientCurrency')->name('save.client.currency');

    Route::post('save/coaching/session', 'Client\ServicesPricingController@saveCoachingSession')->name('save.coaching.session');
    Route::post('save/group/coaching', 'Client\ServicesPricingController@saveGroupCoaching')->name('save.group.coaching');
    Route::post('save/pt/locations', 'Client\ServicesPricingController@savePtLocations')->name('save.pt.locations');
    Route::post('add/pt/locations', 'Client\ServicesPricingController@addPtLocations')->name('add.pt.locations');
    Route::post('delete/pt/locations', 'Client\ServicesPricingController@destroyPtLocations')->name('delete.pt.locations');
    Route::post('training/plan/prices/calculate', 'Client\ServicesPricingController@calculateTrainingPlanPrices')->name('calculate.training.plan.prices');
    Route::post('training/plan/prices/save', 'Client\ServicesPricingController@saveTrainingPlanData')->name('save.training.plan.data');

    Route::get('/schedule', 'Client\ScheduleController@index');
    Route::post('/schedule/block/week', 'Client\ScheduleController@updateSchedule')->name('schedule.block.week');
    Route::post('/get/schedule/data', 'Client\ScheduleController@getScheduleData')->name('get.schedule.data');
    Route::post('/block/time/slot', 'Client\ScheduleController@blockTimeSlotClients')->name('block.time.slot');
    Route::post('/block/drag/select-slot', 'Client\ScheduleController@blockDragSlot')->name('block.drag.slot');
    Route::post('/block/drag/slot-save', 'Client\ScheduleController@saveBlockDragSlot')->name('save.block.drag.slot');
    Route::post('get/block/slot-edit', 'Client\ScheduleController@getBlockSlotData')->name('get.block.slot.data');
    Route::post('/edit/block/slot-edit-save', 'Client\ScheduleController@editBlockSlotSaved')->name('edit.block.slot.saved');
    Route::post('/slot/slot-delete', 'Client\ScheduleController@slotDelete')->name('slot.delete');
    Route::post('/upcoming/get-upcoming-program', 'Client\UpcomingProgramController@getUpcomingProgram')->name('get.upcoming.program');


    Route::get('client/{id}/program', 'Client\ClientsTrainingProgramController@index');
    Route::post('client/training/programs', 'Client\ClientsTrainingProgramController@getClientTrainingPrograms')->name('client.plan.get.training.programs');

    Route::resource('clients', 'Client\ClientsController');
    Route::post('/clients/data', 'Client\ClientsController@getClientsData')->name('get.clients.data');
    Route::post('/accept/reject/booking', 'Client\ClientsController@acceptRejectBooking')->name('accept.reject.booking');
    Route::post('/booking/accept/confirmation', 'Client\ClientsController@bookingConfirmation')->name('accept.reject.confirm');
    Route::match(['GET', 'POST'], 'client-plans-overview/{id?}', 'Client\ClientsController@overViewStore')->name('client.plans.overview');
    Route::match(['GET', 'POST'], '/client-tabs/{client_plan_id?}/{day_id?}', 'Client\ClientsController@TabContent')->name('tab.content');
    Route::post('client-plan-weekly-training-setup', 'Client\ClientsController@planWeeklyTrainingSetup')->name('client.plan.weekly.training.setup');
    Route::post('client-plan-get-drag-drop-options', 'Client\ClientsController@getPlanDragDropOptions')->name('client.plan.get.drag.drop.options');
    Route::post('client/add/weekly/training/setup', 'Client\ClientsController@addWeeklyTrainingSetup')->name('client.add.weekly.training.setup');
    Route::post('client-delete-training-plan', 'Client\ClientsController@deleteTrainingPlan')->name('client.delete.training.plan');
    Route::post('client/delete/main/workout', 'Client\ClientsController@deleteTrainingMainWorkout')->name('client.delete.training.main.workout');
    Route::post('client/delete/weekly/workout', 'Client\ClientsController@deleteTrainingMainWorkout')->name('client.delete.training.main.workout');
    Route::post('client/update/order/workout', 'Client\ClientsController@updateOrderWorkout')->name('client.update.order.workout');
    Route::post('client/plan/update/drag/drop', 'Client\ClientsController@updatePlanDragAndDrop')->name('client.plan.update.drag.drop');
    Route::post('client/plan/add/comment', 'Client\ClientsController@addPlanComment')->name('client.plan.add.comment');
    Route::post('client/plan/add/plan', 'Client\ClientsController@addClientWeeklyPlanProfile')->name('client.add.plan');
    Route::post('client-add-drag-drop-exercise', 'Client\ClientsController@addDragAndDropExercise')->name('client.plan.drag.drop.exercise');
    Route::post('/clients/data/info', 'Client\ClientsController@getSelectedClientInformation')->name('get.clients.info');
    Route::post('/client/plan/publish', 'Client\ClientsController@publishClientPlan')->name('publish.client.plan');
    Route::post('/client/plan/import', 'Client\ClientsController@importPlan')->name('import.plan');
    Route::post('/client/training/program', 'Client\ClientsController@clientTainingProgramPopup')->name('client.training.program');

    Route::post('/client/day-plan-save', 'Client\ClientsController@dayPlanSave')->name('client.day.plan.save');
    Route::post('/client/one-day-plan-save', 'Client\ClientsController@oneDayPlanSave')->name('client.one.day.plan.save');
    // Accounts
    Route::get('freelance/account', 'Client\AccountController@index')->name('freelance-profile-account');
    Route::post('freelance/bank/account-detail-edit', 'Client\AccountController@bankInformation')->name('freelance-bank-account');
    Route::post('/user/booking-information', 'Client\AccountController@userBookingInformations')->name('user.booking.information');


    Route::get('/create-connect-account', 'Client\AccountController@createConnectAccount');
    Route::get('/transfer-amount', 'Client\AccountController@transferAmount');

    Route::get('/earnings', 'Client\EarningsController@index');
    Route::post('/coach/funds', 'Client\EarningsController@getCoachFunds')->name('get.coach.funds');
    Route::get('/coach/receipt/{id}', 'Client\EarningsController@getCoachReceipt')->name('get.coach.receipt');

});

// admin Routes with auth and adminMiddleware
Route::group(['middleware' => ['adminMiddleware','auth']], function () {
    Route::resource('database', 'admin\DatabaseController');
    Route::resource('end-users', 'admin\EndUsersController');
    Route::resource('freelance-specialists', 'admin\FreelancespecialistsController');
    Route::resource('admin', 'admin\HomeController');
    Route::resource('subscriber-profile', 'admin\SubscriberprofileController');
    Route::get('/dashboard', 'admin\HomeController@index')->name('dashboard');

    Route::post('/end-users/data', 'admin\EndUsersController@getUserData')->name('end-user.get.users.data');
    Route::post('/freelance-users/data', 'admin\FreelancespecialistsController@getFreelanceUserData')->name('freelance-users.get.users.data');
    Route::get('import-exercise-images/{type?}', 'admin\DatabaseController@importImages');
    Route::post('/get-exercise', 'admin\DatabaseController@getExercises')->name('get.exercises');
    Route::post('/save', 'admin\DatabaseController@save');

    Route::get('/admin', 'admin\HomeController@index');
    Route::get('/endusers', 'admin\EndUsersController@index');
    Route::post('import', 'admin\DatabaseController@import')->name('import');
    Route::get('/live_search', 'admin\DatabaseController@index');
    Route::get('/live_search/action', 'admin\DatabaseController@action')->name('live_search.action');

    Route::get('image', 'admin\DatabaseController@index');

    Route::get('freelance-profile/{id}', 'admin\FreelanceAccountSetting@index');
    Route::Post('save/identity/data', 'admin\FreelanceAccountSetting@saveIdentityData')->name('save.identity.data');
    Route::Post('save/end-user/identity/data', 'admin\EndUserAccountSetting@endUserSaveIdentityData')->name('save.end-user.identity.data');
    Route::Post('client/education-verify', 'admin\FreelanceAccountSetting@saveEducationVerifyStatus')->name('client.education.verify');
    Route::get('enduser-profile/{id}', 'admin\EndUserAccountSetting@index');
    Route::Post('edit/mobile/data', 'admin\FreelanceAccountSetting@editMobileNumber')->name('edit.mobile.data');

    Route::Post('education-certificate', 'admin\FreelanceAccountSetting@educationCertificate')->name('education.certificate');

    Route::get('bookings', 'admin\BookingsController@index');
    Route::post('partner/bookings', 'admin\BookingsController@getActiveUserData')->name('get.partner.bookings');
    Route::get('client-earnings', 'admin\CoachEarningsController@index');
    Route::post('partner-earning', 'admin\CoachEarningsController@getCoachFunds')->name('get.partner.earning');
    Route::post('coach-pay', 'admin\CoachEarningsController@coachPay')->name('coach.pay');



});
 Route::get('/test/score', 'Client\AccountController@updateClientScore');
 Route::get('/update-bookings', 'Client\AccountController@updateBookings');
Route::get('/subscription', 'SubscriptionController@create')->name('subscription.create');
Route::get('reviews', function () {
    return view('admin.reviews.index');
});
Route::get('/admin-schedule', function () {
    return view('admin.schedule.index');
});

 Route::get('/test/earning', 'Client\EarningsController@testClientEarning');
 Route::get('/test/transfer/earning', 'Client\EarningsController@testClientEarningTransfer');

//Route::get('enduser-profile/{id}', function () {
//    return view('admin.endusers.enduser-profile');
//});

//Route::get('freelance-profile-edit', function () {
//    return view('admin.freelance.freelance-profile-edit');
//});


// client pages routs
Route::get('/client-new', function () {
    return view('client.account');
});
// Route::get('/images-test', function () {
//     return view('images-compress');
// });
 Route::get('/images-test', 'ImagesCompressController@showUploadForm');
 Route::post('/upload', 'ImagesCompressController@storeUploads');

 Route::get('/terms-of-service', 'Client\TermPolicyController@getTerms')->name('terms');
 Route::get('/privacy-policy', 'Client\TermPolicyController@getPrivacyPolicy')->name('privacy-policy');
 Route::post('/images-rout', 'ImagesCompressController@store')->name('images-rout');



//Route::get('/schedule', function () {
//    return view('client.schedule');
//});
//Route::get('/clients', function () {
//    return view('client.clients');
//});
//Route::get('/settings', function () {
//    return view('client.settings');
//});
Route::get('/program-database', function () {
    return view('client.program-database');
});
//Route::get('/earnings', function () {
//    return view('earnings');
//});

// client superAdmin routs
Route::get('/client/admin/account', function () {
    return view('client.admin.account');
});
Route::get('/client/admin/clients', function () {
    return view('client.admin.clients');
});
Route::get('/client/admin/client-profile', function () {
    return view('client.admin.client-profile');
});
Route::get('/client/admin/database', function () {
    return view('client.admin.database');
});
Route::get('/client/admin/support', function () {
    return view('client.admin.support');
});
