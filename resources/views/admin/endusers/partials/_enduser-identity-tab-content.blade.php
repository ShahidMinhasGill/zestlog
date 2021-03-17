<div class="row">
    <div class="col-lg-6">
        <div class="pb-3 mb-3 border-bottom">
            <h3 class="section-title mb-4">Identity Verification</h3>

            <div class="form-group row">
                <label for="first_name" class="col-sm-3 col-form-label">First name</label>
                <div class="col-sm-9">
                    <input class="form-control end-user-identity identity-information"id="first_name" name="" value="@if(isset($user['first_name']) && !empty($user['first_name'])){{$user['first_name']}} @endif" type="text">
                </div>
            </div>
            <div class="form-group row">
                <label for="first_name" class="col-sm-3 col-form-label">Middle name</label>
                <div class="col-sm-9">
                    <input class="form-control end-user-identity identity-information"id="middle_name" name="" value="@if(isset($user['middle_name']) && !empty($user['middle_name'])){{$user['middle_name']}} @endif"  type="text">
                </div>
            </div>
            <div class="form-group row">
                <label for="first_name" class="col-sm-3 col-form-label">Last name</label>
                <div class="col-sm-9">
                    <input class="form-control end-user-identity identity-information"id="last_name" value="@if(isset($user['last_name']) && !empty($user['last_name'])){{$user['last_name']}} @endif"  name="" type="text">
                </div>
            </div>

            <div class="form-group row">
                <label for="first_name" class="col-sm-3 col-form-label">Birthday</label>
                <div class="col-sm-9">

                    <input class="form-control end-user-identity identity-information"id="birthday" name="" value="{{@$user['birthday']}}"  type="date">
                </div>
            </div>
        </div>

        <div class="custom-control custom-checkbox mb-3">
            <input type="checkbox" class="custom-control-input end-user-identity identity-information" @if(isset($user['is_identity_verified']) && $user['is_identity_verified']==1) checked="checked"
                   @endif  id="is_identity_verify">
            <label class="custom-control-label h5 font-weight-bold" for="is_identity_verify" id="is_identity_verify">Verified</label>
        </div>

        <button class="btn success-btn" id="end-user-identity-edit">Edit</button>
    </div>

    <div class="col-lg-6">
        <div class="border d-table w-100 h-100">
            <div class="text-muted d-table-cell align-middle text-center increase-image-size"id="{{asset(MobileUserIdentityImagePath.'/'.$identityDetail['id_photo'])}}_{{$identityDetail['id_photo']}}">
                @if(isset($identityDetail['id_photo']) && !empty($identityDetail['id_photo']))
                    <img src="{{asset(MobileUserIdentityImagePath.'/'.$identityDetail['id_photo'])}}"
                         alt="profile-pic.png" width="680" height="390">
                @else
                    <label for="first_name" class="col-sm-3 col-form-label">ID Image not
                        available</label>
                @endif</div>
        </div>
    </div>
</div>