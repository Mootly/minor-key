<?php
/**
  * This is the root page for the Minor Key application.
  * Currently it lives as a sample page for other static pages.
  *
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  *
  */

/** --------------------------------------------------------------------------- *
  * Define page specific presets.
  */
  define('MK_CLASSLIB', '/mk_core/class_lib/');
  define('DEF_PREFIX', 'mk');
  define('DEF_TEMPLATE', 'basic');

/** --------------------------------------------------------------------------- *
  * Define page specific variables.
  */
  // $some_var = 'x';

/** --------------------------------------------------------------------------- *
  *Load the Minor Key processing environment.
  */
  require_once( __DIR__ . '/mk_core/init.php' );
  require_once( $mko_paths->core   . '/grab.php' );
  require_once( $mko_paths->core   . '/proc.php' );

/** --------------------------------------------------------------------------- *
  *Load the master templating module.
  */
  if ( (isset($_REQUEST['async'])) AND ($_REQUEST['async'] == true) ) {
   require_once( $mko_paths->core . '/async_prep.php' );
  } else {
   require_once( $mko_paths->core . '/prep.php' );
  }

  /** --------------------------------------------------------------------------- *
    *Load the current template.
    */
    require_once( $mko_paths->template  . '/index.php' );

  $loader = new Twig_Loader_Array(array(
    'index' => '<p>Hello, {{ name }}!</p>',
  ));
  $twig = new Twig_Environment($loader);

  echo $twig->render('index', array('name' => 'Test Case'));
?>
