@extends('admin.layouts.app')
<style>
    thead tr th select {
        min-width: 80px;
    }
     .display-none {
         display: none !important;
     }
</style>
@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <nav>
             {{--   <div class="nav nav-pills" role="tablist">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#bookins-active" role="tab" aria-controls="bookins-active" aria-selected="true">Active</a>

                    <a class="nav-item nav-link" data-toggle="tab" href="#bookins-waiting" role="tab" aria-controls="bookins-waiting" aria-selected="false">Waiting</a>

                    <a class="nav-item nav-link" data-toggle="tab" href="#bookins-archived" role="tab" aria-controls="bookins-archived" aria-selected="false">Archived</a>

                </div>--}}
                <div class="nav nav-pills" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active action_freelance" id="active" value="active" data-toggle="tab" href="#nav-Active" role="tab" aria-controls="nav-Active" aria-selected="true">Active</a>
                    <a class="nav-item nav-link action_freelance" id="waiting" value="waiting" data-toggle="tab" href="#nav-Waiting" role="tab" aria-controls="nav-Waiting" aria-selected="false">Waiting</a>
                    <a class="nav-item nav-link action_freelance" id="archived" value="archived" data-toggle="tab" href="#nav-Archived" role="tab" aria-controls="nav-Archived" aria-selected="false">Archived</a>

                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="bookins-active" role="tabpanel" aria-labelledby="bookins-active-tab">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nr</th>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck333">
                                            <label class="custom-control-label" for="customCheck333"></label>
                                        </div>
                                    </th>
                                    <th>
                                        Client<br>
                                        <div class="table-search d-flex mr-2">
                                            <i class="fas fa-search"></i>
                                            <input type="text" id="search" name="search" placeholder="Search a name" class="form-control table-name-search">
                                        </div>
                                    </th>
                                    <th scope="col" class="text-center">Username
                                        <div class="table-search d-flex mr-2">
                                            <i class="fas fa-search"></i>
                                            <input type="text" placeholder="Search a user name" class="form-control" style="width: 200px;"id="userName">
                                        </div>
                                    </th>
                                    <th>
                                        Partner<br>
                                        <div class="table-search d-flex mr-2">
                                            <i class="fas fa-search"></i>
                                            <input type="text" id="partner" name="search" placeholder="Search a name" class="form-control">
                                        </div>
                                    </th>
                                    <th>Age<br>
                                        {!! Form::select('age', $age , null , ['class' => 'custom-select drop_down_filters', 'id' => 'age']) !!}</th>
                                    <th >Gender
                                        <br><select  class="custom-select drop_down_filters" id="gender">
                                            <option selected=""value="">Select</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </th>

                                    <th scope="col" class="text-center ">BMI category
                                        <br><select style="width:80px;" class="custom-select drop_down_filters" id="bmi">
                                            <option value="" selected="">All</option>
                                            <option value="1">Underweight (<18.5)</option>
                                            <option value="2">Normal (18.5 - 24.9)</option>
                                            <option value="3">Overweight (25 - 29.9)</option>
                                            <option value="4">Obese (30 & Above)</option>
                                        </select>
                                    </th>
                                    <th>Booking Submission
                                        <br><input type="date"name="booking-submission" id="bookingSubmission" class="form-control" style="width: 200px;">
                                    </th>
                                    <th scope="col" class="text-center">Booking Subtotal
                                        <br><select style="width:80px;" class="custom-select">
                                            <option selected="">All</option>
                                        </select>
                                    </th>
                                    <th scope="col" class="text-center">Country
                                        <br>{!! Form::select('country', $countries, null , ['class' => 'custom-select drop_down_filters','id'=>'country','name'=>'country']) !!}
                                    </th>
                                    <th scope="col" class="text-center">City
                                        <br> {!! Form::select('city', $cities,null, ['class' => 'custom-select form-control drop_down_filters', 'id' => 'cityList']) !!}
                                    </th>
                                    <th scope="col" id="reason_archived" class="text-center display-none">Reason for Archiving
                                        <br> {!! Form::select('reason_archiving', ['' => 'All', 1 => 'Completed', 2 => 'Rejected'],null, ['class' => 'custom-select form-control drop_down_filters', 'id' => 'reason_archiving']) !!}
                                    </th>
                                    <th scope="col" colspan="3" class="text-left">Status</th>

                                </tr>
                            </thead>

                            <tbody>
                            <tbody id="page-data"></tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="bookins-waiting" role="tabpanel" aria-labelledby="bookins-waiting-tab">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nr</th>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck333">
                                            <label class="custom-control-label" for="customCheck333"></label>
                                        </div>
                                    </th>
                                    <th>
                                        Client<br>
                                        <div class="table-search d-flex mr-2">
                                            <i class="fas fa-search"></i>
                                            <input type="text" id="search" name="search" placeholder="Search a name" class="form-control table-name-search">
                                        </div>
                                    </th>
                                    <th>
                                        Age
                                        <br><select class="custom-select">
                                            <option selected="">All</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </th>
                                    <th>
                                        Gender
                                        <br><select class="custom-select">
                                            <option selected="">All</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </th>
                                    <th>
                                        BMI category
                                        <br><select class="custom-select">
                                            <option selected="">All</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </th>

                                    <th>Booking submission<br>
                                        <input type="date" class="form-control" value="dd/mm/yyyy"></th>
                                    <th>
                                        Booking subtotal
                                        <br><select class="custom-select">
                                            <option selected="">All</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </th>
                                    <th>
                                        Country
                                        <br><select class="custom-select">
                                            <option selected="">All</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </th>
                                    <th>
                                        City
                                        <br><select class="custom-select">
                                            <option selected="">All</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </th>
                                    <th>
                                        Partner<br>
                                        <div class="table-search d-flex mr-2">
                                            <i class="fas fa-search"></i>
                                            <input type="text" id="search" name="search" placeholder="Search a name" class="form-control">
                                        </div>
                                    </th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th>1</th>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cl1">
                                            <label class="custom-control-label" for="cl1"></label>
                                        </div>
                                    </td>
                                    <td class="text-left"><a href="#!">Same Nilson</a></td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>USD 2500</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td><a href="#!">James Wrights</a></td>
                                    <td><b>Waiting</b></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="bookins-archived" role="tabpanel" aria-labelledby="bookins-archived-tab">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nr</th>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck333">
                                            <label class="custom-control-label" for="customCheck333"></label>
                                        </div>
                                    </th>
                                    <th>
                                        Client<br>
                                        <div class="table-search d-flex mr-2">
                                            <i class="fas fa-search"></i>
                                            <input type="text" id="search" name="search" placeholder="Search a name" class="form-control table-name-search">
                                        </div>
                                    </th>
                                    <th>
                                        Age
                                        <br><select class="custom-select">
                                            <option selected="">All</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </th>
                                    <th>
                                        Gender
                                        <br><select class="custom-select">
                                            <option selected="">All</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </th>
                                    <th>
                                        BMI category
                                        <br><select class="custom-select">
                                            <option selected="">All</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </th>

                                    <th>Booking submission<br>
                                        <input type="date" class="form-control" value="dd/mm/yyyy"></th>
                                    <th>
                                        Booking subtotal
                                        <br><select class="custom-select">
                                            <option selected="">All</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </th>
                                    <th>
                                        Country
                                        <br><select class="custom-select">
                                            <option selected="">All</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </th>
                                    <th>
                                        City
                                        <br><select class="custom-select">
                                            <option selected="">All</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </th>
                                    <th>
                                        Partner<br>
                                        <div class="table-search d-flex mr-2">
                                            <i class="fas fa-search"></i>
                                            <input type="text" id="search" name="search" placeholder="Search a name" class="form-control">
                                        </div>
                                    </th>
                                    <th>
                                        Reason for Archiving
                                        <br><select class="custom-select">
                                            <option selected="">All</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody id="page-data"></tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('after-scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{!! asset('css/fancybox/jquery.fancybox.css') !!}"/>
    {!! Html::script('js/fancybox/jquery.fancybox.js') !!}
    {!! Html::script('js/fancybox/jquery.fancybox.pack.js') !!}
    <script type="text/javascript">
        $route = '{{ URL::route('city') }}';
        $getClientsDataRoute = '{{ URL::route('get.partner.bookings') }}';
        $getClientInfoRout = '{{ URL::route('get.clients.info') }}';
        $acceptRejectRoute = '{{ URL::route('accept.reject.booking') }}';
        $addClientPlanProfile = '{{ URL::route('client.add.plan') }}';
        $acceptOrRejectBooking = '{{ URL::route('accept.reject.confirm')}}';
        $weeklyTrainingSetupRoute = '{{ URL::route('client.plan.weekly.training.setup')}}';
        $getDragDropOptionsRoute = '{{ URL::route('client.plan.get.drag.drop.options') }}';
        $addWeeklyTrainingSetupRoute = '{{ URL::route('client.add.weekly.training.setup') }}';
        $deleteRoute = '{{ URL::route('client.delete.training.plan') }}';
        $deleteSubRoute = '{{ URL::route('client.delete.training.main.workout') }}';
        $updateOrderWorkoutRoute = '{{ URL::route('client.update.order.workout') }}';
        $planUpdateDragDropRoute = '{{ URL::route('client.plan.update.drag.drop') }}';
        $getExercisesRoute = '{{ URL::route('get-exercises') }}';
        $getExerciseVideoRoute = '{{ URL::route('get.exercise.video') }}';
        $addDragdropRoute = '{{ URL::route('client.plan.drag.drop.exercise') }}';
        $addCommentRoute = '{{ URL::route('client.plan.add.comment') }}';
        $publishClientPlanRout = '{{ URL::route('publish.client.plan') }}';
        $importPlanRoute = '{{ URL::route('import.plan') }}';
        $importPlanDataRout = '{{ URL::route('plan.get.training.programs') }}';
        $token = "{{ csrf_token() }}";
        $page = 1;
        $search = '';
        $asc = 'asc';
        $desc = 'desc';
        $dragDrop = true;
        {{--$workoutTypeSet = $.parseJSON('{!! $data['workoutTypeSet'] !!}');--}}
        $workoutTypeSet = '';
        // $defaultType = 'renderExercises';
        $defaultType = 'renderClients';
        $sortType = 'desc';
        $sortColumn = 'a.id';
        $dropDownFilters = {};
        $action_freelance = 'active';
        $accountRegDate = '';
        $bmi = '';
        $gender='';
        $userName='';
        $partner='';
        $id = 0;
        $extraId = $exerciseId = $workoutCounter = $workoutSubCounter = $deleteId = $positionId = 0;
        $page = 1;
        $workoutType = '';
        $dropDownFilters = {};
        $addNewRowCount = [];
        $weekId = 1;
        $startWeek = 1;
        $endWeek =1;
        $end = 1;
        $start =1;
        $unique_id = '';
        $user_id = '';
        $year = '1970';
        $bookingSubmission='';
        $startYear = '1970';
        $clientId = 0;
        $userId = 0;
        $isImportRender = 0;
        $weekIncrementValue = 0;
        $plan_type = '';
        $importDayId = '';
        $startProgramDate = '';
        $endProgramDate = '';
        $weeksList = [];
        $enableWeeks = 1;

        $(document).ready(function () {
            $(".client-plan-information-div").hide()
            $("#user-profile").hide()
            // getExercisesData();
            $('#search').val('');
            $(document).on("click", '.paq-pager ul.pagination a', function (e) {
                e.preventDefault();
                $page = $(this).attr('href').split('page=')[1];
                // getExercisesData();
            });
            oncall();
            $('#search').val('');
            $(".action_freelance").click(function (e) {
                e.preventDefault();
                $action_freelance = $(this).attr('id');
                if ($action_freelance === 'archived') {
                    $('#reason_archived').removeClass('display-none');
                } else {
                    $('#reason_archived').addClass('display-none');
                }
                oncall();
            });
            $('#accountRegDate').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $accountRegDate = $(this).val();
                    $page = 1;
                    updateClientFormData();
                    $type = 'renderClients';
                    renderAdmin();
                }
            });

            $('#userName').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $userName = $(this).val();
                    $page = 1;
                    updateFormData();
                    $type = $defaultType;
                    renderAdmin();
                }
            });
            $('#partner').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $partner = $(this).val();
                    $page = 1;
                    updateFormData();
                    $type = $defaultType;
                    renderAdmin();
                }
            });

            $('#bookingSubmission').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $bookingSubmission = $(this).val();
                    $page = 1;
                    updateFormData();
                    $type = $defaultType;
                    renderAdmin();
                }
            });

            $('#country').on('change', function () {
                $('#cityList').empty();
                $.ajax({
                    type: 'POST',
                    url: $route,
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'cca3': this.value
                    },

                    success: function (data) {
                        if (data.code == 200) {
                            data.cityList.forEach(function (obj) {
                                $('#cityList').append(new Option(obj.city, obj.code));

                            });
                        } else {
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });

            });

            $('body').on('click', '.accept-reject-popup', function () {
                let id = this.id.split('_');
                let uniqueId = id[1]+'_'+id[2]+'_'+id[3];
                $formData = {
                    '_token': $token,
                    id: uniqueId
                };
                $.ajax({
                    type: 'POST',
                    url: $acceptRejectRoute,
                    data: $formData,
                    success: function (data) {
                        $.fancybox(data.view, {
                            width : 500,
                            height : 600,
                            fitToView : true,
                            autoSize : false,
                            closeClick: false,
                            closeEffect: false,
                            'autoscale': true,
                            openEffect: 'none'
                        });
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
            // $('body').on('click', '.client_name_click', function () {
            //     let id = this.id.split('_')[2];
            //     let unsplitId = this.id.split('_');
            //     let uniqueId = unsplitId[3]+'_'+unsplitId[4]+'_'+unsplitId[5];
            //     $unique_id = uniqueId;
            //     $(".client-plan-information-div").hide();
            //     $("#user-profile").hide();
            //     $formData = {
            //         '_token': $token,
            //         id: id,
            //         unique_id:uniqueId
            //     };
            //     $.ajax({
            //
            //         type: 'POST',
            //         url: $getClientInfoRout,
            //         data: $formData,
            //         success: function (response) {
            //             if (response.success == true) {
            //                 $id = response.data.id;
            //                 $year = response.data.year;
            //                 $startYear = response.data.year;
            //                 $weekId = response.data.start_week;
            //                 $unique_id = response.data.unique_id;
            //                 $clientId = response.data.client_id;
            //                 $userId = response.data.user_id;
            //                 $startProgramDate = response.data.start_program_date;
            //                 $endProgramDate = response.data.end_program _date;
            //                 $weekIncrementValue = response.data.week_increment_value;
            //                 $weeksList = response.data.weeks;
            //                 $enableWeeks = 1;
            //                 var li;
            //                 $("#list-of-project").empty();
            //                 $.each(response.data.weeks, function (index, value) {
            //                     $.each(value, function (key, row) {
            //                         if (index == parseInt($enableWeeks)) {
            //                             li = "<li class='list-inline-item weeks-ids enable'id=" + key + '_' + row + ">" + index + "</li>"
            //                             $enableWeeks = parseInt($weekIncrementValue) + parseInt($enableWeeks);
            //                         } else {
            //                             li = "<li class='list-inline-item weeks-ids'id=" + key + '_' + row + ">" + index + "</li>"
            //                         }
            //                         if (index == 1) {
            //                             $('#week-year').text('Week' + ' ' + key + ', ' + row);
            //                             $weekId = key;
            //                             $year=row;
            //                         }
            //                     });
            //                     $("#list-of-project").append(li);
            //                 });
            //                 $("#list-of-project").css('color', '#97A59E');
            //                 $(".enable").css('color', 'black');
            //
            //                 $.each(response.data, function (index, value) {
            //                     $('#' + index).val(value);
            //                     $('#' + index).text(value);
            //                     if (index == 'enduser_status') {
            //                         let displayText = 'Archived';
            //                         if (value == 0) {
            //                             displayText = 'Waiting';
            //                         } else if (value == 1) {
            //                             displayText = 'Active';
            //                         }
            //                         $('#' + index).text(displayText);
            //                     } else if (index == 'end_week') {
            //                         $endWeek = value;
            //                         $end = value;
            //                     } else if (index == 'start_week') {
            //                         $startWeek = value;
            //                         $start = value;
            //                         $weekId = value;
            //                     } else if (index == 'client_plan_id') {
            //                         $id = value;
            //                     } else if (index == 'user_id') {
            //                         $user_id = value;
            //                     }
            //                 });
            //                 if (response.data.is_publish_plan == 1) {
            //                     $('#is_publish_plan').html('Published');
            //
            //                 } else {
            //                     $('#is_publish_plan').html('Not Published');
            //                 }
            //             }
            //             getWeeklyPlanSetup();
            //         },
            //         error: function (error) {
            //             console.log(error);
            //         }
            //     });
            // });
            $('body').on('click', '#increment-week', function () {
                $weekId = $('#week_id').html().split(' ')[1];
                $weekEnd = (Number($weekId) + Number($weekIncrementValue));
                if ($weekId < $weekEnd) {
                    $weekId = (Number($weekId) + Number($weekIncrementValue));
                    if($weekId > 52){
                        $weekId = ($weekId - 52)
                        $year++;
                    }
                    $('#week_id').html('Week ' + $weekId);
                }
                getClientLatestPlanId();
                getWeeklyPlanSetup();
            });
            $('body').on('click', '#decrement-week', function () {
                $weekId = $('#week_id').html().split(' ')[1];
                $weekId = (Number($weekId) - Number($weekIncrementValue));
                if ($weekId < 1) {
                    $weekId = 52 + $weekId;
                    $('#week_id').html('Week ' + $weekId);
                    $year--;
                }
                else if ($weekId >= $start) {
                    $('#week_id').html('Week ' + $weekId);
                }
                getClientLatestPlanId();
                getWeeklyPlanSetup();
            });
            $('body').on('change', '.weekly-workout-filters', function () {
                let clickedId = this.id.split('_');
                let clickedUniqueId = clickedId[1] + '_' + clickedId[2];
                let clickedValue = this.value;
                var arrayTypes = ['vertical', 'circuit'];
                if (arrayTypes.indexOf(clickedValue) == -1) {
                    $('#exercise-plus_' + clickedUniqueId).css('visibility', 'hidden');
                    $('#exercise-minus_' + clickedUniqueId).css('visibility', 'hidden');
                } else {
                    $('#exercise-plus_' + clickedUniqueId).css('visibility', 'visible');
                    $('#exercise-minus_' + clickedUniqueId).css('visibility', 'visible');
                }
                $('#workout-set-value_' + clickedUniqueId).html(1);
                $('#workout-exercise-value_' + clickedUniqueId).html($workoutTypeSet[clickedValue]);

                let setType = $('#weekly-workout-setup_' + clickedUniqueId).val();
                if (setType !== '') {
                    $('#plan_' + clickedUniqueId).removeClass('disable-click');
                } else {
                    $('#plan_' + clickedUniqueId).addClass('disable-click');
                }
            });

            $('body').on('click', '.fa-plus-set, .fa-minus-set', function () {
                let clickedId = this.id.split('_');
                let clickedUniqueId = clickedId[1] + '_' + clickedId[2];
                let setType = $('#weekly-workout-setup_' + clickedUniqueId).val();
                if (setType !== '') {
                    let splitType = clickedId[0].split('-');
                    let type = splitType[0];
                    let actionType = splitType[1];
                    let id = 'workout-set-value';
                    if (type == 'exercise') {
                        id = 'workout-exercise-value';
                    }
                    id = id + '_' + clickedUniqueId;
                    if (actionType === 'plus')
                        cal.DataIncrement(id, type, setType, 1);
                    else
                        cal.DataDecrement(id, type, setType, 1);
                }
            });
            $('body').on('click', '.save-workout-sets', function () {
                let clickedId = this.id.split('_');
                let dayId = clickedId[1];
                let clickedUniqueId = clickedId[1] + '_' + clickedId[2];
                let setType = $('#weekly-workout-setup_' + clickedUniqueId).val();
                $addRecordRoute = $addWeeklyTrainingSetupRoute;
                $formData = {
                    '_token': $token,
                    id: $id,
                    day_id: dayId,
                    set_type: setType,
                    set: parseInt($('#workout-set-value_' + clickedUniqueId).html()),
                    exercise_set: parseInt($('#workout-exercise-value_' + clickedUniqueId).html())
                };
                addSubRecord(clickedUniqueId);
            });

            $('body').on('click', '.accept_reject_booking', function () {
                let id = this.id.split('_');
                let uniqueId = id[1]+'_'+id[2]+'_'+id[3];
                $isRequestAccept = false;
                if (id[0] == 'accept') {
                    $isRequestAccept = true;
                }else {
                }
                $formData = {
                    '_token': $token,
                    id:uniqueId,
                    isRequestAccept: $isRequestAccept,
                    finalPrice: id[4]
                };
                $.ajax({
                    type: 'POST',
                    url: $acceptOrRejectBooking,
                    data: $formData,
                    success: function (data) {
                        $('.fancybox-close').click();
                        updateClientFormData();
                        $type = 'renderClients';
                        renderAdmin();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
            //Import plan from program database
            $('body').on('click', '#import-database', function () {
                var importPlanId = '';
                var count = 0;
                $('input.checkbox-import-select:checkbox:checked').each(function (){
                    count++;
                });
                if(count>1){
                    alert('Please select one plan!');
                    return false;
                }
                $('input.checkbox-import-select:checkbox:checked').each(function () {
                    $id = $(this).attr("id");
                    importPlanId = $id.split('_')[1];
                });
                $formData = {
                    '_token': $token,
                    plan_id:importPlanId,
                    unique_id:$unique_id,
                    week_id:$weekId,
                    plan_type:$plan_type,
                    import_day_id:$importDayId
                };
                $.ajax({
                    type: 'POST',
                    url: $importPlanRoute,
                    data: $formData,
                    success: function (data) {
                        alert('The selected training plan was imported successfully.');
                        $('.close-import-popup').click();
                        getWeeklyPlanSetup();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
            //this is use to import predevelop plans
            //start client plan
            $('body').on('click', '.training-plan-setup', function (e) {
                $('#nav-overview').html('');
                cal.overViewPopUp('nav-overview');
            });

            $('body').on('click', '#save-training-plan, #save-close-training-plan', function (e) {
                e.preventDefault();
                let close = false;
                if ($(this).attr('id') === 'save-close-training-plan') {
                    close = true;
                }
                var inputs = $(".body_parts_drop_down:enabled");
                for (var i = 0; i < inputs.length; i++) {
                    if ($(inputs[i]).val() == '') {
                        swal("Oops!", "Body Part 1 is required to be selected for training days", "error");
                        return;
                    }
                }
                saveOverview(close);
            });

            $('body').on('click', '.training-plan-popup', function (e) {
                e.preventDefault();
                if (!$(this).hasClass('disabledTab')) {
                    let isMainWorkoutOnTop = 0;
                    if ($('#tab_main_workout').next('div').attr("id") === 'tab_cardio') {
                        isMainWorkoutOnTop = 1;
                    }
                    let formData = $('#tabs_form').serializeArray();
                    formData.push({name: 'is_main_workout_top', value: isMainWorkoutOnTop});
                    let activeTab = $('.active_tab').val();
                    let dayId = this.id.split('-')[1];
                    if (typeof (activeTab) !== 'undefined') {
                        $.post('/client-tabs', formData, function (response) {
                            if (response.success == false) {
                                swal("Oops!", response.message, "error");
                            } else {
                                cal.weeklyPopUp(dayId);
                            }
                        });
                    } else {
                        cal.weeklyPopUp(dayId);
                    }
                }
            });

            $('body').on('click', '#nav-overview-tab', function () {
                let isMainWorkoutOnTop = 0;
                if ($('#tab_main_workout').next('div').attr("id") === 'tab_cardio') {
                    isMainWorkoutOnTop = 1;
                }
                let formData = $('#tabs_form').serializeArray();
                formData.push({name: 'is_main_workout_top', value: isMainWorkoutOnTop});
                let activeTab = $('.active_tab').val();
                let dayId = this.id.split('-')[1];
                if (typeof (activeTab) !== 'undefined') {
                    $.post('/client-tabs', formData, function (response) {
                        cal.overViewPopUp('nav-overview');
                    });
                } else {
                    cal.overViewPopUp('nav-overview');
                }
            });

            $('body').on('click', '.delete_training_plan', function () {
                var result = confirm(('Are you sure to delete'));
                if (result) {
                    let clickedId = this.id.split('_');
                    $deleteId = clickedId[1] + '_' + clickedId[2] + '_' + clickedId[3];
                    $deleteRowId = $(this).closest("li").attr('id');
                    displayFormData();
                    ajaxStartStop();
                    $.ajax({
                        url: $deleteRoute,
                        type: 'POST',
                        data: $displayFormData,
                        success: function (data) {
                            if (data.success == true) {
                                // swal("Done!", data.message, "success");
                                $('#' + $deleteRowId).remove();
                                // location.reload();
                            }
                        },
                        error: function ($error) {

                        }
                    });
                }
            });
            $('body .drop_down_filters_excercise').change(function () {
                $dropDownFilters = {};
                var inputs = $(".drop_down_filters_excercise");
                for (var i = 0; i < inputs.length; i++) {
                    $dropDownFilters[$(inputs[i]).attr('id')] = $(inputs[i]).val();
                }
                $page = 1;
                getExercisesData();
            });
            $('body .drop_down_filters_import').change(function () {
                $dropDownFilters = {};
                var inputs = $(".drop_down_filters_import");
                for (var i = 0; i < inputs.length; i++) {
                    $dropDownFilters[$(inputs[i]).attr('id')] = $(inputs[i]).val();
                }
                $isImportRender = 1;
                updateFormData();
                $type = $defaultType;
                renderAdmin();
            });
            $('body').on('click', '#clear-exercise-filters', function () {
                var inputs = $(".drop_down_filters_excercise");
                for (var i = 0; i < inputs.length; i++) {
                    $(inputs[i]).val('');
                }
                $dropDownFilters = {};
                $page = 1;
                getExercisesData();
            });

            $('body').on('click', '.exer-close-btn', function () {
                var inputs = $(".drop_down_filters_excercise");
                for (var i = 0; i < inputs.length; i++) {
                    $(inputs[i]).val('');
                }
                $dropDownFilters = {};
                $page = 1;
                $('#search_exercise').val('');
                $search = '';
                getExercisesData();
            });
            $('body').on('click', '#save-weekly-setup, #save-close-weekly-setup', function (e) {
                e.preventDefault();
                let close = false;
                if ($(this).attr('id') === 'save-close-weekly-setup') {
                    close = true;
                }
                savePopup(close);
            });
            $('body').on('click', '.enable', function (e) {

                let clickedId = $(this).attr('id');
                $(".enable").css('color', 'black');
                $("#"+clickedId).css('color', 'blue');
                let splitClickedId = clickedId.split('_');
                $('#week-year').text('Week' + ' ' + splitClickedId[0] + ', ' + splitClickedId[1]);
                $weekId = splitClickedId[0];
                if (splitClickedId[0] != 53) {
                    $year = splitClickedId[1];
                }
                getClientLatestPlanId();
                getWeeklyPlanSetup();

            });
            $('body').on('keydown', '#search_exercise', function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $search = $(this).val();
                    $page = 1;
                    displayFormData();
                    getExercisesData();
                }
            });
            $('body').on('click', '.delete_training_plan_workout', function () {
                $deleteRowId = $(this).closest("li").attr('id');
                var result = confirm(('Are you sure to delete'));
                if (result) {
                    $formData = {
                        '_token': $token,
                        id: $id,
                        deleteId: this.id,
                        extraId: $deleteRowId
                    };
                    deleteSubRecord();
                }
            });
            $('body').on('click', '.structure-items-div', function () {
                if ($id == 0) {
                    swal("Oops!", "Please complete the header first.", "error");
                    return false;
                }
                let clickedId = $(this).attr('id');
                let splitClickedId = clickedId.split('_');
                clickedId = splitClickedId[1] + '_' + splitClickedId[2];
                getWeeklyPlanSetupData(clickedId);
            });
            $('body').on('click', '#add-client-exercise', function () {
                getExercisesData();
            });
            $('body').on('change', '.drag-drop-workout-filters', function () {
                let clickedValue = this.value;
                let clickedId = this.id;
                let clickedDropId = $(this).attr("class").split(' ')[2];
                let clickedDragAndDropId = parseInt($('#' + clickedDropId).attr('data-drag-drop-id'));
                if (clickedDragAndDropId > 0) {
                    $formData = {
                        '_token': $token,
                        id: $id,
                        clickedValue: clickedValue,
                        clickedId: clickedId,
                        clickedDragAndDropId: clickedDragAndDropId
                    };
                    ajaxStartStop();
                    $.ajax({
                        url: $planUpdateDragDropRoute,
                        type: 'POST',
                        data: $formData,
                        success: function (data) {
                        },
                        error: function ($error) {

                        }
                    });
                }
            });

            $('body').on('click', '.add-training-plan-comment', function () {
                let dayId = this.id.split('_')[1];
                $('#comment-modal-box_' + dayId).trigger('click');
                $('.modal-backdrop').remove();
                let comment = $('#text_' + dayId).val();
                if (comment == '') {
                    swal("Oops!", "Please add comment!", "error");
                    return;
                }
                $formData = {
                    '_token': $token,
                    id: $id,
                    dayId: dayId,
                    comment: $('#text_' + dayId).val()
                };
                $addRecordRoute = $addCommentRoute;
                ajaxStartStop();
                $.ajax({
                    url: $addRecordRoute,
                    type: 'POST',
                    data: $formData,
                    success: function (data) {
                        $message = data.message;
                        swal("Done!", $message, "success");
                    },
                    error: function ($error) {

                    }
                });
            })
            $('body').on('click', '.exercise_video', function () {
                $formData = {
                    '_token': $token,
                    exerciseId: this.id,
                };
                $.ajax({
                    url: $getExerciseVideoRoute,
                    type: 'POST',
                    data: $formData,
                    success: function (data) {
                        $.fancybox(data.view, {
                            width : 700,
                            height : 500,
                            fitToView : true,
                            autoSize : false,
                            closeClick: false,
                            closeEffect: false,
                            'autoscale': false,
                            openEffect: 'none',
                            'scrolling'   : 'no',
                        });
                    },
                    error: function ($error) {

                    }
                });
            });
            $('body').on('click', '#publish-client-plan', function () {
                $publishPlanStatus = $('#publish-client-plan').html();
                $isPublish = 0;
                if ($publishPlanStatus == 'Publish') {
                    $isPublish = 1;
                    $('#is_publish_plan').html('Published');
                } else {
                    $('#is_publish_plan').html('Not Published');
                }
                $formData = {
                    '_token': $token,
                    client_plan_id:$id,
                    unique_id:$unique_id,
                    user_id:$user_id,
                    week_id:$weekId,
                    is_publish:$isPublish
                };
                $.ajax({
                    url: $publishClientPlanRout,
                    type: 'POST',
                    data: $formData,
                    success: function (data) {
                        $('#close-publish').click();
                    },
                    error: function ($error) {
                    }
                });
            });
            $('body').on('click', '#import-predevelop-plan', function () {
                $plan_type = 2;
                importPlans();
            });
            $('body').on('click', '.plan-import-one-day-class', function () {
                $plan_type = 1;
                $splitId = this.id;
                $importDayId = $splitId.split('-')[1];
                importPlans();
            });

            /**
             * This is used to get drop down data dynamically
             */
            // $('body .drop_down_filters').change(function () {
            //     $dropDownFilters = {};
            //     var inputs = $(".drop_down_filters");
            //     for (var i = 0; i < inputs.length; i++) {
            //         $dropDownFilters[$(inputs[i]).attr('id')] = $(inputs[i]).val();
            //     }
            //     updateFormData();
            //     $renderRoute = $importPlanDataRout;
            //     $type = 'renderPlans';
            //     renderAdmin();
            // });


            $('body').on('click', '#is_publish_plan', function () {
                $isPublishPlan = $('#is_publish_plan').html();
                if ($isPublishPlan == 'Published')
                    $('#publish-client-plan').html('Un publish');
                else
                    $('#publish-client-plan').html('Publish');
            });
            $('body').on('click', '.add-new-row', function () {
                if ($id == 0) {
                    swal("Oops!", "Please complete the header first.", "error");
                    return false;
                }
                let clickedId = this.id.split('_');
                $extraId = clickedId[1] + '_' + clickedId[2];
                if (typeof ($addNewRowCount[$extraId]) === 'undefined') {
                    $addNewRowCount[$extraId] = 0;
                }
                $addNewRowCount[$extraId] += 1;
                console.log($addNewRowCount);
                displayFormData();
                $addNewFormData = $displayFormData;
                $addNewFormData['is_new'] = 1;
                ajaxStartStop();
                $.ajax({
                    url: $getDragDropOptionsRoute,
                    type: 'POST',
                    data: $addNewFormData,
                    success: function (data) {
                        if (data.success == true) {
                            $('#drag_drop_items_' + data.extraId).append(data.data);
                            $type = 'draggable';
                            renderAdmin();
                        }
                    },
                    error: function ($error) {

                    }
                });
            });

        });

        var deleteSubRecord = function () {
            ajaxStartStop();
            $.ajax({
                url: $deleteSubRoute,
                type: 'POST',
                data: $formData,
                success: function (data) {
                    if (data.success == true) {
                        $('#' + $deleteRowId).remove();
                    }
                },
                error: function ($error) {

                }
            });
        }
        var addSubRecord = function (clickedUniqueId) {
            ajaxStartStop();
            $.ajax({
                url: $addRecordRoute,
                type: 'POST',
                data: $formData,
                success: function (data) {
                    if (data.success == true) {
                        $('#weekly-workout-setup_' + clickedUniqueId).val('');
                        $('#plan_' + clickedUniqueId).addClass('disable-click');
                        $('#close_' + clickedUniqueId).trigger('click');
                        $type = 'displayData';
                        $displayDataRoute = $getDragDropOptionsRoute;
                        $extraId = clickedUniqueId;
                        displayFormData();
                        renderAdmin('drag_drop_items_' + clickedUniqueId);
                    }
                },
                error: function ($error) {

                }
            });
        }
        /**
         * This is used to overview select
         **/
        var overViewSelect = function () {
            $(".sel-change").change(function () {
                let disable = false;
                let childId = $(this).attr("child-id").split('-');
                let tabClass = $(this).attr("day-id").split('-')[1];
                let array = ['Active rest', 'Active Rest', 'active rest', 'rest', 'Rest'];
                if (array.includes($("option:selected", this).text())) {
                    disable = true;
                }
                $("." + childId).prop('disabled', disable);
                $("." + childId).val('');
                if (disable == true) {
                    $('#nav-' + tabClass).addClass('disabledTab');
                    $('#nav-' + tabClass).css('background-color', 'lightgrey');
                    $('#nav-' + tabClass).removeAttr('data-toggle');
                } else {
                    $('#nav-' + tabClass).removeClass('disabledTab');
                    $('#nav-' + tabClass).attr('data-toggle', 'tab');
                    $('#nav-' + tabClass).css('background-color', '');
                }
            });
        }

        /**
         * Used to move cardio up and down
         */
        var moveUp = function () {
            div1 = $('#tab_main_workout');
            div2 = $('#tab_cardio');
            tdiv1 = div1.clone();
            tdiv2 = div2.clone();
            if (!div2.is(':empty')) {
                div1.replaceWith(tdiv2);
                div2.replaceWith(tdiv1);
                tdiv1.addClass("replaced");
            }
            $('.cardioCas').find('i').toggleClass('fa-arrow-up fa-arrow-down');
        }

        /**
         * This is used to save popup design
         * */
        var savePopup = function (close) {
            let isMainWorkoutOnTop = 0;
            if ($('#tab_main_workout').next('div').attr("id") === 'tab_cardio') {
                isMainWorkoutOnTop = 1;
            }
            let formData = $('#tabs_form').serializeArray();
            formData.push({name: 'is_main_workout_top', value: isMainWorkoutOnTop});
            let activeTab = $('.active_tab').val();
            $.post('/client-tabs', formData, function (response) {
                if (response.success == true && close == true) {
                    $('#nav-overview').html('');
                    $('.training-close').trigger('click');
                }
                getWeeklyPlanSetup();
                if (response.success == false) {
                    swal("Oops!", response.message, "error");
                }
            });
        }

        var cal = {
            DataDecrement: function (id, type, setType, dec = 1) {
                let oldVal = parseInt($('#' + id).html());
                if (type == 'exercise' && setType === 'vertical' && oldVal < 3) {
                    return;
                }
                if (type == 'exercise' && setType === 'circuit' && oldVal < 5) {
                    return;
                }
                if (oldVal < 2) {
                    return;
                }
                if (oldVal > 0) {
                    let newVal = oldVal - parseInt(dec);
                    $('#' + id).html(newVal);
                }
            },
            DataIncrement: function (id, type, setType, inc = 1) {
                let oldVal = parseInt($('#' + id).html());
                if (oldVal < 20) {
                    let newVal = oldVal + parseInt(inc);
                    $('#' + id).html(newVal);
                }
            },
            weeklyPopUp: function (id) {
                $.get('/client-tabs/' + $id + '/' + id, function (response) {
                    $('#nav-overview').html(response.view);
                    if (response.isMainWorkoutTop < 1) {
                        moveUp();
                    }
                });
            },
            overViewPopUp: function (tabName) {
                $.get('/client-plans-overview/' + $id, {tabName: tabName}, function (response) {
                    $('#nav-overview').html(response);
                });
            },
        }

        /**
         * This is used to save overview popup
         **/
        var saveOverview = function (close) {
            let formData = $('#plans-overview').serializeArray();
            formData.push({name: 'client_plan_id', value: $id});
            formData.push({name: 'week_id', value: $weekId});
            formData.push({name: 'unique_id', value: $unique_id});
            let activeTab = $('.active_tab').val();
            $.post('/client-plans-overview', formData, function (response) {
                if (response.status == 200) {
                    $id = response.id;
                    if (close == true) {
                        $('#nav-overview').html('');
                        $('.training-close').trigger('click');
                        getWeeklyPlanSetup();
                    }
                } else {
                    swal("Oops!", "Something went wrong!", "error");
                }
            });
        }

        /**
         * This is used to get weekly plan setup
         **/
        var getWeeklyPlanSetup = function () {
            $('.add-main-workout-data').html('');
            $type = 'displayData';
            $displayDataRoute = $weeklyTrainingSetupRoute;
            displayFormData();
            renderAdmin('weekly_plan_training_setup');
        }

        /**
         * This is used to get exercised data
         */
        var getExercisesData = function () {
            $type = 'displayData';
            $displayDataRoute = $getExercisesRoute;
            displayFormData();
            renderAdmin('search-exercies-dynamic');
        }

        var getWeeklyPlanSetupData = function (clickedId) {
            if (!$('#ex-row-colapse_' + clickedId).hasClass('show')) {
                $type = 'displayData';
                $displayDataRoute = $getDragDropOptionsRoute;
                $extraId = clickedId;
                displayFormData();
                renderAdmin('drag_drop_items_' + clickedId);
            }
        }

        var importPlans = function () {
            $formData = {};
            $formData = {
                '_token': $token,
                page:  $page,
                search: $search,
                sortType: $sortType,
                sortColumn: $sortColumn,
                dropDownFilters: $dropDownFilters,
                plan_type:$plan_type
            };
            $type = 'renderPlans';
            $isImportRender = 1;
            $renderRoute = $importPlanDataRout;
            renderAdmin();
            $('#search').val('');
        }
        /**
         * This is used for display form data
         * */
        var displayFormData = function () {
            $displayFormData = {
                '_token': $token,
                id: $id,
                extraId: $extraId,
                page: $page,
                deleteId: $deleteId,
                dropDownFilters: $dropDownFilters,
                search: $search,
                weekId: $weekId,
                year: $year,
                unique_id: $unique_id,
                client_id: $clientId,
                user_id: $userId,
                week_increment_value:$weekIncrementValue
            };
        }

        function oncall() {
            updateClientFormData();
            $renderRoute = $getClientsDataRoute;
            $type = 'renderClients';
            renderAdmin();
        }
        var updateFormData = function () {
            $formData = {
                '_token': $token,
                data:  $('#add-form').serialize(),
                id: $id,
                extraId: $extraId,
                exerciseId: $exerciseId,
                dropDownFilters: $dropDownFilters,
                workoutCounter: $workoutCounter,
                workoutSubCounter: $workoutSubCounter,
                workoutType: $workoutType,
                positionId: $positionId,
                search: $search,
                action_freelance:$action_freelance,
                userName: $userName,
                partner: $partner,
                bmi: $bmi,
                gender:$gender,
                bookingSubmission:$bookingSubmission,
                plan_type:$plan_type
            };
        }

        var updateClientFormData = function () {
            $formData = {
                '_token': $token,
                page: $page,
                search: $search,
                sortType: $sortType,
                sortColumn: $sortColumn,
                dropDownFilters: $dropDownFilters,
                action_freelance: $action_freelance,
                accountRegDate:$accountRegDate,
                bookingSubmission:$bookingSubmission,
                bmi:$bmi,
                gender:$gender
            };
        }
        var getClientLatestPlanId = function () {
            $formData = {
                '_token': $token,
                id: $user_id,
                unique_id: $unique_id,
                week_id:$weekId,
                year:$year
            };
            $.ajax({
                type: 'POST',
                url: $getClientInfoRout,
                data: $formData,
                success: function (response) {
                    if (response.success == true) {
                        $.each(response.data, function (index, value) {
                            $unique_id = response.data.unique_id;
                            $id = response.data.client_plan_id;
                        });
                    }
                },
                error: function (error) {
                }
            });
        }
    </script>
    {!! Html::script('js/admin.js?id='.version())!!}
@endpush
