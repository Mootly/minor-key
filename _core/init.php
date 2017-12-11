<?php
/**
  * This is the init script for the Minor Key application.
  *
  * @copyright 2017 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */

# Constants ------------------------------------------------------------------- *
# Values are repeated in case there was no config file.
                    # Core file paths
  if (!defined('MP_ROOT'))      define( 'MP_ROOT', $_SERVER['DOCUMENT_ROOT'] );
  if (!defined('MP_CLASSLIB'))  define( 'MP_CLASSLIB', MP_ROOT.'/_core/class_lib/' );
                    # Fail to default MP_basic template if none specified
  if (!defined('DEF_PREFIX'))   define( 'DEF_PREFIX',    'mk' );
  if (!defined('DEF_TEMPLATE')) define( 'DEF_TEMPLATE',  'basic' );
  if (!defined('DEF_ROOT'))     define( 'DEF_ROOT', '' );
  if (!defined('DEF_CLASSLIB')) define( 'DEF_CLASSLIB', MP_ROOT.'/_core/class_lib/' );

# Call our core objects ------------------------------------------------------- *
                    # Page components
  require_once( MP_CLASSLIB . '/mkc_parts.php');
  if (!isset($mko_parts)) $mko_parts = new mkc_parts(true);
  if (!isset($mko_menus)) $mko_menus = new mkc_parts(true);
                    # Set default paths for assets
  require_once( MP_CLASSLIB . '/mkc_paths.php' );
  if (!isset($mko_paths)) $mko_paths = new mkc_paths(true);
  $mko_paths->MP_classlib   = MP_CLASSLIB;
  $mko_paths->core          = MP_ROOT . '/_core';
  $mko_paths->vendor        = MP_ROOT . '/_vendors';
                    # Define our template name
  if(defined('DEF_TEMPLATE')) {
    if (defined('DEF_PREFIX')) {
      $temp_string          = DEF_PREFIX . '_' . DEF_TEMPLATE;
    } else {
      $temp_string          = DEF_TEMPLATE;
    }
  } else {
    $temp_string            = "MP_basic";
  }
# Locate our templates and class library -------------------------------------- *
                    # If the template contains a classlib, declare in config.php
                    # Otherwise it will assume:
                    # /templates/template_name/classlib
  define( 'MP_PSEP', '/' );
  $mko_parts->template      = $temp_string ;
  $mko_paths->template      = MP_ROOT . '/templates/' . $temp_string ;
  if (defined('DEF_CLASSLIB')) {
    $mko_paths->tp_classlib = MP_ROOT . DEF_CLASSLIB;
  } else {
    $mko_paths->tp_classlib = MP_ROOT . '/templates/' . $temp_string .'/classlib';
  }
  spl_autoload_register(function ($classname) {
    if(preg_match('/^mkc_/', $classname)) {
      global $mko_paths;
      require_once $mko_paths->MP_classlib . MP_PSEP . strtolower($classname) . '.php';
    } else {
      require_once $mko_paths->tp_classlib . MP_PSEP . strtolower($classname) . '.php';
    }
  });
                    # Load registered components needed by third party modules
  require_once( $mko_paths->vendor . '/autoload.php' );
                    # Load the Minor Key processing environment
  require_once( $mko_paths->core   . '/grab.php' );
  require_once( $mko_paths->core   . '/proc.php' );

                    # Load the master templating module
  if ( (isset($_REQUEST['async'])) AND ($_REQUEST['async'] == true) ) {
    require_once( $mko_paths->core . '/async_prep.php' );
  } else {
    require_once( $mko_paths->core . '/prep.php' );
  }
                    # Clean our output buffers to be safe
  if (ob_get_level()) ob_end_clean();

// end include file ----------------------------------------------------------- *
