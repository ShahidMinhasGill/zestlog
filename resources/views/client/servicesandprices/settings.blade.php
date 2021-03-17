@extends('layouts.app')
<style>
    .disable-div {
        pointer-events:none;
        background-color: ghostwhite;
    }
</style>
@section('content')
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <nav>
                    <div class="nav nav-pills" id="nav-tab" role="tablist">
                        
                        <a class="nav-item nav-link Pricing-link active" id="nav-pricing-tab" data-toggle="tab"
                           href="#nav-pricing" role="tab" aria-controls="nav-pricing" aria-selected="false">Services & Pricing</a>

                        @if(!empty(isHide()))
                            <a class="nav-item nav-link Pricing-link" id="nav-Discount-tab" data-toggle="tab" href="#nav-Discount"
                               role="tab" aria-controls="nav-Discount" aria-selected="true">Discount</a>

                            <a class="nav-item nav-link Pricing-link" id="cancellation-tab" data-toggle="tab" href="#cancellation" role="tab"
                               aria-controls="cancellation" aria-selected="false"> Cancellation</a>
                        @endif
                        <div class="ml-auto d-flex align-items-center">
                            <label class="mr-2"><strong>Currency</strong></label>
                            {!! Form::select('client-currency', $objCurrency, @$objClientCurrency->currency_id , ['class' => 'custom-select currency_select', 'id' => 'client-currency']) !!}
                        </div>

                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    
                    <div class="tab-pane fade active show" id="nav-pricing" role="tabpanel" aria-labelledby="nav-pricing-tab">

                        <nav class="inner-tab">
                            <div class="nav nav-pills" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-Services-tab " data-toggle="tab"
                                   href="#nav-Services" role="tab" aria-controls="nav-Services" aria-selected="true">Services</a>

                                <a class="nav-item nav-link training_program @if(empty($training)) disable-div @endif" id="nav-Training-program-tab" data-toggle="tab"
                                   href="#nav-Training-program" role="tab" aria-controls="nav-Training-program"
                                   aria-selected="false">Training Program</a>
                                @if(!empty(isHide()))
                                <a class="nav-item nav-link diet_program @if(empty($diet)) disable-div @endif" id="nav-diet-program-tab" data-toggle="tab"
                                   href="#nav-diet-program" role="tab" aria-controls="nav-diet-program"
                                   aria-selected="false">Diet Program</a>
                                @endif
                                <a class="nav-item nav-link online_coaching @if(empty($online)) disable-div @endif" id="nav-coaching-tab" data-toggle="tab"
                                   href="#nav-coaching" role="tab" aria-controls="nav-coaching" aria-selected="false">Online
                                    Coaching</a>

                                <a class="nav-item nav-link personal_training @if(empty($personal)) disable-div @endif" id="nav-p-training-tab" data-toggle="tab"
                                   href="#nav-p-training" role="tab" aria-controls="nav-p-training"
                                   aria-selected="false">Personal Training</a>
                            </div>
                        </nav>

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade active show" id="nav-Services" role="tabpanel"
                                 aria-labelledby="nav-Services-tab">
                                @include('client.partials.setting-partials._services-tabcontent')
                            </div>
                            <div class="tab-pane training-program-data fade" id="nav-Training-program" role="tabpanel"
                                 aria-labelledby="nav-Training-program-tab">
                            </div>

                            <!-- Diet program pricing setup tab content -->
                            <div class="tab-pane training-program-data fade" id="nav-diet-program" role="tabpanel"
                                 aria-labelledby="nav-diet-program-tab">
                            </div>
                            <!-- End Diet program pricing setup tab content -->

                            <!-- Online coaching pricing setup tab content -->
                            <div class="tab-pane training-program-data fade" id="nav-coaching" role="tabpanel"
                                 aria-labelledby="nav-coaching-tab">
                            <!-- End Group online coaching -->
                            </div>
                            <!--End Online coaching pricing setup tab content -->

                            <!-- Personal training pricing setup tab content -->
                            <div class="tab-pane training-program-data fade" id="nav-p-training" role="tabpanel"
                                 aria-labelledby="nav-p-training-tab">

                            </div>

                            <!-- End Personal training pricing setup tab content -->
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-Discount" role="tabpanel"
                         aria-labelledby="nav-Discount-tab">
                        <div class="row">
                            <div class="col-md-12">
                                @include('client.partials.setting-partials._discount-tabcontent')
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="cancellation" role="tabpanel" aria-labelledby="cancellation-tab">
                        @include('client.partials.setting-partials._cancellation-tabcontent')
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
    <script>
        $calculateServicePriceRoute = '{{ URL::route('calculate.service.prices') }}';
        $getServicesProgramRoute = '{{ URL::route('get.services.program') }}';
        $saveServicesProgramRoute = '{{ URL::route('save.training.price') }}';
        $saveCoachingSessionRoute = '{{ URL::route('save.coaching.session') }}';
        $saveGroupCoachingRoute = '{{ URL::route('save.group.coaching') }}';
        $savePtLocationsRoute = '{{ URL::route('save.pt.locations') }}';
        $addPtLocationsRoute = '{{ URL::route('add.pt.locations') }}';
        $deletePtLocationsRoute = '{{ URL::route('delete.pt.locations') }}';
        $saveServicesBookingRoute = '{{ URL::route('save.services.booking') }}';
        $calculateTrainingPrices = '{{ URL::route('calculate.training.plan.prices') }}';
        $saveTrainingPlanData = '{{ URL::route('save.training.plan.data') }}';
        $currencyRoute = '{{ URL::route('save.client.currency') }}';
        $token = "{{ csrf_token() }}";
        $trainingPlanDiscounts = {};
        $trainingWeekDiscounts = {};
        $checkboxDayCheckedList = {};
        $planDayIdList = {};
        $checkboxWeekCheckedList = {};
        $availableServicesBookingId = {};
        $finalPrices = {};
        $isSaveClick = 'false';
        $emptyData = 'true';
        $isDiscountCheck = 'true';
        $isDiscountBaseChecked = 0;
        $type = 0;
        $(document).ready(function () {

            $('body').on('keypress', ':input', function (evt) {
                //if the letter is not digit then display error and don't type anything
                if ($(this).data('allow') !== 'allow-add-input') {
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if (charCode == 46) {
                        //Check if the text already contains the . character
                        if (this.value.indexOf('.') === -1) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        if (charCode > 31 &&
                            (charCode < 48 || charCode > 57))
                            return false;
                    }
                }

                return true;
                enableDisable();
            });
            $('.nav-link').click(function () {
                let id = this.id;
                id = id.substring(0, id.lastIndexOf("-"));
                $formData = {
                    '_token': $token,
                    id: id
                };
                if(id == 'nav-coaching' || id == 'nav-Training-program' || id == 'nav-p-training' || id == 'nav-diet-program') {
                    ajaxStartStop();
                    $.ajax({
                        url: $getServicesProgramRoute,
                        type: 'POST',
                        data: $formData,
                        success: function (response) {
                            if (response.success == true) {
                                $('.training-program-data').html('');
                                $('#' + response.id).html(response.data);
                                clearArrays();
                                if (id == 'nav-Training-program') {
                                    $type = 1;
                                    checkConditions();
                                } else if (id == 'nav-diet-program') {
                                    $type = 2;
                                    checkConditions();
                                }else if (id == 'nav-coaching') {
                                    $type = 3;
                                    checkConditions();
                                    $('.coaching-sessions-listing').each(function (i, e) {
                                        let id = this.id.split('_')[2];
                                        if ($(this).is(':checked')) {
                                            $('.coaching-sessions_' + id).prop("disabled", false);
                                            $('#price_changed_' + id).prop("disabled", false);
                                        } else {
                                            $('.coaching-sessions_' + id).prop("disabled", true);
                                            $('#price_changed_' + id).prop("disabled", true);
                                        }
                                    });
                                    $('.coaching-sessions').each(function (i, e) {
                                        let id = this.id.split('_')[2];
                                        if ($(this).is(':checked')) {
                                            $('.coaching-sessions_' + id).prop("disabled", false);
                                        } else {
                                            $('.coaching-sessions_' + id).prop("disabled", true);
                                        }
                                    });
                                }else if (id == 'nav-p-training') {
                                    $type = 4;
                                    // $('.group-coaching-sessions').each(function (i, e) {
                                    //     let id = this.id.split('_')[3];
                                    //     if ($(this).is(':checked')) {
                                    //         $('.group-coaching-sessions_' + id).prop("disabled", false);
                                    //     } else {
                                    //         $('.group-coaching-sessions_' + id).prop("disabled", true);
                                    //     }
                                    // });
                                    $('.coaching-sessions-listing').each(function (i, e) {
                                        let id = this.id.split('_')[2];
                                        if ($(this).is(':checked')) {
                                            $('.coaching-sessions_' + id).prop("disabled", false);
                                            $('#price_changed_' + id).prop("disabled", false);
                                        } else {
                                            $('.coaching-sessions_' + id).prop("disabled", true);
                                            $('#price_changed_' + id).prop("disabled", true);
                                        }
                                    });

                                    $('.coaching-sessions').each(function (i, e) {
                                        let id = this.id.split('_')[2];
                                        if ($(this).is(':checked')) {
                                            $('.coaching-sessions_' + id).prop("disabled", false);
                                        } else {
                                            $('.coaching-sessions_' + id).prop("disabled", true);
                                        }
                                    });

                                    $('.pt-coaching-sessions').each(function (i, e) {
                                        let id = this.id.split('_')[2];
                                        if ($(this).is(':checked')) {
                                            $('.pt-coaching-sessions_' + id).prop("disabled", false);
                                        } else {
                                            $('.pt-coaching-sessions_' + id).prop("disabled", true);
                                        }
                                    });
                                    checkConditions();
                                }
                            }

                        },
                        error: function ($error) {

                        }
                    });
                }
            });
            $('body').on('click', '#calculate-discount', function () {
                clearArrays();
                $isSaveClick = 'false'
                $emptyData = 'false';
                if (document.getElementById('my-input2').checked) {
                    $isDiscountBaseChecked= 1;
                    $isDiscountCheck = 'true'
                    saveAndCalculatePrices();
                }else
                {
                    // $isDiscountBaseChecked= 0;
                    // $isDiscountCheck = 'false'
                    $isDiscountBaseChecked= 1;
                    $isDiscountCheck = 'true'
                    saveAndCalculatePrices();
                }

            });
            $('body').on('click', '#btn-save', function () {
                $clickedId = this.id;
                enableDisable();
                if ($(this).attr('data-id') == 0) {
                    $('#' + $clickedId).attr('data-id', 1);
                    $('#' + $clickedId).html('Save');
                    $('#' + $clickedId + '-div').removeClass('disable-div');
                    $('.discount-input').removeClass('disable-div');
                } else {
                    clearArrays();
                    $isSaveClick = 'true';
                    $emptyData = 'false';
                    if (document.getElementById('my-input2').checked) {
                        $isDiscountBaseChecked = 1;
                        $isDiscountCheck = 'true'

                    } else {
                        $isDiscountBaseChecked = 0;
                        $isDiscountCheck = 'false'
                    }
                    saveAndCalculatePrices();
                }
                $('.final_week_input_1').addClass('disable-div');
                $('.final_week_input_2').addClass('disable-div');
                $('.final_week_input_3').addClass('disable-div');
                $('.final_week_input_4').addClass('disable-div');
                $('.final_week_input_5').addClass('disable-div');
                $('.final_week_input_6').addClass('disable-div');
            });

            $('body').on('click', '#calculate-training-price', function () {
                $baseTrainingPrice = $('#base_price').val();
                $dayId = {};
                $('.checkbox-checked-training-days').each(function (i, e) {
                    let id = this.id.split('_')[1];
                    if ($(this).is(':checked')) {
                        $dayId[id] = id;
                    }
                });
                $formData = {
                    base_price: $baseTrainingPrice,
                    day_id: $dayId
                }
                $.ajax({
                    url: $calculateTrainingPrices,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                        $.each(response.data, function (index, value) {
                            $('#' + index).val(value);
                        });
                    },
                    error: function ($error) {
                    }
                });
            });

            $('body').on('click', '#btn-save-training-plan', function () {
                let clickedId = this.id;
                if ($(this).attr('data-id') == 0) {
                    $('#' + clickedId).attr('data-id', 1);
                    $('#' + clickedId).html('Save');
                    $('#' + clickedId + '-div').removeClass('disable-div');
                } else {
                    $isDefaultCheckedLengthProgram = 0;
                    $isDefaultCheckedWeeklyRepeat = 0;
                    $isDefaultcheckedRepeatProgram = 0;

                    if($(".is_default_checked_weekly_repeat").prop('checked') == true){
                        $isDefaultCheckedWeeklyRepeat = 1;
                    }
                    if($("#checkbox_use_default_booking").prop('checked') == true){
                        $isDefaultCheckedLengthProgram = 1;
                    }
                    if($("#checkbox_repeat_program").prop('checked') == true){
                        $isDefaultcheckedRepeatProgram = 1;
                    }

                    $btnname = $( "#btn-save-training-data" ).html();
                    $baseTrainingPrice = $('#base_price').val();
                    $dayIds = {};
                    $weekIds = {};
                    $booking={};
                    $('.checkbox-checked-training-days').each(function (i, e) {
                        let id = this.id.split('_')[1];
                        if ($(this).is(':checked')) {
                            $daysPlanValue =  $('#discount_'+id).val();
                            $dayIds[id] = $daysPlanValue;
                        }
                    });
                    $('.discount-training-one-booking').each(function (i, e) {
                        let id = this.id.split('_')[1];
                        if ($(this).is(':checked')) {
                            $weekDiscountValue =  $('#discount-week_'+id).val();
                            $weekIds[id] = $weekDiscountValue;
                        }
                    });

                    $('.purchased-booking').each(function (i, e) {
                        let id = this.id.split('_')[1];
                        $bookingValue =  $('#booking_'+id).val();
                        $booking[id] = $bookingValue;
                    });

                    $formData = {
                        base_price: $baseTrainingPrice,
                        day_id: $dayIds,
                        week_id: $weekIds,
                        booking_value:$booking,
                        repeat_percentage:$('#repeat-input-percentage').val(),
                        is_default_checked_weekly_repeat:$isDefaultCheckedWeeklyRepeat,
                        is_default_checked_length_program:$isDefaultCheckedLengthProgram,
                        is_default_checked_repeat_program:$isDefaultcheckedRepeatProgram,
                    }
                    $.ajax({
                        url: $saveTrainingPlanData,
                        type: 'POST',
                        data: $formData,
                        success: function (response) {
                            $('#' + clickedId).attr('data-id', 0);
                            $('#' + clickedId).html('Edit');
                            $('#' + clickedId + '-div').addClass('disable-div');
                            $.each(response.data, function (index, value) {
                                $('#' + index).val(value);
                            });
                        },
                        error: function ($error) {
                        }
                    });
                }
            });

            $('body').on('click', '#checkbox_use_default_booking', function () {
                if ($(this).is(':checked')) {
                    $('.discount-training-plan-week').prop("disabled", true);
                    // $('.week-training-booking-row-2').hide();
                    $('#discount-week_1').val(0);
                    $('#discount-week_2').val(2.5);
                    $('#discount-week_3').val(5);
                    $('#discount-week_4').val(7.5);
                    $('#discount-week_5').val(15);
                    $('#discount-week_6').val(30);
                } else {
                    $('.discount-training-plan-week').prop("disabled", false);
                    // $('.week-training-booking-row-2').show();
                    $('#discount-week_1').val('');
                    $('#discount-week_2').val('');
                    $('#discount-week_3').val('');
                    $('#discount-week_4').val('');
                    $('#discount-week_5').val('');
                    $('#discount-week_6').val('');
                    // $('#discount-week_7').val('');
                }
            });


            $('body').on('click', '.coaching_input', function () {
                if ($(this).is(':checked')) {
                    $('.online-coaching-discount-weeks').prop("disabled", true);

                    // $('.week-training-booking-row-2').hide();
                    $('#discount-week_1').val(0);
                    $('#discount-week_2').val(2.5);
                    $('#discount-week_3').val(5.0);
                    $('#discount-week_4').val(7.5);
                    $('#discount-week_5').val(15.0);
                    $('#discount-week_6').val(30.0);


                    $('.discount-training-plan').prop("disabled", true);
                    $('#discount_250').val(0.0);
                    $('#discount_500').val(2.5);
                    $('#discount_1').val(5.0);
                    $('#discount_2').val(7.5);
                    $('#discount_3').val(10.0);
                    $('#discount_4').val(12.5);
                    $('#discount_5').val(15.0);
                    $('#discount_6').val(17.5);
                    $('#discount_7').val(20.0);

                } else {
                    $('.online-coaching-discount-weeks').prop("disabled", false);
                    $('.online-coaching-discount-weeks').removeClass('disable-div');
                    $('#discount-week_1').val('');
                    $('#discount-week_2').val('');
                    $('#discount-week_3').val('');
                    $('#discount-week_4').val('');
                    $('#discount-week_5').val('');
                    $('#discount-week_6').val('');


                    $('.discount-training-plan').prop("disabled", false);
                    $('.discount-training-plan').removeClass('disable-div');
                    $('#discount_250').val('');
                    $('#discount_500').val('');
                    $('#discount_1').val('');
                    $('#discount_2').val('');
                    $('#discount_3').val('');
                    $('#discount_4').val('');
                    $('#discount_5').val('');
                    $('#discount_6').val('');
                    $('#discount_7').val('');
                }
            });

            $('body').on('click', '.training_input', function () {
                if ($(this).is(':checked')) {
                    $('.discount-training-plan-week').prop("disabled", true);

                    // $('.week-training-booking-row-2').hide();
                    $('#discount-week_1').val(0);
                    $('#discount-week_2').val(2.5);
                    $('#discount-week_3').val(5.0);
                    $('#discount-week_4').val(7.5);
                    $('#discount-week_5').val(15.0);
                    $('#discount-week_6').val(30.0);


                    $('.discount-training-plan').prop("disabled", true);
                    $('#discount_250').val(0.0);
                    $('#discount_500').val(0.0);
                    $('#discount_1').val(0.0);
                    $('#discount_2').val(2.5);
                    $('#discount_3').val(5.0);
                    $('#discount_4').val(7.5);
                    $('#discount_5').val(10.0);
                    $('#discount_6').val(12.5);
                    $('#discount_7').val(15.0);

                } else {
                    $('.discount-training-plan-week').prop("disabled", false);
                    $('.discount-training-plan-week').removeClass('disable-div');
                    $('#discount-week_1').val('');
                    $('#discount-week_2').val('');
                    $('#discount-week_3').val('');
                    $('#discount-week_4').val('');
                    $('#discount-week_5').val('');
                    $('#discount-week_6').val('');


                    $('.discount-training-plan').prop("disabled", false);
                    $('.discount-training-plan').removeClass('disable-div');
                    $('#discount_250').val('');
                    $('#discount_500').val('');
                    $('#discount_1').val('');
                    $('#discount_2').val('');
                    $('#discount_3').val('');
                    $('#discount_4').val('');
                    $('#discount_5').val('');
                    $('#discount_6').val('');
                    $('#discount_7').val('');
                }
            });


            $('body').on('click', '#checkbox_repeat_program', function () {
                if ($(this).is(':checked')) {
                    $('.purchased-booking').prop("disabled", true);
                    $('#booking_1').val(0);
                    $('#booking_2').val(2.5);
                    $('#booking_3').val(5);
                    $('#booking_4').val(7.5);
                    $('#booking_5').val(12.5);
                    $('#booking_6').val(20);
                } else {
                    $('.purchased-booking').prop("disabled", false);
                    $('#booking_1').val('');
                    $('#booking_2').val('');
                    $('#booking_3').val('');
                    $('#booking_4').val('');
                    $('#booking_5').val('');
                    $('#booking_6').val('');
                }
            });
            $('body').on('click', '.is_default_checked_weekly_repeat', function () {
                if ($(this).is(':checked')) {
                    $('#repeat-input-percentage').val(10);
                } else {
                    $('#repeat-input-percentage').val('');
                }
            });
            $('body').on('click', '.coaching-sessions', function () {
                let id = this.id.split('_')[2];
                if ($(this).is(':checked')) {
                    $('.coaching-sessions_' + id).prop("disabled", false);
                } else {
                    $('.coaching-sessions_' + id).prop("disabled", true);
                }
            });

            $('body').on('click', '.coaching-sessions-listing', function () {
                let id = this.id.split('_')[2];
                if ($(this).is(':checked')) {
                    $('.coaching-sessions_' + id).prop("disabled", false);
                    $('#price_changed_' + id).prop("disabled", false);
                } else {
                    $('.coaching-sessions_' + id).prop("disabled", true);
                    $('#price_changed_' + id).prop("disabled", true);
                }
            });

            $('body').on('click', '.coaching-checkbox', function () {
                if ($(this).is(':checked')) {
                    $(this).prop('checked', true);
                } else {
                    $(this).prop('checked', false);
                }
            });

            // $('body').on('click', '.group-coaching-sessions', function () {
            //     let id = this.id.split('_')[3];
            //     if ($(this).is(':checked')) {
            //         $('.group-coaching-sessions_' + id).prop("disabled", false);
            //     } else {
            //         $('.group-coaching-sessions_' + id).prop("disabled", true);
            //     }
            // });

            // $('body').on('click', '.group-coaching-checkbox', function () {
            //     if ($(this).is(':checked')) {
            //         $(this).prop('checked', true);
            //     } else {
            //         $(this).prop('checked', false);
            //     }
            // });

            $('body').on('click', '.pt-coaching-sessions', function () {
                let id = this.id.split('_')[3];
                if ($(this).is(':checked')) {
                    $('.pt-coaching-sessions_' + id).prop("disabled", false);
                } else {
                    $('.pt-coaching-sessions_' + id).prop("disabled", true);
                }
            });

            $('body').on('click', '.pt-coaching-checkbox', function () {
                if ($(this).is(':checked')) {
                    $(this).prop('checked', true);
                } else {
                    $(this).prop('checked', false);
                }
            });

            $('body').on('click', '#save-coaching-sessions, #save-pt-sessions', function () {
                let id = this.id;
                if ($(this).attr('data-id') == 0) {
                    $('#' + id).attr('data-id', 1);
                    $('#' + id).html('Save');
                    $('#' + id + '-div').removeClass('disable-div')
                } else {
                    let type = 0;
                    let key = 'length_online_coaching_session';
                    let keyVal = 0;
                    if (this.id == 'save-pt-sessions') {
                        type = 1;
                        key = 'length_pt_session';
                    }
                    if ($('#' + key).is(':checked')) {
                        keyVal = 1;
                    }
                    let data = $("form[name=coaching-session-form]").serializeArray();
                    $('.coaching-checkbox').each(function (i, e) {
                        if (!$(this).is(':checked')) {
                            data.push({name: e.getAttribute("name"), value: 0});
                        }
                    });
                    $formData = {
                        '_token': $token,
                        'data': data,
                        'type': type,
                        'key': key,
                        'keyVal': keyVal
                    };
                    ajaxStartStop();
                    $.ajax({
                        url: $saveCoachingSessionRoute,
                        type: 'POST',
                        data: $formData,
                        success: function (response) {
                            $('#' + id).attr('data-id', 0);
                            $('#' + id).html('Edit');
                            $('#' + id + '-div').addClass('disable-div')
                        },
                        error: function ($error) {
                        }
                    });
                }
            });

            $('body').on('click', '#save-group-coaching, #save-group-sessions', function () {
                let type = 0;
                let key = 'group_online_coaching';
                let keyVal = 0;
                if (this.id == 'save-group-sessions') {
                    type = 1;
                    key = 'group_personal_training';
                }
                if ($('#' + key).is(':checked')) {
                    keyVal = 1;
                }

                let data = $("form[name=group-coaching-form]").serializeArray();
                $('.group-coaching-checkbox').each(function (i, e) {
                    if (!$(this).is(':checked')) {
                        data.push({name: e.getAttribute("name"), value: 0});
                    }
                });
                $formData = {
                    '_token': $token,
                    'data': data,
                    'type': type,
                    'key': key,
                    'keyVal': keyVal
                };
                ajaxStartStop();
                $.ajax({
                    url: $saveGroupCoachingRoute,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                    },
                    error: function ($error) {
                    }
                });
            });

            $('body').on('click', '#save-pt-locations', function () {
                let id = this.id;
                if ($(this).attr('data-id') == 0) {
                    $('#' + id).attr('data-id', 1);
                    $('#' + id).html('Save');
                    $('#' + id + '-div').removeClass('disable-div')
                } else {
                    key = 'pt_session_location';
                    keyVal = 0;
                    if ($('#' + key).is(':checked')) {
                        keyVal = 1;
                    }
                    let data = $("form[name=pt-location-form]").serializeArray();
                    $('.group-coaching-checkbox').each(function (i, e) {
                        if (!$(this).is(':checked')) {
                            data.push({name: e.getAttribute("name"), value: 0});
                        }
                    });
                    $formData = {

                        '_token': $token,
                        'data': data,
                        'key': key,
                        'keyVal': keyVal
                    };
                    ajaxStartStop();
                    $.ajax({
                        url: $savePtLocationsRoute,
                        type: 'POST',
                        data: $formData,
                        success: function (response) {
                            $('#' + id).attr('data-id', 0);
                            $('#' + id).html('Edit');
                            $('#' + id + '-div').addClass('disable-div');
                        },
                        error: function ($error) {
                        }
                    });
                }
            });

            $('body').on('click', '#add-pt-location', function () {
                $formData = {
                    '_token': $token,
                };
                ajaxStartStop();
                $.ajax({
                    url: $addPtLocationsRoute,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                        $('#pt-locations-body').append(response.data);
                    },
                    error: function ($error) {
                    }
                });
            });

            $('body').on('click', '.delete-pt-locations', function () {
                $deleteId = this.id;
                var result = confirm(('Are you sure to delete'));
                if (result) {
                    $formData = {
                        '_token': $token,
                        'id': $deleteId
                    };
                    ajaxStartStop();
                    $.ajax({
                        url: $deletePtLocationsRoute,
                        type: 'POST',
                        data: $formData,
                        success: function (response) {
                            if (response.success == true) {
                                $('#row_' + response.id).remove();
                            }
                        },
                        error: function ($error) {
                        }
                    });
                }
            });
            $('.currency_select').on('change', function () {
                var currency_id = $(".currency_select option:selected").val();
                if (currency_id != '') {
                    $.ajax({
                        type: 'POST',
                        url: $currencyRoute,
                        data: {
                            currency_id: currency_id,
                        },
                    });
                }
            });

            $('body').on('click', '.checkbox-services', function () {
                let id = this.id.split('_')[1];
                let keyId = $(this).attr('data-key');
                let isChecked = 0;
                if (this.checked === true) {
                    isChecked = 1;
                }
                ajaxStartStop();
                $formData = {
                    '_token': $token,
                    'id': id,
                    'is_checked': isChecked,
                };
                $.ajax({
                    url: $saveServicesBookingRoute,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                        if (response.success == true) {
                            if (isChecked == 1) {
                                $('.' + keyId).removeClass('disable-div');
                            } else {
                                $('.' + keyId).addClass('disable-div');
                            }
                        }
                    },
                    error: function ($error) {
                    }
                });
            });

        });

        var clearArrays = function () {
            $trainingPlanDiscounts = {};
            $trainingWeekDiscounts = {};
            $checkboxDayCheckedList = {};
            $checkboxWeekCheckedList = {};
            $availableServicesBookingId ={};
            $planDayIdList = {};
            $finalPrices = {};
            $isSaveClick = 'false';
            $emptyData = 'true';
            $isDiscountCheck = 'true';
            $isDiscountBaseChecked = 0;
        }
        var checkConditions = function () {
            if (document.getElementById('my-input2').checked) {
                $isDiscountCheck = 'true';
                $(".discount-input").removeClass('disable-div');
                $(".final_price_class").prop("disabled", true);
                $('.training-plan-checkbox').each(function (index, obj) {
                    if (this.checked === false) {
                        let id = this.id.split('_')[1];
                        $('.final_day_' + id).css("background-color","#D3D3D3");
                    }
                });

                $('.training-week-checkbox').each(function (index, obj) {
                    if (this.checked === false) {
                        let id = this.id.split('_')[1];
                        $('.final_week_' + id).css("background-color","#D3D3D3");
                    }
                });
                saveAndCalculatePrices();
            } else {
                $isDiscountCheck = 'false'
                $(".discount-input").addClass('disable-div');
                $(".final_price_class").prop("disabled", false);
                $('.training-plan-checkbox').each(function (index, obj) {
                    if (this.checked === false) {
                        let id = this.id.split('_')[1];
                        $('.final_day_input_' + id).prop("disabled", true);
                        $('.final_day_' + id).css("background-color","#D3D3D3");
                    }
                });
                $('.training-week-checkbox').each(function (index, obj) {
                    if (this.checked === false) {
                        let id = this.id.split('_')[1];
                        $('.final_week_input_' + id).prop("disabled", true);
                        $('.final_week_input_' + id).addClass('disable-div');;
                        $('.final_week_' + id).css("background-color","#D3D3D3");
                    }
                });
            }
        }

        var saveAndCalculatePrices = function () {
            $('.training-plan-checkbox').each(function (index, obj) {
                if (this.checked === true) {
                    let splitId = this.id.split('_');
                    let id = splitId[1];
                    let trainingPlanId = splitId[2];
                    $trainingPlanDiscounts[id] = $('#discount_' + id).val();
                    $checkboxDayCheckedList[id + '_' + trainingPlanId] = id;

                }
            });
            $('.training-week-checkbox').each(function (index, obj) {
                if (this.checked === true) {
                    let id = this.id.split('_')[1];
                    $trainingWeekDiscounts[id] = $('#discount-week_' + id).val();
                    $checkboxWeekCheckedList[id] = id;
                }
            });
            $('.final_price_class').each(function (index, obj) {
                let id = this.id.split('_');
                id = id[2]+'_'+id[3];
                $finalPrices[id] = $('#final_price_' + id).val();
            });
            updateFormData();
            if ($isSaveClick == 'true') {
                SaveServicePrices();
            } else {
                calculateServicePrices();
            }

        }

        /**
         *
         **/
        var calculateServicePrices = function () {
            ajaxStartStop();
            $.ajax({
                url: $calculateServicePriceRoute,
                type: 'POST',
                data: $formData,
                success: function (response) {
                    if (response.success == true) {
                        $(".week-fields").val('');
                        $(".week-fields").html('----');
                        $.each(response.data, function (index, value) {
                            $.each(value, function (i, v) {
                                $('#' + i).val(v);
                                $('#' + i).html(v);
                            })
                        });
                    }
                },
                error: function ($error) {

                }
            });
        }
        // save training Prices
        var SaveServicePrices = function () {
            ajaxStartStop();
            $.ajax({
                url: $saveServicesProgramRoute,
                type: 'POST',
                data: $formData,
                success: function (response) {
                    if (response.success == true) {
                        $('#' + $clickedId).attr('data-id', 0);
                        $('#' + $clickedId).html('Edit');
                        $('#' + $clickedId + '-div').addClass('disable-div');
                    }
                },
                error: function ($error) {

                }
            });
        }



        var enableDisable = function () {
            if (document.getElementById('my-input2').checked) {

                $('.discount-training-plan').prop("disabled", true);
                $('.discount-training-plan').addClass('disable-div');
                $('.discount-training-plan-week').prop("disabled", true);
                $('.discount-training-plan-week').addClass('disable-div');
                $('.online-coaching-discount-weeks').prop("disabled", true);
                $('.online-coaching-discount-weeks').addClass('disable-div');

            }
            else
            {
                $('.discount-training-plan').prop("disabled", false);
                $('.discount-training-plan').removeClass('disable-div');
                $('.discount-training-plan-week').prop("disabled", false);
                $('.discount-training-plan-week').removeClass('disable-div');
                $('.online-coaching-discount-weeks').prop("disabled", false);
                $('.online-coaching-discount-weeks').removeClass('disable-div');

            }

           }
        /**
         * This is used to update form data
         */
        var updateFormData = function () {
            $formData = {
                '_token': $token,
                // data:  $('#add-form').serialize(),
                trainingPlanDiscounts: $trainingPlanDiscounts,
                trainingWeekDiscounts: $trainingWeekDiscounts,
                basePrice: $('#base_price').val(),
                isSaveClick: $isSaveClick,
                emptyData: $emptyData,
                isDiscountCheck: $isDiscountCheck,
                finalPrices: $finalPrices,
                checkboxDayCheckedList: $checkboxDayCheckedList,
                checkboxWeekCheckedList: $checkboxWeekCheckedList,
                isDiscountBaseChecked: $isDiscountBaseChecked,
                type: $type,
                availableServicesBookingId: $availableServicesBookingId,
                planDayIdList: $planDayIdList
            };
        }

        function clearFields() {
            $isSaveClick = 'false'
            if (document.getElementById('my-input2').checked) {
                $(".discount-input").prop("disabled", false);
                $(".final_price_class").val('');
                $isDiscountCheck = 'true';
                $emptyData = 'true';
            } else {
                $isDiscountCheck = 'false';
                $(".discount-input").prop("disabled", true);
                $(".week-fields").html('---');
                $('.discount-input').val('');
                $(".final_price_class").val('');
            }
            checkConditions();
        }

        function daysCheckboxChecked() {
            $('.training-plan-checkbox').each(function (index, obj) {
                if (this.checked === true) {
                    let id = this.id.split('_')[1];
                    $('.final_day_' + id).css("background-color", "#FFFFFF");
                    $('.final_day_input_' + id).prop("disabled", false);
                }
                if (this.checked === false) {
                    let id = this.id.split('_')[1];
                    $('.final_day_' + id).css("background-color", "#D3D3D3");
                    $('.final_day_input_' + id).prop("disabled", true);
                    $('.final_day_input_' + id).val('');
                }
            });
            $('.training-week-checkbox').each(function (index, obj) {
                if (this.checked === false) {
                    let id = this.id.split('_')[1];
                    $('.final_week_' + id).css("background-color", "#D3D3D3");
                    $('.final_day_week_' + id).css("background-color", "#D3D3D3");
                    $('.final_week_input_' + id).prop("disabled", true);
                    $('.final_week_input_' + id).addClass('disable-div');
                }
                if (this.checked === true) {
                    let id = this.id.split('_')[1];
                    $('.final_week_' + id).css("background-color", "#FFFFFF");
                }
            });
        }
    </script>
    {!! Html::script('js/client.js?id='.version())!!}
@endpush
