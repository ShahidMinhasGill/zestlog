<div class="modal fade" id="week-import-client" tabindex="-1" role="dialog" aria-labelledby="week-importLabel" aria-hidden="true">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 p-1">
                <button type="button" class="close close-import-popup" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="section-title text-left mb-3">Select a program to import</h3>
                   <div class="table-responsive">
                        <table class="tableFixHead table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center">Nriiii</th>
                                    <th scope="col" class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck11">
                                            <label class="custom-control-label" for="customCheck11"></label>
                                        </div>
                                    </th>
                                    <th scope="col" class="text-center">Title
                                        </br> <input type="text" class="form-control" id="search" name="search" placeholder="Search" style="width: 180px"> </th>
                                    <th scope="col" class="text-center">Category</th>
                                    <th scope="col" class="text-center">Duration</th>
                                    <th scope="col" class="text-center">Created by
                                        <br>
                                    </th>
                                    <th scope="col" class="text-center">Access
                                        <br> {!! Form::select('access_type', $data['access_type'], null , ['class' => 'custom-select drop_down_filters_import width80', 'id' => 'access_type'])  !!}
                                    </th>
                                    <th scope="col" class="text-center" width="100px">Goal
                                        <br>{!! Form::select('goal_id', $data['goals'], null , ['class' => 'custom-select drop_down_filters_import width80', 'id' => 'goal_id'])  !!}
                                    </th>
                                    <th scope="col" class="text-center">Training days/week
                                        <br>{!! Form::select('training_day_id', $data['training_days'], null , ['class' => 'custom-select drop_down_filters_import width80', 'id' => 'training_day_id'])  !!}
                                    </th>
                                    <th scope="col" class="text-center">Equipment
                                        <br>{!! Form::select('equipment_id', $data['exercise_equipments'], null , ['class' => 'custom-select drop_down_filters_import width80', 'id' => 'equipment_id'])  !!}
                                        </select>
                                    </th>
                                    <th scope="col" class="text-center">Training Age
                                        <br>{!! Form::select('training_age_id', $data['training_ages'], null , ['class' => 'custom-select drop_down_filters_import width163', 'id' => 'training_age_id'])  !!}
                                    </th>
                                    <th scope="col" class="text-center">Age Category
                                        <br>{!! Form::select('age_category_id', $data['age_categories'], null , ['class' => 'custom-select drop_down_filters_import width163', 'id' => 'age_category_id'])  !!}
                                    </th>
                                    <th scope="col" class="text-center">Gender
                                        <br> {!! Form::select('gender', $data['gender'], null , ['class' => 'custom-select drop_down_filters_import width83', 'id' => 'gender'])  !!}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="page-data-import">
                            <div class="no-record-found"></div>
                            </tbody>
                        </table>
                    </div>
                <div class="paq-pager"></div>
                <div class="text-right">
                        <button class="btn success-btn" id="import-database">Import</button>
                    </div>
            </div>
        </div>
    </div>
</div>
