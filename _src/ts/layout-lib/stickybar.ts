/* --- Stickybar --------------------------------------- TypeScript version --- *
 * Lock the title or other element to the top of the page on scroll.
 * ---------------------------------------------------------------------------- *
 * Namespace : mp_sticky
 * *** Fix position on scroll (stickybar)
 * Locks the title bar or other element to the top of the screen on scroll.
 * Invokes on: onload, onscroll
 * Calls:
 *   box  : class   : element(s) to lock
 *   next : class   : first element following first sticky
 *                  : will autograb if not provided
 * Notes:
 *   The layout is CSS driven, aside from locking the height of the parent
 *   the script only generates a class for our fixed elements
 *   and styles for elements that need to clear them.
 *   .fixed-top     : our fixed elements
 *   Although it appears to support many, it only supports one at present.
 * --- Revision History ------------------------------------------------------- *
 * 2021-04-13 | Starting a TS version
 * ---------------------------------------------------------------------------- */
class mpc_sticky {
  box               : NodeListOf<HTMLElement>;
  next              : NodeListOf<HTMLElement>;
  position          : number[];
  offset            : number[];
  eHandle           : object;
  firstpass         : boolean;
  elTop             : number[];
  constructor(
    box   : string        = '.sticky',
    next? : string
  ) {
    this.firstpass        = false;
    this.box              = document.querySelectorAll(box);
    this.next             = document.querySelectorAll(next);
    this.box.forEach ((el : HTMLElement, key : number) => {
      this.position[key]  = el.getBoundingClientRect().top
      this.offset[key]    = el.offsetHeight;
    });
  }
  stickybox() {
    if (window.innerWidth > 800) {
      this.position.forEach ((curr_pos : number, key : number) => {
        this.elTop[key]   = Math.round(curr_pos - window.pageYOffset);
        if (this.elTop[key] < 1) {
          this.box[key].classList.add('fixed-top');
          this.next[key].setAttribute('style', 'margin-top: ${this.offset}px;');
        } else {
          this.box[key].classList.remove('fixed-top');
          this.next[key].setAttribute('style', '');
        }
      });
      this.firstpass      = true;
    } else if (this.firstpass)  {
      this.box.forEach ((el : HTMLElement, key : number) => { el.classList.remove('fixed-top'); });
      this.next.forEach ((el : HTMLElement, key : number) => { el.setAttribute('style', ''); });
      this.firstpass      = false;
    }
  }
}
                    // *** Initialize - Example ------------------------------- *
                    // * we want both load and scroll listeners on this         *
// [namespace].sticky = new mpc_sticky();
// window.addEventListener('load', mpn.sticky.stickybox.eHandle);
// window.addEventListener('scroll', mpn.sticky.sitckybox.eHandle);
/*! --- Copyright (c) 2020 Mootly Obviate -- See /LICENSE.md ------------------ */
