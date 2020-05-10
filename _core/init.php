<?php
/**
  * This is the init script for the MoosePress application.
  *
  * @copyright 2017-2018 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */

# Security -------------------------------------------------------------------- *
# make sure our pages are more secure than the server *might* be                *
  ini_set('session.cookie_httponly', 1 );
  ini_set('session.use_only_cookies', 1);
  if(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == "on")) {
    ini_set('session.cookie_secure', 1);
  }
# These are, unfortunately, dependent on the browser to respond correctly.      *
  header('X-XSS-Protection: 1; mode=block');
  header('X-Frame-Options: SAMEORIGIN');
# Constants ------------------------------------------------------------------- *
# Values are repeated in case there was no config file.                         *
                    # Core file paths                                           *
                    # Use constants to force any overrides to be manually coded *
                    # below                                                     *
  if (!defined('MP_PSEP'))       define( 'MP_PSEP', '/' );
  if (!defined('MP_ROOT'))       define( 'MP_ROOT', $_SERVER['DOCUMENT_ROOT'].'/' );
  if (!defined('MP_CLASSLIB'))   define( 'MP_CLASSLIB', MP_ROOT.'_core/class_lib/' );
  if (!defined('MP_WIDGETLIB'))  define( 'MP_WIDGETLIB', MP_ROOT.'_core/widgets/' );
                    # Fail to default MP_basic template if none specified
  if (!defined('DEF_PREFIX'))    define( 'DEF_PREFIX', 'mp' );
  if (!defined('DEF_TEMPLATE'))  define( 'DEF_TEMPLATE', 'basic' );
  if (!defined('PERM_TEMPLATE')) define( 'PERM_TEMPLATE', 'mp_basic' );
  if (!defined('DEF_ROOT'))      define( 'DEF_ROOT', '' );
  if (!defined('DEF_CLASSLIB'))  define( 'DEF_CLASSLIB', '_core/class_lib/' );
# Call our core objects ------------------------------------------------------- *
                    # Page components                                           *
  require_once( MP_CLASSLIB . 'mpc_parts.php');
  if (!isset($mpo_parts)) $mpo_parts = new mpc_parts();
  $mpo_parts->page_path     = dirname($_SERVER['SCRIPT_NAME']);
  $mpo_parts->user_agent    = dirname($_SERVER['HTTP_USER_AGENT']);
//  if (!isset($mpo_menus)) $mpo_menus = new mpc_parts(true);
                    # Set default paths for assets                              *
  require_once( MP_CLASSLIB . 'mpc_paths.php' );
  if (!isset($mpo_paths)) $mpo_paths = new mpc_paths(true);
  $mpo_paths->mp_classlib   = MP_CLASSLIB;
  $mpo_paths->core          = MP_ROOT . '_core/';
  $mpo_paths->vendor        = MP_ROOT . '_vendors/';
# Locate our templates and class library -------------------------------------- *
                    # If we are in a test copy of pages,                        *
                    # set site base path accordingly                            *
  if (strpos($mpo_parts->page_path,'_templates') !== false) {
    $mpo_parts->site_base     = MP_PSEP . '_templates/'.$mpo_parts->template.'pages';
  } elseif (strpos($mpo_parts->page_path,'/sites/') !== false) {
    $temp_array = explode('/', preg_replace('/.*sites\//','',$mpo_parts->page_path));
    $temp_string = $temp_array[0];
    $mpo_parts->site_base     = MP_PSEP . 'sites' . MP_PSEP . $temp_string;
                    # check for site specific overrides                         *
                    # currently only supports template overrides                *
    include_once( MP_ROOT . $mpo_parts->site_base . '/config.php' );
  } else {
    $mpo_parts->site_base     = '';
  }
                    # If we are in a template folder, use that template         *
                    # Otherwise define our template name from config            *
                    # If none defined, use default                              *
  if (strpos($mpo_parts->page_path,'_templates') !== false) {
    $temp_array = explode('/', preg_replace('/.*_templates\//','',$mpo_parts->page_path));
    $temp_string = $temp_array[0].'/';
  } else {
    if (defined('DEF_TEMPLATE_OVERRIDE')) {
      $temp_string = DEF_TEMPLATE_OVERRIDE . MP_PSEP;
    } elseif(defined('DEF_TEMPLATE')) {
      if (defined('DEF_PREFIX')) {
        $temp_string        = DEF_PREFIX . '_' . DEF_TEMPLATE . MP_PSEP;
      } else { $temp_string = DEF_TEMPLATE . MP_PSEP; }
    } else { $temp_string   = "mp_basic/"; }
  }
                    # If the template contains classlib, declare in config.php  *
                    # Otherwise it will assume:                                 *
                    # /_templates/template_name/classlib                        *
  $mpo_parts->template        = $temp_string ;
  $mpo_parts->perm_template   = PERM_TEMPLATE.MP_PSEP;
  $mpo_paths->template        = MP_ROOT . '_templates/';
                    # root assets - server-side only - root included            *
  $mpo_paths->widgets         = MP_ROOT . '_assets/widgets/';
  $mpo_paths->php_widgets     = MP_ROOT . '_assets/php_widgets/';
                    # template assets - server or client - root not included    *
  $mpo_paths->tp_root         = '/_templates/' . $mpo_parts->template;
  $mpo_paths->assets          = '/_templates/' . $mpo_parts->template . '_assets/';
  $mpo_paths->images          = '/_templates/' . $mpo_parts->template . '_assets/images/';
  $mpo_paths->tp_widgets      = '/_templates/' . $mpo_parts->template . '_assets/widgets/';
  $mpo_paths->tp_php_widgets  = '/_templates/' . $mpo_parts->template . '_assets/php_widgets/';
                    # Specify preset paths for standard resources               *
  $mpo_paths->docs          = $mpo_parts->site_base .'/docs';
  $mpo_parts->docs          = $mpo_paths->docs;
  $mpo_paths->cms           = $mpo_parts->site_base .'/edit';
  $mpo_parts->cms           = $mpo_paths->cms;
  $mpo_paths->search        = $mpo_parts->site_base .'/search';
  $mpo_parts->search        = $mpo_paths->search;
                    # path to template class libs
  if (!(defined('DEF_TEMPLATE_OVERRIDE')) && defined('DEF_CLASSLIB')) {
    $mpo_paths->tp_classlib = MP_ROOT . DEF_CLASSLIB;
  } else {
    $mpo_paths->tp_classlib = MP_ROOT . '_templates/' . $temp_string .'class_lib/';
  }
                    # init autoloader                                           *
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
  require_once( $mpo_paths->core . 'send.php' );

                    # Clean our output buffers to be safe
  if (ob_get_level()) ob_end_clean();

// end include file ----------------------------------------------------------- *
