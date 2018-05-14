<?php
/* === Style Guide: Text and Callouts ========================================= *
 * Copyright (c) 2017-2018 Mootly Obviate - See /LICENSE.md
 * --- Revision History ------------------------------------------------------- *
 * 2018-05-09 | Copied over from test page.
 * ---------------------------------------------------------------------------- */
                    # Call config to init the application
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
# --- ↓↓↓ EDIT VARIABLES BELOW ↓↓↓ -------------------------------------------- ***
$mpo_parts->h1_title          = 'Style Guide: Text and Callouts';
$mpo_parts->link_title        = 'Text and Callouts';
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
<p>All content styles in the style should should be represented in this page for testing and for documentation.</p>

<h2 id="toc-links">Contents</h2>

<h2>Basics</h2>

<p>You can <strong>strongly</strong> emphasize things, or just <b>boldface</b> them, depending on whether semantic markup applies.</p>

<p><em>Emphasis</em>, <cite>cite</cite>, and <var>var</var> all use <i>italics</i> to callout content.</p>

<p><u>Underline</u> should only be used for links or where legal documents must appear <b>exactly</b> as formatted.</p>

<h2>Alerts</h2>

<p class="task">This is a task to remind me to do something.</p>
<p class="note">This is a helpful tip.</p>
<p class="note"><span class="title">Note:</span> This is a helpful tip with a label.</p>
<p class="warning">This is a warning.</p>
<p class="warning"><span class="title">Caution:</span> This is a warning with a label.</p>
<p class="alert-box">This is an alert box.</p>
<p class="wrong-box">This is a "wrong" box.</p>

<h2>Flags</h2>

<p class="wrong-flag">This is a paragraph flagged as wrong.</p>
<p class="right-flag">This is a paragraph flagged as right.</p>
<ul>
  <li class="wrong-flag">This is a list item flagged as wrong.</li>
  <li class="right-flag">This is a list item flagged as right.</li>
</ul>
<p class="bad-idea">This text is a bad idea. So let's not do it.</p>

<p>Text can be called out with <span class="red">red</span> or <span class="green">green</span>.</p>

<div class="pull-box-dark">
  <p>On dark background it can also be highlighted in <span class="hilite-red">red</span>, <span class="hilite-yellow">yellow</span>, or <span class="hilite-green">green</span>.</p>
</div>

<h2>Icons</h2>

<p>The following <a href="https://fontawesome.com/" target="_blank">Font Awesome</a> icons have styling applied in the default style sheet. More are listed below in the links section.</p>

<p><i class="fa fa-ban"></i> - <code>fa-ban</code></p>
<p><i class="fa fa-check"></i> - <code>fa-check</code></p>
<p><i class="fa fa-question"></i> - <code>fa-question</code></p>
<p><i class="fa fa-times"></i> - <code>fa-times</code></p>

<h3 class="aud-general">General Audience Stuff</h3>

<p>A little icon to put after the heading of a section to let people know it is general audience friendly.</p>

<h3 class="aud-technical">Technical Audience Stuff</h3>

<p>A little icon to put after the heading of a section to let people know there are technical details for technical audiences ahead. It is automatically applied to the main title of the page if the body has a class of <code>.tech-notes</code>.</p>

<h2>Boxes</h2>

<div class="pull-box-dark">
  <h4>Dark Box</h4>
  <p>A box with a dark background. <a href="#">Link in a dark box.</a></p>
</div>

<div class="pull-box">
  <h4>Light Box</h4>
  <p>A box with a light background. <a href="#">Link in a light box.</a></p>
</div>

<div class="pull-box-alt">
  <h4>Alt Box</h4>
  <p>Alternate color for light boxes. <a href="#">Link in an alt box.</a></p>
</div>

<div class="pull-box-example">
  <h4>Example Box</h4>
  <p>An example box.</p>
</div>

<h2>Code</h2>

<pre>
<span class="cc-html">&lt;p></span>Some HTML.<span class="cc-html">&lt;p></span>
JS w/ VAR tags  : <span class="cc-js">x = (<var>yourVar</var> !== null) ? <var>yourVar</var> : 'oops!'</span>
PHP w/ VAR tags : <span class="cc-php">$x = ($<var>yourVar</var> !== null) ? $<var>yourVar</var> : 'oops!'</span>
A <b>bold</b> and <em>emphatic</em> thing.
</pre>

<p>The most common use of the <code class="cc-php">ob_</code> (example: <code>ob_end_clean();</code>) control functions is to defer buffer output until a specific time.</p>

<?php
# --- ↑↑↑ EDIT CONTENT ABOVE ↑↑↑ ---------------------------------------------- ***
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
$page_elements = $mpo_parts->build_page();
echo ($twig->render($mpt_full_template, array('page'=>$page_elements['content'])));
?>