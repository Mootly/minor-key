/** -- Jump link navbar tab toggle on scroll ---------------------------------- *
 * Set the current highlight to the correct tab in a multipart page
 * Classes:
 * - click  - navBar_item
 * - scroll - anchor
 * mkv_JTTLastAction tracks which script fired off last to keep them from arguing
 * ---------------------------------------------------------------------------- */
 var mkv_JTTLastAction = '';
                    // Onclick set                                              *
 $('.navBar_item a').click(function () {
   $('.navBar_item a.active').removeClass('active');
   $(this).addClass('active');
   mkv_JTTLastAction = 'click';
});
                    // Page scroll set                                          *
var waypoints = $('.anchor').waypoint({
  handler: function(direction) {
    if (mkv_JTTLastAction != 'click') {
      $('.navBar_item a.active').removeClass('active');
      var tHref='a[href="#'+this.element.id+'"]';
      $(tHref).addClass('active');
    }
    mkv_JTTLastAction = 'scroll';
  },
  continuous: false // on jump, only trigger last event                         *
});
/*! -- Copyright (c) 2017-2018 Mootly Obviate -- See /LICENSE.md -------------- */
