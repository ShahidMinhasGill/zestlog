@extends('client.admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <h1 class="pagetitle">Coaching & PT Clients</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <nav>
                <div class="nav nav-pills" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-Active-tab" data-toggle="tab" href="#nav-Active" role="tab" aria-controls="nav-Active" aria-selected="true">Active</a>

                    <a class="nav-item nav-link" id="nav-Waiting-tab" data-toggle="tab" href="#nav-Waiting" role="tab" aria-controls="nav-Waiting" aria-selected="false">Waiting</a>

                    <a class="nav-item nav-link" id="nav-Archived-tab" data-toggle="tab" href="#nav-Archived" role="tab" aria-controls="nav-Archived" aria-selected="false">Archived</a>

                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-Active" role="tabpanel" aria-labelledby="nav-Active-tab">
                    @include('client.admin.partials.clients-partials._active-tabcontent')
                </div>

                <div class="tab-pane fade" id="nav-Waiting" role="tabpanel" aria-labelledby="nav-Waiting-tab">
                    @include('client.admin.partials.clients-partials._waiting-tabcontent')
                </div>

                <div class="tab-pane fade" id="nav-Archived" role="tabpanel" aria-labelledby="nav-Archived-tab">
                    @include('client.admin.partials.clients-partials._archived-tabcontent')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection