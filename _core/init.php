<?php
/**
  * This is the init script for the MoosePress application.
  *
  * @copyright 2017-2018 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */

# Constants ------------------------------------------------------------------- *
# Values are repeated in case there was no config file.
                    # Core file paths
  if (!defined('MP_ROOT'))      define( 'MP_ROOT', $_SERVER['DOCUMENT_ROOT'] );
  if (!defined('MP_CLASSLIB'))  define( 'MP_CLASSLIB', MP_ROOT.'/_core/class_lib/' );
                    # Fail to default MP_basic template if none specified
  if (!defined('DEF_PREFIX'))   define( 'DEF_PREFIX',    'mp' );
  if (!defined('DEF_TEMPLATE')) define( 'DEF_TEMPLATE',  'basic' );
  if (!defined('DEF_ROOT'))     define( 'DEF_ROOT', '' );
  if (!defined('DEF_CLASSLIB')) define( 'DEF_CLASSLIB', '/_core/class_lib/' );
# Call our core objects ------------------------------------------------------- *
                    # Page components
  require_once( MP_CLASSLIB . '/mpc_parts.php');
  if (!isset($mpo_parts)) $mpo_parts = new mpc_parts();
//  if (!isset($mpo_menus)) $mpo_menus = new mpc_parts(true);
                    # Set default paths for assets
  require_once( MP_CLASSLIB . '/mpc_paths.php' );
  if (!isset($mpo_paths)) $mpo_paths = new mpc_paths(true);
  $mpo_paths->mp_classlib   = MP_CLASSLIB;
  $mpo_paths->core          = MP_ROOT . '/_core';
  $mpo_paths->vendor        = MP_ROOT . '/_vendors';
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
  $mpo_parts->template      = $temp_string ;
  $mpo_paths->template      = MP_ROOT . '/templates/' . $temp_string ;
  $mpo_paths->php_widgets   = MP_ROOT . '/_assets/php_widgets' ;
  $mpo_paths->docs          = MP_ROOT . '/docs' ;
  if (defined('DEF_CLASSLIB')) {
    $mpo_paths->tp_classlib = MP_ROOT . DEF_CLASSLIB;
  } else {
    $mpo_paths->tp_classlib = MP_ROOT . '/templates/' . $temp_string .'/classlib';
  }
                    # init autoloader
  spl_autoload_register(function ($classname) {
    if(preg_match('/^mpc_/', $classname)) {
      global $mpo_paths;
      require_once $mpo_paths->mp_classlib . MP_PSEP . strtolower($classname) . '.php';
    } else {
      require_once $mpo_paths->tp_classlib . MP_PSEP . strtolower($classname) . '.php';
    }
  });
                    # Load registered components needed by third party modules
  require_once( $mpo_paths->vendor . '/autoload.php' );
                    # Load the mooseplum processing environment
  require_once( $mpo_paths->core   . '/grab.php' );
  require_once( $mpo_paths->core   . '/proc.php' );

                    # Load the master templating module
  if ( (isset($_REQUEST['async'])) AND ($_REQUEST['async'] == true) ) {
    require_once( $mpo_paths->core . '/async_prep.php' );
  } else {
    require_once( $mpo_paths->core . '/prep.php' );
  }
                    # Clean our output buffers to be safe
  if (ob_get_level()) ob_end_clean();

// end include file ----------------------------------------------------------- *
