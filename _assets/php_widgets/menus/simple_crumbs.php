<?php
/**
  * Create a simple directory-based breadcrumb trail.
  *
  * Invoke after config and setting variables. Will build $mpo_parts->crumbs.
  * Note that case insensitive servers will produce an all lower-case list
  * <div id="breadcrumb-box">
  *   <a href="link">label</a>
  *   <span class="spacer [fa-classes]"></span>
  *   ...
  *   <span class="spacer [fa-classes]"></span>
  *   <span class="position">Current Page</span>
  * </div>
  *
  * @copyright 2018-2020 Mootly Obviate - See /LICENSE.md
  * @package   moosepress
  * --- Revision History ------------------------------------------------------ *
  * 2020-10-02 | Added code to cover all pssobile default files
  * 2019-07-09 | Added revision log, cleaned code
  * --------------------------------------------------------------------------- */
  $t_path = explode('/',$_SERVER['SCRIPT_NAME']);
  if (!defined('SITE_HOME')) define( 'SITE_HOME', '' );
  $crumbstring = '<span class="position">' . mb_strtolower($mpo_parts->link_title) . '</span>';
                    # array of overrides inserted between this page and auto    *
                    # currently defaulting to FontAwesome 4 because that is     *
                    # what was used during the first iteration of this widget   *
  $t_crumbclass = ($mpo_parts->crumb_classes) ? $mpo_parts->crumb_classes : 'fa fa-angle-double-right';
  if (isset($t_crumbs_parent)) {
    foreach ($t_crumbs_parent as $t_link) {
      $crumbstring = '<a href="' . $t_link['url'] . '">' . $t_link['name'] . '</a> <span class="spacer '.$t_crumbclass.'"></span> ' .$crumbstring;
    }
  }
                    # --------------------------------------------------------- *
                    # "auto_off" allows us to turn off auto and just use the    *
                    # parent crumb list in the array above                      *
  if (!isset($t_crumbs_auto_off)) {
    $t_currel = array_pop($t_path);
                    # test for default/index files, which would just duplicate  *
                    # the immediate parent directory link                       *
                    # the regex requires this be the end of the path            *
                    # the 7 character suffix allows for suffix and language     *
                    # e.g. - default.es.aspx                                    *
                    # if you don't use language suffixes, bump it down          *
                    # if you use output type infixes, bump it up                *
                    # e.g. - default.html.apsx                                  *
                    # if using dot separators in path names this can lead to    *
                    # more false positives as the suffix allowance is increased *
    $tf_regex   = '~(default|index)\..{2,7}$~i';
    if (preg_match($tf_regex, $t_currel)) {
      $t_skip = array_pop($t_path);
    }
    while (count($t_path) > 0) {
      $_include_this= true;
                    # don't need to test for file paths before adding slash     *
                    # because only directories are linked in the breadcrumbs    *
      $t_currpath   = implode('/',$t_path).'/';
      $t_currel     = array_pop($t_path);
                    # stop at top of site if not shared                         *
                    # otherwise path back to root                               *
                    # only relevant for subsite arrangements                    *
      if ((defined('SITE_SHARED')) && (SITE_SHARED !== true)) {
        if (strlen($t_currpath) < strlen($mpo_parts->site_base.MP_PSEP)) {
          $_include_this = false;
        } elseif ($t_currpath == $mpo_parts->site_base.MP_PSEP) {
          $t_currel   = 'home';
          $t_currpath = $mpo_parts->site_base.MP_PSEP;
          $t_path = array();
        }
                    # root will come up empty. point to home page w SITE_HOME   *
      } elseif (($t_currpath == '/') || ($t_currpath == '')) {
        $t_currel   = 'home';
        $t_currpath = SITE_HOME ?: '/';
                    # hide directories on path with no default index file       *
                    # using glob to address all suffix cases                    *
                    # if using dot separators in path names this can lead to    *
                    # false positives
      } else {
        $tf_dirpath = MP_ROOT.$t_currpath;
        $tf_idxlist = glob($tf_dirpath.'index.*');
        $tf_deflist = glob($tf_dirpath.'default.*');
        if ((is_dir( $tf_dirpath )) and (!(count($tf_idxlist) or count($tf_deflist)))) {
          $_include_this = false;
        }
        if (($t_currpath == SITE_HOME) OR ($t_currpath.'/' == SITE_HOME)) {
          $_include_this = false;
        }
      }

                    # clean up garbage characters in display string             *
                    # and force to lower case because IIS is always lowercase   *
                    # while most others are mixed case                          *
      if ($_include_this) {
        $t_currel = preg_replace('/\-([^\-])/', ' ${1}', $t_currel);
        $t_currel = preg_replace('/\- /', '-', $t_currel);
        $t_currel = preg_replace('/_/', ' ', $t_currel);
        $crumbstring = '<a href="' . $t_currpath . '">' . mb_strtolower($t_currel) . '</a> <span class="spacer '.$t_crumbclass.'"></span> ' .$crumbstring;
      }
    }
  }
  $mpo_parts->crumbs = $crumbstring;
?>
