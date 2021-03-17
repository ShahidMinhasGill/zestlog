<h3 class="section-title mb-4">Foods List</h3>
<div class="pb-3 mb-3 border-bottom">
    <button class="btn success-btn">Add a new row</button>
    <button class="btn secondary-btn">Bulk upload</button>
</div>
<div class="table-responsive">
    <div class="food-table">
        <div class="food-table-col">
            <div class="food-table-head">
                <strong>Nr</strong>
                <div class="custom-control custom-checkbox ml-2 float-right">
                    <input type="checkbox" class="custom-control-input" id="customCheck1111">
                    <label class="custom-control-label" for="customCheck1111"></label>
                </div>
            </div>
            <div class="food-table-td">
                <strong>1</strong>
                <div class="custom-control custom-checkbox ml-2 float-right">
                    <input type="checkbox" class="custom-control-input" id="customCheck1112">
                    <label class="custom-control-label" for="customCheck1112"></label>
                </div>
            </div>
        </div>

        <div class="food-table-col">
            <div class="food-table-head p-grams-th1"><strong>Action</strong></div>
            <div class="food-table-td">
                <button class="btn success-btn sm-btn mb-2">Edit</button>
                <br>
                <button class="btn delete-btn sm-btn">Delete</button>
            </div>
        </div>

        <div class="food-table-col p-grams-col1">
            <div class="food-table-head border-right-dashed"><strong>ID</strong></div>
            <div class="food-table-td border-right-dashed">213646113165465</div>
        </div>
        <div class="food-table-col" style="flex: 0 0 120px">
            <div class="food-table-head border-right-dashed">
                <strong>Country</strong>
                <select class="custom-select">
                    <option selected>select</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="food-table-td border-right-dashed"><input type="text" class="form-control"></div>
        </div>
        <div class="food-table-col" style="flex: 0 0 120px">
            <div class="food-table-head border-right-dashed">
                <strong>Food Category</strong>
                <select class="custom-select">
                    <option selected>select</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="food-table-td border-right-dashed"><input type="text" class="form-control"></div>
        </div>
        <div class="food-table-col">
            <div class="food-table-head border-right-dashed">
                <strong class="text-left">Name</strong>
                <br>
                <div class="table-search d-flex mr-2">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search a name" class="form-control" style="width: 200px;">
                </div>

            </div>
            <div class="food-table-td border-right-dashed"><input type="text" class="form-control" value="Yogurt, Low fat, 5%"></div>
        </div>
        <div class="food-table-col photo-col">
            <div class="food-table-head">
                <strong>Photo</strong>
            </div>
            <div class="food-table-td">
                <span class="upload-img-wrapper">
                    <img src="{{asset('assets/images/Screenshot_1.png')}}" class="exer-img" alt="Illustration.png">
                    <input type="file" name="">
                </span>
            </div>
        </div>
        <div class="food-table-col" style="flex: 0 0 110px;">
            <div class="food-table-head">
                <strong class="p-grams-th" data-toggle="tooltip" data-placement="top" title="Click to Open">Per, grams <i class="fas fa-angle-double-right fa-lg ml-2 text-danger"></i></strong>
            </div>
            <div class="food-table-td">
                <input type="text" class="form-control" value="100">
            </div>
        </div>

        <div class="food-table-col food-list-col">
            <div class="food-table-head bg-light">
                <div class="food-list-head">
                    <ul class="list-unstyled1 list-inline food-list-items">
                        @for ($i = 0; $i < 20; $i++) <li class="list-inline-item">

                            <div class="fd-right"><span>Energy</span></div>
                            <div class="fd-left"><span>Kj</span></div>
                            </li>
                            @endfor
                    </ul>
                </div>
            </div>
            <div class="food-table-td">
                <div class="energy-digit">
                    @for ($i = 0; $i < 20; $i++) <div>359</div>
                @endfor
            </div>
        </div>
    </div>

    <div class="food-table-col portion-head-col">
        <div class="food-table-head portion-head">
            <div class="po-label"><strong>Portion #1</strong></div>
            <div class="po-grams"><strong>Grams</strong></div>
        </div>
        <div class="food-table-td portion-td">
            <div class="po-label">
                <input type="text" class="form-control" value="">
            </div>
            <div class="po-grams">
                <input type="text" class="form-control" value="">
            </div>
        </div>
    </div>
    <div class="food-table-col portion-head-col">
        <div class="food-table-head portion-head">
            <div class="po-label"><strong>Portion #2</strong></div>
            <div class="po-grams"><strong>Grams</strong></div>
        </div>
        <div class="food-table-td portion-td">
            <div class="po-label">
                <input type="text" class="form-control" value="">
            </div>
            <div class="po-grams">
                <input type="text" class="form-control" value="">
            </div>
        </div>
    </div>
    <div class="food-table-col portion-head-col">
        <div class="food-table-head portion-head">
            <div class="po-label"><strong>Portion #3</strong></div>
            <div class="po-grams"><strong>Grams</strong></div>
        </div>
        <div class="food-table-td portion-td">
            <div class="po-label">
                <input type="text" class="form-control" value="">
            </div>
            <div class="po-grams">
                <input type="text" class="form-control" value="">
            </div>
        </div>
    </div>
    <div class="food-table-col portion-head-col">
        <div class="food-table-head portion-head">
            <div class="po-label"><strong>Portion #4</strong></div>
            <div class="po-grams"><strong>Grams</strong></div>
        </div>
        <div class="food-table-td portion-td">
            <div class="po-label">
                <input type="text" class="form-control" value="">
            </div>
            <div class="po-grams">
                <input type="text" class="form-control" value="">
            </div>
        </div>
    </div>
    <div class="food-table-col portion-head-col">
        <div class="food-table-head portion-head">
            <div class="po-label"><strong>Portion #5</strong></div>
            <div class="po-grams"><strong>Grams</strong></div>
        </div>
        <div class="food-table-td portion-td">
            <div class="po-label">
                <input type="text" class="form-control" value="">
            </div>
            <div class="po-grams">
                <input type="text" class="form-control" value="">
            </div>
        </div>
    </div>
</div>
</div>