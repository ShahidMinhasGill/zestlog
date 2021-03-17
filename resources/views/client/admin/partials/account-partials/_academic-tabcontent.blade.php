<div class="row">
    <div class="col-lg-6 border-right">
        <div class="row">
            <div class="col-10">
                <h3 class="section-title">Formal Education</h3>
            </div>
            <div class="col-2 text-right">
                <h4>Verified</h4>
            </div>
        </div>
        <form action="">
            <div class="form-group row border-bottom pb-3">
                <div class="col-sm-8">
                    <div class="row">
                        <label for="username" class="col-sm-6 col-form-label">Education #1</label>
                        <div class="col-sm-6 mb-2">
                            <input type="text" class="form-control" id="username">
                        </div>

                        <label for="username" class="col-sm-6 col-form-label">University/College</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="username">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="client custom-file w-75 float-left">
                        <input type="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Certificate</label>
                    </div>

                    <div class="varified-chbox float-right mt-2">
                        <input type="checkbox" class="custom-control-input" id="vmodal1">
                        <label class="custom-control-label" for="vmodal1"></label>
                    </div>
                    @include('client.admin.partials.account-partials._certificate-verified-popup')
                </div>

            </div>
            <div class="form-group row border-bottom pb-3">
                <div class="col-sm-8">
                    <div class="row">
                        <label for="username" class="col-sm-6 col-form-label">Education #2</label>
                        <div class="col-sm-6 mb-2">
                            <input type="text" class="form-control" id="username">
                        </div>

                        <label for="username" class="col-sm-6 col-form-label">University/College</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="username">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="client custom-file w-75 float-left">
                        <input type="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Certificate</label>
                    </div>

                    <div class="varified-chbox float-right mt-2">
                        <input type="checkbox" class="custom-control-input" id="vmodal2">
                        <label class="custom-control-label" for="vmodal2"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row border-bottom pb-3">
                <div class="col-sm-8">
                    <div class="row">
                        <label for="username" class="col-sm-6 col-form-label">Education #3</label>
                        <div class="col-sm-6 mb-2">
                            <input type="text" class="form-control" id="username">
                        </div>

                        <label for="username" class="col-sm-6 col-form-label">University/College</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="username">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="client custom-file w-75 float-left">
                        <input type="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Certificate</label>
                    </div>

                    <div class="varified-chbox float-right mt-2">
                        <input type="checkbox" class="custom-control-input" id="vmodal3">
                        <label class="custom-control-label" for="vmodal3"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8">
                    <div class="row">
                        <label for="username" class="col-sm-6 col-form-label">Specialization 1</label>
                        <div class="col-sm-6 mb-2">
                            <input type="text" class="form-control" id="username">
                        </div>

                        <label for="username" class="col-sm-6 col-form-label">Specialization 2</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="username">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="col-lg-6">
        <h3 class="section-title">Backgroud, Experience, Skills, Personal Intersts</h3>

        <div class="form-group">
            <textarea id="my-textarea" placeholder="" class="form-control mt-3" name="" rows="10" readonly></textarea>
        </div>
    </div>
</div>