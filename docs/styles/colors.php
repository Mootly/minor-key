<?php
/* === Style Guide: Colors ==================================================== *
 * Copyright (c) 2017-2020 Mootly Obviate - See /LICENSE.md
 * --- Revision History ------------------------------------------------------- *
 * 2018-05-09 | Copied over from test page.
 * ---------------------------------------------------------------------------- */
                    # Call config to init the application
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
                    # Build the page ------------------------------------------ *
                    # Content developers shouldn't touch anything above here.
                    # ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ EDIT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                    # page_name should equal your H1 title.
$mpo_parts->h1_title          = 'Template Colors';
$mpo_parts->link_title        = 'Template Colors';
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Docs : Style Guide';
$mpo_parts->section_base      = $mpo_paths->docs;
$mpo_parts->pagemenu          = 'import';
$mpo_parts->bodyclasses       = 'final';
                    # import page components that are not generated by template.
ob_start();
require_once( MP_ROOT.'/docs/_assets/includes/menu.docs.php' );
$mpo_parts->page_menu = ob_get_clean();
ob_end_clean();
require_once( $mpo_paths->php_widgets.'/menus/simple_crumbs.php' );
                    # The main content body of the page is developed here.
                    # It can be built from pieces or written as a block,
                    # depending on the site.
ob_start();
?>
<!-- *** BEGIN CONTENT ******************************************************** -->
<style type="text/css">
                    /* custom styling for color swatch table                    */
table.list-table td.color-swatch {
  background: linear-gradient(to right, #ffffff 0%,#ffffff 50%,#000000 50%,#000000 100%);
  padding: 0.25em 0; width: 6.0em;
}
td.color-swatch span {
  display: block; height: 5.0em; width: 5.0em; border-radius: 2.5em; margin: auto;
}
</style>

<p>The last column contains the variables as called in the CSS as well as sample swatches for color blends.
<h2 id="toc-links">Contents</h2>

<!-- *** PURPLES *** ********************************************************** -->
<h2>Purples</h2>

<table class="list-table" title="Color swatches of template purples">
  <thead>
    <tr>
      <th scope="col">Swatch</th>
      <th scope="col">RGB</th>
      <th scope="col">Hex</th>
      <th scope="col">Name</th>
      <th scope="col">Called Variables</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="color-swatch"><span style="background-color: rgb(112,61,116);"> </span></td>
      <td>rgb(112,61,116)</td>
      <td>#703d74</td>
      <td>$c-base-plum</td>
      <td>
        <ul>
          <li>$c-code-hilite-1</li>
          <li>$c-tip-border</li>
        </ul>
      </td>
    </tr>
    <tr>
      <td class="color-swatch"><span style="background-color: rgb(99,68,100);"> </span></td>
      <td>rgb(99,68,100)</td>
      <td>#644564</td>
      <td>$c-base-flatplum</td>
      <td>
        <ul>
          <li>$c-banner-bg</li>
          <li>$c-base-flatplum</li>
          <li>$c-plum-border</li>
          <li>$c-link-icons</li>
          <li>$c-visited-text</li>
          <li>$c-subbanner-hilite</li>
          <li style="color:#fcf8fb; background-color:#825a82;">$c-button-active-bg <br />lighten($c-base-flatplum, 10)</li>
        </ul>
      </td>
    </tr>
  </tbody>
</table>

<!-- *** end contents ********************************************************* -->
<?php
                    # ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ EDIT ABOVE ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
                    # Content developers shouldn't touch anything below here.
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
                    // Submit to template generator --------------------------- *
mpf_renderPage($mpo_parts->template.$mpt_['default'].$mpt_['suffix'], $mpo_parts);
?>
