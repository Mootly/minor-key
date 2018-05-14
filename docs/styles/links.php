<?php
/* === Style Guide: Text and Callouts ========================================= *
 * Copyright (c) 2017-2018 Mootly Obviate - See /LICENSE.md
 * --- Revision History ------------------------------------------------------- *
 * 2018-05-09 | Copied over from test page.
 * ---------------------------------------------------------------------------- */
                    # Call config to init the application
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
# --- ↓↓↓ EDIT VARIABLES BELOW ↓↓↓ -------------------------------------------- ***
$mpo_parts->h1_title          = 'Style Guide: Links &amp; Images';
$mpo_parts->link_title        = 'Links &amp; Images';
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

<h2>Links</h2>

<p>This is a <span class="fake-link">fake link</span>, for when you need to pretend.</p>
<p>This is a <a href="ocfs">real link</a>.</p>
<div class="top-link"><a href="#page-body"><span>[top]</span></a></div>
<p>Look in the right margin to see a top-link. <i class="fa fa-arrow-right muted" aria-hidden="true"></i></p>
<p>This is a link set with multiple options to choose from:<br />
  <span class="linkset">[ <a href="demo.docx">Word <span class="reader-only">document for this item</span></a> ]</span>
  <span class="linkset">[ <a href="demo.pdf">PDF<span class="reader-only">document for this item</span></a> ] [ None ]</span><br />
  It has <b>reader-only</b> content to ensure links are fully described to text readers.
</p>
<p>This a <a href="#">link with meta-information</a><span class="fileinfo"> ( Word | 25pb )</span> appended to it.</p>

<h2>Link Icons</h2>
<p>You may want to further refine the external link CSS, in case you are using full pathing in all URLS. See CSS for commented example. The <i>external link</i> icon overrides most other link type icons because it is a more specific selector.</p>
<p><a href="https://external.org">External Link</a> (begins with "http")</p>
<p><a href="ocfs/document.xls">Excel document</a> (.xls, .xlsx)</p>
<p><a href="ocfs/document.wmv">Media files</a> (.wmv, .wvx, .mov, .mpg, .mpeg, .flv, .avi, .mp4, .asx, .rm)</p>
<p><a href="ocfs/document.pdf">PDF document</a> (.pdf)</p>
<p><a href="ocfs/document.ppt">PowerPoint presentation</a> (.pps, .ppt, .pptx)</p>
<p><a href="ocfs/word.doc">Word document</a> (.rtf, .doc, .docx, .dot, .dotx)</p>
<p><a href="www.youtube.com/watch">YouTube</a></p>

<h2>Basic Image Box</h2>

<figure class="figure">
  <img src="<?= $mpo_parts->section_base ?>/_assets/images/edo-women.jpg" alt="" />
  <figcaption><span class="label">Figure 1:</span> Edo Women by Uehara Konen (1878-1940)</figcaption>
</figure>

<h2>Floated Image Box</h2>

<figure class="figure left50">
  <img src="<?= $mpo_parts->section_base ?>/_assets/images/edo-women.jpg" alt="" />
  <figcaption><span class="label">Figure 2:</span> Left half-screen float</figcaption>
</figure>

<figure class="figure right50">
  <img src="<?= $mpo_parts->section_base ?>/_assets/images/edo-women.jpg" alt="" />
  <figcaption><span class="label">Figure 3:</span> Right half-screen float</figcaption>
</figure>

<figure class="figure left30">
  <img src="<?= $mpo_parts->section_base ?>/_assets/images/edo-women.jpg" alt="" />
  <figcaption><span class="label">Figure 4:</span> Left third-screen float</figcaption>
</figure>

<figure class="figure right30">
  <img src="<?= $mpo_parts->section_base ?>/_assets/images/edo-women.jpg" alt="" />
  <figcaption><span class="label">Figure 5:</span> Right third-screen float</figcaption>
</figure>

<p>Voluptate labore excepteur magna velit officia ipsum amet tempor exercitation quis officia velit sint ex commodo. Occaecat duis nulla deserunt occaecat et velit aute. Velit consectetur anim ad elit duis dolor eiusmod commodo dolore. Proident id occaecat ullamco amet id aliquip fugiat in Lorem aute sunt sit reprehenderit et reprehenderit. Sit deserunt aliqua cillum excepteur culpa duis deserunt amet excepteur dolor minim. Magna laborum consectetur mollit enim magna commodo ut esse.</p>
<?php
# --- ↑↑↑ EDIT CONTENT ABOVE ↑↑↑ ---------------------------------------------- ***
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
$page_elements = $mpo_parts->build_page();
echo ($twig->render($mpt_full_template, array('page'=>$page_elements['content'])));
?>
