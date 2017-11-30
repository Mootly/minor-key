/** -- Jump link navbar tab toggle on scroll ---------------------------------- *
 * Set the current highlight to the correct tab in a multipart page
 * Classes:
 * - nav bar  - .navBar_item
 * - anchor   - .jumplink
 * mkv_JTTLastAction tracks which script fired off last to keep them from arguing
 * ---------------------------------------------------------------------------- */
                    // Get an array of anchors to to prior elements on up       ***
var mkv_JTTlinkset = $('.jumplink').toArray();
for ( var i = 0; i < mkv_JTTlinkset.length; i++ ) {
  mkv_JTTlinkset[i] = ( mkv_JTTlinkset[i].id);
}

var mkv_JTTLastAction = '';
                    // Onclick set                                              ***
$('.navBar_item a').click(function () {
  $('.navBar_item a.active').removeClass('active');
  $(this).addClass('active');
  mkv_JTTLastAction = 'click';
});
                    // Page scroll set                                          ***
var waypoints = $('.jumplink').waypoint({
  handler: function(direction) {
    if (mkv_JTTLastAction != 'click') {
      $('.navBar_item a.active').removeClass('active');
      if (direction == 'down') {
        $('a[href="#'+this.element.id+'"]').addClass('active');
      } else if (direction == 'up') {
        var tprevPos = $.inArray(this.element.id, mkv_JTTlinkset);
        var tprevID  = (tprevPos > 0) ? mkv_JTTlinkset[tprevPos -1] : 'top';
        $('a[href="#'+tprevID+'"]').addClass('active');
      }
    }
    mkv_JTTLastAction = 'scroll';
  },
  continuous: false // on jump, only trigger last event                         ***
});
/*! -- Copyright (c) 2017-2018 Mootly Obviate -- See /LICENSE.md -------------- */
