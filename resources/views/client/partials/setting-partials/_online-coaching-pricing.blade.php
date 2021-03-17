<h3 class="section-title mb-3">Online coaching pricing setup</h3>

<div class="table-responsive disable-div" id="btn-save-div">
    <div class="pricing-modal-table">
        <div class="tb-head d-flex p-3 bg-light">
            <div class="td" style="flex: 0 0 auto">Variable Pricing</div>
        </div>
        <div class="tb-body">
            <div class="d-flex tb-tr">
                <div class="td" style="flex: 0 0 500px">
                    <div class="td-inner-wrapper">
                        <div class="my-2 mt-3">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="card bg-light mb-2">
                                        <div class="card-body p-1">
                                            <strong class="mr-2 mb-1 float-left">Base Price: <small class="font-weight-bold"> 1 online coaching session </small></strong>
                                            {{ Form::text('base_price', $basePrice['base_price'], ['class' => 'form-control float-right w-25', 'id' => 'base_price']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="card bg-light mb-2">
                                        <div class="card-body p-1">
                                            <div class="custom-control custom-checkbox mb-2 float-left">
                                                <input id="my-input2" @if($basePrice['is_checked']==1) checked="checked"
                                                       @endif class="custom-control-input base-checkbox-checked coaching_input"
                                                       type="checkbox" onclick="clearFields()" nc
                                                       name="" value="true">
                                                <label for="my-input2" class="custom-control-label"><strong>Use default
                                                        discounts%</strong></label>
                                                <a href="javascript: void(0)" id="calculate-discount"
                                                   class="btn sm-btn success-btn rounded">Calculate</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-3 text-right"><strong>Discount</strong></div>
                            </div>
                        </div>
                        <div class="plan-head d-flex p-2 bg-light mb-2">
                            <div style="flex: 0 0 380px;"></div>
                            <div style="flex: 0 0 25px"><strong>Discount</strong></div>
                        </div>
                        <ul class="plan-list list-unstyled">
                            @foreach($data['dayName'] as $key=> $row)
                                <li>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input training-plan-checkbox"onclick="daysCheckboxChecked()"
                                               id="checkbox_{{getDayParseId($row['days_value'])}}_{{$row['id']}}"
                                               @if(!empty($dayDiscounts[getDayParseId($row['days_value'])])) checked="checked" @endif>
                                        <label class="custom-control-label"
                                               for="checkbox_{{getDayParseId($row['days_value'])}}_{{$row['id']}}">{{$row['name']}}</label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-end">
                                        <input type="text"
                                               class="form-control plan-input discount-input discount-training-plan"
                                               id="discount_{{getDayParseId($row['days_value'])}}"
                                               @if($isAutoCalculateDiscount && !empty($dayDiscounts[getDayParseId($row['days_value'])]))
                                               value="{{$dayDiscounts[getDayParseId($row['days_value'])]['discount']}}"
                                                @endif
                                        ><span class="ml-2">%</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @php
                    $array = preparePlanNumbers();
                @endphp
                @foreach($data['weekName'] as $key=> $row)
                    @php
                        $key = $key + 1;
                    @endphp
                    <div class="td" style="flex: 0 0 400px">
                        <div class="td-inner-wrapper">
                            <div class="week-header">
                                <div class="card mb-0">
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input id="week-checkbox_{{$key}}"
                                                           class="custom-control-input training-week-checkbox"onclick="daysCheckboxChecked()"
                                                           type="checkbox"
                                                           @if(!empty($weekDiscounts[$key])) checked="checked" @endif>
                                                    <label for="week-checkbox_{{$key}}" class="custom-control-label">
                                                        <strong>{{$row['name']}}</strong></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="d-flex align-items-center mt-4">
                                                    <input type="text"
                                                           class="form-control plan-input discount-input discount-training-plan-week online-coaching-discount-weeks"
                                                           id="discount-week_{{$key}}"
                                                           @if($isAutoCalculateDiscount && !empty($weekDiscounts[$key]))
                                                           value="{{$weekDiscounts[$key]['discount']}}"
                                                            @endif
                                                    ><span class="ml-2">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="week-program-table">
                                <div class="wp-tb-head">
                                    <div>Total Nr. of sessions</div>
                                    <div>before Discount</div>
                                    <div>Total Discount%</div>
                                    <div>Final Price</div>
                                </div>
                                @foreach($data['dayName'] as $keyDay=> $row)
                                    @php
                                        $totalPlans = '----';
                                        $beforeDiscount= $totalDiscount = $finalPrice = '----';
                                        if (($key == 1 &&($row['days_value'] == 0.5 || $row['days_value']== 0.25)) || ($key == 2 && $row['days_value']== 0.25)) {
                                            $totalPlans = '';
                                            $beforeDiscount= $totalDiscount = $finalPrice  = '';
                                        }
                                    @endphp
                                    <div class="wp-tb-tr final_day_{{getDayParseId($row['days_value'])}} final_day_week_{{$key}}">
                                        @if($totalPlans)
                                            <div id="total_plan_{{getDayParseId($row['days_value'])}}_{{$key}}">{{getWeekDays($key,$row['days_value'])}}</div>
                                            <div class="week-fields" id="before_discount_{{getDayParseId($row['days_value'])}}_{{$key}}">{{$beforeDiscount}}</div>
                                            <div class="week-fields" id="total_discount_{{getDayParseId($row['days_value'])}}_{{$key}}">{{$totalDiscount}}</div>
                                        @else
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        @endif
                                        <div>
                                            @if($finalPrice)
                                                {{ Form::text('final_price_'.getDayParseId($row['days_value']).'_'.$key, getFinalPrice($trainingData,getDayParseId($row['days_value']),$key), ['class' => 'form-control final_week_input_'.$key.' final_price_class week-fields final_day_input_'.getDayParseId($row['days_value']), 'id' => 'final_price_'.getDayParseId($row['days_value']).'_'.$key]) }}
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

<button class="btn success-btn my-3" data-id="0" id="btn-save">Edit</button>

<form id="coaching-session-form" name="coaching-session-form">
<div class="card">
    <div class="card-body">
        <div class="custom-control custom-checkbox mb-3">
            {{--<input id="length_online_coaching_session" class="custom-control-input" type="checkbox" name="length_online_coaching_session" @if($length_online_coaching_session) checked @endif>--}}
            <label for="length_online_coaching_session" class="font-weight-bold">Length of online coaching sessions</label>
        </div>

        <div class="table-responsive disable-div" id="save-coaching-sessions-div">
            <table class="table text-center">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Nr</th>
                    <th scope="col">Listing</th>
                    <th scope="col">Session length</th>
                    {{--<th scope="col">Price change</th>--}}
                    {{--<th scope="col">Price Up</th>--}}
                    {{--<th scope="col">Price Down</th>--}}
                    {{--<th scope="col">(+) Rate Up%</th>--}}
                    {{--<th scope="col">(-) Rate Down%</th>--}}
                </tr>
                </thead>
                <tbody>
                @include('client.partials.setting-partials._common-sessions')
                </tbody>
            </table>
        </div>

        <a href="javascript: void(0)" data-id="0" id="save-coaching-sessions" class="btn success-btn mt-3">Edit</a>
    </div>
</div>
</form>

{{--@include('client.partials.setting-partials._group-coaching', ['title' => 'Group online coaching', 'uniqueId' => 'save-group-coaching', 'groupId' => 'group_online_coaching', 'checkedId' => $group_online_coaching])--}}
