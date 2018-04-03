<?php
/**
  * Demo logout page.
  *
  * @copyright 2018 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */
                    # Call config to inti the application --------------------- *
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
require_once( $mpo_paths->template.'/db_config.php' );
require_once( $mpo_paths->template.'/_assets/php_widgets/login_check.php' );
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
$mpo_parts->login_path        = './login.php';
$mpo_parts->login_message     = '<p>Please login to access online fillable forms.</p>';

                    # Check for form data, process. --------------------------- *
if ($mpo_parts->status == 'verified') {
  $mpo_parts->login_path    = 'success';
  $mpo_parts->login_message = '<p class="center">You are already logged in as <b>'.$_SESSION['group'].'</b>. If this is not you, please <a href="/logout.php">logout</a>.</p>';
} else if (!empty($_POST)) {
  $mpo_user         = new mpc_db('sqlsrv', $db_login);
  $p_user           = htmlspecialchars($_POST['userid']);
  $p_pass           = htmlspecialchars($_POST['password']);
  $sql              = 'select password from dbo.ref_audience where audience_key = ? collate Latin1_General_BIN';
  $params           = array($p_user);
  $options          = array('Scrollable' => SQLSRV_CURSOR_KEYSET);
  $results          = $mpo_user->runquery($sql, $params, $options);
  $tCheck           = password_verify($p_pass, $results[0]['password']);
  if($tCheck == true) {
    $mpo_parts->login_path    = 'success';
    $mpo_parts->status        = 'verified';
    if (!empty($_SESSION['return_page'])) {
      $mpo_parts->login_message = '<p class="center">Return to your <a href="'.$_SESSION['return_page'].'">previous page</a>.</p>';
      unset($_SESSION['return_page']);
  } else {
      $mpo_parts->login_message = '';
    }
    $_SESSION['group'] = $p_user;
    $_SESSION['last_activity'] = $tTime;
  } else {
    $mpo_parts->login_message = '<p class="wrong-box center">The user ID or password was not correct.</p>';
  }
}
ob_start();
                    # The notices in the left bar go here.--------------------- *
?>
<?php
$mpo_parts->notices = ob_get_clean();
ob_end_clean();
ob_start();
                    # The main content body of the page goes here. ------------ *
?>
<?php
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
$page_elements = $mpo_parts->build_page();
echo ($twig->render($mpt_form_template, array('page'=>$page_elements['content'])));
?>
