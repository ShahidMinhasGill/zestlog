@extends('client.admin.layouts.app')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <h1 class="pagetitle">Help Desk</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="tableFixHead table-responsive">
                <table class="help-desk-table table">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-left sender-th"><span>Sender</span>
                                <br> <input type="text" class="form-control" placeholder="Search"> </th>
                            <th>Subject</th>
                            <th class="text-center">Sent from
                                <br><select class="custom-select">
                                    <option selected="">All</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </th>
                            <th class="text-center">Date
                                <br><select class="custom-select">
                                    <option selected="">All</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </th>
                            <th class="text-center">Status
                                <br><select class="custom-select">
                                    <option selected="">All</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </th>
                            <th colspan="2">
                                <span class="pl-4">Action</span>
                                <br><select class="custom-select">
                                    <option selected="">All</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>-------------------</td>
                            <td>-------------------</td>
                            <td c class="text-center" lass="text-center">Mobile</td>
                            <td class="text-center">---/----/----</td>
                            <td class="text-center"><strong>New</strong></td>
                            <td class="text-center"></td>
                            <td class="text-right"><i class="fas fa-chevron-right fa-lg"></i></td>
                        </tr>

                        @for($i=0; $i < 10; $i++)
                        <tr>
                            <td>-------------------</td>
                            <td>-------------------</td>
                            <td class="text-center">Mobile</td>
                            <td class="text-center">---/----/----</td>
                            <td class="text-center">Read</td>
                            <td class="text-center">Replied</td>
                            <td class="text-right"><i class="fas fa-chevron-right fa-lg"></i></td>
                        </tr>
                        @endfor

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection