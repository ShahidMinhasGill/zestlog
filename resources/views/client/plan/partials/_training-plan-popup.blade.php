@php
    $weekTab = $weekTabBody = $class ='';
    if(empty($is_client_plan))
        $class = 'mb-3';
@endphp
@foreach ( $data["days"] as $key => $wkDay )
    @php
        $dayName = ("'$wkDay'");
        $weekTab .= '<a class="nav-item nav-link training-plan-popup" id="nav-'.$key.'" data-toggle="tab" href="javascript: void(0)" role="tab" aria-controls="nav-'.$wkDay.'" aria-selected="false">'.$wkDay.'</a>';
        $weekTabBody .= '<div class="tab-pane fade" id="nav-'.$wkDay.'" role="tabpanel" aria-labelledby="nav-'.$wkDay.'-tab"> <div class="weekly-training-form" id="popup-data-'.$key.'"></div></div>';
    @endphp
@endforeach
<!-- Training plan setup modal -->
<button type="button" class="btn success-btn training-plan-setup {{$class}}" data-toggle="modal" data-target="#training-plan-setup"> Setup</button>
<!-- Modal -->
<div class="modal fade" id="training-plan-setup" tabindex="-1" role="dialog"
     aria-labelledby="training-plan-setupLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header border-0 pb-0">
                <button type="button" class="close training-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="section-title mb-4">One week training Plan Setup</h3>
                <div class="training-plan-content">
                    <nav>
                        <div class="nav nav-pills" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-overview-tab"
                               data-toggle="tab" href="#nav-overview" role="tab"
                               aria-controls="nav-overview" aria-selected="true">Overview</a>
                            {!! $weekTab!!}
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-overview" role="tabpanel"
                             aria-labelledby="nav-home-tab">
                        </div>
                        {!! $weekTabBody !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
