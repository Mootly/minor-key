<?php
/**
  * Create a simple directory-based breadcrumb trail.
  *
  * Invoke after config and setting variables. Will build $mpo_parts->crumbs.
  * Note that case insensitive servers will produce an all lower-case list
  * <div id="breadcrumb-box">
  *   <a href="link">label</a>
  *   <span class="fa fa-iconname"></span>
  *   ...
  *   <span class="fa fa-iconname"></span>
  *   <span class="position">Current Page</span>
  * </div>
  *
  * @copyright 2018 Mootly Obviate - See /LICENSE.md
  * @package   moosepress
  * --- Revision History ------------------------------------------------------ *
  * 2019-07-09 | Added revision log, cleaned code
  * --------------------------------------------------------------------------- */
  $t_path = explode('/',$_SERVER['SCRIPT_NAME']);
  $t_home = SITE_HOME ? SITE_HOME : '/';
  $crumbstring = '<span class="position">' . $mpo_parts->link_title . '</span>';
                    # array of overrides inserted between this page and auto    *
  if (isset($t_crumbs_parent)) {
    foreach ($t_crumbs_parent as $t_link) {
      $crumbstring = '<a href="' . $t_link['url'] . '">' . $t_link['name'] . '</a> <span class="fa fa-angle-double-right"></span> ' .$crumbstring;
    }
  }
                    # --------------------------------------------------------- *
                    # "auto_off" allows us to turn off auto and just use the    *
                    # parent crumb list in the array above                      *
  if (!isset($t_crumbs_auto_off)) {
    $t_currel = array_pop($t_path);
    if ($t_currel == 'index.php') {
      $t_skip = array_pop($t_path);
    }
    while (count($t_path) > 0) {
      $_include_this= true;
                    # don't need to test for file paths before adding slash     *
                    # because only directories are linked in the breadcrumbs    *
      $t_currpath   = implode('/',$t_path).'/';
      $t_currel     = array_pop($t_path);
                    # root will come up empty. point to home page w DEF_HOME    *
      if ($t_currpath == '/') {
        $t_currel   = 'home';
        $t_currpath = '/'.$t_home;
                    # stop at top of site if not shared                         *
      } elseif ((SITE_SHARED !== true) && ($t_currpath == MP_PSEP.$mpo_parts->site_base)) {
        $t_currel   = 'home';
        $t_currpath = '/'.$mpo_parts->site_base . $t_home;
        $t_path = array();
                    # hide directories on path with no default index file       *
                    # it should be an else after all over overrides             *
      } else {
        $tf_dirpath = MP_ROOT.$t_currpath;
        $tf_phppath = MP_ROOT.$t_currpath.'index.php';
        $tf_vbspath = MP_ROOT.$t_currpath.'default.asp';
        $tf_htmpath = MP_ROOT.$t_currpath.'index.html';
        if ((is_dir( $tf_dirpath )) and
        (!(file_exists($tf_phppath) or file_exists($tf_vbspath) or file_exists($tf_htmpath)))) {
          $_include_this = false;
        }
        if (($t_currpath == $t_home) OR ($t_currpath.'/' == $t_home))
        { $_include_this = false; }
      }
      # clean up garbage characters in display string             *
      if ($_include_this) {
        $t_currel = preg_replace('/\-([^\-])/', ' ${1}', $t_currel);
        $t_currel = preg_replace('/\- /', '-', $t_currel);
        $t_currel = preg_replace('/_/', ' ', $t_currel);
        $crumbstring = '<a href="' . $t_currpath . '">' . $t_currel . '</a> <span class="fa fa-angle-double-right"></span> ' .$crumbstring;
      }
    }
  }
  $mpo_parts->crumbs = $crumbstring;
?>
