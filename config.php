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
                    # This defines the full site root
                    # It is used for object library pathing
                    # e.g., C:/Web/minor-key
  if (!defined('MK_ROOT')) { define( 'MK_ROOT', $_SERVER['DOCUMENT_ROOT'] ); }
                    # Core file paths ----------------------------------------- *
                    # This defines the site root as used by templates
                    # This should be blank for standard pathing.
                    # This should match MK_ROOT for servers that expect
                    # absolute server pathing
                    # For subfolders that are their own subdomains, adjust
                    # accordingly
  if (!defined('DEF_ROOT')) define( 'DEF_ROOT', '');
  if (!defined('CURR_PATH')) define( 'CURR_PATH', dirname($_SERVER['REQUEST_URI']));
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
      'ocfs'
    ); }
  if (!defined('DEF_TEMPLATE')) {
    define(
      'DEF_TEMPLATE',
      'master'
    ); }
# Initialize the Site --------------------------------------------------------- *
  require_once( MK_ROOT.'/_core/init.php' );

# Site specific variables ----------------------------------------------------- *
                    # Values expected by the site or sub-site ----------------- *
  $mko_parts->site_name = 'Minor Key';
  $mko_parts->site_abbr = '[mk]';
                    # Template formatting rules ------------------------------- *
  $mkt_full_template        = 'page_master.php';           # for generating complete pages
  $mkt_header_template      = 'page_header.php';           # header include for flat file content
  $mkt_footer_template      = 'page_footer.php';           # footer include for flat file content
  $mko_parts->title_struct  = ['page_name','section_name','site_name'];
  $mko_parts->separator     = ' | ';
// end config ----------------------------------------------------------------- *
