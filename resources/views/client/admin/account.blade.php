@extends('client.admin.layouts.app')

@section('content')
<div class="page-content">
    @include('client.admin.partials.account-partials._account-head')

    <div class="card">
        <div class="card-body">
            <nav class="clients-nav">
                <div class="nav nav-pills" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-Coaching-tab" data-toggle="tab" href="#nav-Coaching" role="tab" aria-controls="nav-Coaching" aria-selected="true">Coaching & Pt</a>

                    <a class="nav-item nav-link" id="nav-cl-profile-tab" data-toggle="tab" href="#nav-cl-profile" role="tab" aria-controls="nav-cl-profile" aria-selected="false">Profile</a>

                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-Coaching" role="tabpanel" aria-labelledby="nav-Coaching-tab">
                    <!-- nav-Coaching inner tab -->
                    <nav class="inner-tab">
                        <div class="nav nav-pills" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-Active-tab" data-toggle="tab" href="#nav-Active" role="tab" aria-controls="nav-Active" aria-selected="true">Active</a>

                            <a class="nav-item nav-link" id="nav-Waiting-tab" data-toggle="tab" href="#nav-Waiting" role="tab" aria-controls="nav-Waiting" aria-selected="false">Waiting</a>

                            <a class="nav-item nav-link" id="nav-Archived-tab" data-toggle="tab" href="#nav-Archived" role="tab" aria-controls="nav-Archived" aria-selected="false">Archived</a>

                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-Active" role="tabpanel" aria-labelledby="nav-Active-tab">
                            @include('client.admin.partials.account-partials._active-tabcontent')
                        </div>

                        <div class="tab-pane fade" id="nav-Waiting" role="tabpanel" aria-labelledby="nav-Waiting-tab">
                            @include('client.admin.partials.account-partials._waiting-tabcontent')
                        </div>

                        <div class="tab-pane fade" id="nav-Archived" role="tabpanel" aria-labelledby="nav-Archived-tab">
                            @include('client.admin.partials.account-partials._archived-tabcontent')
                        </div>
                    </div>
                    <!-- End nav-Coaching inner tab -->
                </div>
                <div class="tab-pane fade" id="nav-cl-profile" role="tabpanel" aria-labelledby="nav-cl-profile-tab">
                    <!-- nav-cl-profile inner tab -->
                    <nav class="inner-tab">
                        <div class="nav nav-pills" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-account-tab" data-toggle="tab" href="#nav-account" role="tab" aria-controls="nav-account" aria-selected="true">Account</a>

                            <a class="nav-item nav-link" id="nav-Academic-tab" data-toggle="tab" href="#nav-Academic" role="tab" aria-controls="nav-Academic" aria-selected="false">Academic</a>

                            <a class="nav-item nav-link" id="nav-Payouts-tab" data-toggle="tab" href="#nav-Payouts" role="tab" aria-controls="nav-Payouts" aria-selected="false">Payouts</a>

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
                                            @include('client.admin.partials.account-partials._persnoal-info-tabcontent')
                                        </div>

                                        <div class="tab-pane fade" id="nav-acc-login" role="tabpanel" aria-labelledby="nav-acc-login-tab">
                                            @include('client.admin.partials.account-partials._account-login-tabcontent')
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 text-center">
                                    <div class="acc-por-pic mb-4">
                                        <img src="{{asset('assets/images/profile-pic.png')}}" alt="profile-pic">
                                    </div>
                                </div>
                            </div>
                            <!-- Account inner tab end -->
                        </div>

                        <div class="tab-pane fade" id="nav-Academic" role="tabpanel" aria-labelledby="nav-Academic-tab">
                            @include('client.admin.partials.account-partials._academic-tabcontent')
                        </div>

                        <div class="tab-pane fade" id="nav-Payouts" role="tabpanel" aria-labelledby="nav-Payouts-tab">
                            @include('client.admin.partials.account-partials._payout-tabcontent')
                        </div>
                    </div>
                    <!-- End nav-cl-profile inner tab -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection