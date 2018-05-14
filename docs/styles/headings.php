<?php
/* === Style Guide: Text and Callouts ========================================= *
 * Copyright (c) 2017-2018 Mootly Obviate - See /LICENSE.md
 * --- Revision History ------------------------------------------------------- *
 * 2018-05-09 | Copied over from test page.
 * ---------------------------------------------------------------------------- */
                    # Call config to init the application
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
# --- ↓↓↓ EDIT VARIABLES BELOW ↓↓↓ -------------------------------------------- ***
$mpo_parts->h1_title          = 'Style Guide: Headings';
$mpo_parts->link_title        = 'Headings';
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

<h2 class="section">Stacked Headings</h2>

<h1>Stacked H1</h1>
<h2 class="toc-skip">Stacked H2</h2>
<h3>Stacked H3</h3>
<h4>Stacked H4</h4>
<h5>Stacked H5</h5>
<h6>Stacked H6</h6>

<h2 class="section">Inline Headings</h2>

<h1>Inline H1</h1>
<p>First Paragraph. Aliqua eiusmod sunt ullamco minim consequat duis ad ipsum cupidatat est dolore do occaecat. Officia dolore anim ut sit consequat mollit est esse proident veniam velit. Labore non tempor ipsum officia commodo et aute mollit aute cillum ex sit excepteur occaecat reprehenderit nisi.</p>
<p>Subsequent paragraphs. Et elit sint officia mollit officia anim sit ipsum eiusmod elit.</p>

<h2 class="toc-skip">Inline H2</h2>
<p>Ea consequat aliqua in proident nisi fugiat ipsum sint adipisicing laboris deserunt et tempor et magna magna nostrud.</p>

<h3>Inline H3</h3>
<p>Irure velit laborum non culpa sint est ullamco elit qui incididunt id nulla ut pariatur est ea.</p>

<h4>Inline H4</h4>
<p>Nisi pariatur enim ullamco in aute dolore aliqua proident.</p>

<h5>Inline H5</h5>
<p>Aute culpa duis tempor nulla incididunt aliquip duis eu veniam qui.</p>

<h6>Inline H6</h6>
<p>Sit non veniam ex ex exercitation reprehenderit aute ullamco proident et velit.</p>
<?php
# --- ↑↑↑ EDIT CONTENT ABOVE ↑↑↑ ---------------------------------------------- ***
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
$page_elements = $mpo_parts->build_page();
echo ($twig->render($mpt_full_template, array('page'=>$page_elements['content'])));
?>
