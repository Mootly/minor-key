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
$mko_parts->page_name = 'Hello!';
$mko_parts->h1_title  = 'Example of a page as a write-deferred block';
$mko_parts->link_title  = 'Home';
$mko_parts->page_name = $mko_parts->h1_title;
$mko_parts->section_name = 'Home';
$mko_parts->accessibility = 'standard';
// $mko_parts->pagemenu = 'docs.general';

                    # The main content body of the page is developed here.      *
                    # You can iterate across the two ob_ functions to create    *
                    # more page parts.                                          *
                    # Each part must be defined in the receiving template       *
                    # to be used.                                               *
ob_start();
                    # ↓↓↓ EDIT CONTENT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ ***
?>
<p>The most common use of the <code>ob_</code> (output buffer) control functions is to defer buffer output until a specific time. In this case, this allows the write proces to be delayed until the content is passed to the template, allowing the page to be fully generated before writing anything to output.</p>

<p>This means we can create static content for an HTML page in a file then invoke the template to wrap that content. The content file is an easy to read PHP file that only requires the content creator to assign values to a few variables and fill in the content between the proverbial lines.</p>
<?php
                    # ↑↑↑ EDIT CONTENT ABOVE ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ ***
$mko_parts->accessibility = 'standard';
$mko_parts->main_content = ob_get_clean();
ob_end_clean();
$page_elements = $mko_parts->build_page();
echo ($twig->render($mkt_full_template, array('page'=>$page_elements['content'])));
?>
