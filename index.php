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
                    # ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ EDIT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                    # page_name should equal your H1 title.
$mko_parts->page_name = 'Hello!';
                    # The main content body of the page is developed here.
                    # It can be built from pieces or written as a block,
                    # depending on the site.
ob_start();
?>
<h2>Example of the page as a delayed block</h2>
<p>Fortean spleen ideals.</p>
<p>Furious green ideas.</p>
<?php
 $mko_parts->accessibility = 'standard';
$mko_parts->main_content = '<p>Hallooo!!!</p>'."\n".ob_get_clean();
ob_end_clean();
                    # ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ EDIT ABOVE ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
                    # Content developers shouldn't touch anything below here.
                    # Invoke the template ------------------------------------- *
$page_elements = $mko_parts->build_page();
$loader = new Twig_Loader_Filesystem($mko_paths->template);
$twig   = new Twig_Environment($loader, array(
  // 'debug' => true
));
// $twig->addExtension(new Twig_Extension_Debug());
echo ($twig->render($mkt_full_template, array('page'=>$page_elements['content'])));
?>
