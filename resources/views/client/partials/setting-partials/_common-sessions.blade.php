@foreach($coachingSessions as $key=> $row)
    <tr>
        <th scope="row">{{$row->id}}</th>
        <td>
            <div class="custom-control custom-checkbox">
                <input id="is_listing_{{$row->id}}" class="custom-control-input coaching-checkbox listing coaching-sessions-listing listing_{{$row->id}}" type="checkbox" name="is_listing_{{$row->id}}" @if($row->is_listing == 1) checked @endif @if($row->id == 2 || $row->id == 7) checked disabled @endif>
                <label for="is_listing_{{$row->id}}" class="custom-control-label"></label>
            </div>
        </td>
        <td>
            <div class="text-center">
                <span>{{$row->value}}</span>
            </div>
        </td>
        {{--@if($row->id == 2 || $row->id == 7)--}}
            {{--<td class="br-td">--}}
                {{--<div class="custom-control custom-checkbox">--}}
                    {{--<strong>Default</strong>--}}
                {{--</div>--}}
            {{--</td>--}}
        {{--@else--}}
            {{--<td class="br-td">--}}
                {{--<div class="custom-control custom-checkbox">--}}
                    {{--<input id="price_changed_{{$row->id}}" class="custom-control-input coaching-checkbox coaching-sessions" type="checkbox" name="price_changed_{{$row->id}}" @if($row->price_changed == 1) checked @endif>--}}
                    {{--<label for="price_changed_{{$row->id}}" class="custom-control-label"></label>--}}
                {{--</div>--}}
            {{--</td>--}}
            {{--<td class="br-td">--}}
                {{--<div class="d-flex align-items-center justify-content-center">--}}
                    {{--<div class="custom-control custom-radio">--}}
                        {{--<input type="radio" id="priceup_checked_{{$row->id}}" name="price_checked_{{$row->id}}" class="custom-control-input coaching-sessions_{{$row->id}}" @if($row->price_checked == 1) checked @endif value="1">--}}
                        {{--<label class="custom-control-label" for="priceup_checked_{{$row->id}}"></label>--}}
                    {{--</div>--}}
                    {{--<input type="text" id="price_up_{{$row->id}}" name="price_up_{{$row->id}}" class="form-control text-center coaching-sessions_{{$row->id}}" value="{{$row->price_up}}" style="width: 80px;">--}}
                {{--</div>--}}
            {{--</td>--}}
            {{--<td class="br-td">--}}
                {{--<div class="d-flex align-items-center justify-content-center">--}}
                    {{--<div class="custom-control custom-radio">--}}
                        {{--<input type="radio" id="pricedown_checked_{{$row->id}}" name="price_checked_{{$row->id}}" class="custom-control-input coaching-sessions_{{$row->id}}" @if($row->price_checked !== null && $row->price_checked == 0) checked="checked" @endif value="0">--}}
                        {{--<label class="custom-control-label" for="pricedown_checked_{{$row->id}}"></label>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<input type="text" id="price_down_{{$row->id}}" name="price_down_{{$row->id}}" class="form-control text-center coaching-sessions_{{$row->id}}" value="{{$row->price_down}}" style="width: 80px;">--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</td>--}}
            {{--<td class="br-td">--}}
                {{--<div class="d-flex align-items-center justify-content-center">--}}
                    {{--<div class="custom-control custom-radio">--}}
                        {{--<input type="radio" id="rateup_checked_{{$row->id}}" name="price_checked_{{$row->id}}" class="custom-control-input coaching-sessions_{{$row->id}}" @if($row->price_checked == 2) checked="checked" @endif value="2">--}}
                        {{--<label class="custom-control-label" for="rateup_checked_{{$row->id}}"></label>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<input type="text" id="rate_up_{{$row->id}}" name="rate_up_{{$row->id}}" class="form-control text-center coaching-sessions_{{$row->id}}" value="{{$row->rate_up}}" style="width: 80px;">--}}
                    {{--</div>--}}
                    {{--<span class="ml-2">%</span>--}}
                {{--</div>--}}
            {{--</td>--}}
            {{--<td class="br-td">--}}
                {{--<div class="d-flex align-items-center justify-content-center">--}}
                    {{--<div class="custom-control custom-radio">--}}
                        {{--<input type="radio" id="ratedown_checked_{{$row->id}}" name="price_checked_{{$row->id}}" class="custom-control-input coaching-sessions_{{$row->id}}" @if($row->price_checked !== null && $row->price_checked == 3) checked="checked" @endif value="3">--}}
                        {{--<label class="custom-control-label" for="ratedown_checked_{{$row->id}}"></label>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<input type="text" id="rate_down_{{$row->id}}" name="rate_down_{{$row->id}}" class="form-control text-center coaching-sessions_{{$row->id}}" value="{{$row->rate_down}}" style="width: 80px;">--}}
                    {{--</div>--}}
                    {{--<span class="ml-2">%</span>--}}
                {{--</div>--}}
            {{--</td>--}}
        {{--@endif--}}
    </tr>
@endforeach
