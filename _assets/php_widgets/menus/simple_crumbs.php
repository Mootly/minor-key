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
    $_include_this  = true;
    $t_currpath  = implode('/',$t_path);
    $t_currel = array_pop($t_path);
                    # root will come up empty. point to home page w DEF_HOME    *
    if ($t_currpath == '') {
      $t_currel = 'home';
      $t_currpath = defined('DEF_HOME') ? DEF_HOME : '/';
                    # hide directories on path with no default index file       *
                    # it should be an else after all over overrides             *
    } else {
      $tf_dirpath  = MP_ROOT.$t_currpath;
      $tf_phppath  = MP_ROOT.$t_currpath.'/index.php';
      $tf_vbspath  = MP_ROOT.$t_currpath.'/default.asp';
      $tf_htmpath  = MP_ROOT.$t_currpath.'/index.html';
      if ((is_dir( $tf_dirpath )) and
          (!(file_exists($tf_phppath) or file_exists($tf_vbspath) or file_exists($tf_htmpath)))) {
        $_include_this = false;
      }
    }
                    # clean up garbage characters in display string             *
    if ($_include_this) {
      $t_currel = preg_replace('/\-([^\-])/', ' ${1}', $t_currel);
      $t_currel = preg_replace('/\- /', '-', $t_currel);
      $t_currel = preg_replace('/_/', ' ', $t_currel);
      $crumbstring = '<a href="' . $t_currpath . '">' . $t_currel . '</a> <i class="fa fa-angle-double-right"></i> ' .$crumbstring;
    }
  }
  $mpo_parts->crumbs = $crumbstring;
?>
