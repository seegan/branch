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


jQuery(document).ready(function(){

  var qus_str = questions.questions;
  question = qus_str.split(',');
  console.log(question);
  
});












(function($) {

  var OnlineExam = function(element, options) {
    var settings = jQuery.extend({
      container:'.answer-board',
    }, options);

    var elem = $(element);
    var $jquery = element;
    var $Board = $(settings.container);



    var collectAndSubmit = function (time) {
      console.log('time_submit');
    }

    var collectExamData = function (time) {

      //localStorage.removeItem('favoriteflavor');

      var nav_prev_data = localStorage.getItem('navigator_data');
      var board_prev_data = localStorage.getItem('board_data');
      
      if( nav_prev_data == $('#question-navigator :input').serialize() && board_prev_data == $('.answer-board.inner-board :input').serialize()) {
        collectAndSubmit();
      } else {
        jQuery.ajax({
            url: filter_ajaxurl,
            type: 'POST',
            dataType: "json",
            showAutocompleteOnFocus : true,
            autoFocus: true,
            selectFirst: true,
            data: {
                'action': 'examDataSubmit',
                'navigator_data' : $('#question-navigator :input').serialize(),
                'board_data' : $('.answer-board.inner-board :input').serialize(),
            },
            success: function( data ) {
              
            }
        });
      }

      localStorage.setItem('navigator_data',$('#question-navigator :input').serialize());
      localStorage.setItem('board_data',$('.answer-board.inner-board :input').serialize());




    }





    var activeQuestionChange = function(questionid) {
      var question_id = '#question_'+questionid;
      $Board.find('.block_questions').css('display', 'none');
      $Board.find(question_id).css('display', 'block');
      $Board.find('#active_question').val(questionid);

      jQuery('#question-navigator li').find('.active').removeClass('active');
      jQuery('#question-navigator li').find('.active_status').val('0');

      jQuery('[data-questionid="'+questionid+'"]').find('span').addClass('active');
      jQuery('[data-questionid="'+questionid+'"]').find('.active_status').val('1');

      collectExamData();
    }
    var changeToNotAnswered = function(question_id ) {
      jQuery('[data-questionid="'+question_id+'"]').removeClass().addClass('notanswered');
      jQuery('[data-questionid="'+question_id+'"]').find('.attend_status').val('notanswered');
      activeQuestionChange(question_id);
    }
    var changeToNotAnsweredClear = function(question_id ) {
      jQuery('[data-questionid="'+question_id+'"]').removeClass().addClass('notanswered');
      jQuery('[data-questionid="'+question_id+'"]').find('.attend_status').val('notanswered');
      activeQuestionChange(question_id);
    }
    var changeToAnswered = function(question_id ) {
      jQuery('[data-questionid="'+question_id+'"]').removeClass().addClass('answered');
      jQuery('[data-questionid="'+question_id+'"]').find('.attend_status').val('answered');
      activeQuestionChange(question_id);
    }
    var changeToReview = function(question_id, action ) {
      jQuery('[data-questionid="'+question_id+'"]').removeClass().addClass('reviewnext');
      jQuery('[data-questionid="'+question_id+'"]').find('.attend_status').val('reviewnext');
      
      if(action == 'stay') {
        activeQuestionChange(question_id);
      }

    }
    var changeToReviewMark = function(question_id, action ) {
      jQuery('[data-questionid="'+question_id+'"]').removeClass().addClass('attemptedreview');
      jQuery('[data-questionid="'+question_id+'"]').find('.attend_status').val('attemptedreview');
      
      if(action == 'stay') {
        activeQuestionChange(question_id);
      }

    }





    var makeQuestionBlock = function(data, order_no) {

      var option_html = "";
      $.each(data.options, function( key, value ) {
          option_html += "<div class='question_options'>";
          option_html += "  <div class='radio radio-success'>";
          option_html += "    <input id='radio-"+value.option_id+"' type='radio' name='single_option["+value.question_id+"]' value='"+value.option_id+"' class='single-option'>";
          option_html += "    <label for='radio-"+value.option_id+"'>";
          option_html +=          value.option_val;
          option_html += "    </label>";
          option_html += "  </div>";
          option_html += "</div>";
      });


      var html = "<div id='question_"+data.question_id+"' class='block_questions'>";
          html += " <div class='row'>";
          html += "   <div class='col-lg-12'>";
          html += "     <div class='question_txt'>";
          html += "       <div class='question_txt_in'>";
          html += "         <span class='badge badge-pill badge-primary'>"+order_no+"</span>"
          html +=           data.question;
          html += "       </div>";
          html += "       <div style='clear:both;'></div>";
          html += "     </div>";
          html += "     <div class='option-main' data-optionquestion='"+data.question_id+"'>";
          html +=         option_html;
          html += "     </div>";
          html += "   </div>";
          html += " </div>";
          html += "</div>";

         return html;
    };


    var moveToNext = function(question_id ) {
      var current_li_sel = jQuery('[data-questionid='+question_id+']');
      var total_li = jQuery( "#navigator-in li" ).length;
      var index = jQuery( "#navigator-in li" ).index( current_li_sel );
      var curent_order = index+1;
      var current_question = 0;
      if(curent_order >= total_li) {
        current_question = jQuery( "#navigator-in li" ).first().data('questionid');
        jQuery('[data-questionid='+current_question+']').trigger( 'click' );
      } else {
        current_question = jQuery(current_li_sel).next().data('questionid');
        jQuery('[data-questionid='+current_question+']').trigger( 'click' );
      }
    }
    var moveToPrev = function(question_id ) {
      var current_li_sel = jQuery('[data-questionid='+question_id+']');
      var total_li = jQuery( "#navigator-in li" ).length;
      var index = jQuery( "#navigator-in li" ).index( current_li_sel );
      var curent_order = index+1;
      var current_question = 0;
      if(curent_order == 1) {
        current_question = jQuery( "#navigator-in li" ).last().data('questionid');
        jQuery('[data-questionid='+current_question+']').trigger( 'click' );
      } else {
        current_question = jQuery(current_li_sel).prev().data('questionid');
        jQuery('[data-questionid='+current_question+']').trigger( 'click' );
      }   
    }


    var output = {

      'listener':function(param){
          delta = 10000,
          window.tid = setInterval(function() {
              //output.collectAndSubmit(time);       
              collectAndSubmit('test');       
          }, delta);

      },



      'toNextQuestion': function() {
        jQuery('.move_next').on('click', function(){
          var current_question = jQuery('#active_question').val();
          moveToNext(current_question);
        });
      },
      'toPrevQuestion': function() {
        jQuery('.move_prev').on('click', function(){
          var current_question = jQuery('#active_question').val();
          moveToPrev(current_question);
        });
      },


      'createBoard':function() {
        var order_no = 1;
        var b_html = "";
        $.each( questions.question_data, function( key, value ) {
          b_html = makeQuestionBlock(value, order_no);
          $Board.append(b_html);
          order_no++;
        });
      },
      'onValueChange': function() {
        jQuery('.single-option').on('change', function(){
          var option_main = jQuery(this).parent().parent().parent();
          var question_id = jQuery(option_main).data('optionquestion');
          var checked = jQuery(option_main).find('.single-option').is(':checked');
          if(checked) {
            changeToAnswered(question_id);
          } /*else {
            changeToNotAnswered(question_id);
          }*/
        })
      },
      'onClearResponse': function() {
        jQuery('.clear_response').on('click', function(){
          var question_id = jQuery('#active_question').val();
          jQuery('[data-optionquestion='+question_id+']').find('.single-option').prop('checked', false);
          changeToNotAnsweredClear(question_id);
        });
      },

      'onReviewQuestion': function() { 

        jQuery('.review_stay').on('click', function(){
          var question_id = jQuery('#active_question').val();
          var is_checked = jQuery('[data-optionquestion='+question_id+']').find('.single-option').is(':checked');
          if(is_checked) {
            changeToReviewMark(question_id, 'stay');
          }else {
            changeToReview(question_id, 'stay');
          }
        });

        jQuery('.review_next').on('click', function(){
          var question_id = jQuery('#active_question').val();
          var is_checked = jQuery('[data-optionquestion='+question_id+']').find('.single-option').is(':checked');
          if(is_checked) {
            changeToReviewMark(question_id, 'move');
          }else {
            changeToReview(question_id, 'move');
          }
          moveToNext(question_id);
        });
      },




      'init':function(){
          $jquery.each(function(){
            var _this = this;
            _this.$this = $(this);
            output.toNextQuestion();
            output.toPrevQuestion();
            output.createBoard();
            output.onValueChange();
            output.onClearResponse();
            output.onReviewQuestion();
            //var privatefun = function(){ console.log('inside private');  }
            
            _this.$this.find('#navigator-in li').on('click',function(){


                //Timer Reset when li click
                clearInterval(window.tid);
                output.listener();


                var question_id = $(this).data('questionid');
                var question_status = $(this).attr('class');
                switch(question_status) {
                  case 'notvisited':
                    changeToNotAnswered(question_id);
                    break;
                  case 'notanswered':
                    activeQuestionChange(question_id);
                    break;
                  case 'answered':
                    activeQuestionChange(question_id);
                    break;
                  case 'reviewnext':
                    activeQuestionChange(question_id);
                    break;
                  case 'attemptedreview':
                    activeQuestionChange(question_id);
                    break;
                  default:
                    break;
                }

            });


            $(window).resize(function() {
              var board_height = (window.innerHeight) - 250;
              board_height = board_height+'px';
              $(".inner-board").height(board_height);
            }).resize();              

          });
          //output.function1("value");
      }
    };
    output.init();

/*    // Public method - can be called from client code
    output.publicMethod = function() {
      console.log('public method called!');
      
    };*/

    // Private method - can only be called from within this object

    return output;
  };

  $.fn.OnlineTest = function(options) {
    var element = $(this);

    // pass options to plugin constructor
    var onlinetest = new OnlineExam(this, options);

    return onlinetest;
  };
})(jQuery);

//Usage:

$('#question-navigator').OnlineTest({
  container:'.answer-board',
});
//var onlinetest = $('#question-navigator').OnlineTest({answer_container:'answer-board'});
//onlinetest.publicMethod();








/*     $(document).on('keyup keypress blur change mousemove',function(){
        clearInterval(window.tid);
        listener();
    });*/