@if(!isLightVersion())

    <div class="row">
    <div class="col-sm-6">
        <h3 class="section-title">Week Programs</h3>
    </div>
    <div class="col-sm-6 text-left text-sm-right">
        <a class="btn primary-btn" href="{{route('plans.create')}}">Create a new program</a>
    </div>
</div>
    @endif
<div class="table-responsive">
    <table class="table">
        <table class="week-plan-table table">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="text-center">Nr</th>
                    <th scope="col" class="text-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck11">
                            <label class="custom-control-label" for="customCheck11"></label>
                        </div>
                    </th>
                    <th scope="col" class="text-center">Action</th>
                    <th scope="col" class="text-center">Title
                        </br> <input type="text" class="form-control" id="search" name="search" placeholder="Search" style="width: 180px"> </th>
                    <th scope="col" class="text-center">Category</th>
                    <th scope="col" class="text-center">Duration</th>
                    <th scope="col" class="text-center">Created by
                        <br>
                    </th>
                    <th scope="col" class="text-center">Access
                        <br> {!! Form::select('access_type', $access_type, null , ['class' => 'custom-select drop_down_filters width80', 'id' => 'access_type']) !!}
                    </th>
                    <th scope="col" class="text-center">Goal
                        <br>{!! Form::select('goal_id', $goals, null , ['class' => 'custom-select drop_down_filters width80', 'id' => 'goal_id']) !!}
                    </th>
                    <th scope="col" class="text-center">Training days/week
                        <br>{!! Form::select('training_day_id', $training_days, null , ['class' => 'custom-select drop_down_filters width80', 'id' => 'training_day_id']) !!}
                    </th>
                    <th scope="col" class="text-center">Equipment
                        <br>{!! Form::select('equipment_id', $equipments, null , ['class' => 'custom-select drop_down_filters width80','id' => 'equipment_id']) !!}
                    </th>
                    <th scope="col" class="text-center">Training Age
                        <br>{!! Form::select('training_age_id', $training_ages, null , ['class' => 'custom-select drop_down_filters width163', 'id' => 'training_age_id']) !!}
                    </th>
                    <th scope="col" class="text-center">Age Category
                        <br>{!! Form::select('age_category_id', $age_categories, null , ['class' => 'custom-select drop_down_filters width163', 'id' => 'age_category_id']) !!}
                    </th>
                    <th scope="col" class="text-center">Gender
                        <br> {!! Form::select('gender', $gender, null , ['class' => 'custom-select drop_down_filters width83', 'id' => 'gender']) !!}
                    </th>
                    <th scope="col" class="text-center">Description</th>
                </tr>
            </thead>
            <tbody id="page-data">
                <div class="no-record-found"></div>
            </tbody>
        </table>
    </table>
    <div class="paq-pager"></div>
</div>
