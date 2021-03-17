@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <nav>
                        <div class="nav nav-pills" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-account-tab" data-toggle="tab" href="#nav-account" role="tab" aria-controls="nav-account" aria-selected="true">Account</a>

                            <a class="nav-item nav-link" id="nav-Academic-tab" data-toggle="tab" href="#nav-Academic" role="tab" aria-controls="nav-Academic" aria-selected="false">Academic</a>

                            <a class="nav-item nav-link" id="nav-Earnings-tab" data-toggle="tab" href="#nav-Earnings" role="tab" aria-controls="nav-Earnings" aria-selected="false">Earnings</a>

                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-account" role="tabpanel" aria-labelledby="nav-home-tab">
                            <!-- Account inner tab start -->
                            <div class="row">
                                <div class="col-md-6 account-left-col">
                                    <nav class="inner-tab">
                                        <div class="nav nav-pills" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-p-info-tab" data-toggle="tab" href="#nav-p-info" role="tab" aria-controls="nav-p-info" aria-selected="true">Personal Info</a>

                                            <a class="nav-item nav-link" id="nav-acc-login-tab" data-toggle="tab" href="#nav-acc-login" role="tab" aria-controls="nav-acc-login" aria-selected="false">Account Login</a>


                                        </div>
                                    </nav>

                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-p-info" role="tabpanel" aria-labelledby="nav-home-tab">
                                            @include('client.partials._client-p-info-tabcontent')
                                        </div>

                                        <div class="tab-pane fade" id="nav-acc-login" role="tabpanel" aria-labelledby="nav-acc-login-tab">
                                            @include('client.partials._client-account-tabcontent')
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 text-center">
                                    <div class="acc-por-pic mb-4">
                                        <img src="{{asset('assets/images/profile-pic.png')}}" alt="">
                                    </div>
                                    <input type="file" class="btn primary-btn"></input>
                                </div>
                            </div>
                            <!-- Account inner tab end -->
                        </div>

                        <div class="tab-pane fade" id="nav-Academic" role="tabpanel" aria-labelledby="nav-Academic-tab">
                            <div class="row">
                                @include('client.partials._client-academic-tabcontent')
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-Earnings" role="tabpanel" aria-labelledby="nav-Earnings-tab">
                                @include('client.partials._client-earnings-tabcontent')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
