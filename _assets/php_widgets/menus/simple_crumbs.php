<?php
/**
  * Create a simple directory-based breadcrumb trail.
  *
  * Invoke after config and setting variables. Will build $mpo_parts->crumbs.
  * <div id="breadcrumb-box">
  *   <a href="link">label</a>
  *   <i class="fa fa-iconname"></i>
  *   ...
  *   <i class="fa fa-iconname"></i>
  *   <span class="position">Current Page</span>
  * </div>
  *
  * @copyright 2018 Mootly Obviate - See /LICENSE.md
  * @package   moosepress
  * --------------------------------------------------------------------------- */
  $t_path = explode('/',$_SERVER['PHP_SELF']);
  $crumbstring = '<span class="position">' . $mpo_parts->link_title . '</span>';
  $t_currel = array_pop($t_path);
  if ($t_currel == 'index.php') {
    $t_skip = array_pop($t_path);
  }
  while (count($t_path) > 0) {
    $t_currpath = implode('/',$t_path);
    $t_currel = array_pop($t_path);
    if ($t_currpath == '') {
      $t_currpath = '/';
      $t_currel = 'home';
    }
    $t_currel = preg_replace('/\-([^\-])/', ' ${1}', $t_currel);
    $t_currel = preg_replace('/\- /', '-', $t_currel);
    $crumbstring = '<a href="' . $t_currpath . '">' . $t_currel . '</a> <i class="fa fa-angle-double-right"></i> ' .$crumbstring;
  }
//  $crumbstring = '<div id="breadcrumb-box">' . $crumbstring . '</div>';
  $mpo_parts->crumbs = $crumbstring;
?>
