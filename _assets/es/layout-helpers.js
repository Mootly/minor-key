/* --- Page layout scripts --------------------------- ECMAScript 6 version --- *
 * Scripts for script-managed page layout features.
 * ---------------------------------------------------------------------------- *
 * ** Fix position on scroll (stickybar)
 *    Locks the title bar or other element to the top of the screen on scroll.
 *    Invokes on: onload, onscroll
 *    Calls:
 *      class="stickybox"     : parent of element to lock
 *      class="stickybar"     : element to lock
 *      class="stickyclear"   : anything after the sticky that may need tweaking
 *    Notes:
 *      The parent is what tracks the position, the child is what gets locked.
 *      The layout is CSS driven, aside from locking the height of the parent
 *      this only generates classes.
 * ---------------------------------------------------------------------------- *
 * ** Table of Contents Generator
 *  Automates jump link menu based on headings the current page.
 *  Invokes on: onload
 * -----
 *  Tasks:
 *  - A menu is inserted after element with id="toc-links":
 *    Example: <h2 id="toc-links">Contents</h2>
 *  - The menu includes all tier 1 elements (var: mpv_toc_tier1).
 *  - Checks for '.add-toc" to include tier 2 elements (var: mpv_toc_tier2).
 *  - If a listed element does not have an ID, it assigns one.
 * -----
 *  Calls:
 *    id="toc-links"    : the header for the TOC itself, appends below it
 *    class="add-toc"   : specifies second tier listings to add
 * -----
 *  Assumptions:
 *  - Only uses IDs. (Do not use embedded anchors.)
 *  - Only checks for targets in specified divs by ID.
 *  - Tier 2 elements are siblings of tier 1 elements.
 *  - If DL is listed for tier 2, targets child DT elements.
 * -----
 *  User set flags - Most of these are best declared at the template level
 *  Flag            | Default         |
 *  toc_container   | 'page-body'     | the element to search for headings
 *  toc_exclude      | ''              | comma separated list of headings to exclude
 *                  |                 | script automaticaly excludes id="toc-links"
 *  toc_tier1       | 'h2'            | the heading to use to generate the TOC
 *  toc_tier2       | 'h3,dl'         | somma separated list of elements to check for add-toc
 *  toc_skipAll     | false           | do not insert links back to the top
 *  toc_skipFirst   | true            | skip top link on first heading
 *  toc_skipNested  | true            | only add links to top level headings
 * -----
 *  Notes:
 *    Set the TOC header to display: none; in case script fails to fire.
 *    Script will change this to display: block;
 * ---------------------------------------------------------------------------- *
 * --- Revision History ------------------------------------------------------- *
 * 2019-11-26 | ES6 TOC generator completed
 * ---------------------------------------------------------------------------- */
// *** Stickybar -------------------------------------------------------------- *
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

