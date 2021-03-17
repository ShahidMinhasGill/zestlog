<div class="exer-table table-responsive">
    <div class="exer-table">
        <div class="exer-tb-head bg-light">
            <div class="exer-tb-th text-left">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Nr</label>
                </div>
            </div>
            <div class="exer-tb-th">Action</div>
            <div class="exer-tb-th id-th">ID</div>
            <div class="exer-tb-th gender-th male-th">
                <div class="mb-2">Male</div>
                <div class="gender-th-inner">
                    <span>Illustration</span>
                    <span>GIF</span>
                    <span>Video</span>
                </div>
            </div>
            <div class="exer-tb-th gender-th">
                <div class="mb-2">Female</div>
                <div class="gender-th-inner">
                    <span>Illustration</span>
                    <span>GIF</span>
                    <span>Video</span>
                </div>
            </div>
            <div class="exer-tb-th lang-th">
                <div class="land-header pb-2 mb-2">
                    <h4 class="lang-lable font-weight-bold mb-0 mr-3">English</h4>
                </div>
                <div class="lang-inner-th">
                    <div>
                        Name<br>
                        <div class="table-search d-flex mr-2">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Search a name" class="form-control" style="width: 200px;">
                        </div>
                    </div>

                    <div>
                        Body Part<br>
                        <select style="width:80px;" class="custom-select">
                            <option selected="">All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>

                    <div>
                        Target Muscle<br>
                        <select style="width:80px;" class="custom-select">
                            <option selected="">All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div>
                        Equipment<br>
                        <select style="width:80px;" class="custom-select">
                            <option selected="">All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div>
                        Training Form<br>
                        <select style="width:80px;" class="custom-select">
                            <option selected="">All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div>
                        Dicipline<br>
                        <select style="width:80px;" class="custom-select">
                            <option selected="">All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div>
                        Level<br>
                        <select style="width:80px;" class="custom-select">
                            <option selected="">All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div>
                        Priority<br>
                        <select style="width:80px;" class="custom-select">
                            <option selected="">All</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="text-left">Text</div>
                </div>
            </div>
        </div>

        <div class="exer-tb-body">
            <div class="exer-tb-td text-left">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck3">
                    <label class="custom-control-label" for="customCheck3">1</label>
                </div>
            </div>
            <div class="exer-tb-td">
                <button class="btn success-btn sm-btn mb-3">Edit</button>
                <br>
                <button class="btn delete-btn sm-btn">Delete</button></div>
            <div class="exer-tb-td id-td"><span>213646113165465</span></div>
            <div class="exer-tb-td gender-td male-td">
                <span class="upload-img-wrapper">
                    <img src="{{asset('assets/images/Screenshot_1.png')}}" class="exer-img" alt="Illustration.png">
                    <input type="file" name="">
                </span>
                <span class="upload-img-wrapper">
                    <img src="{{asset('assets/images/Screenshot_2.png')}}" class="exer-img" alt="Illustration.png">
                    <input type="file" name="">
                </span>
                <span class="upload-img-wrapper">
                    <img src="{{asset('assets/images/Screenshot_3.png')}}" class="exer-img" alt="Illustration.png">
                    <input type="file" name="">
                </span>
            </div>
            <div class="exer-tb-td gender-td">
                <span class="upload-img-wrapper">
                    <img src="{{asset('assets/images/Screenshot_1.png')}}" class="exer-img" alt="Illustration.png">
                    <input type="file" name="">
                </span>
                <span class="upload-img-wrapper">
                    <img src="{{asset('assets/images/Screenshot_2.png')}}" class="exer-img" alt="Illustration.png">
                    <input type="file" name="">
                </span>
                <span class="upload-img-wrapper">
                    <img src="{{asset('assets/images/Screenshot_3.png')}}" class="exer-img" alt="Illustration.png">
                    <input type="file" name="">
                </span>
            </div>
            <div class="exer-tb-td lang-td">
                <div class="lang-inner-td">
                    <div style="width: 200px; flex: 0 0 200px">DB Biceps Curl</div>
                    <div>Arm</div>
                    <div>Biceps</div>
                    <div>DB</div>
                    <div>Resistance</div>
                    <div>Dicipline text</div>
                    <div>Level text</div>
                    <div>Priority text</div>
                    <div style="flex:auto">
                        <textarea id="my-textarea" class="form-control" name="" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="exer-tb-body">
            <div class="exer-tb-td text-left">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck2">
                    <label class="custom-control-label" for="customCheck2">1</label>
                </div>
            </div>
            <div class="exer-tb-td">
                <button class="btn success-btn sm-btn mb-3">Edit</button>
                <br>
                <button class="btn delete-btn sm-btn">Delete</button></div>
            <div class="exer-tb-td id-td"><span>213646113165465</span></div>
            <div class="exer-tb-td gender-td male-td">
                <span class="upload-img-wrapper">
                    <img src="{{asset('assets/images/Screenshot_1.png')}}" class="exer-img" alt="Illustration.png">
                    <input type="file" name="">
                </span>
                <span class="upload-img-wrapper">
                    <img src="{{asset('assets/images/Screenshot_2.png')}}" class="exer-img" alt="gif-image">
                    <input type="file" name="">
                </span>

                <span class="upload-img-wrapper">
                    <img src="{{asset('assets/images/Screenshot_3.png')}}" class="exer-img" alt="exercise-video">
                    <input type="file" name="">
                </span>
            </div>
            <div class="exer-tb-td gender-td">
                <span class="upload-img-wrapper">
                    <img src="{{asset('assets/images/Screenshot_1.png')}}" class="exer-img" alt="Illustration.png">
                    <input type="file" name="">
                </span>
                <span class="upload-img-wrapper">
                    <img src="{{asset('assets/images/Screenshot_2.png')}}" class="exer-img" alt="Illustration.png">
                    <input type="file" name="">
                </span>
                <span class="upload-img-wrapper">
                    <img src="{{asset('assets/images/Screenshot_3.png')}}" class="exer-img" alt="Illustration.png">
                    <input type="file" name="">
                </span>
            </div>
            <div class="exer-tb-td lang-td">
                <div class="lang-inner-td">
                    <div style="width: 200px; flex: 0 0 200px">DB Biceps Curl</div>
                    <div>Arm</div>
                    <div>Biceps</div>
                    <div>DB</div>
                    <div>Resistance</div>
                    <div>Dicipline text</div>
                    <div>Level text</div>
                    <div>Priority text</div>
                    <div style="flex:auto">
                        <textarea id="my-textarea" class="form-control" name="" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>