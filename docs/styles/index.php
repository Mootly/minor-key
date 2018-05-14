<?php
/* === Style Guide: Text and Callouts ========================================= *
 * Copyright (c) 2017-2018 Mootly Obviate - See /LICENSE.md
 * --- Revision History ------------------------------------------------------- *
 * 2018-05-09 | Copied over from test page.
 * ---------------------------------------------------------------------------- */
                    # Call config to init the application
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
# --- ↓↓↓ EDIT VARIABLES BELOW ↓↓↓ -------------------------------------------- ***
$mpo_parts->h1_title          = 'Style Guide';
$mpo_parts->link_title        = 'Style Guide';
                    # page_name should equal your H1 title.
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Documentation';
$mpo_parts->section_base      = '/docs';
$mpo_parts->accessibility     = 'standard';
$mpo_parts->pagemenu          = 'docs';
$mpo_parts->bodyclasses       = 'final';
$page_path                    = $mpo_parts->page_path;
require_once( $mpo_paths->php_widgets.'/menus/simple_crumbs.php' );
ob_start();
# --- ↓↓↓ EDIT CONTENT BELOW ↓↓↓ ---------------------------------------------- ***
                    # The main content body of the page is developed here.
                    # It can be built from pieces or written as a block,
                    # depending on the site.
?>
<h3>What's Here</h3>

<table class="list-table">
  <thead>
    <tr>
      <th>Page</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th colspan="2">Style Guide</th>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/callouts.php">Text Elements &amp; Callouts</a></td>
      <td>Text, text styling, and callouts.</td>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/links.php">Links &amp; Images</a></td>
      <td>Link, images, and other embedded content</td>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/lists.php">Lists</a></td>
      <td>Lists.</td>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/tables.php">Tables</a></td>
      <td>The different tables currently available.</td>
    </tr>
  </tbody>
</table>
<?php
# --- ↑↑↑ EDIT CONTENT ABOVE ↑↑↑ ---------------------------------------------- ***
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
$page_elements = $mpo_parts->build_page();
echo ($twig->render($mpt_full_template, array('page'=>$page_elements['content'])));
?>