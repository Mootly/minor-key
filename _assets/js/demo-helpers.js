/* --- Demo helper scripts ---------------------------------------------------- *
 * Scripts to help with demonstration pages to call out elements as needed.
 * --- Revision History ------------------------------------------------------- *
 * 2019-07-09 | Added revision log, cleaned code
 * ---------------------------------------------------------------------------- */

/* --- Label images sizes with an overlay ------------------------------------- */
                    // images block.size-img > img                              *
$(window).on( 'load', function () {
  var tTarget = $('.size-img');
  tTarget.each(function() {
    var tvH = Math.round($(this).find('img').height());
    var tvW = Math.round($(this).find('img').width());
    $(this).prepend('<div class="element-size">' + tvH + ' x ' + tvW + '</div>');
  });
});
$(window).on('resize', function () {
  var tTarget = $('.size-img');
  tTarget.each(function() {
    var tvH = Math.round($(this).find('img').height());
    var tvW = Math.round($(this).find('img').width());
    $(this).find('.element-size').text(tvH + ' x ' + tvW);
  });
});
 /*! -- Copyright (c) 2018 Mootly Obviate -- See /LICENSE.md ------------------ */
