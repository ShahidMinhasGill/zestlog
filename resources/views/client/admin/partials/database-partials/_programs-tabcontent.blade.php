<!-- <div class="card">
    <div class="card-body">
        <h1 class="pagetitle">Training Programs</h1>
    </div>
</div> -->
<nav class="inner-tab">
    <div class="nav nav-pills" id="nav-tab" role="tablist">
        <a class="nav-item nav-link" id="nav-t-programs-tab" data-toggle="tab" href="#nav-t-programs" role="tab" aria-controls="nav-t-programs" aria-selected="false">Training Programs</a>

        <a class="nav-item nav-link" id="nav-d-programs-tab" data-toggle="tab" href="#nav-d-programs" role="tab" aria-controls="nav-d-programs" aria-selected="false">Diet Programs</a>

    </div>
</nav>

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-t-programs" role="tabpanel" aria-labelledby="nav-t-programs-tab">
        @include('client.admin.partials.database-partials._training-programs-table')
    </div>

    <div class="tab-pane fade" id="nav-d-programs" role="tabpanel" aria-labelledby="nav-d-programs-tab">
        @include('client.admin.partials.database-partials._diet-programs-table')
    </div>
</div>