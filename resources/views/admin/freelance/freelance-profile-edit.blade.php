@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="mr-3">
                    <span class="header-avtar">
                        @if(!empty($user['profile_pic_upload']))
                            <img src="{{asset(MobileUserImagePath.'/'.$user['profile_pic_upload'])}}" alt="profile-pic.png">
                        @else
                            <img src="{{asset('assets/images/profile-pic.png')}}" alt="profile-pic.png">
                        @endif
                    </span>
                </div>
                <h2 class="pagetitle full_name_display"id="full_name_display">{{$user['first_name']}} {{$user['last_name']}}</h2>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <nav>
                <div class="nav nav-pills" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#clients" role="tab" aria-controls="clients" aria-selected="true">Clients</a>

                    <a class="nav-item nav-link" data-toggle="tab" href="#Academic" role="tab" aria-controls="Academic" aria-selected="true">Academic</a>

                    <a class="nav-item nav-link" data-toggle="tab" href="#Earnings" role="tab" aria-controls="Earnings" aria-selected="true">Earnings</a>

                    <a class="nav-item nav-link" data-toggle="tab" href="#Account" role="tab" aria-controls="Account" aria-selected="true">Account</a>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="clients" role="tabpanel" aria-labelledby="clients-tab">
                        @include('admin.freelance.partials._clients-tab-content')
                    </div>

                    <div class="tab-pane fade" id="Academic" role="tabpanel" aria-labelledby="Academic-tab">
                    @include('admin.freelance.partials._academic-tab-content')
                    </div>

                    <div class="tab-pane fade" id="Earnings" role="tabpanel" aria-labelledby="Earnings-tab">
                    @include('admin.freelance.partials._earnings-tab-content')
                    </div>

                    <div class="tab-pane fade" id="Account" role="tabpanel" aria-labelledby="Account-tab">
                    @include('admin.freelance.partials._account-tab-content')
                    </div>

            </div>
        </div>
    </div>
</div>

@endsection
@push('after-scripts')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" type="text/css" href="{!! asset('css/fancybox/jquery.fancybox.css') !!}"/>
    {!! Html::script('js/fancybox/jquery.fancybox.js') !!}
    {!! Html::script('js/fancybox/jquery.fancybox.pack.js') !!}
    <script type="text/javascript">
        $route = '{{ URL::route('city') }}';
        $identityRout = '{{ URL::route('save.identity.data') }}';
        $increaseImageSize = '{{ URL::route('education.certificate') }}';
        $educationVerifyRout = '{{ URL::route('client.education.verify') }}';
        $editMobileRoute = '{{ URL::route('edit.mobile.data') }}';
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
        $mobileNumber= '';
        $email = '';
        $userId = $.parseJSON('{!! $user['id'] !!}');
        $(document).ready(function () {
            $('.identity-information').prop("disabled", true);
            $('.acadmic-information').prop("disabled", true);
            $('.edit-mobile-number').prop("disabled", true);
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
                        $.each(response.data, function (index, value) {
                            $('.' + index).val(value);
                            if (index == 'full_name_display') {
                                $('#' + index).html(value);
                            }
                            else if (index == 'user-age') {
                                $('#' + index).html(value);
                            }
                        });
                        $('.identity-information').prop("disabled", true);
                        $('#identity-edit').html('Edit');

                    },
                    error: function ($error) {
                    }
                });
            }else{
                $('.identity-information').prop("disabled", false);
                $('#identity-edit').html('Save');
            }

        });

        $('body').on('click', '#edit_security', function () {

            if ($('#edit_security').html() == 'Save') {
                $mobileNumber = $('#txt_mobile').val();
                $email = $('#txt_email').val();
                $countryCode = $('#country-code').val();
                $formData = {
                    '_token': $token,
                    user_id: $userId,
                    mobile_number: $mobileNumber,
                    email: $email,
                    country_code: $countryCode,
                };
                ajaxStartStop();
                $.ajax({
                    url: $editMobileRoute,
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                        $('.edit-mobile-number').prop("disabled", true);
                        $('#edit_security').html('Edit');

                    },
                });
            } else {
                $('.edit-mobile-number').prop("disabled", false);
                $('#edit_security').html('Save');
            }

        });

        $('body').on('click', '.increase-image-size', function () {
            let id = this.id;
            $path = id.split('_')[0];
            $isPic = id.split('_')[1];
            if($isPic != ''){
                $formData = {
                    '_token': $token,
                    id:$path
                };
                ajaxStartStop();
                $.ajax({
                    url: $increaseImageSize,
                    type: 'POST',
                    data: $formData,
                    success: function (data) {
                        $.fancybox(data.view, {
                            height : 900,
                            width : 1000,
                            fitToView : true,
                            autoSize : false,
                            closeClick: false,
                            closeEffect: false,
                            'autoscale': true,
                            openEffect: 'none',


                        });
                    },
                });
            }

        });

        $('body').on('click', '#acadmic-btn-edit', function () {

            if($('#acadmic-btn-edit').html() == 'Save'){

                $('.is-verify-education').each(function (index, obj) {
                    let id = this.id;
                    id = id.split('_')[1];
                    if ($(this).is(':checked')) {
                        $is_education_verify['' + id] = 1;
                    }else{
                        $is_education_verify['' + id] = 0;
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
                        $('.acadmic-information').prop("disabled", true);
                        $('#acadmic-btn-edit').html('Edit');
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
                        // $('.is-already-verify_'+id).prop("disabled", true);
                    }
                });
                $('#acadmic-btn-edit').html('Save');
            }
        });
        $('body .drop_down_filters-specialization').change(function () {
            $dropDownFilters = {};
            var inputs = $(".drop_down_filters-specialization");
            for (var i = 0; i < inputs.length; i++) {
                $dropDownFilters[$(inputs[i]).attr('id')] = $(inputs[i]).val();
            }
        });
    </script>
    {!! Html::script('js/admin.js?id='.version())!!}
@endpush