<?php
/**
  * This is the init script for the Minor Key application.
  *
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */

# Constants ------------------------------------------------------------------- *
# Values are repeated in case there was no config file.
                    # Core file paths
  if (!defined('MK_ROOT'))      define( 'MK_ROOT', $_SERVER['DOCUMENT_ROOT'] );
  if (!defined('MK_CLASSLIB'))  define( 'MK_CLASSLIB', MK_ROOT.'/mk_core/class_lib/' );
                    # Fail to default mk_basic template if none specified
  if (!defined('DEF_PREFIX'))   define( 'DEF_PREFIX',    'mk' );
  if (!defined('DEF_TEMPLATE')) define( 'DEF_TEMPLATE',  'basic' );
  if (!defined('DEF_ROOT'))     define( 'DEF_ROOT', '' );
  if (!defined('DEF_CLASSLIB')) define( 'DEF_CLASSLIB', MK_ROOT.'/mk_core/class_lib/' );

# Call our core objects ------------------------------------------------------- *
                    # Page components
  require_once( MK_CLASSLIB . '/mkc_parts.php');
  if (!isset($mko_parts)) $mko_parts = new mkc_parts(true);
  if (!isset($mko_menus)) $mko_menus = new mkc_parts(true);
                    # Set default paths for assets
  require_once( MK_CLASSLIB . '/mkc_paths.php' );
  if (!isset($mko_paths)) $mko_paths = new mkc_paths(true);
  $mko_paths->mk_classlib   = MK_CLASSLIB;
  $mko_paths->core          = MK_ROOT . '/mk_core';
  $mko_paths->vendor        = MK_ROOT . '';
                    # Define our template name
  if(defined('DEF_TEMPLATE')) {
    if (defined('DEF_PREFIX')) {
      $temp_string          = DEF_PREFIX . '_' . DEF_TEMPLATE;
    } else {
      $temp_string          = DEF_TEMPLATE;
    }
  } else {
    $temp_string            = "mk_basic";
  }
# Locate our templates and class library -------------------------------------- *
                    # If the template contains a classlib, declear in config.php
                    # Otherwise it will assume:
                    # /templates/template_name/classlib
  define( 'MK_PSEP', '/' );
  $mko_paths->template      = MK_ROOT . '/templates/' . $temp_string ;
  if (defined('DEF_CLASSLIB')) {
    $mko_paths->tp_classlib = MK_ROOT . DEF_CLASSLIB;
  } else {
    $mko_paths->tp_classlib = MK_ROOT . '/templates/' . $temp_string .'/classlib';
  }
  spl_autoload_register(function ($classname) {
    if(preg_match('/^mkc_/', $classname)) {
      global $mko_paths;
      require_once $mko_paths->mk_classlib . MK_PSEP . strtolower($classname) . '.php';
    } else {
      require_once $mko_paths->tp_classlib . MK_PSEP . strtolower($classname) . '.php';
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
