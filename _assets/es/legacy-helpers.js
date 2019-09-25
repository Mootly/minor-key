/* --- Legacy content helper scripts ----------------- ECMAScript 6 version --- *
 * Scripts to correct legacy code.
 * ---------------------------------------------------------------------------- *
 * Available Functions:
 * ** Clean Images
 *    Cleans old HTML tags out of images and adds appropriate styling.
 *    Notes:
 *      Fires immediately, so make sure it is at the end of the body.
 *
 * --- Revision History ------------------------------------------------------- *
 * 2019-09-25 | Added revision log, cleaned code
 * ---------------------------------------------------------------------------- */
// *** Clean Images ----------------------------------------------------------- *
                    // Fix image centering                                      *
document.querySelectorAll('img[hspace]').forEach(function(p_box) {
  p_box.removeAttr('hspace');
  p_box.style.margin                    = 'auto';
  p_box.parentElement.style.textAlign   = 'center';
}
// *** onload operations ------------------------------------------------------ *
// window.addEventListener('load', mpf_);
/*! -- Copyright (c) 2019 Mootly Obviate -- See /LICENSE.md ------------------ */
