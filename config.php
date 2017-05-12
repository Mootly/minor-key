<?php
/**
  * Configuration script.
  *
  * Set all your system varaibles here.
  *
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */
                    # Contants ------------------------------------------------ ***
  if (!defined('MK_ROOT')) define( 'MK_ROOT', $_SERVER['DOCUMENT_ROOT'] );
  if (!defined('MK_CLASSLIB')) define( 'MK_CLASSLIB', MK_ROOT.'/mk_core/class_lib/' );
                    # The objects that manage our page and location ----------- ***
  require_once( MK_CLASSLIB . '/mkc_parts.php' );
  if (!isset($mko_parts)) { $mko_parts = new mkc_parts(true); }
  if (!isset($mko_menus)) { $mko_menus = new mkc_parts(true); }
                    # System variables ---------------------------------------- ***
                    # Required by the application

                    # Site specific variables --------------------------------- ***
                    # Should be required by the site/page templates
  $mkv_parts->site_name = 'Minor Key';
  $mkv_parts->site_abbr = '[mk]';
                    # Template specific variables ----------------------------- ***
                    # Optional - cam be ignored by the template
  $mkt_base_template        = 'index.php';
  $mko_parts->title_struct  = ['page_name','section_name','site_name'];
  $mko_parts->separator     = ' | ';
// end config ----------------------------------------------------------------- ***
