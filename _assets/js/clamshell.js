/** --------------------------------------------------------------------------- *
  * Clamshell creator.
  *
  * This accordion folds:
  *  - Any DL with a class of 'clamshell-list'
  *  - The comments form at the bottom of the page
  * All elements are collapsed and accordion links added.
  * An open all link added to the top of each list.
  * If the URL has a hash for a list item that item is opened and the page shifted
  * to the top of the list item.
  * Toggles manage individual list items or list as a whole.
  * Hot key to open: S or F.
  * Hot key to close: H.
  */
                    // ONLOAD: Add list item links for DL clamshells
                    // The double loop is intentional.
                    // We are tracking the index of both loops to create
                    // reasonably unique IDs.
var clamshellList = $('dl.clamshell, dl.example-box'); 
clamshellList.each(function (index1) {
  $(this).children('dt').each(function (index2) {
    if (!($(this).is('[id]'))) {
      $(this).attr('id', 'dt-'+$(this).text().replace(/ /g,'-')+'-'+index1+'-'+index2);
    }
//    if (!($(this).children('span.right-link'))) {
      $(this).prepend('<span class="right-link"><a class="more-link" href="#'+$(this).attr('id')+'" title="'+$(this).text()+'"><i class="fa fa-toggle-right"><span>[show details]</span></i></a></span>');
//    }
  });
});
                    // Add list item links for header-based links
// var clamshellBlock = $('div[class|=clamshell]');
// var headerToUse   = clamshellBlock.attr('class').indexOf('clamshell');
//     headerToUse   = clamshellBlock.attr('class').substring(headerToUse+10, headerToUse+12);
// clamshellBlock.find(headerToUse).each(function () {
//   $(this).prepend('<span class="right-link"><a class="more-link" href="#'+$(this).attr('id')+'" title="'+$(this).text()+'"><i class="fa fa-toggle-right"><span>[show details]</span></i></a></span>');
// });

                    // ONLOAD: Add list headers and hide/show all links
$(clamshellList).each(function () {
  $(this).prepend('<dt class="list-header"><span class="right-link"><a class="all-link" href="#all-links" title="show all">Show All &nbsp; <i class="fa fa-list"></i></a></span> </dt>');
  if ($(this).hasClass('example-box')) {
    if ( $(this).children('dt').length > 2 ) {
      $(this).children('dt.list-header').addClass('multi');
    }
  }
});

                    // ONLOAD: open list item on direct link to it in URL
if (($(clamshellList)) && (location.hash!='')) {
  var clamshellTarget = location.hash;
  // LOAD: hide all list items except anchored dd
  clamshellList.children('dd').not(clamshellTarget).hide();
    if ($(clamshellTarget).length) {
      $(clamshellTarget).find('.more-link').find('i').addClass('fa fa-toggle-down').removeClass('fa-toggle-right');
      $(clamshellTarget).find('.more-link').find('i span').text('[hide details]');
      $(clamshellTarget).closest('dt').next('dd').toggle(500);
      if ( $(clamshellTarget).parents('dd') ) {
        $(clamshellTarget).parents('dd').prev().find('.more-link').find('i').addClass('fa fa-toggle-down').removeClass('fa-toggle-right');
        $(clamshellTarget).parents('dd').prev().find('.more-link').find('i span').text('[hide details]');
        $(clamshellTarget).parents('dd').toggle(500);
      }
      $('html, body').scrollTop($(clamshellTarget).offset().top-50);
    }
} else {            // ONLOAD: hide all dd's cuz no anchor in URL
  if ($(clamshellList)) { clamshellList.children('dd').hide(); }
}

                    // EVENT: open target fold for internal link
$(window).on('hashchange', function(e){
  if (($(clamshellList)) && (location.hash!='')) {
    var clamshellTarget = location.hash;
    if ( $(clamshellTarget).is(':hidden') ) {
      $(clamshellTarget).parents('dd').show();
    }
    $(clamshellTarget).find('a.more-link i span').text('[hide details]');
    $(clamshellTarget).find('a.more-link i').toggleClass('fa-toggle-right fa-toggle-down');
    $(clamshellTarget).next('dd').show(500);
  }
});

                    // EVENT: open fold on direct select
$(clamshellList).on('click', 'a.more-link', function(event) {
  var togType = ($(this).find('i span').text() == '[show details]') ? true : false;
  $(this).find('i span').text(togType ? '[hide details]' : '[show details]');
  $(this).find('i').toggleClass('fa-toggle-right fa-toggle-down');
  $(event.target).closest('dt').next('dd').toggle(500);
  return false;
});

                    // EVENT: open all folds on direct select
$(clamshellList).on('click', 'a.all-link', function(event) {
  var togType = ($(this).find('b').text() == 'Show All') ? true : false;
  $(event.target).closest('dl').children('dd').toggle(500);
  $(this).find('b').text(togType ? 'Hide All' : 'Show All');
  $(event.target).closest('dl').children('dt').find('a.more-link i span').text(togType ? '[hide details]' : '[show details]');
  $(event.target).closest('dl').children('dt').find('a.more-link i').attr('class', togType ? 'fa fa-toggle-down' : 'fa fa-toggle-right');
  return false;
});

// Assign hotkeys and bootstrap button toggle --------------------------------- *
$('#bs-vis-toggle-all').click(function(){
  if ($(this).hasClass('tog-hide')) {   // to show all
    $(this).text('Hide All');
    if ($('.in')){  // Fix BS bug where it toggles elements with .in
      $('.in').each(function(){
        $(this).removeClass('in');
      })
    }
    $('#content .collapse').collapse('show');
    $(this).removeClass('tog-hide').addClass('tog-show');
  }
  else if ($(this).hasClass('tog-show')) { // to hide all
    $(this).text('Show All');
    $('#content .collapse').collapse('hide');
    $(this).removeClass('tog-show').addClass('tog-hide');
  }
});
jQuery(document).on('keydown', function (e) {
  if ($('dl.clamshell-list, dl.example-box, div.collapse') && !($('input, textarea').is(":focus"))) {
    if ((e.ctrlKey && e.keyCode == 70 ) || (e.keyCode == 70) || (e.keyCode == 83)  ) {
      $('#content .collapse').collapse('show');
      if ($('#bs-vis-toggle-all')) { // if bs toggle button, change its state too
        $('#bs-vis-toggle-all').text('Hide All').removeClass('tog-hide').addClass('tog-show');
      }
      clamshellList.find('dd').show(200);
      $('.more-link').find('i').attr('class', 'fa fa-toggle-down');
      $('.more-link').find('i span').text('[hide details]');
      clamshellList.find('.all-link b').text('Hide All');
    }
    if (e.keyCode == 72) {
      $('#content .collapse').collapse('hide');
      if ($('#bs-vis-toggle-all')) { // if bs toggle button, change its state too
        $('#bs-vis-toggle-all').text('Show All').removeClass('tog-show').addClass('tog-hide');
      }
      clamshellList.find('dd').hide(200);
      $('.more-link').find('i').attr('class', 'fa fa-toggle-right');
      $('.more-link').find('i span').text('[show details]');
      clamshellList.find('.all-link b').text('Show All');
    }
  }
  if (e.keyCode == 27) { $('#lightbox').fadeOut(); }
});

// CLEANUP - Scroll tweak. Should run last ------------------------------------ *
$(window).on('hashchange', function(e){
  if (location.hash!='') {
    var topTarget = location.hash;
    if ($(topTarget).length) { $('html, body').scrollTop($(topTarget).offset().top-50); }
  }
});
