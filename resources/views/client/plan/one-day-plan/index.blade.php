@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="pagetitle">Plan Creator</h1>
                    </div>
                </div>

            </div>
        </div>

        @include('client.plan.one-day-plan.partials._main-section')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    {{--<button type="button" class="btn success-btn mb-3 mr-2" data-toggle="modal" data-target="#day-plan-setup-popup">--}}
                    {{--Setup ss--}}
                    {{--</button>--}}
                    @include('client.partials._week-import-popup')
                    @include('client.plan.one-day-plan.partials._day-import-popup')

                    <!-- day plan setup popup -->
                    @include('client.plan.one-day-plan.partials._day-plan-setup-popup')
                    <!-- End day plan setup popup -->
                    </div>

                    <div class="col-md-6 text-right">
                        <button class="btn success-btn add-exer-btn float-right">Add exercise</button>
                    </div>
                </div>

                <div id="weekly_plan_training_setup" class="col-12"></div>
                {{--@include('client.plan.one-day-plan.partials._day-training-plan')--}}

                @include('client.plan.one-day-plan.partials._search-exercise')
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
    <script>
        $indexRoute = '{{ URL::route('plans.index') }}';
        $deleteDraftRoute = '{{ URL::route('delete.draft.plan') }}';
        $addPlanRoute = '{{ URL::route('plans.store') }}';
        $createNewPlan = '{{ URL::route('create.plan.week') }}';
        $RedirectRoute = '{{ URL::route('plans.index') }}' + '?type=onedayplan';
        $addDragdropRoute = '{{ URL::route('plan.drag.drop.exercise') }}';
        $addCommentRoute = '{{ URL::route('plan.add.comment') }}';
        $weeklyTrainingSetupRoute = '{{ URL::route('one.day.plan-weekly-training-setup') }}';
        $getDragDropOptionsRoute = '{{ URL::route('plan-get-drag-drop-options') }}';
        $getExercisesRoute = '{{ URL::route('get-exercises') }}';
        $deleteRoute = '{{ URL::route('delete.training.plan') }}';
        $planUpdateDragDropRoute = '{{ URL::route('plan.update.drag.drop') }}';
        $addWeeklyTrainingSetupRoute = '{{ URL::route('add.weekly.training.setup') }}';
        $updateOrderWorkoutRoute = '{{ URL::route('update.order.workout') }}';
        $deleteSubRoute = '{{ URL::route('delete.training.main.workout') }}';
        $getExerciseVideoRoute = '{{ URL::route('get.exercise.video') }}';
        $importPlanDataRout = '{{ URL::route('plan.get.training.programs') }}';
        $importPlanRoute = '{{ URL::route('import.plan.day') }}';
        $addCustomizeDropDown = '{{ URL::route('add.customize.dropdown') }}';
        $saveCustomizeDropDown = '{{ URL::route('save.customize.dropdown') }}';
        $removeCustomizeDropDown = '{{ URL::route('remove.customize.dropdown') }}';
        $dragDrop = true;
        $isSpecificId = 'search-exercies-dynamic';
        $token = "{{ csrf_token() }}";
        $id = '{!! $data['id'] !!}';
        $equipmentIds = $.parseJSON('{!! $data['equipmentIds'] !!}');
        $workoutTypeSet = $.parseJSON('{!! $data['workoutTypeSet'] !!}');
        $extraId = $exerciseId = $workoutCounter = $workoutSubCounter = $deleteId = $positionId = 0;
        $page = 1;
        $workoutType = '';
        $defaultType = 'renderExercises';
        $renderRoute = $getExercisesRoute;
        $search = '';
        $sortType = 'desc';
        $sortColumn = 'a.id';
        $dropDownFilters = {};
        $isBladePaginator = true;
        $clickItemId = 0;
        $addNewRowCount = [];
        $isMouseClick = true;
        $isImportRender = 0;
        $planIdNumber = 0;
        $planTypeSelected = 0;
        $clickIdTab = '';
        $isEdit = '{{$data['isEdit']}}';
        $previousValue = '';

        $(document).ready(function () {
            getPlanIdOnStart();
            $('.js-example-basic-multiple').select2({
                maximumSelectionLength: 4,
            });
            setTimeout(function () {
                $('.js-example-basic-multiple').val($equipmentIds).change();
            }, 500);
            $.when(getWeeklyPlanSetup()).then(function() {
                $dropDownFilters = {};
                getExercisesData();
            });
            $('#search').val('');
            $(document).on("click", '.paq-pager ul.pagination a', function (e) {
                e.preventDefault();
                $page = $(this).attr('href').split('page=')[1];
                getExercisesData();
            });
            // get weekly plan setup data
            $('#add-form').submit(function (e) {
                e.preventDefault();
                let inputs = $(".plan-creator-drop");
                let error = false;
                for (var i = 0; i < inputs.length; i++) {
                    if ($(inputs[i]).val() == '') {
                        error = true;
                    }
                }
                if ($('#title').val() == '') {
                    error = true;
                }
                // if ($('#equipment_id').val() == '' || $('#equipment_id').val() == null || $('#equipment_id').val() == 'null') {
                //     error = true;
                // }
                if (error == true) {
                    swal("Oops!", "Please complete the header first.", "error");
                    return false;
                }
                $addRecordRoute = $addPlanRoute;
                $type = 'addRecord';
                updateFormData();
                $formData['is_save'] = 1;
                $formData['plan_type'] = 1;
                renderClient();
            });
            $('body').on('click', '.structure-items', function () {
                if ($id == 0) {
                    swal("Oops!", "Please complete the header first.", "error");
                    return false;
                }
                let clickedId = $(this).attr('id');
                $clickIdTab = clickedId;
                getWeeklyPlanSetupData(clickedId);

            });
            $('body').on('click', '.structure-items-div', function () {
                if ($id == 0) {
                    swal("Oops!", "Please complete the header first.", "error");
                    return false;
                }
                let clickedId = $(this).attr('id');
                let splitClickedId = clickedId.split('_');
                clickedId = splitClickedId[1] + '_' + splitClickedId[2];
                $clickIdTab = clickedId;
                getWeeklyPlanSetupData(clickedId);
            });

            $('.training-plan-setup').on('click', function () {
                let inputs = $(".plan-creator-drop");
                let error = false;
                for (var i = 0; i < inputs.length; i++) {
                    if ($(inputs[i]).val() == '') {
                        error = true;
                    }
                }
                if ($('#title').val() == '') {
                    error = true;
                }
                // if ($('#equipment_id').val() == '' || $('#equipment_id').val() == null || $('#equipment_id').val() == 'null') {
                //     error = true;
                // }
                if (error == true) {
                    swal("Oops!", "Please complete the header first.", "error");
                    return false;
                }
                if ($id == 0 && error == false) {
                    updateFormData();
                    ajaxStartStop();
                    $.ajax({
                        url: $addPlanRoute,
                        type: 'POST',
                        data: $formData,
                        success: function (data) {
                            $id = data.id;
                            $('#nav-overview').html('');
                            cal.overViewPopUp('nav-overview');
                        },
                        error: function ($error) {

                        }
                    });
                }

                if ($id > 0 && error == false) {
                    $('#nav-overview').html('');
                    cal.overViewPopUp('nav-overview');
                }
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
                            renderClient();
                        }
                    },
                    error: function ($error) {

                    }
                });
            });

            $('body').on('click', '.delete_training_plan', function () {
                let clickedId = this.id.split('_');
                $deleteId = clickedId[1] + '_' + clickedId[2] + '_' + clickedId[3];
                $deleteRowId = $(this).closest("li").attr('id');
                swal({
                    title: "Are you sure to delete?",
                    icon: "warning",
                    buttons: ["Cancel", "Delete"],
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    dangerMode: true,
                    closeOnCancel: true
                }).then(function(isConfirm) {
                    if (isConfirm) {
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
            });

            $('body').on('click', '.plan-import-one-day-class', function () {
                $splitId = this.id;
                $importDayId = $splitId.split('-')[1];
                importPlans();
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

            $('body').on('click', '.delete-plan-draft', function () {
                let showMessage = '';
                let confirmBtn = '';
                if ($isEdit == true) {
                    showMessage = 'We will remove any changes you made,and keep the original version.';
                    confirmBtn = 'Keep the original version';
                } else {
                    showMessage = 'Are you sure to delete this draft?';
                    confirmBtn = 'Delete';
                }
                swal({
                    title: showMessage,
                    icon: "warning",
                    buttons: ["Close", confirmBtn],
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Keep the original version',
                    cancelButtonText: "Close",
                    dangerMode: true,
                    closeOnCancel: true
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        $formData = {
                            '_token': $token,
                            plan_id:$id,
                            is_edit:$isEdit
                        };
                        $.ajax({
                            type: 'POST',
                            url: $deleteDraftRoute,
                            data: $formData,
                            success: function (data) {
                                if (data.success == true) {
                                    window.location = $indexRoute + '?type=onedayplan';
                                } else if ($isEdit == true) {
                                    window.location = $indexRoute + '?type=onedayplan';
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
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
                    plan_type:1,
                    import_day_id:$importDayId,
                    plan_table_id:$planIdNumber,
                    is_edit: $isEdit
                };
                $.ajax({
                    type: 'POST',
                    url: $importPlanRoute,
                    data: $formData,
                    success: function (data) {
                        alert('The selected training plan was imported successfully');
                        $('.close-import-popup').click();
                        $id = $planIdNumber;
                        getWeeklyPlanSetup();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
            $('body .drop_down_filters_import').change(function () {
                if ($plan_type != 1) {
                    $planTypeSelected = $plan_type;
                }
                $plan_type = 1;
                $dropDownFilters = {};
                var inputs = $(".drop_down_filters_import");
                for (var i = 0; i < inputs.length; i++) {
                    $dropDownFilters[$(inputs[i]).attr('id')] = $(inputs[i]).val();
                }
                $isImportRender = 1;
                updateFormData();
                $type = $defaultType;
                renderClient();
                $plan_type = $planTypeSelected;
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

            $('body').on('click', '#clear-exercise-filters', function () {
                var inputs = $(".drop_down_filters_excercise");
                for (var i = 0; i < inputs.length; i++) {
                    $(inputs[i]).val('');
                }
                $dropDownFilters = {};
                $('#search_exercise').val('');
                $search = '';
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

            $('body').on('click', '#save-weekly-setup, #save-close-weekly-setup', function (e) {
                e.preventDefault();
                let close = false;
                if ($(this).attr('id') === 'save-close-weekly-setup') {
                    close = true;
                }
                savePopup(close);
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
                    formData.push({name: 'is_edit', value: $isEdit});
                    let activeTab = $('.active_tab').val();
                    let dayId = this.id.split('-')[1];
                    if (typeof (activeTab) !== 'undefined') {
                        $.post('/tabs', formData, function (response) {
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
            $('body').on('click', '.week-plan', function () {
                $clickItemId = this.id.split('_')[1];
                $('#collapse1, #collapse2, #collapse3, #collapse4').not('#collapse' + $clickItemId).removeClass('show');
                if (!$('#collapse' + $clickItemId).hasClass('show')) {
                    getWeeklyPlanSetup();
                }
            })

            $('body').on('change', '.drag-drop-workout-filters', function () {
                let clickedValue = this.value;
                let clickedId = this.id;
                let clickedDropId = $(this).attr("class").split(' ')[2];
                let clickedDragAndDropId = parseInt($('#' + clickedDropId).attr('data-drag-drop-id'));
                if (clickedDragAndDropId > 0) {
                    $val  = $(this).val();
                    if($val != 'c_option'){
                        $formData = {
                            '_token': $token,
                            id: $id,
                            clickedValue: clickedValue,
                            clickedId: clickedId,
                            clickedDragAndDropId: clickedDragAndDropId,
                            is_edit:$isEdit
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
                }
            });

            // $('body').on('click', '.close-training-setup', function () {
            //     if ($isMouseClick == true) {
            //         alert(44);
            //         let clickedId = this.id.split('_');
            //         let clickedUniqueId = clickedId[1] + '_' + clickedId[2];
            //
            //         $('#weekly-workout-setup_' + clickedUniqueId).val('');
            //         $('#plan_' + clickedUniqueId).addClass('disable-click');
            //
            //         $type = 'displayData';
            //         $displayDataRoute = $getDragDropOptionsRoute;
            //         $extraId = clickedUniqueId;
            //         displayFormData();
            //         renderClient('drag_drop_items_' + clickedUniqueId);
            //     }
            //     $isMouseClick = true;
            // });

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
                    exercise_set: parseInt($('#workout-exercise-value_' + clickedUniqueId).html()),
                    is_edit:$isEdit
                };
                addSubRecord(clickedUniqueId);
            });

            $('body').on('click', '.delete_training_plan_workout', function () {
                $clikedDeleteId = this.id;
                $deleteRowId = $(this).closest("li").attr('id');
                swal({
                    title: "Are you sure to delete?",
                    icon: "warning",
                    buttons: ["Cancel", "Delete"],
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    dangerMode: true,
                    closeOnCancel: true
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        $formData = {
                            '_token': $token,
                            id: $id,
                            deleteId: $clikedDeleteId,
                            extraId: $deleteRowId,
                            is_edit:$isEdit
                        };
                        deleteSubRecord();
                    }
                });
            });

            $('body').on('click', '#nav-overview-tab', function () {
                let isMainWorkoutOnTop = 0;
                if ($('#tab_main_workout').next('div').attr("id") === 'tab_cardio') {
                    isMainWorkoutOnTop = 1;
                }
                let formData = $('#tabs_form').serializeArray();
                formData.push({name: 'is_main_workout_top', value: isMainWorkoutOnTop});
                formData.push({name: 'is_edit', value: $isEdit});
                let activeTab = $('.active_tab').val();
                let dayId = this.id.split('-')[1];
                if (typeof (activeTab) !== 'undefined') {
                    $.post('/tabs', formData, function (response) {
                        cal.overViewPopUp('nav-overview');
                    });
                } else {
                    cal.overViewPopUp('nav-overview');
                }
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
            $('body').on('click', '.close-customized-option', function () {
                $type = 'displayData';
                $displayDataRoute = $getDragDropOptionsRoute;
                $extraId = $clickIdTab;
                displayFormData();
                renderClient('drag_drop_items_' + $clickIdTab);
                $.fancybox.close();
            });

            $("body").on('focus', '.customize-dropdowns', function () {
                // Store the current value on focus and on change
                $previousValue = this.value;
            }).change(function (e) {
                $val = '';
                let id = e.target.id;
                $val = e.target.value;
                let structureIdData = e.target.getAttribute('data-structureId');
                if ($val == 'c_option') {
                    structureId = structureIdData.split('_')[2];
                    customizeDropDown(id, structureId);
                    $('#' + id + '.' + structureIdData + ' option').removeAttr('selected');
                    $('body #' + id + '.' + structureIdData).val($previousValue);
                }
                $previousValue = $val;
            });

            $('body').on('click', '.save-customized-option', function () {
                let id = this.id;
                $customizedValue  = $('#customized-value').val();
                $formData = {
                    '_token': $token,
                    table_id:id,
                    customized_value:$customizedValue,
                };
                ajaxStartStop();
                $.ajax({
                    url: $saveCustomizeDropDown,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                        $.each(response.data, function (index, value) {
                            $('table').append('<tr id="remove_' + value + '_'+index+ '_td"><td>'+$customizedValue+'</td><td><a href="javascript: void(0)" class="remove-customize-option" id="remove_' + value + '_'+index+ '">Remove</a></td></tr>');
                        });
                        $type = 'displayData';
                        $displayDataRoute = $getDragDropOptionsRoute;
                        $extraId = $clickIdTab;
                        displayFormData();
                        renderClient('drag_drop_items_' + $clickIdTab);
                        $('#customized-value').val('');
                        $('.hide-text').hide();
                        $.each(response.data, function (index, value) {
                        $('body .' + $clickedItemId + '_customization').prepend($('<option>', {
                            value: value,
                            text: $customizedValue
                        }));
                        });
                    },
                    error: function ($error) {
                    }
                });

            });

            $('body').on('click', '.remove-customize-option', function () {
                let id = this.id;
                $removeId = id;
                $customizedValue  = $('#customized-value').val();
                $formData = {
                    '_token': $token,
                    table_id:id,
                    customized_value:$customizedValue,
                };
                ajaxStartStop();
                $.ajax({
                    url: $removeCustomizeDropDown,
                    type: 'POST',
                    data: $formData,
                    success: function (data) {
                        // $('body ').find('#'+$removeId + '_td').remove();
                        $('body #'+$removeId+'_td').remove();
                        $type = 'displayData';
                        $displayDataRoute = $getDragDropOptionsRoute;
                        $extraId = $clickIdTab;
                        displayFormData();
                        renderClient('drag_drop_items_' + $clickIdTab);
                        $('#customized-value').val('');
                        let removeSelectOption = $removeId.split('_')[1];
                        $('body .' + $clickedItemId + '_customization' + ' option[value='+removeSelectOption+']').remove();
                    },
                    error: function ($error) {

                    }
                });
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

            // finish document ready
        });

        /**
         *
         **/
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
                        renderClient('drag_drop_items_' + clickedUniqueId);
                    }
                },
                error: function ($error) {

                }
            });
        }

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

        var getWeeklyPlanSetupData = function (clickedId) {
            if (!$('#ex-row-colapse_' + clickedId).hasClass('show')) {
                $type = 'displayData';
                $displayDataRoute = $getDragDropOptionsRoute;
                $extraId = clickedId;
                displayFormData();
                renderClient('drag_drop_items_' + clickedId);
            }
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
                is_edit:$isEdit
            };
        }

        /**
         * This is used to update form data
         */
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
                plan_type:1,
                is_edit:$isEdit
            };
        }

        /**
         * This is used to get weekly plan setup
         **/
        var getWeeklyPlanSetup = function () {
            $('.add-main-workout-data').html('');
            $type = 'displayData';
            $displayDataRoute = $weeklyTrainingSetupRoute;
            displayFormData();
            renderClient('weekly_plan_training_setup');
        }

        /**
         * This is used to get exercised data
         */
        var getExercisesData = function () {
            $type = 'displayData';
            $displayDataRoute = $getExercisesRoute;
            displayFormData();
            renderClient('search-exercies-dynamic');
        }
        /**
         * this is used to get plan data in import popup
         */
        var importPlans = function () {
            $formData = {};
            $formData = {
                '_token': $token,
                page:  $page,
                search: $search,
                sortType: $sortType,
                sortColumn: $sortColumn,
                dropDownFilters: $dropDownFilters,
                plan_type:1
            };
            $type = 'renderPlans';
            $isImportRender = 1;
            $renderRoute = $importPlanDataRout;
            $plan_type = 2;
            renderClient();
            $('#search').val('');
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
        function customizeDropDown(id,clickedDropId) {
            $clickedItemId = id.split('_')[0];
            $formData = {
                '_token': $token,
                table_id:id,
                structure_id:clickedDropId
            };
            $.ajax({
                url: $addCustomizeDropDown,
                type: 'POST',
                data: $formData,
                success: function (response) {
                    $.fancybox(response.view, {
                        width : 500,
                        height : 500,
                        fitToView : true,
                        autoSize : false,
                        closeClick: false,
                        closeEffect: false,
                        'autoscale': true,
                        openEffect: 'none'
                    });
                },
                error: function ($error) {
                },
                error: function ($error) {

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
                if (oldVal < 10) {
                    let newVal = oldVal + parseInt(inc);
                    $('#' + id).html(newVal);
                }
            },
            weeklyPopUp: function (id) {
                $.get('/tabs/' + $id + '/' + id + '/' + $isEdit, function (response) {
                    $('#nav-overview').html(response.view);
                    if (response.isMainWorkoutTop < 1) {
                        moveUp();
                    }
                });
            },
            overViewPopUp: function (tabName) {
                $.get('/one/day/plans-overview/' + $id + '/' + $isEdit, {tabName: tabName}, function (response) {
                    $('#nav-overview').html(response);
                });
            },
        }

        /**
         * This is used to save overview popup
         **/
        var saveOverview = function (close) {
            let formData = $('#plans-overview').serializeArray();
            formData.push({name: 'plan_id', value: $id});
            formData.push({name: 'is_edit', value: $isEdit});
            let activeTab = $('.active_tab').val();
            $.post('/one/day/plans-overview', formData, function (response) {
                if (response.status == 200) {
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

        var getPlanIdOnStart = function () {
            $formData = {
                '_token': $token,
                plan_id:$id,
                plan_type: 1
            };
            $.ajax({
                type: 'POST',
                url: $createNewPlan,
                data: $formData,
                success: function (response) {
                    $planIdNumber = response.data.id;
                    $id = response.data.id;
                },
                error: function (error) {
                    console.log(error);
                }
            });
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
            formData.push({name: 'is_edit', value: $isEdit});
            let activeTab = $('.active_tab').val();
            $.post('/tabs', formData, function (response) {
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
    </script>

    {!! Html::script('js/client.js?id='.version())!!}
@endpush
