/* --- Demo helper scripts --------------------------- ECMAScript 6 version --- *
 * Scripts to help with demonstration pages to call out elements as needed.
 * Any generated elements will still need to be styled.
 * ---------------------------------------------------------------------------- *
 * Available Functions:
 * ** Show Element Size
 *    Creates overlay division to show current dimensions.
 *    Invokes on: onload, onresize
 *    Calls:
 *      class="show-size-div" : size the current block
 *      class="show-size-img" : size of image inside the current block
 *    Notes:
 *      Remember to position 'element-size' so it doesn't resize the div.
 *
 * --- Revision History ------------------------------------------------------- *
 * 2019-09-17 | Genericize and remove jQuery calls
 * 2019-07-09 | Added revision log, cleaned code
 * ---------------------------------------------------------------------------- */
// *** Show Element Size ------------------------------------------------------ *
function mpf_showElementSize(p_box, p_type='img') {
  let f_vH, f_vW, f_div;
  if (p_type == 'img') {
    f_vH            = Math.round(p_box.querySelector('img').height);
    f_vW            = Math.round(p_box.querySelector('img').width);
  } else {
    f_vH            = Math.round(p_box.height);
    f_vW            = Math.round(p_box.width);
  }
  if (p_box.firstChild.className == 'element-size') {
    p_box.firstChild.innerText = f_vH + ' x ' + f_vW;
  } else {
    f_div           =  document.createElement('div');
    f_div.className = 'element-size';
    f_div.innerText = f_vH + ' x ' + f_vW + ' - ';
    p_box.insertBefore(f_div, p_box.firstChild);
  }
}
                    // The iterator for the above loop                          *
function mpf_checkElementSize() {
  let f_showSize    = document.querySelectorAll('.show-size-img');
  f_showSize.forEach(function(p_box) { mpf_showElementSize(p_box, 'img'); });
      f_showSize    = document.querySelectorAll('.show-size-div');
  f_showSize.forEach(function(p_box) { mpf_showElementSize(p_box, 'div'); });
};

// *** onload operations ------------------------------------------------------ *
window.addEventListener('load', mpf_checkElementSize);
// *** onresize operations ---------------------------------------------------- *
window.addEventListener('resize', mpf_checkElementSize);
 /*! -- Copyright (c) 2019 Mootly Obviate -- See /LICENSE.md ------------------ */
