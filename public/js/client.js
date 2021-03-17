$(document).ready(function () {
    $(document).on("click", '.paq-pager ul.pagination a', function (e) {
        if (typeof ($isBladePaginator) === 'undefined') {
            e.preventDefault();
            $page = $(this).attr('href').split('page=')[1];
            $type = $defaultType;
            updateFormData();
            renderClient();
        }
    });
    $('body').on('click', '.delete_content', function (e) {
        e.preventDefault();
        if (typeof ($viewOnly) === 'undefined' || $viewOnly != 1) {
            $deleteId = this.id;
            swal({
                title: "Are you sure to delete?",
                icon: "warning",
                buttons: ["Cancel", "Delete"],
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                dangerMode: true,
                closeOnCancel: true
            }).then(function(isConfirm) {
                if (isConfirm) {
                    $type = 'delete';
                    $formData = {
                        '_token': $token,
                        'id': $deleteId
                    };
                    renderClient();
                }
            })
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
        renderClient();
    });

    $('#search').keydown(function (e) {
        if (e.keyCode == 13) {
            event.preventDefault();
            $search = $(this).val();
            $page = 1;
            updateFormData();
            $type = $defaultType;
            renderClient();
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
        renderClient();
    });

});

/**
 * This is used to control admin all functions
 */
function renderClient(uniqueId) {
    /**
     * This is user to render grid data on base of grid fields
     */
    var renderGrid = function () {
        $html = '';
        $result = $data.result;
        $gridFields = $data.gridFields;
        $count = 1;
        $('#total-record').html('[' + $data.total + ']');
        let paqPager = 'paq-pager';
        if (typeof ($isImportRender) !== 'undefined') {
            if ($isImportRender == 1) {
                paqPager = 'import-plan-class.paq-pager';
            } else {
                paqPager = 'paq-pager';
            }
        }
        $("." + paqPager).html($data.pager);
        if ($result != '') {
            $.each($result, function (i, v) {
                $keyValue = v;
                $blockedDisplay = '';
                $html += '<tr id="row_' + $keyValue.id + '" class="' + $blockedDisplay + '">';
                let isColumnAction = false;
                $.each($gridFields, function (index, value) {
                    $columValue = v[value.name];
                    if(value.name == 'action_column') {
                        isColumnAction = true;
                        var fn = window[$defaultType + 'Action'];
                        if (typeof fn === 'function') { // used to trigger relative action
                            fn();
                        }
                    } else if (value.name == 'radio_box') {
                        $html += '<td id="column_' + value.name + '_' + $keyValue.id + '"><input class="checkbox-import-select" name="radio_import_plans" type="radio" id="checkbox_' + $keyValue.id + '"></td>';
                    } else if (value.name == 'checkbox') {
                        $html += '<td id="column_' + value.name + '_' + $keyValue.id + '"><input class="checkbox-import-select" type="checkbox" id="checkbox_' + $keyValue.id + '"></td>';
                    } else if (typeof (value.custom) !== 'undefined' && typeof (value.custom.isAnchor) !== 'undefined') {
                        if ($keyValue.status == 1) {
                            if (value.custom.url != '')
                                $html += '<td class="client_name_click" id="column_' + value.name + '_' + $keyValue.id + '_' + $keyValue.unique_id + '"><a href="' + value.custom.url + '/' + $keyValue.id + '/">' + $columValue + '</a></td>';
                            else
                                $html += '<td class="client_name_click" id="column_' + value.name + '_' + $keyValue.id + '_' + $keyValue.unique_id + '"><a target="_blank" href="' + value.custom.url + '/client/' + $keyValue.unique_id + '/program">' + $columValue + '</a></td>';
                        } else if (value.name == 'user_name') {
                            $html += '<td class="client_user_name_click" id="column_' + value.name + '_' + $keyValue.id + '_' + $keyValue.unique_id + '"><a target="_blank" href="' + value.custom.url + '/client/' + $keyValue.unique_id + '/program">' + $columValue + '</a></td>';
                        }
                        else
                            $html += '<td id="column_' + value.name + '_' + $keyValue.id + '_' + $keyValue.unique_id + '">' + $columValue + '</a></td>';
                    } else if (value.name == 'id') {
                        $html += '<td id="column_' + value.name + '_' + $keyValue.id + '">' + $count + '</td>';
                        $count++;
                    } else if (value.name == 'publish') {
                        if ($keyValue.publish == 1) {
                            $html += '<td id="column_' + value.name + '_' + $keyValue.id + '">Published</td>';
                        } else {
                            $html += '<td id="column_' + value.name + '_' + $keyValue.id + '">Not Published</td>';
                        }
                    } else if (value.name == 'new_repeat') {
                        if ($keyValue.new_repeat == 0) {
                            $html += '<td id="column_' + value.name + '_' + $keyValue.id + '">Repeat</td>';
                        } else {
                            $html += '<td id="column_' + value.name + '_' + $keyValue.id + '">New</td>';
                        }
                    } else if (value.name == 'booking_form') {
                        $class = 'badge badge-success p-2';
                        $showStr = ' Booking ';
                        $html += '<td class="bookings-description-upcoming" id="column_' + value.name + '-' + $keyValue.unique_id + '"><button class="' + $class + '">' + $showStr + '</button></td>';
                    } else if (value.name == 'download_receipt') {
                        $class = 'badge badge-success p-2';
                        $showStr = ' download ';
                        $html += '<td class="download-receipt" id="column_' + value.name + '-' + $keyValue.id +'-' + $keyValue.transfer_id + '"><a href="/coach/receipt/'+$keyValue.id+'" class="' + $class + '">' + $showStr + '</a></td>';
                    }
                    else {
                        $html += '<td class="'+value.name+'" id="column_' + value.name + '_' + $keyValue.id + '">' + isNull($columValue) + '</td>';
                    }
                });
                if (!isColumnAction) {
                    var fn = window[$defaultType + 'Action'];
                    if (typeof fn === 'function') { // used to trigger relative action
                        fn();
                    }
                }

                $html += '</tr>';
            });
        } else {
            // $('.no-record-found').html('No Record Found');
        }
        if ($isImportRender == 0) {
            $('#page-data').html($html);
        } else if ($isImportRender == 1) {
            $('#page-data-import-day').html($html);
            $('#page-data-import').html($html);
        } else if ($isImportRender == 2) {
            $('#page-data-meetings').html($html);
        } else if ($isImportRender == 3) {
            $('#active-page-data').html($html);
        } else if ($isImportRender == 4) {
            $('#page-data-history').html($html);

        }
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
     * This is used to render plan action
     */
    renderPayAction = function () {
        if($keyValue.s_a_id == 'no'){
            $id = $keyValue.client_id;
            $html += '<td>\n' +
                '<a href="javascript: void(0)" id="pay_' + $id + '"class="btn btn-danger sm-btn"onclick="">Send</a>\n' +
                '</td>';
        }else {
            $id = $keyValue.client_id;
            $html += '<td>\n' +
                '<a href="javascript: void(0)" id="pay_' + $id + '"class="client-pay btn success-btn sm-btn"onclick="">Send</a>\n' +
                '</td>';
        }
    }

    /**
     * This is used to render plan action
     */
    renderClientsAction = function () {
        $currentId = $keyValue.unique_id;
        if (parseInt($keyValue.actionColumn) == 1) {
            $html += '<td>\n' +
                '<a href="javascript: void(0);" id="client_' + $currentId + '" class="btn sm-btn success-btn rounded accept-btn">Active</a>\n' +
                '</td>';
        } else if (parseInt($keyValue.actionColumn) == 2) {
            $html += '<td>\n' +
                '<a href="javascript: void(0);" id="client_' + $currentId + '" class="btn sm-btn success-btn rounded accept-reject-popup">Accept/Reject</a>\n' +
                '</td>';
        } else if (parseInt($keyValue.actionColumn) == 3) {
            $html += '<td>\n' +
                'Archived\n' +
                '</td>';
        }
    }

    /**
     * This is used to check value null or not
     *
     * @returns {*}
     */
    var isNull = function (value) {
        if (value === null && typeof value === "object") {
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
                $equipmentIds = data.equipmentIds;
                $('.js-example-basic-multiple').val($equipmentIds).change();
                $message = data.message;
                if (data.success == true) {
                    if(typeof (data.isRedirect) !== 'undefined' && data.isRedirect == true) {
                        window.location = $RedirectRoute;
                    }
                    $id = data.id;
                } else {
                    if ($.isArray(data.message)) {
                        $message = '';
                        $.each(data.message, function (i, v) {
                            $message += v + "\n";
                        })
                    } else {
                        swal("Oops!", $message, "error");
                        return false;
                    }
                }
                if (typeof ($dragDrop) !== 'undefined' && $dragDrop == true) {
                   setTimeout(function () {
                       if (typeof ($uniqueId) !== 'undefined') {
                           $('#exercise_' + $uniqueId).html(data.name);
                           $image = data.exercise_image;
                           $('#exercise_image_' + $uniqueId).html('<img src="'+$image+'">');
                           if (typeof (data.dragDropId) !== 'undefined') {
                               $('#' + $uniqueId).attr('data-drag-drop-id', data.dragDropId);
                           }
                       }
                       $dropDownFilters = {};
                       var inputs = $(".drop_down_filters_excercise");
                       for (var i = 0; i < inputs.length; i++) {
                           $dropDownFilters[$(inputs[i]).attr('id')] = $(inputs[i]).val();
                       }
                       getExercisesData();
                   }, 500);
                } else {
                    swal("Done!", $message, "success");
                }
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
                    if (typeof ($clickItemId) !== 'undefined' && $clickItemId > 0) {
                        $('#collapse' + $clickItemId).addClass('show');
                    }
                    if (typeof (data.id) !== 'undefined') {
                        $id = data.id;
                        isPublished(data.is_publish);
                        publishText(data.is_publish);
                    }
                    if (typeof (data.viewPopup) !== 'undefined') {
                        $('#training-plan-popup').html(data.viewPopup);
                    }
                    if(data.pager !== 'undefined') {
                        $('.paq-pager').html(data.pager);
                    }
                    if (typeof ($dragDrop) !== 'undefined' && $dragDrop == true) {
                        draggableDropable();
                        if(typeof (data.extraId) !== 'undefined') {
                            sortable(data.extraId);
                        }
                    }
                }
            },
            error: function ($error) {

            }
        });
    }
    var sortable = function (id) {
        $('.sortable_' + id).sortable({
            revert: true,
            update: function( event, ui ) {
                let id = ui.item.attr("id");
                let splitId = id.split('_');
                let uniqueSortableId = splitId[2] + '_' + splitId[3];
                var idsInOrder = $(".sortable_" + uniqueSortableId).sortable("toArray");
                let isEditPage = 0;
                if (typeof ($isEdit) !== 'undefined') {
                    isEditPage = $isEdit;
                }
                $formData = {
                    '_token': $token,
                    id: $id,
                    idsInOrder: idsInOrder,
                    isEdit: isEditPage
                };
                ajaxStartStop();
                $.ajax({
                    url: $updateOrderWorkoutRoute,
                    type: 'POST',
                    data: $formData,
                    success: function (data) {
                    },
                    error: function ($error) {
                    }
                });
                console.log(idsInOrder);
            }
        });
        $('.sortable_' + id).disableSelection();
    };

    /**
     * This is used to handle exercise drag and drop
     */
    var draggableDropable = function () {
        $("body .draggable").draggable({
            start: function() {
              $('.add-exer-col').css('overflow', 'inherit');
            },
            revert : function(event, ui) {
                $('.add-exer-col').css('overflow', 'auto');
                // on older version of jQuery use "draggable"
                // $(this).data("draggable")
                // on 2.x versions of jQuery use "ui-draggable"
                // $(this).data("ui-draggable")
                $(this).data("uiDraggable").originalPosition = {
                    top : 0,
                    left : 0
                };
                // return boolean
                return !event;
                // that evaluate like this:
                // return event !== false ? false : true;
            },
            stop: function () {
                $('.add-exer-col').css('overflow', 'auto');
            }
        });
        $("body .droppable").droppable({
            drop: function (event, ui) {
                $('.add-exer-col').css('overflow', 'auto');
                let dropableId = $(this).attr('id');
                $uniqueId = dropableId;
                var draggableId = ui.draggable.attr("id");

                var draggableName = ui.draggable.attr("data-exercise-name");
                let isExercise = draggableId.split('_')[0];
                if (isExercise !== 'exercise') {
                    return false;
                }
                let splitString = dropableId.split('_');
                $workoutType = splitString[0];
                $extraId = splitString[1] + '_' + splitString[2];
                $workoutCounter = $workoutSubCounter = 0;
                if (typeof (splitString[3]) !== 'undefined') {
                    $workoutCounter = splitString[3];
                }
                if (typeof (splitString[4]) !== 'undefined') {
                    $workoutSubCounter = splitString[4];
                }
                $positionId = 0;
                if (typeof (splitString[5]) !== 'undefined') {
                    $positionId = splitString[5];
                }
                $dropDownFilters = {};
                var inputs = $("." + dropableId);
                for (var i = 0; i < inputs.length; i++) {
                    $dropDownFilters[$(inputs[i]).attr('id')] = $(inputs[i]).val();
                }
                $exerciseId = draggableId.split('_')[1];
                $addRecordRoute = $addDragdropRoute;
                updateFormData();
                $type = 'addRecord';
                renderClient();
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
                        renderClient();
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
    } else if($type.indexOf('draggable') !== -1) {
        draggableDropable();
    }

    var functionList = {};
    functionList["sorter"] = sorter;
    functionList['uploadImage'] = uploadImage;
    if ($type in functionList) {
        functionList[$type]();
    }

}
