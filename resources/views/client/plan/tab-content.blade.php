{!! Form::open(['route' => ['plans-weekly-setup'], 'class' => 'form-horizontal', 'method' => 'post','id' => 'tabs_form', 'autocomplete' => 'off']) !!}
<input type="hidden" name="active_tab" class="active_tab" value="{{$days_data}}">
<input type="hidden" name="day_id" class="day_id" value="{{ $day_id }}">
<input type="hidden" name="plan_id" class="tab_id" value="{{ $plan->id }}">
<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="training-plan-str pb-3 mb-3 border-bottom pl-5">
            <h3 class="section-title"><small>{{$days_data}} Training Plan Structure</small></h3>
            <div id="plan-items">
                <div class="col-items col1">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="warm-up_{{$day_id}}_{{$plan->id}}" name="warm_up" type="checkbox" checked="checked" disabled>
                        <label class="custom-control-label" for="warm-up_{{$day_id}}_{{$plan->id}}">Warm-up</label>
                    </div>
                </div>
                <div class="col-items col2" id="tab_main_workout">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="main-workout_{{$day_id}}_{{$plan->id}}" name="main_workout" type="checkbox" {{ isset($data->main_workout) && ($data->main_workout == '1') ? 'checked="checked"' : ''}}>
                        <label class="custom-control-label" for="main-workout_{{$day_id}}_{{$plan->id}}">Main workout</label>
                    </div>
                </div>
                <div class="col-items col3" id="tab_cardio">
                    <span class="plan-navigator">
                        <a href="javaScript:void(0);" class="cardioCas" onclick="moveUp()"><i class="fas fa-arrow-up"></i></a>
                    </span>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="cardio_{{$day_id}}_{{$plan->id}}" name="cardio" type="checkbox" {{ isset($data->cardio) && ($data->cardio == '1') ? 'checked="checked"' :'' }}>
                        <label class="custom-control-label" for="cardio_{{$day_id}}_{{$plan->id}}">Cardio</label>
                    </div>
                </div>
                <div class="col-items col4">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="cool-down_{{$day_id}}_{{$plan->id}}" name="cool_down" type="checkbox" checked="checked" disabled>
                        <label class="custom-control-label" for="cool-down_{{$day_id}}_{{$plan->id}}">Cool down</label>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="main-workout-setup">--}}
        {{--<h3 class="section-title"><small>Main Work Out Setup</small></h3>--}}
        {{--<div class="row">--}}
        {{--<div class="col-3">--}}
        {{--<h5 class="font-weight-bold mb-3">Set Type</h5>--}}
        {{--<ul class="setup-list list-unstyled">--}}
        {{--<li>Horizontal set</li>--}}
        {{--<li>Vertical set</li>--}}
        {{--<li>Super set</li>--}}
        {{--<li>Triset</li>--}}
        {{--<li>Dropset</li>--}}
        {{--<li>Pyramidset</li>--}}
        {{--<li>Circut</li>--}}
        {{--</ul>--}}
        {{--</div>--}}
        {{--<div class="col-3">--}}
        {{--<h5 class="font-weight-bold mb-3">How many Set?</h5>--}}
        {{--<ul class="set-list list-unstyled">--}}
        {{--<li>--}}
        {{--<a href="javaScript:void(0);" class="reorder-up">--}}
        {{--<i class="fas fas fa-minus" onclick=cal.DataDecrement("horizontal_set_{{$days_data}}","1")></i></a>--}}
        {{--<input type="hidden" name="horizontal_set" class="horizontal_set_{{$days_data}}" value="{{ !empty($data->horizontal_set) ? $data->horizontal_set : '0' }}" readonly="readonly">--}}
        {{--<span id="horizontal_set_{{$days_data}}">{{ !empty($data->horizontal_set) ? $data->horizontal_set : 0}}</span>--}}
        {{--<a href="javaScript:void(0);" class="reorder-down" onclick=cal.DataIncrement("horizontal_set_{{$days_data}}","1")>--}}
        {{--<i class="fas fas fa-plus"></i></a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="javaScript:void(0);" class="reorder-up">--}}
        {{--<i class="fas fas fa-minus" onclick=cal.DataDecrement("vertical_set_{{$days_data}}","1")></i></a>--}}
        {{--<input type="hidden" name="verticle_set" class="vertical_set_{{$days_data}}" value="{{ !empty($data->verticle_set) ? $data->verticle_set : '0' }}" readonly="readonly">--}}
        {{--<span id="vertical_set_{{$days_data}}">{{ !empty($data->verticle_set) ? $data->verticle_set : 0 }}</span>--}}
        {{--<a href="javaScript:void(0);" class="reorder-down" onclick=cal.DataIncrement("vertical_set_{{$days_data}}","1")>--}}
        {{--<i class="fas fas fa-plus"></i></a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="javaScript:void(0);" class="reorder-up">--}}
        {{--<i class="fas fas fa-minus" onclick=cal.DataDecrement("super_set_{{$days_data}}","1")></i></a>--}}
        {{--<input type="hidden" name="super_set" class="super_set_{{$days_data}}" value="{{ !empty($data->super_set) ? $data->super_set : '0' }}" readonly="readonly">--}}
        {{--<span id="super_set_{{$days_data}}">{{ !empty($data->super_set) ? $data->super_set : 0 }}</span>--}}
        {{--<a href="javaScript:void(0);" class="reorder-down" onclick=cal.DataIncrement("super_set_{{$days_data}}","1")>--}}
        {{--<i class="fas fas fa-plus"></i></a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="javaScript:void(0);" class="reorder-up">--}}
        {{--<i class="fas fas fa-minus" onclick=cal.DataDecrement("triset_{{$days_data}}","1")></i></a>--}}
        {{--<input type="hidden" name="tri_set" class="triset_{{$days_data}}" value="{{ !empty($data->tri_set) ? $data->tri_set : '0' }}" readonly="readonly">--}}
        {{--<span id="triset_{{$days_data}}">{{ !empty($data->tri_set) ? $data->tri_set : 0 }}</span>--}}
        {{--<a href="javaScript:void(0);" class="reorder-down" onclick=cal.DataIncrement("triset_{{$days_data}}","1")>--}}
        {{--<i class="fas fas fa-plus"></i></a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="javaScript:void(0);" class="reorder-up">--}}
        {{--<i class="fas fas fa-minus" onclick=cal.DataDecrement("dropset_{{$days_data}}","1")></i></a>--}}
        {{--<input type="hidden" name="drop_set" class="dropset_{{$days_data}}" value="{{ !empty($data->drop_set) ? $data->drop_set : '0' }}" readonly="readonly">--}}
        {{--<span id="dropset_{{$days_data}}">{{ !empty($data->drop_set) ? $data->drop_set : 0 }}</span>--}}
        {{--<a href="javaScript:void(0);" class="reorder-down" onclick=cal.DataIncrement("dropset_{{$days_data}}","1")>--}}
        {{--<i class="fas fas fa-plus"></i></a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="javaScript:void(0);" class="reorder-up">--}}
        {{--<i class="fas fas fa-minus" onclick=cal.DataDecrement("pyramidset_{{$days_data}}","1")></i></a>--}}
        {{--<input type="hidden" name="pyramid_set" class="pyramidset_{{$days_data}}" value="{{ !empty($data->pyramid_set) ? $data->pyramid_set : '0' }}" readonly="readonly">--}}
        {{--<span id="pyramidset_{{$days_data}}">{{ !empty($data->pyramid_set) ? $data->pyramid_set : 0 }}</span>--}}
        {{--<a href="javaScript:void(0);" class="reorder-down" onclick=cal.DataIncrement("pyramidset_{{$days_data}}","1")>--}}
        {{--<i class="fas fas fa-plus"></i></a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="javaScript:void(0);" class="reorder-up">--}}
        {{--<i class="fas fas fa-minus" onclick=cal.DataDecrement("circut_{{$days_data}}","1")></i></a>--}}
        {{--<input type="hidden" name="circuit_set" class="circut_{{$days_data}}" value="{{ !empty($data->circuit_set) ? $data->circuit_set : '0' }}" readonly="readonly">--}}
        {{--<span id="circut_{{$days_data}}">{{ !empty($data->circuit_set) ? $data->circuit_set : 0 }}</span>--}}
        {{--<a href="javaScript:void(0);" class="reorder-down" onclick=cal.DataIncrement("circut_{{$days_data}}","1")>--}}
        {{--<i class="fas fas fa-plus"></i></a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</div>--}}
        {{--<div class="col-sm-6 text-center">--}}
        {{--<h5 class="font-weight-bold mb-3">How many exercise in a Set?</h5>--}}
        {{--<ul class="set-list list-unstyled">--}}
        {{--<li>--}}
        {{--<input type="hidden" name="horizontal_exercise_set" class="horizontal_set_reps_{{$days_data}}" value="{{ !empty($data->horizontal_exercise_set) ? $data->horizontal_exercise_set : 1 }}" readonly="readonly">--}}
        {{--<span id="horizontal_set_reps_{{$days_data}}">{{ (!empty($data->horizontal_exercise_set)) ? $data->horizontal_exercise_set : 1 }}</span>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="javaScript:void(0);" class="reorder-up">--}}
        {{--<i class="fas fas fa-minus" onclick=cal.DataDecrement("vertical_set_reps_{{$days_data}}","1")></i>--}}
        {{--</a><input type="hidden" name="verticle_exercise_set" class="vertical_set_reps_{{$days_data}}" value="{{ !empty($data->verticle_exercise_set) ? $data->verticle_exercise_set : 2 }}" readonly="readonly">--}}
        {{--<span id="vertical_set_reps_{{$days_data}}">{{ !empty($data->verticle_exercise_set) ? $data->verticle_exercise_set : 2 }}</span>--}}
        {{--<a href="javaScript:void(0);" class="reorder-down" onclick=cal.DataIncrement("vertical_set_reps_{{$days_data}}","1")><i class="fas fas fa-plus"></i>--}}
        {{--</a>--}}
        {{--<li>--}}
        {{--<input type="hidden" name="super_exercise_set" class="super_set_reps_{{$days_data}}" value="{{ !empty($data->super_exercise_set) ? $data->super_exercise_set : 2 }}" readonly="readonly">--}}
        {{--<span id="super_set_reps_{{$days_data}}">{{ !empty($data->super_exercise_set) ? $data->super_exercise_set : 2 }}</span>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<input type="hidden" name="tri_exercise_set" class="triset_reps_{{$days_data}}" value="{{ !empty($data->tri_exercise_set) ? $data->tri_exercise_set : 3 }}" readonly="readonly">--}}
        {{--<span id="triset_reps_{{$days_data}}">{{ !empty($data->tri_exercise_set) ? $data->tri_exercise_set : 3 }}</span>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<input type="hidden" name="drop_exercise_set" class="dropset_reps_{{$days_data}}" value="{{ !empty($data->drop_exercise_set) ? $data->drop_exercise_set : 1 }}" readonly="readonly">--}}
        {{--<span id="dropset_reps_{{$days_data}}">{{ !empty($data->drop_exercise_set) ? $data->drop_exercise_set : 1 }}</span>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<input type="hidden" name="pyramid_exercise_set" class="pyramidset_reps" value="{{ !empty($data->pyramid_exercise_set) ? $data->pyramid_exercise_set : 1 }}" readonly="readonly">--}}
        {{--<span id="pyramidset_reps">{{ !empty($data->pyramid_exercise_set) ? $data->pyramid_exercise_set : 1 }}</span>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="javaScript:void(0);" class="reorder-up">--}}
        {{--<i class="fas fas fa-minus" onclick=cal.DataDecrement("circut_set_reps","1")></i>--}}
        {{--</a><input type="hidden" name="circuit_exercise_set" class="circut_set_reps" value="{{ !empty($data->circuit_exercise_set) ? $data->circuit_exercise_set : 4 }}" readonly="readonly">--}}
        {{--<span id="circut_set_reps">{{ !empty($data->circuit_exercise_set) ? $data->circuit_exercise_set : 4 }}</span>--}}
        {{--<a href="javaScript:void(0);" class="reorder-down" onclick=cal.DataIncrement("circut_set_reps","1")><i class="fas fas fa-plus"></i>--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</div>--}}

        {{--</div>--}}
        {{--</div>--}}
    </div>

</div>
<div class="form-apply-row">
    <div class="row justify-content-center">
        <div class="col-4">
            <button type="button" id="save-weekly-setup" class="btn primary-btn btn-block my-3">Apply</button>
        </div>
        <div class="col-4">
            <button type="button" id="save-close-weekly-setup" class="btn outline-btn btn-block my-3">Apply & Close</button>
        </div>
    </div>
</div>
{!!Form::close()!!}
