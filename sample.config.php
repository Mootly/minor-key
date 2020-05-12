<?php
/**
  * Configuration script.
  *
  * This is just a bootstrap that sets some defaults ans then grabs things.
  * Config has been moved to config.local.php for each template, which will
  * override these settings.
  * Not renaming file to bootstrap, tempting though it is, because we need
  * backward compatibility and too many pages are already looking for config.
  *
  * @copyright 2019-2020 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- *
  * --- Revision History ------------------------------------------------------ *
  * 2020-05-12 | Break out template specific variables.
  * 2019-07-09 | Added revision log, cleaned code
  * --------------------------------------------------------------------------- */
# Constants ------------------------------------------------------------------- *
# Use constants for our base variables: easy to see, can't be overwritten.      *
# !!! DON'T TOUCH THESE !!! --------------------------------------------------- *
                    # Application Pathing ------------------------------------- *
                    # MP_PSEP           Path seperator (just in case)           *
                    # MP_ROOT           Server root of site application         *
                    # MP_CLASSLIB       Server path to default class library    *
                    # MP_WIDGETLIB      Server path to default widget library   *
                    # CURR_PATH         Current script (page) being executed    *
if (!defined('MP_PSEP'))       define( 'MP_PSEP',       '/'                               );
if (!defined('MP_ROOT'))       define( 'MP_ROOT',       $_SERVER['DOCUMENT_ROOT'].'/'     );
if (!defined('MP_CLASSLIB'))   define( 'MP_CLASSLIB',   MP_ROOT.'_core/class_lib/'        );
if (!defined('MP_WIDGETLIB'))  define( 'MP_WIDGETLIB',  MP_ROOT.'_core/widgets/'          );
if (!defined('CURR_PATH'))     define( 'CURR_PATH',     dirname($_SERVER['SCRIPT_NAME'])  );
# *** START EDITABLE *** ------------------------------------------------------ *
                    # Default Pathing ----------------------------------------- *
                    # Set these to whataver you want your site to fall back on  *
                    # Default site pathing                                      *
                    # DEF_ROOT          Application relative root of site       *
                    # For                                | Value should be      *
                    # ---------------------------------- | -------------------- *
                    # standard pathing                   | leave blank          *
                    # servers that expect server pathing | match MP_ROOT        *
                    # subdomains as subfolders           | adjust accordingly   *
                    # DEF_HOME          Root relative home page of site         *
                    # DEF_CLASSLIB      Site path to default class library      *
if (!defined('DEF_ROOT'))      define( 'DEF_ROOT',      ''                  );
if (!defined('DEF_HOME'))      define( 'DEF_HOME',      '/'                 );
if (!defined('DEF_CLASSLIB'))  define( 'DEF_CLASSLIB',  '_core/class_lib/'  );
                    # Template Names ------------------------------------------ *
                    # Fallback breaks without a PERM value                      *
                    # Default name and prefix separate.                         *
                    # This allows for template families                         *
if (!defined('DEF_PREFIX'))    define( 'DEF_PREFIX',    'mp'                );
if (!defined('DEF_TEMPLATE'))  define( 'DEF_TEMPLATE',  'basic'             );
if (!defined('PERM_TEMPLATE')) define( 'PERM_TEMPLATE', 'mp_basic'          );
# *** END EDITABLE *** -------------------------------------------------------- *
# Initialize the Site --------------------------------------------------------- *
require_once( MP_ROOT.'_core/init.php' );
# Load template-specific configuation ----------------------------------------- *
require_once( MP_ROOT . $mpo_paths->tp_root . 'config.local.php' );
if (!defined('SITE_HOME'))     define( 'SITE_HOME',     DEF_HOME             );
// end config ----------------------------------------------------------------- *
