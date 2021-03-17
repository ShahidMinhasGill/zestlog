<div class="mb-3">
    <div class="row">
        <div class="col-md-6">
            <button class="btn success-btn sm-btn" data-toggle="modal" data-target="#training-plan-setup">Setup/Edit</button>
            <button class="btn secondary-btn sm-btn" data-toggle="modal" data-target="#import-week">Import</button>
        </div>
        <div class="col-md-6 text-left text-md-right">
            <button class="btn success-btn add-exer-btn">Add Exercise</button>
        </div>
    </div>


</div>
<div class="week-plan accordion" id="accordionExample">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <div class="btn btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <div class="row">
                        <div class="col-4">
                            <strong>Monday</strong>
                        </div>
                        <div class="col-4">
                            <span class="text-muted">Training</span>
                        </div>
                        <div class="col-4">
                            <span class="text-muted">Upperbody</span>
                        </div>
                    </div>
                </div>
            </h2>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body px-2 pt-3 pb-0">
                <!-- comment box modal -->
                <div class="mb-3">
                    <a href="javascript(:void);" type="button" class=" primary-link" data-toggle="modal" data-target="#comment-box-modal">
                        <strong class="text-primary pr-2 mr-2 border-right">Comment</strong>
                        <span class="text-muted">click to Type </span>
                    </a>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="comment-box-modal" tabindex="-1" role="dialog" aria-labelledby="comment-box-modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header modal-header border-0 pb-0">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h3 class="section-title mb-4">Comment
                                </h3>

                                <div class="form-group">
                                    <label for="my-textarea"><strong>Comment
                                        </strong></label>
                                    <textarea id="my-textarea" class="form-control" name="" rows="3"></textarea>
                                </div>
                                <div class="text-center">
                                    <button class="btn primary-btn">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End comment box modal -->
                <div class="table-responsive">
                    <!--Start warm-up row -->
                    <div class="ex-row">
                        <div class="ex-row items" data-toggle="collapse" href="#ex-row-colapse" role="button" aria-expanded="false" aria-controls="ex-row-colapse">
                            <div class="ex-col">Warm-up</div>
                            <div class="ex-col">Set</div>
                            <div class="ex-col">Rep</div>
                            <div class="ex-col">Duration</div>
                            <div class="ex-col">notes</div>
                            <div class="ex-col text-right">
                                <a class="ex-row-colapse">
                                    <i class="fas fa-caret-down fa-2x text-dark"></i>
                                </a>
                            </div>
                        </div>

                        <div class="collapse" id="ex-row-colapse">

                            <a href="javascript: void(0)" class="add-new-row">
                                <button class="btn outline-btn my-2">Add a new row</button>
                            </a>
                            <div id="dragglist" class="dragg-table-wrapper card card-body">
                                <div class="inner-table-head justify-content-end bg-white p-3 rounded">
                                    <a href="" class="set-remove-link">Remove</a>
                                </div>
                                <div class="table-block drag-tr table-block-group">
                                    <div class="table-block-list">
                                        <div class="inner-table-wrapper bg-white p-3 rounded">
                                            <div class="inner-inner">
                                                <div class="inner-table">
                                                    <div class="inner-table-col text-primary">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                2.
                                                                Drag and drop <br>
                                                                <span class="text-dark">3/4 Sit-up</span>
                                                            </div>
                                                            <div class="exer-add-img-wrapper">
                                                                <img src="http://34.205.23.143/exercise/male/images/00011101-3-4-Sit-up_Waist_medium.png" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!--End warm-up row -->

                    <!--Start Main workout row -->
                    <div class="ex-row">
                        <div class="ex-row items" data-toggle="collapse" href="#ex-row-colapse2" role="button" aria-expanded="false" aria-controls="ex-row-colapse2">
                            <div class="ex-col">Main workout</div>
                            <div class="ex-col">Set</div>
                            <div class="ex-col">Rep</div>
                            <div class="ex-col">1RM%</div>
                            <div class="ex-col">Tempo</div>
                            <div class="ex-col">Rest</div>
                            <div class="ex-col text-right">
                                <a class="ex-row-colapse">
                                    <i class="fas fa-caret-down fa-2x text-dark"></i>
                                </a>
                            </div>
                        </div>

                        <div class="collapse" id="ex-row-colapse2">
                            <a href="javascript: void(0)" class="add-new-workout" id="plus-workout_1_2">
                                <button class="btn outline-btn my-2 tr-add " data-toggle="modal" data-target="#add-day-sets-popup" style="font-size: 1rem">Add a new set</button>
                            </a>

                            @include('client.plan.one-day-plan.partials._add-day-sets-popup')

                            <div id="dragglist" class="dragg-table-wrapper card card-body">
                                <ul class="list-unstyled mb-0">
                                    <!-- Start triset group -->
                                    <li>
                                        <div class="inner-table-head bg-white p-3 rounded">
                                            <span>Triset</span>
                                            <a href="" class="set-remove-link">Remove</a>
                                        </div>
                                        <div class="table-block drag-tr table-block-group">
                                        <div class="table-block-list">
                                            <div class="inner-table-wrapper bg-white p-3 rounded">

                                                <div class="inner-inner">
                                                    <div class="inner-table">
                                                        <div class="inner-table-col text-primary">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                            1.
                                                            Drag and drop (T) <br>
                                                            <span id="exercise_tri_1_2_1_1_12" class="text-dark"> Assisted Standing Triceps Extension </span>
                                                            </div>
                                                            <div class="exer-add-img-wrapper">
                                                            <img src="http://34.205.23.143/exercise/male/images/00011101-3-4-Sit-up_Waist_medium.png" alt="">
                                                            </div>
                                                        </div>
                                                        </div>

                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="inner-table-wrapper bg-white p-3 rounded">

                                                <div class="inner-inner">
                                                    <div class="inner-table">
                                                        <div class="inner-table-col text-primary">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                            1.
                                                            Drag and drop (T) <br>
                                                            <span id="exercise_tri_1_2_1_1_12" class="text-dark"> Assisted Standing Triceps Extension </span>
                                                            </div>
                                                            <div class="exer-add-img-wrapper">
                                                            <img src="http://34.205.23.143/exercise/male/images/00011101-3-4-Sit-up_Waist_medium.png" alt="">
                                                            </div>
                                                        </div>
                                                        </div>

                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="inner-table-wrapper bg-white p-3 rounded">

                                                <div class="inner-inner">
                                                    <div class="inner-table">
                                                        <div class="inner-table-col text-primary">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                            1.
                                                            Drag and drop (T) <br>
                                                            <span id="exercise_tri_1_2_1_1_12" class="text-dark"> Assisted Standing Triceps Extension </span>
                                                            </div>
                                                            <div class="exer-add-img-wrapper">
                                                            <img src="http://34.205.23.143/exercise/male/images/00011101-3-4-Sit-up_Waist_medium.png" alt="">
                                                            </div>
                                                        </div>
                                                        </div>

                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </li>
                                <!-- End triset group -->

                                <!-- Start vertical set group -->
                                <li>
                                    <div class="inner-table-head bg-white p-3 rounded">
                                        <span>Vertical set</span>
                                        <a href="" class="set-remove-link">Remove</a>
                                    </div>
                                    <div class="table-block drag-tr table-block-group">
                                        <div class="table-block-list">
                                            <div class="inner-table-wrapper bg-white p-3 rounded">
                                                <div class="inner-inner">
                                                    <div class="inner-table">
                                                        <div class="inner-table-col text-primary">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                            1.
                                                            Drag and drop (v) <br>
                                                            <span class="text-dark"> Narrow Stance BB Parallel Squat (Half Squat) </span>
                                                        </div>
                                                        <div class="exer-add-img-wrapper">
                                                        <img src="http://34.205.23.143/exercise/male/images/00011101-3-4-Sit-up_Waist_medium.png" alt="">
                                                        </div>
                                                        </div>
                                                    </div>

                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="inner-table-wrapper bg-white p-3 rounded">
                                                <div class="inner-inner">
                                                    <div class="inner-table">
                                                        <div class="inner-table-col text-primary">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                            1.
                                                            Drag and drop (v) <br>
                                                            <span class="text-dark"> Narrow Stance BB Parallel Squat (Half Squat) </span>
                                                        </div>
                                                        <div class="exer-add-img-wrapper">
                                                        <img src="http://34.205.23.143/exercise/male/images/00011101-3-4-Sit-up_Waist_medium.png" alt="">
                                                        </div>
                                                        </div>
                                                    </div>

                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="inner-table-col">
                                                            <select class="custom-select">
                                                                <option selected="">Select1
                                                                </option>
                                                                <option value="1">One
                                                                </option>
                                                                <option value="2">Two
                                                                </option>
                                                                <option value="3">Three
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </li>
                                <!-- End vertical set group -->

                                <!--Start Horizontal set group-->
                                <li>
                                    <div class="inner-table-head bg-white p-3 rounded">
                                        <span>Horizontal set</span>
                                        <a href="" class="set-remove-link">Remove</a>   
                                    </div>
                                
                                    <div class="table-block drag-tr table-block-group">
                                    <div class="table-block-list">
                                        <div class="inner-table-wrapper bg-white p-3 rounded">

                                            <div class="inner-inner">
                                                <div class="inner-table">
                                                    <div class="inner-table-col text-primary">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                        1.
                                                        Drag and drop (H) <br>
                                                        <span class="text-dark"> BB Forward Lunge </span>
                                                    </div>
                                                    <div class="exer-add-img-wrapper">
                                                    <img src="http://34.205.23.143/exercise/male/images/00011101-3-4-Sit-up_Waist_medium.png" alt="">
                                                    </div>
                                                    </div>
                                                </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="inner-table-wrapper bg-white p-3 rounded">

                                        <div class="inner-inner">
                                            <div class="inner-table">
                                                <div class="inner-table-col text-primary">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                    1.
                                                    Drag and drop (H) <br>
                                                    <span class="text-dark"> BB Forward Lunge </span>
                                                </div>
                                                <div class="exer-add-img-wrapper">
                                                <img src="http://34.205.23.143/exercise/male/images/00011101-3-4-Sit-up_Waist_medium.png" alt="">
                                                </div>
                                                </div>
                                            </div>
                                                <div class="inner-table-col">
                                                    <select class="custom-select">
                                                        <option selected="">Select1
                                                        </option>
                                                        <option value="1">One
                                                        </option>
                                                        <option value="2">Two
                                                        </option>
                                                        <option value="3">Three
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="inner-table-col">
                                                    <select class="custom-select">
                                                        <option selected="">Select1
                                                        </option>
                                                        <option value="1">One
                                                        </option>
                                                        <option value="2">Two
                                                        </option>
                                                        <option value="3">Three
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="inner-table-col">
                                                    <select class="custom-select">
                                                        <option selected="">Select1
                                                        </option>
                                                        <option value="1">One
                                                        </option>
                                                        <option value="2">Two
                                                        </option>
                                                        <option value="3">Three
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="inner-table-col">
                                                    <select class="custom-select">
                                                        <option selected="">Select1
                                                        </option>
                                                        <option value="1">One
                                                        </option>
                                                        <option value="2">Two
                                                        </option>
                                                        <option value="3">Three
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="inner-table-col">
                                                    <select class="custom-select">
                                                        <option selected="">Select1
                                                        </option>
                                                        <option value="1">One
                                                        </option>
                                                        <option value="2">Two
                                                        </option>
                                                        <option value="3">Three
                                                        </option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                </div>
                                <li>
                                <!--End Horizontal set group-->

                                <!--Start pyramid set-->
                                <li>
                                    <div class="inner-table-head bg-white p-3 rounded">
                                        <span>Pyramid</span>
                                        <a href="" class="set-remove-link">Remove</a>   
                                    </div>
                                 <div class="table-block drag-tr table-block-group">
                                    <div class="table-block-list">
                                        <div class="inner-table-wrapper bg-white p-3 rounded">

                                            <div class="inner-inner">
                                                <div class="inner-table">
                                                    <div class="inner-table-col text-primary">
                                                    <div class="d-flex justify-content-between">
                                                    <div>
                                                        1.
                                                        Drag and drop (v) <br>
                                                        <span class="text-dark"> One-arm BB Snatch </span>
                                                    </div>
                                                    <div class="exer-add-img-wrapper">
                                                    <img src="http://34.205.23.143/exercise/male/images/00011101-3-4-Sit-up_Waist_medium.png" alt="">
                                                    </div>
                                                    </div>
                                                </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <li>
                                <!--End pyramid set group-->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Main workout row -->

                    <!--Start cardio row -->
                    <div class="ex-row">
                        <div class="ex-row items" data-toggle="collapse" href="#ex-row-colapse3" role="button" aria-expanded="false" aria-controls="ex-row-colapse3">
                            <div class="ex-col">Cardio</div>
                            <div class="ex-col">Form</div>
                            <div class="ex-col">Stage</div>
                            <div class="ex-col">W:R</div>
                            <div class="ex-col">Rep</div>
                            <div class="ex-col">Duration</div>
                            <div class="ex-col text-right">
                                <a class="ex-row-colapse">
                                    <i class="fas fa-caret-down fa-2x text-dark"></i>
                                </a>
                            </div>
                        </div>

                        <div class="collapse" id="ex-row-colapse3">
                        <a href="javascript: void(0)" class="add-new-row">
                                <button class="btn outline-btn my-2">Add a new row</button>
                            </a>
                            <div id="dragglist" class="dragg-table-wrapper card card-body">
                                <div class="inner-table-head justify-content-end bg-white p-3 rounded">
                                    <a href="" class="set-remove-link">Remove</a>
                                </div>
                                <div class="table-block drag-tr table-block-group">
                                    <div class="table-block-list">
                                        <div class="inner-table-wrapper bg-white p-3 rounded">
                                            <div class="inner-inner">
                                                <div class="inner-table">
                                                    <div class="inner-table-col text-primary">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                2.
                                                                Drag and drop <br>
                                                                <span class="text-dark">3/4 Sit-up</span>
                                                            </div>
                                                            <div class="exer-add-img-wrapper">
                                                                <img src="http://34.205.23.143/exercise/male/images/00011101-3-4-Sit-up_Waist_medium.png" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!--End cardio row -->

                    <!-- cool-down row -->
                    <div class="ex-row">
                        <div class="ex-row items" data-toggle="collapse" href="#ex-row-colapse4" role="button" aria-expanded="false" aria-controls="ex-row-colapse4">
                            <div class="ex-col">Cool-down</div>
                            <div class="ex-col">Set</div>
                            <div class="ex-col">Rep</div>
                            <div class="ex-col">Duration</div>
                            <div class="ex-col">Note</div>
                            <div class="ex-col text-right">
                                <a class="ex-row-colapse">
                                    <i class="fas fa-caret-down fa-2x text-dark"></i>
                                </a>
                            </div>
                        </div>

                        <div class="collapse" id="ex-row-colapse4">
                        <a href="javascript: void(0)" class="add-new-row">
                                <button class="btn outline-btn my-2">Add a new row</button>
                            </a>
                            <div id="dragglist" class="dragg-table-wrapper card card-body">
                                <div class="inner-table-head justify-content-end bg-white p-3 rounded">
                                    <a href="" class="set-remove-link">Remove</a>
                                </div>
                                <div class="table-block drag-tr table-block-group">
                                    <div class="table-block-list">
                                        <div class="inner-table-wrapper bg-white p-3 rounded">
                                            <div class="inner-inner">
                                                <div class="inner-table">
                                                    <div class="inner-table-col text-primary">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                2.
                                                                Drag and drop <br>
                                                                <span class="text-dark">3/4 Sit-up</span>
                                                            </div>
                                                            <div class="exer-add-img-wrapper">
                                                                <img src="http://34.205.23.143/exercise/male/images/00011101-3-4-Sit-up_Waist_medium.png" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="inner-table-col">
                                                        <select class="custom-select">
                                                            <option selected="">Select1
                                                            </option>
                                                            <option value="1">One
                                                            </option>
                                                            <option value="2">Two
                                                            </option>
                                                            <option value="3">Three
                                                            </option>
                                                        </select>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
                <div class="btn  btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <div class="row">
                        <div class="col-4">
                            <strong>Tuesday</strong>
                        </div>
                        <div class="col-4">
                            <span class="text-muted">Active Rest</span>
                        </div>
                        <div class="col-4">
                            <span class="text-muted">Lower body</span>
                        </div>
                    </div>
                    </button>
            </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body px-2 pt-3 pb-0">
                <div class="alert alert-primary">
                    <p class="mb-0">Active rest notes</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingThree">
            <h2 class="mb-0">
                <div class="btn  btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <div class="row">
                        <div class="col-4">
                            <strong>Wednsday</strong>
                        </div>
                        <div class="col-4">
                            <span class="text-muted">Rest</span>
                        </div>

                    </div>
                </div>
            </h2>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body px-2 pt-3 pb-0">
                <div class="alert alert-success">
                    <p class="mb-0">Rest notes content........</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingFour">
            <h2 class="mb-0">
                <div class="btn  btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    <div class="row">
                        <div class="col-4">
                            <strong>Thursday</strong>
                        </div>
                        <div class="col-4">
                            <span class="text-muted">Training</span>
                        </div>

                    </div>
                </div>
            </h2>
        </div>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
            <div class="card-body px-2 pt-3 pb-0">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                richardson ad squid. 3 wolf
                moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa
                nesciunt laborum eiusmod.
                Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                coffee nulla assumenda
                shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson
                cred nesciunt sapiente ea
                proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                farm-to-table, raw denim
                aesthetic synth nesciunt you probably haven't heard of them accusamus labore
                sustainable VHS.
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingFive">
            <h2 class="mb-0">
                <div class="btn  btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    <div class="row">
                        <div class="col-4">
                            <strong>Friday</strong>
                        </div>
                        <div class="col-4">
                            <span class="text-muted">Training</span>
                        </div>

                    </div>
                </div>
            </h2>
        </div>
        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
            <div class="card-body px-2 pt-3 pb-0">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                richardson ad squid. 3 wolf
                moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa
                nesciunt laborum eiusmod.
                Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                coffee nulla assumenda
                shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson
                cred nesciunt sapiente ea
                proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                farm-to-table, raw denim
                aesthetic synth nesciunt you probably haven't heard of them accusamus labore
                sustainable VHS.
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingSix">
            <h2 class="mb-0">
                <div class="btn  btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                    <div class="row">
                        <div class="col-4">
                            <strong>Saturday</strong>
                        </div>
                        <div class="col-4">
                            <span class="text-muted">Training</span>
                        </div>

                    </div>
                </div>
            </h2>
        </div>
        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
            <div class="card-body px-2 pt-3 pb-0">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                richardson ad squid. 3 wolf
                moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa
                nesciunt laborum eiusmod.
                Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                coffee nulla assumenda
                shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson
                cred nesciunt sapiente ea
                proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                farm-to-table, raw denim
                aesthetic synth nesciunt you probably haven't heard of them accusamus labore
                sustainable VHS.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingSeven">
            <h2 class="mb-0">
                <div class="btn  btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                    <div class="row">
                        <div class="col-4">
                            <strong>Sunday</strong>
                        </div>
                        <div class="col-4">
                            <span class="text-muted">Training</span>
                        </div>

                    </div>
                </div>
            </h2>
        </div>
        <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
            <div class="card-body px-2 pt-3 pb-0">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                richardson ad squid. 3 wolf
                moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa
                nesciunt laborum eiusmod.
                Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                coffee nulla assumenda
                shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson
                cred nesciunt sapiente ea
                proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                farm-to-table, raw denim
                aesthetic synth nesciunt you probably haven't heard of them accusamus labore
                sustainable VHS.
            </div>
        </div>
    </div>
</div>
