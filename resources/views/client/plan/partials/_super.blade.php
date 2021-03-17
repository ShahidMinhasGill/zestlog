{{--type_extraId_maincounter_subCounter--}}
<li id="sortable-plan_{{$row->id}}_{{$extraId}}">
<div class="inner-table-head bg-white p-3 rounded">
        <span>Superset</span>
    <a href="javascript: void(0)" class="set-remove-link delete_training_plan_workout" id="delete_{{$planWeekTrainingSetupId}}_{{$workoutTypeSetId}}_{{$pWorkoutMainMounter}}">Remove</a>
        </div>
<div class="table-block drag-tr table-block-group">
    <div class="table-block-list">
    
        @for($j=1;$j <= $row->exercise_set; $j++)
            @php
                $isRestSuper = false;
                if($j == 2)
                $isRestSuper = true;
            @endphp
            @include('client.plan.partials._common_main_workout',
             ['i' => $row->workout_main_counter, 'type' => 's', 'isRest' => $isRestSuper, 'workoutTypeSetId' => 3, 'record' => [], 'uniqueId' => 'super_'.$extraId.'_'.$row->workout_main_counter.'_'.$j, 'subCounter' => $j])
        @endfor
    </div>
</div>
</li>

