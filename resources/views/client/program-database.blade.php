@extends('client.layouts.app')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <nav>
                <div class="nav nav-pills" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-t-programs-tab" data-toggle="tab" href="#nav-t-programs" role="tab" aria-controls="nav-t-programs" aria-selected="true">Training Programs</a>

                    <a class="nav-item nav-link" id="nav-n-programs-tab" data-toggle="tab" href="#nav-n-programs" role="tab" aria-controls="nav-n-programs" aria-selected="false">Nutrition Programs</a>

                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-t-programs" role="tabpanel" aria-labelledby="nav-t-programs-tab">
                    Training Programs
                </div>
                <div class="tab-pane fade" id="nav-n-programs" role="tabpanel" aria-labelledby="nav-n-programs-tab">
                    @include('client.partials.program-database-partials._nutrition-programs')
                </div>
            </div>
        </div>
    </div>

    <!-- plan creator -->
    <div class="card">
        <div class="card-body">
            <h1 class="pagetitle">Plan Creator</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row pb-3 mb-5 border-bottom">
                <div class="col-md-6 col-lg-4 mr-auto">
                    <form action="">
                        <div class="form-group row">
                            <label for="title" class="col-sm-4 col-form-label">Title</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="title">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-sm-4 col-form-label">Category</label>
                            <div class="col-sm-8">
                                <p>Nutrition/ Diet </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-sm-4 col-form-label">For</label>
                            <div class="col-sm-8">
                                <p>One week</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-sm-4 col-form-label">Access</label>
                            <div class="col-sm-8">
                                <select class="custom-select">
                                    <option selected="">Private</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-sm-4 col-form-label">Description</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6 col-lg-4 text-left text-md-right">
                    <button class="btn success-btn mr-2"> Add this plan to library </button>
                    <a href="" class="link-danger">Cancel</a>
                </div>
            </div>
            <!-- Diet week plan -->
            <div class="row">
                <div class="col-md-6 border-right">

                    <div class="clearfix mb-3">
                        <button class="btn success-btn sm-btn mr-2" data-toggle="modal" data-target="#diet-plan-setup">Setup/Edit</button>
                        @include('client.partials.program-database-partials._diet-plan-setup-popup')

                        <button class="btn secondary-btn sm-btn" data-toggle="modal" data-target="#diet-week-import">Import</button>

                        @include('client.partials.program-database-partials._diet-week-import')
                    </div>

                    <div class="diet-week-plan week-plan accordion" id="accordionExample">

                        @include('client.partials.program-database-partials._diet-plans')

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="food-details-wrapper">
                        <div class="food-details-head mb-3">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="table-search d-flex mr-2">
                                        <i class="fas fa-search"></i>
                                        <input type="text" placeholder="Search a food" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3 d-flex align-items-center justify-content-around">
                                    <a href="">
                                        <i class="far fa-bookmark fa-lg"></i>
                                    </a>
                                    <a href="">
                                        <i class="fas fa-globe-americas fa-lg"></i>
                                    </a>
                                    <select class="custom-select" style="width:65px; float: right;">
                                        <option selected>No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @include('client.partials.nutrition-tab-partials._nutritional-foods-table')
                    </div>
                </div>
            </div>
            <!--End Diet week plan -->
        </div>
    </div>


    <!-- End plan creator -->
</div>
@endsection