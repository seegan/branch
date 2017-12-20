function loadTinymce() {
    if(jQuery(".option_editor").length > 0){

        tinymce.init({
            selector: "textarea.option_editor",
            theme: "modern",
            plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor autoresize"
                    ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [
                {title: "Bold text", inline: "b"},
                {title: "Red text", inline: "span", styles: {color: "#ff0000"}},
                {title: "Red header", block: "h1", styles: {color: "#ff0000"}},
                {title: "Example 1", inline: "span", classes: "example1"},
                {title: "Example 2", inline: "span", classes: "example2"},
                {title: "Table styles"},
                {title: "Table row 1", selector: "tr", classes: "tablerow1"}
            ],
            autoresize_bottom_margin: 2,
            height:15,
            autoresize_min_height: 15,
            autoresize_max_height: 300,
            menubar: false, statusbar: true, object_resizing: false,
            paste_as_text: true, force_br_newlines: true,
        });

    }
}

            
function getOptionKey(num) {
  return num.replace(/[{}]/g, "");
}



function parseUrl( url ) {
    var a = document.createElement('a');
    a.href = url;
    return a;
}
function getPathFromUrl(url) {
  return url.split(/[?#]/)[1];
}

Array.prototype.diff = function diff(a) {
    return this.filter(function(i) {return a.indexOf(i) < 0;});
};

function populateMultiSelect(sel = '') {
    //advance multiselect start
    jQuery(sel).multiSelect( 'refresh' );    
}


jQuery(document).ready(function () {

  if(jQuery('.date_pic').length > 0 ) {
    jQuery('.date_pic').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "dd M yyyy",
        clearBtn: true,
    });
  }


  if(jQuery('.time_pic').length > 0 ) {
    jQuery('.time_pic').timepicker({ 'timeFormat': 'h:i A' });
  }



  jQuery('.take_exam_btn').on('click', function(){
    var exam_link = jQuery(this).data('examinstruc');
    launchApplication(exam_link, 'Exam Window');
  });



  Webcam.set({
    width: 1280,
    height: 720,
    image_format: 'jpeg',
    jpeg_quality: 90,
    enable_flash: false,
    constraints: {
      width: { exact: 1280 },
      height: { exact: 720 }
    }
  });

  Webcam.on( 'live', function() {
    if(jQuery('.take_schedule_btn').data('examschedule').length > 0) {
      location.href = jQuery('.take_schedule_btn').data('examschedule');
    }
  });
  Webcam.on( 'error', function(err) {
    alert('Please enable Camera to take this exam');
  });




  jQuery('.take_schedule_btn').on('click', function(){

    var camera_alowed = true;
    var exam_link = jQuery('.take_schedule_btn').data('examschedule');

    if(jQuery('#tos_instruction:checked').length > 0 ) {

      if(camera_alowed == true) {
        Webcam.attach( '#my_camera' );
      } else {
        location.href = exam_link;
      } 

    } else {
      alert('Please read and accept instructions!');
    }






  });


});



function take_snapshot() {
  // take snapshot and get image data
  Webcam.snap( function(data_uri) {
    // display results in page
    console.log(data_uri);
  });
}


function launchApplication(l_url, l_windowName)
{
    if ( typeof launchApplication.winRefs == 'undefined' )
    {
        launchApplication.winRefs = {};
    }
    if ( typeof launchApplication.winRefs[l_windowName] == 'undefined' || launchApplication.winRefs[l_windowName].closed )
    {
        var l_width = screen.availWidth;
        var l_height = screen.availHeight;

        var l_params = 'status=1' +
                       ',resizable=1' +
                       ',scrollbars=1' +
                       ',width=' + l_width +
                       ',height=' + l_height +
                       ',left=0' +
                       ',top=0';

        launchApplication.winRefs[l_windowName] = window.open(l_url, l_windowName, l_params);
        launchApplication.winRefs[l_windowName].moveTo(0,0);
        launchApplication.winRefs[l_windowName].resizeTo(l_width, l_height);
    } else {
        launchApplication.winRefs[l_windowName].focus()
    }
}