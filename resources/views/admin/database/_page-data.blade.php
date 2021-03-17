@if(!empty($data['result']))
    @foreach($data['result'] as $key=>$row)
        <form id="file-upload-form" class="uploader mb-0" action="{{url('save')}}" method="post"
              accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{$row->id}}" name="id" id="id" readonly>
            <div class="exer-tb-body" id="row_{{$row->id}}">
                <div class="exer-tb-td text-left">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck3">
                        <label class="custom-control-label" for="customCheck3">{{$row->id}}</label>
                    </div>
                </div>
                <div class="exer-tb-td">
                    {{--<button class="btn success-btn sm-btn mb-3">Edit</button>--}}
                    <button type="submit" class="btn success-btn sm-btn mb-3">Update</button>
                    <br>
                    <button type="submit" id="delete_{{$row->id}}" class="btn delete-btn sm-btn delete_exercise">Delete</button>
                </div>
                <div class="exer-tb-td id-td"><span>{{$row->exercise_id}}</span></div>
                <div class="exer-tb-td gender-td male-td">
                    <span class="upload-img-wrapper">
                        @if(!empty($row->male_illustration))
                            <img src="{{asset(exerciseImagePathMale.'/'.$row->male_illustration)}}" class="exer-img" alt="Illustration.png">
                        @else
                            <img src="{{asset('assets/images/Screenshot_1.png')}}" class="exer-img" alt="Illustration.png">
                        @endif
                    <input id="file_image_{{$row->id}}" type="file" name="fileUploadImageMale" accept="image/*" class="upload-image">
                    <div id="image_male_{{$row->id}}">&nbsp</div>
                </span>
                    <span class="upload-img-wrapper">
                        @if(!empty($row->male_gif))
                            <img src="{{asset(exerciseGifPathMale.'/'.$row->male_gif)}}" class="exer-img" alt="Illustration.png">
                        @else
                            <img src="{{asset('assets/images/Screenshot_2.png')}}" class="exer-img" alt="Illustration.png">
                        @endif
                     <input id="file_gif_{{$row->id}}" type="file" name="fileUploadGifMale" accept="image/*" class="upload-gif">
                     <div id="gif_male_{{$row->id}}">&nbsp</div>
                </span>
                    <span class="upload-img-wrapper">
                        @if(!empty($row->male_video))
                            <video width="80" height="80"><source src="{{asset(exerciseVideoPathMale.'/'.$row->male_video)}}" type="video/mp4"></video>
                        @else
                            <img src="{{asset('assets/images/Screenshot_3.png')}}" class="exer-img" alt="Illustration.png">
                        @endif
                    <input id="file_video_{{$row->id}}" type="file" name="fileUploadVideoMale" accept="video/mkv,video/mp4,video/x-m4v,video/*" class="upload-video">
                     <div id="video_male_{{$row->id}}">&nbsp</div>
                </span>
                </div>
                <div class="exer-tb-td gender-td">
                <span class="upload-img-wrapper">
                    @if(!empty($row->female_illustration))
                        <img src="{{asset(exerciseImagePathFemale.'/'.$row->female_illustration)}}" class="exer-img" alt="Illustration.png">
                    @else
                        <img src="{{asset('assets/images/Screenshot_1.png')}}" class="exer-img" alt="Illustration.png">
                    @endif
                    <input id="file1female_image_{{$row->id}}" type="file" name="fileUploadImageFemale" accept="image/*" class="upload-image-Female">
                    <div id="image_female_{{$row->id}}">&nbsp</div>
                </span>
                    <span class="upload-img-wrapper">
                        @if(!empty($row->female_gif))
                            <img src="{{asset(exerciseGifPathFemale.'/'.$row->female_gif)}}" class="exer-img" alt="Illustration.png">
                        @else
                            <img src="{{asset('assets/images/Screenshot_2.png')}}" class="exer-img" alt="Illustration.png">
                        @endif
                    <input id="filefemale_gif_{{$row->id}}" type="file" name="fileUploadGifFemale" accept="image/*" class="upload-gif-Female">
                        <div id="gif_female_{{$row->id}}">&nbsp</div>
                </span>
                    <span class="upload-img-wrapper">
                        @if(!empty($row->female_video))
                            <video width="80" height="80"><source src="{{asset(exerciseVideoPathFemale.'/'.$row->female_video)}}" type="video/mp4"></video>
                        @else
                            <img src="{{asset('assets/images/Screenshot_3.png')}}" class="exer-img" alt="Illustration.png">
                        @endif
                    <input id="filefemale_video_{{$row->id}}" type="file" name="fileUploadVideoFemale" accept="video/mkv,video/mp4,video/x-m4v,video/*" class="upload-video-Female">
                        <div id="video_female_{{$row->id}}">&nbsp</div>
                </span>
                </div>
                <div class="exer-tb-td lang-td">
                    <div class="lang-inner-td">
                        <div style="width: 200px; flex: 0 0 200px"><input type="text"value="{{$row->name}}"name="title" class="form-control"></div>
                        <div>{!! Form::select('body_part', $body_parts,$row->body_part_id, ['class' => 'custom-select','id'=>'body_part']) !!}</div>
                        <div>{!! Form::select('target_Muscle', $target_muscles, $row->target_muscle_id , ['class' => 'custom-select','id'=>'target_muscle']) !!}</div>
                        <div>{!! Form::select('equipment', $equipment, $row->equipment_id , ['class' => 'custom-select','id'=>'equipment']) !!}</div>
                        <div>{!! Form::select('training_form', $training_forms, $row->training_form_id , ['class' => 'custom-select','id'=>'training_form']) !!}</div>
                        <div>{!! Form::select('dicipline', $discipline, $row->discipline_id , ['class' => 'custom-select','id'=>'dicipline']) !!}</div>
                        <div>{!! Form::select('level', $level, $row->level_id , ['class' => 'custom-select','id'=>'level']) !!}</div>
                        <div>{!! Form::select('priority', $priority, $row->priority_id , ['class' => 'custom-select','id'=>'priority']) !!}</div>
                        <div style="flex:auto">
                            <textarea id="my-textarea" class="form-control" name="description"
                                                          rows="3">{{$row->description}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
    <div class="paq-pager p-3 border-top">
        {!! $data['pager'] !!}
    </div>
@endif
<script>
    $('.upload-image').change(function () {
        let fileName = this.files && this.files.length ? this.files[0].name.split('.')[0] : '';
        let id = $(this).attr('id').split('_')[2];
        $fn = fileName.slice(0, 7);
        $('#image_male_' + id).html($fn);
    });
    $('.upload-gif').change(function () {
        let fileName = this.files && this.files.length ? this.files[0].name.split('.')[0] : '';
        let id = $(this).attr('id').split('_')[2];
        $fn = fileName.slice(0, 7);
        $('#gif_male_' + id).html($fn);
    });
    $('.upload-video').change(function () {
        let fileName = this.files && this.files.length ? this.files[0].name.split('.')[0] : '';
        let id = $(this).attr('id').split('_')[2];
        $fn = fileName.slice(0, 7);
        $('#video_male_' + id).html($fn);
    });
    $('.upload-image-Female').change(function () {
        let fileName = this.files && this.files.length ? this.files[0].name.split('.')[0] : '';
        let id = $(this).attr('id').split('_')[2];
        $fn = fileName.slice(0, 7);
        $('#image_female_' + id).html($fn);
    });
    $('.upload-gif-Female').change(function () {
        let fileName = this.files && this.files.length ? this.files[0].name.split('.')[0] : '';
        let id = $(this).attr('id').split('_')[2];
        $fn = fileName.slice(0, 7);
        $('#gif_female_' + id).html($fn);
    });
    $('.upload-video-Female').change(function () {
        let fileName = this.files && this.files.length ? this.files[0].name.split('.')[0] : '';
        let id = $(this).attr('id').split('_')[2];
        $fn = fileName.slice(0, 7);
        $('#video_female_' + id).html($fn);
    });
</script>