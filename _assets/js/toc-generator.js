/** -- Page content menu generator -------------------------------------------- *
 * This routine automates the table of contents for jump links internal to
 * the current page.
 * Tasks:
 * - A menu is inserted after element with id="toc-links":
 *   Exmaple: <h2 id="toc-links">Contents</h2>
 * - The menu includes all tier 1 elements (var: mkc_toc_tier1).
 * - Checks for '.add-toc" to include tier 2 elements (var: mkc_toc_tier2).
 * - If a listed element does not have an ID, it assigns one.
 * Assumptions:
 * - Only uses IDs and ignores embedded anchors.
 * - Only checks for targets in div#content-main.
 * - Tier 2 elements are siblings of tier 1 elements.
 * - If DL is listed for tier 2, targets child DT elements.
 * ---------------------------------------------------------------------------- */
$(window).on( 'load', function () {
  if ($('#toc-links').length) {
    var mkv_toc_menuList  = '';
                    // TOC starts with this heagding                            *
    var mkv_toc_tier1     = 'h2';
                    // To catch DTs, specify parent DL                          *
    var mkv_toc_tier2     = 'h3, dl';
                    // Varaibles to generate links back to the top of the page  *
                    // If no body ID, go to TOC.                                *
                    // skipfirst  == true ? skip link on first heading          *
                    // skipnested == true ? only add links to top level headings*
    if (typeof skipfirst  == 'undefined') { var skipfirst  = true; }
    if (typeof skipnested == 'undefined') { var skipnested = true; }
    var mkv_toc_topID     = ($('body').is('[id]')) ? $('body').attr('id') : 'toc-link' ;
    var mkv_toc_returnto  = '<div class="top-link"><a href="#'+mkv_toc_topID+'"><span>[top]</span></a></div>';
                    // don't include headings with this text in them            *
    var mkv_toc_system = ['Status', 'Warning', 'Quick Links', 'Contents', 'Internal Notes'];
                    // generate an array of all H2 headings                     *
    var mkv_toc_list = $('#content-main').find(mkv_toc_tier1);
    var h2Len = mkv_toc_list.length;
    for (var i=0; i<h2Len; i++) {
      var mkv_toc_this      = mkv_toc_list.eq(i);
      var mkv_toc_thisText  = mkv_toc_this.text();
      var subMenuList = '';
      if (($.inArray(mkv_toc_thisText, mkv_toc_system) == -1) && mkv_toc_thisText) {
                    // add id attribute to h2 if none                           *
        if (!(mkv_toc_this.is('[id]'))) { mkv_toc_this.attr('id', 't1-'+mkv_toc_thisText.replace(/ /g,'-')); }
                    // add link to toc                                          *
        mkv_toc_menuList += '<li id="jumpto-'+mkv_toc_this.attr('id')+'"><a href="#'+mkv_toc_this.attr('id')+'">'+mkv_toc_thisText+'</a>';
                    // add links for tier 2 elements                            *
        if (skipfirst) { skipfirst = false; } else { mkv_toc_this.before(mkv_toc_returnto); }
        var mkv_toc_flList = mkv_toc_this.nextUntil(mkv_toc_tier1,mkv_toc_tier2);
        var mkv_toc_flLength = mkv_toc_flList.length;
        for (var j=0; j<mkv_toc_flLength; j++) {
                    // this will only catch siblings                            *
          var mkv_toc_flThis = mkv_toc_flList.eq(j);
          if (mkv_toc_flThis.hasClass('add-toc')) {
            if (!(mkv_toc_flThis.is('[id]'))) {
              mkv_toc_flThis.attr('id', 't2-'+mkv_toc_flThis.text().replace(/ /g,'-'));
            }
            if (!skipnested) { mkv_toc_flThis.before(mkv_toc_returnto); }
            subMenuList += '<li><a href="#'+mkv_toc_flThis.attr('id')+'">'+mkv_toc_flThis.text()+'</a></li>';
          }
                    // this will catch DTs                                      *
          var mkv_toc_fl2List = mkv_toc_flThis.children('.add-toc');
          var mkv_toc_fl2Length = mkv_toc_fl2List.length;
          for (var k=0; k<mkv_toc_fl2Length; k++) {
            var mkv_toc_fl2This = mkv_toc_fl2List.eq(k);
            if (!(mkv_toc_fl2This.is('[id]'))) {
              mkv_toc_fl2This.attr('id', 'dl-'+mkv_toc_fl2This.text().replace(/ /g,'-'));
            }
            subMenuList += '<li><a href="#'+mkv_toc_fl2This.attr('id')+'">'+mkv_toc_fl2This.text()+'</a></li>';
          }
        }
                    // if submenu, nest in menu                                 *
        if (subMenuList) { subMenuList = '<ul>'+subMenuList+'</ul>'; }
        mkv_toc_menuList += subMenuList;
        mkv_toc_menuList += '</li>';
      }
    }
                    // write the menu                                           *
    $('#toc-links').after('<ul id="jumpto" />');
    $('#jumpto').append(mkv_toc_menuList);
  }
});
/*! -- Copyright (c) 2017-2018 Mootly Obviate -- See /LICENSE.md -------------- */
