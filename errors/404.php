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
$mpv_findStatus     = 'not found';
                    # if some clever hacker is looking for the 404 page         *
                    # let them know they found it                               *
if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) { $mpv_findStatus = '404 success'; }
                    # allow file types to search for                            *
                    # broken out for readability                                *
                    # this was built while migrating a site off .Net            *
                    # you may want to extend this list if doing the same        *
$mpv_validExt                 = array();
$mpv_validExt['webpage']      = 'asp,aspx,cfm,htm,html,php';
$mpv_validExt['document']     = 'doc,docx,dot,dotx,pdf,rtf';
$mpv_validExt['slideshow']    = 'pps,ppt,pptx';
$mpv_validExt['spreadsheet']  = 'xls,xlsx';
$mpv_validExt['images']       = 'jpg,jpeg,gif,png,svg';
$mpv_validExt['movie']        = 'avi,asx,flv,mov,mp4,mpg,mpeg,rm,wmv,wvx';
$mpv_validExt['subtitles']    = 'sbv,srt,sub,vtt';
$mpv_validExtString           = implode(',',$mpv_validExt);
                    # grab what we are looking for                              *
$mpv_requestedURI   = $_SERVER['REQUEST_URI'];
$mpv_queryString    = $_SERVER['QUERY_STRING'];

// ADD TEST FOR THESE STEPS
                    # returns array: 0 - error code, 1 - url                    *
                    # only return two in case there are semicolons in url       *
$mpv_qsArray        = explode( ';', $mpv_queryString, 2 );
                    # returns array: scheme, host, port, path                   *
$mpv_urlArray       = parse_url($mpv_qsArray[1]);
                    # returns array: dirname, basename, extension, filename     *
$mpv_pathArray      = pathinfo($mpv_urlArray['path']);
$mpv_pathArray['dirname'] = ltrim($mpv_pathArray['dirname'],'\\');
                    # searching for                                             *
$mpv_targetPath     = $mpv_pathArray['dirname'].MP_PSEP.$mpv_pathArray['filename'];
# *** our first test - did they just get the extension wrong? ----------------- *
                    # check directory for file matches with allowed suffixes    *
                    # special cases for URLs with no file and for index files   *
if (($mpv_pathArray['filename'] == 'default') || ($mpv_pathArray['filename'] == 'index')) {
  $mpv_globTargetPath = ltrim($mpv_pathArray['dirname'], '/').MP_PSEP.'{default,index}';
} elseif ($mpv_pathArray['filename'] == $mpv_pathArray['basename']) {
  $mpv_globTargetPath = ltrim($mpv_targetPath, '/').MP_PSEP.'{default,index}';
} else {
  $mpv_globTargetPath = ltrim($mpv_targetPath, '/');
}
$mpv_globPath       = MP_ROOT.$mpv_globTargetPath.'.{'.$mpv_validExtString.'}';
$mpv_resultset      = glob ( $mpv_globPath, GLOB_BRACE );
if (count($mpv_resultset) == 0) {       # still not found
  $mpv_findStatus   = 'search';
} elseif (count($mpv_resultset) == 1) { # only one match, redirect to it
  $mpv_findStatus   = 'success';
  $mpv_redirectPath = str_replace(MP_ROOT,'',$mpv_resultset[0]);
  header('Location: '.MP_PSEP.$mpv_redirectPath);
} else {                                # multi-matches
  $mpv_findStatus   = 'multiple';
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
<pre>
$mpv_redirectPath: <?php var_dump($mpv_redirectPath); ?>
*****
$mpv_qsArray: <?php var_dump($mpv_qsArray); ?>
*****
$mpv_urlArray: <?php var_dump($mpv_urlArray); ?>
*****
$mpv_pathArray: <?php var_dump($mpv_pathArray); ?>
*****
$mpv_targetPath: <?php var_dump($mpv_targetPath); ?>
*****
$mpv_globPath: <?php var_dump($mpv_globPath); ?>
*****
$mpv_resultset: <?php var_dump($mpv_resultset); ?>
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
