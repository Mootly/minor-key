<?php
/* === Developer Notes ======================================================== *
 * Copyright (c) 2017-2018 Mootly Obviate - See /LICENSE.md
 * --- Revision History ------------------------------------------------------- *
 * 2018-08-23 | Created page.
 * ---------------------------------------------------------------------------- */
                    # Call config to init the application --------------------- *
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
                    # Build the page ------------------------------------------ *
                    # Content developers shouldn't touch anything above here.
# *** Do our search setup ----------------------------------------------------- *
$mpv_404_status     = 'not found';
                    # if some clever hacker is looking for the 404 page         *
                    # let them know they found it                               *
if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) {
  $mpv_404_redirect_status    = '404 success';
} else {
                    # allow file types to search for                            *
                    # broken out for readability                                *
                    # this was built while migrating a site off .Net            *
                    # you may want to extend this list if doing the same        *
  $mpv_404_vExt               = array();
  $mpv_404_vExt['webpage']    = 'asp,aspx,cfm,htm,html,php';
  $mpv_404_vExt['document']   = 'doc,docx,dot,dotx,rtf';        # odt,ott,
  $mpv_404_vExt['pdf']        = 'pdf';
  $mpv_404_vExt['slideshow']  = 'pps,ppt,pptx';                 # odp,odt,
  $mpv_404_vExt['spreadsheet']= 'xls,xlsm,xlsx,xlt,xltm,xltx';  # ods,ots,
  $mpv_404_vExt['images']     = 'jpg,jpeg,gif,png,svg';
  $mpv_404_vExt['movie']      = 'avi,mov,mp4,mpg,mpeg,wmv';     # asx,flv,wvx,
  $mpv_404_vExt['subtitles']  = 'sbv,srt,sub,vtt';
  $mpv_404_vExtString         = implode(',',$mpv_404_vExt);
  # *** URL breakout ---------------------------------------------------------- *
  # break out the URL in steps so all values are easily available               *
                    # Order of operations:                                      *
                    # - 2 - try $_SERVER['REQUEST_URI']                         *
                    # - 3 - if both empty, redirect to root                     *
                    # - 1 - try $_SERVER['QUERY_STRING']                        *
  if (empty($_SERVER['QUERY_STRING'])) {
    if (empty($_SERVER['REQUEST_URI'])) {
      $mpv_404_reqURI = parse_url($_SERVER['REQUEST_URI']);
    } else {
                    # *** REDIRECT to homepage -------------------------------- #
      header('Location: '.MP_PSEP.$mpo_parts->site_base);                       #
                    # *** REDIRECT to homepage -------------------------------- #
    }
  } else {
                    # return array of query string components                   *
                    #   0 - error code, 1 - url                                 *
                    # only return two in case there are semicolons in url       *
    $mpv_404_qsArr                      = explode( ';', $_SERVER['QUERY_STRING'], 2 );
                    # return array of URL components                            *
                    #   scheme, host, port, path                                *
    $mpv_404_reqURI                     = parse_url($mpv_404_qsArr[1]);
  }
                    # return array of filename components                       *
                    # dirname, basename, extension, filename                    *
  $mpv_404_pathArr                      = pathinfo($mpv_404_reqURI['path']);
  $mpv_404_pathArr['dirname']           = ltrim($mpv_404_pathArr['dirname'],'\\');
                    # get the category of our file extension                    *
                    # directory, invalid, one of the $mpv_404_vExt keys         *
  if ($mpv_404_pathArr['extension'] == '') {
    $mpv_404_pathArr['src_cat']         = 'directory';
  } else {
    $mpv_404_pathArr['src_cat']         = preg_grep(
      '/(^|\W)'.$mpv_404_pathArr['extension'].'($|\W)/',
      $mpv_404_vExt
    );
    if (is_array($mpv_404_pathArr['src_cat'])) {
      reset($mpv_404_pathArr['src_cat']);
      $mpv_404_pathArr['src_cat']       = key($mpv_404_pathArr['src_cat']);
    } else {
      $mpv_404_pathArr['src_cat']       = 'invalid';
    }
  }
                    # our base search string                                    *
  $mpv_404_tPath    = $mpv_404_pathArr['dirname'].MP_PSEP.$mpv_404_pathArr['filename'];
# *** TEST ONE - did they just get the extension wrong? ----------------------- *
                    # build filename set to look for                            *
                    # special case for index files                              *
  if (($mpv_404_pathArr['filename'] == 'default') || ($mpv_404_pathArr['filename'] == 'index')) {
    $mpv_404_globTarget = ltrim($mpv_404_pathArr['dirname'], '/').MP_PSEP.'{default,index}';
  } else {
    $mpv_404_globTarget = ltrim($mpv_404_tPath, '/');
  }
                    # check directory for file matches with allowed suffixes    *
  $mpv_404_globPath = MP_ROOT.$mpv_404_globTarget.'.{'.$mpv_404_vExtString.'}';
  $mpv_404_results  = glob ( $mpv_404_globPath, GLOB_BRACE );
                    # review our results                             *
  if (!$mpv_404_results || (count($mpv_404_results) == 0 )) {   # still not found
    $mpv_404_status = 'search';
  } elseif (count($mpv_404_results) == 1) {                   # only one match
    $mpv_404_status = 'success';
    $mpv_404_redPath= str_replace(MP_ROOT,'',$mpv_404_results[0]);
                    # *** REDIRECT to found page ------------------------------ #
    header('Location: '.MP_PSEP.$mpv_404_redPath);                              #
                    # *** REDIRECT to found page ------------------------------ #
  } else {                                                  # multi-matches
    $mpv_404_status = 'multiple';
  }
}
# *** our second test - check database for redirect --------------------------- *
                    # if not success, check the database                        *

