<?php
/** 
  * This is the init script for the Minor Key application.
  *
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */

                    # Application presets ------------------------------------- ***
                    # Set path constants -------------------------------------- ***
  define( 'MK_PSEP', '/' );
  define( 'MK__DIR__', dirname(__FILE__,2) );
  define( 'MK__CLASSLIB__', MK__DIR__ . MK_CLASSLIB );
  require_once( MK__CLASSLIB__ . '/mkc_paths.php');
                    # Set default paths for assets ---------------------------- ***
  if (!isset($mko_paths)) { $mko_paths = new mkc_paths(true); }
  $mko_paths->mk_classlib     = MK__CLASSLIB__;
  $mko_paths->core            = MK__DIR__ . '/mk_core';
  $mko_paths->vendor          = MK__DIR__ . '/vendors';
  if(defined('DEF_TEMPLATE')) {
    if (defined('DEF_PREFIX')) {
      $temp_string  = DEF_PREFIX . '_' . DEF_TEMPLATE;
    } else {
      $temp_string  = DEF_TEMPLATE;
    }
  } else {
    $temp_string    = 'mk_basic';
  }
  $mko_paths->template    = MK__DIR__ . '/templates/'. $temp_string ;
  $mko_paths->tp_classlib = MK__DIR__ . '/templates/'. $temp_string .'/classlib';
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
/** end include file ---------------------------------------------------------- */
