
@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="mr-3">
                    <span class="header-avtar">
                        @if(!empty($user['profile_pic_upload']))
                            <img class="rounded-circle" src="{{asset(clientImagePath.'/'.$user['profile_pic_upload'])}}" alt="profile-pic.png">
                        @else
                            <img src="{{asset('assets/images/profile-pic.png')}}" alt="profile-pic.png">
                        @endif
                    </span>
                </div>
                <h2 class="pagetitle">{{$user['first_name']}} {{$user['last_name']}}</h2>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <nav>
                <div class="nav nav-pills" id="nav-tab" role="tablist">
                    {{--<a class="nav-item nav-link active" data-toggle="tab" href="#clients" role="tab" aria-controls="clients" aria-selected="true">Clients</a>--}}
                    <a class="nav-item nav-link active" id="account-tab" data-toggle="tab" href="#Account" role="tab" aria-controls="Account" aria-selected="true">Account</a>

                    <a class="nav-item nav-link" id="academic-tab" data-toggle="tab" href="#Academic" role="tab" aria-controls="Academic" aria-selected="true">Academic</a>
                    @if(!isLightVersion())
                    <a class="nav-item nav-link" id="earnings-tab" data-toggle="tab" href="#Earnings" role="tab" aria-controls="Earnings" aria-selected="true">Earnings</a>
                    @endif
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="clients" role="tabpanel" aria-labelledby="clients-tab">
                        @include('client.account.partials._account-tab-content')
                    </div>

                    <div class="tab-pane fade" id="Academic" role="tabpanel" aria-labelledby="Academic-tab">
                    @include('client.account.partials._academic-tab-content')
                    </div>

                    <div class="tab-pane fade" id="Earnings" role="tabpanel" aria-labelledby="Earnings-tab">
                    @include('client.account.partials._earnings-tab-content')
                    </div>

                    <div class="tab-pane fade" id="Account" role="tabpanel" aria-labelledby="Account-tab">
                    @include('client.account.partials._account-tab-content')
                    </div>

            </div>
        </div>
    </div>
</div>

@endsection
@push('after-scripts')

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" type="text/css" href="{!! asset('css/fancybox/jquery.fancybox.css') !!}"/>
    {!! Html::script('js/fancybox/jquery.fancybox.js') !!}
    {!! Html::script('js/fancybox/jquery.fancybox.pack.js') !!}
    <script type="text/javascript">
        $route = '{{ URL::route('city') }}';
        $identityRout = '{{ URL::route('save.identity.data') }}';
        $educationVerifyRout = '{{ URL::route('client.education.verify') }}';
        $FreelanceBankAccount = '{{ URL::route('freelance-bank-account') }}';
        $bookingInformationRout = '{{ URL::route('user.booking.information') }}';
        $defaultType = 'renderFreelanceUser';
        $token = "{{ csrf_token() }}";
        $page = 1;
        $search = '';
        $asc = 'asc';
        $desc = 'desc';
        $sortType = 'desc';
        $sortColumn = 'a.id';
        $dropDownFilters = {};
        $action_freelance = '';
        $accountRegDate = '';
        $lastLogin = '';
        $identitydata = {};
        $is_education_verify = {};
        $SpecializationDetails = {};
        $userId = $.parseJSON('{!! $user['id'] !!}');
        $(document).ready(function () {
            $('.identity-information').prop("disabled", true);
            $('.acadmic-information').prop("disabled", true);
            $('.bank-information').prop("disabled", true);
            $('.nav-item').click(function () {
                let id = this.id;
                if (id == 'account-tab') {
                    location.reload();
                }
            });
        });

        $('body').on('click', '#identity-edit', function () {

            if($('#identity-edit').html() == 'Save'){

                $('.identity-information').each(function (index, obj) {
                    let id = this.id;
                    if (id == 'verified1') {
                        if ($(this).is(':checked')) {
                            $identitydata['' + id] = 1;
                        } else {
                            $identitydata['' + id] = 2;
                        }
                    } else {
                        $identitydata['' + id] = $('#' + id).val();
                    }
                });
                $formData = {
                    '_token': $token,
                    identity_data:$identitydata,
                    user_id:$userId
                };
                ajaxStartStop();
                $.ajax({
                    url: $identityRout,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                    },
                    error: function ($error) {
                    }
                });
            }else{
                $('.identity-information').prop("disabled", false);
                $('#identity-edit').html('Save');
            }

        });

        $('body').on('click', '#acadmic-btn-edit', function () {

            if($('#acadmic-btn-edit').html() == 'Save'){

                $('.is-verify-education').each(function (index, obj) {
                    let id = this.id;
                    id = id.split('_')[1];
                    if ($(this).is(':checked')) {
                        $is_education_verify['' + id] = 1;
                    }
                });
                $('.acadmic-information').each(function (index, obj) {
                    let id = this.id;
                    id = id.split('_')[2];
                    $SpecializationDetails['education_title_'+id] = $('#education_title_'+id).val();
                    $SpecializationDetails['education_from_'+id] = $('#education_from_'+id).val();
                });
                $formData = {
                    '_token': $token,
                    is_education_verify:$is_education_verify,
                    user_id:$userId,
                    SpecializationDetails:$SpecializationDetails,
                    dropDownFilters:$dropDownFilters
                };
                ajaxStartStop();
                $.ajax({
                    url: $educationVerifyRout,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                    },
                    error: function ($error) {
                    }
                });
            }else{
                $('.acadmic-information').prop("disabled", false);
                $('.is-verify-education').each(function (index, obj) {
                    let id = this.id;
                    id = id.split('_')[1];
                    if ($(this).is(':checked')) {
                        $('.is-already-verify_'+id).prop("disabled", true);
                    }
                });
                $('#acadmic-btn-edit').html('Save');
            }
        });

        $('body').on('click', '#bank-account-edit', function () {

            if($('#bank-account-edit').html() == 'Save'){

                $('.bank-information')
                    let id = this.id;
                    $accountHolder = $('#account_holder').val();
                    $accountNumber = $('#account_number').val();
                    $BicCode = $('#bic_code').val();
                    $Swift = $('#swift').val();
                    $accountName = $('#account_name').val();
                ;
                $formData = {
                    '_token': $token,
                    user_id:$userId,
                    account_holder:$accountHolder,
                    account_number:$accountNumber,
                    bic_code:$BicCode,
                    swift:$Swift,
                    account_name:$accountName
                };
                ajaxStartStop();
                $.ajax({
                    url: $FreelanceBankAccount,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                    },
                    error: function ($error) {
                    }
                });
            }else{
                $('.bank-information').prop("disabled", false);

                $('#bank-account-edit').html('Save');
            }
        });
        $('body .drop_down_filters-specialization').change(function () {
            $dropDownFilters = {};
            var inputs = $(".drop_down_filters-specialization");
            for (var i = 0; i < inputs.length; i++) {
                $dropDownFilters[$(inputs[i]).attr('id')] = $(inputs[i]).val();
            }
        });
        $('body').on('click', '.bookings-description', function () {
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
    </script>
    {!! Html::script('js/admin.js?id='.version())!!}
@endpush
