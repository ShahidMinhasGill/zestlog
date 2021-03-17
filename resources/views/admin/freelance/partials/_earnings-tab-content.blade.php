<nav class="inner-tab">
    <div class="nav nav-pills" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-bankaccount-tab" data-toggle="tab" href="#nav-bankaccount" role="tab" aria-controls="nav-bankaccount" aria-selected="false">Bank Accounts</a>

    </div>

    <div class="tab-content" id="nav-tabContent">
        <!-- bankaccount tab content Start -->
        <div class="tab-pane fade show active" id="nav-bankaccount" role="tabpanel" aria-labelledby="nav-bankaccount">
            <div class="row">
            <div class="col-md-6">
                <h3 class="section-title">Bank account <small class="font-weight-lighter h6">(Payouts will be transferred to the following bank account)</small>
                </h3>

                <form action="">
                    <div class="form-group row bank-information">
                        <label for="acholder" class="col-sm-4 col-form-label ">Beneficiary (Account owner)</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bank-information" value="{{@$bankAccountDetails['bank_holder']}}" id="account_holder">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="acholder" class="col-sm-4 col-form-label">Account number</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bank-information" value="{{@$bankAccountDetails['account_number']}}"  id="account_number">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="acholder" class="col-sm-4 col-form-label">Sort Code</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bank-information" value="{{@$bankAccountDetails['bic_code']}}"  id="bic_code">
                        </div>
                    </div> <br>
                    <h3 class="">Beneficiary Information</h3>
                    <br>
                    <div class="form-group row">
                        <label for="acholder" class="col-sm-4 col-form-label">Date of Birth</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bank-information" value="{{scheduleDateTimeFormat(@$bankAccountDetails['birthday'])}}"  id="date_of_birth">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="acholder" class="col-sm-4 col-form-label">Email address</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bank-information" value="{{@$bankAccountDetails['email']}}"  id="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="acholder" class="col-sm-4 col-form-label">Address line 1</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bank-information" value="{{@$bankAccountDetails['address_line_one']}}"  id="address_line_one">
                            </div>
                    </div>
                    <div class="form-group row">
                        <label for="acholder" class="col-sm-4 col-form-label">Address line 2</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bank-information" value="{{@$bankAccountDetails['address_line_two']}}"  id="address_line_two">
                           </div>
                    </div>
                    <div class="form-group row">
                        <label for="acholder" class="col-sm-4 col-form-label">Postal Code</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bank-information" value="{{@$bankAccountDetails['postal_code']}}"  id="postal_code">
                             </div>
                    </div>
                    <div class="form-group row">
                        <label for="acholder" class="col-sm-4 col-form-label">City</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bank-information" value="{{@$bankAccountDetails['city']}}"  id="city">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="acholder" class="col-sm-4 col-form-label">Country</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bank-information" value="{{@$countryName}}"  id="country">
                        </div>
                    </div>


                    {{--<div class="form-group row">--}}
                        {{--<label for="acholder" class="col-sm-4 col-form-label">BIC/SWIFT</label>--}}
                        {{--<div class="col-sm-8">--}}
                            {{--<input type="text" class="form-control" id="acholder">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="form-group row">--}}
                        {{--<label for="acholder" class="col-sm-4 col-form-label">Name of the Bank</label>--}}
                        {{--<div class="col-sm-8">--}}
                            {{--<input type="text" class="form-control" id="acholder">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                   
                </form>
            </div>
            </div>
        </div>
        <!-- bankaccount tab content End -->
    </div>
</nav>