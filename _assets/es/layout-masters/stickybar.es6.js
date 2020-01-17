/* --- Page layout scripts --------------------------- ECMAScript 6 version --- *
 * Scripts for script-managed page layout features.
 * ---------------------------------------------------------------------------- *
 * Available Functions:
 * ** Fix position on scroll (stickybar)
 *    Locks the title bar or other element to the top of the screen on scroll.
 *    Invokes on: onload, onscroll
 *    Calls:
 *      class="stickybar-parent" : parent of element to lock
 *      class="stickybar"        : element to lock
 *    Notes:
 *      The parent is what tracks the position, the child is what gets locked.
 *      The layout is CSS drive, aside from locking the height of the parent
 *      this only generates classes.
 * --- Revision History ------------------------------------------------------- *
 * 2020-01-17 | Script breakout
 * 2019-11-26 | ES6 TOC generator completed
 * ---------------------------------------------------------------------------- */
// *** Show Element Size ------------------------------------------------------ *
function mpf_stickybar() {
  // f_vT            = Math.round(p_box.getBoundingClientRect().top)
  // f_vL            = Math.round(p_box.getBoundingClientRect().left)
  // if (f_vL < 1) {
      // $('#stickThis').addClass('stick');
      // $('#stick-here').height($('#stickThis').outerHeight());
  // } else {
      // $('#stickThis').removeClass('stick');
      // $('#stick-here').height(0);
  // }
}
/*! --- Copyright (c) 2020 Mootly Obviate -- See /LICENSE.md ------------------ */
