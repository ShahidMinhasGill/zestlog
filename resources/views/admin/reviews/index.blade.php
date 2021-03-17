@extends('admin.layouts.app')
<style>
    thead tr th select {
        min-width: 80px;
    }

    .table-search {
        width: 163px;
    }
</style>
@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <h1 class="pagetitle border-bottom pb-3 mb-3">Reviews</h1>

            <div class="table-responsive">
                <table class="table text-center">
                    <thead class="thead-light">
                        <th>Nr</th>
                        <th>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="Riview1">
                                <label class="custom-control-label" for="Riview1"></label>
                            </div>
                        </th>
                        <th>
                            Client<br>
                            <div class="table-search d-flex mr-2">
                                <i class="fas fa-search"></i>
                                <input type="text" id="search" name="search" placeholder="Search a name" class="form-control table-name-search">
                            </div>
                        </th>
                        <th>
                            Review submission
                            <br>
                            <input type="date" class="form-control" value="dd/mm/yyyy">
                        </th>
                        <th>
                            Booking subtotal
                            <br><select class="custom-select">
                                <option selected="">All</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </th>
                        <th>
                            Partner<br>
                            <div class="table-search d-flex mr-2">
                                <i class="fas fa-search"></i>
                                <input type="text" id="search" name="search" placeholder="Search a name" class="form-control">
                            </div>
                        </th>
                        <th>
                            Public rating<br>
                            <select class="custom-select">
                                <option selected="">All</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </th>
                        <th>Public review</th>
                        <th>
                            Private rating<br>
                            <select class="custom-select">
                                <option selected="">All</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </th>
                        <th>Private review</th>
                        <th>
                            Rating on Zestlog<br>
                            <select class="custom-select">
                                <option selected="">All</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </th>
                        <th> Review on Zestlog</th>
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
                            <td class="text-left">
                                <a href="#!">Samn Nilson</a>
                            </td>
                            <td>-------</td>
                            <td>USD 2500</td>
                            <td>
                                <a href="#!">James Wrights</a>
                            </td>
                            <td>5</td>
                            <td>Great coatch</td>
                            <td>Definitely yes</td>
                            <td>Awesome</td>
                            <td>Definitely yes</td>
                            <td>Love it</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection