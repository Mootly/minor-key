<?php
/**
  * Send to template routine
  * Any generic code for triggering templates goes here.
  *
  * @copyright 2019 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */

# Submit to Template ---------------------------------------------------------- *
                    // pass in template and content since they are required     *
                    // pull in twig and any optional variables as globals       *
                    // currently only mpo_scripts and mpo_styles                *
function mpf_renderPage($page_template, $mpo_parts) {
  global $twig;
  global $mpo_scripts;
  global $mpo_styles;
  $page_elements    = $mpo_parts->build_page();
  $template_array   = array();
  $template_array['page'] = $page_elements['content'];
  if ($mpo_scripts) {
    $template_array['scripts'] = $mpo_scripts->build_list();
  }
  if ($mpo_styles) {
    $template_array['styles'] = $mpo_styles->build_list();
  }
  echo($twig->render($page_template, $template_array));
}
// end ------------------------------------------------------------------------ *
