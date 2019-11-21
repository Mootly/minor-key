/* --- Page layout scripts --------------------------- ECMAScript 6 version --- *
 * Scripts for script-managed page layout features.
 * ---------------------------------------------------------------------------- *
 * Available Functions:
 * ** Fix position on scroll (stickybar)
 *    Locks the title bar or other element to the top of the screen on scroll.
 *    Invokes on: onload, onscroll
 *    Calls:
 *      class="stickybar-parent" : parent of element to lock
 *      class="stickybar"        : element to lock
 *    Notes:
 *      The parent is what tracks the position, the child is what gets locked.
 *      The layout is CSS drive, aside from locking the height of the parent
 *      this only generates classes.
 * ---------------------------------------------------------------------------- *
 * ** Table of Contents Generator
 *    Automates jump link menu based on headings the current page.
 *    Invokes on: onload
 *    Calls:
 *      id="toc-links"    : the header for the TOC itself, appends below it
 *      class="add-toc"   : specifies second tier listings to add
 *    Assumptions:
 *    - Only uses IDs. (Do not use embedded anchors.)
 *    - Only checks for targets in specified divs by ID.
 *    - Tier 2 elements are siblings of tier 1 elements.
 *    - If DL is listed for tier 2, targets child DT elements.
 *    User set flags - Most of these are best declared at the template level
 *    Flag              | Default       |
 *    toc_container     | 'page-body'   | the element to search for headings
 *    toc_system        | ''            | comma separated list of headings to exclude
 *                      |               | script automaticaly excludes id="toc-links"
 *    toc_tier1         | 'h2'          | the heading to use to generate the TOC
 *    toc_tier2         | 'h3,dl'       | comma separated list of elements to check for add-toc
 *    toc_skipAll       | false         | do not insert links back to the top
 *    toc_skipFirst     | true          | skip top link on first heading
 *    toc_skipNested    | true          | only add links to top level headings
 *    Notes:
 *      Set the TOC header to display: none; in case script fails to fire.
 *      Script will change this to display: block;
 * ---------------------------------------------------------------------------- *
 * --- Revision History ------------------------------------------------------- *
 * 2019-09-21 | Createe
 * ---------------------------------------------------------------------------- */
