<?php
/**
  * Demo homepage.
  *
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */

                    # These two lines init the application -------------------- *
  require_once( $_SERVER['DOCUMENT_ROOT'].'\config.php' );
                    # Load the current template ------------------------------- *
  $mko_parts->title = 'Hello!';
  $mko_parts->name  = 'Ken Doll';
//  $mko_parts->title = $mko_parts->page_name.$mko_parts->title_separator.$mkp_parts->site_name;
  $loader = new Twig_Loader_Filesystem($mko_paths->template);
  $twig = new Twig_Environment($loader, array());
  echo ($twig->render($mkt_base_template, array('title'=>'a','name'=>'b')));
?>
