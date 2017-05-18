<?php
/**
  * Configuration script.
  *
  * Set all your system varaibles here.
  *
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */

  # Constants ----------------------------------------------------------------- *
  # We use constants for our base variables to make them easy to spot and to
  # ensure they can't be overwritten in the code.
                    # Don't touch this ---------------------------------------- *
                    # Thise defines the site root
  if (!defined('MK_ROOT')) { define( 'MK_ROOT', $_SERVER['DOCUMENT_ROOT'] ); }
                    # Core file paths ----------------------------------------- *
                    # This should match MK_ROOT unless you have subfolders that
                    # contain subdomains.
  if (!defined('DEF_ROOT')) define( 'DEF_ROOT', $_SERVER['DOCUMENT_ROOT']);
                    # If the templates being used have a class library,
                    # specify it here.
  // if (!defined('DEF_CLASSLIB')) {
  //   define(
  //     'DEF_CLASSLIB',
  //     '/mk_core/class_lib/'
  //   ); }
                    # Specify our tempalte names
  if (!defined('DEF_PREFIX'))  {
    define(
      'DEF_PREFIX',
      'mk'
    ); }
  if (!defined('DEF_TEMPLATE')) {
    define(
      'DEF_TEMPLATE',
      'basic'
    ); }
# Initialize the Site --------------------------------------------------------- *
  require_once( MK_ROOT.'\mk_core\init.php' );

# Site specific variables ----------------------------------------------------- *
                    # Values expected by the site or sub-site ----------------- *
  $mkv_parts->site_name = 'Minor Key';
  $mkv_parts->site_abbr = '[mk]';
                    # Template formatting rules ------------------------------- *
  $mkt_base_template        = 'index.php';
  $mko_parts->title_struct  = ['page_name','section_name','site_name'];
  $mko_parts->separator     = ' | ';
// end config ----------------------------------------------------------------- *
