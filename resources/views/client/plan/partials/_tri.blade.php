{{--type_extraId_maincounter_subCounter--}}
<li id="sortable-plan_{{$row->id}}_{{$extraId}}">
<div class="inner-table-head bg-white p-3 rounded">
        <span>Triset</span>
    <a href="javascript: void(0)" class="set-remove-link delete_training_plan_workout" id="delete_{{$planWeekTrainingSetupId}}_{{$workoutTypeSetId}}_{{$pWorkoutMainMounter}}">Remove</a>
        </div>
    <div class="table-block drag-tr table-block-group">
        <div class="table-block-list">
            @for($j=1;$j <= $row->exercise_set; $j++)
                @php
                $isRestTri = false;
                if($j == 3)
                $isRestTri = true;
                @endphp
                @include('client.plan.partials._common_main_workout',
                ['i' => $row->workout_main_counter, 'type' => 'T', 'isRest' => $isRestTri, 'workoutTypeSetId' => 4, 'record' => [], 'uniqueId' => 'tri_'.$extraId.'_'.$row->workout_main_counter.'_'.$j, 'subCounter' => $j])
                @endfor
        </div>
    </div>
</li>
