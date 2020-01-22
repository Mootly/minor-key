/* --- Stickybar ------------------------------------- ECMAScript 6 version --- *
 * Lock the title or other element to the top of the page on scroll.
 * ---------------------------------------------------------------------------- *
 * Available Functions:
 * ** Fix position on scroll (stickybar)
 *    Locks the title bar or other element to the top of the screen on scroll.
 *    Invokes on: onload, onscroll
 *    Calls:
 *      class="stickybox"     : parent of element to lock
 *      class="stickybar"     : element to lock
 *      class="stickyclear"   : anything after the sticky that may need tweaking
 *    Notes:
 *      The parent is what tracks the position, the child is what gets locked.
 *      The layout is CSS driven, aside from locking the height of the parent
 *      this only generates classes.
 * --- Revision History ------------------------------------------------------- *
 * 2020-01-17 | Script breakout
 * 2019-11-26 | ES6 TOC generator completed
 * ---------------------------------------------------------------------------- */
 function mpf_stickybar() {
   const f_fbox      = document.getElementById('title-box');
   let f_vT          = Math.round(f_fbox.getBoundingClientRect().top);
   let f_vL          = Math.round(f_fbox.getBoundingClientRect().left);
   if (f_vT < 1) {
     $('#title-main').addClass('fixed-top');
     $('#sidebar-left').addClass('fixed-above');
     $('#content-main').addClass('fixed-above');
     $('.fixed-above').css('margin-top', $('#title-main').outerHeight());
   } else {
     $('#title-main').removeClass('fixed-top');
     $('.fixed-above').removeAttr('style');
     $('#sidebar-left').removeClass('fixed-above');
     $('#content-main').removeClass('fixed-above');
   }
 }

/*! --- Copyright (c) 2020 Mootly Obviate -- See /LICENSE.md ------------------ */
