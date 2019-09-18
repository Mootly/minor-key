/* --- Demo helper scripts --------------------------- ECMAScript 6 version --- *
 * Scripts to help with demonstration pages to call out elements as needed.
 * Any generated elements will still need to be styled.
 * ---------------------------------------------------------------------------- *
 * Available Functions:
 * ** List dimensions of an object
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

function mpf_showElementSize(tBox, tType='img') {
  if (tType == 'img') {
    const tvH       = Math.round(tBox.querySelector('img').height);
    const tvW       = Math.round(tBox.querySelector('img').width);
  } else {
    const tvH       = Math.round(tBox.height);
    const tvW       = Math.round(tBox.width);
  }
   const tDiv       =  document.createElement("div");
   tDiv.className   = "element-size";
   tDiv.innerText   = tvH + ' x ' + tvW;
   tBox.insertBefore(tDiv, tBox.firstChild);
}
window.onload = function () {
  let tShowSize     = document.querySelectorAll('.show-size-img');
  tShowSize.forEach(function(tBox) { mpf_showElementSize(tBox, 'img'); });
       tShowSize    = document.querySelectorAll('.show-size-div');
  tShowSize.forEach(function(tBox) { mpf_showElementSize(tBox, 'div'); });
};
window.onresize = function () {
  let tShowSize     = document.querySelectorAll('.show-size-img');
  tShowSize.forEach(function(tBox) { mpf_showElementSize(tBox, 'img'); });
       tShowSize    = document.querySelectorAll('.show-size-div');
  tShowSize.forEach(function(tBox) { mpf_showElementSize(tBox, 'div'); });
  tTarget.forEach(function(tTargetImgBox) {
    const tvH       = Math.round(tTargetImgBox.querySelector('img').height);
    const tvW       = Math.round(tTargetImgBox.querySelector('img').width);
    tTargetImgBox.querySelector('.element-size').innerText(tvH + ' x ' + tvW);
  });
};
 /*! -- Copyright (c) 2019 Mootly Obviate -- See /LICENSE.md ------------------ */
