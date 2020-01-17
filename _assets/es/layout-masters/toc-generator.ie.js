/* --- Table of Contents Generator ---------------------- Legacy JS version --- *
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
 *  toc_system      | ''              | comma separated list of headings to exclude
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
 * --- Revision History ------------------------------------------------------- *
 * 2020-01-17 | Script breakout
 * 2019-11-26 | ES6 TOC generator completed
 * ---------------------------------------------------------------------------- */
function mpf_toc_generator() {
                    // check for a TOC element, otherwise do nothing            *
  var el_tocTarget = document.getElementById('toc-links');
  if (el_tocTarget) {
                    // *** populate or configuration variables ---------------- *
                    // Unhide TOC - TOC hidden in case script doesn't load      *
    el_tocTarget.style.display = 'block';
                    // TOC starts with this heading                             *
    var c_toc_tier1           = (typeof toc_tier1       !== 'undefined')
                                ? toc_tier1       : 'h2';
                    // And also includes these elements
    var c_toc_tier2           = (typeof toc_tier2       !== 'undefined')
                                ? toc_tier2.split(/,\s?/)
                                : ['h3', 'dt'];
    var c_toc_includes        = c_toc_tier1+', '+c_toc_tier2.toString();
                    // Array of content section IDs to use                      *
    var c_toc_container       = (typeof toc_container   !== 'undefined')
                                ? toc_container.split(/,\s?/)
                                : ['page-body'];
                    // Array of headings to exclude                             *
    var c_toc_system          = (typeof toc_system      !== 'undefined')
                                ? (el_tocTarget.innerText + ',' + toc_system).split(/,\s/)
                                : [el_tocTarget.innerText];
                    // Variables to generate links back to the top of the page  *
    var c_toc_skipAll         = (typeof toc_skipAll     !== 'undefined')
                                ? toc_skipAll
                                : false;
    var   v_toc_skipFirst     = (typeof toc_skipFirst   !== 'undefined')
                                ? toc_skipFirst
                                : true;
    var c_toc_skipNested      = (typeof toc_skipNested  !== 'undefined')
                                ? toc_skipNested
                                : true;
                    // *** Create our back to top link ------------------------ *
                    // If no body ID, return to top at TOC instead.             *
    var c_toc_topID           = (document.body.id) ? document.body.id : 'toc-link' ;
    var el_topLinkDiv         = document.createElement('div');
        el_topLinkDiv.className = 'top-link';
    var el_topLinkA           = document.createElement('a');
        el_topLinkA.title     = 'Back to Top';
        el_topLinkA.href      = '#'+c_toc_topID;
        el_topLinkA.innerHTML = '<span>[top]</span>';
        el_topLinkDiv.appendChild(el_topLinkA);
                    // *** Generate our TOC block ----------------------------- *
                    // place the container and repurpose the element            *
    var el_tocLinkList        = document.createElement('ul');
    var el_tocLinkSubList     = document.createElement('ul');
        el_tocLinkList.id     = 'jumpto';
        el_tocTarget.parentNode.insertBefore(el_tocLinkList, el_tocTarget.nextSibling);
        el_tocLinkList        = document.getElementById('jumpto');
                    // *** ---------------------------------------------------- *
                    // *** Begin our element loop ----------------------------- *
                    // *** Remember to match case on string tests               *
    var nlist_includes        = document.querySelectorAll(c_toc_includes);
    var a_toc_includes        = Array.prototype.slice.apply(nlist_includes);
    a_toc_includes.forEach(function (el_current) {
      var v_linkText          = el_current.textContent;
                    // add id attribute to target if none                       *
                    // doing it once outside of tests to simplify               *
      if (!(el_current.hasAttribute('id'))) {
        el_current.id = 'goto-'+v_linkText
        .replace(/[`~!@#$%^&*()|+=?;'",.<>\{\}\[\]\\\/]/gi,'')
        .trim().replace(/ /g,'-');
      }
      if ((el_current.tagName.toLowerCase() == c_toc_tier1.toLowerCase()) &&
          (c_toc_system.indexOf(el_current.textContent) == -1) &&
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
        if (!c_toc_skipAll) {
          if (v_toc_skipFirst) {
            v_toc_skipFirst = false;
          } else {
            el_current.parentNode.insertBefore(el_topLinkDiv.cloneNode(true), el_current)
          }
        }
                    // add linkto TOC element                                   *
        var el_tocLinkItem              = document.createElement('li');
            el_tocLinkItem.id           = 'jumpto'+el_current.id;
        var el_tocLinkA                 = document.createElement('a');
            el_tocLinkA.setAttribute('href', '#'+el_current.id);
            el_tocLinkA.innerText       = el_current.textContent;
            el_tocLinkItem.appendChild(el_tocLinkA);
            el_tocLinkList.appendChild(el_tocLinkItem);
      }
      if (el_current.classList && el_current.classList.contains('add-toc')) {
        // add linkto TOC element                                   *
        var el_tocLinkSubItem           = document.createElement('li');
            el_tocLinkSubItem.id        = 'jumpto'+el_current.id;
        var el_tocLinkSubA              = document.createElement('a');
            el_tocLinkSubA.setAttribute('href', '#'+el_current.id);
            el_tocLinkSubA.innerText    = el_current.textContent;
            el_tocLinkSubItem.appendChild(el_tocLinkSubA);
            el_tocLinkSubList.appendChild(el_tocLinkSubItem);
      }
    });
  }
}
/*! --- Copyright (c) 2020 Mootly Obviate -- See /LICENSE.md ------------------ */
