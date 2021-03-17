<div class="card">
    <div class="card-body">
        <h1 class="pagetitle">Account</h1>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 account-left-col">
                <nav>
                    <div class="nav nav-pills" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-p-info-tab" data-toggle="tab"
                           href="#nav-p-info" role="tab" aria-controls="nav-p-info"
                           aria-selected="true">Personal Info</a>
                        <a class="nav-item nav-link" id="nav-acc-login-tab" data-toggle="tab"
                           href="#nav-acc-login" role="tab" aria-controls="nav-acc-login"
                           aria-selected="false">Account Login</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-p-info" role="tabpanel"
                         aria-labelledby="nav-home-tab">
                        <h3 class="section-title">Personal Info</h3>
                        <div class="form-group row">
                            {!! Form::label('first_name', 'First name', ['class' => 'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('first_name', $user['first_name'], ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('last_name', 'Last name', ['class' => 'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('last_name', $user['last_name'], ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-3 pt-0">Gender</legend>
                                <div class="col-sm-9 d-flex">
                                    <div class="form-check mr-3">
                                        {!! Form::radio('gender', 'male', false,['class' => 'form-check-input']) !!}
                                        {!! Form::label('gender', 'Male', ['class' => 'form-check-label']) !!}
                                    </div>
                                    <div class="form-check">
                                        {!! Form::radio('gender','female', false,['class' => 'form-check-input',]) !!}
                                        {!! Form::label('gender', 'Female', ['class' => 'form-check-label']) !!}
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        {{--<div class="form-group row">--}}
                        {{--{!! Form::label('birthday', 'Birthday', ['class' => 'col-sm-3 col-form-label']) !!}--}}
                        {{--<div class="col-sm-9">--}}
                        {{--{!! Form::text('birthday', $user['birthday'], ['class' => 'form-control','autocomplete'=>'off']) !!}--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group row">
                            {!! Form::label('mobile_number', 'Mobile No', ['class' => 'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::number('mobile_number', $user['mobile_number'], ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('email', 'Email', ['class' => 'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::email('email', $user['email'], ['class' => 'form-control', 'disabled']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Email" class="col-sm-12 col-form-label">Address</label>
                            <div class="col-sm-9 ml-auto">
                                <div class="form-group row">
                                    {!! Form::label('address_line_one', 'Line 1', ['class' => 'col-sm-3 col-form-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('address_line_one', $user['address_line_one'], ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('address_line_two', 'Line 2', ['class' => 'col-sm-3 col-form-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('address_line_two', $user['address_line_two'], ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('country', 'Country', ['class' => 'col-sm-3 col-form-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::select('country', $countries, $user->country, array('class' => 'form-control', 'id' => 'country')) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('city', 'City', ['class' => 'col-sm-3 col-form-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::select('city', $cities, $user->city, array('class' => 'form-control', 'id' => 'cityList')) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('zip_code', 'Zip Code', ['class' => 'col-sm-3 col-form-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::number('zip_code', $user['zip_code'], ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-acc-login" role="tabpanel"
                         aria-labelledby="nav-acc-login-tab">
                        <h3 class="section-title">Account Login</h3>
                        <div class="form-group row">
                            {!! Form::label('user_name', 'Username', ['class' => 'col-sm-3 col-form-label'])!!}
                            <div class="col-sm-9">
                                {!! Form::text('user_name', $user['user_name'], ['class' => 'form-control', 'disabled']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('password', 'Password', ['class' => 'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center" id="profile-pic">
                <div class="acc-por-pic mb-4">
                    @if(!empty($user->profile_pic_upload))
                        <img id="profile_pic" src="{{$user->profile_pic_upload}}" alt="Profile Pic">
                    @endif
                </div>
                <input type="file" id="profile_pic_upload" name="profile_pic_upload" class="btn primary-btn" onchange="pickImg(this);" accept="image/x-png,image/gif,image/jpeg">
            </div>
            <div class="form-group row">
                <div class="col-sm-9">
                    {!! Form::submit('Update',['class' => 'btn outline-btn']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}