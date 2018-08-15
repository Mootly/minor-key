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
 * ---------------------------------------------------------------------------- ***/
$(window).on( 'load', function () {
  if ($('#toc-links').length) {
    $('#toc-links').show();
    var mpv_toc_menuList  = '';
                    // TOC starts with this heagding                            ***
    var mpv_toc_tier1     = 'h2';
                    // To catch DTs, specify parent DL                          ***
    var mpv_toc_tier2     = 'h3, dl';
                    // Comma separated list of content section IDs to use       ***
    var mpv_toc_container = '#content-main, #right_content';
                    // Varaibles to generate links back to the top of the page  ***
                    // If no body ID, go to TOC.                                ***
                    // skipfirst  == true ? skip link on first heading          ***
                    // skipnested == true ? only add links to top level headings***
    if (typeof skipfirst  == 'undefined') { var skipfirst  = true; }
    if (typeof skipnested == 'undefined') { var skipnested = true; }
    var mpv_toc_topID     = ($('body').is('[id]')) ? $('body').attr('id') : 'toc-link' ;
    var mpv_toc_returnto  = '<div class="top-link"><a href="#'+mpv_toc_topID+'"><span>[top]</span></a></div>';
                    // don't include headings with this text in them            ***
    var mpv_toc_system = ['Status', 'Warning', 'Quick Links', 'Contents', 'Internal Notes'];
                    // generate an array of all H2 headings                     ***
    var mpv_toc_list = $(mpv_toc_container).find(mpv_toc_tier1);
    var h2Len = mpv_toc_list.length;
    for (var i=0; i<h2Len; i++) {
      var mpv_toc_this      = mpv_toc_list.eq(i);
      var mpv_toc_thisText  = mpv_toc_this.text();
      if (!(mpv_toc_this.hasClass('toc-skip'))) {
        var subMenuList = '';
        if (($.inArray(mpv_toc_thisText, mpv_toc_system) == -1) && mpv_toc_thisText) {
                    // add id attribute to h2 if none                           ***
          if (!(mpv_toc_this.is('[id]'))) { mpv_toc_this.attr('id', 't1-'+mpv_toc_thisText.replace(/ /g,'-')); }
                    // add link to toc                                          ***
          mpv_toc_menuList += '<li id="jumpto-'+mpv_toc_this.attr('id')+'"><a href="#'+mpv_toc_this.attr('id')+'">'+mpv_toc_thisText+'</a>';
                    // add links for tier 2 elements                            ***
          if (skipfirst) { skipfirst = false; } else { mpv_toc_this.before(mpv_toc_returnto); }
          var mpv_toc_flList = mpv_toc_this.nextUntil(mpv_toc_tier1,mpv_toc_tier2);
          var mpv_toc_flLength = mpv_toc_flList.length;
          for (var j=0; j<mpv_toc_flLength; j++) {
                    // this will only catch siblings                            ***
            var mpv_toc_flThis = mpv_toc_flList.eq(j);
            if (mpv_toc_flThis.hasClass('add-toc')) {
              if (!(mpv_toc_flThis.is('[id]'))) {
                mpv_toc_flThis.attr('id', 't2-'+mpv_toc_flThis.text().replace(/ /g,'-'));
              }
              if (!skipnested) { mpv_toc_flThis.before(mpv_toc_returnto); }
              subMenuList += '<li><a href="#'+mpv_toc_flThis.attr('id')+'">'+mpv_toc_flThis.text()+'</a></li>';
            }
                    // this will catch DTs                                      ***
            var mpv_toc_fl2List = mpv_toc_flThis.children('.add-toc');
            var mpv_toc_fl2Length = mpv_toc_fl2List.length;
            for (var k=0; k<mpv_toc_fl2Length; k++) {
              var mpv_toc_fl2This = mpv_toc_fl2List.eq(k);
              if (!(mpv_toc_fl2This.is('[id]'))) {
                mpv_toc_fl2This.attr('id', 'dl-'+mpv_toc_fl2This.text().replace(/ /g,'-'));
              }
              subMenuList += '<li><a href="#'+mpv_toc_fl2This.attr('id')+'">'+mpv_toc_fl2This.text()+'</a></li>';
            }
          }
                    // if submenu, nest in menu                                 ***
          if (subMenuList) { subMenuList = '<ul>'+subMenuList+'</ul>'; }
          mpv_toc_menuList += subMenuList;
          mpv_toc_menuList += '</li>';
        }
      }
    }
                    // write the menu                                           ***
    $('#toc-links').after('<ul id="jumpto" />');
    $('#jumpto').append(mpv_toc_menuList);
  }
});
/*! -- Copyright (c) 2017-2018 Mootly Obviate -- See /LICENSE.md -------------- */
