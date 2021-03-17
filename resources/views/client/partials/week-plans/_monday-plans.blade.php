<div class="card">
    <div class="card-header" id="headingOne">
        <h2 class="mb-0">
            <div class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                <div class="row">
                    <div class="col-4">
                        <div class="p-day-block">
                            <strong class="p-day">Monday</strong>
                            <span class="p-date">DD/MM/YYY</span>
                        </div>
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

    <div id="collapseOne" class="collapse show active" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="card-body px-2 pt-3 pb-0">
            <!-- comment box modal -->
            <div class="mb-3">
                <a href="javascript(:void);" type="button" class=" primary-link" data-toggle="modal" data-target="#comment-box-modal">
                    <strong class="text-primary pr-2 mr-2 border-right">Comment</strong>
                    <span class="text-muted">click to Type </span>
                </a>
            </div>

            <!-- Modal -->
            @include('client.partials._comment-box-popup')
            <!-- End comment box modal -->
            <div class="table-responsive">

                @include('client.partials.week-plans._warm-up')

                @include('client.partials.week-plans._main-workout')

                @include('client.partials.week-plans._cardio')

                @include('client.partials.week-plans._cool-down')
            </div>
        </div>
    </div>
</div>