@php
    if (!empty($isClientPlan))
       $isClientPlan = true;
    else
       $isClientPlan = false;
   $recordMainWorkoutData = getMainworkoutData($extraId, $planId, $workoutTypeSetId, $i, $subCounter, $isClientPlan, $isEdit);
   $uniqueId = $uniqueId.'_'.$positionId;
@endphp

<div class="inner-table-wrapper bg-white p-3 rounded">

    <div class="dragg-icon moved_workout_position" id="moved_{{$uniqueId}}">
        @if($subCounter == 1)
        <!-- <span class="text-primary align-middle"><i class="far fa-hand-rock"></i></span> -->
        @endif
    </div>

    <div class="inner-inner">
        <div class="inner-table">
            <div class="inner-table-col text-primary drag-tr droppable" data-drag-drop-id="{{@$recordMainWorkoutData->id}}" id="{{$uniqueId}}">
                <div class="d-flex justify-content-between">
                    <div>
                    {{$subCounter}}.
                    Drag and drop ({{$type}}) <br/>
                    <span id="exercise_{{$uniqueId}}" class="text-dark">{!! @$recordMainWorkoutData->name !!}</span>
                 </div>
                    <div class="exer-add-img-wrapper" id="exercise_image_{{$uniqueId}}">
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
                    if(!empty(@$recordMainWorkoutData->set_id)){
                    $defaultValue = $recordMainWorkoutData->set_id;
                    }
                @endphp
                {!! Form::select('sets', $sets, $defaultValue, ['class' => 'custom-select drag-drop-workout-filters '.$uniqueId.' customize-dropdowns set_customization', 'id' => 'set_id', 'data-structureId' => $uniqueId]) !!}
            </div>
            <div class="inner-table-col">
                @php
                    $defaultValue = 1;
                    if(!empty(@$recordMainWorkoutData->rep_id)){
                    $defaultValue = $recordMainWorkoutData->rep_id;
                    }
                @endphp
                {!! Form::select('reps', $reps, $defaultValue , ['class' => 'custom-select drag-drop-workout-filters '.$uniqueId.' customize-dropdowns rep_customization', 'id' => 'rep_id', 'data-structureId' => $uniqueId]) !!}
            </div>
            <div class="inner-table-col">
                @php
                    $defaultValue = 1;
                    if(!empty(@$recordMainWorkoutData->rm_id)){
                    $defaultValue = $recordMainWorkoutData->rm_id;
                    }
                @endphp
                {!! Form::select('rms', $rms, $defaultValue, ['class' => 'custom-select drag-drop-workout-filters '.$uniqueId.' customize-dropdowns rm_customization', 'id' => 'rm_id', 'data-structureId' => $uniqueId]) !!}
            </div>
            <div class="inner-table-col">
                @php
                    $defaultValue = 1;
                    if(!empty(@$recordMainWorkoutData->tempo_id)){
                    $defaultValue = $recordMainWorkoutData->tempo_id;
                    }
                @endphp
                {!! Form::select('tempos', $tempos, $defaultValue , ['class' => 'custom-select drag-drop-workout-filters '.$uniqueId.' customize-dropdowns tempos_customization', 'id' => 'tempo_id', 'data-structureId' => $uniqueId]) !!}
            </div>
            @if(!empty($isRest))
            <div class="inner-table-col">
                @php
                    $defaultValue = 1;
                    if(!empty(@$recordMainWorkoutData->rest_id)){
                    $defaultValue = $recordMainWorkoutData->rest_id;
                    }
                @endphp
                {!! Form::select('rests', $rests, $defaultValue , ['class' => 'custom-select drag-drop-workout-filters '.$uniqueId.' customize-dropdowns rest_customization', 'id' => 'rest_id', 'data-structureId' => $uniqueId]) !!}
            </div>
            @endif
            @if($subCounter == 1)
            <!-- <div class="tr-remove ml-auto">
                <a href="javascript: void(0)" class="delete_training_plan_workout" id="delete_{{$planWeekTrainingSetupId}}_{{$workoutTypeSetId}}_{{$pWorkoutMainMounter}}">
                    <i class="fas fa-times-circle fa-lg"></i>
                </a>
            </div> -->
            @endif
        </div>
    </div>
</div>
