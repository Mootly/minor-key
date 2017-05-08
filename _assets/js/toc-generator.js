/** --------------------------------------------------------------------------- *
 * Page content menu generator.                                                 *
 *                                                                              *
 * This routine automates the table of contents for jump links internal to      *
 * the current page.                                                            *
 * It uses IDs and ignores any embedded anchors.                                *
 * A menu is inserted after an H2 with id="toc-links":                          *
 *   <h2 id="toc-links">Contents</h2>                                           *
 * The menu includes all H2 elements in the document.                           *
 * If an H2 element does not have an ID, it assigns one.                        *
 * Checks for the class 'freq-link" to include H3 and DT elements.              *
 * Assumes H3 and DL tags are siblings of the H2 tags.                          *
 * ---------------------------------------------------------------------------- */
$(window).on( 'load', function () {
  if ($('#toc-links').length) {
    var menuList = '';
                    // don't include headings with this text in them            ***
    var h2System = ['Status message', 'Warning message', 'Quick links', 'Contents', 'Search form', 'Internal notes'];
                    // generate an array of all H2 headings                     ***
    var h2List = $('#contents').find('h2');
    var h2Len = h2List.length;
    for (var i=0; i<h2Len; i++) {
      var h2This      = h2List.eq(i);
      var h2ThisText  = h2This.text();
      var subMenuList = '';
      if ((jQuery.inArray(h2ThisText, h2System) == -1) && h2ThisText) {
                    // add id attribute to h2 if none                           ***
        if (!(h2This.is('[id]'))) { h2This.attr('id', 'h2-'+h2ThisText.replace(/ /g,'-')); }
                    // add link to toc                                          ***
        menuList += '<li id="jumpto-'+h2This.attr('id')+'"><a href="#'+h2This.attr('id')+'">'+h2ThisText+'</a>';
                    // add links for h3 + dt elements                           ***
        var flList = h2This.nextUntil('h2','h3, dl');
        var flLength = flList.length;
        for (var j=0; j<flLength; j++) {
                    // this will only catch H3s                                 ***
          var flThis = flList.eq(j);
          if (flThis.hasClass('freq-link')) {
            if (!(flThis.is('[id]'))) {
              flThis.attr('id', 'h3-'+flThis.text().replace(/ /g,'-'));
            }
            subMenuList += '<li><a href="#'+flThis.attr('id')+'">'+flThis.text()+'</a></li>';
          }
                    // this will catch DTs                                      ***
          var fl2List = flThis.children('.freq-link');
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
