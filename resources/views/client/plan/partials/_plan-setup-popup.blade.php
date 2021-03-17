<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header p-1 border-0">
            <button type="button" id="close_{{$row['day_id']}}_{{$structure['id']}}" class="close close-training-setup" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-center text-dark">
            <h3 class="section-title mb-4">Add set(s) to main workout</h3>

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <ul class="add-set-list list-unstyled">
                        <li class="clearfix add-li">
                            <div class="float-left">
                                <strong>Select a set</strong>
                            </div>
                            <div class="float-right">
                                {!! Form::select('workout_set_type', $row['workoutSetupTypes'], null , ['class' => 'custom-select weekly-workout-filters', 'id' => 'weekly-workout-setup_'.$row['day_id'].'_'.$structure['id']]) !!}
                            </div>
                        </li>
                        <li class="clearfix add-li">
                            <div class="float-left">
                                <strong>How many?</strong>
                            </div>
                            <div class="float-right">
                                <ul class="set-list list-unstyled">
                                    <li>
                                        <a href="javaScript:void(0);" class="reorder-up fa-minus-set"
                                           id="set-minus_{{$row['day_id']}}_{{$structure['id']}}">
                                            <i class="fas fas fa-minus"></i></a>
                                        <span id="workout-set-value_{{$row['day_id']}}_{{$structure['id']}}">1</span>
                                        <a href="javaScript:void(0);" class="reorder-down fa-plus-set"
                                           id="set-plus_{{$row['day_id']}}_{{$structure['id']}}">
                                            <i class="fas fas fa-plus"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="clearfix add-li">
                            <div class="float-left">
                                <strong>How many exercise?</strong>
                            </div>
                            <div class="float-right">
                                <ul class="set-list list-unstyled">
                                    <li>
                                        <a href="javaScript:void(0);" class="reorder-up fa-minus-set"
                                           id="exercise-minus_{{$row['day_id']}}_{{$structure['id']}}">
                                            <i class="fas fas fa-minus"></i></a>
                                        <span id="workout-exercise-value_{{$row['day_id']}}_{{$structure['id']}}">1</span>
                                        <a href="javaScript:void(0);" class="reorder-down fa-plus-set"
                                           id="exercise-plus_{{$row['day_id']}}_{{$structure['id']}}">
                                            <i class="fas fas fa-plus"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-12">
                <a href="javascript:void(0)" id="plan_{{$row['day_id']}}_{{$structure['id']}}" class="save-workout-sets btn success-btn mb-3 mr-2 disable-click">Apply</a>
            </div>
        </div>
    </div>
</div>
<style>
    .disable-click {
        pointer-events:none !important;
        background-color: lightgrey !important;
    }
</style>