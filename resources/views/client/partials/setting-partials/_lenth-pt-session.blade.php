<form id="coaching-session-form" name="coaching-session-form">
 <div class="card">
     <div class="card-body">
         <div class="custom-control custom-checkbox mb-3">
             {{--<input id="length_pt_session" class="custom-control-input" type="checkbox" name="length_pt_session" @if($length_pt_session) checked @endif>--}}
             <label for="length_pt_session" class="font-weight-bold">Length of PT sessions</label>
         </div>


         <div class="table-responsive disable-div" id="save-pt-sessions-div">
             <table class="table text-center">
                 <thead class="thead-light">
                     <tr>
                         <th scope="col">Nr</th>
                         <th scope="col">Listing</th>
                         <th scope="col">Session length</th>
                         {{--<th scope="col">Price change</th>--}}
                         {{--<th scope="col">Price Up</th>--}}
                         {{--<th scope="col">Price Down</th>--}}
                         {{--<th scope="col">(+) Rate Up%</th>--}}
                         {{--<th scope="col">(-) Rate Down%</th>--}}
                     </tr>
                 </thead>
                 <tbody>
                 @include('client.partials.setting-partials._common-sessions')

                 </tbody>
             </table>
         </div>
         <a href="javascript: void(0)" data-id="0" id="save-pt-sessions" class="btn success-btn mt-3">Edit</a>
     </div>
 </div>
</form>
