<!-- Import selected week to edit modal -->
<div class="modal fade" id="diet-week-import" tabindex="-1" role="dialog" aria-labelledby="import-weekLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-md">
        <div class="modal-content">
            <div class="modal-header modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-table-wrapper table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">
                                <div class="table-search">
                                    <i class="fas fa-search"></i>
                                    <input type="text" placeholder="Search" class="form-control">
                                </div>
                            </th>
                            <th scope="col">Category</th>
                            <th scope="col">For</th>
                            <th scope="col" class="text-center">Created by
                                <br><select class="custom-select">
                                    <option selected>All</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>Fat Loss #1</td>
                            <td>Training</td>
                            <td>One week</td>
                            <td>..........</td>
                            <td>Discription</td>
                        </tr>
                        <tr>
                            <td>Fat Loss #1</td>
                            <td>Training</td>
                            <td>One week</td>
                            <td>..........</td>
                            <td>Discription</td>
                        </tr>
                        <tr>
                            <td>Fat Loss #1</td>
                            <td>Training</td>
                            <td>One week</td>
                            <td>..........</td>
                            <td>Discription</td>
                        </tr>
                        <tr>
                            <td>Fat Loss #1</td>
                            <td>Training</td>
                            <td>One week</td>
                            <td>..........</td>
                            <td>Discription</td>
                        </tr>
                        <tr>
                            <td>Fat Loss #1</td>
                            <td>Training</td>
                            <td>One week</td>
                            <td>..........</td>
                            <td>Discription</td>
                        </tr>
                        <tr>
                            <td>Fat Loss #1</td>
                            <td>Training</td>
                            <td>One week</td>
                            <td>..........</td>
                            <td>Discription</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn primary-btn">Import Selected Week to
                    Edit</button>
            </div>
        </div>
    </div>
</div>

<!--End Import selected week to edit modal -->

