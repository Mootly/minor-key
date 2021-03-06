<?php
/* === Developer Notes - Code Organization ==================================== *
 * Copyright (c) 2017-2020 Mootly Obviate - See /LICENSE.md
 * --- Revision History ------------------------------------------------------- *
 * 2019-05-29 | Added pathing for widget and assets.
 * 2018-05-09 | Copied over from test page.
 * ---------------------------------------------------------------------------- */
                    # Call config to init the application
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
                    # Build the page ------------------------------------------ *
                    # Content developers shouldn't touch anything above here.
                    # ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ EDIT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                    # page_name should equal your H1 title.
$mpo_parts->h1_title          = 'Code Organization';
$mpo_parts->link_title        = 'Code Organization';
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Docs : CMS Dev Notes';
$mpo_parts->section_base      = $mpo_paths->docs;
$mpo_parts->bodyclasses       = 'final tech-notes';
$mpo_parts->pagemenu          = 'import';
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
<p>These are the basic rules set out for writing code for this application.</p>

<p>The standards are kept pretty loose, but should be adhered to.</p>

<h2 id="toc-links">Contents</h2>

<h2 class="add-toc">Component separation and processing order</h2>

<p>All core code has been written with the unidirectional flow described below. You can iterate, but not move backwards.</p>

<p>Direction of flow is enforced by encapsulation and an expectation that a particular data set or type of object will be passed each step of the way. Core files will include the following strings to indicate what part of the process they are involved with.</p>

<p>Request evaluation and computation:</p>
<dl class="inline-terms">
  <dt id="dfn-process-init">init</dt><dd>Initialize core.</dd>
  <dt id="dfn-process-grab">grab</dt><dd>Retrieve requests and accompanying data.</dd>
  <dt id="dfn-process-proc">proc</dt><dd>Process request data and gather response data.</dd>
</dl>

<p>Response assembly and presentation:</p>
<dl class="inline-terms">
  <dt id="dfn-process-prep">prep</dt><dd>Use the template to prepare response for presentation</dd>
  <dt id="dfn-process-send">send</dt><dd>Send response</dd>
</dl>

<h2 class="add-toc">Template widgets v. content widgets</h2>

<p>These paths all reside in <code>/_templates/<var>[template name]</var></code>.</p>

<table class="list-table">
  <thead>
    <tr>
      <th>Path</th>
      <th>Example content</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>/_assets/images/</code> </td>
      <td>Site-wide image assets.</td>
    </tr>
    <tr>
      <td><code>/_assets/includes/</code> </td>
      <td>Widgets and assets included through the templates. They should all be <code>.twig</code> files.</td>
    </tr>
    <tr>
      <td><code>/_assets/js/</code> </td>
      <td>Site-wide javascript assets.</td>
    </tr>
    <tr>
      <td>
        <code>/_assets/php_widgets/</code>
      </td>
      <td>Site-wide widgets to include in page content. These should <strong>not</strong> be imported through the template.</td>
    </tr>
    <tr>
      <td>
        <code>/_assets/widgets/</code>
      </td>
      <td>Site-wide fragements to include in page content. These should <strong>not</strong> be imported through the template.</td>
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
