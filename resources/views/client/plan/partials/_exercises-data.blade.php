@if(!empty($data['result']))
<style>
    .text-one-line {
        clear: both;
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
    }
</style>
<div class="exer-steps">
    <ul class="exer-steps-list list-unstyled">
        @foreach($data['result'] as $record)
            <li class="exer-steps-list-item">
            <div class="row draggable" data-exercise-name="{{$record->name}}" id="exercise_{{$record->id}}">
                <div class="col-md-5 exer-steps-img">
                        @if(!empty($record->male_illustration))
                            <img src="{{asset(exerciseImagePathMale.'/'.$record->male_illustration)}}" class="exer-img img-fluid" alt="Male image">
                        @endif
                        @if(!empty($record->female_illustration))
                            <img src="{{asset(exerciseImagePathFemale.'/'.$record->female_illustration)}}" class="exer-img" alt="Male image">
                        @endif
                </div>
                <div class="col-md-5 exer-steps-details">
                        <p class="font-weight-bold text-one-line">{{$record->name}}</p>
                        <ul class="list-unstyled">
                            <li>
                                <span>Body Part</span>
                                <p>{{$record->body_part_name}}</p>
                            </li>
                            <li>
                                <span>Target muscle</span>
                                <p>{{$record->target_muscle_name}}</p>
                            </li>
                            <li>
                                <span>Equipment</span>
                                <p>{{$record->equipment_name}}</p>
                            </li>
                            <li>
                                <span>Training Form</span>
                                <p class="text-one-line">{{$record->training_form_name}}</p>
                            </li>
                        </ul>
                </div>
                <div class="col-md-2">
                    <div class="exce-video-link">
                        @if(!empty($record->male_gif))
                            <a href="javascript: void(0)" class="exercise_video" id="exercise_{{$record->id}}">
                                <img src="{{\URL::asset('assets/images/icon_gif.png')}}" alt="Gif Icon" height="50" width="50">
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@else
    {{--<div>No record Found</div>--}}
@endif
