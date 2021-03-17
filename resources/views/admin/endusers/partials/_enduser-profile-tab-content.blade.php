<div class="row">
    <div class="col-lg-6">
        <div class="mb-4">
            <h3 class="section-title mb-4">Display name, username, location</h3>

            <div class="form-group row">
                <label for="first_name" class="col-sm-3 col-form-label">Display name</label>
                <div class="col-sm-9">
                    <input class="form-control" name="" value="@if(isset($userProfile['display_name']) && !empty($userProfile['display_name'])){{$userProfile['display_name']}}
                    @endif" type="text">
                </div>
            </div>
            <div class="form-group row">
                <label for="first_name" class="col-sm-3 col-form-label">Real name</label>
                <div class="col-sm-9">
                    <input class="form-control full_name_display" name="" value="@if(isset($userProfile['first_name'],$userProfile['last_name'])){{$userProfile['first_name']}} {{$userProfile['last_name']}}@endif"type="text">
                </div>
            </div>
            <div class="form-group row">
                <label for="first_name" class="col-sm-3 col-form-label">User name</label>
                <div class="col-sm-9">
                    <input class="form-control user_name" value="@if(isset($userProfile['user_name']) && !empty($userProfile['user_name'])){{$userProfile['user_name']}}@endif" name="" type="text">
                </div>
            </div>
            <div class="form-group row">
                <label for="first_name" class="col-sm-3 col-form-label">Country</label>
                <div class="col-sm-9">
                    <input class="form-control country" value="@if(isset($userProfile['country']) && !empty($userProfile['country'])){{$userProfile['country']}}@endif" name="" type="text">
                </div>
            </div>
            <div class="form-group row">
                <label for="first_name" class="col-sm-3 col-form-label">City</label>
                <div class="col-sm-9">
                    <input class="form-control city" value="@if(isset($userProfile['city']) && !empty($userProfile['city'])){{$userProfile['city']}}@endif" name="" type="text">
                </div>
            </div>

        </div>
        <h3 class="section-title mb-4">Other Info</h3>

        <div class="form-group row">
            <label for="first_name" class="col-sm-3 col-form-label">Date of Birth</label>
            <div class="col-sm-9">
                <input class="form-control birthday" name="" value="@if(isset($userProfile['birthday']) && !empty($userProfile['birthday'])){{scheduleDateTimeFormat($userProfile['birthday'])}}@endif" type="text">
            </div>
        </div>
        <div class="form-group row">
            <label for="first_name" class="col-sm-3 col-form-label">Age</label>
            <div class="col-sm-9">
                <span class="user-age">@if(isset($userProfile['age']) && !empty($userProfile['age']))
                        {{$userProfile['age']}}
                    @endif</span>
            </div>
        </div>
        <div class="row">
            <legend class="col-form-label col-sm-3 pt-0 font-weight-bold">Gender</legend>
            <div class="col-sm-9 d-flex">
                <div class="form-check mr-3">
                    <input class="form-check-input" name="gender" type="radio" value="male" id="gender"
                           @if(isset($userProfile['gender']) && $userProfile['gender'] == 'male')
                           checked
                            @endIf
                    >
                    <label for="gender"  class="form-check-label">Male</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="gender" type="radio" value="female" id="gender"
                           @if(isset($userProfile['gender']) && $userProfile['gender'] == 'female')
                           checked
                            @endIf
                    >
                    <label for="gender" class="form-check-label">Female</label>
                </div>
            </div>
        </div>
    </div>
</div>