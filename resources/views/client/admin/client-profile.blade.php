@extends('client.admin.layouts.app')

@section('content')
<div class="page-content">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <span class="plan-navigator">
                        <a href="" class="ml-0 primary-link float-none mb-2 d-inline-block">
                            <i class="fas fa-arrow-left mb-0"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @include('client.admin.partials.client-profile-partials._client-pro-head')

            <nav class="clients-nav">
                <div class="nav nav-pills" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-Coaching-tab" data-toggle="tab" href="#nav-Coaching" role="tab" aria-controls="nav-Coaching" aria-selected="true">Coaching &amp; Pt</a>

                    <a class="nav-item nav-link" id="nav-cl-profile-tab" data-toggle="tab" href="#nav-cl-profile" role="tab" aria-controls="nav-cl-profile" aria-selected="false">Profile</a>

                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-Coaching" role="tabpanel" aria-labelledby="nav-Coaching-tab">
                    @include('client.admin.partials.client-profile-partials._coaching-tabcontent')
                </div>

                <div class="tab-pane fade" id="nav-cl-profile" role="tabpanel" aria-labelledby="nav-cl-profile-tab">
                    @include('client.admin.partials.client-profile-partials._profile-tabcontent')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection