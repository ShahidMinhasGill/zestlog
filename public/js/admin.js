$(document).ready(function () {
    $(document).on("click", '.paq-pager ul.pagination a', function (e) {
        e.preventDefault();
        $page = $(this).attr('href').split('page=')[1];
        $type = $defaultType;
        updateFormData();
        renderAdmin();
    });

    $('body').on('click', '.delete_content', function (e) {
        e.preventDefault();
            $deleteId = this.id;
            var result = confirm(('Are you sure to delete'));
            if (result) {
                $type = 'delete';
                $formData = {
                    '_token': $token,
                    'id': $deleteId
                };
                renderAdmin();
            }
    });

    $('body').on('click', '.sorting', function (e) {
        e.preventDefault();
        $('.sorting').not(this).removeClass('fa-sort-asc fa-sort-desc').addClass('fa-sort');
        $sortColumn = $(this).parent().attr("id");
        if ($(this).hasClass('fa-sort-' + $asc)) {
            $(this).removeClass('fa-sort-' + $asc).addClass('fa-sort-' + $desc);
            $sortType = 'desc';
        } else if ($(this).hasClass('fa-sort-' + $desc)) {
            $(this).removeClass('fa-sort-' + $desc).addClass('fa-sort-' + $asc);
            $sortType = 'asc';
        } else {
            $(this).addClass('fa-sort-' + $asc);
            $sortType = 'asc';
        }
        $type = $defaultType;
        updateFormData();
        renderAdmin();
    });

    $('#search').keydown(function (e) {
        if (e.keyCode == 13) {
            event.preventDefault();
            $search = $(this).val();
            $page = 1;
            updateFormData();
            $type = $defaultType;
            renderAdmin();
        }
    });

    /**
     * This is used to get drop down data dynamically
     */
    $('body .drop_down_filters').change(function () {
        $dropDownFilters = {};
        var inputs = $(".drop_down_filters");
        for (var i = 0; i < inputs.length; i++) {
            $dropDownFilters[$(inputs[i]).attr('id')] = $(inputs[i]).val();
        }
        updateFormData();
        $type = $defaultType;
        renderAdmin();
    });
});

/**
 * This is used to control admin all functions
 */
function renderAdmin(uniqueId) {

    /**
     * This is user to render grid data on base of grid fields
     */
    var renderGrid = function () {
        $html = '';
        $result = $data.result;
        $gridFields = $data.gridFields;
        $('#total-record').html('[' + $data.total + ']');
        $(".paq-pager").html($data.pager);
        if ($result != '') {
            $.each($result, function (i, v) {
                $keyValue = v;
                $blockedDisplay = '';
                $html += '<tr id="row_' + $keyValue.id + '" class="' + $blockedDisplay + '">';
                $.each($gridFields, function (index, value) {
                    $columValue = v[value.name];
                    if (value.name == 'checkbox') {
                        $html += '<td id="column_' + value.name + '_' + $keyValue.id + '"><input type="checkbox" id="checkbox_"' + $keyValue.id + '></td>';
                    } else if (value.name == 'status') {
                        $class = 'badge badge-warning p-2';
                        $showStr = 'DeActivated';
                        if ($columValue == 1) {
                            $class = 'badge badge-success p-2';
                            $showStr = 'Activate';
                        } else if ($columValue == 0) {
                            $class = 'badge badge-danger p-2';
                            $showStr = 'Blocked';
                        }
                        $html += '<td id="column_' + value.name + '_' + $keyValue.id + '"><span class="' + $class + '">' + $showStr + '</span></td>';
                    } else if (typeof (value.custom) !== 'undefined' && typeof (value.custom.isAnchor) !== 'undefined') {
                        // $html += '<td id="column_' + value.name + '_' + $keyValue.id + '"><a href="'+value.custom.url+'/'+$keyValue.id+'/edit">' + $columValue + '</a></td>';
                        if ($keyValue.user_type != 2) {
                            $html += '<td id="column_' + value.name + '_' + $keyValue.id + '"><a href="freelance-profile/' + $keyValue.id + '">' + $columValue + '</a></td>';
                        } else {
                            $html += '<td id="column_' + value.name + '_' + $keyValue.id + '"><a href="enduser-profile/' + $keyValue.id + '">' + $columValue + '</a></td>';
                        }
                    } else if (value.name == 'is_identity_verified') {
                        $class = 'badge badge-danger p-2';
                        $showStr = 'Not Verified';
                        if ($columValue == 1) {
                            $class = 'badge badge-success p-2';
                            $showStr = ' Verified ';
                        } else if ($columValue == 0) {
                            $class = 'badge badge-warning p-2';
                            $showStr = 'Pending';
                        }
                        $html += '<td id="column_' + value.name + '_' + $keyValue.id + '"><span class="' + $class + '">' + $showStr + '</span></td>';
                    }
                    else if (value.name == 'is_coach_verify') {
                        $class = 'badge badge-danger p-2';
                        $showStr = 'Not Activate';
                        if ($columValue == 1) {
                            $class = 'badge badge-success p-2';
                            $showStr = ' Activated ';
                        }
                        $html += '<td id="column_' + value.name + '_' + $keyValue.id + '"><span class="' + $class + '">' + $showStr + '</span></td>';
                    }
                    else {
                        $html += '<td id="column_' + value.name + '_' + $keyValue.id + '">' + isNull($columValue) + '</td>';
                    }
                });
                var fn = window[$defaultType + 'Action'];
                if (typeof fn === 'function') { // used to trigger relative action
                    fn();
                }
                $html += '</tr>';
            });
        }

        $('#page-data').html($html);
    };

    /**
     * This is used to render plan action
     */
    renderPlansAction = function () {
        $id = $keyValue.id;
        $html += '<td>\n' +
            '<a href="' + $editRoute + '/' + $id + '/edit' +'" class="btn edit-btn sm-btn">Edit</a>\n' +
            '<a href="javascript: void(0)" id="delete_' + $id + '" class="delete_content btn delete-btn sm-btn">Delete</a>\n' +
            '</td>';
    }

    /**
     * This is used to check value null or not
     *
     * @returns {*}
     */
    var isNull = function (value) {
        if ((value === null && typeof value === "object") || typeof (value) === 'undefined') {
            return '';
        }

        return value;
    }

    /**
     * This is used to upload image
     */
    var uploadImage = function () {
        $('.uploader').dmUploader({
            url: $uploadImageRoute,
            allowedTypes: 'image/*',
            dataType: 'json',
            onBeforeUpload: function (id) {
                $('.uploader').data('dmUploader').settings.extraData = {
                    "_token": $token,
                    id: 1
                };
            },
            onNewFile: function (id, file) {
                $.danidemo.addFile('#demo-files', id, file);

                /*** Begins Image preview loader ***/
                if (typeof FileReader !== "undefined") {

                    var reader = new FileReader();

                    // Last image added
                    var img = $('#demo-files').find('.demo-image-preview').eq(0);

                    reader.onload = function (e) {
                        img.attr('src', e.target.result);
                    }

                    reader.readAsDataURL(file);

                } else {
                    // Hide/Remove all Images if FileReader isn't supported
                    $('#demo-files').find('.demo-image-preview').remove();
                }
                /*** Ends Image preview loader ***/

            },
            onUploadProgress: function (id, percent) {
                var percentStr = percent + '%';
                $.danidemo.updateFileProgress(id, percentStr);
            },
            onUploadSuccess: function (id, data) {
                if (typeof ($isUploadImage) !== 'undefined') {
                    $isUploadImage = true;
                }
                if (data.success == true) {
                    if (typeof $imageType != 'undefined' && $imageType == true) {
                        location.reload(true);
                    }
                    $.danidemo.updateFileStatus(id, 'success', 'Upload Complete');
                    $.danidemo.updateFileProgress(id, '100%');
                }
            },
            onUploadError: function (id, message) {
                //notificationMsg(message, error);
            },
            onFileTypeError: function (file) {
                notificationMsg('File \'' + file.name + '\' cannot be added: must be an Image', error);
            },
            onFileSizeError: function (file) {
                //notificationMsg('File \'' + file.name + '\' cannot be added: size excess limit', error);
            },
            onFallbackMode: function (message) {
                //notificationMsg('Browser not supported(do something else here!): ' + message, error);
            }
        });
    }

    /**
     * This is used to render grid routes
     */
    var callGridRender = function () {
         ajaxStartStop();
        $.ajax({
            url: $renderRoute,
            type: 'POST',
            data: $formData,
            success: function (data) {
                $data = data;
                renderGrid();
            },
            error: function ($error) {
                // notificationMsg($error, error);
            }
        });
    };

    var sorter = function () {
        // will be add later
    }

    /**
     * This is common function used to add record
     */
    var addRecord = function () {
        ajaxStartStop();
        $.ajax({
            url: $addRecordRoute,
            type: 'POST',
            data: $formData,
            success: function (data) {
                $message = data.message;
                if (data.success == true) {
                    $id = data.id;
                } else {
                    if ($.isArray(data.message)) {
                        $message = '';
                        $.each(data.message, function (i, v) {
                            $message += v + "\n";
                        })
                    }
                }
                swal("Done!", $message, "success");
            },
            error: function ($error) {

            }
        });
    }

    /**
     * This is used to display data
     */
    var displayData = function (uniqueId) {
        ajaxStartStop();
        $.ajax({
            url: $displayDataRoute,
            type: 'POST',
            data: $displayFormData,
            success: function (data) {
                if (data.success == true) {
                    $('#' + uniqueId).html(data.data);
                    if(data.pager !== 'undefined') {
                        $('.paq-pager').html(data.pager);
                    }
                    if (typeof ($dragDrop) !== 'undefined' && $dragDrop == true) {
                        draggableDropable();
                    }
                }
            },
            error: function ($error) {

            }
        });
    }

    var draggableDropable = function () {
        $("body .draggable").draggable();
        $("body .droppable").droppable({
            drop: function (event, ui) {
                let dropableId = $(this).attr('id');
                var draggableId = ui.draggable.attr("id");
                alert(dropableId);
                alert(draggableId);
            }
        });
    }

    /**
     * This is general function used to delete content
     */
    var destroy = function () {
        ajaxStartStop();
        $.ajax({
            url: $deleteRoute,
            type: 'Delete',
            data: $formData,
            success: function (data) {
                if (data.success == true) {
                    swal("Done!", data.message, "success");
                    $('#row_' + data.id).remove();
                    if (typeof ($reloadAfterDelete) !== 'undefined' && $reloadAfterDelete == true) {
                        $page = 1;
                        updateFormData();
                        $type = $defaultType;
                        renderAdmin();
                    }
                }
            },
            error: function ($error) {
                // notificationMsg($error, error);
            }
        });
    }

    /**
     * This is used to view popup
     */
    var viewPopup = function () {
        ajaxStartStop();
        $.ajax({
            url: $viewPopupRoute,
            type: 'POST',
            data: $formData,
            success: function (data) {
                $('#myModal').html(data.view);
                $('#myModal').modal('show');
            },
            error: function ($error) {
                notificationMsg($error, error);
            }
        });
    }

    // rendering grid
    if ($type.indexOf('render') !== -1) {
        callGridRender();
    } else if ($type.indexOf('delete') !== -1) {
        destroy();
    } else if($type.indexOf('addRecord') !== -1) {
        addRecord();
    } else if($type.indexOf('viewPopup') !== -1) {
        viewPopup();
    } else if($type.indexOf('displayData') !== -1) {
        displayData(uniqueId);
    }

    var functionList = {};
    functionList["sorter"] = sorter;
    functionList['uploadImage'] = uploadImage;
    if ($type in functionList) {
        functionList[$type]();
    }

}