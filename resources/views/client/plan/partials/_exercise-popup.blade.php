<div id="exercise-video-popup_{{$data['exerciseId']}}">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="section-title mb-3">{!! $data['name'] !!}</h3>
                <img src="{{asset(exerciseGifPathMale.'/'.$data['source'])}}">
            </div>
        </div>
    </div>
</div>
