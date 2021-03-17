<div class="row">
    <div class="col-lg-6">

        <h3 class="section-title mb-4">Security</h3>

        <div class="form-group row">
            <label for="first_name" class="col-sm-3 col-form-label">Mobile phone</label>
            <div class="col-sm-2">
                <input class="form-control edit-mobile-number"id="country-code" value="+{{$user['extension']}}" name="" type="text">
            </div>
            <div class="col-sm-4">
                <input class="form-control edit-mobile-number"id="txt_mobile" value="{{$userProfile['mobile_number']}}" name="" type="text">
            </div>
        </div>
        <div class="form-group row">
            <label for="first_name" class="col-sm-3 col-form-label">Email address</label>
            <div class="col-sm-6">
                <input class="form-control edit-mobile-number" name=""id="txt_email" value="{{$userProfile['email']}}" type="text">
            </div>
        </div>
        <button class="btn success-btn"id="edit_security">Edit</button>
    </div>
</div>