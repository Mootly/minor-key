/* --- blockFolder.js --------------------------------------------------------- *
 * Adds collapser class to overly long blocks.                                  *
 * ---------------------------------------------------------------------------- */
$('document').ready( function() {
  $('.pull-box-article').each ( function() {
    if ($(this).height() > 600) {
      $(this).addClass('overflow-block').attr('tabindex','0');
      $(this).after('<div class="overflow-footer"></div>');
    }
  });
});
/*! -- Copyright (c) 2020 Mootly Obviate -- See /LICENSE.md ------------------- */
