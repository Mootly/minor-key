/** --------------------------------------------------------------------------- *
 * Page content menu generator.                                                 *
 *                                                                              *
 * This routine automates the table of contents for jump links internal to      *
 * the current page.                                                            *
 * It uses IDs and ignores any embedded anchors.                                *
 * A menu is inserted after element with id="toc-links":                        *
 *   Exmaple: <h2 id="toc-links">Contents</h2>                                  *
 * The menu includes all tier1 elements in the document.                        *
 * If a tier1 element does not have an ID, it assigns one.                      *
 * Checks for the class 'add-toc" to include tier2 elements.                    *
 * Assumes tier2 elements are siblings of tier1 elements,                       *
 * so it might miss things with complicated nesting.                            *
 * ---------------------------------------------------------------------------- */
$(window).on( 'load', function () {
  if ($('#toc-links').length) {
    var menuList = '';
                    // TOC starts with this heagding                            ***
    var tier1 = 'h2';
                    // To catch DTs, specify parent DL                          ***
    var tier2 = 'h3, dl';
                    // don't include headings with this text in them            ***
    var tocSystem = ['Status', 'Warning', 'Quick Links', 'Contents', 'Internal Notes'];
                    // generate an array of all H2 headings                     ***
    var tocList = $('#content-main').find(tier1);
    var h2Len = tocList.length;
    for (var i=0; i<h2Len; i++) {
      var tocThis      = tocList.eq(i);
      var tocThisText  = tocThis.text();
      var subMenuList = '';
      if (($.inArray(tocThisText, tocSystem) == -1) && tocThisText) {
                    // add id attribute to h2 if none                           ***
        if (!(tocThis.is('[id]'))) { tocThis.attr('id', 't1-'+tocThisText.replace(/ /g,'-')); }
                    // add link to toc                                          ***
        menuList += '<li id="jumpto-'+tocThis.attr('id')+'"><a href="#'+tocThis.attr('id')+'">'+tocThisText+'</a>';
                    // add links for tier 2 elements                            ***
        var flList = tocThis.nextUntil(tier1,tier2);
        var flLength = flList.length;
        for (var j=0; j<flLength; j++) {
                    // this will only catch siblings                            ***
          var flThis = flList.eq(j);
          if (flThis.hasClass('add-toc')) {
            if (!(flThis.is('[id]'))) {
              flThis.attr('id', 't2-'+flThis.text().replace(/ /g,'-'));
            }
            subMenuList += '<li><a href="#'+flThis.attr('id')+'">'+flThis.text()+'</a></li>';
          }
                    // this will catch DTs                                      ***
          var fl2List = flThis.children('.add-toc');
          var fl2Length = fl2List.length;
          for (var k=0; k<fl2Length; k++) {
            var fl2This = fl2List.eq(k);
            if (!(fl2This.is('[id]'))) {
              fl2This.attr('id', 'dl-'+fl2This.text().replace(/ /g,'-'));
            }
            subMenuList += '<li><a href="#'+fl2This.attr('id')+'">'+fl2This.text()+'</a></li>';
          }
        }
                    // if submenu, nest in menu                                 ***
        if (subMenuList) { subMenuList = '<ul>'+subMenuList+'</ul>'; }
        menuList += subMenuList;
        menuList += '</li>';
      }
    }
                    // write the menu                                           ***
    $('#toc-links').after('<ul id="jumpto" />');
    $('#jumpto').append(menuList);
  }
});
