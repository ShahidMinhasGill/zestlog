<button class="btn success-btn block-time-slot" data-toggle="modal" data-target="#block-time-slot">Block a time slot</button>
<div class="modal fade" id="block-time-slot" tabindex="-1" role="dialog" aria-labelledby="block-time-slotLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="section-title">Block a time slot</h3>

                <form action="">
                    <div class="form-group row">
                        <label for="date" class="col-sm-3 col-form-label">Date</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date" class="col-sm-3 col-form-label">Time</label>
                        <div class="col-sm-9 d-flex align-items-center">
                            {!! Form::select('startTime', $data['startTimeSlots'], null, ['id' => 'startTime','class' => 'form-control selected-value']) !!}
                            <span class="mx-3">to</span>
                            {!! Form::select('endTime', $data['endTimeSlots'], 2, ['id' => 'endTime','class' => 'form-control end-time-dropdown']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="username" class="col-sm-3 col-form-label">Repeat</label>
                        <div class="col-sm-9">
                            <select class="custom-select repeat"id="repeat-block-slot" style="width: 100px">
                                <option value="" selected>Select</option>
                                <option selected value="1">No Repeat</option>
                                <option value="2">Daily</option>
                                <option value="3">Weekly</option>
                                <option value="4">Monthly</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="username" class="col-sm-3 col-form-label">End Repeat</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="endRepeatDate">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn success-btn btn-save">Save</button>
                <a href="javascript(:void)" type="button" class="link-danger font-weight-bold" data-dismiss="modal">Cancel</a>
            </div>
        </div>
    </div>
</div>

