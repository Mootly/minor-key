/* --- imgCleaner.js ---------------------------------------------------------- *
 * Converts old WYSIWYG code for images with new CSS-managed layout.            *
 * ---------------------------------------------------------------------------- */
$('document').ready( function() {
  $('img[hspace]').each ( function() {
    $(this).removeAttr('hspace').attr('style','margin: auto;');
    $(this).parent().attr('style','text-align: center;');
  });
});
/*! -- Copyright (c) 2018-2019 Mootly Obviate -- See /LICENSE.md -------------- */
