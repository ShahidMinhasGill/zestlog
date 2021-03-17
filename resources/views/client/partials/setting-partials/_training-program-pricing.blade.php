<h3 class="section-title mb-3">Training program pricing setup</h3>

<!--Start Base price setup card -->

<div class="disable-div" id="btn-save-training-plan-div">
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body pricing-modal-table">
                <div class="border-bottom pb-2 mb-2">
                    <h4 class="font-weight-bold">Base Price Setup</h4>
                </div>
                <div class="tb-body">
                    <div class="">
                        <div class="td" style="flex: 0 0 500px">
                            <div class="">
                                <div class="mb-2 mt-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card bg-light mb-2">
                                                <div class="card-body p-1">
                                                    <strong class="mr-2 mb-1 float-left">Base Price: 1 training
                                                        plan</strong>
                                                    {{ Form::text('base_price', $basePrice['base_price'], ['class' => 'form-control float-right w-25', 'id' => 'base_price']) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div style="pointer-events: auto; padding-right: 5%;margin-left: 30%">
                                            <a href="javascript: void(0)" data-id="0" id="btn-save-training-plan" class="btn success-btn btn-save-training-data mt-3">Edit</a>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card bg-light mb-2">
                                                <div class="card-body p-1">
                                                    <strong class="mr-2 mb-1 float-left">Weekly repeat use
                                                        <br>
                                                        <div class="custom-control custom-checkbox mb-2 float-left">
                                                            <input id="my-input2"
                                                                   @if(isset($repeatPercentageValue['is_use_default_week_repeat']) && $repeatPercentageValue['is_use_default_week_repeat']==1) checked="checked"
                                                                   @endif
                                                                   class="custom-control-input is_default_checked_weekly_repeat"
                                                                   type="checkbox" name="">
                                                            <label for="my-input2" class="custom-control-label is_default_checked_weekly_repeat"><strong>Use
                                                                    default</strong></label>
                                                        </div>
                                                    </strong>
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <strong>+</strong>
                                                        {{ Form::text('repeat_percentage_value',isset($repeatPercentageValue['repeat_percentage_value']) ? $repeatPercentageValue['repeat_percentage_value'] : '', ['class' => 'form-control float-right w-50', 'id' => 'repeat-input-percentage']) }}
                                                        <strong>%</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card bg-light mb-4">
                                                <div class="card-body p-1">
                                                    <a href="javascript: void(0)"
                                                       class="btn sm-btn success-btn rounded float-right"id="calculate-training-price">Calculate</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col" colspan="2">Nr</th>
                                        <th scope="col" class="text-right">Base price (1-week program)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data['dayName'] as $key=> $row)
                                        <tr>
                                            <td colspan="2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           class="custom-control-input training-plan-checkbox checkbox-checked-training-days"
                                                           onclick="daysCheckboxChecked()"
                                                           id="checkbox_{{getDayParseId($row['days_value'])}}_{{$row['id']}}"
                                                           @if(!empty($dayDiscounts[getDayParseId($row['days_value'])])) checked="checked" @endif>
                                                    <label class="custom-control-label"
                                                           for="checkbox_{{getDayParseId($row['days_value'])}}_{{$row['id']}}">{{$row['name']}}</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <input type="text"
                                                           class="form-control plan-input discount-input discount-training-plan w-35"
                                                           id="discount_{{getDayParseId($row['days_value'])}}"
                                                           @if($isAutoCalculateDiscount && !empty($dayDiscounts[getDayParseId($row['days_value'])]))
                                                           value="{{$dayDiscounts[getDayParseId($row['days_value'])]['discount']}}"
                                                            @endif
                                                    ><span class="ml-2"></span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Base price setup card -->

<!--Start lenth of program card -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body pricing-modal-table">
                <div class="pb-2 mb-2">
                    <h4 class="font-weight-bold border-bottom">Length of Program in One Booking</h4>
                    <div class="custom-control custom-checkbox mb-2 float-left">
                        <input id="checkbox_use_default_booking" @if(isset($repeatPercentageValue['is_use_default_length_program_booking']) && $repeatPercentageValue['is_use_default_length_program_booking']==1) checked="checked"
                               @endif
                               class="custom-control-input"
                               type="checkbox" name="checkbox_use_default_booking">
                        <label for="checkbox_use_default_booking" class="custom-control-label"><strong>Use
                                default</strong></label>
                    </div>

                </div>

                <div class="tb-body">
                    <div class="td" style="flex: 0 0 500px">
                        <div class="">
                            <table class="table text-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nr</th>
                                    <th scope="col">Listing</th>
                                    <th scope="col">Length of Program</th>
                                    <th scope="col" class="text-right pr-5">Discount%</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['weekName'] as $key=> $row)
                                    @php
                                        $key = $key + 1;
                                    @endphp
                                    <tr class="week-training-booking-row-{{$key}}">
                                        <th scope="row">{{$key}}</th>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input id="week-checkbox_{{$key}}"
                                                       class="custom-control-input training-week-checkbox discount-training-one-booking"
                                                       onclick="daysCheckboxChecked()"
                                                       type="checkbox"
                                                       @if(!empty($weekDiscounts[$key])) checked="checked" @endif>
                                                <label for="week-checkbox_{{$key}}" class="custom-control-label"></label>
                                            </div>
                                        </td>
                                        <td><strong>{{$row['name']}}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input type="text"
                                                       class="form-control plan-input discount-input discount-training-plan-week w-35"
                                                       id="discount-week_{{$key}}"
                                                       @if($isAutoCalculateDiscount && !empty($weekDiscounts[$key]))
                                                       value="{{$weekDiscounts[$key]['discount']}}"
                                                        @endif
                                                >
                                                <strong>%</strong>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End lenth of program card -->

<!--Start Repeat program card -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body pricing-modal-table">

                <div class=" pb-2 mb-2">
                    <h4 class="dint-weight-bold border-bottom">Number of New Programs Purchased in One Booking</h4>
                    <div class="custom-control custom-checkbox mb-2 float-left">
                        <input id="checkbox_repeat_program" class="custom-control-input" type="checkbox" name="checkbox_repeat_program" @if(isset($repeatPercentageValue['is_use_default_repeat_purchase_booking']) && $repeatPercentageValue['is_use_default_repeat_purchase_booking']==1) checked="checked"@endif>
                        <label for="checkbox_repeat_program" class="custom-control-label"><strong>Use
                                default</strong></label>
                    </div>
                    </div>
                
                <div class="tb-body">
                    <div class="td" style="flex: 0 0 500px">
                        <div class="">
                            <table class="table text-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nr</th>
                                    <th scope="col">Purchased in One Booking</th>
                                    <th scope="col" class="text-right pr-5">Discount%</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($repeatPurchase['repeatPurchaseBooking'] as $key=> $row)
                                    @php
                                        $key = $key + 1;
                                    @endphp
                                    <tr class="repeat-purchase-booking-row-{{$key}}">
                                        <th scope="row">{{$key}}</th>
                                        <td><strong>{{$row['name']}}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input type="text"
                                                       class="form-control float-right w-35 mx-2  discount-input purchased-booking"
                                                       value="{{isset($objRepeatBooking['discount_'.$key]) ? $objRepeatBooking['discount_'.$key] : ''}}"
                                                       id="booking_{{$key}}">
                                                <strong>%</strong>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Repeat program card -->
</div>

