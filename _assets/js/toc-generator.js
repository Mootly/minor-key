/* --- Page content menu generator -------------------------------------------- ***
 * This routine automates the table of contents for jump links internal to
 * the current page.
 * Tasks:
 * - A menu is inserted after element with id="toc-links":
 *   Exmaple: <h2 id="toc-links">Contents</h2>
 * - The menu includes all tier 1 elements (var: mpc_toc_tier1).
 * - Checks for '.add-toc" to include tier 2 elements (var: mpc_toc_tier2).
 * - If a listed element does not have an ID, it assigns one.
 * Assumptions:
 * - Only uses IDs and ignores embedded anchors.
 * - Only checks for targets in specified divs by ID.
 * - Tier 2 elements are siblings of tier 1 elements.
 * - If DL is listed for tier 2, targets child DT elements.
 * User set flags
 * Flag                   | Default     |
 * mpv_toc_skipFirst      | true        | skip top link on first heading
 * mpv_toc_skipNested     | true        | only add links to top level headings
 * <class> add-toc        |             | add this item to TOC
 * --- Revision History ------------------------------------------------------- *
 * 2020-04-10 | Scrub auto-generated links from clamshells, etc. in TOC
 * 2019-07-09 | Added revision log, cleaned code
 * ---------------------------------------------------------------------------- */
$(window).on( 'load', function () {
  if ($('#toc-links').length) {
    $('#toc-links').show();
    var mpv_toc_menuList  = '';
                    // TOC starts with this heading                             *
    var mpv_toc_tier1     = (typeof toc_tier1 === 'undefined') ? 'h2' : toc_tier1;
                    // To catch DTs, specify parent DL                          *
    var mpv_toc_tier2     = (typeof toc_tier2 === 'undefined') ? 'h3, dl' : toc_tier2;
                    // Comma separated list of content section IDs to use       *
    var mpv_toc_container = '#content-main, #right_content';
                    // Variables to generate links back to the top of the page  *
    if (typeof mpv_toc_skipFirst  == 'undefined') { mpv_toc_skipFirst  = true; }
    if (typeof mpv_toc_skipNested == 'undefined') { mpv_toc_skipNested = true; }
                    // If no body ID, return to top at TOC.                     *
    var mpv_toc_topID     = ($('body').is('[id]')) ? $('body').attr('id') : 'toc-link' ;
    var mpv_toc_returnto  = '<div class="top-link"><a href="#'+mpv_toc_topID+'"><span>[top]</span></a></div>';
                    // don't include headings with this text in them            *
    var mpv_toc_system = ['Status', 'Warning', 'Quick Links', 'Contents', 'Internal Notes'];
                    // generate an array of all H2 headings                     *
    var mpv_toc_list = $(mpv_toc_container).find(mpv_toc_tier1);
    var h2Len = mpv_toc_list.length;
    for (var i=0; i<h2Len; i++) {
      var mpv_toc_this      = mpv_toc_list.eq(i);
      var mpv_toc_thisText  = mpv_toc_this.clone().children('.right-link,.reader-only').remove().end().text();
      if (!(mpv_toc_this.hasClass('toc-skip'))) {
        var subMenuList = '';
        if (($.inArray(mpv_toc_thisText, mpv_toc_system) == -1) && mpv_toc_thisText) {
                    // add id attribute to h2 if none                           *
          if (!(mpv_toc_this.is('[id]'))) { mpv_toc_this.attr('id', 't1-'+mpv_toc_thisText.replace(/ /g,'-')); }
                    // add link to toc                                          *
          mpv_toc_menuList += '<li id="jumpto-'+mpv_toc_this.attr('id')+'"><a href="#'+mpv_toc_this.attr('id')+'"><span class="reader-only">Skip to </span>'+mpv_toc_thisText+'</a>';
                    // add links for tier 2 elements                            *
          if (mpv_toc_skipFirst) { mpv_toc_skipFirst = false; } else { mpv_toc_this.before(mpv_toc_returnto); }
          var mpv_toc_flList = mpv_toc_this.nextUntil(mpv_toc_tier1,mpv_toc_tier2);
          var mpv_toc_flLength = mpv_toc_flList.length;
          for (var j=0; j<mpv_toc_flLength; j++) {
                    // this will only catch siblings                            *
            var mpv_toc_flThis = mpv_toc_flList.eq(j);
            if (mpv_toc_flThis.hasClass('add-toc')) {
              var mpv_toc_flText = mpv_toc_flThis.clone().children('.right-link,.reader-only').remove().end().text();
              if (!(mpv_toc_flThis.is('[id]'))) {
                mpv_toc_flThis.attr('id', 't2-'+mpv_toc_flText.replace(/ /g,'-'));
              }
              if (!mpv_toc_skipNested) { mpv_toc_flThis.before(mpv_toc_returnto); }
              subMenuList += '<li><a href="#'+mpv_toc_flThis.attr('id')+'"><span class="reader-only">Skip to </span>'+mpv_toc_flText+'</a></li>';
            }
                    // this will catch DTs                                      *
            var mpv_toc_fl2List = mpv_toc_flThis.children('.add-toc');
            var mpv_toc_fl2Length = mpv_toc_fl2List.length;
            for (var k=0; k<mpv_toc_fl2Length; k++) {
              var mpv_toc_fl2This = mpv_toc_fl2List.eq(k);
              var mpv_toc_fl2Text = mpv_toc_fl2This.clone().children('.right-link,.reader-only').remove().end().text();
              if (!(mpv_toc_fl2This.is('[id]'))) {
                mpv_toc_fl2This.attr('id', 'dl-'+mpv_toc_fl2Text.replace(/ /g,'-'));
              }
              subMenuList += '<li><a href="#'+mpv_toc_fl2This.attr('id')+'"><span class="reader-only">Skip to </span>'+mpv_toc_fl2Text+'</a></li>';
            }
          }
                    // if submenu, nest in menu                                 *
          if (subMenuList) { subMenuList = '<ul>'+subMenuList+'</ul>'; }
          mpv_toc_menuList += subMenuList;
          mpv_toc_menuList += '</li>';
        }
      }
    }
                    // write the menu                                           *
    $('#toc-links').after('<ul id="jumpto" />');
    $('#jumpto').append(mpv_toc_menuList);
  }
});
/*! -- Copyright (c) 2017-2020 Mootly Obviate -- See /LICENSE.md -------------- */
