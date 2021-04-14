/* --- Stickybar --------------------------------------- TypeScript version --- *
 * Lock the title or other element to the top of the page on scroll.
 * ---------------------------------------------------------------------------- *
 * Namespace : mp_sticky
 * *** Fix position on scroll (stickybar)
 * Locks the title bar or other element to the top of the screen on scroll.
 * Invokes on: onload, onscroll
 * Calls:
 *   mpv_sticky_box : class   : element(s) to lock
 *   mpv_sticky_next: id      : first element following first sticky
 *    Notes:
 *      The layout is CSS driven, aside from locking the height of the parent
 *      this only generates styles and classes.
 *      .fixed-top  : our fixed elements
 * --- Revision History ------------------------------------------------------- *
 * 2021-04-13 | Startign a TS version
 * REDO FOR MULTIPLE AND ON ASSUMPTION WE DON'T KNOW STARTING POS OF STICKY
 * ---------------------------------------------------------------------------- */
// *** variables we need ------------------------------------------------------ *
// *** initialize ------------------------------------------------------------- *
// * we want both load and scroll listeners on this                             *
var box = (box === undefined) ? '#content-main' : box;
var next = (next === undefined) ? '#content-main' : next;
var position = document.querySelector(box).getBoundingClientRect().top;
function init() {
    if (document.querySelector(box)) {
        window.addEventListener('load', stickybar);
        window.addEventListener('scroll', stickybar);
    }
}
// *** our sticky function ---------------------------------------------------- *
function stickybar() {
    let f_firstpass = false;
    const f_box = document.querySelector(box);
    const f_tweak = document.querySelectorAll(next);
    const f_position = position;
    const f_offset = f_box.getBoundingClientRect().top;
    if (window.innerWidth > 800) {
        let f_vT = Math.round(f_position - window.pageYOffset);
        if (f_vT < 1) {
            f_box.classList.add('fixed-top');
            f_tweak.forEach((el_current) => {
                el_current.setAttribute('style', 'margin-top: ' + f_offset + 'px;');
            });
        }
        else {
            f_box.classList.remove('fixed-top');
            f_tweak.forEach((el_current) => {
                el_current.setAttribute('style', '');
            });
        }
        f_firstpass = true;
    }
    else if (f_firstpass) {
        f_box.classList.remove('fixed-top');
        f_tweak.forEach((el_current) => {
            el_current.setAttribute('style', '');
        });
        f_firstpass = false;
    }
}
/*! --- Copyright (c) 2020 Mootly Obviate -- See /LICENSE.md ------------------ */
//# sourceMappingURL=page-lib.js.map