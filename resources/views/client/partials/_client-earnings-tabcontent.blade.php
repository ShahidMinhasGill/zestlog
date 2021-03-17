<!-- <div class="col-md-6 account-left-col">
    <h3 class="section-title">
        Payout
    </h3>
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Nr.</th>
                    <th scope="col">Payout date</th>
                    <th scope="col">Amount transfered</th>
                    <th scope="col">Currency</th>
                    <th scope="col">to account</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>-------</td>
                    <td>-------</td>
                    <td>-------</td>
                    <td>-------</td>
                    <td>Receipt</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>-------</td>
                    <td>-------</td>
                    <td>-------</td>
                    <td>-------</td>
                    <td>Receipt</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>-------</td>
                    <td>-------</td>
                    <td>-------</td>
                    <td>-------</td>
                    <td>Receipt</td>
                </tr>
            </tbody>
        </table>
    </div>
</div> -->

<!-- <div class="col-md-6">
    <h3 class="section-title">Bank account
        <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></i>
    </h3>

    <form action="">
        <div class="form-group row">
            <label for="acholder" class="col-sm-4 col-form-label">Account holder</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="acholder">
            </div>
        </div>
        <div class="form-group row">
            <label for="acholder" class="col-sm-4 col-form-label">Account number</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="acholder">
            </div>
        </div>
        <div class="form-group row">
            <label for="acholder" class="col-sm-4 col-form-label">BIC code</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="acholder">
            </div>
        </div>
        <div class="form-group row">
            <label for="acholder" class="col-sm-4 col-form-label">SWIFT</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="acholder">
            </div>
        </div>
        <div class="form-group row">
            <label for="acholder" class="col-sm-4 col-form-label">Name of the Bank</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="acholder">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-12 text-right">
                <button class="btn primary-btn">Edit</button>
            </div>
        </div>
    </form>
</div> -->

<nav class="inner-tab">
    <div class="nav nav-pills" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-funds-tab" data-toggle="tab" href="#nav-funds" role="tab" aria-controls="nav-funds" aria-selected="true">Funds</a>

        <a class="nav-item nav-link" id="nav-payouts-tab" data-toggle="tab" href="#nav-payouts" role="tab" aria-controls="nav-payouts" aria-selected="false">Payouts</a>

        <a class="nav-item nav-link" id="nav-bankaccount-tab" data-toggle="tab" href="#nav-bankaccount" role="tab" aria-controls="nav-bankaccount" aria-selected="false">Bank Accounts</a>

        <a class="nav-item nav-link" id="nav-earninghistory-tab" data-toggle="tab" href="#nav-earninghistory" role="tab" aria-controls="nav-earninghistory" aria-selected="false">Earning history</a>

    </div>

    <div class="tab-content" id="nav-tabContent">
        <!-- funds tab content start -->
        <div class="tab-pane fade show active" id="nav-funds" role="tabpanel" aria-labelledby="nav-funds">
            <div class="row">
                <div class="col-12 funds-content">
                    <h3 class="section-title">
                        Funds to be Paid out
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
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Pending</td>
                                    <td>Recived booking</td>
                                    <td>--/--/----</td>
                                    <td>-------</td>
                                    <td><a href="">View booking</a></td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Available</td>
                                    <td>Program sale</td>
                                    <td>--/--/----</td>
                                    <td>-------</td>
                                    <td>8 weeks fate loss - phase 2</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Available</td>
                                    <td>Program sale</td>
                                    <td>--/--/----</td>
                                    <td>-------</td>
                                    <td>8 weeks fate loss - phase 1</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- funds tab content End -->

        <!-- payouts tab content Start -->
        <div class="tab-pane fade" id="nav-payouts" role="tabpanel" aria-labelledby="nav-payouts">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="section-title mb-3">
                        Payouts
                    </h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nr.</th>
                                    <th scope="col">Payout date</th>
                                    <th scope="col">Amount transfered</th>
                                    <th scope="col">Currency</th>
                                    <th scope="col">to account</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>-------</td>
                                    <td>-------</td>
                                    <td>-------</td>
                                    <td>-------</td>
                                    <td><a href="">Receipt</a></td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>-------</td>
                                    <td>-------</td>
                                    <td>-------</td>
                                    <td>-------</td>
                                    <td><a href="">Receipt</a></td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>-------</td>
                                    <td>-------</td>
                                    <td>-------</td>
                                    <td>-------</td>
                                    <td><a href="">Receipt</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- payouts tab content End -->

        <!-- bankaccount tab content Start -->
        <div class="tab-pane fade" id="nav-bankaccount" role="tabpanel" aria-labelledby="nav-bankaccount">
            <div class="row">
            <div class="col-md-6">
                <h3 class="section-title">Bank account <small class="font-weight-lighter h6">(Payouts will be transferred to the following bank account)</small>
                </h3>

                <form action="">
                    <div class="form-group row">
                        <label for="acholder" class="col-sm-4 col-form-label">Account holder</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="acholder">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="acholder" class="col-sm-4 col-form-label">Account number</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="acholder">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="acholder" class="col-sm-4 col-form-label">BIC code</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="acholder">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="acholder" class="col-sm-4 col-form-label">SWIFT</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="acholder">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="acholder" class="col-sm-4 col-form-label">Name of the Bank</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="acholder">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <button class="btn success-btn">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
            </div>
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
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Fund</td>
                                    <td>Recived booking</td>
                                    <td>--/--/----</td>
                                    <td>-------</td>
                                    <td><a href="">View booking</a></td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Fund</td>
                                    <td>Program sale</td>
                                    <td>--/--/----</td>
                                    <td>-------</td>
                                    <td>8 weeks fate loss - phase 2</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Fund</td>
                                    <td>Program sale</td>
                                    <td>--/--/----</td>
                                    <td>-------</td>
                                    <td>8 weeks fate loss - phase 1</td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>Paid out</td>
                                    <td>Recived booking</td>
                                    <td>--/--/----</td>
                                    <td>-------</td>
                                    <td><a href="">View booking</a></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- earninghistory tab content End -->
    </div>
</nav>