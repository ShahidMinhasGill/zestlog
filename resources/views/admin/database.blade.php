@extends('admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <h1 class="pagetitle">Exercise</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="pb-3 mb-3 border-bottom">
                <button class="btn success-btn">Add a new row</button>
                <button class="btn secondary-btn">Bulk upload</button>
            </div>

            @include('admin.partials._database-table')
        </div>
    </div>
</div>
@endsection