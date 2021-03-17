<!-- <h3 class="section-title mb-3">Nutrition/diet program pricing setup</h3>

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
                                            <strong class="mr-2 mb-1 float-left">Base Price: 1 training plan</strong>
                                            {{ Form::text('base_price', $basePrice['base_price'], ['class' => 'form-control float-right w-25', 'id' => 'base_price']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="card bg-light mb-4">
                                        <div class="card-body p-1">
                                            <div class="custom-control custom-checkbox mb-2 float-left">
                                                <input id="my-input2" @if($basePrice['is_checked']==1) checked="checked"
                                                       @endif class="custom-control-input base-checkbox-checked"
                                                       type="checkbox" onclick="clearFields()" nc
                                                       name="" value="true">
                                                <label for="my-input2" class="custom-control-label"><strong>Use discount
                                                        numbers</strong></label>
                                            </div>
                                            <a href="javascript: void(0)" id="calculate-discount" class="btn sm-btn success-btn rounded float-right">Calculate</a>
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

                @foreach($data['weekName'] as $key=> $row)
                    @php
                        $key = $key + 1;
                    @endphp
                    <div class="td final_week_{{$key}}" style="flex: 0 0 400px">
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
                                                           class="form-control plan-input discount-input discount-training-plan-week"
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
                                    <div>Total Nr. of plans</div>
                                    <div>before Discount</div>
                                    <div>Total Discount%</div>
                                    <div>Final Price</div>
                                </div>
                                @foreach($data['dayName'] as $keyDay=> $row)
                                    <div class="wp-tb-tr final_day_{{getDayParseId($row['days_value'])}} final_day_week_{{$key}}">
                                        <div id="total_plan_{{getDayParseId($row['days_value'])}}_{{$key}}">{{getWeekDays($key,$row['days_value'])}}</div>
                                        <div class="week-fields " id="before_discount_{{getDayParseId($row['days_value'])}}_{{$key}}">----</div>
                                        <div class="week-fields" id="total_discount_{{getDayParseId($row['days_value'])}}_{{$key}}">----</div>
                                        <div>
                                            {{ Form::text('final_price_'.getDayParseId($row['days_value']).'_'.$key, getFinalPrice($trainingData,getDayParseId($row['days_value']),$key), ['class' => 'form-control final_week_input_'.$key.' final_price_class week-fields final_day_input_'.getDayParseId($row['days_value']), 'id' => 'final_price_'.getDayParseId($row['days_value']).'_'.$key]) }}
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

<button class="btn success-btn mt-3" data-id="0" id="btn-save">Edit</button>  -->


<h3 class="section-title mb-3">Diet program pricing setup</h3>

<!--Start Base price setup card -->
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
                                                    <strong class="mr-2 mb-1 float-left">Base Price: 1 diet plan</strong>
                                                    <input class="form-control float-right w-25" type="text" value="10.00">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card bg-light mb-2">
                                                <div class="card-body p-1">
                                                    <strong class="mr-2 mb-1 float-left">Weekly repeat use
                                                        <br>
                                                        <div class="custom-control custom-checkbox mb-2 float-left">
                                                            <input id="my-input2" class="custom-control-input" type="checkbox" name="">
                                                            <label for="my-input2" class="custom-control-label"><strong>Use default</strong></label>
                                                        </div>
                                                    </strong>
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <strong>+</strong>
                                                        <input class="form-control float-right w-50 mx-2" id="base_price" name="base_price" type="text" value="">
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
                                                    <a href="javascript: void(0)" class="btn sm-btn success-btn rounded float-right">Calculate</a>
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
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>7 diet plans (7 days) per week</td>
                                            <td><input type="text" class="form-control w-35 ml-auto" placeholder="9.5"></td>
                                        </tr>

                                    </tbody>
                                </table>
                                <button class="btn success-btn">Edit</button>
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
                <div class="border-bottom pb-2 mb-2">
                    <h4 class="font-weight-bold">Length of Program in One Booking</h4>
                </div>
                <div class="custom-control custom-checkbox mb-2 float-left">
                    <input id="my-input21" class="custom-control-input" type="checkbox" name="">
                    <label for="my-input21" class="custom-control-label"><strong>Use default</strong></label>
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
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="listing-1">
                                                <label class="custom-control-label" for="listing-1"></label>
                                            </div>
                                        </td>
                                        <td><strong>1 Week</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="listing-2">
                                                <label class="custom-control-label" for="listing-2"></label>
                                            </div>
                                        </td>
                                        <td><strong>2 Weeks</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input class="form-control float-right w-35 mx-2" type="text" value="">
                                                <strong>%</strong>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="listing-3" checked> 
                                                <label class="custom-control-label" for="listing-3"></label>
                                            </div>
                                        </td>
                                        <td><strong>4 Weeks</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input class="form-control float-right w-35 mx-2" type="text" value="">
                                                <strong>%</strong>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="listing-4" checked> 
                                                <label class="custom-control-label" for="listing-4"></label>
                                            </div>
                                        </td>
                                        <td><strong>8 Weeks</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input class="form-control float-right w-35 mx-2" type="text" value="">
                                                <strong>%</strong>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="listing-5">
                                                <label class="custom-control-label" for="listing-5"></label>
                                            </div>
                                        </td>
                                        <td><strong>12 Weeks</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input class="form-control float-right w-35 mx-2" type="text" value="">
                                                <strong>%</strong>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="listing-5">
                                                <label class="custom-control-label" for="listing-6"></label>
                                            </div>
                                        </td>
                                        <td><strong>24 Weeks</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input class="form-control float-right w-35 mx-2" type="text" value="">
                                                <strong>%</strong>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">7</th>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="listing-7" checked> 
                                                <label class="custom-control-label" for="listing-7"></label>
                                            </div>
                                        </td>
                                        <td><strong>48 Weeks</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input class="form-control float-right w-35 mx-2" type="text" value="">
                                                <strong>%</strong>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn success-btn">Edit</button>
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
                <div class="border-bottom pb-2 mb-2">
                    <h4 class="font-weight-bold">Repeat Program Purchase in One Booking</h4>
                </div>
                <div class="custom-control custom-checkbox mb-2 float-left">
                    <input id="my-input22" class="custom-control-input" type="checkbox" name="">
                    <label for="my-input22" class="custom-control-label"><strong>Use default</strong></label>
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
                                    <tr>
                                        <th scope="row">1</th>
                                        <td><strong>1 Training Program</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td><strong>2 Training Programs</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input class="form-control float-right w-35 mx-2" type="text" value="">
                                                <strong>%</strong>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td><strong>3 Training Programs</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input class="form-control float-right w-35 mx-2" type="text" value="">
                                                <strong>%</strong>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td><strong>4 Training Programs</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input class="form-control float-right w-35 mx-2" type="text" value="">
                                                <strong>%</strong>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td><strong>6 Training Programs</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input class="form-control float-right w-35 mx-2" type="text" value="">
                                                <strong>%</strong>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td><strong>12 Training Programs</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <input class="form-control float-right w-35 mx-2" type="text" value="">
                                                <strong>%</strong>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn success-btn">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Repeat program card -->
