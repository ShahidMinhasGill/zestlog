<div class="modal-body">
    <h3 class="section-title">Dropdown options</h3>
    <h3 class="hi-bold">{{$tableName}}</h3>
    <form action="">
        <div class="form-group row">
            <label for="date" class="col-sm-3 col-form-label"id="block">New option</label>
            <div class="col-sm-7">
                @if(!empty($set))
                    <select class="form-control custom-select" id="customized-value">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                    </select>
                @else
                    <input type="text" class="form-control" id="customized-value" value="">
                @endif
            </div>
            <button type="button" class="btn success-btn save-customized-option"id="{{$customizeId}}">Add</button>
        </div>
        <div class="form-group row modal-footer">
            <label class="col-sm-12 col-form-label"id="">Already added</label>
            <table class="col-12 customize-table_remove_{{$customizeId}}"id="">
                @foreach($obj as $key=>$row)
                    <tr id="remove_{{$key}}_{{$customizeId}}_td">
                        <td class="remove-customize-option" id="remove_{{$key}}_{{$customizeId}}">{{$row}}</td>
                        <td>
                            <a class="remove-customize-option" href="javascript: void(0)" id="remove_{{$key}}_{{$customizeId}}">Remove</a>
                        </td>
                    </tr>
                @endforeach
            </table>
            @if(empty($obj))
                <div class="form-group row col-12 hide-text">
                    <div class="col-sm-12 d-flex">
                        <span class="mx-3">You have not added a new options yet</span>
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn success-btn close-customized-option"id="close-customized-popup">Save</button>
</div>
