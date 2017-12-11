/** --------------------------------------------------------------------------- *
  * Title Lock.
  *
  * Lock our title box at the top of the page of scroll.
  * @copyright 2017-2018 - Mootly Obviate
  *   MIT license - https://opensource.org/licenses/MIT
  */
$(window).on( 'load', function () {
  var titlepoint = $('#title-box').waypoint({
    handler: function(direction) {
      if ($(window).width() > 800) {
        if (direction == 'down') {
          $('#title-box').addClass('fixed-top');
          $('#sidebar-left').addClass('fixed-above');
          $('#content-main').addClass('fixed-above');
          $('.fixed-above').css('margin-top', $('#title-box').outerHeight());
        } else if (direction == 'up') {
          $('#title-box').removeClass('fixed-top');
          $('.fixed-above').removeAttr('style');
          $('#sidebar-left').removeClass('fixed-above');
          $('#content-main').removeClass('fixed-above');
        }
      } else {
        $('#title-box').removeClass('fixed-top');
        $('.fixed-above').removeAttr('style');
        $('#sidebar-left').removeClass('fixed-above');
        $('#content-main').removeClass('fixed-above');
      }

    },
    continuous: false // on jump, only trigger last event                         ***
  });
});
