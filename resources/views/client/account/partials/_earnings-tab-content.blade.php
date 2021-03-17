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
                    </div>
                    <h3 class="section-title">Beneficiary Information</h3>
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
                            {{--<input type="text" class="form-control bank-information" value="{{@$bankAccountDetails['swift']}}"  id="swift">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="form-group row">--}}
                        {{--<label for="acholder" class="col-sm-4 col-form-label">Name of the Bank</label>--}}
                        {{--<div class="col-sm-8">--}}
                            {{--<input type="text" class="form-control bank-information" value="{{@$bankAccountDetails['bank_name']}}"  id="account_name">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                   
                </form>
            </div>
            </div>
            {{--<button class="btn success-btn" id="bank-account-edit">Edit</button>--}}
        </div>

        <!-- bankaccount tab content End -->

        <!-- earninghistory tab content start -->
        <div class="tab-pane fade" id="nav-earninghistory" role="tabpanel" aria-labelledby="nav-earninghistory">
            <div class="row">
                <div class="col-12 earninghistory-content">
                    <h3 class="section-title mb-3">
                        Earning history
                    </h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" width="50px">Nr.</th>
                                    <th scope="col" width="120px">Status</th>
                                    <th scope="col" width="50px">Type</th>
                                    <th scope="col" width="160px">Submission/purchase<br>date</th>
                                    <th scope="col" width="100px">Earning</th>
                                    <th scope="col">Discription</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{--<tr>--}}
                                    {{--<th scope="row">1</th>--}}
                                    {{--<td>Fund</td>--}}
                                    {{--<td>Recived booking</td>--}}
                                    {{--<td>--/--/----</td>--}}
                                    {{--<td>-------</td>--}}
                                    {{--<td><a href="">View booking</a></td>--}}
                                {{--</tr>--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- earninghistory tab content End -->
    </div>
</nav>
