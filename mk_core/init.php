<?php
/**
  * This is the init script for the Minor Key application.
  *
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */

                    # Define default page specific presets -------------------- ***
  if (!defined('DEF_PREFIX'))   define('DEF_PREFIX',    'mk');
  if (!defined('DEF_TEMPLATE')) define('DEF_TEMPLATE',  'basic');
                    # Define page specific variables -------------------------- ***
  // $some_var = 'x';
                    # Application presets ------------------------------------- ***
                    # Set path constants -------------------------------------- ***
  define( 'MK_PSEP', '/' );
                    # Set default paths for assets ---------------------------- ***
  require_once( MK_CLASSLIB . '/mkc_paths.php' );
  if (!isset($mko_paths)) { $mko_paths = new mkc_paths(true); }
  $mko_paths->mk_classlib     = MK_CLASSLIB;
  $mko_paths->core            = MK_ROOT . '/mk_core';
  $mko_paths->vendor          = MK_ROOT . '/vendors';
  if(defined('DEF_TEMPLATE')) {
    if (defined('DEF_PREFIX')) {
      $temp_string  = DEF_PREFIX . '_' . DEF_TEMPLATE;
    } else {
      $temp_string  = DEF_TEMPLATE;
    }
  } else {
    $temp_string    = "mk_basic";
  }
  $mko_paths->template    = MK_ROOT . '/templates/'. $temp_string ;
  $mko_paths->tp_classlib = MK_ROOT . '/templates/'. $temp_string .'/classlib';
                    # Tell PHP where the template class library is ------------ ***
  spl_autoload_register(function ($classname) {
    if(preg_match('/^mkc_/', $classname)) {
      global $mko_paths;
      require_once $mko_paths->mk_classlib . MK_PSEP . strtolower($classname) . '.php';
    } else {
      require_once $mko_paths->tp_classlib . MK_PSEP . strtolower($classname) . '.php';
    }
  });
                    # Load registered components needed by third party modules  ***
  require_once( $mko_paths->vendor . '/autoload.php' );
                    # Load the Minor Key processing environment --------------- ***
  require_once( $mko_paths->core   . '/grab.php' );
  require_once( $mko_paths->core   . '/proc.php' );

                    # Load the master templating module.----------------------- ***
  if ( (isset($_REQUEST['async'])) AND ($_REQUEST['async'] == true) ) {
    require_once( $mko_paths->core . '/async_prep.php' );
  } else {
    require_once( $mko_paths->core . '/prep.php' );
  }

/** end include file ---------------------------------------------------------- */
