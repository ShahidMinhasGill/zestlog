<form id="pt-location-form" name="pt-location-form">
 <div class="card">
     <div class="card-body">
         <div class="custom-control custom-checkbox mb-3">
             {{--<input id="pt_session_location"  class="custom-control-input" type="checkbox" name="pt_session_location" value="true" @if($pt_session_location) checked @endif>--}}
             <label class="font-weight-bold">PT session Location</label>
         </div>

         <div class="table-responsive disable-div" id="save-pt-locations-div">
             <table class="table text-center">
                 <thead class="thead-light">
                     <tr>
                         <th scope="col">Nr</th>
                         {{--<th scope="col">Listing</th>--}}
                         <th class="text-left" scope="col">Name and Address</th>
                         {{--<th scope="col">Price change</th>--}}
                         {{--<th scope="col">Price Up</th>--}}
                         {{--<th scope="col">Price Down</th>--}}
                         {{--<th scope="col">(+) Rate Up%</th>--}}
                         {{--<th scope="col" class="text-left" colspan="2">(-) Rate Down%</th>--}}
                         <th class="bg-white border-0" scope="col"><a href="javascript: void(0)" id="add-pt-location"><i class="fas fa-plus-circle fa-lg"></i></a></th>
                     </tr>
                 </thead>
                 <tbody id="pt-locations-body">
                    @include('client.partials.setting-partials._common-pt-locations')
                 </tbody>
</table>
</div>

<a href="javascript: void(0)" data-id="0" id="save-pt-locations" class="btn success-btn mt-3">Edit</a>
</div>
</div>
</form>
