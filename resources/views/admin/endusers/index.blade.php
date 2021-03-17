@extends('admin.layouts.app')
<style>
    .width100 {
        width: 100px;
    }
    thead tr th select {
        min-width: 80px;
    }

    .table-search {
        width: 163px;
    }
</style>
@section('content')
    <div class="page-content">
        @include('admin.partials._endusers-head')

        <div class="card">
            <div class="card-body">
                <div class="end-users-table tableFixHead table-responsive">
                    <table class="freelance-tb table text-center">
                        <thead class="thead-light">
                        <tr>
                            <th >Nr</th>
                            <th >
                                <div class="custom-control custom-checkbox float-left">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1"></label>
                                </div>
                            </th>

                            <th >
                                Full name
                                <div class="table-search d-flex mr-2">
                                    <i class="fas fa-search"></i>
                                    <input type="text" placeholder="Search a name"  name="search" id="search" class="form-control" >
                                </div>
                            </th>
                            <th >
                                Username
                                <div class="table-search d-flex mr-2">
                                    <i class="fas fa-search"></i>
                                    <input type="text" placeholder="Search a name" name="search-display_name" id="search_display_name" class="form-control" >
                                </div>
                            </th>
                            <th >Signedup date
                               <br><input type="date" name="" class="form-control filterDate" id="accountRegDate">
                            </th>
                            <th >Age
                                <br> {!! Form::select('age', $age,null, ['class' => 'custom-select form-control drop_down_filters', 'id' => 'age']) !!}

                            </th>
                            <th >Gender
                                <br><select  class="custom-select drop_down_filters" id="gender">
                                    <option selected=""value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </th>
                            <th >Country
                                <br>{!! Form::select('country', $countries, null , ['class' => 'custom-select drop_down_filters','id'=>'country','name'=>'country']) !!}
                            </th>
                            <th >City
                                <br> {!! Form::select('city', $cities,null, ['class' => 'custom-select form-control drop_down_filters', 'id' => 'cityList']) !!}
                            </th>
                            <th >1iPartner
                                <br><select  class="custom-select drop_down_filters"id="is_3i_partner">
                                    <option selected=""value="">All</option>
                                    <option value="1">1iPartner</option>
                                    <option value="0">Not 1iPartner</option>
                                </select>
                            </th>
                            <th >Identity
                                <br><select  class="custom-select drop_down_filters"id="identity">
                                    <option selected=""value="">All</option>
                                    <option value="1">Verified</option>
                                    <option value="0">Pending</option>
                                    <option value="2">Not Verified</option>
                                </select>
                            </th>
                            <th >Coach channel
                                <br><select  class="custom-select drop_down_filters"id="coach_channel">
                                    <option selected=""value="">All</option>
                                    <option value="1">Activated</option>
                                    <option value="0">Not Activated</option>
                                </select>
                            </th>
                            <th >No. of bookings
                                <br><select  class="custom-select drop_down_filters"id="no_of_booking">
                                    <option selected=""value="">All</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2-5</option>
                                    <option value="3">6-10</option>
                                    <option value="4">More than 10</option>
                                </select>
                            </th>
                            <th >No. of logs
                                <br><select  class="custom-select drop_down_filters"id="no_of_log">
                                    <option selected=""value="">All</option>
                                    <option value="0">0</option>
                                    <option value="1">1-10</option>
                                    <option value="2">11-100</option>
                                    <option value="3">Above 100</option>
                                </select>
                            </th>
                            <th >Last visit
                                <br><input type="date" name="" class="form-control" value="dd/mm/yyyy"id="lastLogin">
                            </th>
                           
                            <th >Time Spent (min)
                                <input type="text" placeholder="" name="search" id="timeSpent" class="form-control">
                            </th>
                            <th >Status
                                <br><select  class="custom-select drop_down_filters"id="status">
                                    <option selected=""value="">Select</option>
                                    <option value="1">Active</option>
                                    <option value="2">Deactivate</option>
                                </select>
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="page-data"></tbody>
                    </table>

                </div>
            </div>
            <div class="paq-pager"></div>
        </div>
    </div>
@endsection
@push('after-scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript">
        $route = '{{ URL::route('city') }}';
        $renderRoute = '{{ URL::route('end-user.get.users.data') }}';
        $identityRout = '{{ URL::route('save.identity.data') }}';
        $editRoute = '{{ URL::route('end-users.edit', ['end_user' => 0]) }}';
        $editRoute = $editRoute.substr(0, $editRoute.lastIndexOf("/"));
        $editRoute = $editRoute.substr(0, $editRoute.lastIndexOf("/"));
        $deleteRoute = '{!! URL::route('end-users.destroy', ['end_user' => 0]) !!}';
        $defaultType = 'renderEndUsers';
        $token = "{{ csrf_token() }}";
        $page = 1;
        $search = '';
        $asc = 'asc';
        $desc = 'desc';
        $sortType  = 'desc';
        $sortColumn = 'a.id';
        $dropDownFilters = {};
        $accountRegDate = '';
        $lastLogin = '';
        $birthDay = '';
        $bmi = '';
        $timeSpent= '';
        $searchUserName= '';
        $(document).ready(function() {
            updateFormData();
            $type = $defaultType;
            renderAdmin();
            $('#search').val('');
            $('#accountRegDate').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $accountRegDate = $(this).val();
                    $page = 1;
                    updateFormData();
                    $type = $defaultType;
                    renderAdmin();
                }
            });

            $('#lastLogin').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $lastLogin = $(this).val();
                    $page = 1;
                    updateFormData();
                    $type = $defaultType;
                    renderAdmin();
                }
            });
            $('#birthDay').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $birthDay = $(this).val();
                    $page = 1;
                    updateFormData();
                    $type = $defaultType;
                    renderAdmin();
                }
            });
            $('#bmi').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $bmi = $(this).val();
                    $page = 1;
                    updateFormData();
                    $type = $defaultType;
                    renderAdmin();
                }
            });
            $('#search_display_name').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $searchUserName = $(this).val();
                    $page = 1;
                    updateFormData();
                    $type = $defaultType;
                    renderAdmin();
                }
            });
            $('#timeSpent').keydown(function (e) {
                if (e.keyCode == 13) {
                    event.preventDefault();
                    $timeSpent = $(this).val();
                    $page = 1;
                    updateFormData();
                    $type = $defaultType;
                    renderAdmin();
                }
            });
            $('#country').on('change', function () {
                $('#cityList').empty();
                $.ajax({
                    type: 'POST',
                    url: $route,
                    data: {
                        '_token': $token,
                        'cca3': this.value
                    },
                    success: function (data) {
                        if (data.code == 200) {
                            data.cityList.forEach(function (obj) {
                                $('#cityList').append(new Option(obj.city, obj.code));

                            });
                        } else {
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });

            });
        });
        $('body').on('click','#end-user-identity-edit', function () {
            // alert(789);
        });
        var updateFormData = function () {
            $formData = {
                '_token': $token,
                page:  $page,
                search: $search,
                sortType: $sortType,
                sortColumn: $sortColumn,
                dropDownFilters: $dropDownFilters,
                accountRegDate:$accountRegDate,
                lastLogin:$lastLogin,
                birthDay:$birthDay,
                bmi:$bmi,
                searchUserName:$searchUserName,
                timeSpent:$timeSpent
            };
        }

    </script>

    {!! Html::script('js/admin.js?id='.version())!!}
@endpush
