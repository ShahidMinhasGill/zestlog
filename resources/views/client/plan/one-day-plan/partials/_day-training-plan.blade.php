<div class="one-day-plan accordion" id="accordionExample">
        {{--<div class="card-header" id="headingOne">--}}
            {{--<h2 class="mb-0">--}}
                {{--<button class="btn  btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOneDay" aria-expanded="true" aria-controls="collapseOneDay">--}}
                    {{--<b>One day</b>--}}
                    {{--<br>--}}
                {{--</button>--}}

            {{--</h2>--}}
        {{--</div>--}}

        @foreach($data as $row)
            <div class="week-plan accordion" id="accordionExample_{{$row['day_id']}}">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <div class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$row['day_id']}}" aria-expanded="true" aria-controls="collapseOne">
                                <div class="row">
                                    <div class="col-4">
                                        <span class="d-block mb-2"><strong>{{$row['day_name']}}</strong></span>
                                        @if($row['day_plan_id'] == 1)
                                            <button
                                                class="btn grey-outline-btn sm-btn w-25 mr-2 py-1 font-weight-bold plan-import-one-day-class"
                                                data-toggle="modal" data-target="#week-day-import"
                                                id="Import-{{$row['day_id']}}">Import
                                            </button>
                                            @if(!empty(isHide()))
                                                <button class="btn grey-outline-btn sm-btn w-25 py-1 font-weight-bold"
                                                        data-toggle="modal" data-target="#plan-save">Save
                                                </button>
                                            @endif
                                        @else
                                            <h6 class="w-25 font-weight-bold">&nbsp</h6>
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        <span class="text-muted">{{$row['day_plan']}}</span>
                                    </div>
                                    <div class="col-4">
                                        <span class="text-muted">{{$row['body_parts']}}</span>
                                    </div>
                                </div>
                            </div>
                        </h2>
                    </div>

                    <div id="collapse{{$row['day_id']}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample_{{$row['day_id']}}">
                        <div class="card-body px-2 pt-3 pb-0">
                            @if(!empty($row['is_rest']))
                                <div>{!! nl2br($row['meta_description']) !!}</div>
                            @else
                            <!-- comment box modal -->
                                <div class="mb-3">
                                    <a href="javascript(:void);" type="button" class=" primary-link" data-toggle="modal" data-target="#comment-box-modal_{{$row['day_id']}}">
                                        <strong class="text-primary pr-2 mr-2 border-right">Comment</strong>
                                        <span class="text-muted">click to Type </span>
                                    </a>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="comment-box-modal_{{$row['day_id']}}" tabindex="-1" role="dialog" aria-labelledby="comment-box-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header modal-header border-0 pb-0">
                                                <button type="button" id="comment-modal-box_{{$row['day_id']}}" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h3 class="section-title mb-4">Comment
                                                </h3>

                                                <div class="form-group">
                                                    <label for="my-textarea"><strong>Comment
                                                        </strong></label>
                                                    <textarea id="text_{{$row['day_id']}}" class="form-control" name="" rows="3"></textarea>
                                                </div>
                                                <div class="text-center">
                                                    <a class="btn primary-btn add-training-plan-comment" href="javascript: void(0)" id="comment_{{$row['day_id']}}">Save</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End comment box modal -->
                            @endif
                            <div class="table-responsive">
                                @foreach($row['plan_structures'] as $structure)
                                    @if(($structure['id'] == 1 && $row['warm_up']) || ($structure['id'] == 2 && $row['main_workout'])
                                    || ($structure['id'] == 3 && $row['cardio']) || ($structure['id'] == 4 && $row['cool_down']))
                                        <div class="ex-row">
                                            <div class="ex-row items structure-items-div" id="div_{{$row['day_id']}}_{{$structure['id']}}" data-toggle="collapse" href="#ex-row-colapse_{{$row['day_id']}}_{{$structure['id']}}" role="button" aria-expanded="false" aria-controls="ex-row-colapse_{{$row['day_id']}}_{{$structure['id']}}">
                                                <div class="ex-col">{{$structure['name']}}</div>
                                                @foreach($structure['columns'] as $value)
                                                    <div class="ex-col">{{$value}}</div>
                                                @endforeach
                                                <div class="ex-col text-right">
                                                    <a id="{{$row['day_id']}}_{{$structure['id']}}" class="structure-items ex-row-colapse_{{$row['day_id']}}_{{$structure['id']}}">
                                                        <i class="fas fa-caret-down fa-2x text-dark"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="collapse" id="ex-row-colapse_{{$row['day_id']}}_{{$structure['id']}}">
                                                @if($structure['id'] !=2)
                                                    <a href="javascript: void(0)" class="add-new-row" id="plus_{{$row['day_id']}}_{{$structure['id']}}">
                                                        <!-- <i class="fas fa-plus-circle d-flex align-items-center tr-add text-primary p-2"></i> -->

                                                        <button class="btn outline-btn my-2">Add a new row</button>
                                                    </a>
                                                @else
                                                    <a href="javascript: void(0)" class="add-new-workout" id="plus-workout_{{$row['day_id']}}_{{$structure['id']}}">
                                                        <button class="btn outline-btn my-2 tr-add " data-toggle="modal" data-target="#add-sets-modal_{{$row['day_id']}}_{{$structure['id']}}" style="font-size: 1rem">Add a new set</button>
                                                    </a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="add-sets-modal_{{$row['day_id']}}_{{$structure['id']}}" tabindex="-1" role="dialog" aria-labelledby="add-sets-modalLabel" aria-hidden="true">
                                                        @include('client.plan.partials._plan-setup-popup')
                                                    </div>
                                                @endif
                                                <div class="dragg-table-wrapper card card-body">
                                                    <ul class="sortable add-main-workout-data list-unstyled sortable_{{$row['day_id']}}_{{$structure['id']}}" id="drag_drop_items_{{$row['day_id']}}_{{$structure['id']}}" style="list-style-type:none;">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
</div>