# *** BEGIN EDITABLE VALUES --------------------------------------------------- *
                    # ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ EDIT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                    # page_name should equal your H1 title.
$mpo_parts->h1_title          = '404: The page you requested could not be found';
$mpo_parts->link_title        = '404';
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Errors';
$mpo_parts->section_base      = $mpo_parts->site_base .'/errors';
$mpo_parts->accessibility     = 'standard';
                    # The main content body of the page is developed here.
                    # It can be built from pieces or written as a block,
                    # depending on the site.
ob_start();
?>
<!-- *** BEGIN CONTENT ******************************************************** -->
<div id="contents">
<?php if ($mpv_404_status == '404 success') {
  $mpo_parts->h1_title          = '404: The page you requested is this one';
?>
<div class="center">
<h2>Congratulations!</h2>

<h3>You have found the 404 page!</h3>

<p>No idea why people would want to intentionally look at a 404 page, but here it is.</p>

<p>If this is not what you were looking for, try the <a href="/search/">search page</a> or the search bar above.</p>
</div>
<?php } /* endif */ ?>
<pre>
$mpv_404_redPath: <?php var_dump($mpv_404_redPath); ?>
*****
$mpv_404_qsArr: <?php var_dump($mpv_404_qaArr); ?>
*****
$mpv_404_reqURI: <?php var_dump($mpv_404_reqURI); ?>
*****
$mpv_404_pathArr: <?php var_dump($mpv_404_pathArr); ?>
*****
$mpv_404_tPath: <?php var_dump($mpv_404_tPath); ?>
*****
$mpv_404_globPath: <?php var_dump($mpv_404_globPath); ?>
*****
$mpv_404_results: <?php var_dump($mpv_404_results); ?>
*****
$_SESSION: <?php var_dump($_SESSION); ?>
</pre>
</div>
<!-- *** END CONTENT ********************************************************** -->
<?php
                    # ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ EDIT ABOVE ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
                    # Content developers shouldn't touch anything below here.
                    # Invoke the template ------------------------------------- *
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
$page_elements = $mpo_parts->build_page();
echo ($twig->render($mpo_parts->template.$mpt_form_template, array('page'=>$page_elements['content'])));
?>
