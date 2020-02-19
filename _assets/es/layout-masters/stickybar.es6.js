/* --- Stickybar ------------------------------------- ECMAScript 6 version --- *
 * Lock the title or other element to the top of the page on scroll.
 * ---------------------------------------------------------------------------- *
 * ** Fix position on scroll (stickybar)
 *    Locks the title bar or other element to the top of the screen on scroll.
 *    Invokes on: onload, onscroll
 *    Calls:
 *      mpv_stickybar_box     : element to lock
 *      mpv_stickybar_tweak   : following elements that need margin tweaks
 *      mpv_stickybar_pos     : initial y coordinate of sticky element
 *    Notes:
 *      The layout is CSS driven, aside from locking the height of the parent
 *      this only generates styles and classes.
 *      .fixed-top { position: fixed; top: 0; left: 0; z-index: <var>; width: 100%; }
 * --- Revision History ------------------------------------------------------- *
 * 2020-01-17 | Script breakout
 * ---------------------------------------------------------------------------- */
 function mpf_stickybar() {
   const f_box       = document.querySelector(mpv_stickybar_box);
   const f_tweak     = document.querySelectorAll(mpv_stickybar_tweak);
   const f_position  = mpv_stickybar_pos;
   const f_offset    = f_box.offsetHeight;
   if (window.innerWidth > 800) {
     let f_vT        = Math.round(f_position - window.pageYOffset);
     if (f_vT < 1) {
       f_box.classList.add('fixed-top');
       f_tweak.forEach ((el_current) => {
         el_current.setAttribute('style', 'margin-top: '+f_offset+'px;');
       });
     } else {
       f_box.classList.remove('fixed-top');
       f_tweak.forEach ((el_current) => {
         el_current.setAttribute('style', '');
       });
     }
     f_firstpass     = true;
   } else if (f_firstpass)  {
     f_box.classList.remove('fixed-top');
     f_tweak.forEach ((el_current) => {
       el_current.setAttribute('style', '');
     });
     f_firstpass     = false;
   }
 }

/*! --- Copyright (c) 2020 Mootly Obviate -- See /LICENSE.md ------------------ */
