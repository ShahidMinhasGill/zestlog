<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 border-right">
                {!! Form::model($data['plan'], ['id' => 'add-form', 'class' => 'form-horizontal','files'=> true]) !!}
                <div class="form-group row">
                    {{ Form::label('title', 'Title', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">
                        {{ Form::text('title', old('title'), ['class' => 'form-control',  'maxlength' => '50', 'id' => 'title', 'required' => 'true', 'placeholder' => '']) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('day_plan_id', 'Category', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">Training</div>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-sm-3 col-form-label">For</label>
                    <div class="col-sm-9">
                        <p>One week</p>
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('access', 'Access', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">
                        {!! Form::select('access_type', ['private' => 'Private', 'public' => 'Public'], null , ['class' => 'custom-select plan-creator-drop', 'required' => true, 'id' => 'access']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('description', 'Description', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">
                        {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'maxlength' => '300', 'rows' => 4, 'cols' => 40, 'id' => 'description']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    {{ Form::label('goal_id', 'Goal', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">
                        {!! Form::select('goal_id', $data['goals'], null , ['class' => 'custom-select plan-creator-drop', 'required' => true, 'id' => 'goal_id']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('training_day_id', 'Training days/week', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">
                        {!! Form::select('training_day_id', $data['training_days'], null , ['class' => 'custom-select training-active-days', 'id' => 'training_day_id', 'multiple' => true,'disabled' => true, 'data-select2-id' => 'main-section-trainig-day']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('equipment_id', 'Equipments', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">
                        {!! Form::select('equipment_id[]', $data['equipments'], null , ['class' => 'custom-select  js-example-basic-multiple', 'multiple' => true, 'disabled' => true, 'id' => 'equipment_id', 'data-select2-id' => 'main-section-week']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('training_ages', 'Training Age', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">
                        {!! Form::select('training_age_id', $data['training_ages'], null , ['class' => 'custom-select plan-creator-drop', 'required' => true, 'id' => 'training_ages']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('age_category_id', 'Age Category', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">
                        {!! Form::select('age_category_id', $data['age_categories'], null , ['class' => 'custom-select plan-creator-drop', 'required' => true, 'id' => 'age_category_id']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('gender', 'Gender', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">
                        {!! Form::select('gender', $data['gender'], null , ['class' => 'custom-select plan-creator-drop', 'required' => true, 'id' => 'gender']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-right plan-frm-btn">
                <button class="btn outline-btn mr-2" type="submit">Save</button>
                <a href="javascript: void(0)" class="link-danger delete-plan-draft">Cancel</a>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
