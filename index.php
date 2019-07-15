<?php
/**
  * Demo homepage.
  *
  * @copyright 2017 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */
                    # Call config to inti the application --------------------- *
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
$mpo_paginator = new mpc_paginate_bar();
$t_count = 700;
$t_params['type']       = 'get';
$t_params['per_page']   = 32;
$t_params['curr_page']  = 5;
$t_params['direction']  = 'desc';
$t_params['max_run']    = 5;
$t_params['firstlast']  = true;
$t_params['overlap']    = true;
$t_params['compress']   = true;
$t_result = $mpo_paginator->setposition($t_count, $t_params);
$t_result = $mpo_paginator->makebar();
$t_result = $mpo_paginator->getbar();
                    # Build the page ------------------------------------------ *
                    # Content developers shouldn't touch anything above here.
                    # ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ EDIT VARIABLES BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                    # page_name should equal your H1 title.
$mpo_parts->page_name     = 'Hello!';
$mpo_parts->h1_title      = 'Test Page';
$mpo_parts->link_title    = 'Home';
$mpo_parts->page_name     = $mpo_parts->h1_title;
$mpo_parts->section_name  = 'Home';
$mpo_parts->section_base  = '/';
$mpo_parts->accessibility = 'standard';
$mpo_parts->bodyclasses   = 'final';
// $mpo_parts->pagemenu = 'docs.general';
require_once( $mpo_paths->php_widgets.'menus/simple_crumbs.php' );
require_once( $mpo_paths->php_widgets.'/video_components.php' );
                    # The main content body of the page is developed here.      *
                    # You can iterate across the two ob_ functions to create    *
                    # more page parts.                                          *
                    # Each part must be defined in the receiving template       *
                    # to be used.                                               *
ob_start();
                    # ↓↓↓ EDIT CONTENT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ ***
?>

<div class="sunset"></div>

  <pre>
  <?php var_dump(htmlspecialchars($t_result)); ?>
  </pre>

  <?php echo($t_result); ?>
<?php
                    # ↑↑↑ EDIT CONTENT ABOVE ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ ***
$mpo_parts->accessibility = 'standard';
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
$page_elements = $mpo_parts->build_page();
$page_scripts  = $mpo_scripts->build_list();
$page_styles   = $mpo_styles->build_list();
echo ($twig->render($mpo_parts->template.$mpt_full_template, array('page'=>$page_elements['content'], 'scripts'=>$page_scripts, 'styles'=>$page_styles)));
?>
