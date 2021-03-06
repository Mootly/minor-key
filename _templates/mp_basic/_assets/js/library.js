/** --------------------------------------------------------------------------- *
  * JS Libary.
  *
  * This file contains all core JS operatations for the mp_basic template.
  * @copyright 2017-2018 - Mootly Obviate
  *   MIT license - https://opensource.org/licenses/MIT
  */
  var navHasFocus = false;
  var subHasFocus = false;
$(window).on( 'load', function () {
                    // Prevent Google translate from translating elements       *
                    // that should remain as is                                 *
  $('abbr, acronym, address, cite, code, kbd, pre, samp, var').addClass('notranslate');
                    // Hamburger and tab toggles                                *
                    // Covers both mouse and keyboard entry                     *
  $('#search-control').on('click', function(e) {
    e.preventDefault();
    $('#navigation-search').toggleClass('mobile-hidden mobile-show');
    });
  $('#menu-control').on('click', function(e) {
    e.preventDefault();
    $('#header-nav-body').toggleClass('mobile-hidden mobile-show');
  });
  $('#notices-body, #header-nav-body, #navigation-search, #page-nav-body').focusin(function () {
    $(this).removeClass('mobile-hidden');
    $(this).addClass('mobile-shown');
  })
  $('#notices-body, #header-nav-body, #navigation-search, #page-nav-body').focusout(function () {
    $(this).removeClass('mobile-shown');
    $(this).addClass('mobile-hidden');
  })

  $('.page-nav').on('focusin', function (e) {
    navHasFocus=true;
    $(this).find('#page-nav-toggle').removeClass('closed');
    $(this).find('#page-nav-toggle').addClass('open');
    $(this).children('#page-nav-body').removeClass('mobile-hidden');
    $(this).children('#page-nav-body').addClass('mobile-show');
  });
  $('.page-nav').on('focusout', function (e) {
    $(this).find('#page-nav-toggle').removeClass('open');
    $(this).find('#page-nav-toggle').addClass('closed');
    $(this).children('#page-nav-body').removeClass('mobile-show');
    $(this).children('#page-nav-body').addClass('mobile-hidden');
  });
  $('#page-nav-toggle').children('a').on('click', function(e) {
    if(!navHasFocus) {
      $(this).parent().parent().find('#page-nav-body').toggleClass('mobile-hidden mobile-show');
      $(this).parent().toggleClass('open closed');
    }
    navHasFocus=false;
  });
  $('.collapse-header').on('focusin', function (e) {
    subHasFocus=true;
    $(this).removeClass('closed');
    $(this).addClass('open');
    $(this).children('.collapse-list').removeClass('hidden');
  });
  $('.collapse-header').on('focusout', function (e) {
    $(this).removeClass('open');
    $(this).addClass('closed');
    $(this).children('.collapse-list').addClass('hidden');
  });
  $('.collapse-header').children('a').on('click', function(e) {
    e.preventDefault();
    if(!subHasFocus) {
      $(this).parent().children('.page-nav-sublist').toggleClass('hidden');
      $(this).parent().toggleClass('open closed');
    }
    subHasFocus=false;
  });
                    // Flag current page in side menu                           *
                    // Strip of 'index.php' to cover default index cases        *
  var tCurrLoc = location.protocol+'//'+location.host+((location.pathname.indexOf('index.php') == -1) ? location.pathname : location.pathname.slice(0,location.pathname.indexOf('index.php')));
  $('#menu-left').find('a').each(function(){
    if ($(this).attr('href') != '#') {
      var tCurrLink = ($(this).prop('href').indexOf('index.php') == -1) ? $(this).prop('href') : $(this).prop('href').slice(0,$(this).prop('href').indexOf('index.php'));
      if (tCurrLoc == tCurrLink) {
        $(this).parent().addClass('active')
        $(this).closest('.collapse-header').removeClass('closed');
        $(this).closest('.collapse-header').addClass('open');
        $(this).closest('ul').removeClass('hidden');
      }
    }
  });

  var titlepoint = $('#title-box').waypoint({
    handler: function(direction) {
      if ($(window).width() > 800) {
        if (direction == 'down') {
          $('#title-box').addClass('fixed-top');
          $('#sidebar-left').addClass('fixed-above');
          $('#content-main').addClass('fixed-above');
          $('.fixed-above').css('margin-top', $('#title-box').outerHeight());
        } else if (direction == 'up') {
          $('#title-box').removeClass('fixed-top');
          $('.fixed-above').removeAttr('style');
          $('#sidebar-left').removeClass('fixed-above');
          $('#content-main').removeClass('fixed-above');
        }
      } else {
        $('#title-box').removeClass('fixed-top');
        $('.fixed-above').removeAttr('style');
        $('#sidebar-left').removeClass('fixed-above');
        $('#content-main').removeClass('fixed-above');
      }

    },
    continuous: false // on jump, only trigger last event                         ***
  });
});
