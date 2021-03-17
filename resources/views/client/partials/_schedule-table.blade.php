<style>
    .tableFixHead {
        max-height: 550px;
        overflow-y: auto;
    }
    .tableFixHead thead tr{
        background-color: #fff;
        border-top: 1px solid #dee2e6;
        position: relative;
    }
    .tableFixHead thead tr td{
        position: relative;
        border-top: 0;
        border-right: 1px solid #dee2e6;
    }
    .tableFixHead thead tr td::before{
        content: "";
        position: absolute;
        background: #dee2e6;
        width: 100%;
        height: 2px;
        bottom: -2px;
        left: 0;
        z-index: 9;
    }
    .tableFixHead thead tr:first-child td::after{
        content: "";
        position: absolute;
        background: #dee2e6;
        width: 100%;
        height: 1px;
        top: -1px;
        left: 0;
        z-index: 9;
    }
    
</style>
<div class="col-12">
    <div class="tableFixHead">
    <table class="table table-bordered border-bottom">
        <thead>
            <tr class="block-whole-week-tr">
                <td style="width: 4%"></td>
                <td colspan="7">Block Whole Week
                    <select class="custom-select" style="width: 60px;" id="whole-week-block">
                        <option @if(isset($data['scheduleData']['is_block_whole_week']) && $data['scheduleData']['is_block_whole_week']==0)selected @endif value="0">No
                        </option>
                        <option @if(isset($data['scheduleData']['is_block_whole_week']) && $data['scheduleData']['is_block_whole_week']==1)selected @endif value="1">Yes
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width: 4%"></td>
                @foreach($data['days'] as $key =>$row)
                <td class="text-center selected-week-date" id="days_id_{{$key}}" data-id="{{$arrWeek[$key - 1]}}" style="width: 13.71%">{{$row}} {{scheduleDateTimeFormat($arrWeek[$key - 1])}}</td>
                @endforeach
            </tr>
            <tr>
                <td style="width: 4%"></td>
                @foreach($data['days'] as $key=> $row)
                <td class="text-center" style="width: 13.71%">Block Whole Day</br>
                    <select class="custom-select block-days block_day_{{$key}}" style="width: 60px" id="block_day_{{$key}}">
                        <option @if(isset($data['scheduleDataDays'][$key]) && $data['scheduleDataDays'][$key]['is_block_whole_day']==0) selected @endif value="0">No
                        </option>
                        <option @if(isset($data['scheduleDataDays'][$key]) && $data['scheduleDataDays'][$key]['is_block_whole_day']==1) selected @endif value="1">Yes
                        </option>
                    </select>
                </td>
                @endforeach
            </tr>
        </thead>
        <tbody class="tb-body">
            @php
            $arrBookingSlot = $arrUniqueBlockedSlots = []
            @endphp
            @foreach($data['timeSlots'] as $key=> $row)

            @php
            $currentTimeStamp = strtotime($row['time_slot']);
            //$key = $row['id'];
            @endphp
            <div class="table-slot">
                <tr class="slot-tr border1 row_slot_{{$key}}">
                    <td style="width: 4%" class="border time_slot_{{$key}}">
                        <ul class="time-list list-unstyled mb-0">
                            <li><span>{{$row['time_slot']}}</span></li>
                        </ul>

                    </td>
                    @php
                    $bookedTimeSlot = isBookedTimeSlot($arrBooking,$currentTimeStamp, $arrWeek[0], $arrBookingSlot);
                    $blockedTimeSlot= isBlockTimeSlot($data['blockTimeSlots'], 1, $currentTimeStamp, $arrWeek[0], true, $arrUniqueBlockedSlots);
                    $displayClass = 'empty-slot';
                    if(!empty($bookedTimeSlot['booking']) || !empty($bookedTimeSlot['color']))
                    $displayClass = 'booked-slot-tr';
                    elseif(!empty($blockedTimeSlot['is_blocked']))
                        $displayClass = 'block-slot-tr';
                    @endphp

                    <td style="width: 13.71%" class="{{$displayClass}} table-row border block_day_1 block-slot-td td-class-blocked_{{@$blockedTimeSlot['id']}} time_slot_{{$key}} @if(!empty($bookedTimeSlot['color'])) booked_time_slot_row @endif" id="time_slot_{{$row['id']}}_1_{{@$blockedTimeSlot['id']}}">
                        @if(!empty($bookedTimeSlot['booking']) || !empty($bookedTimeSlot['color']))
                        <p class="mb-0 booked_time_slot_row">{!! $bookedTimeSlot['booking'] !!}</p>
                        @elseif(!empty($blockedTimeSlot['is_blocked']))
                         <div class="mb-0 block-slot text-light font-weight-bold" data-id="{{$blockedTimeSlot['id']}}" id="block-time_slot_{{$row['id']}}_1">{{$blockedTimeSlot['is_text']}}</div>
                        @else
                            <p class="mb-0 empty-slot"></p>
                        @endif
                    </td>
                    @php
                    $bookedTimeSlot = isBookedTimeSlot($arrBooking,$currentTimeStamp, $arrWeek[1], $arrBookingSlot);
                    $blockedTimeSlot = isBlockTimeSlot($data['blockTimeSlots'], 2, $currentTimeStamp, $arrWeek[1], true, $arrUniqueBlockedSlots);
                    $displayClass = 'empty-slot';
                    if(!empty($bookedTimeSlot['booking']) || !empty($bookedTimeSlot['color']))
                    $displayClass = 'booked-slot-tr';
                    elseif(!empty($blockedTimeSlot['is_blocked']))
                        $displayClass = 'block-slot-tr';
                    @endphp
                    <td style="width: 13.71%" class="{{$displayClass}} table-row border block_day_2 block-slot-td td-class-blocked_{{@$blockedTimeSlot['id']}} time_slot_{{$key}} @if(!empty($bookedTimeSlot['color'])) booked_time_slot_row @endif" id="time_slot_{{$row['id']}}_2_{{@$blockedTimeSlot['id']}}">
                        @if(!empty($bookedTimeSlot['booking']) || !empty($bookedTimeSlot['color']))
                            <p class="mb-0 booked_time_slot_row">{!! $bookedTimeSlot['booking'] !!}</p>
                        @elseif(!empty($blockedTimeSlot['is_blocked']))
                            <div class="mb-0 block-slot text-light font-weight-bold" data-id="{{$blockedTimeSlot['id']}}" id="block-time_slot_{{$row['id']}}_2">{{$blockedTimeSlot['is_text']}}</div>
                        @else
                            <p class="mb-0 empty-slot"></p>
                        @endif
                    </td>
                    @php
                    $bookedTimeSlot = isBookedTimeSlot($arrBooking,$currentTimeStamp, $arrWeek[2], $arrBookingSlot);
                    $blockedTimeSlot = isBlockTimeSlot($data['blockTimeSlots'], 3, $currentTimeStamp, $arrWeek[2], true, $arrUniqueBlockedSlots);
                    $displayClass = 'empty-slot';
                    if(!empty($bookedTimeSlot['booking']) || !empty($bookedTimeSlot['color']))
                    $displayClass = 'booked-slot-tr';
                    elseif(!empty($blockedTimeSlot['is_blocked']))
                        $displayClass = 'block-slot-tr';
                    @endphp
                    <td style="width: 13.71%" class="{{$displayClass}} table-row border block_day_3 block-slot-td td-class-blocked_{{@$blockedTimeSlot['id']}} time_slot_{{$key}} @if(!empty($bookedTimeSlot['color'])) booked_time_slot_row @endif" id="time_slot_{{$row['id']}}_3_{{@$blockedTimeSlot['id']}}">
                        @if(!empty($bookedTimeSlot['booking']) || !empty($bookedTimeSlot['color']))
                            <p class="mb-0 booked_time_slot_row">{!! $bookedTimeSlot['booking'] !!}</p>
                        @elseif(!empty($blockedTimeSlot['is_blocked']))
                            <div class="mb-0 block-slot text-light font-weight-bold" data-id="{{$blockedTimeSlot['id']}}" id="block-time_slot_{{$row['id']}}_3">{{$blockedTimeSlot['is_text']}}</div>
                        @else
                            <p class="mb-0 empty-slot"></p>
                        @endif
                    </td>
                        @php
                        $bookedTimeSlot = isBookedTimeSlot($arrBooking,$currentTimeStamp, $arrWeek[3], $arrBookingSlot);
                        $blockedTimeSlot = isBlockTimeSlot($data['blockTimeSlots'], 4, $currentTimeStamp, $arrWeek[3], true, $arrUniqueBlockedSlots);
                        $displayClass = 'empty-slot';
                        if(!empty($bookedTimeSlot['booking']) || !empty($bookedTimeSlot['color']))
                        $displayClass = 'booked-slot-tr';
                        elseif(!empty($blockedTimeSlot['is_blocked']))
                         $displayClass = 'block-slot-tr';
                        @endphp
                        <td style="width: 13.71%" class="{{$displayClass}} table-row border block_day_4 block-slot-td td-class-blocked_{{@$blockedTimeSlot['id']}} time_slot_{{$key}} @if(!empty($bookedTimeSlot['color'])) booked_time_slot_row @endif" id="time_slot_{{$row['id']}}_4_{{@$blockedTimeSlot['id']}}">
                            @if(!empty($bookedTimeSlot['booking']) || !empty($bookedTimeSlot['color']))
                                <p class="mb-0 booked_time_slot_row">{!! $bookedTimeSlot['booking'] !!}</p>
                            @elseif(!empty($blockedTimeSlot['is_blocked']))
                                <div class="mb-0 block-slot text-light font-weight-bold" data-id="{{$blockedTimeSlot['id']}}" id="block-time_slot_{{$row['id']}}_4">{{$blockedTimeSlot['is_text']}}</div>
                            @else
                                <p class="mb-0 empty-slot"></p>
                            @endif
                        </td>
                        @php
                        $bookedTimeSlot = isBookedTimeSlot($arrBooking,$currentTimeStamp, $arrWeek[4], $arrBookingSlot);
                        $blockedTimeSlot = isBlockTimeSlot($data['blockTimeSlots'], 5, $currentTimeStamp, $arrWeek[4], true, $arrUniqueBlockedSlots);
                        $displayClass = 'empty-slot';
                        if(!empty($bookedTimeSlot['booking']) || !empty($bookedTimeSlot['color']))
                        $displayClass = 'booked-slot-tr';
                        elseif(!empty($blockedTimeSlot['is_blocked']))
                         $displayClass = 'block-slot-tr';
                        @endphp
                        <td style="width: 13.71%" class="{{$displayClass}} table-row border block_day_5 block-slot-td td-class-blocked_{{@$blockedTimeSlot['id']}} time_slot_{{$key}} @if(!empty($bookedTimeSlot['color'])) booked_time_slot_row @endif" id="time_slot_{{$row['id']}}_5_{{@$blockedTimeSlot['id']}}">
                            @if(!empty($bookedTimeSlot['booking']) || !empty($bookedTimeSlot['color']))
                                <p class="mb-0 booked_time_slot_row">{!! $bookedTimeSlot['booking'] !!}</p>
                            @elseif(!empty($blockedTimeSlot['is_blocked']))
                                <div class="mb-0 block-slot text-light font-weight-bold" data-id="{{$blockedTimeSlot['id']}}" id="block-time_slot_{{$row['id']}}_5">{{$blockedTimeSlot['is_text']}}</div>
                            @else
                                <p class="mb-0 empty-slot"></p>
                            @endif
                        </td>
                        @php
                        $bookedTimeSlot = isBookedTimeSlot($arrBooking,$currentTimeStamp, $arrWeek[5], $arrBookingSlot);
                        $blockedTimeSlot = isBlockTimeSlot($data['blockTimeSlots'], 6, $currentTimeStamp, $arrWeek[5], true, $arrUniqueBlockedSlots);
                        $displayClass = 'empty-slot';
                        if(!empty($bookedTimeSlot['booking']) || !empty($bookedTimeSlot['color']))
                        $displayClass = 'booked-slot-tr';
                        elseif(!empty($blockedTimeSlot['is_blocked']))
                         $displayClass = 'block-slot-tr';
                        @endphp
                        <td style="width: 13.71%" class="{{$displayClass}} table-row border block_day_6 block-slot-td td-class-blocked_{{@$blockedTimeSlot['id']}} time_slot_{{$key}} @if(!empty($bookedTimeSlot['color'])) booked_time_slot_row @endif" id="time_slot_{{$row['id']}}_6_{{@$blockedTimeSlot['id']}}">
                            @if(!empty($bookedTimeSlot['booking']) || !empty($bookedTimeSlot['color']))
                                <p class="mb-0 booked_time_slot_row">{!! $bookedTimeSlot['booking'] !!}</p>
                            @elseif(!empty($blockedTimeSlot['is_blocked']))
                                <div class="mb-0 block-slot text-light font-weight-bold" data-id="{{$blockedTimeSlot['id']}}" id="block-time_slot_{{$row['id']}}_6">{{$blockedTimeSlot['is_text']}}</div>
                            @else
                                <p class="mb-0 empty-slot"></p>
                            @endif
                        </td>
                        @php
                        $bookedTimeSlot = isBookedTimeSlot($arrBooking,$currentTimeStamp, $arrWeek[6], $arrBookingSlot);
                        $blockedTimeSlot = isBlockTimeSlot($data['blockTimeSlots'], 7, $currentTimeStamp, $arrWeek[6], true, $arrUniqueBlockedSlots);
                        $displayClass = 'empty-slot';
                        if(!empty($bookedTimeSlot['booking']) || !empty($bookedTimeSlot['color']))
                        $displayClass = 'booked-slot-tr';
                        elseif(!empty($blockedTimeSlot['is_blocked']))
                         $displayClass = 'block-slot-tr';
                        @endphp
                        <td style="width: 13.71%" class="{{$displayClass}} table-row border block_day_7 block-slot-td td-class-blocked_{{@$blockedTimeSlot['id']}} time_slot_{{$key}} @if(!empty($bookedTimeSlot['color'])) booked_time_slot_row @endif" id="time_slot_{{$row['id']}}_7_{{@$blockedTimeSlot['id']}}">
                            @if(!empty($bookedTimeSlot['booking']) || !empty($bookedTimeSlot['color']))
                                <p class="mb-0 booked_time_slot_row">{!! $bookedTimeSlot['booking'] !!}</p>
                            @elseif(!empty($blockedTimeSlot['is_blocked']))
                                <div class="mb-0 block-slot text-light font-weight-bold" data-id="{{$blockedTimeSlot['id']}}" id="block-time_slot_{{$row['id']}}_7">{{$blockedTimeSlot['is_text']}}</div>
                            @else
                                <p class="mb-0 empty-slot"></p>
                            @endif
                        </td>
            </tr>
</div>
@endforeach
</tbody>
</table>
</div>
</div>
@push('after-scripts')

@endpush

<script>
    $(document).ready(function() {

        var $th = $('.tableFixHead').find('thead tr')
            $('.tableFixHead').on('scroll', function () {
                $th.css('transform', 'translateY(' + this.scrollTop + 'px)');
            });

        // var el = document.querySelector('[data-module="sticky-table"]');

        // var scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;

        // var thead = el.querySelector('thead');

        // var offset = el.getBoundingClientRect();


        // window.addEventListener('scroll', function(event) {
        //     var rect = el.getBoundingClientRect();

        //     scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;

        //     if (rect.top < thead.offsetHeight) {
        //         thead.style.width = rect.width + 'px';
        //         thead.classList.add('thead--is-fixed');
        //     } else {
        //         thead.classList.remove('thead--is-fixed');
        //     }
        // });

    });
</script>
