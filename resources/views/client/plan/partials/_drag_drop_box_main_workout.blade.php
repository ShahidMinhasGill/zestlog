@if(!empty($training_setup_position))
    @foreach($training_setup_position as $row)
        @php
            $positionId = $row->id;
            if(empty($isClientPlan))
                $planWeekTrainingSetupId = $row->plan_week_training_setup_id;
            else
                $planWeekTrainingSetupId = $row->client_plan_week_training_setup_id;
            $workoutTypeSetId = $row->workout_type_set_id;
            $pWorkoutMainMounter = $row->workout_main_counter;
        @endphp
        @switch($row->key_value)
            @case('horizontal')
                @include('client.plan.partials._horizontal')
            @break

            @case('vertical')
            @include('client.plan.partials._vertical')
            @break

            @case('super')
            @include('client.plan.partials._super')
            @break

            @case('tri')
            @include('client.plan.partials._tri')
            @break

            @case('drop')
            @include('client.plan.partials._drop')
            @break

            @case('pyramid')
            @include('client.plan.partials._pyramid')
            @break

            @default
            @include('client.plan.partials._circuit')
        @endswitch
    @endforeach
@endif
