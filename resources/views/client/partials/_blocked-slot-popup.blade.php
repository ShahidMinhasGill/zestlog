<div id="close-delete-popup">
    <div class="modal-body">
        <h3 class="section-title">Delete or Edit slot</h3>
        <form action="">
            <div class="form-group row">
                <label for="date" class="col-sm-3 col-form-label" id="block-day-slot-date">Date</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="selected-slot-date"
                           value="{{$data['selectedDaYDate']}}" readonly>
                    {{--<input type="date" class="form-control" value="2013-01-08">--}}
                </div>

            </div>
            <div class="form-group row">
                <label for="date" class="col-sm-3 col-form-label">Time</label>

                <div class="col-sm-9  d-flex align-items-center">
                    <input type="hidden" id="selectedid" value="{{$data['id']}}">
                    {!! Form::select('edit-start-time', $data['startTimeSlots'], $data['start_time'], ['id' => 'edit-start-time','class' => 'form-control selected-value-block']) !!}
                    <span class="mx-3">to</span>
                    {!! Form::select('edit-end-time', $data['endTimeSlots'], $data['end_time'], ['id' => 'edit-end-time','class' => 'form-control end-time-dropdown']) !!}
                </div>
            </div>
            @if(isset($data['repeat_id']) && $data['repeat_id'] != 1)
                <div>
                    <h4>This is a repeating event.</h4>
                    <input class="is-checked-all-slot" type="checkbox"id="{{@$data['unique_id']}}">
                    <label> Apply changes to all repeating slots of this event</label>
                </div>
            @endif
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn success-btn" id="save-edit-time-slot">Save edit</button>
        <button type="button" class="btn primary-btn" id="delete-time-slot-popup">Delete</button>
    </div>
</div>
