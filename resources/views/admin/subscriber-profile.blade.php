@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid1">
        @include('admin.partials._subscriber-pro-head')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7 mx-auto">
                        <nav>
                            <div class="nav nav-pills" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-p-info-tab" data-toggle="tab" href="#nav-p-info" role="tab" aria-controls="nav-p-info" aria-selected="true">Personal Info</a>
                                <a class="nav-item nav-link" id="nav-acc-login-tab" data-toggle="tab" href="#nav-acc-login" role="tab" aria-controls="nav-acc-login" aria-selected="false">Account Login</a>

                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-p-info" role="tabpanel" aria-labelledby="nav-home-tab">
                                @include('admin.partials._subscriber-p-info-tabcontent')
                            </div>
                            <div class="tab-pane fade" id="nav-acc-login" role="tabpanel" aria-labelledby="nav-acc-login-tab">
                                @include('admin.partials._subscriber-account-tabcontent')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection