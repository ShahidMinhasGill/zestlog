<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Nr</th>
                <th scope="col">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck2">
                        <label class="custom-control-label" for="customCheck2"></label>
                    </div>
                </th>
                <th scope="col" class="text-center">
                    <div class="table-search d-flex mr-2">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search a name" class="form-control" style="width: 200px;">
                    </div>
                </th>

                <th scope="col" class="text-center">Date of reg
                    <br><select style="width:80px;" class="custom-select">
                        <option selected="">All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </th>
                <th scope="col" class="text-center">BMI, kg/m2
                    <br><select style="width:80px;" class="custom-select">
                        <option selected="">All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>

                </th>
                <th scope="col" class="text-center">BMI category
                    <br><select style="width:80px;" class="custom-select">
                        <option selected="">All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </th>
                <th scope="col" class="text-center">Country
                    <br><select style="width:80px;" class="custom-select">
                        <option selected="">All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </th>
                <th scope="col" class="text-center">State
                    <br><select style="width:80px;" class="custom-select">
                        <option selected="">All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </th>
                <th scope="col" class="text-center">City
                    <br><select style="width:80px;" class="custom-select">
                        <option selected="">All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </th>
                <th scope="col" colspan="3" class="text-left">Status</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr>
                <th scope="row">1</th>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck2">
                        <label class="custom-control-label" for="customCheck2"></label>
                    </div>
                </td>
                <td class="text-left"><a href="">James Daniels</a></td>
                <td>.../.../...</td>
                <td>24</td>
                <td>Normal</td>
                <td>Norway</td>
                <td>Rogaland</td>
                <td>Rogaland</td>
                <td><span class="badge badge-warning p-2">Waiting</span></td>
                <td>
                    <a href="javascript(:void)" data-toggle="modal" data-target="#program-registration" class="btn sm-btn success-btn rounded">Accept/Reject</a>

                    <div class="modal fade" id="program-registration" tabindex="-1" role="dialog" aria-labelledby="program-registrationLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content text-left">
                                <div class="modal-header modal-header border-0 pb-0">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h3 class="section-title">Client's Program Registration</h3>

                                    <div class="week-plan c-program-accordion accordion" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-block text-left c-program-btn" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        Personal Information
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                <div class="c-program-card card-body">
                                                    <ul class="cl-program-list list-unstyled mb-0">
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Full name</strong></label>
                                                                <span class="float-right right-div">James Anderson</span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Gender</strong></label>
                                                                <span class="float-right right-div">Male</span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Age</strong></label>
                                                                <span class="float-right right-div">34</span>
                                                            </div>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>BMI</strong></label>
                                                                <span class="float-right right-div">27 kg/m2</span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Waist circumference</strong></label>
                                                                <span class="float-right right-div">95cm</span>
                                                            </div>

                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Training age</strong></label>
                                                                <span class="float-right right-div">Less than six months</span>
                                                            </div>

                                                            <div class="list-items clearfix">
                                                                <small>More info</small>
                                                                <div class="form-group">
                                                                    <textarea id="my-textarea" class="form-control" name="" rows="1"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Goal for this program</strong></label>
                                                                <span class="float-right right-div">Improved Helth & Fitness</span>
                                                            </div>
                                                        </li>

                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted"><strong>Additional Details</strong></label>
                                                                <div class="form-group">
                                                                    <textarea id="my-textarea" class="form-control" name="" rows="1"></textarea>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="headingTwo">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-block text-left collapsed c-program-btn" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Training Program
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                <div class="c-program-card card-body">
                                                    <ul class="cl-program-list list-unstyled mb-0">
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Duration</strong></label>
                                                                <span class="float-right right-div">12 weeks</span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Days per week</strong></label>
                                                                <div class="float-right d-block right-div">
                                                                    <p class="mb-0">3 days per week</p>
                                                                    <small>Monday, Wednesday, Saturday</small>

                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Age</strong></label>
                                                                <span class="float-right right-div">34</span>
                                                            </div>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>BMI</strong></label>
                                                                <span class="float-right right-div">27 kg/m2</span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Waist circumference</strong></label>
                                                                <span class="float-right right-div">95cm</span>
                                                            </div>

                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Training age</strong></label>
                                                                <span class="float-right right-div">Less than six months</span>
                                                            </div>

                                                            <div class="list-items clearfix">
                                                                <small>More info</small>
                                                                <div class="form-group">
                                                                    <textarea id="my-textarea" class="form-control" name="" rows="1"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Goal for this program</strong></label>
                                                                <span class="float-right right-div">Improved Helth & Fitness</span>
                                                            </div>
                                                        </li>

                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted"><strong>Additional Details</strong></label>
                                                                <div class="form-group">
                                                                    <textarea id="my-textarea" class="form-control" name="" rows="1"></textarea>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="headingTwo">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-block text-left collapsed c-program-btn" type="button" data-toggle="collapse" data-target="#diet-program" aria-expanded="false" aria-controls="diet-program">
                                                        Diet Program
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="diet-program" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                <div class="c-program-card card-body">
                                                   Diet program content
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="headingThree">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-block text-left c-program-btn collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        Online Coaching
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                <div class="c-program-card card-body">
                                                    <ul class="cl-program-list list-unstyled mb-0">
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Total number of online coaching sessions</strong></label>
                                                                <div class="float-right right-div">
                                                                    <p class="mb-0">24</p>
                                                                    <small>12 weeks, 2 sessions/week</small>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Length of each session</strong></label>
                                                                <div class="float-right d-block right-div">
                                                                    30 minutes
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Number of particiants</strong></label>
                                                                <span class="float-right right-div">1</span>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header" id="headingFour">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-block text-left c-program-btn collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                        Personal Training
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                                <div class="c-program-card card-body">
                                                    <ul class="cl-program-list list-unstyled mb-0">
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Total number of PT sessions</strong></label>
                                                                <div class="float-right right-div">
                                                                    <p class="mb-0">24</p>
                                                                    <small>12 weeks, 2 sessions/week</small>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Training location</strong></label>
                                                                <div class="float-right right-div">
                                                                    <p class="mb-0">SATS Madla</p>
                                                                    <small>Sannergata 6B, 0557 Oslo</small>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Length of each session</strong></label>
                                                                <span class="float-right right-div">60 minutes</span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="list-items clearfix">
                                                                <label class="text-muted float-left left-div"><strong>Number of participants</strong></label>
                                                                <span class="float-right right-div">2</span>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <h4>
                                                <span class="mr-3"><strong>Earning:</strong></span>
                                                <strong>250 USD</strong>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn success-btn">Accept Booking</button>
                                    <a href="javascript(:void)" type="button" class="btn primary-btn" data-dismiss="modal">Reject Booking</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck2">
                        <label class="custom-control-label" for="customCheck2"></label>
                    </div>
                </td>
                <td class="text-left"><a href="">James Daniels</a></td>
                <td>.../.../...</td>
                <td>24</td>
                <td>Normal</td>
                <td>Norway</td>
                <td>Rogaland</td>
                <td>Rogaland</td>
                <td><span class="badge badge-warning p-2">Waiting</span></td>
                <td><span class="btn sm-btn success-btn rounded">Accept/Reject</span></td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck2">
                        <label class="custom-control-label" for="customCheck2"></label>
                    </div>
                </td>
                <td class="text-left"><a href="">James Daniels</a></td>
                <td>.../.../...</td>
                <td>24</td>
                <td>Normal</td>
                <td>Norway</td>
                <td>Rogaland</td>
                <td>Rogaland</td>
                <td><span class="badge badge-warning p-2">Waiting</span></td>
                <td><span class="btn sm-btn success-btn rounded">Accept/Reject</span></td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck2">
                        <label class="custom-control-label" for="customCheck2"></label>
                    </div>
                </td>
                <td class="text-left"><a href="">James Daniels</a></td>
                <td>.../.../...</td>
                <td>24</td>
                <td>Normal</td>
                <td>Norway</td>
                <td>Rogaland</td>
                <td>Rogaland</td>
                <td><span class="badge badge-warning p-2">Waiting</span></td>
                <td><span class="btn sm-btn success-btn rounded">Accept/Reject</span></td>
            </tr>
            <tr>
                <th scope="row">4</th>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck2">
                        <label class="custom-control-label" for="customCheck2"></label>
                    </div>
                </td>
                <td class="text-left"><a href="">James Daniels</a></td>
                <td>.../.../...</td>
                <td>24</td>
                <td>Normal</td>
                <td>Norway</td>
                <td>Rogaland</td>
                <td>Rogaland</td>
                <td><span class="badge badge-warning p-2">Waiting</span></td>
                <td><span class="btn sm-btn success-btn rounded">Accept/Reject</span></td>
            </tr>

        </tbody>
    </table>
</div>
