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
  require_once( $mko_paths->template  . '/index.php' );
                    # Some test code ------------------------------------------ ***
  $loader = new Twig_Loader_Array(array(
    'index' => '<p>Hello, {{ name }}!</p>',
  ));
  $twig = new Twig_Environment($loader);

  echo $twig->render('index', array('name' => 'Test Case'));
?>
