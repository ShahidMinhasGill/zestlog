<h3 class="section-title mb-3">Training program pricing setup</h3>

<div class="table-responsive">
    <div class="pricing-modal-table">
        <div class="tb-head d-flex p-3 bg-light">
            <div class="td" style="flex: 0 0 auto">Variable Pricing</div>
        </div>
        <div class="tb-body">
            <div class="d-flex tb-tr">
                <div class="td" style="flex: 0 0 500px">
                    <div class="td-inner-wrapper">
                        <div class="mb-2 mt-3">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="card bg-light mb-2">
                                        <div class="card-body p-1">
                                            <strong class="mr-2 mb-1 float-left">Base Price: 1 training plan</strong>
                                            {{ Form::text('base_price', old('base_price'), ['class' => 'form-control float-right w-25', 'id' => 'base_price']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="card bg-light mb-4">
                                        <div class="card-body p-1">
                                            <div class="custom-control custom-checkbox mb-2 float-left">
                                                <input id="my-input2" class="custom-control-input" type="checkbox" onclick="clearFields()" nc
                                                       name="" value="true" checked>
                                                <label for="my-input2" class="custom-control-label"><strong>Use discount
                                                        numbers</strong></label>
                                            </div>
                                            <a href="javascript: void(0)" id="calculate-discount" class="btn sm-btn success-btn rounded float-right">Calculate</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 text-right">
                                    <strong>Discount</strong>
                                </div>
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
                                        <input type="checkbox" class="custom-control-input training-plan-checkbox" id="checkbox_{{$key + 1}}">
                                        <label class="custom-control-label" for="checkbox_{{$key + 1}}">{{$row['name']}}</label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-end">
                                        <input type="text" class="form-control plan-input discount-input discount-training-plan" id="discount_{{$key + 1}}"><span class="ml-2">%</span>
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
                    <div class="td" style="flex: 0 0 400px">
                        <div class="td-inner-wrapper">
                            <div class="week-header">
                                <div class="card mb-0">
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input id="week-checkbox_{{$key}}" class="custom-control-input training-week-checkbox"type="checkbox">
                                                    <label for="week-checkbox_{{$key}}" class="custom-control-label">
                                                        <strong>{{$row['name']}}</strong></label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="d-flex align-items-center mt-4">
                                                    <input type="text" class="form-control plan-input discount-input discount-training-plan-week"id="discount-week_{{$key}}"><span class="ml-2">%</span>
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
                                @for($j = 1;$j<=7;$j++)
                                    <div class="wp-tb-tr">
                                        <div class="week-fields" id="total_plan_{{$j}}_{{$key}}">----</div>
                                        <div class="week-fields" id="before_discount_{{$j}}_{{$key}}">----</div>
                                        <div class="week-fields" id="total_discount_{{$j}}_{{$key}}">----</div>
                                        <div>
                                            {{ Form::text('final_price_'.$j.'_'.$key, old('final_price_'.$j.'_'.$key), ['class' => 'form-control final_price_class week-fields', 'id' => 'final_price_'.$j.'_'.$key]) }}
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<button class="btn success-btn mt-3"id="btn-save">Edit/Save</button>
