<?php
/**
  * Demo homepage.
  *
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */
                    # Call config to inti the application --------------------- *
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
                    # Build the page ------------------------------------------ *
                    # Content developers shouldn't touch anything above here.
                    # ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ EDIT VARIABLES BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                    # page_name should equal your H1 title.
$mko_parts->page_name     = 'Hello!';
$mko_parts->h1_title      = 'Element Test Page';
$mko_parts->link_title    = 'Home';
$mko_parts->page_name     = $mko_parts->h1_title;
$mko_parts->section_name  = 'Home';
$mko_parts->accessibility = 'standard';
$mko_parts->body_class    = 'draft';
// $mko_parts->pagemenu = 'docs.general';

                    # The main content body of the page is developed here.      *
                    # You can iterate across the two ob_ functions to create    *
                    # more page parts.                                          *
                    # Each part must be defined in the receiving template       *
                    # to be used.                                               *
ob_start();
                    # ↓↓↓ EDIT CONTENT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ ***
?>

<h2 id="toc-links">Contents</h2>

<hr />
<h2>Headings</h2>
<hr />

<h1>Stacked H1</h1>
<h2 class="toc-skip">Stacked H2</h2>
<h3>Stacked H3</h3>
<h4>Stacked H4</h4>
<h5>Stacked H5</h5>
<h6>Stacked H6</h6>

<h1>Inline H1</h1>
<p>Following paragraph.</p>

<h2 class="toc-skip">Inline H2</h2>
<p>Following paragraph.</p>

<h3>Inline H3</h3>
<p>Following paragraph.</p>

<h4>Inline H4</h4>
<p>Following paragraph.</p>

<h5>Inline H5</h5>
<p>Following paragraph.</p>

<h6>Inline H6</h6>
<p>Following paragraph.</p>


<p>The most common use of the <code>ob_</code> (output buffer) control functions is to defer buffer output until a specific time. In this case, this allows the write proces to be delayed until the content is passed to the template, allowing the page to be fully generated before writing anything to output.</p>

<pre>
A test block.
To test blockiness.
Efficient fallaciousness.
A <b>bold</b> and <em>emphatic</em> thing.
</pre>

<p>Be <b>bold</b> and <em>emphatic</em>.</p>

<p>This means we can create static content for an HTML page in a file then invoke the template to wrap that content. The content file is an easy to read PHP file that only requires the content creator to assign values to a few variables and fill in the content between the proverbial lines.</p>
<?php
                    # ↑↑↑ EDIT CONTENT ABOVE ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ ***
$mko_parts->accessibility = 'standard';
$mko_parts->main_content = ob_get_clean();
ob_end_clean();
$page_elements = $mko_parts->build_page();
echo ($twig->render($mkt_full_template, array('page'=>$page_elements['content'])));
?>
