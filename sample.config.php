<?php
/**
  * Configuration script.
  *
  * This is really just the bootstrap that grabs things.
  * Config moved to config.local.php for each template.
  *
  * @copyright 2019-2020 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- *
  * --- Revision History ------------------------------------------------------ *
  * 2020-05-11 | Break out template specific variables.
  * 2019-07-09 | Added revision log, cleaned code
  * --------------------------------------------------------------------------- */
# Constants ------------------------------------------------------------------- *
# Use constants for our base variables: easy to see, can't be overwritten.      *
                    # Don't touch these --------------------------------------- *
                    # Application pathing                                       *
if (!defined('MP_PSEP'))       define( 'MP_PSEP',       '/'                               );
if (!defined('MP_ROOT'))       define( 'MP_ROOT',       $_SERVER['DOCUMENT_ROOT'].'/'     );
if (!defined('MP_CLASSLIB'))   define( 'MP_CLASSLIB',   MP_ROOT.'_core/class_lib/'        );
if (!defined('MP_WIDGETLIB'))  define( 'MP_WIDGETLIB',  MP_ROOT.'_core/widgets/'          );
if (!defined('CURR_PATH'))     define( 'CURR_PATH',     dirname($_SERVER['SCRIPT_NAME'])  );
                    # Touch these --------------------------------------------- *
                    # Default site pathing                                      *
                    # ROOT     - directory location of home page for site       *
                    # CLASSLIB - where in templates classlibs live              *
if (!defined('DEF_PREFIX'))    define( 'DEF_PREFIX',    'mp'                );
if (!defined('DEF_TEMPLATE'))  define( 'DEF_TEMPLATE',  'basic'             );
if (!defined('PERM_TEMPLATE')) define( 'PERM_TEMPLATE', 'mp_basic'          );
if (!defined('DEF_ROOT'))      define( 'DEF_ROOT',      ''                  );
if (!defined('DEF_CLASSLIB'))  define( 'DEF_CLASSLIB',  '_core/class_lib/'  );
# Initialize the Site --------------------------------------------------------- *
require_once( MP_ROOT.'_core/init.php' );
# Load template-specific configuation ----------------------------------------  *
require_once( MP_ROOT . $mpo_paths->tp_root . '/config.local.php' );
# Invoke Twig ----------------------------------------------------------------- *
require_once( MP_ROOT.'_core/prep.php' );
// end config ----------------------------------------------------------------- *
