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
$mp_edit_rights     = 'CMS';
require_once( $mpo_paths->template.$mpo_parts->template.'/db_config.php' );
$mpo_404 = new ocfs_filefinder(true);
                    # Check 1 - check database -------------------------------- *
                    # if you have a database, check for a redirect record first *
if ($mpo_404->status == 'not found') {
  $t_matchedURIList = $mpo_404->try_redirects();
}
                    # no redirect in the database. Flag it.                     *
if (empty($t_matchedURIList)) { $t_updatecheck = $mpo_404->flag_brokenlink(); }
                    # Check 2 - simple name mismatch -------------------------- *
if (empty($t_matchedURIList)) {
  $t_matchedURIList = $mpo_404->try_nameMismatch('suffix spaces');
}
                    # Check 3 - check again with date wildcarding ------------- *
if (empty($t_matchedURIList)) {
  $t_matchedURIList = $mpo_404->try_nameMismatch('suffix spaces dates');
}
                    # customize our error message.                              *
switch ($mpo_404->targetCategory) {
  case 'webpage':     $t_type_message = 'a webpage';        break;
  case 'document':    $t_type_message = 'a document';       break;
  case 'pdf':         $t_type_message = 'a PDF';            break;
  case 'slideshow':   $t_type_message = 'a presentation';   break;
  case 'spreadsheet': $t_type_message = 'a spreadsheet';    break;
  case 'images':      $t_type_message = 'an image';         break;
  case 'video':       $t_type_message = 'a video';          break;
  case 'subtitles':   $t_type_message = 'a subtitle file';  break;
  default:            $t_type_message = 'anything';         break;
}

# *** BEGIN EDITABLE VALUES --------------------------------------------------- *
                    # Build the page ------------------------------------------ *
                    # Content developers shouldn't touch anything above here.
                    # ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ EDIT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                    # page_name should equal your H1 title.
$mpo_parts->h1_title          = '404: The page you requested could not be found';
$mpo_parts->link_title        = '404';
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Errors: 404';
$mpo_parts->section_base      = $mpo_parts->site_base .'/errors';
$mpo_parts->accessibility     = 'standard';
                    # The main content body of the page is developed here.
                    # It can be built from pieces or written as a block,
                    # depending on the site.
ob_start();
?>
<!-- *** BEGIN CONTENT ******************************************************** -->
<div id="contents" style="margin-bottom: 5.0em;">
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
if (in_array($mpo_404->status, ['confirm','multiple'])) { ?>
<div>

  <h2>Something's missing!</h2>

<p>We didn't find <?= $t_type_message; ?> at this address, but we did find some matches that might be what you were looking for.</p>

<ul>
<?php foreach($t_matchedURIList as $t_item) {
  if(!empty($t_item)) { ?>
  <li><a href="<?= $t_item; ?>"><?= $t_item; ?></a></li>
<?php } } ?>
</ul>

<p>Otherwise, try the <a href="/search/">search page</a> or the search bar above.</p>
</div>
<?php } /* endif */
# *** results found that need user confirmation ------------------------------- *
if (in_array($mpo_404->status, ['search','not found','no match'])) { ?>
<div>

  <h2>Something's missing!</h2>

  <p>Sorry, we didn't find <?= $t_type_message; ?> at this address.</p>

  <p>Things you can do:</p>
  <ul>
    <li>Check the address for typos.</li>
    <li>Enter a search in the search bar above.</li>
    <li>Go to the <a href="/search/">search page</a>.</li>
  </ul>
</div>
<?php } /* endif */ ?>
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
