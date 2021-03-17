<div id="program-registration">
    <div class="modal-dialog">
        <div class="modal-content text-left">
            <div class="modal-body">
                <h3 class="section-title">Client's Program Registration</h3>

                <div class="week-plan c-program-accordion accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-block text-left c-program-btn" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Personal Information
                                </button>
                            </h2>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="c-program-card card-body">
                                <ul class="cl-program-list list-unstyled mb-0">
                                    <li>
                                        <div class="list-items clearfix">
                                            <label class="text-muted float-left left-div"><strong>Full name</strong></label>
                                            <span class="float-right right-div">{!!@$data['personalInformation']['first_name'] !!} {!!@$data['personalInformation']['last_name'] !!}</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-items clearfix">
                                            <label class="text-muted float-left left-div"><strong>Gender</strong></label>
                                            <span class="float-right right-div">{!! @$data['personalInformation']['gender'] !!}</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-items clearfix">
                                            <label class="text-muted float-left left-div"><strong>Age</strong></label>
                                            <span class="float-right right-div">{{@$data['age']}}</span>
                                        </div>
                                        <div class="list-items clearfix">
                                            <label class="text-muted float-left left-div"><strong>BMI</strong></label>
                                            <span class="float-right right-div">{!! @$data['personalInformation']['bmi'] !!}</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-items clearfix">
                                            <label class="text-muted float-left left-div"><strong>Waist circumference</strong></label>
                                            <span class="float-right right-div">{!! @$data['personalInformation']['waist'] !!}</span>
                                        </div>

                                        <div class="list-items clearfix">
                                            <label class="text-muted float-left left-div"><strong>Training age</strong></label>
                                            <span class="float-right right-div">{!! @$data['personalInformation']['training_age'] !!}</span>
                                        </div>

                                        <div class="list-items clearfix">
                                            <small>More info</small>
                                            <div class="form-group">
                                                <textarea id="my-textarea" class="form-control" name="" rows="1" readonly>{!! @$data['personalInformation']['more_info'] !!}</textarea>
                                            </div>
                                        </div>

                                        <div class="list-items clearfix">
                                            <label class="text-muted float-left left-div"><strong>Goal for this program</strong></label>
                                            <span class="float-right right-div">{!! @$data['personalInformation']['goal'] !!}</span>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="list-items clearfix">
                                            <label class="text-muted"><strong>Additional Details</strong></label>
                                            <div class="form-group">
                                                <textarea id="my-textarea" class="form-control" name="" rows="1" readonly>{!! @$data['personalInformation']['additional_details'] !!}</textarea>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if(!empty($data['bookingDuration']))
                        @foreach($data['bookingDuration'] as $row)
                            @if($row['key_pair'] == 'training_program')
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h2 class="mb-0">
                                            <button class="btn btn-block text-left collapsed c-program-btn"
                                                    type="button" data-toggle="collapse" data-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                Training Program
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                         data-parent="#accordionExample">
                                        <div class="c-program-card card-body">
                                            <ul class="cl-program-list list-unstyled mb-0">
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Total Training plans</strong></label>
                                                        <span class="float-right right-div">{!!@$row['total_sessions'] !!}</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Duration</strong></label>
                                                        <span class="float-right right-div">{!!@$row['week'] !!}</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Days per
                                                                week</strong></label>
                                                        <div class="float-right d-block right-div">
                                                            <p class="mb-0">{!! @$row['training_plan'] !!}</p>
                                                            <small>
                                                                @foreach($data['days'] as $days)
                                                                    {{$days}}@if(!$loop->last),@endif
                                                                @endforeach
                                                            </small>

                                                        </div>
                                                    </div>
                                                </li>
                                                @if(!isLightVersion())
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Change of training plan</strong></label>
                                                        <span class="float-right right-div">{!!@$row['change_training_plan'] !!}</span>
                                                    </div>
                                                </li>
                                                @endif
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Start date</strong></label>
                                                        <span class="float-right right-div">{!!viewDateFormat(@$row['starting_date']) !!}</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Client
                                                                selection of exercise equipment</strong></label>

                                                        <span class="float-right right-div">
                                                            @foreach($arrEquipemntsName as $row)
                                                                {{$row}}<br>
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($row['key_pair'] == 'diet_program')
                                <div class="card">
                                    <div class="card-header" id="headingFive">
                                        <h2 class="mb-0">
                                            <button class="btn btn-block text-left collapsed c-program-btn"
                                                    type="button" data-toggle="collapse" data-target="#diet-program"
                                                    aria-expanded="false" aria-controls="diet-program">
                                                Diet Program
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="diet-program" class="collapse" aria-labelledby="headingFive"
                                         data-parent="#accordionExample">
                                        <div class="c-program-card card-body">
                                            <ul class="cl-program-list list-unstyled mb-0">
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Total Diet plans</strong></label>
                                                        <span class="float-right right-div">{!!@$row['total_sessions'] !!}</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>
                                                                Duration</strong></label>
                                                        <div class="float-right right-div">
                                                            <p class="mb-0">{{@$row['week']}}</p>
                                                            <small></small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>
                                                                Frequency</strong></label>
                                                        <div class="float-right right-div">
                                                            <p class="mb-0">{{@$row['training_plan']}}</p>
                                                            <small></small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Change Diet plan</strong></label>
                                                        <span class="float-right right-div">{!!@$row['change_training_plan'] !!}</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Start date</strong></label>
                                                        <span class="float-right right-div">{!!databaseDateFromat(@$row['starting_date']) !!}</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($row['key_pair'] == 'online_coaching')
                                <div class="card">
                                    <div class="card-header" id="headingThree">
                                        <h2 class="mb-0">
                                            <button class="btn btn-block text-left c-program-btn collapsed"
                                                    type="button" data-toggle="collapse" data-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                Online Coaching
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                         data-parent="#accordionExample">
                                        <div class="c-program-card card-body">
                                            <ul class="cl-program-list list-unstyled mb-0">
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Total online coaching sessions</strong></label>
                                                        <div class="float-right right-div">
                                                            <p class="mb-0">{{@$row['total_sessions']}}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>
                                                                Duration</strong></label>
                                                        <div class="float-right right-div">
                                                            <p class="mb-0">{{@$row['week']}}</p>
                                                            <small></small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>
                                                                Frequency</strong></label>
                                                        <div class="float-right right-div">
                                                            <p class="mb-0">{{@$row['training_plan']}}</p>
                                                            <small></small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Length of
                                                                each session</strong></label>
                                                        <div class="float-right d-block right-div">
                                                            {{@$row['session_length']}}
                                                        </div>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($row['key_pair'] == 'personal_training')
                                <div class="card">
                                    <div class="card-header" id="headingFour">
                                        <h2 class="mb-0">
                                            <button class="btn btn-block text-left c-program-btn collapsed"
                                                    type="button" data-toggle="collapse" data-target="#collapseFour"
                                                    aria-expanded="false" aria-controls="collapseFour">
                                                Personal Training
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                         data-parent="#accordionExample">
                                        <div class="c-program-card card-body">
                                            <ul class="cl-program-list list-unstyled mb-0">
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Total PT sessions</strong></label>
                                                        <div class="float-right right-div">
                                                            <p class="mb-0">{{@$row['total_sessions']}}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Total
                                                                number of PT sessions</strong></label>
                                                        <div class="float-right right-div">
                                                            <p class="mb-0">{{@$row['week']}}, {{@$row['training_plan']}}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Training
                                                                location</strong></label>
                                                        <div class="float-right right-div">
                                                            <p class="mb-0">{{ @$row['training_session_location']}}</p>

                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="list-items clearfix">
                                                        <label class="text-muted float-left left-div"><strong>Length
                                                                of each session</strong></label>
                                                        <span class="float-right right-div">{{ @$row['session_length']}}</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
                @if(!isLightVersion())
                <div class="text-right">
                    <h4>
                        <span class="mr-3"><strong>Earning:</strong></span>
                        <strong>{{@$data['finalPrice']}}</strong>
                        <strong>{{@$objClientCurrency['code']}}</strong>
                    </h4>
                </div>
                @endif
                <div class="modal-footer">
                    <button type="button" class="btn success-btn accept_reject_booking"id="accept_{{@$data['unique_id']}}_{{@$data['finalPrice']}}">Accept Booking</button>
                    <button type="button" class="btn btn-danger accept_reject_booking"id="reject_{{@$data['unique_id']}}_{{@$data['finalPrice']}}">Reject Booking</button>

                    {{--<a href="javascript(:void)" type="button" class="btn primary-btn accept_reject_booking"id="reject_{{$data['unique_id']}}"--}}
                       {{--data-dismiss="modal">Reject Booking</a>--}}
                </div>
            </div>
        </div>
    </div>
</div>
