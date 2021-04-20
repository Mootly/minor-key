<?php
/**
  * Demo logout page.
  *
  * @copyright 2018 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */
                    # Call config to inti the application --------------------- *
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
require_once( $mpo_paths->template.$mpo_parts->template.'/db_config.php' );
                    # Build the page ------------------------------------------ *
                    # Content developers shouldn't touch anything above here.
                    # ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ EDIT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                    # page_name should equal your H1 title.
$mpo_parts->page_name         = 'Login';
$mpo_parts->h1_title          = 'Login';
$mpo_parts->link_title        = 'Login';
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Forms';
$mpo_parts->accessibility     = 'standard';
$mpo_parts->pagemenu          = 'home.left';
$mpo_parts->login_path        = '/login.php';
$mpo_parts->login_message     = '<p>Please login to access online fillable forms.</p>';

require_once( $mpo_paths->template.$mpo_parts->template.'/_assets/php_widgets/login/check.php' );

ob_start();
                    # The notices in the left bar go here.--------------------- *
?>
<?php
$mpo_parts->notices = ob_get_contents();
ob_end_clean();
ob_start();
                    # The main content body of the page goes here. ------------ *
?>
<?php
$mpo_parts->main_content = ob_get_contents();
ob_end_clean();

$page_elements = $mpo_parts->build_page();
echo ($twig->render($mpo_parts->template.$mpt_form_template, array('page'=>$page_elements['content'])));
?>
