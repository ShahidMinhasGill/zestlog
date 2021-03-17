@extends('admin.layouts.app')
@section('content')

<div class="page-content">
    <div class="card">
        <div class="card-body">
        <nav>
            <div class="nav nav-pills admin-schedule-nav" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" data-toggle="tab" href="#past" role="tab" aria-controls="past" aria-selected="true">Past</a>

                <a class="nav-item nav-link" data-toggle="tab" href="#upcoming" role="tab" aria-controls="upcoming" aria-selected="true">Upcoming</a>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="past" role="tabpanel" aria-labelledby="past-tab">
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead class="thead-light">
                            <th>Nr</th>
                            <th><div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk1">
                                    <label class="custom-control-label" for="chk1"></label>
                                </div></th>
                            <th>Schedule for<br>
                                <input type="text" class="form-control" placeholder="dd/mm/yyy">
                            </th>
                            <th>Confirmation<br>
                                <select class="custom-select">
                                <option selected="">All</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                </select>
                            </th>
                            <th>Selected Option<br>
                                <select class="custom-select">
                                <option selected="">All</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                </select>
                            </th>
                            <th>Client's rating<br>
                                <select class="custom-select">
                                <option selected="">All</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                </select>
                            </th>
                            <th>Cost of Appointment<br>
                                <select class="custom-select">
                                <option selected="">All</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                </select>
                            </th>
                            <th>Service<br>
                                <select class="custom-select">
                                <option selected="">All</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                </select>
                            </th>
                            <th>Partner Username<br>
                            <div class="table-search d-flex mr-2">
                                <i class="fas fa-search"></i>
                                <input type="text" id="search" name="search" placeholder="Search a name" class="form-control">
                            </div>
                            </th>
                            <th>Client Username<br>
                            <div class="table-search d-flex mr-2">
                                <i class="fas fa-search"></i>
                                <input type="text" id="search" name="search" placeholder="Search a name" class="form-control">
                            </div>
                            </th>
                            <th>Booking from</th>
                            <th>Status</th>
                        </thead>

                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="Riview2">
                                    <label class="custom-control-label" for="Riview2"></label>
                                </div>
                                </td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                                <td></td>
                                <td>USD 2500</td>
                                <td>---</td>
                                <td> <a href="#!">@James.Wrights</a></td>
                                <td> <a href="#!">@smae.nilson</a></td>
                                <td><button" class="btn success-btn sm-btn rounded">Booking</button></td>
                                <td><b>Past</b></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="Riview2">
                                    <label class="custom-control-label" for="Riview2"></label>
                                </div>
                                </td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                                <td></td>
                                <td>USD 2500</td>
                                <td>---</td>
                                <td> <a href="#!">@James.Wrights</a></td>
                                <td> <a href="#!">@smae.nilson</a></td>
                                <td><button" class="btn success-btn sm-btn rounded">Booking</button></td>
                                <td><b>Past</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
            <div class="table-responsive">
                    <table class="table text-center">
                        <thead class="thead-light">
                            <th>Nr</th>
                            <th><div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk2">
                                    <label class="custom-control-label" for="chk2"></label>
                                </div></th>
                            <th>Schedule for<br>
                                <input type="text" class="form-control" placeholder="dd/mm/yyy">
                            </th>
                            
                            <th>Cost of Appointment<br>
                                <select class="custom-select">
                                <option selected="">All</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                </select>
                            </th>
                            <th>Service<br>
                                <select class="custom-select">
                                <option selected="">All</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                </select>
                            </th>
                            <th>Partner Username<br>
                            <div class="table-search d-flex mr-2">
                                <i class="fas fa-search"></i>
                                <input type="text" id="search" name="search" placeholder="Search a name" class="form-control">
                            </div>
                            </th>
                            <th>Client Username<br>
                            <div class="table-search d-flex mr-2">
                                <i class="fas fa-search"></i>
                                <input type="text" id="search" name="search" placeholder="Search a name" class="form-control">
                            </div>
                            </th>
                            <th>Booking from</th>
                            <th>Status</th>
                        </thead>

                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="chk3">
                                    <label class="custom-control-label" for="chk3"></label>
                                </div>
                                </td>
                                <td>---</td>
                                <td>USD 2500</td>
                                <td>---</td>
                                <td> <a href="#!">@James.Wrights</a></td>
                                <td> <a href="#!">@smae.nilson</a></td>
                                <td><button" class="btn success-btn sm-btn rounded">Booking</button></td>
                                <td><b>Upcoming</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
