<div class="card">
    <div class="card-body">
        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-sm-6">
                <h1 class="pagetitle">End Users</h1>
            </div>
            <div class="col-sm-6 text-left text-sm-right">
                <button class="btn secondary-btn sm-btn">Terms & Conditions</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <ul class="list-unstyled users-detals">
                    <li>
                        <p class="up-title"><strong>Total: </strong> <span>{{$total_users}}</span></p>
                    </li>
                    <li>
                        <p class="up-title"><strong>Signed up Yesterday: </strong> <span>{{$signup_yesterday}}</span></p>
                    </li>
                    <li>
                        <p class="up-title"><strong>Signed up Last Week: </strong> <span>{{$signup_last_week}}</span></p>
                    </li>
                    <li>
                        <p class="up-title"><strong>Signed up Last Month: </strong> <span>{{$signup_last_month}}</span></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>