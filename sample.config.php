<?php
/**
  * Configuration script.
  *
  * Set all your system variables here.
  *
  * @copyright 2017 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */

  # Constants ----------------------------------------------------------------- *
  # We use constants for our base variables to make them easy to spot and to
  # ensure they can't be overwritten in the code.
                    # Don't touch this ---------------------------------------- *
                    # This defines the full site root
                    # It is used for object library pathing
                    # e.g., C:/Web/moosepress
  if (!defined('MP_ROOT'))      { define( 'MP_ROOT', $_SERVER['DOCUMENT_ROOT'].'/' ); }
                    # Core file paths ----------------------------------------- *
                    # This defines the site root as used by templates
                    # This should be blank for standard pathing.
                    # This should match MP_ROOT for servers that expect
                    # absolute server pathing
                    # For subfolders that are their own subdomains, adjust
                    # accordingly
  if (!defined('DEF_ROOT'))     { define( 'DEF_ROOT', '' ); }
  if (!defined('CURR_PATH'))    { define( 'CURR_PATH', dirname($_SERVER['SCRIPT_NAME']) ); }
                    # Where does the home page live (if not root?
  if (!defined('DEF_HOME'))     { define( 'DEF_HOME', '/' ); }
                # Specify our template name
                    # Template names have the following format:
                    # {prefix}_{name}
  if (!defined('DEF_PREFIX'))   { define( 'DEF_PREFIX', 'mp' ); }
  if (!defined('DEF_TEMPLATE')) { define( 'DEF_TEMPLATE', 'basic' ); }
                    # If the templates being used have a class library,
                    # specify it here.
// if (!defined('DEF_CLASSLIB'))  { define( 'DEF_CLASSLIB', '/mp_core/class_lib/' ); }
# Initialize the Site --------------------------------------------------------- *
  require_once( MP_ROOT.'_core/init.php' );

# Site specific variables ----------------------------------------------------- *
                    # Values expected by the site or sub-site ----------------- *
  $mpo_parts->site_name     = 'MoosePress';
  $mpo_parts->site_abbr     = '[mp]';
                    # Specify page title elements ----------------------------- *
                    # Names are properties of _path object defined in page.
                    # format as below: page name | section | site name
  $mpo_parts->title_struct  = ['page_name','section_name','site_name'];
  $mpo_parts->separator     = ' | ';
                    # Define template library --------------------------------- *
                    # This is the only place the filenames should appear.
  $mpt_             = array(
    'suffix'        => '.html.twig',    # default twig suffix
                    # template partials
    'header'        => 'page_header',   # header include
    'footer'        => 'page_footer',   # footer include
                    # page templates
    'default'       => 'page_default',  # standard content page
    'home'          => 'home_default',  # home/splash pages
    'forms'         => 'form_default',  # forms
  );
                    # Set our site wide page defaults ------------------------- *
                    # Whether and which accessibility menu to use.
  $mpo_parts->menu_access     = 'standard';
                    # Comma separated list of classes to add to the body tag.
  $mpo_parts->body_classes    = 'final';
                    # Specify what header elements to show.
  $mpo_parts->header_menu     = array(
    'login'         => true,
    'menu'          => 'main.menu.html.twig',
    'search'        => true,
    'translate'     => true,
  );
                    # Default menu <perm> loads the MoosePress docs menu.
                    # Just to have a menu for testing
                    # Otherwise will look for <menu_left>.html.twig
                    # set to false to skip menu
  $mpo_parts->menu_left       = 'perm';
# Invoke Twig ----------------------------------------------------------------- *
require_once( MP_ROOT.'_core/prep.php' );

// end config ----------------------------------------------------------------- *
