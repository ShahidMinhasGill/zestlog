<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">Nr</th>
            <th scope="col">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1"></label>
                </div>
            </th>
            <th scope="col" class="text-center">Name
                <div class="table-search d-flex mr-2">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search a name" class="form-control" style="width: 200px;"id="search">
                </div>
            </th>
            <th scope="col" class="text-center">Username
                <div class="table-search d-flex mr-2">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search a user name" class="form-control" style="width: 200px;"id="userName">
                </div>
            </th>
            <th >Age
                <br> {!! Form::select('age', $age ?? '',null, ['class' => 'custom-select form-control drop_down_filters', 'id' => 'age']) !!}

            </th>

            <th >Gender
                <br><select  class="custom-select drop_down_filters" id="gender">
                    <option selected=""value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </th>

            {{--<th scope="col" class="text-center">Date of reg--}}
            {{--<br><input type="date" name="" class="form-control filterDate" id="accountRegDate">--}}
            {{--</th>--}}
            {{--<th scope="col" class="text-center">BMI, kg/m2--}}
            {{--<br><input type="text"name="bmi" id="bmi" class="form-control" style="width: 200px;">--}}
            {{--</th>--}}
            <th scope="col" class="text-center ">BMI category
                <br><select style="width:80px;" class="custom-select drop_down_filters" id="bmi">
                    <option value="" selected="">All</option>
                    <option value="1">Underweight (<18.5)</option>
                    <option value="2">Normal (18.5 - 24.9)</option>
                    <option value="3">Overweight (25 - 29.9)</option>
                    <option value="4">Obese (30 & Above)</option>
                </select>
            </th>
            <th scope="col" class="text-center">Booking Submission
                <br><input type="date"name="booking-submission" id="bookingSubmission" class="form-control" style="width: 200px;">
            </th>
            <th scope="col" class="text-center">Booking Subtotal
                <br><select style="width:80px;" class="custom-select">
                    <option selected="">All</option>
                </select>
            </th>
            <th scope="col" class="text-center">Country
                <br>{!! Form::select('country', $countries, null , ['class' => 'custom-select drop_down_filters','id'=>'country','name'=>'country']) !!}
            </th>
            {{--<th scope="col" class="text-center">State--}}
            {{--<br><select style="width:80px;" class="custom-select">--}}
            {{--<option selected="">All</option>--}}
            {{--</select>--}}
            {{--</th>--}}
            <th scope="col" class="text-center">City
                <br> {!! Form::select('city', $cities,null, ['class' => 'custom-select form-control drop_down_filters', 'id' => 'cityList']) !!}
            </th>
            <th scope="col" colspan="3" class="text-left">Status</th>
        </tr>
        </thead>
        <tbody id="page-data"></tbody>
    </table>
    <div class="paq-pager"></div>
</div>
