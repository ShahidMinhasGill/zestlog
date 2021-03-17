<style>
    .custom-select drag-drop-workout-filters {
        width: 100px !important;
    }
</style>
@if(count($objTempTraining) > 0)
@php
if (!empty($isClientPlan))
$isClientPlan = true;
else
$isClientPlan = false;
@endphp
@foreach($objTempTraining as $key => $row)
@php
$currentCounter = $row->workout_main_counter;
if(empty($isNew))
$recordMainWorkoutData = getMainworkoutData($extraId, $planId, 0, $currentCounter, 0, $isClientPlan, $isEdit);

@endphp
<li id="sortable-wcc_{{$row->id}}_{{$extraId}}">
    <div class="inner-table-head justify-content-end bg-white p-3 rounded">
        <a href="javascript: void(0)" class="set-remove-link delete_training_plan" id="delete_{{$extraId}}_{{$currentCounter}}">Remove</a>
    </div>
    <div class="table-block drag-tr table-block-group">
        <div class="table-block-list">
            <div class="inner-table-wrapper bg-white p-3 rounded">

                <div class="inner-inner">
                    <div class="inner-table">
                        <div class="inner-table-col text-primary drag-tr droppable" data-drag-drop-id="{{@$recordMainWorkoutData->id}}" id="droppable_{{$extraId}}_{{$currentCounter}}_0_{{$row->id}}">
                            <div class="d-flex justify-content-between">
                                <div>
                                    {{$currentCounter}}.
                                    Drag and drop <br />
                                    <span id="exercise_droppable_{{$extraId}}_{{$currentCounter}}_0_{{$row->id}}" class="text-dark">{!! @$recordMainWorkoutData->name !!}</span>
                                </div>

                                <div class="exer-add-img-wrapper" id="exercise_image_droppable_{{$extraId}}_{{$currentCounter}}_0_{{$row->id}}">
                                    @if(!empty($recordMainWorkoutData->male_illustration))
                                        <img src="{!! asset(exerciseImagePathMale.'/'.@$recordMainWorkoutData->male_illustration) !!}" alt="">
                                    @else
                                       <img src="">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="inner-table-col">
                            @php
                                $defaultValue = 1;
                                if(!empty(@$recordMainWorkoutData->form_id)){
                                $defaultValue = $recordMainWorkoutData->form_id;
                                }
                            @endphp
                            {!! Form::select('forms', $forms,$defaultValue, ['class' => 'custom-select drag-drop-workout-filters droppable_'.$extraId.'_'.$currentCounter.'_0_'.$row->id.' customize-dropdowns form_customization', 'id' => 'form_id', 'data-structureId' => 'droppable_'.$extraId.'_'.$currentCounter.'_0_'.$row->id]) !!}
                        </div>
                        <div class="inner-table-col">
                            @php
                                $defaultValue = 1;
                                if(!empty(@$recordMainWorkoutData->stage_id)){
                                $defaultValue = $recordMainWorkoutData->stage_id;
                                }
                            @endphp
                            {!! Form::select('stages', $stages,$defaultValue , ['class' => 'custom-select drag-drop-workout-filters droppable_'.$extraId.'_'.$currentCounter.'_0_'.$row->id.' customize-dropdowns stage_customization', 'id' => 'stage_id', 'data-structureId' => 'droppable_'.$extraId.'_'.$currentCounter.'_0_'.$row->id]) !!}
                        </div>
                        <div class="inner-table-col">
                            @php
                                $defaultValue = 1;
                                if(!empty(@$recordMainWorkoutData->wr_id)){
                                $defaultValue = $recordMainWorkoutData->wr_id;
                                }
                            @endphp
                            {!! Form::select('wrs', $wrs, $defaultValue , ['class' => 'custom-select drag-drop-workout-filters droppable_'.$extraId.'_'.$currentCounter.'_0_'.$row->id.' customize-dropdowns wr_customization', 'id' => 'wr_id', 'data-structureId' => 'droppable_'.$extraId.'_'.$currentCounter.'_0_'.$row->id]) !!}
                        </div>
                        <div class="inner-table-col">
                            @php
                                $defaultValue = 1;
                                if(!empty(@$recordMainWorkoutData->rep_id)){
                                $defaultValue = $recordMainWorkoutData->rep_id;
                                }
                            @endphp
                            {!! Form::select('reps', $reps, $defaultValue , ['class' => 'custom-select drag-drop-workout-filters droppable_'.$extraId.'_'.$currentCounter.'_0_'.$row->id.' customize-dropdowns rep_customization', 'id' => 'rep_id', 'data-structureId' => 'droppable_'.$extraId.'_'.$currentCounter.'_0_'.$row->id]) !!}
                        </div>
                        <div class="inner-table-col">
                            @php
                                $defaultValue = 1;
                                if(!empty(@$recordMainWorkoutData->duration_id)){
                                $defaultValue = $recordMainWorkoutData->duration_id;
                                }
                            @endphp
                            {!! Form::select('durations', $durations, $defaultValue , ['class' => 'custom-select drag-drop-workout-filters droppable_'.$extraId.'_'.$currentCounter.'_0_'.$row->id.' customize-dropdowns duration_customization', 'id' => 'duration_id', 'data-structureId' => 'droppable_'.$extraId.'_'.$currentCounter.'_0_'.$row->id]) !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</li>
@endforeach
@endif
