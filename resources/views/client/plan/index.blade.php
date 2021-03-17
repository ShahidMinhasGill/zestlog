@extends('layouts.app')
<style>
    .width80 {
        width: 80px !important;
    }
    .width163 {
        width: 163px !important;
    }
</style>
@section('content')
    <div class="page-content">
        <div class="container-fluid1">
            <!-- <div class="card">
                <div class="card-body">
                    <h1 class="pagetitle">Training Programs</h1>
                </div>
            </div> -->

            <div class="card">
                <div class="card-body">

                <div class="nav nav-pills" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-training-programs" data-toggle="tab" href="#nav-training-programs" role="tab" aria-controls="nav-training-programs" aria-selected="true">Training programs</a>
                   
                </div>

                <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-training-programs" role="tabpanel" aria-labelledby="nav-training-programs">
                    <!-- inner tab start -->
                <nav class="inner-tab">
                    <div class="nav nav-pills" id="nav-inner-tab" role="tablist">
                        @if(!isLightVersion())
                            <a class="nav-link action-plan @if($planType == 2) active @endif" id="week-plans-tab" data-toggle="tab" href="#week-plans" role="tab" aria-controls="week-plans" aria-selected="false">One-week program</a>
                        @endif

                        <a class="nav-link action-plan @if($planType == 1) active @endif" id="one-day-plans-tab" data-toggle="tab" href="#one-day-plans" role="tab" aria-controls="one-day-plans" aria-selected="false">
                            @if(isLightVersion()) Saved Training Plans @else One-day plan @endif
                        </a>

                    </div>
                </nav>

                <div class="tab-content" id="nav-inner-tabContent">
                <div class="tab-pane @if($planType == 2) show active @else fade @endif" id="week-plans" role="tabpanel"
                     aria-labelledby="week-plans-tab">
                    @include('client.plan.partials._week-plans-tabcontent')
                </div>
                <div class="tab-pane @if($planType == 1) show active @else fade @endif" id="one-day-plans" role="tabpanel" aria-labelledby="one-day-plans-tab">
                    @include('client.plan.partials._day-plans-tabcontent')
                </div>

                </div>
                </div>
                </div>
                </div>
                <!-- inner tab End -->
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $renderRoute = '{{ URL::route('plan.get.training.programs') }}';
    $editRoute = '{{ URL::route('plans.edit', ['plan' => 0]) }}';
    $editRoute = $editRoute.substr(0, $editRoute.lastIndexOf("/"));
    $editRoute = $editRoute.substr(0, $editRoute.lastIndexOf("/"));
    $deleteRoute = '{!! URL::route('plans.destroy', ['plan' => 0]) !!}';
    $defaultType = 'renderPlans';
    $token = "{{ csrf_token() }}";
    $page = 1;
    $search = '';
    $asc = 'asc';
    $desc = 'desc';
    $sortType  = 'desc';
    $sortColumn = 'a.id';
    $dropDownFilters = {};
    $isImportRender = '{{$isImportRender}}';
    $planType = '{{$planType}}';

    $(document).ready(function() {
        updateFormData();
        $type = $defaultType;
        renderClient();
        $('#search').val('');
    });

    $('body').on('click', '.action-plan', function () {
        $page = 1;
       let id = this.id;
       if(id == 'one-day-plans-tab'){
           $planType = 1;
           $isImportRender = 1;
       }else {
           $planType = 2;
           $isImportRender = 0;
       }
        updateFormData();
        $type = $defaultType;
        renderClient();
    });
    var updateFormData = function () {
        $formData = {
            '_token': $token,
            page:  $page,
            search: $search,
            sortType: $sortType,
            sortColumn: $sortColumn,
            dropDownFilters: $dropDownFilters,
            plan_type:$planType
        };
    }

</script>

    {!! Html::script('js/client.js?id='.version())!!}
@endpush
