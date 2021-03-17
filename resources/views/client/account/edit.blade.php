@extends('layouts.app')
@section('content')
    <div class="page-content">
        <div class="page-content">
            @include('partials.flash-message')
            {!! Form::model($user, ['method' => 'PATCH', 'route' => [$rout, $user->id],'files' => true,'id' => 'accountForm']) !!}
            @include('partials._edit')
        </div>
    </div>
@endsection
@push('after-scripts')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript">
        $route = '{{ URL::route('city') }}';
        $token = "{{ csrf_token() }}";
        $(document).ready(function () {
            $('#nav-tab').click(function () {
                $('#profile-pic').css('visibility', 'visible');
            });
            $('#nav-acc-login-tab').click(function () {
                setTimeout(function () {
                    $('#profile-pic').css('visibility', 'hidden');
                }, 1);
            });
        });

        /**
         * This is used to update form data
         */
        function updateFormData() {
            $formData = {
            }
        }

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

    </script>
@endpush