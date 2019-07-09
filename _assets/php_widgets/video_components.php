<?php
/**
  * List of components for vidoe includes so we just need one in the page.
  *
  * @copyright 2018 Mootly Obviate - See /LICENSE.md
  * @package   moosepress
  * --- Revision History ------------------------------------------------------ *
  * 2019-07-09 | Added revision log, cleaned code
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
