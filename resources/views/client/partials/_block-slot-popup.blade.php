<div class="modal-body">
    <h3 class="section-title">Block a time slot</h3>
    <form action="">
        <div class="form-group row">
            <label for="date" class="col-sm-3 col-form-label"id="block-day-slot-date">Date</label>
            <div class="col-sm-5">
                <input type="text" class="form-control"id="selected-slot-date" value="{{$data['selectedDaYDate']}}" readonly>
                {{--<input type="date" class="form-control" value="2013-01-08">--}}
            </div>

        </div>
        <div class="form-group row">
            <label for="date" class="col-sm-3 col-form-label">Time</label>
            <div class="col-sm-9 d-flex align-items-center">
                {!! Form::select('startTimedrag', $data['timeSlotsPopup'], $data['start_time'], ['id' => 'startTimedrag','class' => 'form-control selected-value-drag']) !!}
                <span class="mx-3">to</span>
                {!! Form::select('endTimedrag', $data['endTimeSlots'], $data['end_time'], ['id' => 'endTimedrag','class' => 'form-control end-time-dropdown']) !!}
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn success-btn"id="save-drag-time-slot-popup-data">Save</button>
</div>