// *** Show Element Size ------------------------------------------------------ *
function mpf_stickybar() {
  // f_vT            = Math.round(p_box.getBoundingClientRect().top)
  // f_vL            = Math.round(p_box.getBoundingClientRect().left)
  // if (f_vL < 1) {
      // $('#stickThis').addClass('stick');
      // $('#stick-here').height($('#stickThis').outerHeight());
  // } else {
      // $('#stickThis').removeClass('stick');
      // $('#stick-here').height(0);
  // }
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
                    // check for a TOC element, otherwise do nothing            *
  const el_tocTarget = document.getElementById('toc-links');
  if (el_tocTarget) {
                    // *** populate or configuration variables ---------------- *
                    // Unhide TOC - TOC hidden in case script doesn't load      *
    el_tocTarget.style.display = 'block';
                    // TOC starts with this heading                             *
    const c_toc_tier1         = (typeof toc_tier1       !== 'undefined')
                                ? toc_tier1       : 'h2';
                    // To catch DTs, specify parent DL                          *
    const c_toc_tier2         = (typeof toc_tier2       !== 'undefined')
                                ? toc_tier2.split(/,\s/)
                                : ['h3','dl'];
                    // Array of content section IDs to use                      *
    const c_toc_container     = (typeof toc_container   !== 'undefined')
                                ? toc_container.split(/,\s/)
                                : ['page-body'];
                    // Array of headings to exclude                             *
    const c_toc_system        = (typeof toc_system      !== 'undefined')
                                ? (el_tocTarget.innerText + ',' + toc_system).split(/,\s/)
                                : [el_tocTarget.innerText];
                    // Variables to generate links back to the top of the page  *
    const c_toc_skipAll       = (typeof toc_skipAll     !== 'undefined')
                                ? toc_skipAll
                                : false;
    const c_toc_skipFirst     = (typeof toc_skipFirst   !== 'undefined')
                                ? toc_skipFirst
                                : true;
    const c_toc_skipNested    = (typeof toc_skipNested  !== 'undefined')
                                ? toc_skipNested
                                : true;
                    // *** Create our back to top link ------------------------ *
                    // If no body ID, return to top at TOC instead.             *
    const c_toc_topID         = (document.body.id) ? document.body.id : 'toc-link' ;
    let   el_topLinkDiv       =  document.createElement('div');
          el_topLinkDiv.className = 'top-link';
    let   el_topLinkA         =  document.createElement('a');
          el_topLinkA.title   = 'Back to Top';
          el_topLinkA.href    = '#'+c_toc_topID;
          el_topLinkA.innerHTML = '<span>[top]</span>';
          el_topLinkDiv.appendChild(el_topLinkA);
                    // *** Generate our TOC block ----------------------------- *
                    // place the container and repurpose the element            *
    let   el_tocLinkList      = document.createElement('ul');
          el_tocLinkList.className = 'jumpto';
          el_tocTarget.parentNode.insertBefore(el_tocLinkList, el_tocTarget.nextSibling);
          el_tocLinkList      = document.getElementById('jumpto');
                    // *** Begin our element loop ----------------------------- *
    let   nlist_tier1 = document.querySelectorAll(c_toc_tier1);
    nlist_tier1.forEach ((el_current) => {
      if (!(c_toc_system.includes(el_current.textContent)) &&
          !(el_current.classList.contains('toc-skip'))) {
        let v_linkText        = el_current.textContent;
                    // add id attribute to target if none                       *
        if (!(el_current.hasAttribute('id'))) {
          el_current.id = 'goto-'+v_linkText.replace(/[`~!@#$%^&*()|+=?;'",<>\{\}\[\]\\\/]/gi,'').trim().replace(/ /g,'-');
                    // add link to toc                                          *
        }
// *** TO HERE *** TO HERE *** TO HERE *** TO HERE *** TO HERE *** TO HERE ***  *
          // mpv_toc_menuList += '<li id="jumpto-'+mpv_toc_this.attr('id')+'"><a href="#'+mpv_toc_this.attr('id')+'">'+mpv_toc_thisText+'</a>';
      }
    });
  //                   // add links for tier 2 elements                            *
  //         if (mpv_toc_skipFirst) { mpv_toc_skipFirst = false; } else { mpv_toc_this.before(mpv_toc_returnto); }
  //         var mpv_toc_flList = mpv_toc_this.nextUntil(mpv_toc_tier1,mpv_toc_tier2);
  //         var mpv_toc_flLength = mpv_toc_flList.length;
  //         for (var j=0; j<mpv_toc_flLength; j++) {
  //                   // this will only catch siblings                            *
  //           var mpv_toc_flThis = mpv_toc_flList.eq(j);
  //           if (mpv_toc_flThis.hasClass('add-toc')) {
  //             if (!(mpv_toc_flThis.is('[id]'))) {
  //               mpv_toc_flThis.attr('id', 't2-'+mpv_toc_flThis.text().replace(/ /g,'-'));
  //             }
  //             if (!mpv_toc_skipNested) { mpv_toc_flThis.before(mpv_toc_returnto); }
  //             subMenuList += '<li><a href="#'+mpv_toc_flThis.attr('id')+'">'+mpv_toc_flThis.text()+'</a></li>';
  //           }
  //                   // this will catch DTs                                      *
  //           var mpv_toc_fl2List = mpv_toc_flThis.children('.add-toc');
  //           var mpv_toc_fl2Length = mpv_toc_fl2List.length;
  //           for (var k=0; k<mpv_toc_fl2Length; k++) {
  //             var mpv_toc_fl2This = mpv_toc_fl2List.eq(k);
  //             if (!(mpv_toc_fl2This.is('[id]'))) {
  //               mpv_toc_fl2This.attr('id', 'dl-'+mpv_toc_fl2This.text().replace(/ /g,'-'));
  //             }
  //             subMenuList += '<li><a href="#'+mpv_toc_fl2This.attr('id')+'">'+mpv_toc_fl2This.text()+'</a></li>';
  //           }
  //         }
  //                   // if submenu, nest in menu                                 *
  //         if (subMenuList) { subMenuList = '<ul>'+subMenuList+'</ul>'; }
  //         mpv_toc_menuList += subMenuList;
  //         mpv_toc_menuList += '</li>';
  //       }
  //     }
  //   }
                    // *** write the menu ------------------------------------- *
    el_tocTarget.parentNode.insertBefore(el_tocLinkList, el_tocTarget.nextSibling);
    // $('#toc-links').after('<ul id="jumpto" />');
    // $('#jumpto').append(mpv_toc_menuList);
  }
}
// *** ------------------------------------------------------------------------ *
// *** onload operations ------------------------------------------------------ *
window.addEventListener('load', mpf_toc_generator);
// *** onresize operations ---------------------------------------------------- *
// window.addEventListener('resize', mpf_);
// *** onscroll operations ---------------------------------------------------- *
// window.addEventListener('scroll', mpf_);

/*! --- Copyright (c) 2019 Mootly Obviate -- See /LICENSE.md ------------------ */

// https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/addEventListener
//  https://jsfiddle.net/ghctkLgg/
//  https://html-online.com/articles/javascript-stick-html-top-scroll/
