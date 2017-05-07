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

  $loader = new Twig_Loader_Array(array(
    'index' => '<p>Hello, {{ name }}!</p>',
  ));
  $twig = new Twig_Environment($loader);

  echo $twig->render('index', array('name' => 'Test Case'));
?>
