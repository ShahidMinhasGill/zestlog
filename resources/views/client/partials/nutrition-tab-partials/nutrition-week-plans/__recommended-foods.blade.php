<!-- <div class="recommended-head">
    <div class="row">
        <div class="col-6 bg-secondary text-white">
            <div class="recommendation-head text-center p-2">
                <strong>Recommendation</strong>
            </div>
        </div>
        <div class="col-6 bg-info text-white">
            <div class="consumed-head text-center p-2">
                <strong>Consumed</strong>
            </div>
        </div>
    </div>
</div> -->

<nav>
    <div class="nav nav-pills" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active Pricing-link" id="recommendations-tab" data-toggle="tab" href="#recommendations" role="tab" aria-controls="recommendations" aria-selected="false">Recommendations</a>

        <a class="nav-item nav-link Pricing-link" id="consumed-tab" data-toggle="tab" href="#consumed" role="tab" aria-controls="consumed" aria-selected="false">Consumed</a>
    </div>

    <div class="tab-content" id="nav-tabContent">
        <!-- start recommendation tab content -->
        <div class="tab-pane fade active show" id="recommendations" role="tabpanel" aria-labelledby="recommendations-tab">
            <div class="text-left mb-3">
                <a href="javascript: void(0)"><i class="fas fa-plus-circle fa-lg"></i></a>
            </div>

            <table class="r-foods-table table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">List of recommended foods</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Fat,gr</th>
                        <th scope="col">Carb,gr</th>
                        <th scope="col">Protein,gr</th>
                        <th scope="col" colspan="3">Kcal</th>
                    </tr>
                </thead>
                <tbody id="dragglist">
                    <tr class="drag-tr">
                        <th scope="row">
                            1
                        </th>
                        <td>White rice, cooked</td>
                        <td class="text-center"><span class="mr-2">2</span>Cup</td>
                        <td class="text-center fat-bg">----</td>
                        <td class="text-center carb-bg">----</td>
                        <td class="text-center pro-bg">----</td>
                        <td class="text-center kcal-bg">----</td>
                        <td class="border-right text-center"><a href="" class="text-dark"><i class="fas fa-times"></i></a></td>
                    </tr>
                    <tr class="drag-tr">
                        <th scope="row">
                            2
                        </th>
                        <td>Mince beef, 14%, fat, raw</td>
                        <td class="text-center"><span class="mr-2">30</span>gr</td>
                        <td class="text-center fat-bg">----</td>
                        <td class="text-center carb-bg">----</td>
                        <td class="text-center pro-bg">----</td>
                        <td class="text-center kcal-bg">----</td>
                        <td class="border-right text-center"><a href="" class="text-dark"><i class="fas fa-times"></i></a></td>
                    </tr>
                    <tr class="drag-tr">
                        <th scope="row">
                            3
                        </th>
                        <td>Olive oil</td>
                        <td class="text-center"><span class="mr-2">30</span>gr</td>
                        <td class="text-center fat-bg">----</td>
                        <td class="text-center carb-bg">----</td>
                        <td class="text-center pro-bg">----</td>
                        <td class="text-center kcal-bg">----</td>
                        <td class="border-right text-center"><a href="" class="text-dark"><i class="fas fa-times"></i></a></td>
                    </tr>
                    <tr class="drag-tr">
                        <th scope="row">
                            4
                        </th>
                        <td>White rice, cooked</td>
                        <td class="text-center"><span class="mr-2">2</span>Cup</td>
                        <td class="text-center fat-bg">----</td>
                        <td class="text-center carb-bg">----</td>
                        <td class="text-center pro-bg">----</td>
                        <td class="text-center kcal-bg">----</td>
                        <td class="border-right text-center"><a href="" class="text-dark"><i class="fas fa-times"></i></a></td>
                    </tr>
                    <tr class="drag-tr">
                        <th scope="row">
                            5
                        </th>
                        <td>Mince beef, 14%, fat, raw</td>
                        <td class="text-center"><span class="mr-2">30</span>gr</td>
                        <td class="text-center fat-bg">----</td>
                        <td class="text-center carb-bg">----</td>
                        <td class="text-center pro-bg">----</td>
                        <td class="text-center kcal-bg">----</td>
                        <td class="border-right text-center"><a href="" class="text-dark"><i class="fas fa-times"></i></a></td>
                    </tr>

                </tbody>
            </table>

            <div class="row no-gutters">
                <div class="col-md-9">
                    <table class="table table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" colspan="2" style="text-align: right; padding-right: 145px;">%</th>
                                <th scope="col" class="text-center">g</th>
                                <th scope="col" class="text-center">gr/kg.bw</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-bottom">
                                <th scope="row" class="border-right">Fat</th>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="fat progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="fat progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="fat progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <th scope="row" class="border-right">Carb</th>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="carb progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="carb progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="carb progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <th scope="row" class="border-right">Protein</th>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="protein progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="protein progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="protein progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-3 progress-lg d-flex align-items-center justify-content-center">
                    <div class="total-progress">
                        <div class="progress" data-percentage="25">
                            <span class="progress-left">
                                <span class="progress-bar"></span>
                            </span>
                            <span class="progress-right">
                                <span class="progress-bar"></span>
                            </span>
                            <div class="progress-value">
                                <div>
                                    <strong class="font-weight-bold">2300/</strong><span>2500</span><br>
                                    <span class="font-weight-bold">Kcal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End recommendation tab content -->

        <div class="tab-pane fade" id="consumed" role="tabpanel" aria-labelledby="consumed-tab">
            <!--start consumed tab content -->

            <table class="r-foods-table table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">List of recommended foods</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Fat,gr</th>
                        <th scope="col">Carb,gr</th>
                        <th scope="col">Protein,gr</th>
                        <th scope="col" colspan="3">Kcal</th>
                    </tr>
                </thead>
                <tbody id="dragglist">
                    <tr class="drag-tr">
                        <th scope="row">
                            1
                        </th>
                        <td>White rice, cooked</td>
                        <td class="text-center"><span class="mr-2">2</span>Cup</td>
                        <td class="text-center fat-bg">----</td>
                        <td class="text-center carb-bg">----</td>
                        <td class="text-center pro-bg">----</td>
                        <td class="text-center kcal-bg">----</td>
                        
                    </tr>
                    <tr class="drag-tr">
                        <th scope="row">
                            2
                        </th>
                        <td>Mince beef, 14%, fat, raw</td>
                        <td class="text-center"><span class="mr-2">30</span>gr</td>
                        <td class="text-center fat-bg">----</td>
                        <td class="text-center carb-bg">----</td>
                        <td class="text-center pro-bg">----</td>
                        <td class="text-center kcal-bg">----</td>
                       
                    </tr>
                    <tr class="drag-tr">
                        <th scope="row">
                            3
                        </th>
                        <td>Olive oil</td>
                        <td class="text-center"><span class="mr-2">30</span>gr</td>
                        <td class="text-center fat-bg">----</td>
                        <td class="text-center carb-bg">----</td>
                        <td class="text-center pro-bg">----</td>
                        <td class="text-center kcal-bg">----</td>
                       
                    </tr>
                    <tr class="drag-tr">
                        <th scope="row">
                            4
                        </th>
                        <td>White rice, cooked</td>
                        <td class="text-center"><span class="mr-2">2</span>Cup</td>
                        <td class="text-center fat-bg">----</td>
                        <td class="text-center carb-bg">----</td>
                        <td class="text-center pro-bg">----</td>
                        <td class="text-center kcal-bg">----</td>
                        
                    </tr>
                    <tr class="drag-tr">
                        <th scope="row">
                            5
                        </th>
                        <td>Mince beef, 14%, fat, raw</td>
                        <td class="text-center"><span class="mr-2">30</span>gr</td>
                        <td class="text-center fat-bg">----</td>
                        <td class="text-center carb-bg">----</td>
                        <td class="text-center pro-bg">----</td>
                        <td class="text-center kcal-bg">----</td>
                        
                    </tr>

                </tbody>
            </table>

            <div class="row no-gutters">
                <div class="col-md-9">
                    <table class="table table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" colspan="2" style="text-align: right; padding-right: 145px;">%</th>
                                <th scope="col" class="text-center">g</th>
                                <th scope="col" class="text-center">gr/kg.bw</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-bottom">
                                <th scope="row" class="border-right">Fat</th>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="fat progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="fat progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="fat progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <th scope="row" class="border-right">Carb</th>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="carb progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="carb progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="carb progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <th scope="row" class="border-right">Protein</th>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="protein progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="protein progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="nutri-list justify-content-center">
                                        <div class="progress-wrapper">
                                            <div class="protein progress" data-percentage="25">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">
                                                    <div>
                                                        25/40
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-3 progress-lg d-flex align-items-center justify-content-center">
                    <div class="total-progress">
                        <div class="progress" data-percentage="25">
                            <span class="progress-left">
                                <span class="progress-bar"></span>
                            </span>
                            <span class="progress-right">
                                <span class="progress-bar"></span>
                            </span>
                            <div class="progress-value">
                                <div>
                                    <strong class="font-weight-bold">2300/</strong><span>2500</span><br>
                                    <span class="font-weight-bold">Kcal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end consumed tab content -->
        </div>
    </div>
</nav>