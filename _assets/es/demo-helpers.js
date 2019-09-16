/* --- Demo helper scripts --------------------------- ECMAScript 6 version --- *
 * Scripts to help with demonstration pages to call out elements as needed.
 * --- Revision History ------------------------------------------------------- *
 * 2019-07-09 | Added revision log, cleaned code
 * ---------------------------------------------------------------------------- */

/* --- Label images sizes with an overlay ------------------------------------- */
                    // images block.size-img > img                              *
window.onload = function () {
  var tTarget = document.querySelectorAll('.size-img');
  tTarget.forEach(function(tTargetImgBox) {
    var tvH = Math.round(tTargetImgBox.querySelector('img').height);
    var tvW = Math.round(tTargetImgBox.querySelector('img').width);
    var tSizeBox =  document.createElement("div");
    tSizeBox.className = "element-size";
    tSizeBox.innerText = tvH + ' x ' + tvW;
    tTargetImgBox.insertBefore(tSizeBox, tTargetImgBox.firstChild);
  });
};
window.onresize = function () {
  var tTarget = document.querySelectorAll('.size-img');
  tTarget.forEach(function(tTargetImgBox) {
    var tvH = Math.round(tTargetImgBox.querySelector('img').height);
    var tvW = Math.round(tTargetImgBox.querySelector('img').width);
    tTargetImgBox.querySelector('.element-size').innerText(tvH + ' x ' + tvW);
  });
};
 /*! -- Copyright (c) 2019 Mootly Obviate -- See /LICENSE.md ------------------ */
