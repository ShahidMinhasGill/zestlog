@if(!empty($ptSessionLocations))
    @foreach($ptSessionLocations as $key => $row)
        <tr id="row_{{$row->id}}">
            <th scope="row">{{ ((!empty($objCount))) ? $objCount :  $key+1}}</th>
            {{--<td>--}}
                {{--<div class="custom-control custom-checkbox">--}}
                    {{--<input id="pt_is_listing_{{$row->id}}" class="custom-control-input pt-coaching-checkbox listing pt_listing_{{$row->id}}" type="checkbox" name="pt_is_listing_{{$row->id}}" @if($row->is_listing == 1) checked @endif>--}}
                    {{--<label for="pt_is_listing_{{$row->id}}" class="custom-control-label"></label>--}}
                {{--</div>--}}
            {{--</td>--}}
            <td>
                <div class="d-flex align-items-center">
                    <input data-allow="allow-add-input" id="pt_address_name_{{$row->id}}" class="form-control pt-coaching-sessions pt-locations-input" value="{{$row->address_name}}" type="text" name="pt_address_name_{{$row->id}}">
                </div>
            </td>
            {{--<td class="br-td" class="br-td">--}}
                {{--<div class="custom-control custom-checkbox">--}}
                    {{--<input id="pt_price_changed_{{$row->id}}" class="custom-control-input pt-coaching-checkbox pt-coaching-sessions" type="checkbox" name="pt_price_changed_{{$row->id}}" @if($row->price_changed == 1) checked @endif>--}}
                    {{--<label for="pt_price_changed_{{$row->id}}" class="custom-control-label"></label>--}}
                {{--</div>--}}
            {{--</td>--}}
            {{--<td class="br-td" class="br-td">--}}
                {{--<div class="d-flex align-items-center">--}}
                    {{--<div class="custom-control custom-radio">--}}
                        {{--<input type="radio" id="pt_priceup_checked_{{$row->id}}" name="pt_price_checked_{{$row->id}}" class="custom-control-input pt-coaching-sessions_{{$row->id}}" @if($row->price_checked == 1) checked @endif value="1">--}}
                        {{--<label class="custom-control-label" for="pt_priceup_checked_{{$row->id}}"></label>--}}
                    {{--</div>--}}
                    {{--<input type="text" id="pt_price_up_{{$row->id}}" name="pt_price_up_{{$row->id}}" class="form-control text-center pt-coaching-sessions_{{$row->id}}" value="{{$row->price_up}}" style="width: 80px;">--}}
                {{--</div>--}}
            {{--</td>--}}

            {{--<td class="br-td" class="br-td">--}}
                {{--<div class="d-flex align-items-center">--}}
                    {{--<div class="custom-control custom-radio">--}}
                        {{--<input type="radio" id="pt_pricedown_checked_{{$row->id}}" name="pt_price_checked_{{$row->id}}" class="custom-control-input pt-coaching-sessions_{{$row->id}}" @if($row->price_checked !== null && $row->price_checked == 0) checked="checked" @endif value="0">--}}
                        {{--<label class="custom-control-label" for="pt_pricedown_checked_{{$row->id}}"></label>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<input type="text" id="pt_price_down_{{$row->id}}" name="pt_price_down_{{$row->id}}" class="form-control text-center pt-coaching-sessions_{{$row->id}}" value="{{$row->price_down}}" style="width: 80px;">--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</td>--}}

            {{--<td class="br-td" class="br-td">--}}
                {{--<div class="d-flex align-items-center">--}}
                    {{--<div class="custom-control custom-radio">--}}
                        {{--<input type="radio" id="pt_rateup_checked_{{$row->id}}" name="pt_rate_checked_{{$row->id}}" class="custom-control-input pt-coaching-sessions_{{$row->id}}" @if($row->rate_checked == 1) checked="checked" @endif value="1">--}}
                        {{--<label class="custom-control-label" for="pt_rateup_checked_{{$row->id}}"></label>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<input type="text" id="pt_rate_up_{{$row->id}}" name="pt_rate_up_{{$row->id}}" class="form-control text-center pt-coaching-sessions_{{$row->id}}" value="{{$row->rate_up}}" style="width: 80px;">--}}
                    {{--</div>--}}
                    {{--<span class="ml-2">%</span>--}}
                {{--</div>--}}
            {{--</td>--}}
            {{--<td class="br-td" class="br-td">--}}
                {{--<div class="d-flex align-items-center">--}}
                    {{--<div class="custom-control custom-radio">--}}
                        {{--<input type="radio" id="pt_ratedown_checked_{{$row->id}}" name="pt_rate_checked_{{$row->id}}" class="custom-control-input pt-coaching-sessions_{{$row->id}}" @if($row->rate_checked !== null && $row->rate_checked == 0) checked="checked" @endif value="0">--}}
                        {{--<label class="custom-control-label" for="pt_ratedown_checked_{{$row->id}}"></label>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<input type="text" id="pt_rate_down_{{$row->id}}" name="pt_rate_down_{{$row->id}}" class="form-control text-center pt-coaching-sessions_{{$row->id}}" value="{{$row->rate_down}}" style="width: 80px;">--}}
                    {{--</div>--}}
                    {{--<span class="ml-2">%</span>--}}
                {{--</div>--}}
            {{--</td>--}}
            <td><a href="javascript: void(0)" class="text-dark delete-pt-locations" id="delete_{{$row->id}}"><i class="fas fa-times fa-lg"></i></a></td>
        </tr>
    @endforeach
@endif
