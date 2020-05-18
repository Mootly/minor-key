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
# Locate our site base -------------------------------------------------------- *
                    # Set site base according to location                       *
                    # reserved path elements:                                   *
                    # - /_templates/{template}/pages/                           *
                    # - /sites/                                                 *
  if (strpos($mpo_parts->page_path,'_templates') !== false) {
    $temp_array = explode('/pages/', $mpo_parts->page_path);
    $temp_string = $temp_array[0];
    $mpo_parts->site_base     = MP_PSEP . $temp_string . MP_PSEP . 'pages';
  } elseif (strpos($mpo_parts->page_path,'/sites/') !== false) {
    $temp_array = explode('/', preg_replace('/.*sites\//','',$mpo_parts->page_path));
    $temp_string = $temp_array[0];
    $mpo_parts->site_base     = MP_PSEP . 'sites' . MP_PSEP . $temp_string;
                    # check for site specific overrides                         *
    if (file_exists(MP_ROOT . $mpo_parts->site_base . '/config.local.php')) {
      include_once( MP_ROOT . $mpo_parts->site_base . '/config.local.php' );
    }
  } else {
    $mpo_parts->site_base     = '/';
  }
# Locate our templates -------------------------------------------------------- *
                    # If we are in a template folder, use that template         *
  if (strpos($mpo_parts->page_path,'_templates') !== false) {
    $temp_array = explode('/', preg_replace('/.*_templates\//','',$mpo_parts->page_path));
    $temp_string = $temp_array[0].'/';
                    # check for local overrides                                 *
  } else {
    if (defined('SITE_TEMPLATE_FULL')) {
      $temp_string = DEF_TEMPLATE_OVERRIDE . MP_PSEP;
    } elseif(defined('SITE_TEMPLATE')) {
      if (defined('SITE_TEMPLATE_PREFIX')) {
        $temp_string          = SITE_TEMPLATE_PREFIX . '_' . SITE_TEMPLATE . MP_PSEP;
      } else { $temp_string   = SITE_TEMPLATE . MP_PSEP; }
                    # else use defsult template                                 *
    } elseif(defined('DEF_TEMPLATE')) {
      if (defined('DEF_PREFIX')) {
        $temp_string          = DEF_PREFIX . '_' . DEF_TEMPLATE . MP_PSEP;
      } else { $temp_string   = DEF_TEMPLATE . MP_PSEP; }
                    # make sure there is always a perm template                 *
    } else { $temp_string     = PERM_TEMPLATE; }
  }
  $mpo_parts->template        = $temp_string;
  $mpo_parts->perm_template   = PERM_TEMPLATE.MP_PSEP;
# server paths to template and site components -------------------------------- *
  $mpo_paths->template        = MP_ROOT . '_templates/';
  $mpo_paths->widgets         = MP_ROOT . '_assets/widgets/';
  $mpo_paths->php_widgets     = MP_ROOT . '_assets/php_widgets/';
# local paths to template and site components --------------------------------- *
  $mpo_paths->tp_root         = '/_templates/' . $mpo_parts->template;
  $mpo_paths->assets          = '/_templates/' . $mpo_parts->template . '_assets/';
  $mpo_paths->images          = '/_templates/' . $mpo_parts->template . '_assets/images/';
  $mpo_paths->tp_widgets      = '/_templates/' . $mpo_parts->template . '_assets/widgets/';
  $mpo_paths->tp_php_widgets  = '/_templates/' . $mpo_parts->template . '_assets/php_widgets/';
  # If the template contains classlib, declare in config.php  *
  # Otherwise it will assume:                                 *
  # /_templates/template_name/classlib                        *
  # root assets - server-side only - root included            *
                    # Specify preset paths for standard resources               *
  $mpo_paths->docs          = $mpo_parts->site_base .'/docs';
  $mpo_parts->docs          = $mpo_paths->docs;
  $mpo_paths->cms           = $mpo_parts->site_base .'/edit';
  $mpo_parts->cms           = $mpo_paths->cms;
  $mpo_paths->search        = $mpo_parts->site_base .'/search';
  $mpo_parts->search        = $mpo_paths->search;
                    # path to template class libs                               *
  if (!(defined('DEF_TEMPLATE_OVERRIDE')) && defined('DEF_CLASSLIB')) {
    $mpo_paths->tp_classlib = MP_ROOT . DEF_CLASSLIB;
  } else {
    $mpo_paths->tp_classlib = MP_ROOT . '_templates/' . $temp_string .'class_lib/';
  }
  # Specify path to template class library ------------------ *
  # Leave initial slash off, path will be prepended.
if (!defined('TP_CLASSLIB'))    define( 'TP_CLASSLIB',    $mpo_paths->tp_root.'/class_lib/'   );
if (!defined('SITE_CLASSLIB'))  define( 'SITE_CLASSLIB',  $mpo_parts->site_base.'/class_lib/' );
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
