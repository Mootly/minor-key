/* --- Legacy content helper scripts ----------------- ECMAScript 6 version --- *
 * Scripts to correct legacy code.
 * ---------------------------------------------------------------------------- *
 * Available Functions:
 * ** Show Element Size
 *    Creates overlay division to show current dimensions.
 *    Invokes on: onload, onresize
 *    Assumptions:
 *      A single image inside the containing element (e.g., figure).
 *    Calls:
 *      class="show-size-el"  : size the current block
 *      class="show-size-img" : size of image inside the current block
 *      class="show-size-vid" : size of video element inside the current block
 *    Notes:
 *      Remember to position 'element-size' so it doesn't resize the div.
 *
 * --- Revision History ------------------------------------------------------- *
 * 2019-09-17 | Genericize and remove jQuery calls
 * 2019-07-09 | Added revision log, cleaned code
 * ---------------------------------------------------------------------------- */
// *** Show Element Size ------------------------------------------------------ *
$('document').ready( function() {
  $('img[hspace]').each ( function() {
    $(this).removeAttr('hspace').attr('style','margin: auto;');
    $(this).parent().attr('style','text-align: center;');
  });
});
// *** onload operations ------------------------------------------------------ *
window.addEventListener('load', mpf_showElementSize);
/*! -- Copyright (c) 2019 Mootly Obviate -- See /LICENSE.md ------------------ */
