<style>
    .show-text-one-line {
        white-space: nowrap !important;
    }
</style>
<div class="page-content" style="margin: 0 auto !important;">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="pagetitle">Save as</h1>
                </div>
            </div>

        </div>
    </div>

    <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 border-right">
                {!! Form::model($data['plan'], ['id' => 'add-form-data', 'class' => 'form-horizontal','files'=> true]) !!}
                <div class="form-group row">
                    {{ Form::label('title', 'Title', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">
                        {{ Form::text('title', old('title'), ['class' => 'form-control title-fileds', 'maxlength' => '50', 'id' => 'title', 'required' => 'true', 'placeholder' => '']) }}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('day_plan_id', 'Category', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">Training</div>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-sm-3 col-form-label">For</label>
                    <div class="col-sm-9">
                        <p>One Day</p>
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('access', 'Access', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">
                        @if(1 === 0)
                            {!! Form::select('access_type', ['private' => 'Private', 'public' => 'Public'], null , ['class' => 'custom-select plan-creator-drop', 'required' => true, 'id' => 'access']) !!}
                        @else
                            Private
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('description', 'Description', ['class' => 'col-sm-3 col-form-label show-text-one-line '])}}
                    <div class="col-sm-9">
                        {!! Form::textarea('description', old('description'), ['class' => 'form-control description-fileds', 'maxlength' => '300', 'rows' => 4, 'cols' => 40, 'id' => 'description']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    {{ Form::label('goal_id', 'Goal', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">
                        {!! Form::select('goal_id', $data['goals'], null , ['class' => 'custom-select plan-creator-goal required-fileds', 'required' => true, 'id' => 'goal_id']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('training_day_id', 'Training days/week', ['class' => 'col-sm-3 col-form-label'])}}
                    <div class="col-sm-9">
                        @if(1 === 0)
                            {!! Form::select('training_day_id', $data['training_days'], null , ['class' => 'custom-select plan-creator-drop', 'required' => true, 'id' => 'training_day_id']) !!}
                        @else
                            1
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    {{ Form::label('equipment_id', 'Equipments', ['class' => 'col-sm-3 col-form-label show-text-one-line'])}}
                    <div class="col-sm-9">
                        {!! Form::select('equipment_id[]', $data['equipments'], null , ['class' => 'custom-select plan-creator-drop js-example-basic-multiple one-day-save', 'multiple' => true,'disabled' => true, 'id' => 'equipment_id', 'data-select2-id' => 'one-day-save-data-id']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-right plan-frm-btn">
                <button class="btn outline-btn mr-2" type="submit" id="save-one-day-plan">Save</button>
                <a href="javascript: void(0)" class="link-danger cancel-plan-draft">Cancel</a>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
</div>