<!-- Training plan setup modal -->
<div class="modal fade" id="training-plan-setup" tabindex="-1" role="dialog" aria-labelledby="training-plan-setupLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="section-title mb-4">One week training Plan Setup</h3>

                <div class="training-plan-content">
                    <nav>
                        <div class="nav nav-pills" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-overview-tab" data-toggle="tab" href="#nav-overview" role="tab" aria-controls="nav-overview" aria-selected="true">Overview</a>

                            <a class="nav-item nav-link" id="nav-monday-tab" data-toggle="tab" href="#nav-monday" role="tab" aria-controls="nav-monday" aria-selected="false">Monday</a>

                            <a class="nav-item nav-link" id="nav-Tuesday-tab" data-toggle="tab" href="#nav-Tuesday" role="tab" aria-controls="nav-Tuesday" aria-selected="false">Tuesday</a>

                            <a class="nav-item nav-link" id="nav-Wednsday-tab" data-toggle="tab" href="#nav-Wednsday" role="tab" aria-controls="nav-Wednsday" aria-selected="false">Wednsday</a>

                            <a class="nav-item nav-link" id="nav-Thursday-tab" data-toggle="tab" href="#nav-Thursday" role="tab" aria-controls="nav-Thursday" aria-selected="false">Thursday</a>

                            <a class="nav-item nav-link" id="nav-Firday-tab" data-toggle="tab" href="#nav-Firday" role="tab" aria-controls="nav-Firday" aria-selected="false">Firday</a>

                            <a class="nav-item nav-link" id="nav-Saturday-tab" data-toggle="tab" href="#nav-Saturday" role="tab" aria-controls="nav-Saturday" aria-selected="false">Saturday</a>

                            <a class="nav-item nav-link" id="nav-Sunday-tab" data-toggle="tab" href="#nav-Sunday" role="tab" aria-controls="nav-Sunday" aria-selected="false">Sunday</a>

                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-overview" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="row">
                                <div class="col-lg-12 mx-auto">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5 class="font-weight-bold text-center mb-3">
                                                        Week Days
                                                    </h5>
                                                    <ul class="week-list list-unstyled">
                                                        <li>Monday</li>
                                                        <li>Tuesday</li>
                                                        <li>Wednsday</li>
                                                        <li>Thursday</li>
                                                        <li>Friday</li>
                                                        <li>Saturday</li>
                                                        <li>Sunday</li>
                                                    </ul>
                                                </div>

                                                <div class="col-sm-6">
                                                    <h5 class="font-weight-bold text-center mb-3">
                                                        Day Plan
                                                    </h5>
                                                    <ul class="week-select-list list-unstyled">
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-7">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h5 class="font-weight-bold text-center mb-3">
                                                        Body
                                                        Part 1
                                                    </h5>
                                                    <ul class="week-select-list list-unstyled">
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                    </ul>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h5 class="font-weight-bold text-center mb-3">
                                                        Body
                                                        Part 2
                                                    </h5>
                                                    <ul class="week-select-list list-unstyled">
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                    </ul>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h5 class="font-weight-bold text-center mb-3">
                                                        Body
                                                        Part 3
                                                    </h5>
                                                    <ul class="week-select-list list-unstyled">
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                        <li><select class="custom-select">
                                                                <option selected>Open this select
                                                                    menu
                                                                </option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-8 mx-auto">
                                            <button type="button" class="btn primary-btn btn-block my-3">Apply</button>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>

                        <div class="tab-pane fade" id="nav-monday" role="tabpanel" aria-labelledby="nav-monday-tab">
                            <div class="row">
                                <div class="col-lg-9 mx-auto">
                                    <div class="training-plan-str pb-3 mb-3 border-bottom">
                                        <h3 class="section-title"><small>Monday Training Plan
                                                Structure</small></h3>
                                        <div id='plan-items'>
                                            <div class='col-items col1'>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                    <label class="custom-control-label" for="customCheck1">Warm-up</label>
                                                </div>
                                            </div>
                                            <div class='col-items col2'>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                    <label class="custom-control-label" for="customCheck2">Main workout</label>
                                                </div>
                                            </div>
                                            <div class='col-items col3'>
                                                <span class="plan-navigator">
                                                    <a href="#">
                                                        <i class="fas fa-arrow-up"></i></a>
                                                </span>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck3">
                                                    <label class="custom-control-label" for="customCheck3">Cardio</label>
                                                </div>
                                            </div>
                                            <div class='col-items col4'>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck4">
                                                    <label class="custom-control-label" for="customCheck4">Cool down</label>
                                                </div>
                                            </div>



                                        </div>
                                    </div>

                                    <div class="main-workout-setup">
                                        <h3 class="section-title"><small>Main Work Out Setup</small>
                                        </h3>

                                        <div class="row">
                                            <div class="col-3">
                                                <h5 class="font-weight-bold mb-3">Set Type</h5>
                                                <ul class="setup-list list-unstyled">
                                                    <li>Horizontal set</li>
                                                    <li>Vertical set</li>
                                                    <li>Super set</li>
                                                    <li>Triset</li>
                                                    <li>Triset</li>
                                                    <li>Triset</li>
                                                    <li>Triset</li>
                                                </ul>
                                            </div>

                                            <div class="col-3">
                                                <h5 class="font-weight-bold mb-3">How many Set?</h5>
                                                <ul class="set-list list-unstyled">
                                                    <li>
                                                        <a href="#" class="reorder-up">
                                                            <i class="fas fas fa-minus"></i></a>
                                                        <span>0</span>
                                                        <a href="#" class="reorder-down"><i class="fas fas fa-plus"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="reorder-up"><i class="fas fas fa-minus"></i></a>
                                                        <span>1 </span>
                                                        <a href="#" class="reorder-down"><i class="fas fas fa-plus"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="reorder-up"><i class="fas fas fa-minus"></i></a>
                                                        <span>2 </span>
                                                        <a href="#" class="reorder-down"><i class="fas fas fa-plus"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="reorder-up"><i class="fas fas fa-minus"></i></a>
                                                        <span>3 </span>
                                                        <a href="#" class="reorder-down"><i class="fas fas fa-plus"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="reorder-up"><i class="fas fas fa-minus"></i></a>
                                                        <span>4 </span>
                                                        <a href="#" class="reorder-down"><i class="fas fas fa-plus"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="reorder-up"><i class="fas fas fa-minus"></i></a>
                                                        <span> 5 </span>
                                                        <a href="#" class="reorder-down"><i class="fas fas fa-plus"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="reorder-up"><i class="fas fas fa-minus"></i></a>
                                                        <span> 6 </span>
                                                        <a href="#" class="reorder-down"><i class="fas fas fa-plus"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="col-sm-6 text-center">
                                                <h5 class="font-weight-bold mb-3">How many exercise
                                                    in a Set?</h5>

                                                <ul class="set-list list-unstyled">
                                                    <li>
                                                        <a href="#" class="reorder-up">
                                                            <i class="fas fas fa-minus"></i></a>
                                                        <span>0 </span>
                                                        <a href="#" class="reorder-down"><i class="fas fas fa-plus"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="reorder-up"><i class="fas fas fa-minus"></i></a>
                                                        <span>1 </span>
                                                        <a href="#" class="reorder-down"><i class="fas fas fa-plus"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="reorder-up"><i class="fas fas fa-minus"></i></a>
                                                        <span>2 </span>
                                                        <a href="#" class="reorder-down"><i class="fas fas fa-plus"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="reorder-up"><i class="fas fas fa-minus"></i></a>
                                                        <span>3</span>
                                                        <a href="#" class="reorder-down"><i class="fas fas fa-plus"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="reorder-up"><i class="fas fas fa-minus"></i></a>
                                                        <span>4</span>
                                                        <a href="#" class="reorder-down"><i class="fas fas fa-plus"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="reorder-up"><i class="fas fas fa-minus"></i></a>
                                                        <span>5 </span>
                                                        <a href="#" class="reorder-down"><i class="fas fas fa-plus"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="reorder-up"><i class="fas fas fa-minus"></i></a>
                                                        <span>6 </span>
                                                        <a href="#" class="reorder-down"><i class="fas fas fa-plus"></i>
                                                        </a>
                                                    </li>
                                                </ul>

                                            </div>
                                            <div class="col-12">
                                                <button type="button" class="btn primary-btn btn-block my-3">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-Tuesday" role="tabpanel" aria-labelledby="nav-Tuesday-tab">
                            Tuesday tab content
                        </div>

                        <div class="tab-pane fade" id="nav-Wednsday" role="tabpanel" aria-labelledby="nav-Wednsday-tab">
                            Wednsday tab content
                        </div>

                        <div class="tab-pane fade" id="nav-Thursday" role="tabpanel" aria-labelledby="nav-Thursday-tab">
                            Thursday tab content
                        </div>

                        <div class="tab-pane fade" id="nav-Firday" role="tabpanel" aria-labelledby="nav-Firday-tab">
                            Firday tab content
                        </div>

                        <div class="tab-pane fade" id="nav-Saturday" role="tabpanel" aria-labelledby="nav-Saturday-tab">
                            Saturday tab content
                        </div>
                        <div class="tab-pane fade" id="nav-Sunday" role="tabpanel" aria-labelledby="nav-Sunday-tab">
                            Sunday tab content
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>