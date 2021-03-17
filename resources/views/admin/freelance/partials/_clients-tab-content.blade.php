<style>
    thead tr th select {
    min-width: 80px;
}
</style>
<nav class="inner-tab">
    <div class="nav nav-pills">
        <a class="nav-item nav-link active" data-toggle="tab" href="#clients-active" role="tab" aria-controls="clients-active" aria-selected="true">Active</a>

        <a class="nav-item nav-link" data-toggle="tab" href="#clients-Waiting" role="tab" aria-controls="clients-Waiting" aria-selected="true">Waiting</a>

        <a class="nav-item nav-link" data-toggle="tab" href="#clients-Archived" role="tab" aria-controls="clients-Archived" aria-selected="true">Archived</a>

    </div>
</nav>

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="clients-active" role="tabpanel" aria-labelledby="clients-active-tab">
        <!-- clients active table -->
        <div class="table-responsive">
            <table class="table text-center">
                <thead class="thead-light">
                    <th>Nr</th>
                    <th>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck333">
                            <label class="custom-control-label" for="customCheck333"></label>
                        </div>
                    </th>
                    <th>
                        Client<br>
                        <div class="table-search d-flex mr-2">
                            <i class="fas fa-search"></i>
                            <input type="text" id="search" name="search" placeholder="Search a name" class="form-control">
                        </div>
                    </th>
                    <th>
                        Age
                        <br>
                        <select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        Gender
                        <br>
                        <select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        BMI category
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        Booking submission
                        <br>
                        <input type="date" class="form-control" value="dd/mm/yyyy">
                    </th>
                    <th>
                        Booking subtotal
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        Country
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        City
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        Partner<br>
                        <div class="table-search d-flex mr-2">
                            <i class="fas fa-search"></i>
                            <input type="text" id="search" name="search" placeholder="Search a name" class="form-control">
                        </div>
                    </th>
                    <th>Status</th>
                </thead>

                <tbody>
                    <tr>
                        <th>1</th>
                        <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="cl1">
                            <label class="custom-control-label" for="cl1"></label>
                        </div>
                        </td>
                        <td class="text-left"><a href="#!">Same Nilson</a></td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>USD 2500</td>
                        <td>---</td>
                        <td>---</td>
                        <td><a href="#!">James Wrights</a></td>
                        <td><b>Active</b></td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="cl1">
                            <label class="custom-control-label" for="cl1"></label>
                        </div>
                        </td>
                        <td class="text-left"><a href="#!">Same Nilson</a></td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>USD 2500</td>
                        <td>---</td>
                        <td>---</td>
                        <td><a href="#!">James Wrights</a></td>
                        <td><b>Active</b></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="clients-Waiting" role="tabpanel" aria-labelledby="clients-Waiting-tab">
        <!-- clients Waiting table -->
        <div class="table-responsive">
            <table class="table text-center">
                <thead class="thead-light">
                    <th>Nr</th>
                    <th>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck333">
                            <label class="custom-control-label" for="customCheck333"></label>
                        </div>
                    </th>
                    <th>
                        Client<br>
                        <div class="table-search d-flex mr-2">
                            <i class="fas fa-search"></i>
                            <input type="text" id="search" name="search" placeholder="Search a name" class="form-control">
                        </div>
                    </th>
                    <th>
                        Age
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        Gender
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        BMI category
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    
                    <th>Booking submission<br>
                    <input type="date" class="form-control" value="dd/mm/yyyy"></th>
                    <th>
                        Booking subtotal
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        Country
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        City
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>Status</th>
                </thead>

                <tbody>
                    <tr>
                        <th>1</th>
                        <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="cl1">
                            <label class="custom-control-label" for="cl1"></label>
                        </div>
                        </td>
                        <td class="text-left"><a href="#!">Same Nilson</a></td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>USD 2500</td>
                        <td>---</td>
                        <td>---</td>
                        <td><b>Waiting</b></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="clients-Archived" role="tabpanel" aria-labelledby="clients-Archived-tab">
        <!-- clients Archived table -->
        <div class="table-responsive">
            <table class="table text-center">
                <thead class="thead-light">
                    <th>Nr</th>
                    <th>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck333">
                            <label class="custom-control-label" for="customCheck333"></label>
                        </div>
                    </th>
                    <th>
                        Client<br>
                        <div class="table-search d-flex mr-2">
                            <i class="fas fa-search"></i>
                            <input type="text" id="search" name="search" placeholder="Search a name" class="form-control">
                        </div>
                    </th>
                    <th>
                        Age
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        Gender
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        BMI category
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        Booking submission<br>
                        <input type="date" class="form-control" value="dd/mm/yyyy">
                    </th>
                    <th>
                        Booking subtotal
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        Country
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    
                    <th>
                        City
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>
                        Reason for Archiving
                        <br><select  class="custom-select">
                            <option selected>All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </th>
                    <th>Status</th>
                </thead>

                <tbody>
                    <tr>
                        <th>1</th>
                        <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="cl1">
                            <label class="custom-control-label" for="cl1"></label>
                        </div>
                        </td>
                        <td class="text-left"><a href="#!">Same Nilson</a></td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>USD 2500</td>
                        <td>---</td>
                        <td>---</td>
                        <td><b>Completed</b></td>
                        <td><b>Archived</b></td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="cl1">
                            <label class="custom-control-label" for="cl1"></label>
                        </div>
                        </td>
                        <td class="text-left"><a href="#!">Same Nilson</a></td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>USD 2500</td>
                        <td>---</td>
                        <td>---</td>
                        <td><b>Rejected</b></td>
                        <td><b>Archived</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>