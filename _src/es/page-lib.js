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
 * 2021-04-13 | Starting a TS version
 * REDO FOR MULTIPLE AND ON ASSUMPTION WE DON'T KNOW STARTING POS OF STICKY
 * ---------------------------------------------------------------------------- */
class mpc_sticky {
    constructor(box = '.sticky', next = '.content') {
        this.box = document.querySelectorAll(box);
        this.next = document.querySelectorAll(next);
        this.box.forEach(function (el, key) {
            this.position[key] = el.getBoundingClientRect().top;
            this.offset[key] = this.box.offsetHeight;
        });
    }
    stickybar() {
        // this.firstpass  = false;
        // if (window.innerWidth > 800) {
        //   this.elTop    = Math.round(this.position - window.pageYOffset);
        //   if (this.elTop < 1) {
        //     this.box.forEach ((el_current) => {
        //       el_current.classList.add('fixed-top');
        //      }
        //    this.next.forEach ((el_current) => {
        //      el_current.setAttribute('style', 'margin-top: '+this.offset+'px;');
        //    });
        //   } else {
        //     this.box.classList.remove('fixed-top');
        //     this.next.forEach ((el_current) => {
        //       el_current.setAttribute('style', '');
        //     });
        //   }
        //   this.firstpass     = true;
        // } else if (this.firstpass)  {
        //   this.box.classList.remove('fixed-top');
        //   this.next.forEach ((el_current) => {
        //     el_current.setAttribute('style', '');
        //   });
        //   this.firstpass= false;
        // }
    }
}
// *** initialize ----------------------------------------- *
// * we want both load and scroll listeners on this         *
var mpn = mpn || {};
mpn.sticky = new mpc_sticky();
window.addEventListener('load', mpn.stickybar.eHandle);
window.addEventListener('scroll', mpn.stickybar.eHandle);
/*! --- Copyright (c) 2020 Mootly Obviate -- See /LICENSE.md ------------------ */
//# sourceMappingURL=page-lib.js.map