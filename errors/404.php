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
$mpo_404 = new mpc_filefinder(false);
if ($mpo_404->status == 'not found') {
  $t_matchedURIList = $mpo_404->try_extensionMismatch();
}

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
if ($mpo_404->status == '404 success') {
  $mpo_parts->h1_title          = '404: The page you requested is this one.';
?>
<div>
<h2>Congratulations!</h2>

<h3>You have found the 404 page!</h3>

<p>No idea why people would want to intentionally look at a 404 page, but here it is.</p>

<p>If this is not what you were looking for, try the <a href="/search/">search page</a> or the search bar above.</p>
</div>
<?php } /* endif */
# *** 404 for when users the redirect page can't find its target -------------- *
if ($mpo_404->status == 'no search') { ?>
<div>
<h2>No redirect information found.</h2>

<p>You have hit a redirect page without any information on where to be redirected.</p>

<p>Try the <a href="/search/">search page</a> or the search bar above.</p>
</div>
<?php } /* endif */
# *** results found that need user confirmation ------------------------------- *
if (($mpo_404->status == 'confirm') || ($mpo_404->status == 'multiple')) { ?>
<div>

  <h2>Not Found</h2>

<p>We didn't find anything at that address, but we did find some matches that might be what you were looking for.</p>

<ul>
<?php foreach($t_matchedURIList as $t_item) {
  if(!empty($t_item)) { ?>
  <li><a href="<?= $t_item; ?>"><?= $t_item; ?></a></li>
<?php } } ?>
</ul>

<p>Otherwise, try the <a href="/search/">search page</a> or the search bar above.</p>
</div>
<?php } /* endif */ ?>
<pre>
$mpo_404->status: <?php var_dump($mpo_404->status); ?>
$mpo_404->targetURI: <?php var_dump($mpo_404->getTarget('url')); ?>
$mpo_404->targetPath: <?php var_dump($mpo_404->getTarget('path')); ?>
$mpo_404->targetCategory: <?php var_dump($mpo_404->targetCategory); ?>
$mpo_404->getMatches(): <?php var_dump($mpo_404->getMatches()); ?>
$_SERVER['QUERY_STRING']: <?php var_dump($_SERVER['QUERY_STRING']); ?>
$_SERVER['REQUEST_URI']: <?php var_dump($_SERVER['REQUEST_URI']); ?>
$_SERVER['PHP_SELF']: <?php var_dump($_SERVER['PHP_SELF']); ?>
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
