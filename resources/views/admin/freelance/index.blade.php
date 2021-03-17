@extends('admin.layouts.app')
<style>
    thead tr th select {
    min-width: 80px;
}
</style>
@section('content')
    <div class="page-content">
        @include('partials.flash-message')
        <div class="card">
            <div class="card-body">
            <nav>
                    <div class="nav nav-pills" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" data-toggle="tab" href="#freelance-sp" role="tab" aria-controls="freelance-sp" aria-selected="true">Freelance Specialists</a>

                        
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="freelance-sp" role="tabpanel" aria-labelledby="freelance-sp-tab">
                        <!--Start freelance specialists inner tab -->
                        <nav class="inner-tab">
                            <div class="nav nav-pills" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active action_freelance" id="active" value="active" data-toggle="tab" href="#nav-st-active" role="tab" aria-controls="nav-st-active" aria-selected="true">Active</a>
                                <a class="nav-item nav-link action_freelance" id="archived" value="archived" data-toggle="tab" href="#nav-st-archived" role="tab" aria-controls="nav-st-archived" aria-selected="false">Archived</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-st-active" role="tabpanel" aria-labelledby="nav-st-active-tab">
                                <div class="table-responsive">
                                    <table class="freelance-tb table text-center">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">Nr</th>
                                            <th scope="col" class="text-center">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck33">
                                                    <label class="custom-control-label" for="customCheck33"></label>
                                                </div>
                                            </th>
                                            <th scope="col" class="text-center">
                                                Display name
                                                <div class="table-search d-flex mr-2">
                                                    <i class="fas fa-search"></i>
                                                    <input type="text"id="search"name="search" placeholder="Search a name" class="form-control" style="width: 200px;">
                                                </div>
                                            </th>
                                            <th scope="col" class="text-center">
                                                Username
                                                <div class="table-search d-flex mr-2">
                                                    <i class="fas fa-search"></i>
                                                    <input type="text"id="search"name="search" placeholder="Search a name" class="form-control" style="width: 200px;">
                                                </div>
                                            </th>
                                            <th scope="col" class="text-center" id="dateAccountRegister">Signup date
                                                <br>
                                                <input type="date" name="" class="form-control filterDate" id="accountRegDate">
                                            </th>
                                            <!-- <th scope="col" class="text-center">Title</th> -->
                                            <th scope="col" class="text-center">Specialization
                                                <br>{!! Form::select('specializations', $specializations, null , ['class' => 'custom-select drop_down_filters', 'id'=>'specialization_id']) !!}
                                            </th>
                                            <th scope="col" class="text-center">Age
                                                <br><select class="custom-select">
                                                    <option selected>All</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </th>
                                            <th scope="col" class="text-center">Gender
                                                <br><select class="custom-select">
                                                    <option selected>All</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </th>
                                            
                                            <th scope="col" class="text-center">Country
                                                <br>{!! Form::select('country', $countries, null , ['class' => 'custom-select drop_down_filters','id'=>'country','name'=>'country']) !!}
                                            </th>
                                            
                                            <th scope="col" class="text-center">City
                                                <br> {!! Form::select('city', $cities,null, ['class' => 'custom-select form-control drop_down_filters', 'id' => 'city']) !!}
                                            </th>
                                            <th scope="col" class="text-center">Identity
                                                <br><select class="custom-select">
                                                    <option selected>All</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </th>
                                            <th class="text-center" scope="col">Active <br> 
                                            <select class="custom-select">
                                                    <option selected>All</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </th>
                                            <th class="text-center" scope="col">Waiting <br> <select class="custom-select">
                                                    <option selected>All</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </th>
                                           
                                            <th scope="col" class="text-center">Total earnings
                                                <br><select style="width:163px;" class="custom-select">
                                                    <option selected>All</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </th>
                                            <th scope="col" class="text-center">No. of logs
                                                <br><select style="width:163px;" class="custom-select">
                                                    <option selected>All</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </th>
                                            <th scope="col" class="text-center">Last visit
                                                <br>
                                                <input type="date" name="" class="form-control filterDate" id="lastLogin">
                                            </th>

                                            <th scope="col" class="text-center">Time spent(min)
                                                <br><select class="custom-select">
                                                    <option selected>All</option>
                                                    <option value="1">1</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </th>
                                            <th scope="col" class="text-center">Account Status
                                            <br><select class="custom-select">
                                                    <option selected>All</option>
                                                    <option value="1">1</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>

                                            </th>
                                            <th></th>
                                           
                                        </tr>
                                        </thead>
                                         <tbody id="page-data"></tbody>
                                    </table>
                                    <div class="paq-pager"></div>
                                </div>
                            </div>
                        </div>
                        <!--End freelance specialists inner tab -->

                    </div>
                </div>
        </div>
    </div>
    </div>
@endsection
@push('after-scripts')

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript">
        $route = '{{ URL::route('city') }}';
        $renderRoute = '{{ URL::route('freelance-users.get.users.data') }}';
        $editRoute = '{{ URL::route('freelance-specialists.edit', ['freelance_specialist' => 0]) }}';
        $editRoute = $editRoute.substr(0, $editRoute.lastIndexOf("/"));
        $editRoute = $editRoute.substr(0, $editRoute.lastIndexOf("/"));
        $deleteRoute = '{!! URL::route('freelance-specialists.destroy', ['freelance_specialist' => 0]) !!}';
        $defaultType = 'renderFreelanceUser';
        $token = "{{ csrf_token() }}";
        $page = 1;
        $search = '';
        $asc = 'asc';
        $desc = 'desc';
        $sortType = 'desc';
        $sortColumn = 'a.id';
        $dropDownFilters = {};
        $action_freelance = '';
        $accountRegDate = '';
        $lastLogin = '';
        $(document).ready(function () {
            oncall();
            $('#search').val('');
            $(".action_freelance").click(function (e) {
                e.preventDefault();
                $action_freelance = $(this).attr('id');
                oncall();
            });
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
                            // alert(data.msg);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });

            });
        });

        function oncall() {
            updateFormData();
            $type = $defaultType;
            renderAdmin();
        }

        var updateFormData = function () {
            $formData = {
                '_token': $token,
                page: $page,
                search: $search,
                sortType: $sortType,
                sortColumn: $sortColumn,
                dropDownFilters: $dropDownFilters,
                action_freelance: $action_freelance,
                accountRegDate:$accountRegDate,
                lastLogin:$lastLogin
            };
        }
    </script>
    {!! Html::script('js/admin.js?id='.version())!!}
   @endpush