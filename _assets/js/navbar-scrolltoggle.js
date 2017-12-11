/** -- Jump link navbar tab toggle on scroll ---------------------------------- *
 * Set the current highlight to the correct tab in a multipart page
 * Classes:
 * - nav bar  - .navBar_item
 * - anchor   - .jumplink
 * mpv_JTTLastAction tracks which script fired off last to keep them from arguing
 * This was a one off for a project, but I thought it might be useful elsewhere.
 * ---------------------------------------------------------------------------- */
                    // Get an array of anchors to to prior elements on up       ***
var mpv_JTTlinkset = $('.jumplink').toArray();
for ( var i = 0; i < mpv_JTTlinkset.length; i++ ) {
  mpv_JTTlinkset[i] = ( mpv_JTTlinkset[i].id);
}

var mpv_JTTLastAction = '';
                    // Onclick set                                              ***
$('.navBar_item a').click(function () {
  $('.navBar_item a.active').removeClass('active');
  $(this).addClass('active');
  mpv_JTTLastAction = 'click';
});
                    // Page scroll set                                          ***
var waypoints = $('.jumplink').waypoint({
  handler: function(direction) {
    if (mpv_JTTLastAction != 'click') {
      $('.navBar_item a.active').removeClass('active');
      if (direction == 'down') {
        $('a[href="#'+this.element.id+'"]').addClass('active');
      } else if (direction == 'up') {
        var tprevPos = $.inArray(this.element.id, mpv_JTTlinkset);
        var tprevID  = (tprevPos > 0) ? mpv_JTTlinkset[tprevPos -1] : 'top';
        $('a[href="#'+tprevID+'"]').addClass('active');
      }
    }
    mpv_JTTLastAction = 'scroll';
  },
  continuous: false // on jump, only trigger last event                         ***
});
/*! -- Copyright (c) 2017-2018 Mootly Obviate -- See /LICENSE.md -------------- */
