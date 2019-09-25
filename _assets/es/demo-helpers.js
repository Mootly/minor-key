/* --- Demo helper scripts --------------------------- ECMAScript 6 version --- *
 * Scripts to help with demonstration pages to call out elements as needed.
 * Any generated elements will still need to be styled.
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
function mpf_showElementSize() {
  document.querySelectorAll('[class*=show-size]').forEach(function(p_box) {
    let f_targ, f_vH, f_vW, f_div;
    if (p_box.classList.contains('show-size-img')) {
      f_targ        = p_box.querySelector('img').getBoundingClientRect();
    } else if (p_box.classList.contains('show-size-vid')) {
      f_targ        = p_box.querySelector('video').getBoundingClientRect();
    } else {
      f_targ        = p_box.getBoundingClientRect();
    }
    f_vH            = Math.round(f_targ.height);
    f_vW            = Math.round(f_targ.width);
    if (p_box.querySelector('.element-size')) {
      p_box.querySelector('.element-size').innerText = f_vH + ' x ' + f_vW;
    } else {
      f_div           =  document.createElement('div');
      f_div.className = 'element-size';
      f_div.innerText = f_vH + ' x ' + f_vW;
      p_box.insertBefore(f_div, p_box.firstChild);
    }
  });
};
// *** onload operations ------------------------------------------------------ *
window.addEventListener('load', mpf_showElementSize);
// *** onresize operations ---------------------------------------------------- *
window.addEventListener('resize', mpf_showElementSize);
 /*! -- Copyright (c) 2019 Mootly Obviate -- See /LICENSE.md ------------------ */
