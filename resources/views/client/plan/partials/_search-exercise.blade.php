<div class="add-exer-col">
    <div class="add-exer-col-inner">
        <div class="add-exer-col-inner-wrapper">
            <button class="btn exer-close-btn"><i class="fas fa-times"></i></button>
            <div class="exer-search mb-3">
                <input class="form-control" type="text" name="search_exercise" id="search_exercise" placeholder="Search an Exercise">
            </div>

            <div class="exer-filter ">
                <div class="row border-bottom pb-3 mb-2">
                    <div class="col-md-3 text-center">
                        <label class="font-weight-bold" for=""><small>Body Part</small></label>
                        {!! Form::select('body_part_id', $data['exercise_body_parts'], null , ['class' => 'custom-select drop_down_filters_excercise', 'required' => true, 'id' => 'body_part_id']) !!}
                    </div>
                    <div class="col-md-3 text-center">
                        <label class="font-weight-bold" for=""><small>Target Muscle</small></label>
                        {!! Form::select('target_muscle_id', $data['exercise_target_muscles'], null , ['class' => 'custom-select drop_down_filters_excercise', 'required' => true, 'id' => 'target_muscle_id']) !!}
                    </div>
                    <div class="col-md-3 text-center">
                        <label class="font-weight-bold" for=""><small>Equipment</small></label>
                        {!! Form::select('equipment_id', $data['exercise_equipments'], null , ['class' => 'custom-select drop_down_filters_excercise', 'required' => true, 'id' => 'equipment_id']) !!}
                    </div>
                    <div class="col-md-3 text-center">
                        <label class="font-weight-bold" for=""><small>Training form</small></label>
                        {!! Form::select('training_form_id', $data['exercise_training_forms'], null , ['class' => 'custom-select drop_down_filters_excercise', 'required' => true, 'id' => 'training_form_id']) !!}
                    </div>
                    <div class="col-12">
                        <a id="clear-exercise-filters" href="javascript: void(0)" class="btn secondary-btn sm-btn mt-3">Clear filters</a>
                    </div>
                </div>
            </div>
            <div id="search-exercies-dynamic"></div>
            <div class="exercises paq-pager"></div>
        </div>
    </div>
</div>
