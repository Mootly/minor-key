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
  if (!defined('CURR_PATH')) define( 'CURR_PATH', dirname($_SERVER['PHP_SELF']));
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
  require_once( MK_ROOT.'/_core/init.php' );

# Site specific variables ----------------------------------------------------- *
  $mko_parts->page_path     = dirname($_SERVER['PHP_SELF']);
                    # Values expected by the site or sub-site ----------------- *
  $mko_parts->site_name     = 'Minor Key';
  $mko_parts->site_abbr     = '[mk]';
                    # Template formatting rules ------------------------------- *
  $mkt_full_template        = 'page_master.html.twig';      # for generating complete pages
  $mkt_header_template      = 'page_header.html.twig';      # header include for flat file content
  $mkt_footer_template      = 'page_footer.html.twig';      # footer include for flat file content
  $mko_parts->title_struct  = ['page_name','section_name','site_name'];
  $mko_parts->separator     = ' | ';
# Invoke Twig ----------------------------------------------------------------- *
  $loader = new Twig_Loader_Filesystem($mko_paths->template);
  $twig   = new Twig_Environment($loader, array(
    'cache'       => MK_ROOT.'/templates/mk_basic/cache',
    'auto_reload' => true,
  //'debug'       => true,
  ));
  // $twig->addExtension(new Twig_Extension_Debug());

// end config ----------------------------------------------------------------- *
