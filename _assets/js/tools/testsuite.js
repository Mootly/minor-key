$(window).scroll(function () {
  tvH = Math.round($('#title-box').offset().top - $(document).scrollTop());
  tvAlt = Math.round($('#page-header').offset().top - $(document).scrollTop() + $('#page-header').height());
  $('div#posTest').text(tvH + ' - ' + tvAlt);
});
