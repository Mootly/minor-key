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
  if (!isset($mpo_styles))  { $mpo_styles = new mpc_paths(); }
  $mpo_styles->mediashim    = '/_vendors/ghinda/shim.css';
  $mpo_styles->mediabase    = '/_vendors/ghinda/acornmediaplayer/acornmediaplayer.base.css';
  $mpo_styles->mediatheme   = '/_vendors/ghinda/acornmediaplayer/themes/access/acorn.access.css';
  if (!isset($mpo_scripts))  { $mpo_scripts = new mpc_paths(); }
  $mpo_scripts->customui    = '/_vendors/jquery/jquery-ui.min.js';
  $mpo_scripts->mediaplayer = '/_vendors/ghinda/acornmediaplayer/jquery.acornmediaplayer.js';
  $mpo_scripts->mediatrigger= '/_vendors/ghinda/trigger.js';
?>
