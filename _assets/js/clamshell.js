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
 * Hot key to open all  : S, F
 * Hot key to close all : H
 * ---------------------------------------------------------------------------- */
 // ONLOAD Actions ------------------------------------------------------------ *
                    // Add list item links for DL clamshells                    *
                    // The double loop is intentional.                          *
                    // Index of both loops to create reasonably unique IDs.     *
var mkv_clam_list = $('dl.clamshell, dl.example-box');
mkv_clam_list.each(function (index1) {
  $(this).children('dt').each(function (index2) {
    if (!($(this).is('[id]'))) {
      $(this).attr('id', 'dt-'+$(this).text().replace(/ /g,'-')+'-'+index1+'-'+index2);
    }
    $(this).prepend('<span class="right-link"><a class="more-link" href="#'+$(this).attr('id')+'" title="'+$(this).text()+'"><i class="fa fa-toggle-right"><span>[show details]</span></i></a></span>');
  });
});
                    // Add list item links for header-based links               *
var mkv_clam_block = $('div[class|=clamshell]');
var mkv_clam_header2Use   = mkv_clam_block.attr('class').indexOf('clamshell');
    mkv_clam_header2Use   = mkv_clam_block.attr('class').substring(mkv_clam_header2Use+10, mkv_clam_header2Use+12);
mkv_clam_block.find(mkv_clam_header2Use).each(function () {
  $(this).prepend('<span class="right-link"><a class="more-link" href="#'+$(this).attr('id')+'" title="'+$(this).text()+'"><i class="fa fa-toggle-right"><span>[show details]</span></i></a></span>');
});
                    // Add list headers and hide/show all links                 *
$(mkv_clam_list).each(function () {
  $(this).prepend('<dt class="list-header"><span class="right-link"><a class="all-link" href="#all-links" title="show all">Show All &nbsp; <i class="fa fa-list"></i></a></span> </dt>');
  if ($(this).hasClass('example-box')) {
    if ( $(this).children('dt').length > 2 ) {
      $(this).children('dt.list-header').addClass('multi');
    }
  }
});
                    // Open list item on direct link to it in URL               *
if (($(mkv_clam_list)) && (location.hash!='')) {
  var mkv_clam_target = location.hash;
                    // Hide all list items except anchored dd                   *
  mkv_clam_list.children('dd').not(mkv_clam_target).hide();
    if ($(mkv_clam_target).length) {
      $(mkv_clam_target).find('.more-link').find('i').addClass('fa fa-toggle-down').removeClass('fa-toggle-right');
      $(mkv_clam_target).find('.more-link').find('i span').text('[hide details]');
      $(mkv_clam_target).closest('dt').next('dd').toggle(500);
      if ( $(mkv_clam_target).parents('dd') ) {
        $(mkv_clam_target).parents('dd').prev().find('.more-link').find('i').addClass('fa fa-toggle-down').removeClass('fa-toggle-right');
        $(mkv_clam_target).parents('dd').prev().find('.more-link').find('i span').text('[hide details]');
        $(mkv_clam_target).parents('dd').toggle(500);
      }
      $('html, body').scrollTop($(mkv_clam_target).offset().top-50);
    }
} else {            // hide all dd's cuz no anchor in URL                       *
  if ($(mkv_clam_list)) { mkv_clam_list.children('dd').hide(); }
}
// User EVENT Actions --------------------------------------------------------- *
                    //  Open target fold for internal link                      *
$(window).on('hashchange', function(e){
  if (($(mkv_clam_list)) && (location.hash!='')) {
    var mkv_clam_target = location.hash;
    if ( $(mkv_clam_target).is(':hidden') ) {
      $(mkv_clam_target).parents('dd').show();
    }
    $(mkv_clam_target).find('a.more-link i span').text('[hide details]');
    $(mkv_clam_target).find('a.more-link i').toggleClass('fa-toggle-right fa-toggle-down');
    $(mkv_clam_target).next('dd').show(500);
  }
});
                    // Open fold on direct select                               *
$(mkv_clam_list).on('click', 'a.more-link', function(event) {
  var togType = ($(this).find('i span').text() == '[show details]') ? true : false;
  $(this).find('i span').text(togType ? '[hide details]' : '[show details]');
  $(this).find('i').toggleClass('fa-toggle-right fa-toggle-down');
  $(event.target).closest('dt').next('dd').toggle(500);
  return false;
});
                    // Open all folds on direct select                          *
$(mkv_clam_list).on('click', 'a.all-link', function(event) {
  var togType = ($(this).find('b').text() == 'Show All') ? true : false;
  $(event.target).closest('dl').children('dd').toggle(500);
  $(this).find('b').text(togType ? 'Hide All' : 'Show All');
  $(event.target).closest('dl').children('dt').find('a.more-link i span').text(togType ? '[hide details]' : '[show details]');
  $(event.target).closest('dl').children('dt').find('a.more-link i').attr('class', togType ? 'fa fa-toggle-down' : 'fa fa-toggle-right');
  return false;
});
// Assign hotkeys and bootstrap button toggle --------------------------------- *
$('#bs-vis-toggle-all').click(function(){
  if ($(this).hasClass('tog-hide')) {   // Show all                             *
    $(this).text('Hide All');
    if ($('.in')){  // Fix BS bug where it toggles elements with .in            *
      $('.in').each(function(){
        $(this).removeClass('in');
      })
    }
    $('#content .collapse').collapse('show');
    $(this).removeClass('tog-hide').addClass('tog-show');
  }
  else if ($(this).hasClass('tog-show')) { // Hide all                          *
    $(this).text('Show All');
    $('#content .collapse').collapse('hide');
    $(this).removeClass('tog-show').addClass('tog-hide');
  }
});
$(document).on('keydown', function (e) {
  if ($('dl.clamshell-list, dl.example-box, div.collapse') &&
      !($('input, textarea').is(":focus"))) {
    if ((e.ctrlKey && e.keyCode == 70 ) || (e.keyCode == 70) || (e.keyCode == 83)  ) {
      $('#content .collapse').collapse('show');
      if ($('#bs-vis-toggle-all')) { // if bs toggle button, change its state too
        $('#bs-vis-toggle-all').text('Hide All').removeClass('tog-hide').addClass('tog-show');
      }
      mkv_clam_list.find('dd').show(200);
      $('.more-link').find('i').attr('class', 'fa fa-toggle-down');
      $('.more-link').find('i span').text('[hide details]');
      mkv_clam_list.find('.all-link b').text('Hide All');
    }
    if (e.keyCode == 72) {
      $('#content .collapse').collapse('hide');
      if ($('#bs-vis-toggle-all')) { // if bs toggle button, change its state   *
        $('#bs-vis-toggle-all').text('Show All').removeClass('tog-show').addClass('tog-hide');
      }
      mkv_clam_list.find('dd').hide(200);
      $('.more-link').find('i').attr('class', 'fa fa-toggle-right');
      $('.more-link').find('i span').text('[show details]');
      mkv_clam_list.find('.all-link b').text('Show All');
    }
  }
  if (e.keyCode == 27) { $('#lightbox').fadeOut(); }
});

// CLEANUP - Scroll tweak. Must run last -------------------------------------- *
$(window).on('hashchange', function(e){
  if (location.hash!='') {
    var mkv_clam_topTarget = location.hash;
    if ($(mkv_clam_topTarget).length) { $('html, body').scrollTop($(mkv_clam_topTarget).offset().top-50); }
  }
});
/*! -- Copyright (c) 2017-2018 Mootly Obviate -- See /LICENSE.md -------------- */
