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

  jQuery('.take_schedule_btn').on('click', function(){
    var exam_link = jQuery(this).data('examschedule');
    location.href = exam_link;
  });


});


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