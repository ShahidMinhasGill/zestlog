
<nav class="inner-tab">
    <div class="nav nav-pills" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-Profile-tab" data-toggle="tab" href="#nav-Profile" role="tab" aria-controls="nav-Profile" aria-selected="true">Profile</a>

        <a class="nav-item nav-link" id="nav-Security-tab" data-toggle="tab" href="#nav-Security" role="tab" aria-controls="nav-Security" aria-selected="false">Security</a>

        <a class="nav-item nav-link" id="nav-idverification-tab" data-toggle="tab" href="#nav-idverification" role="tab" aria-controls="nav-idverification" aria-selected="false">Identity Verification</a>


    </div>

    <div class="tab-content" id="nav-tabContent">
        <!-- Profile tab content start -->
        <div class="tab-pane fade show active" id="nav-Profile" role="tabpanel" aria-labelledby="nav-Profile">

            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-4">
                        <h3 class="section-title mb-4">Display name, username, location</h3>

                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label">First name </label>
                            <div class="col-sm-9">
                                <input class="form-control first_name"name="" type="text"  value="{{$user['first_name']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label">Last name</label>
                            <div class="col-sm-9">
                                <input class="form-control last_name"name="" type="text" value="{{$user['last_name']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label">User name</label>
                            <div class="col-sm-9">
                                <input class="form-control user_name"name="" type="text" value="{{$user['user_name']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label">Country</label>
                            <div class="col-sm-9">
                                <input class="form-control country" name="" type="text" value="{{$user['country']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label">City</label>
                            <div class="col-sm-9">
                                <input class="form-control city" name="" type="text"value="{{$user['city']}}">
                            </div>
                        </div>

                    </div>
                    <h3 class="section-title mb-4">Other Info</h3>

                    <div class="form-group row">
                        <label for="first_name" class="col-sm-3 col-form-label">Date of Birth</label>
                        <div class="col-sm-9">
                            <input class="form-control birthday" name="" value="{{scheduleDateTimeFormat($user['birthday'])}}" type="text">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="first_name" class="col-sm-3 col-form-label">Age</label>
                        <div class="col-sm-9">
                            <span class="age"id="user-age">{{$user['age']}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <legend class="col-form-label col-sm-3 pt-0 font-weight-bold">Gender</legend>
                        <div class="col-sm-9 d-flex">
                            <div class="form-check mr-3">
                                <input class="form-check-input" name="gender" type="radio" value="male"
                                       @if(isset($user['gender']) && $user['gender'] == 'male')
                                       checked
                                        @endIf
                                >
                                <label for="gender" class="form-check-label">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="gender" type="radio" value="female" id="gender"
                                       @if(isset($user['gender']) && $user['gender'] == 'female')
                                       checked
                                        @endIf
                                >
                                <label for="gender" class="form-check-label">Female</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security tab content start -->
        <div class="tab-pane fade" id="nav-Security" role="tabpanel" aria-labelledby="nav-Security">
            <div class="row">
                <div class="col-lg-6">

                    <h3 class="section-title mb-4">Security</h3>
                    <div class="form-group row">

                    </div>
                    <div class="form-group row">
                        {{--<label for="country-code" class="col-sm-3 col-form-label">Country code</label>--}}
                        <label for="first_name" class="col-sm-3 col-form-label">Mobile phone</label>
                        <div class="col-sm-2">
                            <input class="form-control edit-mobile-number" name=""id="country-code" type="text"value="+{{$user['extension']}}">
                        </div>
                        <div class="col-sm-4">
                            <input class="form-control edit-mobile-number" name=""id="txt_mobile" type="text"value="{{$user['mobile_number']}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="first_name" class="col-sm-3 col-form-label">Email address</label>
                        <div class="col-sm-6">
                            <input class="form-control email" name="" id="txt_email" type="text"value="{{$user['email']}}">
                        </div>
                    </div>
                    <button class="btn success-btn"id="edit_security">Edit</button>

                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="nav-idverification" role="tabpanel" aria-labelledby="nav-idverification">
            <div class="row">
                <div class="col-lg-6">
                    <div class="pb-3 mb-3 border-bottom">
                        <h3 class="section-title mb-4">Identity Verification</h3>

                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label">First name</label>
                            <div class="col-sm-9">
                                <input class="form-control identity-information"id="first_name" value="{{$user['first_name']}}" name="" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label">Middle name</label>
                            <div class="col-sm-9">
                                <input class="form-control identity-information"id="middle_name" value="{{$user['middle_name']}}" name="" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label">Last name</label>
                            <div class="col-sm-9">
                                <input class="form-control identity-information"id="last_name" value="{{$user['last_name']}}" name="" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label">Birthday</label>
                            <div class="col-sm-9">
                                <input class="form-control identity-information" id="birthday" value="{{$user['birthday']}}" name="" type="date">
                            </div>
                        </div>
                    </div>
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox"
                                   @if(isset($user['is_identity_verified']) && $user['is_identity_verified']==1) checked="checked"
                                   @endif
                                   class="identity-information"id="verified1">
                            <label class="h5 font-weight-bold" for="verified1">Verified</label>
                        </div>
                        <button class="btn success-btn"id="identity-edit">Edit</button>
                </div>
                <div class="col-lg-6">
                    <div class="border d-table w-100 h-100 increase-image-size" id="{{asset(MobileUserIdentityImagePath.'/'.$identityDetail['id_photo'])}}">
                        @if(isset($identityDetail['id_photo']) && !empty($identityDetail['id_photo']))
                            <img src="{{asset(MobileUserIdentityImagePath.'/'.$identityDetail['id_photo'])}}" alt="profile-pic.png"width="680"height="500">
                        @else
                            <label for="first_name" class="col-sm-3 col-form-label">Image not available</label>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>