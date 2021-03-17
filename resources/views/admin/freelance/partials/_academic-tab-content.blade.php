<div class="row">
    <div class="col-lg-12 border-right">
        <h3 class="section-title mb-4">Specialization & Formal Education</h3>
        <form action="">
            <div class="form-group row border-bottom pb-3">
                <div class="col-sm-6">
                    <div class="row">
                        <label for="username" class="col-sm-3 col-form-label">Specialization 1</label>
                        <div class="col-sm-6 mb-2">
                            {!! Form::select('specializations', $specializations,@$channelActivations[1]['specialization_id'],['class' => 'custom-select drop_down_filters-specialization acadmic-information', 'id'=>'specialization_id_1']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <label for="username" class="col-sm-3 col-form-label">Education #1</label>
                        <div class="col-sm-6 mb-2">
                            <input type="text" class="form-control acadmic-information is-already-verify_1"
                                   value="@if(isset($channelActivations[1])){{$channelActivations[1]['education_title']}}@endif"
                                   id="education_title_1">
                        </div>

                    </div>

                    <div class="row">
                        <label for="username" class="col-sm-3 col-form-label">University/College</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control acadmic-information is-already-verify_1"
                                   value="@if(isset($channelActivations[1])){{$channelActivations[1]['education_from']}}@endif"
                                   id="education_from_1">
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       class="custom-control-input is-verify-education acadmic-information is-already-verify_1"
                                       @if(isset($channelActivations[1]['is_verify']) && $channelActivations[1]['is_verify']==1) checked="checked"
                                       @endif  id="verified_1">
                                <label class="custom-control-label h5 font-weight-bold" for="verified_1">Verify</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">

                    <div class="border d-table w-100 h-100">
                        <div class="text-muted d-table-cell align-middle text-center increase-image-size" id="{{asset(MobileAccountChannelActivation.'/'.$channelActivations[1]['education_certificate'])}}_{{$channelActivations[1]['education_certificate']}}">
                            @if(isset($channelActivations[1]['education_certificate']) && !empty($channelActivations[1]['education_certificate']))
                                <img src="{{asset(MobileAccountChannelActivation.'/'.$channelActivations[1]['education_certificate'])}}"
                                     alt="profile-pic.png" class="education-certificate myImg" width="670" height="200">
                            @else
                                <label for="first_name" class="col-sm-3 col-form-label">Certificate Image not
                                    available</label>
                            @endif</div>
                    </div>
                </div>
            </div>

            <div class="form-group row border-bottom pb-3">
                <div class="col-sm-6">
                    <div class="row">
                        <label for="username" class="col-sm-3 col-form-label">Specialization 2</label>
                        <div class="col-sm-6 mb-2">
                            {!! Form::select('specializations', $specializations,@$channelActivations[2]['specialization_id'], ['class' => 'custom-select drop_down_filters-specialization acadmic-information', 'id'=>'specialization_id_2']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <label for="username" class="col-sm-3 col-form-label">Education #2</label>
                        <div class="col-sm-6 mb-2">
                            <input type="text" class="form-control acadmic-information is-already-verify_2"
                                   value="@if(isset($channelActivations[2])){{$channelActivations[2]['education_title']}}@endif"
                                   id="education_title_2">
                        </div>
                    </div>
                    <div class="row">
                        <label for="username" class="col-sm-3 col-form-label">University/College</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control acadmic-information is-already-verify_2"
                                   value="@if(isset($channelActivations[2])){{$channelActivations[2]['education_from']}}@endif"
                                   id="education_from_2">
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       class="custom-control-input is-verify-education acadmic-information is-already-verify_2"
                                       @if(isset($channelActivations[2]['is_verify']) && $channelActivations[2]['is_verify']==1) checked="checked"
                                       @endif id="verified_2">
                                <label class="custom-control-label h5 font-weight-bold" for="verified_2">Verify</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">

                    <div class="border d-table w-100 h-100">
                        <div class="text-muted d-table-cell align-middle text-center increase-image-size" id="{{asset(MobileAccountChannelActivation.'/'.$channelActivations[2]['education_certificate'])}}_{{$channelActivations[2]['education_certificate']}}">
                            @if(isset($channelActivations[2]['education_certificate']) && !empty($channelActivations[2]['education_certificate']))
                                <img src="{{asset(MobileAccountChannelActivation.'/'.$channelActivations[2]['education_certificate'])}}">
                            @else
                                <label for="first_name" class="col-sm-3 col-form-label">Certificate Image not
                                    available</label>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row border-bottom pb-3">
                <div class="col-sm-6">
                    <div class="row">
                        <label for="username" class="col-sm-3 col-form-label">Specialization 3</label>
                        <div class="col-sm-6 mb-2">
                            {!! Form::select('specializations', $specializations,@$channelActivations[3]['specialization_id'] , ['class' => 'custom-select drop_down_filters-specialization acadmic-information', 'id'=>'specialization_id_3']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <label for="username" class="col-sm-3 col-form-label">Education #3</label>
                        <div class="col-sm-6 mb-2">
                            <input type="text" class="form-control acadmic-information is-already-verify_3"
                                   value="@if(isset($channelActivations[3])){{$channelActivations[3]['education_title']}}@endif"
                                   id="education_title_3">
                        </div>

                    </div>

                    <div class="row">
                        <label for="username" class="col-sm-3 col-form-label">University/College</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control acadmic-information is-already-verify_3"
                                   value="@if(isset($channelActivations[3])){{$channelActivations[3]['education_from']}}@endif"
                                   id="education_from_3">
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       class="custom-control-input is-verify-education acadmic-information is-already-verify_3"
                                       @if(isset($channelActivations[3]['is_verify']) && $channelActivations[3]['is_verify']==1) checked="checked"
                                       @endif id="verified_3">
                                <label class="custom-control-label h5 font-weight-bold" for="verified_3">Verify</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="border d-table w-100 h-100">
                        <div class="text-muted d-table-cell align-middle text-center increase-image-size" id="{{asset(MobileAccountChannelActivation.'/'.$channelActivations[3]['education_certificate'])}}_{{$channelActivations[3]['education_certificate']}}">
                            @if(isset($channelActivations[3]['education_certificate']) && !empty($channelActivations[3]['education_certificate']))
                                <img src="{{asset(MobileAccountChannelActivation.'/'.$channelActivations[3]['education_certificate'])}}"
                                     alt="profile-pic.png" width="680" height="200">
                            @else
                                <label for="first_name" class="col-sm-3 col-form-label">Certificate Image not
                                    available</label>
                            @endif</div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="col-lg-6">
        <h3 class="section-title">Backgroud, Experience, Skills, Personal Intersts</h3>

        <div class="form-group">
            <textarea id="my-textarea" placeholder="" class="form-control mt-3" name="" rows="10"
                      readonly>@if(isset($user) && !empty($user['introduction'])){{$user['introduction']}}@endif
            </textarea>
        </div>

    </div>
</div>
<button class="btn success-btn" id="acadmic-btn-edit">Edit</button>