
(function () {

  //var $ = jQuery.noConflict();

  $(document).ready(function ($) {
    
    var pageContentType = $("#contentType").text();
    console.log("pageContentType="+pageContentType);

    var wysiwygEditor;
    if(pageContentType == "addQuestionPageContent"){
        var textAreaId = "newQuestionTextArea";
        wysiwygEditor = new WYSIWYGEditor();
        wysiwygEditor.init(textAreaId);
    }
    else if(pageContentType == "questionPageContent"){
        var textAreaId = "answerTextArea";
        wysiwygEditor = new WYSIWYGEditor();
        wysiwygEditor.init(textAreaId);
    }
    
    
    $('#streams__area')
      .jScrollPane({
        horizontalDragMinWidth: 302,
        horizontalDragMaxWidth: 302
      });

    //============================
    //           PARAMS
    //============================
    var FIGURE_WIDTH = 280;
    var FIGURE_GUTTER = 20;
    var CONTENT_WIDTH = 1180;
    //============================
    //         PARAMS END
    //============================

    var figureWidth = FIGURE_GUTTER + FIGURE_WIDTH;
    var figureVisibleAmount = parseInt((CONTENT_WIDTH + FIGURE_GUTTER) / figureWidth);

    var numberScrollElements = $('.jspPane').children().length - figureVisibleAmount;
    var scrollWidth = numberScrollElements * figureWidth;

    var scrollbarWidth = $('.jspTrack').width();
    var scrollbarDragWidth = $('.jspDrag').width();
    var dragWidth = scrollbarWidth - scrollbarDragWidth;
    var moveAmount = 0;
    var dragOffset = 0;

    $('#streams__area').on('mousewheel', function (event) {
      event.preventDefault();
      
      var scrollAmount = event.originalEvent.wheelDeltaY ? event.originalEvent.wheelDeltaY : event.originalEvent.deltaY*-40;

      var leftOffset = $('.jspPane').offset().left;
      var windowWidth = $(window).width();
      var adjIndex = ((windowWidth - CONTENT_WIDTH) / 2) + 1;

      if (adjIndex < 0) {
        adjIndex = 0;
      }

      leftOffset = leftOffset + scrollAmount;

      if ((leftOffset - adjIndex) < -scrollWidth) {
        leftOffset = -scrollWidth + adjIndex;
      } else if ((leftOffset - adjIndex) > 0) {
        leftOffset = adjIndex;
      }

      $('.jspPane').offset({left: leftOffset});

      moveAmount = -(leftOffset - adjIndex) / scrollWidth;
      dragOffset = (dragWidth * moveAmount) + adjIndex;
      $('.jspDrag').offset({left: dragOffset})
    });

    $(window).on('load', function () {
      $('.grid').masonry({
        itemSelector: '.grid-item',
        gutter: 15
      });
    });

    var svodkiPage = 0;
    var svodkiLoading = false;
    $('.loadmore a').click(
        function(){
          if(!svodkiLoading) {
            svodkiPage++;
            $.get('?sv=1&page=' + svodkiPage + '&day=' + currentDate, function (data) {
              if(data.length < 20 || (svodkiPage + 1) * recordCounts.perpage >= recordCounts.current){
                $('.loadmore').hide();
              }
              $data = $(data);
              $('.grid').append($data).masonry('appended', $data);
              $('img').load(function (){$('.grid').masonry()});
              svodkiLoading = false;
            });
            svodkiLoading = true;
          }
          return false;
        }
    );

  });
})(jQuery);
