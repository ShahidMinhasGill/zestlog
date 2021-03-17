<div class="row mb-4">
    <div class="col-md-6">
        <h3 class="section-title">Week Plans</h3>
    </div>
    <div class="col-md-6 text-left text-md-right">
        <button class="btn primary-btn">Create a new plan</button>
    </div>
</div>

<div class="table-responsive">
    <table class="table text-center">
        <thead class="thead-light">
            <tr>
                <th scope="col">Nr</th>
                <th scope="col">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1"></label>
                    </div>
                </th>
                <th scope="col">
                    <div class="table-search d-flex">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search a name" class="form-control" style="width: 200px;">
                    </div>
                </th>
                <th scope="col">Category</th>
                <th scope="col">For</th>
                <th scope="col">Created by<br>
                    <select style="width:80px;" class="custom-select">
                        <option selected="">All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </th>
                <th scope="col" class="text-left" colspan="3">Access<br>
                    <select style="width:80px;" class="custom-select">
                        <option selected="">All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck2">
                        <label class="custom-control-label" for="customCheck2"></label>
                    </div>
                </td>
                <td class="text-left">Fat Loss #1</td>
                <td>Nutrition/Diet</td>
                <td>One week</td>
                <td>------</td>
                <td>Public</td>
                <td><a href="">Description</a></td>
                <td class="text-right"><button class="btn edit-btn sm-btn">Edit</button>
                    <button class="btn delete-btn sm-btn" data-toggle="modal" data-target="#nutri-program-delete">Delete</button>

                    <!-- Modal -->
                    <div class="modal fade" id="nutri-program-delete" tabindex="-1" role="dialog" aria-labelledby="nutri-program-deleteLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header p-1 border-0">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <p class="font-weight-bold py-4">Are you sure you want to delete this program?</p>
                                    <div class="text-center mb-4">
                                        <button class="btn success-btn mr-2">Ok</button>
                                        <button class="btn secondary-btn">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck3">
                        <label class="custom-control-label" for="customCheck3"></label>
                    </div>
                </td>
                <td class="text-left">Fat Loss #2</td>
                <td>Nutrition/Diet</td>
                <td>One week</td>
                <td>------</td>
                <td>Public</td>
                <td><a href="">Description</a></td>
                <td class="text-right"><button class="btn edit-btn sm-btn">Edit</button>
                    <button class="btn delete-btn sm-btn">Delete</button>
                </td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck4">
                        <label class="custom-control-label" for="customCheck4"></label>
                    </div>
                </td>
                <td class="text-left">Muscle gain #1</td>
                <td>Nutrition/Diet</td>
                <td>One week</td>
                <td>------</td>
                <td>Public</td>
                <td><a href="">Description</a></td>
                <td class="text-right"><button class="btn edit-btn sm-btn">Edit</button>
                    <button class="btn delete-btn sm-btn">Delete</button>
                </td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck4">
                        <label class="custom-control-label" for="customCheck4"></label>
                    </div>
                </td>
                <td class="text-left">Power #1</td>
                <td>Nutrition/Diet</td>
                <td>One week</td>
                <td>------</td>
                <td>Public</td>
                <td><a href="">Description</a></td>
                <td class="text-right"><button class="btn edit-btn sm-btn">Edit</button>
                    <button class="btn delete-btn sm-btn">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>