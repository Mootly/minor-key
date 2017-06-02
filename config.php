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
                    # Specify our template names
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
  require_once( MK_ROOT.'/mk_core/init.php' );

# Site specific variables ----------------------------------------------------- *
                    # Values expected by the site or sub-site ----------------- *
  $mko_parts->site_name = 'Minor Key';
  $mko_parts->site_abbr = '[mk]';
                    # Template formatting rules ------------------------------- *
  $mkt_full_template        = 'index.php';                  # for generating complete pages
  $mkt_header_template      = 'index.php';                  # header for flat file content
  $mkt_footer_template      = 'index.php';                  # footer for flat file content
  $mko_parts->title_struct  = ['page_name','section_name','site_name'];
  $mko_parts->separator     = ' | ';
// end config ----------------------------------------------------------------- *
