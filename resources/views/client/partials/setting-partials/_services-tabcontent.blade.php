<h3 class="section-title mb-3">Services Available for booking</h3>
<div class="table-responsive">
    <table class="table text-center">
        <thead class="thead-light">
            <tr>
                <th scope="col" width="50">Nr</th>
                <th scope="col" width="50">Listing</th>
                <th scope="col" class="text-left">Name</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data['services'] as $key=>$row)
            @if(!empty(isHide()) || $row['id'] != 2)
                <tr>
                <th scope="row">{{$key+1}}</th>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input id="checkbox-services_{{$row['id']}}" class="custom-control-input checkbox-services" data-key="{{$row['key_pair']}}" type="checkbox" name="" @if(!empty($row['is_checked'])) checked @endif value="1">
                        <label for="checkbox-services_{{$row['id']}}" class="custom-control-label"></label>
                    </div>
                </td>

                <td class="text-left">{{$row['name']}}</td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>
