@extends('admin.layouts.app')
@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="mr-3">
                    <span class="header-avtar">
                        @if(isset($userProfile['profile_pic_upload']) && !empty($userProfile['profile_pic_upload']))
                            <img src="{{asset(MobileUserImagePath.'/'.$userProfile['profile_pic_upload'])}}"
                                 alt="profile-pic.png">
                        @else<img src="http://127.0.0.1:8000/assets/images/profile-pic.png" alt="profile-pic.png">
                        @endif
                    </span>
                </div>
                <h2 class="pagetitle full_name_display"id="full_name_display">{{$userProfile['first_name']}} {{$userProfile['last_name']}}</h2>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <nav>
                <div class="nav nav-pills" role="tablist">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#enduser-account" role="tab" aria-controls="enduser-account" aria-selected="true">Account</a>

                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="enduser-account" role="tabpanel" aria-labelledby="enduser-account-tab">
                    <!-- enduser account inner tab -->
                    <nav class="inner-tab">
                        <div class="nav nav-pills" role="tablist">
                            <a class="nav-item nav-link active" data-toggle="tab" href="#enduser-profile" role="tab" aria-controls="enduser-profile" aria-selected="true">Profile</a>

                            <a class="nav-item nav-link" data-toggle="tab" href="#enduser-security" role="tab" aria-controls="enduser-security" aria-selected="false">Security</a>

                            <a class="nav-item nav-link" data-toggle="tab" href="#enduser-identity" role="tab" aria-controls="enduser-identity" aria-selected="false">Identity Verification</a>

                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="enduser-profile" role="tabpanel" aria-labelledby="enduser-profile-tab">
                            @include('admin.endusers.partials._enduser-profile-tab-content')
                        </div>

                        <div class="tab-pane fade" id="enduser-security" role="tabpanel" aria-labelledby="enduser-security-tab">
                            @include('admin.endusers.partials._enduser-security-tab-content')
                        </div>

                        <div class="tab-pane fade" id="enduser-identity" role="tabpanel" aria-labelledby="enduser-identity-tab">
                            @include('admin.endusers.partials._enduser-identity-tab-content')
                        </div>
                    </div>
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
        $renderRoute = '{{ URL::route('end-user.get.users.data') }}';
        $identityRout = '{{ URL::route('save.end-user.identity.data') }}';
        $increaseImageSize = '{{ URL::route('education.certificate') }}';
        $editRoute = '{{ URL::route('end-users.edit', ['end_user' => 0]) }}';
        $editRoute = $editRoute.substr(0, $editRoute.lastIndexOf("/"));
        $editMobileRoute = '{{ URL::route('edit.mobile.data') }}';
        $deleteRoute = '{!! URL::route('end-users.destroy', ['end_user' => 0]) !!}';
        $defaultType = 'renderEndUsers';
        $token = "{{ csrf_token() }}";
        $page = 1;
        $search = '';
        $asc = 'asc';
        $desc = 'desc';
        $sortType  = 'desc';
        $sortColumn = 'a.id';
        $dropDownFilters = {};
        $accountRegDate = '';
        $lastLogin = '';
        $birthDay = '';
        $bmi = '';
        $userId = $.parseJSON('{!! $user['id'] !!}');
        $timeSpent= '';
        $EndUserIdentityDetails = {};

        $(document).ready(function() {
            $('.identity-information').prop("disabled", true);
            $('.edit-mobile-number').prop("disabled", true);
        });
        $('body').on('click','#end-user-identity-edit', function () {

            if($('#end-user-identity-edit').html() == 'Save'){

                $('.identity-information').each(function (index, obj) {
                    let id = this.id;
                    if (id == 'is_identity_verify') {
                        if ($(this).is(':checked')) {
                            $EndUserIdentityDetails['' + id] = 1;
                        } else {
                            $EndUserIdentityDetails['' + id] = 2;
                        }
                    } else {
                        $EndUserIdentityDetails['' + id] = $('#' + id).val();
                    }
                });
                $formData = {
                    '_token': $token,
                    identity_data:$EndUserIdentityDetails,
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
                                $('.' + index).html(value);
                            }else if (index == 'user-age') {
                                $('.' + index).html(value);
                            }
                        });
                        $('.identity-information').prop("disabled", true);
                        $('#end-user-identity-edit').html('Edit');
                    },
                    error: function ($error) {
                    }
                });
            }else{
                $('.identity-information').prop("disabled", false);
                $('#end-user-identity-edit').html('Save');
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
        $('body').on('click', '#edit_security', function () {

            if($('#edit_security').html() == 'Save'){
                $mobileNumber = $('#txt_mobile').val();
                $email = $('#txt_email').val();
                $countryCode = $('#country-code').val();
                $formData = {
                    '_token': $token,
                    user_id:$userId,
                    mobile_number:$mobileNumber,
                    email:$email,
                    country_code:$countryCode,
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
            }else{
                $('.edit-mobile-number').prop("disabled", false);
                $('#edit_security').html('Save');
            }

        });
    </script>

    {!! Html::script('js/admin.js?id='.version())!!}
@endpush