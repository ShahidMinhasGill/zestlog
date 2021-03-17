<div class="modal fade" id="add-day-sets-popup" tabindex="-1" aria-labelledby="add-day-sets-popupLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header p-1 border-0">
                <button type="button" class="close close-training-setup" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center text-dark">
                <h3 class="section-title mb-4">Add set(s) to main workout</h3>
                <div class="row">
                <div class="col-md-8 mx-auto">
                    <ul class="add-set-list list-unstyled">
                        <li class="clearfix add-li">
                            <div class="float-left">
                                <strong>Select a set</strong>
                            </div>
                            <div class="float-right">
                                <select class="custom-select">
                                    <option value="" selected="selected">Select</option>
                                    <option value="horizontal">Horizontal set</option>
                                    <option value="vertical">Vertical set</option>
                                    <option value="super">Superset</option>
                                    <option value="tri">Triset</option>
                                    <option value="drop">Dropset</option>
                                    <option value="pyramid">Pyramid set</option>
                                    <option value="circuit">Circuit</option></select>
                            </div>
                        </li>
                        <li class="clearfix add-li">
                            <div class="float-left">
                                <strong>How many?</strong>
                            </div>
                            <div class="float-right">
                                <ul class="set-list list-unstyled">
                                    <li>
                                        <a href="javaScript:void(0);" class="reorder-up fa-minus-set">
                                            <i class="fas fas fa-minus"></i></a>
                                        <span >1</span>
                                        <a href="javaScript:void(0);" class="reorder-down fa-plus-set">
                                            <i class="fas fas fa-plus"></i></a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <li class="clearfix add-li">
                            <div class="float-left">
                                <strong>How many exercise?</strong>
                            </div>
                            <div class="float-right">
                                <ul class="set-list list-unstyled">
                                    <li>
                                        <a href="javaScript:void(0);" class="reorder-up fa-minus-set">
                                            <i class="fas fas fa-minus"></i></a>
                                        <span>1</span>
                                        <a href="javaScript:void(0);" class="reorder-down fa-plus-set">
                                            <i class="fas fas fa-plus"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                </ul></div>
            </div>

            <div class="col-12">
                <a href="javascript:void(0)" class="save-workout-sets btn success-btn mb-3 mr-2">Apply</a>
            </div>

            </div>
        </div>
    </div>
</div>