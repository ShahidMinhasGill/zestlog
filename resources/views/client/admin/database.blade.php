@extends('client.admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <nav>
                <div class="nav nav-pills" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-Programs-tab" data-toggle="tab" href="#nav-Programs" role="tab" aria-controls="nav-Programs" aria-selected="true">Programs</a>

                    <a class="nav-item nav-link" id="nav-Exercise-tab" data-toggle="tab" href="#nav-Exercise" role="tab" aria-controls="nav-Exercise" aria-selected="false">Exercise</a>

                    <a class="nav-item nav-link" id="nav-Food-tab" data-toggle="tab" href="#nav-Food" role="tab" aria-controls="nav-Food" aria-selected="false">Food</a>

                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-Programs" role="tabpanel" aria-labelledby="nav-Programs-tab">
                    @include('client.admin.partials.database-partials._programs-tabcontent')
                </div>

                <div class="tab-pane fade" id="nav-Exercise" role="tabpanel" aria-labelledby="nav-Exercise-tab">
                    Exercise
                </div>

                <div class="tab-pane fade" id="nav-Food" role="tabpanel" aria-labelledby="nav-Food-tab">
                    @include('client.admin.partials.database-partials._food-table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection