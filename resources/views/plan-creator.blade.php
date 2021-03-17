@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="pagetitle">Plan Creator</h1>
                </div>
                <!-- <div class="col-md-6 text-right">
                    <button class="btn outline-btn mr-2" type="submit">Save</button>
                    <a href="{{url('plans')}}" class="link-danger">Cancel</a>
                </div> -->
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @include('partials._create-plan')
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 border-right">
                    @include('partials._weekly-plan')
                </div>

                <div class="col-md-6">
                    @include('partials._search-exercise')
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection