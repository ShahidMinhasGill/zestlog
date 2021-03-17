@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <h1 class="pagetitle">Exercise</h1>
            </div>
        </div>
        @include('partials.flash-message')
        <div class="card">
            <div class="card-body">
                <div class="pb-3 mb-3 border-bottom">
                    <button class="btn success-btn">Add a new row</button>
                    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        ExcelFile <input type="file" name="file">
                        <button class="btn btn-success">Import Bulk Data</button>
                    </form>
                </div>
                <div class="exer-table table-responsive">
                    <div class="exer-table">
                        <div class="exer-tb-head bg-light">
                            <div class="exer-tb-th text-left">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Nr</label>
                                </div>
                            </div>
                            <div class="exer-tb-th">Action</div>
                            <div class="exer-tb-th id-th">ID</div>
                            <div class="exer-tb-th gender-th male-th">
                                <div class="mb-2">Male</div>
                                <div class="gender-th-inner">
                                    <span>Illustration</span>
                                    <span>GIF</span>
                                    <span>Video</span>
                                </div>
                            </div>
                            <div class="exer-tb-th gender-th">
                                <div class="mb-2">Female</div>
                                <div class="gender-th-inner">
                                    <span>Illustration</span>
                                    <span>GIF</span>
                                    <span>Video</span>
                                </div>
                            </div>
                            <div class="exer-tb-th lang-th">
                                <div class="land-header pb-2 mb-2">
                                    <h4 class="lang-lable font-weight-bold mb-0 mr-3">English</h4>
                                </div>
                                <div class="lang-inner-th">
                                    <div>
                                        Name<br>
                                        <div class="table-search d-flex mr-2">
                                            <i class="fas fa-search"></i>
                                            <input type="text" placeholder="Search a name" name="search" id="search"
                                                   class="form-control"
                                                   style="width: 200px;">
                                        </div>
                                    </div>
                                    <div>Body Part<br>{!! Form::select('body_part', $body_parts, null , ['class' => 'custom-select','id'=>'body_part']) !!}</div>
                                    <div>Target Muscle<br>{!! Form::select('target_Muscle', $target_muscles, null , ['class' => 'custom-select','id'=>'target_muscle']) !!}</div>
                                    <div>Equipment<br>{!! Form::select('equipment', $equipment, null , ['class' => 'custom-select','id'=>'equipment']) !!}</div>
                                    <div>Training Form<br>{!! Form::select('training_form', $training_forms, null , ['class' => 'custom-select','id'=>'training_form']) !!}</div>
                                    <div>Dicipline<br>{!! Form::select('dicipline', $discipline, null , ['class' => 'custom-select','id'=>'dicipline']) !!}</div>
                                    <div>Level<br>{!! Form::select('level', $level, null , ['class' => 'custom-select','id'=>'level']) !!}</div>
                                    <div>Priority<br>{!! Form::select('priority', $priority, null , ['class' => 'custom-select','id'=>'priority']) !!}</div>
                                    <div class="text-left">Text</div>
                                </div>
                            </div>
                        </div>
                        <div id="page-data"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $token = "{{ csrf_token() }}";
    $search = $body_part = $target_muscle = $equipment = $training_form = $dicipline = $level = $priority = '';
    $page = 1;
    $deleteRoute = '{!! URL::route('database.destroy', ['database' => 0]) !!}';
    $defaultType = 'renderDatabase';
    $(document).ready(function () {
        updateFormData();
        get_data();

        $('body').on('click', '.delete_exercise', function (e) {
            e.preventDefault();
            $deleteId = this.id;
            var result = confirm(('Are you sure to delete'));
            if (result) {
                $type = 'delete';
                $formData = {
                    '_token': $token,
                    'id': $deleteId
                };
                destroyExercise();

            }
        });

        $(document).on("click", '.paq-pager ul.pagination a', function (e) {
            e.preventDefault();
            $page = $(this).attr('href').split('page=')[1];
            updateFormData();
            get_data();
        });
        $('.custom-select').change(function () {
            $value = $(this).val();
            var id = $(this).attr('id');
            if ($value == '') {
                $value = '0';
            }
            if (id == 'body_part') {
                $body_part = $value;
            } else if (id == 'target_muscle') {
                $target_muscle = $value;
            } else if (id == 'equipment') {
                $equipment = $value;
            } else if (id == 'training_form') {
                $training_form = $value;
            } else if (id == 'dicipline') {
                $dicipline = $value;
            } else if (id == 'level') {
                $level = $value
            } else if (id == 'priority') {
                $priority = $value;
            }
            updateFormData();
            get_data();
        });

        $(document).on('keyup', '#search', function () {
            if (event.keyCode == 13) {
                $search = $(this).val();
                updateFormData();
                get_data();
            }
        });
    });

    var destroyExercise = function () {
        ajaxStartStop();
        $.ajax({
            url: $deleteRoute,
            type: 'Delete',
            data: $formData,
            success: function (data) {
                if (data.success == true) {
                    swal("Done!", data.message, "success");
                    $('#row_' + data.id).remove();
                    get_data();
                }
            },
            error: function ($error) {
                // notificationMsg($error, error);
            }
        });
    }
    function get_data() {
        ajaxStartStop();
        $.ajax({
            url: "{{ route('get.exercises') }}",
            method: 'POST',
            data: $formData,
            dataType: 'json',
            success: function (data) {
                $('#page-data').html(data.data);
            }
        })
    }

    /**
     * This is used to update form data
     */
    var updateFormData = function () {
        $formData = {
            '_token': $token,
            page: $page,
            search: $search,
            body_part: $body_part,
            target_muscle: $target_muscle,
            equipment: $equipment,
            training_form: $training_form,
            dicipline: $dicipline,
            level: $level,
            priority: $priority
        };
    }
</script>
{!! Html::script('js/admin.js?id='.version())!!}