// *** ------------------------------------------------------------------------ *
// *** TOC Generator ---------------------------------------------------------- *
// * Tasks:
// * - A menu is inserted after element with id="toc-links":
// *   Example: <h2 id="toc-links">Contents</h2>
// * - The menu includes all tier 1 elements (var: mpv_toc_tier1).
// * - Checks for '.add-toc" to include tier 2 elements (var: mpv_toc_tier2).
// * - If a listed element does not have an ID, it assigns one.
function mpf_toc_generator() {
                   // *** check for a TOC element, otherwise do nothing        *
 const el_tocTarget = document.getElementById('toc-links');
 if (el_tocTarget) {
                   // *** populate or configuration variables ---------------- *
                   // Unhide TOC - TOC hidden in case script doesn't load      *
   el_tocTarget.style.display = 'block';
                   // TOC starts with this heading                             *
   var   toc_tier1           = toc_tier1 || 'h2';
                   // Limit TOC to these additional elements                   *
   var   toc_tier2           = (toc_tier2) ? toc_tier2.split(/,\s?/) : ['h3', 'dt'];
   var   toc_includes        = toc_tier1+', '+toc_tier2.toString();
                   // ID of content section to use                              *
   var   toc_container       = toc_container || 'page-body';
                   // Array of headings to exclude by text value               *
                   // Can also use the class of 'toc-skip' within a page       *
   var   toc_exclude         = (toc_exclude)
                               ? (el_tocTarget.innerText + ',' + toc_exclude).split(/,\s/)
                               : [el_tocTarget.innerText];
                   // Variables to generate links back to the top of the page  *
   var   toc_skipAll         = toc_skipAll || false;
   var   toc_skipFirst       = toc_skipFirst || true;
   var   toc_skipNested      = toc_skipNested || true;
                   // *** Create our back to top link ------------------------ *
                   // If no body ID, return to top at TOC instead.             *
   const toc_topID           = (document.body.id) ? document.body.id : 'toc-link' ;
   let   el_topLinkDiv       = document.createElement('div');
         el_topLinkDiv.className = 'top-link';
   let   el_topLinkA         = document.createElement('a');
         el_topLinkA.title   = 'Back to Top';
         el_topLinkA.href    = '#'+toc_topID;
         el_topLinkA.innerHTML = '<span>[top]</span>';
         el_topLinkDiv.appendChild(el_topLinkA);
                   // *** Generate our TOC block ----------------------------- *
                   // place the container and repurpose the element            *
   let   el_tocLinkList      = document.createElement('ul');
   let   el_tocLinkSubList   = document.createElement('ul');
         el_tocLinkList.id   = 'jumpto';
         el_tocTarget.parentNode.insertBefore(el_tocLinkList, el_tocTarget.nextSibling);
         el_tocLinkList      = document.getElementById('jumpto');
                   // *** Begin our element loop ----------------------------- *
                   // Remember to match case on string tests                   *
   let   nlist_includes = document.getElementById(toc_container).querySelectorAll(toc_includes);
   let   el_id_tie = 0;
   nlist_includes.forEach ((el_current) => {
     let b_linkText        = el_current.textContent;
                   // add id attribute to target if none                       *
     if (!(el_current.hasAttribute('id'))) {
       el_current.id = 'goto-'+(el_id_tie++)+'-'+(b_linkText
       .replace(/[`~!@#$%^&*()|+=?;'",.<>\{\}\[\]\\\/]/gi,'')
       .trim().replace(/ /g,'-')).substring(0,32);
     }
     if ((el_current.tagName.toLowerCase() == toc_tier1.toLowerCase()) &&
         (toc_exclude.indexOf(el_current.textContent) == -1) &&
        !(el_current.classList && el_current.classList.contains('toc-skip'))) {
                   // write out chidlren if we have them                       *
       if (el_tocLinkSubList.childElementCount && el_tocLinkList.childElementCount) {
         el_tocLinkList.lastElementChild.appendChild(el_tocLinkSubList.cloneNode(true));
         while (el_tocLinkSubList.firstChild) {
           el_tocLinkSubList.removeChild(el_tocLinkSubList.firstChild);
         }
       }
                   // add link to toc - note clone call                        *
                   // check whether to skip first or skip all                  *
       if (!toc_skipAll) {
         if (toc_skipFirst) {
           toc_skipFirst = false;
         } else {
           el_current.parentNode.insertBefore(el_topLinkDiv.cloneNode(true), el_current)
         }
       }
                   // add linkto TOC element                                   *
       let   el_tocLinkItem            = document.createElement('li');
             el_tocLinkItem.id         = 'jumpto'+el_current.id;
       let   el_tocLinkA               = document.createElement('a');
             el_tocLinkA.setAttribute('href', '#'+el_current.id);
             el_tocLinkA.innerText     = el_current.textContent;
             el_tocLinkItem.appendChild(el_tocLinkA);
             el_tocLinkList.appendChild(el_tocLinkItem);
     }
     if (el_current.classList && el_current.classList.contains('add-toc')) {
       // add linkto TOC element                                   *
       let   el_tocLinkSubItem         = document.createElement('li');
             el_tocLinkSubItem.id      = 'jumpto'+el_current.id;
       let   el_tocLinkSubA            = document.createElement('a');
             el_tocLinkSubA.setAttribute('href', '#'+el_current.id);
             el_tocLinkSubA.innerText  = el_current.textContent;
             el_tocLinkSubItem.appendChild(el_tocLinkSubA);
             el_tocLinkSubList.appendChild(el_tocLinkSubItem);
     }
   });
 }
}
// *** ------------------------------------------------------------------------ *
// *** variable presets for listeners ----------------------------------------- *
const mpv_toc_header      = '#toc-links';
const mpv_stickybar_box   = '#title-box';
const mpv_stickybar_tweak = '#content-main';
const mpv_stickybar_pos   = document.querySelector(mpv_stickybar_box).offsetTop;
// *** onload operations ------------------------------------------------------ *
if (document.querySelector(mpv_toc_header)) {
  window.addEventListener('load', mpf_toc_generator);
}
if (document.querySelector(mpv_stickybar_box)) {
  window.addEventListener('load', mpf_stickybar);
}
// *** onscroll operations ---------------------------------------------------- *
if (document.querySelector(mpv_stickybar_box)) {
  window.addEventListener('scroll', mpf_stickybar);
}
// *** onresize operations ---------------------------------------------------- *
// window.addEventListener('resize', mpf_);
/*! --- Copyright (c) 2019 Mootly Obviate -- See /LICENSE.md ------------------ */
// some development notes to me
// https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/addEventListener
//  https://jsfiddle.net/ghctkLgg/
//  https://html-online.com/articles/javascript-stick-html-top-scroll/
// https://www.javascripttutorial.net/es6/javascript-const/
// https://medium.com/@MentallyFriendly/es6-an-idiots-guide-to-let-and-const-70be9691c389
// https://2ality.com/2015/02/es6-scoping.html
// https://blog.pragmatists.com/let-your-javascript-variables-be-constant-1633e56a948d
