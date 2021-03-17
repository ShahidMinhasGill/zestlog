@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="card text-center">
            <div class="card-body">
                <h1 class="mb-0 font-weight-bold">Welcome to Zestlog</h1>
            </div>
        </div>
        <div class="card1 text-center1 ">
    <div class="card">
        <div class="card-body">
    <div class="col-12 mb-5">
        @if(!isLightVersion())
        <div class="invitation-card">
        <strong class="mr-2 mb-1">Your invitation code</strong>
        <input type="text" class="form-control align-content-center" id="invitation_code"
                value="{{@$userInvitation['invitation_code']}}" style="max-width: 200px"><br>
    
                {{--<p  class="mb-1">Signup on Zestlog--}}
                    {{--is by invitation only. Help others join our community.</p>--}}

            @if(@$days > 0 && @$is3iPartner !=1)
                <div>
                    <button class="mb-1 btn primary-btn mr-3 iPartner">Become a 1iPartner</button>

                    <span class="text-danger margin-top" style="padding-left: 9%; padding-top: 2%">{{@$days}}
                        days left</span>
                </div>
            @else
                @if(@$is3iPartner == 1)
                    <strong class="text-success">Congratulations, You are
                        a Zestlog 1iPartner.</strong><br>
                    <strong class="">Continue to enjoy your
                        Free-Forever plan.</strong>
                @elseif(isset($is3iPartner) && $is3iPartner == 0)
                    <strong class="">You missed the opportunity to
                        become a 1iPartner with a Free-Forever plan.</strong>
                @endif
            @endif
                   <div class="table-responsive">
                <table @if(@$days <= 0 || @$is3iPartner == 1) hidden @endif class="table text-center border mt-3">
                    <thead class="thead-light">
                    <th>Nr</th>
                    <th>
                        Name<br>
                        <div class="table-search d-flex mr-2">
                        </div>
                    </th>
                    <th>
                        Username
                        <br>
                    </th>
                    <th>
                        Coach channel
                        <br>
                    </th>
                    <th>
                        Eduction
                        <br>
                    </th>
                    </thead>
                    <tbody>
                    @foreach(@$userDetails as $key => $row)
                        @php($key=$key+1)
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{@$row['first_name']}}</td>
                            <td>{{@$row['user_name']}}</td>
                            @if(isset($row['is_coach_channel']) && $row['is_coach_channel'] == 1)
                                <td>Activated</td>
                            @else
                                <td>Not Activated</td>
                            @endif
                            @if(isset($row['is_verify']) && $row['is_verify'] == 1)
                                <td>Verified</td>
                            @else
                                <td>Not Verified</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div> 
                </div>
                </div>
            @endif
            @if(isLightVersion())
            <h3 class="section-title text-left"> Tutorial </h3>
            @else <h3 class="section-title text-center"> Tutorials </h3> @endif
            @if(!isLightVersion())
            <p style="text-align: center;">These short tutorials are provided as a quick visual guide to get you started.<br/>
            Our Help center will be available soon.</p>
            @endif
        </div>
        @if(!isLightVersion())
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="tuts-card">
                        <p class="font-weight-bold">Settings</p>
                        <div class="tuts-card-body">
                            <video controls controlsList="nodownload" disablePictureInPicture class="home-video">
                                <source src="{{asset('videos/settings.mp4')}}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="tuts-card">
                        <p class="font-weight-bold">Schedule</p>
                        <div class="tuts-card-body">
                            <video controls controlsList="nodownload" disablePictureInPicture class="home-video">
                            <source src="{{asset('videos/schedule.mp4')}}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="tuts-card">
                        <p class="font-weight-bold">@if(isLightVersion()) How to use Zestlog @else Bookings @endif</p>
                        <div class="tuts-card-body">
                            <video controls controlsList="nodownload" disablePictureInPicture class="home-video">
                                @if(isLightVersion()) <source src="{{asset('videos/zestlogs.mp4')}}" type="video/mp4">
                                @else <source src="{{asset('videos/bookings.mp4')}}" type="video/mp4"> @endif
                            {{--<source src="{{asset('videos/bookings.mp4')}}" type="video/mp4">--}}
                            Your browser does not support the video tag.
                        </video>
                        </div>
                    </div>
                </div>
                @if(!isLightVersion())
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="tuts-card">
                        <p class="font-weight-bold">Programs</p>
                        <div class="tuts-card-body">
                            <video controls controlsList="nodownload" disablePictureInPicture class="home-video">
                            <source src="{{asset('videos/program.mp4')}}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        </div>
                    </div>
                </div>
                @endif
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
        $iPartnerRoute = '{{ URL::route('iPartner') }}';
        $token = "{{ csrf_token() }}";
        $(document).ready(function() {

        });
        $('body').on('click', '.iPartner', function () {
            $formData = {
                '_token': $token,
            };
            $.ajax({
                url: $iPartnerRoute,
                type: 'Post',
                data: $formData,
                success: function (response) {
                    $.fancybox(response.view, {
                        width : 900,
                        height : 800,
                        fitToView : true,
                        autoSize : false,
                        closeClick: false,
                        closeEffect: false,
                        'autoscale': false,
                        openEffect: 'none',
                        'scrolling'   : 'no',
                    });
                },
                error: function ($error) {

                }
            });
        });
    </script>
    {!! Html::script('js/admin.js?id='.version())!!}
@endpush

