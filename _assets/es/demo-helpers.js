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
 *      Remember to osition 'element-size' so it doesn't resize the div.
 *
 * --- Revision History ------------------------------------------------------- *
 * 2019-09-17 | Genericize and remove jQuery calls
 * 2019-07-09 | Added revision log, cleaned code
 * ---------------------------------------------------------------------------- */
// *** Show Element Size ------------------------------------------------------ *
function mpf_showElementSize(tBox, tType='img') {
  let tvH, tvW, tDiv;
  if (tType == 'img') {
    tvH             = Math.round(tBox.querySelector('img').height);
    tvW             = Math.round(tBox.querySelector('img').width);
  } else {
    tvH             = Math.round(tBox.height);
    tvW             = Math.round(tBox.width);
  }
  if (tBox.firstChild.classname == 'element-size') {
    tBox.firstChild.innerText(tvH + ' x ' + tvW);
  } else {
    tDiv            =  document.createElement('div');
    tDiv.className  = 'element-size';
    tDiv.innerText  = tvH + ' x ' + tvW;
    tBox.insertBefore(tDiv, tBox.firstChild);
  }
}
// *** onload operations ------------------------------------------------------ *
window.onload = function () {
  let tShowSize     = document.querySelectorAll('.show-size-img');
  tShowSize.forEach(function(tBox) { mpf_showElementSize(tBox, 'img'); });
      tShowSize     = document.querySelectorAll('.show-size-div');
  tShowSize.forEach(function(tBox) { mpf_showElementSize(tBox, 'div'); });
};
// *** onresize operations ---------------------------------------------------- *
window.onresize = function () {
  let tShowSize     = document.querySelectorAll('.show-size-img');
  tShowSize.forEach(function(tBox) { mpf_showElementSize(tBox, 'img'); });
      tShowSize     = document.querySelectorAll('.show-size-div');
  tShowSize.forEach(function(tBox) { mpf_showElementSize(tBox, 'div'); });
};
 /*! -- Copyright (c) 2019 Mootly Obviate -- See /LICENSE.md ------------------ */
