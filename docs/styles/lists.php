<?php
/* === Style Guide: Text and Callouts ========================================= *
 * Copyright (c) 2017-2018 Mootly Obviate - See /LICENSE.md
 * --- Revision History ------------------------------------------------------- *
 * 2018-05-09 | Copied over from test page.
 * ---------------------------------------------------------------------------- */
                    # Call config to init the application
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
# --- ↓↓↓ EDIT VARIABLES BELOW ↓↓↓ -------------------------------------------- ***
$mpo_parts->h1_title          = 'Style Guide: Lists';
$mpo_parts->link_title        = 'Lists';
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

<h2>Basic Lists</h2>

<p>Laboris reprehenderit deserunt aliquip aliqua dolore in ad dolore sint quis dolor aliquip occaecat in proident esse. Commodo ad non aliqua culpa tempor est ex.</p>
<ul>
  <li>List following a pragraph.</li>
  <li>Consectetur minim amet aliqua qui adipisicing Lorem consectetur pariatur qui eiusmod. Pariatur sunt ipsum sint voluptate cillum consequat mollit ullamco aliquip laborum nulla proident dolore.</li>
  <li>Item 3</li>
  <li>Item 4</li>
</ul>
<p>Paragraph following a list. Dolor occaecat veniam voluptate in Lorem aliquip laboris. Lorem deserunt laboris quis esse ipsum dolore in do est veniam dolore excepteur.</p>

<p>Always do the following:</p>
<ol>
  <li>Stop</li>
  <li>Look</li>
  <li>Listen</li>
  <li value="99">Listen some more</li>
  <li value="999">Keep listening</li>
</ol>

<h2>Nesting Lists</h2>

<ul>
  <li>Item 1
    <ul>
      <li>Item 1</li>
      <li>Item 2
        <ol>
          <li>Item 1</li>
          <li>Item 2</li>
          <li>Item 3</li>
        </ol>
      </li>
      <li>Item 3</li>
    </ul>
</li>
  <li>Item 2</li>
  <li>Item 3</li>
</ul>

<ol>
  <li>Item 1
    <ol>
      <li>Item 1</li>
      <li>Item 2
        <ul>
          <li>Item 1</li>
          <li>Item 2</li>
          <li>Item 3</li>
        </ul>
      </li>
      <li>Item 3</li>
    </ol>
</li>
  <li>Item 2</li>
  <li>Item 3</li>
</ol>

<h2>Fake Lists</h2>

<p>The fake list item uses span tags for when you want to toss a list item in the middle of a paragraph for reasons of visual clarity.</p>
<p>
  To get the whatchagizzy working properly, please change
  <span class="fake-li">thignamabomb</span>
  to its correct spelling of
  <span class="fake-li">thingamabob.</span>
</p>

<h2>Definition Lists</h2>

<h3>Basic DL</h3>

<dl>
  <dt>Some term</dt>
  <dd>
    <p>With paragraph tag. Duis enim commodo sint qui commodo eu consequat aliqua consectetur mollit anim. Reprehenderit consectetur amet magna veniam exercitation ut laborum velit elit velit proident sint ut eiusmod commodo. Reprehenderit et esse pariatur quis eiusmod amet deserunt laboris.</p>
    <p>Laborum dolore sit non tempor qui laboris excepteur aliquip incididunt velit velit excepteur qui ad nulla elit.</p>
  </dd>
  <dt>Some other term</dt>
  <dd> No paragraph tag. Duis enim commodo sint qui commodo eu consequat aliqua consectetur mollit anim. Reprehenderit consectetur amet magna veniam exercitation ut laborum velit elit velit proident sint ut eiusmod commodo. Reprehenderit et esse pariatur quis eiusmod amet deserunt laboris.</dd>
</dl>

<h3>Inline DL (<code>.inline-terms</code>)</h3>

<dl class="inline-terms">
  <dt>Some term</dt>
  <dd>
    <p>With paragraph tag. Duis enim commodo sint qui commodo eu consequat aliqua consectetur mollit anim. Reprehenderit consectetur amet magna veniam exercitation ut laborum velit elit velit proident sint ut eiusmod commodo. Reprehenderit et esse pariatur quis eiusmod amet deserunt laboris.</p>
    <p>Laborum dolore sit non tempor qui laboris excepteur aliquip incididunt velit velit excepteur qui ad nulla elit.</p>
</dd>
  <dt>Some other term</dt>
  <dd> No paragraph tag. Duis enim commodo sint qui commodo eu consequat aliqua consectetur mollit anim. Reprehenderit consectetur amet magna veniam exercitation ut laborum velit elit velit proident sint ut eiusmod commodo. Reprehenderit et esse pariatur quis eiusmod amet deserunt laboris.</dd>
</dl>

<h2>Clamshell Lists</h2>

<h3>Clamshell DL (<code>.clamshell</code>)</h3>

<dl class="clamshell">
  <dt>Some term</dt>
  <dd>
    <p>With paragraph tag. Duis enim commodo sint qui commodo eu consequat aliqua consectetur mollit anim. Reprehenderit consectetur amet magna veniam exercitation ut laborum velit elit velit proident sint ut eiusmod commodo. Reprehenderit et esse pariatur quis eiusmod amet deserunt laboris.</p>
    <p>Laborum dolore sit non tempor qui laboris excepteur aliquip incididunt velit velit excepteur qui ad nulla elit.</p>
</dd>
  <dt>Some other term</dt>
  <dd> No paragraph tag. Duis enim commodo sint qui commodo eu consequat aliqua consectetur mollit anim. Reprehenderit consectetur amet magna veniam exercitation ut laborum velit elit velit proident sint ut eiusmod commodo. Reprehenderit et esse pariatur quis eiusmod amet deserunt laboris.</dd>
</dl>

<h3>Clamshell Divisions</h3>

<p>Clamshell can also be applied to divisions. Using divisions currently has a slightly different look.</p>

<div class="clamshell use-h5">
  <h5>Some term</h5>
  <div class="clamfold">
    <p>With paragraph tag. Duis enim commodo sint qui commodo eu consequat aliqua consectetur mollit anim. Reprehenderit consectetur amet magna veniam exercitation ut laborum velit elit velit proident sint ut eiusmod commodo. Reprehenderit et esse pariatur quis eiusmod amet deserunt laboris.</p>
    <p>Laborum dolore sit non tempor qui laboris excepteur aliquip incididunt velit velit excepteur qui ad nulla elit.</p>
  </div>
  <h5>Some other term</h5>
  <div class="clamfold">
    <p>With paragraph tag. Duis enim commodo sint qui commodo eu consequat aliqua consectetur mollit anim. Reprehenderit consectetur amet magna veniam exercitation ut laborum velit elit velit proident sint ut eiusmod commodo. Reprehenderit et esse pariatur quis eiusmod amet deserunt laboris.</p>
    <p>Laborum dolore sit non tempor qui laboris excepteur aliquip incididunt velit velit excepteur qui ad nulla elit.</p>
  </div>
</div>
<?php
# --- ↑↑↑ EDIT CONTENT ABOVE ↑↑↑ ---------------------------------------------- ***
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
$page_elements = $mpo_parts->build_page();
echo ($twig->render($mpt_full_template, array('page'=>$page_elements['content'])));
?>
