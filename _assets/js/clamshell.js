/** -- Clamshell creator ------------------------------------------------------ *
 * Clamshell / accordion fold any:
 *  - DL with a class of 'clamshell-list'
 *  - DL with a class of 'example-box'
 *  - Headings of type H(n) in a DIV with a class of 'clamshell_h(n)'
 * Tasks:
 *  - Collapse all targeted elements
 *  - Add controls for each targeted item
 *  - Add open all control  to the top of each list
 *  - If URL.has(#target) open that item, scroll to item
 * Assumptions:
 * - Currently only written for two levels of nested elements
 * - Uses Font Awesone
 * - Uses the following classes (arrows denote nesting):
 *   .right-link > .all-link|.morelink
 *   .hidden
 * ---------------------------------------------------------------------------- */
var icon_list_all  = 'fa-list';
var icon_is_closed = 'fa-toggle-right';
var icon_is_open   = 'fa-toggle-down';
var hidden_class   = 'hidden';
// ONLOAD Actions ------------------------------------------------------------- *
                    // Add list item links for DL clamshells                    *
                    // The double loop is intentional.                          *
                    // Index of both loops to create reasonably unique IDs.     *
var mkv_clam_list = $('dl.clamshell, dl.example-box');
mkv_clam_list.each(function (index1) {
  $(this).children('dt').each(function (index2) {
    if (!($(this).is('[id]'))) {
      $(this).attr('id', 'dt-'+$(this).text().replace(/ /g,'-')+'-'+index1+'-'+index2);
    }
    $(this).prepend('<span class="right-link"><a class="more-link" href="#'+$(this).attr('id')+'" title="'+$(this).text()+'"><i class="fa '+icon_is_closed+'"><span>[show details]</span></i></a></span>');
  });
});
                    // Add list item links for header-based links               *
var mkv_clam_block = $('div[class|=clamshell]');
if (mkv_clam_block.length > 0) {
  var mkv_clam_header2Use   = mkv_clam_block.attr('class').indexOf('clamshell');
  mkv_clam_header2Use   = mkv_clam_block.attr('class').substring(mkv_clam_header2Use+10, mkv_clam_header2Use+12);
  mkv_clam_block.find(mkv_clam_header2Use).each(function () {
    $(this).prepend('<span class="right-link"><a class="more-link" href="#'+$(this).attr('id')+'" title="'+$(this).text()+'"><i class="fa '+icon_is_closed+'"><span>[show details]</span></i></a></span>');
  });
}
                    // Add list headers and hide/show all links                 *
$(mkv_clam_list).each(function () {
  $(this).prepend('<dt class="list-header"><span class="right-link"><a class="all-link" href="#all-links" title="show all"><span>Show All</span> &nbsp; <i class="fa fa-list"></i></a></span> </dt>');
  // if ($(this).hasClass('example-box')) {  // this may be legacy code
  //   if ( $(this).children('dt').length > 2 ) {
  //     $(this).children('dt.list-header').addClass('multi');
  //   }
  // }
});
                    // Open list item on direct link to it in URL               *
if (($(mkv_clam_list)) && (location.hash!='')) {
  var mkv_clam_target = location.hash;
                    // Hide all list items except anchored dd                   *
  mkv_clam_list.children('dd').not(mkv_clam_target).addClass(hidden_class);
    if ($(mkv_clam_target).length) {
      $(mkv_clam_target).find('.more-link').find('i').addClass('fa '+icon_is_open).removeClass(icon_is_closed);
      $(mkv_clam_target).find('.more-link').find('i span').text('[hide details]');
      $(mkv_clam_target).closest('dt').next('dd').toggleClass(hidden_class);
      if ( $(mkv_clam_target).parents('dd') ) {
        $(mkv_clam_target).parents('dd').prev().find('.more-link').find('i').addClass('fa '+icon_is_open).removeClass(icon_is_closed);
        $(mkv_clam_target).parents('dd').prev().find('.more-link').find('i span').text('[hide details]');
        $(mkv_clam_target).parents('dd').toggleClass(hidden_class);
      }
      $('html, body').scrollTop($(mkv_clam_target).offset().top-50);
    }
} else {            // hide all dd's cuz no anchor in URL                       *
  if ($(mkv_clam_list)) { mkv_clam_list.children('dd').addClass(hidden_class); }
}
// User EVENT Actions --------------------------------------------------------- *
                    //  Open target fold for internal link                      *
$(window).on('hashchange', function(e){
  if (($(mkv_clam_list)) && (location.hash!='')) {
    var mkv_clam_target = location.hash;
    if ( $(mkv_clam_target).is(':hidden') ) {
      $(mkv_clam_target).parents('dd').removeClass(hidden_class);
    }
    $(mkv_clam_target).find('a.more-link i span').text('[hide details]');
    $(mkv_clam_target).find('a.more-link i').toggleClass(icon_is_closed+' '+icon_is_open);
    $(mkv_clam_target).next('dd').toggleClass(hidden_class);
  }
});
                    // Open fold on direct select                               *
$(mkv_clam_list).on('click', 'a.more-link', function(event) {
  var togType = ($(this).find('i span').text() == '[show details]') ? true : false;
  $(this).find('i span').text(togType ? '[hide details]' : '[show details]');
  $(this).find('i').toggleClass(icon_is_closed+' '+icon_is_open);
  $(event.target).closest('dt').next('dd').toggleClass(hidden_class);
  return false;
});
                    // Open all folds on direct select                          *
$(mkv_clam_list).on('click', 'a.all-link', function(event) {
  var togType = ($(this).find('span').text() == 'Show All') ? true : false;
  if (togType) {
    $(event.target).closest('dl').children('dd').removeClass(hidden_class);
  } else {
    $(event.target).closest('dl').children('dd').addClass(hidden_class);
  }
  $(this).find('span').text(togType ? 'Hide All' : 'Show All');
  $(event.target).closest('dl').children('dt').find('a.more-link i span').text(togType ? '[hide details]' : '[show details]');
  $(event.target).closest('dl').children('dt').find('a.more-link i').attr('class', togType ? 'fa '+icon_is_open : 'fa '+icon_is_closed);
  return false;
});

// CLEANUP - Scroll tweak. Must run last -------------------------------------- *
$(window).on('hashchange', function(e){
  if (location.hash!='') {
    var mkv_clam_topTarget = location.hash;
    if ($(mkv_clam_topTarget).length) { $('html, body').scrollTop($(mkv_clam_topTarget).offset().top-50); }
  }
});
/*! -- Copyright (c) 2017-2018 Mootly Obviate -- See /LICENSE.md -------------- */
