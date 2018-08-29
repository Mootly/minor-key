<?php
/* === Developer Notes ======================================================== *
 * Copyright (c) 2017-2018 Mootly Obviate - See /LICENSE.md
 * --- Revision History ------------------------------------------------------- *
 * 2018-08-23 | Created page.
 * ---------------------------------------------------------------------------- *
 * Result flag values ($mpv_404_status):
 * Process states (script should not end on these):
 * - not found      - default state: nothing found
 * - search         - no simple file matches, check database
 * - mistmatch      - unexpected match found, check database
 * Final states
 * - 404 success    - 404 page successfully found
 * - confirm        - unexpected match not resolved, ask user to confirm
 * - mutliple       - multiple matches found, ask for confirmation
 * - no match       - refer user to search page
 * - success        - success - redirect
 * ---------------------------------------------------------------------------- */
                    # Call config to init the application --------------------- *
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
$mpo_404 = new mpc_filefinder();
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
                    # Build the page ------------------------------------------ *
                    # Content developers shouldn't touch anything above here.
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
<?php
# *** 404 for when users try to go to 404 page -------------------------------- *
if ($mpv_404_status == '404 success') {
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
$mpo_404->status: <?php var_dump($mpo_404->status); ?>
$mpo_404->targetURI: <?php var_dump($mpo_404->targetURI); ?>
$mpo_404->targetPath: <?php var_dump($mpo_404->targetPath); ?>
$mpo_404->targetCategory: <?php var_dump($mpo_404->targetCategory); ?>
$_SERVER['QUERY_STRING']: <?php var_dump($_SERVER['QUERY_STRING']); ?>
$_SERVER['REQUEST_URI']: <?php var_dump($_SERVER['REQUEST_URI']); ?>
$_SERVER: <?php var_dump($_SERVER); ?>
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
