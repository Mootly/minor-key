<?php
/**
  * Configuration script.
  *
  * Set all your system varaibles here.
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
  if (!defined('MP_ROOT')) {
    define(
      'MP_ROOT',
      $_SERVER['DOCUMENT_ROOT']
    ); }
                    # Core file paths ----------------------------------------- *
                    # This defines the site root as used by templates
                    # This should be blank for standard pathing.
                    # This should match MP_ROOT for servers that expect
                    # absolute server pathing
                    # For subfolders that are their own subdomains, adjust
                    # accordingly
  if (!defined('DEF_ROOT')) {
    define(
      'DEF_ROOT',
      ''
    ); }
  if (!defined('CURR_PATH')) {
    define(
      'CURR_PATH',
      dirname($_SERVER['PHP_SELF'])
    );}
                    # Specify our template name
                    # Template names have the following format:
                    # {prefix}_{name}
  if (!defined('DEF_PREFIX'))  {
    define(
      'DEF_PREFIX',
      'mp'
    ); }
  if (!defined('DEF_TEMPLATE')) {
    define(
      'DEF_TEMPLATE',
      'basic'
    ); }
                    # If the templates being used have a class library,
                    # specify it here.
// if (!defined('DEF_CLASSLIB')) {
//   define(
//     'DEF_CLASSLIB',
//     '/MP_core/class_lib/'
//   ); }
# Initialize the Site --------------------------------------------------------- *
  require_once( MP_ROOT.'/_core/init.php' );

# Site specific variables ----------------------------------------------------- *
  $mpo_parts->page_path     = dirname($_SERVER['PHP_SELF']);
                    # Values expected by the site or sub-site ----------------- *
  $mpo_parts->site_name     = 'MoosePress';
  $mpo_parts->site_abbr     = '[mp]';
                    # Template formatting rules ------------------------------- *
  $mpt_full_template        = 'page_master.html.twig';      # for generating complete pages
  $mpt_header_template      = 'page_header.html.twig';      # header include for flat file content
  $mpt_footer_template      = 'page_footer.html.twig';      # footer include for flat file content
  $mpo_parts->title_struct  = ['page_name','section_name','site_name'];
  $mpo_parts->separator     = ' | ';
# Invoke Twig ----------------------------------------------------------------- *
require_once( MP_ROOT.'/_core/prep.php' );

// end config ----------------------------------------------------------------- *
