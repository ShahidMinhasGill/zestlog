<div class="nutri-list-head">
    <div class="fat-label">F%</div>
    <div class="carbon-label">C%</div>
    <div class="protein-label">P%</div>
    <div class="kcal-label">Kcal</div>
    <div class="training-label">Training</div>
</div>
<div class="card">
    <div class="card-header" id="headingOne">
        <h2 class="mb-0">
            <div class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#monday-plans" aria-expanded="false" aria-controls="monday-plans">

                <ul class="nutri-list list-unstyled">
                    <li><strong>Monday</strong></li>
                    <li class="text-center">,,,/,,,/,,,</li>
                    <li class="progress-wrapper">

                        <div class="fat progress" data-percentage="25">
                            <span class="progress-left">
                                <span class="progress-bar"></span>
                            </span>
                            <span class="progress-right">
                                <span class="progress-bar"></span>
                            </span>
                            <div class="progress-value">
                                <div>
                                    25/40
                                </div>
                            </div>
                        </div>
                        <div class="carb progress" data-percentage="25">
                            <span class="progress-left">
                                <span class="progress-bar"></span>
                            </span>
                            <span class="progress-right">
                                <span class="progress-bar"></span>
                            </span>
                            <div class="progress-value">
                                <div>
                                    25/40
                                </div>
                            </div>
                        </div>
                        <div class="protein progress" data-percentage="25">
                            <span class="progress-left">
                                <span class="progress-bar"></span>
                            </span>
                            <span class="progress-right">
                                <span class="progress-bar"></span>
                            </span>
                            <div class="progress-value">
                                <div>
                                    25/40
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="total-progress">
                        <div class="progress" data-percentage="25">
                            <span class="progress-left">
                                <span class="progress-bar"></span>
                            </span>
                            <span class="progress-right">
                                <span class="progress-bar"></span>
                            </span>
                            <div class="progress-value">
                                <div>
                                    <strong class="font-weight-bold">2300/</strong><span>2500</span><br>
                                    <span>Kcal</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="training-time text-center">
                        <small>60 min</small>
                    </li>
                </ul>
            </div>
        </h2>
    </div>

    <div id="monday-plans" class="collapse show active" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body p-2">
            <!-- comment box modal -->
            <div class="mb-3">
                <a href="javascript(:void);" type="button" class=" primary-link" data-toggle="modal" data-target="#nutrition-comment-box-modal">
                    <strong class="text-primary pr-2 mr-2 border-right">Comment</strong>
                    <span class="text-muted">click to Type </span>
                </a>
            </div>

            <!-- Modal -->
            @include('client.partials.nutrition-tab-partials._nutrition-comment-box-popup')
            <!-- End comment box modal -->
            <div>

                @include('client.partials.nutrition-tab-partials.nutrition-week-plans.__recommended-foods')

            </div>
        </div>
    </div>
</div>