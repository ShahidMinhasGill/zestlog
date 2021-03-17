<form id="group-coaching-form" name="group-coaching-form">
<div class="card">
     <div class="card-body">
         <div class="custom-control custom-checkbox mb-3">
             <input id="{{$groupId}}" class="custom-control-input" type="checkbox" name="{{$groupId}}" @if($checkedId) checked @endif>
             <label for="{{$groupId}}" class="custom-control-label font-weight-bold">{{$title}}</label>
         </div>

         <div class="table-responsive">
             <table class="table text-center">
                 <thead class="thead-light">
                     <tr>
                         <th scope="col">Nr</th>
                         <th scope="col">Listing</th>
                         <th scope="col">No. of participants</th>
                         <th scope="col">Price change</th>
                         <th scope="col">Price Up</th>
                         <th scope="col">Price Down</th>
                         <th scope="col">(+) Rate Up%</th>
                         <th scope="col" class="text-left" colspan="2">(-) Rate Down%</th>
                         <th class="bg-white border-0" scope="col"><a href=""><i class="fas fa-plus-circle fa-lg"></i></a></th>
                     </tr>
                 </thead>
                 <tbody>
                    @if(!empty($groupOnlineCoachings))
                        @foreach($groupOnlineCoachings as $key => $row)
                            <tr>
                         <th scope="row">{{$key+1}}</th>
                         <td>
                             <div class="custom-control custom-checkbox">
                                 <input id="group_is_listing_{{$row->id}}" class="custom-control-input group-coaching-checkbox listing group_listing_{{$row->id}}" type="checkbox" name="group_is_listing_{{$row->id}}" @if($row->is_listing == 1) checked @endif>
                                 <label for="group_is_listing_{{$row->id}}" class="custom-control-label"></label>
                             </div>
                         </td>
                         <td>
                             <div class="d-flex align-items-center">
                                 <input type="text" id="group_participant_count_{{$row->id}}" name="group_participant_count_{{$row->id}}" class="form-control text-center" value="{{$row->participant_count}}" style="width: 80px;">
                             </div>
                         </td>
                         <td class="br-td" class="br-td">
                             <div class="custom-control custom-checkbox">
                                 <input id="group_price_changed_{{$row->id}}" class="custom-control-input group-coaching-checkbox group-coaching-sessions" type="checkbox" name="group_price_changed_{{$row->id}}" @if($row->price_changed == 1) checked @endif>
                                 <label for="group_price_changed_{{$row->id}}" class="custom-control-label"></label>
                             </div>
                         </td>
                         <td class="br-td" class="br-td">
                             <div class="d-flex align-items-center">
                                 <div class="custom-control custom-radio">
                                     <input type="radio" id="group_priceup_checked_{{$row->id}}" name="group_price_checked_{{$row->id}}" class="custom-control-input group-coaching-sessions_{{$row->id}}" @if($row->price_checked == 1) checked @endif value="1">
                                     <label class="custom-control-label" for="group_priceup_checked_{{$row->id}}"></label>
                                 </div>
                                 <input type="text" id="group_price_up_{{$row->id}}" name="group_price_up_{{$row->id}}" class="form-control text-center group-coaching-sessions_{{$row->id}}" value="{{$row->price_up}}" style="width: 80px;">
                             </div>
                         </td>

                         <td class="br-td" class="br-td">
                             <div class="d-flex align-items-center">
                                 <div class="custom-control custom-radio">
                                     <input type="radio" id="group_pricedown_checked_{{$row->id}}" name="group_price_checked_{{$row->id}}" class="custom-control-input group-coaching-sessions_{{$row->id}}" @if($row->price_checked !== null && $row->price_checked == 0) checked="checked" @endif value="0">
                                     <label class="custom-control-label" for="group_pricedown_checked_{{$row->id}}"></label>
                                 </div>
                                 <div>
                                     <input type="text" id="group_price_down_{{$row->id}}" name="group_price_down_{{$row->id}}" class="form-control text-center group-coaching-sessions_{{$row->id}}" value="{{$row->price_down}}" style="width: 80px;">
                                 </div>
                             </div>
                         </td>
             
                         <td class="br-td" class="br-td">
                             <div class="d-flex align-items-center">
                                 <div class="custom-control custom-radio">
                                     <input type="radio" id="group_rateup_checked_{{$row->id}}" name="group_rate_checked_{{$row->id}}" class="custom-control-input group-coaching-sessions_{{$row->id}}" @if($row->rate_checked == 1) checked="checked" @endif value="1">
                                     <label class="custom-control-label" for="group_rateup_checked_{{$row->id}}"></label>
                                 </div>
                                 <div>
                                     <input type="text" id="group_rate_up_{{$row->id}}" name="group_rate_up_{{$row->id}}" class="form-control text-center group-coaching-sessions_{{$row->id}}" value="{{$row->rate_up}}" style="width: 80px;">
                                 </div>
                                 <span class="ml-2">%</span>
                             </div>
                         </td>
                         <td class="br-td" class="br-td">
                             <div class="d-flex align-items-center">
                                 <div class="custom-control custom-radio">
                                     <input type="radio" id="group_ratedown_checked_{{$row->id}}" name="group_rate_checked_{{$row->id}}" class="custom-control-input group-coaching-sessions_{{$row->id}}" @if($row->rate_checked !== null && $row->rate_checked == 0) checked="checked" @endif value="0">
                                     <label class="custom-control-label" for="group_ratedown_checked_{{$row->id}}"></label>
                                 </div>
                                 <div>
                                     <input type="text" id="group_rate_down_{{$row->id}}" name="group_rate_down_{{$row->id}}" class="form-control text-center group-coaching-sessions_{{$row->id}}" value="{{$row->rate_down}}" style="width: 80px;">
                                 </div>
                                 <span class="ml-2">%</span>
                             </div>
                         </td>

                         <td><a href=""><strong>Edit</strong></a></td>
                         <td><a href="" class="text-dark"><i class="fas fa-times fa-lg"></i></a></td>
                     </tr>
                        @endforeach
                    @endif
                 </tbody>
             </table>
         </div>

         <a href="javascript: void(0)" id="{{$uniqueId}}" class="btn success-btn mt-3">Edit/Save</a>
     </div>
 </div>
</form>
