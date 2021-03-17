<div class="row">
    @if(!isLightVersion())
    <div class="col-sm-6">
        <h3 class="section-title">Day Plans</h3>
    </div>

        <div class="col-sm-6 text-left text-sm-right">
            <a class="btn primary-btn" href="{{route('one.day.plan')}}">Create a new plan</a>
        </div>
    @endif
</div>

<div class="table-responsive">
    <table class="table">
    </table>
    <div class="no-record-found"></div>
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
                    <br>{!! Form::select('equipment_id', $equipments, null , ['class' => 'custom-select drop_down_filters width80', 'id' => 'equipment_id']) !!}
                </th>

                <th scope="col" class="text-center">Description</th>
            </tr>
        </thead>
        <tbody id="page-data-import">
        <div class="no-record-found"></div>
        </tbody>
    </table>
    </table>
    <div class="import-plan-class paq-pager"></div>
    
</div>
