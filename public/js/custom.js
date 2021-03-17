function dashboard__wraper()
{
  var headerHeight = jQuery('.dasbhboard__header').outerHeight();
  var profileHeight = jQuery('.dasbhboard__sidebar .dashboard__profile').outerHeight();
  var footerHeight = jQuery('.sidebar__footer').outerHeight();

  jQuery('.dasbhboard__sidebar').css({'top':headerHeight, 'padding-top': profileHeight, 'padding-bottom': footerHeight});
  jQuery('.dashbaord__main__warper').css('padding-top',headerHeight);
}

jQuery(document).ready(function(){
  dashboard__wraper();
});

jQuery(window).on('resize' , function(){
  dashboard__wraper();
});


// upload js

function initImageUpload(box) {
  let uploadField = box.querySelector('.image-upload');

  uploadField.addEventListener('change', getFile);

  function getFile(e){
    let file = e.currentTarget.files[0];
    checkType(file);
  }

  function previewImage(file){
    let thumb = box.querySelector('.js--image-preview'),
    reader = new FileReader();

    reader.onload = function() {
      thumb.style.backgroundImage = 'url(' + reader.result + ')';
    }
    reader.readAsDataURL(file);
    thumb.className += ' js--no-default';
  }

  function checkType(file){
    let imageType = /image.*/;
    if (!file.type.match(imageType)) {
      throw 'Datei ist kein Bild';
    } else if (!file){
      throw 'Kein Bild gewÃ¤hlt';
    } else {
      previewImage(file);
    }
  }

}

// initialize box-scope
var boxes = document.querySelectorAll('.box');

for (let i = 0; i < boxes.length; i++) {
  let box = boxes[i];
  initDropEffect(box);
  initImageUpload(box);
}



/// drop-effect
function initDropEffect(box){
  let area, drop, areaWidth, areaHeight, maxDistance, dropWidth, dropHeight, x, y;

  // get clickable area for drop effect
  area = box.querySelector('.js--image-preview');
  area.addEventListener('click', fireRipple);

  function fireRipple(e){
    area = e.currentTarget
    // create drop
    if(!drop){
      drop = document.createElement('span');
      drop.className = 'drop';
      this.appendChild(drop);
    }
    // reset animate class
    drop.className = 'drop';

    // calculate dimensions of area (longest side)
    areaWidth = getComputedStyle(this, null).getPropertyValue("width");
    areaHeight = getComputedStyle(this, null).getPropertyValue("height");
    maxDistance = Math.max(parseInt(areaWidth, 10), parseInt(areaHeight, 10));

    // set drop dimensions to fill area
    drop.style.width = maxDistance + 'px';
    drop.style.height = maxDistance + 'px';

    // calculate dimensions of drop
    dropWidth = getComputedStyle(this, null).getPropertyValue("width");
    dropHeight = getComputedStyle(this, null).getPropertyValue("height");

    // calculate relative coordinates of click
    // logic: click coordinates relative to page - parent's position relative to page - half of self height/width to make it controllable from the center
    x = e.pageX - this.offsetLeft - (parseInt(dropWidth, 10)/2);
    y = e.pageY - this.offsetTop - (parseInt(dropHeight, 10)/2) - 30;

    // position drop and animate
    drop.style.top = y + 'px';
    drop.style.left = x + 'px';
    drop.className += ' animate';
    e.stopPropagation();

  }
}





// avtar upload



function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#imagePreview2').css('background-image', 'url('+e.target.result +')');
      $('#imagePreview2').hide();
      $('#imagePreview2').fadeIn(650);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#imageUpload2").change(function() {
  readURL(this);
});

$('.datepicker').datepicker();

$('input[data-role="tagsinput"]').val();


if ($('#timePicker1').length > 0) {

  $('#timePicker1').timepicker({
    uiLibrary: 'bootstrap4'
  });


  $('#timePicker2').timepicker({
    uiLibrary: 'bootstrap4'
  });


  $('#timePicker3').timepicker({
    uiLibrary: 'bootstrap4'
  });

  $('#timePicker4').timepicker({
    uiLibrary: 'bootstrap4'
  });
  $('#timePicker5').timepicker({
    uiLibrary: 'bootstrap4'
  });


  $('#timePicker6').timepicker({
    uiLibrary: 'bootstrap4'
  });


  $('#timePicker7').timepicker({
    uiLibrary: 'bootstrap4'
  });

  $('#timePicker8').timepicker({
    uiLibrary: 'bootstrap4'
  });
  $('#timePicker9').timepicker({
    uiLibrary: 'bootstrap4'
  });
  $('#timePicker10').timepicker({
    uiLibrary: 'bootstrap4'
  });
  $('#timePicker11').timepicker({
    uiLibrary: 'bootstrap4'
  });
  $('#timePicker12').timepicker({
    uiLibrary: 'bootstrap4'
  });
  $('#timePicker13').timepicker({
    uiLibrary: 'bootstrap4'
  });
  $('#timePicker14').timepicker({
    uiLibrary: 'bootstrap4'
  });
  $('#timePicker15').timepicker({
    uiLibrary: 'bootstrap4'
  });

  $('#timePicker16').timepicker({
    uiLibrary: 'bootstrap4'
  });

  $('#timePicker17').timepicker({
    uiLibrary: 'bootstrap4'
  });

  $('#timePicker18').timepicker({
    uiLibrary: 'bootstrap4'
  });

}
jQuery(document).ready(function() {
  jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');
});

// account

$( "#birthday" ).datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: "1930:2020"
});

function pickImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#profile_pic')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$('#country').on('change', function () {
    $('#cityList').empty();
    $.ajax({
        type: 'POST',
        url: 'http://127.0.0.1:8000/city',
        data: {
            'cca3': this.value
        },
        success:function(data){

            console.log(data.code);

            if (data.code == 200){

                data.cityList.forEach(function(obj){

                    console.log(obj);
                    $('#cityList').append(new Option(obj.city,obj.code));

                });
            } else {
                alert(data.msg);
            }

        },
        error: function (error) {
            console.log(error);
        }
    });

});

// juned
$(document).ready(function () {

    var selected = 0;

    var itemlist = $('#plan-items');
    var len = $(itemlist).children().length;


    $("#up").click(function (e) {
        e.preventDefault();
        if (selected > 0) {
            jQuery($(itemlist).children().eq(selected - 1)).before(jQuery($(itemlist).children().eq(selected)));
            selected = selected - 1;
        }
    });

    $("#down").click(function (e) {
        e.preventDefault();
        if (selected < len) {
            jQuery($(itemlist).children().eq(selected + 1)).after(jQuery($(itemlist).children().eq(selected)));
            selected = selected + 1;
        }
    });


    // $(".reorder-up").click(function () {
    //     var $current = $(this).closest('li')
    //     var $previous = $current.prev('li');
    //     if ($previous.length !== 0) {
    //         $current.insertBefore($previous);
    //     }
    //     return false;
    // });

    // $(".reorder-down").click(function () {
    //     var $current = $(this).closest('li')
    //     var $next = $current.next('li');
    //     if ($next.length !== 0) {
    //         $current.insertAfter($next);
    //     }
    //     return false;
    // });

});


// 23-05-2020

$(document).ready(function () {

  // draggable js

  var dragSrcEl = null;

  function handleDragStart(e) {
      // Target (this) element is the source node.
      dragSrcEl = this;

      e.dataTransfer.effectAllowed = 'move';
      e.dataTransfer.setData('text/html', this.outerHTML);

      this.classList.add('dragElem');
  }
  function handleDragOver(e) {
      if (e.preventDefault) {
          e.preventDefault(); // Necessary. Allows us to drop.
      }
      this.classList.add('over');

      e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

      return false;
  }

  function handleDragEnter(e) {
      // this / e.target is the current hover target.
  }

  function handleDragLeave(e) {
      this.classList.remove('over');  // this / e.target is previous target element.
  }

  function handleDrop(e) {
      // this/e.target is current target element.

      if (e.stopPropagation) {
          e.stopPropagation(); // Stops some browsers from redirecting.
      }

      // Don't do anything if dropping the same column we're dragging.
      if (dragSrcEl != this) {
          // Set the source column's HTML to the HTML of the column we dropped on.
          //alert(this.outerHTML);
          //dragSrcEl.innerHTML = this.innerHTML;
          //this.innerHTML = e.dataTransfer.getData('text/html');
          this.parentNode.removeChild(dragSrcEl);
          var dropHTML = e.dataTransfer.getData('text/html');
          this.insertAdjacentHTML('beforebegin', dropHTML);
          var dropElem = this.previousSibling;
          addDnDHandlers(dropElem);

      }
      this.classList.remove('over');
      return false;
  }

  function handleDragEnd(e) {
      // this/e.target is the source node.
      this.classList.remove('over');

      /*[].forEach.call(cols, function (col) {
        col.classList.remove('over');
      });*/
  }

  function addDnDHandlers(elem) {
      elem.addEventListener('dragstart', handleDragStart, false);
      elem.addEventListener('dragenter', handleDragEnter, false)
      elem.addEventListener('dragover', handleDragOver, false);
      elem.addEventListener('dragleave', handleDragLeave, false);
      elem.addEventListener('drop', handleDrop, false);
      elem.addEventListener('dragend', handleDragEnd, false);

  }

  var cols = document.querySelectorAll('#dragglist .drag-tr');
  [].forEach.call(cols, addDnDHandlers);

});

$(".js-select2").select2({
  closeOnSelect: false,
  placeholder: "All",
  allowHtml: true,
  allowClear: true,
  tags: false // создает новые опции на лету
});


// function iformat(icon, badge, ) {
//     var originalOption = icon.element;
//     var originalOptionBadge = $(originalOption).data('badge');

//     return $('<span><i class="fa ' + $(originalOption).data('icon') + '"></i> ' + icon.text + '<span class="badge">' + originalOptionBadge + '</span></span>');
// }

$(window).load(function () {
  $('.exercises.paq-pager').on('click', function () {
    $('.add-exer-col').animate({
      scrollTop: 0
    }, 300);
  });
});

function isPublished(isPublished) {
    if (isPublished == 1) {
        $('#is_publish_plan').html('Published');
        $('#is_publish_plan').removeClass('unpublished').addClass('published');
        $('#btn-publish-id').removeClass('unpublished-color').addClass('published-color');
        // $('.published-div a:hover').css('color', 'green');
    } else {
        $('#is_publish_plan').html('Unpublished');
        $('#is_publish_plan').removeClass('published').addClass('unpublished');
        $('#btn-publish-id').removeClass('published-color').addClass('unpublished-color');
    }
}

function  publishText(isPublished) {
    if (isPublished == 0) {
        $('#publish_text').html('If you select Publish,<br>\n' +
            '                    your client will have access to the training program for this week.');
    } else {
        $('#publish_text').html('If you select Unpublish,<br>\n' +
            '                    your client will not have access to the training program for this week.');
    }
}
