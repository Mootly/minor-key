<?php
/**
  * Any generic for triggering templates goes here.
  *
  * @copyright 2019 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */

# Submit to Template ---------------------------------------------------------- *
function mpf_renderPage($page_template, $mpo_parts, $mpo_scripts = false, $mpo_styles = fase) {
  global $twig;
  $page_elements    = $mpo_parts->build_page();
  $page_scripts     = '';
  $page_styles      = '';
  $template_array   = array();
  $template_array['page'] = $page_elements['content'];
  if (class_exists('mpo_scripts', false)) {
    $template_array['scripts'] = $mpo_scripts->build_list();
  }
  if (class_exists('mpo_styles', false)) {
    $template_array['styles'] = $mpo_style->build_list();
  }
  echo($twig->render($page_template, $template_array));
}
// end include file ----------------------------------------------------------- *
