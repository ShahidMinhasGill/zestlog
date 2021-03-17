@extends('layouts.app')

@section('content')
<style>
    .booked_time_slot_row {
        font-size: 10px;
        color: white;
        text-align: center;
        font-weight: bold;
    }
    .selected-row
    {
        background-color: Lavender;
    }
</style>

<div class="page-content">
    <div class="card">
        <div class="card-body">
        <nav>
            <span class="header-avtar">
            <div class="nav nav-pills client-schedule-nav" id="nav-tab" role="tablist">
                @if(!isLightVersion())
                <a class="nav-item nav-link active" data-toggle="tab"id="upcoming-programs-tab" href="#calendar" role="tab" aria-controls="calendar" aria-selected="true">Calendar</a>
                @endif
                <a class="nav-item nav-link upcoming-program"id="upcoming-meeting-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true">Upcoming</a>
            </div>
            </span>
        </nav>

        <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="calendar" role="tabpanel" aria-labelledby="calendar-tab">
                    <div class="row mb-4 hide" id="schedule-data-div">
                        <div class="col-sm-4">
                            @include('client.partials._timeslot-popup')
                        </div>
                        <div class="col-sm-4 d-flex align-items-center justify-content-center">
                            <a href="javascript: void(0);" id="decrement-week"><i class="fas fa-arrow-circle-left fa-2x text-dark mr-3"></i></a>
                            <span class="h3"id="week_id">Week 1</span>
                            <a href="javascript: void(0);" id="increment-week"><i class="fas fa-arrow-circle-right fa-2x text-dark ml-3"></i></a>
                        </div>

                        <div class="col-sm-2 text-right ml-auto">
                            <!-- <i class="far fa-calendar-alt fa-2x"></i> -->
                            <input type="week" class="form-control"id="week-input">
                        </div>
                    </div>

                    <div class="row" id="schedule_data">
                    </div>

                </div>

            <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
                <nav class="inner-tab">
                    <div class="nav nav-pills" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active upcoming-program"  data-toggle="tab" href="#cl-Programs" role="tab" aria-controls="cl-Programs" aria-selected="true">Programs</a>
                        @if(!isLightVersion())
                        <a class="nav-item nav-link upcoming-meetings" id="meetings" data-toggle="tab" href="#cl-Meetings" role="tab" aria-controls="cl-Meetings" aria-selected="true">Meetings</a>
                        @endif
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="cl-Programs" role="tabpanel" aria-labelledby="cl-Programs-tab">
                    <div class="table-responsive">
                    <table class="table text-center">
                            <thead class="thead-light">
                                <th>Nr</th>
                                <th><div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="chk2">
                                        <label class="custom-control-label" for="chk2"></label>
                                    </div></th>
                                <th>Week of year<br>
                                    <input type="text" class="form-control" id="week_of_year" placeholder="">
                                </th>

                                <th>Week of program<br>
                                    <input type="text" id="week-of-program-id" class="form-control" placeholder="">
                                </th>
                                <th>Service
                                    <br> {!! Form::select('service_id', $data['services'], null , ['class' => 'custom-select drop_down_filters width80', 'id' => 'service_id']) !!}
                                </th>
                                <th>Status<br>
                                <select class="custom-select drop_down_filters" id="is_publish">
                                    <option selected=""value="">All</option>
                                    <option value="1">Published</option>
                                    <option value="0">Not Published</option>
                                    </select>
                                </th>
                                @if(!isLightVersion())
                                <th>New/Repeat<br>
                                <select class="custom-select drop_down_filters"id="is_repeat">
                                    <option selected=""value="">All</option>
                                    <option value="1">New</option>
                                    <option value="0">Repeat</option>
                                    </select>
                                </th>
                                @endif
                                <th>Client<br>
                                <div class="table-search d-flex mr-2">
                                    <i class="fas fa-search"></i>
                                    <input type="text" id="search" name="search" placeholder="Search a name" class="form-control">
                                </div>
                                </th>
                                <th>Booking form</th>
                                <th>Status</th>
                            </thead>
                        <tbody class="bookings-description" id="page-data"></tbody>
                    </table>
                    </div>
                        <div class="paq-pager"></div>
                    </div>

                    <div class="tab-pane fade" id="cl-Meetings" role="tabpanel" aria-labelledby="cl-Meetings-tab">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="thead-light">
                                <th>Nr</th>
                                <th><div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="chk1">
                                        <label class="custom-control-label" for="chk1"></label>
                                    </div></th>
                                <th>Schedule for<br>
                                    <input type="text" id="schedule_date" class="form-control" placeholder="dd/mm/yyy">
                                </th>
                                <th>Service
                                    <br> {!!  Form::select('service_id', $data['services-meeting'], null , ['class' => 'custom-select drop_down_filters_meetings width80', 'id' => 'meeting_service_id']) !!}
                                </th>
                                <th>Location<br>
                                    <br> {!! Form::select('location', $data['trainingLocations'], null , ['class' => 'custom-select drop_down_filters_meetings width80', 'id' => 'location']) !!}
                                </th>

                                <th>Client<br>
                                <div class="table-search d-flex mr-2">
                                    <i class="fas fa-search"></i>
                                    <input type="text" id="search-user" name="search" placeholder="Search a name" class="form-control">
                                </div>
                                </th>
                                <th>Booking form</th>
                                <th>Status</th>
                            </thead>
                            <tbody class="upcoming-meetings" id="page-data-meetings"></tbody>
                        </table>
                    </div>
                        <div class="paq-pager"></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('after-scripts')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#date" ).datepicker({ dateFormat: "dd/mm/yy"});
            $( "#endRepeatDate" ).datepicker({ dateFormat: "dd/mm/yy"});

        } );
    </script>
    <link rel="stylesheet" type="text/css" href="{!! asset('css/fancybox/jquery.fancybox.css') !!}"/>
    {!! Html::script('js/fancybox/jquery.fancybox.js') !!}
    {!! Html::script('js/fancybox/jquery.fancybox.pack.js') !!}
    {!! Html::script('js/jquery.scrollTo-min.js') !!}
    {{--{!! Html::script('js/bootstrap.min.js') !!}--}}
    <script>
        $ScheduleRout = '{{ URL::route('schedule.block.week') }}';
        $blockDragedSlot = '{{ URL::route('block.drag.slot') }}';
        $saveBlockDragedSlot = '{{ URL::route('save.block.drag.slot') }}';
        $getBlockSlotData = '{{ URL::route('get.block.slot.data') }}';
        $editBlockSlotSaved = '{{ URL::route('edit.block.slot.saved') }}';
        $slotDelete = '{{ URL::route('slot.delete') }}';
        $getScheduleDataRout = '{{ URL::route('get.schedule.data') }}';
        $renderRoute = '{{ URL::route('get.upcoming.program') }}';
        $timeSlotBlock = '{{ URL::route('block.time.slot') }}';
        $bookingInformationRout = '{{ URL::route('user.booking.information') }}';
        $defaultType = 'renderUpcomingSessions';
        $token = "{{ csrf_token() }}";
        $page = 1;
        $search = '';
        $asc = 'asc';
        $desc = 'desc';
        $sortType  = 'desc';
        $sortColumn = 'a.id';
        $dropDownFilters = {};
        $weekId = 1;
        $isWholeWeekBlock = 0;
        $blockDayId = 'block_day_0';
        $isBlockDayTrue = 0;
        $startTime = '';
        $endTime = '';
        $repeatId = '';
        $date = '';
        $repeatDate = '';
        $isChangeType = 0;
        $selectedWeekYear = '2020';
        $totalWeeksInyear = 0;
        $currentWeekId = 1;
        $currentYear = '2020';
        $mouseclick = '';
        $mouseup = '';
        $mousemove = '';
        $mousedown = '';
        $isImportRender = 0;
        $isMeetingRoute = 0;
        $isMouseDown = false;
        $selectedDayId = 0;
        $previousDayId = 0;
        $toScrollPage = 25;
        $isScrollToPage = true;
        $isLightVersion = '{{isLightVersion()}}';
        $(document).ready(function () {
            var today = new Date();
            $weekId =  new Date().getWeekNumber();
            $currentWeekId = $weekId;
            if ($currentWeekId == 53)
                $selectedWeekYear = '2020';
            else
                $selectedWeekYear = today.getFullYear();
            $currentYear = $selectedWeekYear;
            $totalWeeksInyear = weeksInYear($selectedWeekYear);
            $('#week_id').html('Week ' + $weekId,$selectedWeekYear);
            if ($isLightVersion == 1) {
                $('#upcoming-meeting-tab')[0].click();
                $isImportRender = 0;
                $isMeetingRoute = 0;
                $page = 1;
                updateFormData();
                $type = $defaultType;
                renderClient();
            } else {
                $('#schedule-data-div').removeClass('hide');
                updateFormData();
                getScheduleData();
            }
            $('body').on('change', '#whole-week-block', function () {
                $isWholeWeekBlock = 0;
                $isChangeType = 1;
                if (this.value == 1) {
                    $isWholeWeekBlock = 1;
                    $('select.block-days').attr('disabled', true);
                    $('.table-row').css("background-color", "#D3D3D3");
                } else {
                    $isWholeWeekBlock = 0;
                    $('select.block-days').attr('disabled', false);
                    $('.table-row').css("background-color", "white");
                }
                updateFormData();
                UpdateSchedule();
            });
            $('body').on('change', '.selected-value', function () {
                $value = parseInt($(this).val());
                $("#endTime option").show();
                for (i = 2; i <= $value; i++) {
                    $("#endTime option[value=" + i + "]").hide();
                }
                $value = $value + 1;
                if ($value == 97) {
                    $value = 1;
                }
                $('#endTime option').removeAttr('selected');
                $('#endTime').val($value);
            });

            $('body').on('change', '.selected-value-block', function () {
                $value = parseInt($(this).val());
                $("#edit-end-time option").show();
                for (i = 2; i <= $value; i++) {
                    $("#edit-end-time option[value=" + i + "]").hide();
                }
                $value = $value + 1;
                if ($value == 97) {
                    $value = 1;
                }
                $('#edit-end-time option').removeAttr('selected');
                $('#edit-end-time').val($value);
            });

            $('body').on('change', '#startTimedrag', function () {
                $value = parseInt($(this).val());
                $("#endTimedrag option").show();
                for (i = 2; i <= $value; i++) {
                    $("#endTimedrag option[value=" + i + "]").hide();
                }
                $value = $value + 1;
                if ($value == 97) {
                    $value = 1;
                }
                $('#endTimedrag option').removeAttr('selected');
                $('#endTimedrag').val($value);
            });
            // $('body').on('change', '#startTimedrag', function () {
            //     $value = parseInt($(this).val());
            //     $value = $value - 1;
            //     $('#endTimedrag option option').removeAttr('selected');
            //     $('#endTimedrag option:eq('+$value+')').attr('selected', 'selected');
            // });

            $('body').on('change', '.block-days', function () {
                $isChangeType = 0;
                $isBlockDayTrue = 0;
                if (this.value == 1) {
                    $blockDayId = this.id;
                    let id = this.id.split('_')[2];
                    $isBlockDayTrue = 1;
                    $('.block_day_'+ id).css("background-color", "#D3D3D3");
                } else {
                    $blockDayId = this.id;
                    $isBlockDayTrue = 0;
                    let id = this.id.split('_')[2];
                    $('.block_day_'+ id).css("background-color", "white");
                }
                updateFormData();
                UpdateSchedule();
            });


            $('body').on('click', '#increment-week', function () {
                $toScrollPage = 25;
                $isScrollToPage = true;
                $weekId = $('#week_id').html().split(' ')[1];
                if($weekId == $totalWeeksInyear){
                    $selectedWeekYear++;
                    $weekId = 0;
                    $totalWeeksInyear = weeksInYear($selectedWeekYear);
                }
                if ($weekId < $totalWeeksInyear) {
                    $weekId++;
                    $('#week_id').html('Week ' + $weekId);
                    updateFormData();
                    getScheduleData();
                    disabledWeek();
                }
            });

            $('body').on('click', '#decrement-week', function () {
                $toScrollPage = 25;
                $isScrollToPage = true;
                $weekId = $('#week_id').html().split(' ')[1];
                if($weekId == 1){
                    $selectedWeekYear--;
                    $totalWeeksInyear = weeksInYear($selectedWeekYear);
                    $weekId = $totalWeeksInyear + 1;
                }
                if ($weekId > 1) {
                    $weekId--;
                    $('#week_id').html('Week ' + $weekId);
                    updateFormData();
                    getScheduleData();
                }
                disabledWeek();
            });
            $('body').on('change', '.repeat', function () {
                $repeatId = '';
                if(this.value!=''){
                    $repeatId = this.value;
                }
            });
            $('body').on('click', '.btn-save', function () {
                $isScrollToPage = false;
                $scrollTop = $('.tableFixHead').scrollTop();
                $date = $("#date").val();
                $repeatDate = $("#endRepeatDate").val();
                $startTime = convertTo24Hour($("#startTime").val().toLowerCase());
                $endTime = convertTo24Hour($("#endTime").val().toLowerCase());
                $repeatId = $('#repeat-block-slot').val();
                updateFormData();
                blockTimeSlot();
            });
            $('body').on('click', '#save-drag-time-slot-popup-data', function () {
                $startTime = $('#startTimedrag').val();
                $endTime = $('#endTimedrag').val();
                $date = $('#selected-slot-date').val();
                $formData = {
                    '_token': $token,
                    start_time_drag: $startTime,
                    end_time_drag: $endTime,
                    date: $date,
                    week_id:$weekId,
                    select_year:$selectedWeekYear,
                    repeatDate: $repeatDate,
                    repeatId: 1,
                };
                $.ajax({
                    url: $saveBlockDragedSlot,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                        updateFormData();
                        getScheduleData();
                        $.fancybox.close();
                    },
                    error: function ($error) {
                    }
                });
            });


            $('body').on('click', '#save-edit-time-slot', function () {
                $isScrollToPage = false;
                $scrollTop = $('.tableFixHead').scrollTop();
               $startTime =  $('#edit-start-time').val();
               $selectedId =  $('#selectedid').val();
               $endTime =  $('#edit-end-time').val();
                $date = $('#selected-slot-date').val();
                $uniqueIdSlots = '';

                if ($('.is-checked-all-slot').is(':checked')) {
                    $uniqueIdSlots = $('.is-checked-all-slot').attr('id');
                }
                $formData = {
                    '_token': $token,
                    start_time_block_slot: $startTime,
                    end_time_block_slot: $endTime,
                    date: $date,
                    selected_id: $selectedId,
                    unique_id_slots:$uniqueIdSlots,
                };
                // console.log($formData);
                $.ajax({
                    url: $editBlockSlotSaved,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                        updateFormData();
                        getScheduleData();
                        $.fancybox.close();
                    },
                    error: function ($error) {
                    }
                });
            });
            $('body').on('click', '#delete-time-slot-popup', function () {
                $isScrollToPage = false;
                $scrollTop = $('.tableFixHead').scrollTop();
                $startTime =  $('#startTimedrag-edit').val();
                $endTime =  $('#endTimedrag-eidt').val();
                $date = $('#selected-slot-date').val();
                $selectedId = $('#selectedid').val();
                $uniqueIdSlots = '';
                if ($('.is-checked-all-slot').is(':checked')) {
                    $uniqueIdSlots = $('.is-checked-all-slot').attr('id');
                }
                $formData = {
                    '_token': $token,
                    start_time_block_slot: $startTime,
                    end_time_block_slot: $endTime,
                    date: $date,
                    selected_id:$selectedId,
                    unique_id_slots:$uniqueIdSlots,
                };
                $.ajax({
                    url: $slotDelete,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                        updateFormData();
                        getScheduleData();
                        $.fancybox.close();
                    },
                    error: function ($error) {
                    }
                });
            });
            $('body').on('click', '.block-slot-tr', function () {
                let id = $(this).attr("id");
                $blockDbId = id.split('_');
                let date = $('#days_id_'+$blockDbId[3]).attr('data-id')
                $dayDate  = date;
                if(typeof($blockDbId[4]) != "undefined" && $blockDbId[4] !== null){
                    let val = $blockDbId[4];
                    if(val != ''){
                        $formData = {
                            '_token': $token,
                            value:val,
                            day_id:$blockDbId[3],
                            day_date:$dayDate
                        };
                        $.ajax({
                            url: $getBlockSlotData,
                            type: 'POST',
                            data: $formData,
                            success: function (response) {
                                $.fancybox(response.view, {
                                    width : 600,
                                    height : 350,
                                    fitToView : true,
                                    autoSize : false,
                                    closeClick: false,
                                    closeEffect: false,
                                    'autoscale': false,
                                    openEffect: 'none',
                                    'scrolling'   : 'no',
                                });

                                $value = parseInt(response.start_value);
                                $("#edit-end-time option").show();
                                for (i = 2; i <= $value; i++) {
                                    $("#edit-end-time option[value=" + i + "]").hide();
                                }
                            },
                            error: function ($error) {
                            }
                        });
                    }
                }
            });

            $('body').on('change', '#week-input', function () {
                $weekInput = $('#week-input').val();
                $selectedWeekYear = $weekInput.split('-')[0];
                $weekId = $weekInput.split('W')[1];
                $('#week_id').html('Week ' + $weekId);
                updateFormData();
                getScheduleData();
                disabledWeek();
            });

            $('body').on('mousedown', '.empty-slot', function () {
                let id = this.id;
                $mousedown = id;
                $valdown = parseInt($mousedown.split('_')[2]);
                $valup = $valdown + 1;
                $currentMouseUP = $valup;
                if ($valup > 96) {
                    $valup = 1;
                }
                $('#' + id).css('background-color', '#A9A9A9');
                // $('#' + id).addClass('selected-row');
                $isMouseDown = true;
            });

            $('body').on('mouseover', '.empty-slot', function () {
                if ($isMouseDown == true) {
                    let id = this.id;
                    $currentMouseUP = id.split('_')[2];
                    $selectedDayId = parseInt(id.split('_')[3]);
                    if ($previousDayId < 1) {
                        $previousDayId = $selectedDayId;
                    }
                    if ($selectedDayId > 0 && $selectedDayId == $previousDayId && $currentMouseUP >= $valup) {
                        $mouseup = id;
                        $valup = $mouseup.split('_')[2];
                        $('#' + id).css('background-color', '#A9A9A9');
                        // $('#' + id).addClass('selected-row');
                    }
                    // else if ($selectedDayId > 0 && $selectedDayId == $previousDayId && $currentMouseUP <= $valup && $currentMouseUP >= $valdown) {
                    //     $mouseup = id;
                    //     $valup = $mouseup.split('_')[2];
                    //     $('#' + id).css('background-color', '');
                    // }
                }
            });

            $('body').on('click', '#upcoming-programs-tab', function () {
                $isMeetingRoute =0;
                $isImportRender = 0;
            });

            $('body').on('mouseup', '.empty-slot', function () {
                $isMouseDown = false;
                $previousDayId = 0;
                $selectedDayId = 0;
                if (!($weekId < $currentWeekId && $selectedWeekYear <= $currentYear)) {
                    let id = this.id;
                    let mousedownsplit = $mousedown.split('_');
                    $valday = mousedownsplit[3];
                    $valdayend = $mouseup.split('_')[3];
                    if ($valdown != $valup) {
                        $isScrollToPage = false;
                        $scrollTop = $('.tableFixHead').scrollTop();
                        for ($i = $valdown; $i <= $valup; $i++) {
                            $('#time_slot_' + $i + '_' + $valday).css("background-color", "#A9A9A9");
                        }
                        let date = $('#days_id_' + $valday).attr('data-id');
                        $selectedDayDate = date;
                        if ($valdown > $valup && $valup!=1) {
                            $temVal = $valdown;
                            $valdown = $valup;
                            $valup = $temVal;
                        }
                        $formData = {
                            '_token': $token,
                            week_id: $weekId,
                            start_time: $valdown,
                            end_time: $valup,
                            selected_day_date: $selectedDayDate,
                        };
                        $.ajax({
                            url: $blockDragedSlot,
                            type: 'POST',
                            data: $formData,
                            success: function (response) {
                                $.fancybox(response.view, {
                                        width: 600,
                                        height: 350,
                                        fitToView: true,
                                        autoSize: false,
                                        closeClick: false,
                                        closeEffect: false,
                                        'autoscale': false,
                                        openEffect: 'none',
                                        'scrolling': 'no',
                                        helpers: {
                                            overlay: {
                                                closeClick: false
                                            }
                                        },
                                        afterClose: function () {
                                            for ($i = $valdown; $i <= $valup; $i++) {
                                                $('#time_slot_' + $i + '_' + $valday + '_').css("background-color", "");
                                            }
                                        }
                                    },
                                );
                            },
                            error: function ($error) {
                            }
                        });
                    }
                }
                if (window.getSelection) {
                    if (window.getSelection().empty) {  // Chrome
                        window.getSelection().empty();
                    } else if (window.getSelection().removeAllRanges) {  // Firefox
                        window.getSelection().removeAllRanges();
                    }
                } else if (document.selection) {  // IE?
                    document.selection.empty();
                }
            });
            $('body').on('click', '.upcoming-program', function () {
                $isImportRender = 0;
                $isMeetingRoute = 0;
                $page = 1;
                updateFormData();
                $type = $defaultType;
                renderClient();
            });

            $('body').on('click', '.upcoming-meetings', function () {
                $isImportRender = 2;
                $isMeetingRoute = 1;
                $page = 1;
                updateFormData();
                $type = $defaultType;
                renderClient();
            });
            $('#week-of-program-id').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $page = 1;
                    updateFormData();
                    $type = $defaultType;
                    renderClient();
                }
            });
            $('#is_publish').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $page = 1;
                    updateFormData();
                    $type = $defaultType;
                    renderClient();
                }
            });
            $('#service_id').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $page = 1;
                    updateFormData();
                    $type = $defaultType;
                    renderClient();
                }
            });
            $('#is_repeat').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $page = 1;
                    updateFormData();
                    $type = $defaultType;
                    renderClient();
                }
            });
            $('#week_of_year').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $page = 1;
                    updateFormData();
                    $type = $defaultType;
                    renderClient();
                }
            });

            $('body').on('click', '#meetings', function () {
                $isMeetingRoute =1;
                $isImportRender = 2;
                updateFormData();
                $type = $defaultType;
                renderClient();

            });
            $('#meeting_service_id').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $page = 1;
                    $isImportRender = 2;
                    $isMeetingRoute =1;
                    updateFormData();
                    $type = $defaultType;
                    renderClient();
                }
            });
            $('#schedule_date').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $page = 1;
                    $isImportRender = 2;
                    $isMeetingRoute =1;
                    updateFormData();
                    $type = $defaultType;
                    renderClient();
                }
            });
            $('#search-user').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $page = 1;
                    $isImportRender = 2;
                    $isMeetingRoute =1;
                    updateFormData();
                    $type = $defaultType;
                    renderClient();
                }
            });
            $('body .drop_down_filters_meetings').change(function () {
                $dropDownFilters = {};
                var inputs = $(".drop_down_filters_meetings");
                for (var i = 0; i < inputs.length; i++) {
                    $dropDownFilters[$(inputs[i]).attr('id')] = $(inputs[i]).val();
                }
                $isImportRender = 2;
                $isMeetingRoute =1;
                updateFormData();
                $type = $defaultType;
                renderClient();
            });

            $('body').on('click', '.bookings-description-upcoming', function () {
                $id  = this.id;
                $id = $id.split('-')[1];
                $formData = {
                    '_token': $token,
                    id:$id,
                };

                ajaxStartStop();
                $.ajax({
                    url: $bookingInformationRout,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                        $.fancybox(response.view, {
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
                    error: function ($error) {
                    }
                });
            });

            $('#startTime')

        });
        function convertTo24Hour(time) {
            var hours = parseInt(time.substr(0, 2));
            if (time.indexOf('am') != -1 && hours == 12) {
                time = time.replace('12', '0');
            }
            if (time.indexOf('pm') != -1 && hours < 12) {
                time = time.replace(hours, (hours + 12));
            }
            return time.replace(/(am|pm)/, '');
        }
        var blockTimeSlot = function () {
            ajaxStartStop();
            $.ajax({
                url: $timeSlotBlock,
                type: 'POST',
                data: $formData,
                success: function (response) {
                    getScheduleData();
                    $('#block-time-slot').trigger('click');
                },
                error: function ($error) {
                }
            });
        }
            var UpdateSchedule = function () {
                $.ajax({
                    url: $ScheduleRout,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                    },
                    error: function ($error) {
                    }
                });
            }
        var getScheduleData = function () {
            ajaxStartStop();
            $.ajax({
                url: $getScheduleDataRout,
                type: 'POST',
                data: $formData,
                success: function (response) {
                    $('#schedule_data').html(response.view);
                    changeColor();
                    blockSlotColor();
                    if ($isScrollToPage == true) {
                        $scrollTop = $('.row_slot_' + $toScrollPage).offset().top - $('.row_slot_1').offset().top;
                    }
                    $('.tableFixHead').animate({
                        scrollTop: $scrollTop
                    }, -1000);
                    $('.tableFix').scrollTo('#row_slot_20');
                },
                error: function ($error) {
                }
            });
        }
            /**
             * This is used to update form data
             */
            var updateFormData = function () {
                $formData = {
                    '_token': $token,
                    // data:  $('#add-form').serialize(),
                    page:  $page,
                    search: $search,
                    sortType: $sortType,
                    sortColumn: $sortColumn,
                    dropDownFilters: $dropDownFilters,
                    weekId:$weekId,
                    selectedWeekYear:$selectedWeekYear,
                    isWholeWeekBlock:$isWholeWeekBlock,
                    isBlockDayTrue:$isBlockDayTrue,
                    blockDayId:$blockDayId,
                    startTime:$startTime,
                    endTime:$endTime,
                    date:$date,
                    repeatDate:$repeatDate,
                    repeatId:$repeatId,
                    isChangeType: $isChangeType,
                    week_of_program:$('#week-of-program-id').val(),
                    is_publish:$('#is_publish').val(),
                    is_service:$('#service_id').val(),
                    repeat_program:$('#is_repeat').val(),
                    week_of_year:$('#week_of_year').val(),
                    is_meeting_route:$isMeetingRoute,
                    meeting_service_id:$('#meeting_service_id').val(),
                    schedule_date:$('#schedule_date').val(),
                    search_user:$('#search-user').val(),
                };

            }
            function changeColor() {
                $("#whole-week-block").each(function () {
                    $isWholeWeekBlock = 0;
                    if (this.value == 1) {
                        $isWholeWeekBlock = 1;
                        $('select.block-days').attr('disabled', true)
                        $('.table-row').css("background-color", "#D3D3D3");
                    } else {
                        $isWholeWeekBlock = 0;
                        $('select.block-days').attr('disabled', false)
                        $('.table-row').css("background-color", "white");
                        $(".block-days").each(function () {
                            $isBlockDayTrue = '';
                            if (this.value == 1) {
                                $blockDayId = this.id;
                                let id = this.id.split('_')[2];
                                $isBlockDayTrue = true;
                                $('.block_day_' + id).css("background-color", "#D3D3D3");
                            } else {
                                $blockDayId = this.id;
                                $isBlockDayTrue = false;
                                let id = this.id.split('_')[2];
                                $('.block_day_' + id).css("background-color", "white");
                            }
                        });
                    }
                });
            }
            /*
            disable past weeks
             */
        function disabledWeek() {
            if ($weekId < $currentWeekId && $selectedWeekYear <= $currentYear) {
                $('select.block-days').attr('disabled', true);
                $('#whole-week-block').attr('disabled', true);
                $('.block-time-slot').attr('disabled', true);
            } else {
                $('.block-time-slot').attr('disabled', false);
            }
        }

        function blockSlotColor() {
            $('.schedule_data').find('tr:visible:first').css('background','blue');
            $(".block-slot").each(function () {
                let id = $(this).attr("data-id");
                $('.td-class-blocked_'+id).css("background-color", "#A9A9A9");
            });
            $(".block-slot-td").each(function () {
                let id = $(this).attr("id");
                let val = id.split('_')[4];
                if(typeof(val) != "undefined" && val !== null && val != ''){
                    $('.td-class-blocked_'+val).removeClass('border');
                }

            });
            $('.booked_time_slot_row').css("background-color", "#87ceeb");
            $('.booked_time_slot_row').removeClass('border');
            // changeColor();
        }
        /**
         * get week number
         * @param d
         * @returns {number[]}
         */
        function getWeekNumber(d) {
            // Copy date so don't modify original
            d = new Date(+d);
            d.setHours(0, 0, 0, 0);
            // Set to nearest Thursday: current date + 4 - current day number
            // Make Sunday's day number 7
            d.setDate(d.getDate() + 4 - (d.getDay() || 7));
            // Get first day of year
            var yearStart = new Date(d.getFullYear(), 0, 1);
            // Calculate full weeks to nearest Thursday
            var weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7)
            // Return array of year and week number
            return [d.getFullYear(), weekNo];
        }

        /*
        get total weeks in year
         */
        function weeksInYear(year) {
            var month = 11,
                day = 31,
                week;

            // Find week that 31 Dec is in. If is first week, reduce date until
            // get previous week.
            do {
                d = new Date(year, month, day--);
                week = getWeekNumber(d)[1];
            } while (week == 1);

            return week;
        }
        Date.prototype.getWeek = function() {
            var onejan = new Date(this.getFullYear(),0,1);
            return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()+1)/7);
        }
        Date.prototype.getWeekNumber = function(){
            var d = new Date(Date.UTC(this.getFullYear(), this.getMonth(), this.getDate()));
            var dayNum = d.getUTCDay() || 7;
            d.setUTCDate(d.getUTCDate() + 4 - dayNum);
            var yearStart = new Date(Date.UTC(d.getUTCFullYear(),0,1));
            return Math.ceil((((d - yearStart) / 86400000) + 1)/7)
        };
    </script>
    {!! Html::script('js/client.js?id='.version())!!}
@endpush
