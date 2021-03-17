@extends('admin.layouts.app')

@section('content')
    <style>
        .earnings-nav.nav-pills .nav-link {
            min-width: 120px;
            text-align: center;
        }
    </style>
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <ul class="earnings-nav nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active action-freelance" id="pending" data-toggle="pill" href="#pills-ern-pending" role="tab" aria-controls="pills-ern-pending" aria-selected="true">Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link action-freelance" id="confirmed" data-toggle="pill" href="#pills-ern-pending" role="tab" aria-controls="pills-ern-confirmed" aria-selected="false">Confirmed</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link action-freelance" id="payouts" data-toggle="pill" href="#pills-ern-pending" role="tab" aria-controls="pills-ern-payouts" aria-selected="false">Paid out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link history-tab" id="history" data-toggle="pill" href="#pills-ern-history" role="tab" aria-controls="pills-ern-history" aria-selected="false">Pay</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-ern-pending" role="tabpanel" aria-labelledby="pills-ern-pending-tab">
                        <h3 class="font-weight-bold mb-3" id="status-name">Funds <small>(pending client's confirmation)</small></h3>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nr</th>
                                    <th scope="col">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1"></label>
                                        </div>
                                    </th>
                                    <th scope="col" class="text-center">Service<br>
                                        <br>{!! Form::select('service', $services, null , ['class' => 'custom-select drop_down_filters', 'id'=>'service_id']) !!}
                                    </th>
                                    <th scope="col">Week of year</th>
                                    <th scope="col">Week of program</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Earning</th>
                                    <th scope="col">Client's <br> confirmation</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"class="hidden"id="paid-out-months">Pay out months</th>
                                    <th scope="col" class="text-center">Coach
                                        <div class="table-search d-flex1 mr-2">
                                            <i class="fas fa-search"></i>
                                            <input type="text" placeholder="Search a name" class="form-control" style="width: 200px;" id="search">
                                        </div>
                                    </th>
                                    <th scope="col">Booking from</th>
                                </tr>
                                </thead>
                                <tbody class=""id="page-data"></tbody>
                            </table>
                        </div>
                        <div class="paq-pager"></div>
                    </div>
                    <div class="tab-pane fade" id="pills-ern-history" role="tabpanel" aria-labelledby="pills-ern-history-tab">
                        <div class="">
                            <h3 class="font-weight-bold mb-3">You can send amount to coaches here</h3>
                            <label>Stripe avaiable balance in <strong>{{@$currency}}</strong></label>
                            <input type="text" placeholder="" class="form-control" style="width: 200px;" id="stripe_balance"value="{{@$balance}}">
                        </div>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nr</th>
                                    <th scope="col">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1"></label>
                                        </div>
                                    </th>
                                    <th scope="col" class="text-center">Coach
                                        <div class="table-search d-flex1">
                                            <i class="fas fa-search"></i>
                                            <input type="text" placeholder="Search a name" class="form-control" style="width: 200px;" id="coach_search">
                                        </div>
                                    </th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Account Available </th>
                                    <th scope="col">Send</th>
                                    {{--<th scope="col">To</th>--}}
                                    {{--<th scope="col">Earning months</th>--}}
                                    {{--<th scope="col">Receipt</th>--}}
                                </tr>
                                </thead>
                                <tbody class=""id="page-data-history"></tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="paq-pager"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="{!! asset('css/fancybox/jquery.fancybox.css') !!}"/>
    {!! Html::script('js/fancybox/jquery.fancybox.js') !!}
    {!! Html::script('js/fancybox/jquery.fancybox.pack.js') !!}
    {!! Html::script('js/jquery.scrollTo-min.js') !!}
    <script>
        $renderRoute = '{{ URL::route('get.partner.earning') }}';
        $bookingInformationRout = '{{ URL::route('user.booking.information') }}';
        $payRout = '{{ URL::route('coach.pay') }}';
        $token = "{{ csrf_token() }}";
        $defaultType = 'renderCoachFunds';
        $page = 1;
        $search = '';
        $coachsearch = '';
        $asc = 'asc';
        $desc = 'desc';
        $sortType  = 'desc';
        $sortColumn = 'a.id';
        $dropDownFilters = {};
        $isImportRender = 0;
        $isMeetingRoute = 0;
        $action_freelance = 'pending';
        $(document).ready(function () {
            $('.hidden').hide();
            updateFormData();
            $type = $defaultType;
            renderClient();
            $('body').on('click', '.action-freelance', function () {
                $action_freelance = this.id;
                if ($action_freelance == 'pending') {
                    $isImportRender = 0;
                    $page = 1;
                    $search = '';
                    $dropDownFilters = {};
                    $('.drop_down_filters').prop('selectedIndex',0);
                    $('#search').val('');
                    $defaultType = 'renderCoachFunds';
                    $('#status-name').html('Funds <small>(pending client\'s confirmation)</small>');
                    $('.hidden').hide();
                } else if ($action_freelance == 'confirmed') {
                    $isImportRender = 0;
                    $page = 1;
                    $dropDownFilters = {};
                    $('.drop_down_filters').prop('selectedIndex',0);
                    $('#search').val('');
                    $search = '';
                    $defaultType = 'renderCoachFunds';
                    $('#status-name').html('Earnings <small>(confirmed by client)</small>');
                    $('#paid-out-months').html('Payout date');
                    $('.hidden').show();
                } else if ($action_freelance == 'payouts') {
                    $isImportRender =0;
                    $dropDownFilters = {};
                    $search = '';
                    $('.drop_down_filters').prop('selectedIndex',0);
                    $('#search').val('');
                    $page = 1;
                    $defaultType = 'renderCoachFunds';
                    $('#paid-out-months').html('Payout date');
                    $('.hidden').show();
                }
                updateFormData();
                $type = $defaultType;
                renderClient();
                // alert($action_freelance);
            });
            $('body').on('click', '.history-tab', function () {
                $page = 1;
                $action_freelance = this.id;
                $isImportRender = 4;
                updateFormData();
                $defaultType = 'renderPay';
                $type = $defaultType;
                renderClient();
                // alert($action_freelance);
            });
            $('body').on('click', '.client-pay', function () {
                var result = confirm(('Are you sure to send amount?'));
                $coachId = this.id;
                $coachId = $coachId.split('_')[1];
                if(result){
                    $formData = {
                        '_token': $token,
                        coach_id:$coachId,
                    };
                    ajaxStartStop();
                    $.ajax({
                        url: $payRout,
                        type: 'POST',
                        data: $formData,
                        success: function (response) {
                           $('#stripe_balance').val(response);
                            $page = 1;
                            $action_freelance = 'history';
                            $isImportRender = 4;
                            updateFormData();
                            $defaultType = 'renderPay';
                            $type = $defaultType;
                            renderClient();
                        },
                        error: function ($error) {
                        }
                    });
                }
            });
            $('body').on('click', '.bookings-description-upcoming', function () {
                $id  = this.id;
                $id = $id.split('-')[1];
                $formData = {
                    '_token': $token,
                    id:$id,
                };
                ajaxStartStop();
                $.ajax({
                    url: $bookingInformationRout,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                        $.fancybox(response.view, {
                            width : 500,
                            height : 600,
                            fitToView : true,
                            autoSize : false,
                            closeClick: false,
                            closeEffect: false,
                            'autoscale': true,
                            openEffect: 'none'
                        });
                    },
                    error: function ($error) {
                    }
                });

            });
        });
        $('#coach_search').keydown(function (e) {
            if (e.keyCode == 13) {
                $page = 1;
                $coachsearch = $(this).val();
                $isImportRender = 4;
                updateFormData();
                $defaultType = 'renderPay';
                $type = $defaultType;
                renderClient();
            }
        });
        /**
         * This is used to update form data
         */

        var updateFormData = function () {
            $formData = {
                '_token': $token,
                // data:  $('#add-form').serialize(),
                page:  $page,
                search: $search,
                sortType: $sortType,
                sortColumn: $sortColumn,
                dropDownFilters: $dropDownFilters,
                action_freelance:$action_freelance,
                coach_search:$coachsearch,
            };
        }
    </script>
    {!! Html::script('js/client.js?id='.version())!!}
@endpush