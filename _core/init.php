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
  if (!defined('MP_PSEP'))       define( 'MP_PSEP', '/' );
  if (!defined('MP_ROOT'))       define( 'MP_ROOT', $_SERVER['DOCUMENT_ROOT'].'/' );
  if (!defined('MP_CLASSLIB'))   define( 'MP_CLASSLIB', MP_ROOT.'_core/class_lib/' );
                    # Fail to default MP_basic template if none specified
  if (!defined('DEF_PREFIX'))    define( 'DEF_PREFIX', 'mp' );
  if (!defined('DEF_TEMPLATE'))  define( 'DEF_TEMPLATE', 'basic' );
  if (!defined('PERM_TEMPLATE')) define( 'PERM_TEMPLATE', 'mp_basic' );
  if (!defined('DEF_ROOT'))      define( 'DEF_ROOT', '' );
  if (!defined('DEF_CLASSLIB'))  define( 'DEF_CLASSLIB', '_core/class_lib/' );
# Call our core objects ------------------------------------------------------- *
                    # Page components
  require_once( MP_CLASSLIB . 'mpc_parts.php');
  if (!isset($mpo_parts)) $mpo_parts = new mpc_parts();
  $mpo_parts->page_path     = dirname($_SERVER['PHP_SELF']);
//  if (!isset($mpo_menus)) $mpo_menus = new mpc_parts(true);
                    # Set default paths for assets
  require_once( MP_CLASSLIB . 'mpc_paths.php' );
  if (!isset($mpo_paths)) $mpo_paths = new mpc_paths(true);
  $mpo_paths->mp_classlib   = MP_CLASSLIB;
  $mpo_paths->core          = MP_ROOT . '_core/';
  $mpo_paths->vendor        = MP_ROOT . '_vendors/';
                    # Define our template name
  if(defined('DEF_TEMPLATE')) {
    if (defined('DEF_PREFIX')) {
      $temp_string          = DEF_PREFIX . '_' . DEF_TEMPLATE . MP_PSEP;
    } else {
      $temp_string          = DEF_TEMPLATE . MP_PSEP;
    }
  } else {
    $temp_string            = "mp_basic/";
  }
# Locate our templates and class library -------------------------------------- *
                    # If the template contains a classlib, declare in config.php
                    # Otherwise it will assume:
                    # /_templates/template_name/classlib
  $mpo_parts->template      = $temp_string ;
  $mpo_parts->perm_template = PERM_TEMPLATE.MP_PSEP;
  $mpo_paths->template      = MP_ROOT . '_templates/';
  $mpo_paths->php_widgets   = MP_ROOT . '_assets/php_widgets/';
                    # If we are in a test copy of pages,
                    # set site base path accordingly
  if (strpos($mpo_parts->page_path,'_templates') !== false) {
    $mpo_parts->site_base   = MP_PSEP . '_templates/'.$mpo_parts->template.'pages';
  } elseif (strpos($mpo_parts->page_path,'/sites/') !== false) {
    $mpo_parts->site_base  = MP_PSEP . 'sites';
  } else {
    $mpo_parts->site_base   = '';
  }
  $mpo_paths->docs          = $mpo_parts->site_base .'/docs';
                    # path t otemplate class libs
  if (defined('DEF_CLASSLIB')) {
    $mpo_paths->tp_classlib = MP_ROOT . DEF_CLASSLIB;
  } else {
    $mpo_paths->tp_classlib = MP_ROOT . '_templates/' . $temp_string .'classlib/';
  }
                    # init autoloader
  spl_autoload_register(function ($classname) {
    global $mpo_paths;
    if(preg_match('/^mpc_/', $classname)) {
      require_once $mpo_paths->mp_classlib . strtolower($classname) . '.php';
    } else {
      require_once $mpo_paths->tp_classlib . strtolower($classname) . '.php';
    }
  });
                    # Load registered components needed by third party modules
  require_once( $mpo_paths->vendor . 'autoload.php' );
                    # Load the mooseplum processing environment
  require_once( $mpo_paths->core   . 'grab.php' );
  require_once( $mpo_paths->core   . 'proc.php' );

                    # Load the master templating module
  if ( (isset($_REQUEST['async'])) AND ($_REQUEST['async'] == true) ) {
    require_once( $mpo_paths->core . 'async_prep.php' );
  } else {
    require_once( $mpo_paths->core . 'prep.php' );
  }
                    # Clean our output buffers to be safe
  if (ob_get_level()) ob_end_clean();

// end include file ----------------------------------------------------------- *
