<?php
/* === Style Guide: Text and Callouts ========================================= *
 * Copyright (c) 2017-2018 Mootly Obviate - See /LICENSE.md
 * --- Revision History ------------------------------------------------------- *
 * 2018-05-09 | Copied over from test page.
 * ---------------------------------------------------------------------------- */
                    # Call config to init the application
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
# --- ↓↓↓ EDIT VARIABLES BELOW ↓↓↓ -------------------------------------------- ***
$mpo_parts->h1_title          = 'Style Guide: Tables';
$mpo_parts->link_title        = 'Tables';
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
<h2 id="toc-links">Contents</h2>

<h2>Unformatted Tables</h2>

<p class="warning">All tables should use a class to style them. The following two tables should appear unformatted (with default table styling).</p>

<h3>Plain</h3>
<table>
  <tr>
    <td>Unadorned</td>
    <td>Table</td>
  </tr>
  <tr>
    <td>Not</td>
    <td>Formatted</td>
  </tr>
</table>

<h3>With THEAD and TFOOT</h3>

<table>
  <caption>A caption about this table.</cpation>
  <thead>
    <tr>
      <th>Unadorned</th>
      <th>Header</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>Unadorned</th>
      <th>Footer</th>
    </tr>
  </tfoot>
  <tbody>
    <tr>
      <td>Unadorned</td>
      <td>Table</td>
    </tr>
    <tr>
      <td>Lorem Ipsum</td>
      <td>Labore irure sint et aliquip labore ipsum deserunt elit cillum quis aute anim Lorem duis id amet.</td>
    </tr>
  </tbody>
</table>

<h2>Accounting table (<code>.list-table .accounting</code>)</h2>

<table class="list-table accounting">
    <thead>
      <tr> <th>Thing</th>   <th>Received</th></tr>
    </thead>
    <tbody>
      <tr><td>Thing 1</td>  <td>$120,792,000</td></tr>
      <tr><td>Thing 2</td>	<td>28,198,100</td></tr>
      <tr><td>Thing 3</td>  <td>28,814,700</td></tr>
    </tbody>
    <tfoot class="totals">
      <tr><td>Total</td>    <td>$177,804,800</td></tr>
    </tfoot>
  </table>

<h2>Directory table (<code>.directory-table</code>)</h2>

<p>The directory table is a faux table for listing facilities and offices. To better support changes in screen size, it uses divisions and spans to emulate a three column layout. It will accept headings of h3-h5 for the section headings, and h4-h6 for the facility/office title.</p>

<div class="directory-table deep">
  <h3 class="listing-head">Deep Listing</h3>
  <div class="listing">
    <p class="secure">Secure</p>
    <h4 class="name">Facility name</h4>
    <p class="description">Facility description</p>
    <p class="address">Address</p>
    <p class="contact">
      <span class="label-runin">Contact:</span>
      Dana Demo &ndash; (718) 555-5555
      <br />
      <span class="label-runin">Operating Agency:</span>
      Sheltering Demo Page
      <br />
      <span class="label-runin">Administering Agency/County:</span>
      Federal Agency of Examples
    </p>
  </div>
</div>
<div class="directory-table">
  <h3 class="listing-head">Simple Listing</h3>
  <div class="listing">
    <h4 class="name">Simple listing</h4>
    <p class="contact">
      <span class="label-runin">Contact:</span>
      Dana Demo &ndash; (718) 555-5555
    </p>
  </div>
</div>


<h2>List table (<code>.list-table</code>)</h2>

<table class="list-table">
  <caption><span class="title">Label:</span> A caption about this table.</cpation>
  <thead>
    <tr>
      <th>Header</th>
      <th>Header</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <td>Footer</td>
      <td>Section</td>
    </tr>
  </tfoot>
  <tbody>
    <tr>
      <td>First</td>
      <td>Body</td>
    </tr>
    <tr>
      <td>Lorem Ipsum</td>
      <td>Labore irure sint et aliquip labore ipsum deserunt elit cillum quis aute anim Lorem duis id amet.</td>
    </tr>
  </tbody>
  <tbody>
    <tr>
      <td>Second</td>
      <td>Body</td>
    </tr>
    <tr>
      <td>Second</td>
      <td>Body</td>
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
