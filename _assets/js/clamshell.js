/* --- Clamshell creator ------------------------------------------------------ *
 * Clamshell / accordion fold any:
 *  - DL with a class of 'clamshell-list'
 *  - DL with a class of 'example-box'
 *  - Headings of type H# in a DIV with a class of 'clamshell' and 'use-h#'
 *  - Folded items: DD and any blockwith class of 'clamfold'
 * Tasks:
 *  - Collapse all targeted elements
 *  - Add controls for each targeted item
 *  - Add open all control  to the top of each list
 *  - If URL.has(#target) open that item, scroll to item
 * Assumptions:
 * - Not fully tested for more than two levels of nesting
 * - Collapser immediately follows its heading
 * - Same heading level is used for folds across page
 * - Uses Font Awesone
 * - Generates the following classes (arrows denote nesting):
 *   .list-header > .right-link > .all-link|.morelink
 *   .hidden
 * ---------------------------------------------------------------------------- */
var icon_list_all   = 'fa-list';
var icon_is_closed  = 'fa-toggle-right';
var icon_is_open    = 'fa-toggle-down';
var hidden_class    = 'hidden';
                    // Determine what we are collapsing.                        ***
var mpv_clam_class  = 'dl.clamshell, dl.example-box, div.clamshell';
var mpv_clam_list   = $(mpv_clam_class);
var mpv_clam_fold   = 'dd, .clamfold';
var mpv_clam_head   = 'dt';
                    // If using DIVs, find out what we are using for headings   ***
var mpv_clam_block  = $('div.clamshell');
if (mpv_clam_block.length > 0) {
  var mpv_tvar      = mpv_clam_block.attr('class').indexOf('use-');
      mpv_clam_head = mpv_clam_head+', '
      + mpv_clam_block.attr('class').substring(mpv_tvar+4, mpv_tvar+6);
}
/* --- EVENT Actions - user and synthetic ------------------------------------- */
                    //  Open target fold                                        ***
$(window).on('hashchange', function(e){
  if (($(mpv_clam_list)) && (location.hash!='')) {
    var mpv_clam_target = location.hash;
    if ($(mpv_clam_target).length) {
      $(mpv_clam_target).find('.more-link').find('i').addClass('fa '+icon_is_open).removeClass(icon_is_closed);
      $(mpv_clam_target).find('.more-link').find('i span').text('[hide details]');
      $(mpv_clam_target).closest(mpv_clam_head).next(mpv_clam_fold).toggleClass(hidden_class);
      if ( $(mpv_clam_target).parents(mpv_clam_fold) ) {
        $(mpv_clam_target).parents(mpv_clam_fold).prev().find('.more-link').find('i').addClass('fa '+icon_is_open).removeClass(icon_is_closed).find('span').text('[hide details]');
        $(mpv_clam_target).parents(mpv_clam_fold).toggleClass(hidden_class);
      }
                    // Set page position
      $('html, body').scrollTop($(mpv_clam_target).offset().top-50);
    }
  }
});
                    // Open fold on direct select                               ***
$(mpv_clam_list).on('click', '.item-toggle, item-toggle a.more-link', function(event) {
  var tTogType      = ($(this).find('i span').text() == '[show details]') ? true : false;
  $(this).find('i span').text(tTogType ? '[hide details]' : '[show details]');
  $(this).find('i').toggleClass(icon_is_closed+' '+icon_is_open);
  $(event.target).closest(mpv_clam_head).next(mpv_clam_fold).toggleClass(hidden_class);
  return false;
});
                    // Open all folds on direct select                          ***

$(mpv_clam_list).on('click', 'a.all-link', function(event) {
  var tTogType = ($(this).find('span').text() == 'Show All') ? true : false;
  if (tTogType) {
    $(event.target).closest(mpv_clam_class).children(mpv_clam_fold).removeClass(hidden_class);
  } else {
    $(event.target).closest(mpv_clam_class).children(mpv_clam_fold).addClass(hidden_class);
  }
  $(this).find('span').text(tTogType ? 'Hide All' : 'Show All');
  $(event.target).closest(mpv_clam_class).children(mpv_clam_head).find('a.more-link i span').text(tTogType ? '[hide details]' : '[show details]');
  $(event.target).closest(mpv_clam_class).children(mpv_clam_head).find('a.more-link i').attr('class', tTogType ? 'fa '+icon_is_open : 'fa '+icon_is_closed);
  return false;
});
/* --- ONLOAD Actions --------------------------------------------------------- */
                    // Add fold toggle links.                                   ***
                    // Generate IDs if none provided (loops append counters).   ***
mpv_clam_list.each(function (index1) {
  $(this).children(mpv_clam_head).each(function (index2) {
    $(this).addClass('item-toggle')
    if (!($(this).is('[id]'))) {
      $(this).attr('id', 'tog-'+$(this).text().replace(/ /g,'-')+'-'+index1+'-'+index2);
    }
    $(this).prepend('<span class="right-link"><a class="more-link" href="#'
    + $(this).attr('id')+'" title="'+$(this).text()+'"><i class="fa '
    + icon_is_closed+'"><span>[show details]</span></i></a></span>');
  });
});
                    // Add list headers and hide/show all links                 ***
$(mpv_clam_list).each(function () {
  if ($(this).children(mpv_clam_head).length > 1) {
    if ($(this).children(mpv_clam_head).first().is('dt')) {
      $(this).prepend('<dt class="list-header"><span class="right-link">'
      + '<a class="all-link" href="#all-links" title="show all">'
      + '<span>Show All</span> &nbsp; <i class="fa fa-list"></i></a>'
      + '</span></dt>');
    } else {
      $(this).prepend('<div class="list-header"><span class="right-link">'
      + '<a class="all-link" href="#all-links" title="show all">'
      + '<span>Show All</span> &nbsp; <i class="fa fa-list"></i></a>'
      + '</span></div>');
    }
  }
  $(this).children(mpv_clam_fold).addClass(hidden_class);
});
                    // Open list item on direct link to it in URL               ***
if (($(mpv_clam_list)) && (location.hash!='')) { $(window).trigger('hashchange'); }
/*! -- Copyright (c) 2017-2018 Mootly Obviate -- See /LICENSE.md -------------- */
