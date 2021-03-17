<div class="row">
    <div class="col-lg-12 mx-auto">
        {!! Form::open(['route' => ['one.day.plans-overview'], 'id' => 'plans-overview', 'class' => 'form-horizontal', 'method' => 'post', 'autocomplete' => 'off']) !!}
        <div class="row">
            <div class="col-sm-5">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class=" font-weight-bold text-center mb-3"></h5>
                        <ul class="week-list list-unstyled">
                            @foreach($data["days"] as $key => $row)
                            <li>
                                {{$row}}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <h5 class="font-weight-bold text-center mb-3"> Day Plan</h5>
                        <ul class="week-select-list list-unstyled">
                            @foreach($data["days"] as $key => $row)
                            <li>
                                {!! Form::select('day_plan_id['.$key.']', $data['day_plans'], @$overview['day_plan'][$key], ['class' => 'custom-select sel-change '.$row.'', 'required' => true, 'child-id' => 'body_part_'.$key, 'day-id' => 'day-'.$key]) !!}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-sm-7">
                <div class="row">
                    <div class="col-sm-4">
                        <h5 class="font-weight-bold text-center mb-3"> Body Part 1</h5>
                        <ul class="week-select-list list-unstyled">
                            @foreach($data["days"] as $key => $row)
                            <li>
                                {!! Form::select('body_part_1['.$key.']', $data['body_parts'], @$overview['body_part_1'][$key], ['class' => 'custom-select body_parts_drop_down body_part_'.$key.'', 'required' => true, ( @in_array($overview['day_plan'][$key], [2,3]) ? 'disabled' : '')]) !!}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <h5 class="font-weight-bold text-center mb-3"> Body Part 2</h5>
                        <ul class="week-select-list list-unstyled">
                            @foreach($data["days"] as $key => $row)
                            <li>
                                {!! Form::select('body_part_2['.$key.']', $data['body_parts'], @$overview['body_part_2'][$key] , ['class' => 'custom-select body_part_'.$key.'', 'required' => true, ( @in_array($overview['day_plan'][$key], [2,3]) ? 'disabled' : '')]) !!}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <h5 class="font-weight-bold text-center mb-3"> Body Part 3</h5>
                        <ul class="week-select-list list-unstyled">
                            @foreach($data["days"] as $key => $row)
                            <li>
                                {!! Form::select('body_part_3['.$key.']', $data['body_parts'], @$overview['body_part_3'][$key] , ['class' => 'custom-select body_part_'.$key.'', 'required' => true, ( @in_array($overview['day_plan'][$key], [2,3]) ? 'disabled' : '')]) !!}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-4">
                <button type="button" id="save-training-plan" class="btn primary-btn btn-block my-3">Apply</button>
            </div>
            <div class="col-4">
                <button type="button" id="save-close-training-plan" class="btn outline-btn btn-block my-3">Apply & Close</button>
            </div>
        </div>

        {{ Form::close() }}
    </div>
</div>
<script>
    $(function() {
        overViewSelect();
        let overViewData = $('[name^="day_plan_id"]');
        $.each(overViewData, function(index, row) {
            if ($(this).val() == '2' || $(this).val() == '3') {
                let tabClass = $(this).attr("day-id").split('-')[1];
                $('#nav-' + tabClass).addClass('disabledTab');
                $('#nav-' + tabClass).css('background-color', 'lightgrey');
                $('#nav-' + tabClass).removeAttr('data-toggle');
                $('#nav-' + tabClass).unbind('click');
            }
        });
        $('#nav-overview-tab').addClass('active');
        $('.training-plan-popup').removeClass('active');
    });
</script>