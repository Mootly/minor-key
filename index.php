<?php
/**
  * This is the root page for the Minor Key application.
  * Currently it lives as a sample page for other static pages.
  *
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */

                    # Load core ----------------------------------------------- ***
  require_once( __DIR__.'\mk_core\init.php' );
                    # Load the current template ------------------------------- ***
//  require_once( $mko_paths->template  . '/index.php' );
                    # Set HTTP Headers ---------------------------------------- ***
                    # Begin content ------------------------------------------- ***
$loader = new Twig_Loader_Filesystem($mko_paths->template);
$twig = new Twig_Environment($loader, array());
echo ($twig->render('index.php', array('name' => 'Dobby', 'title' => 'Dobby')));
?>
