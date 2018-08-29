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


# *** Do our search setup ----------------------------------------------------- *
  # *** URL breakout ---------------------------------------------------------- *
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
