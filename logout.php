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
require_once( $mpo_paths->template.$mpo_parts->template.'/_assets/php_widgets/login/check.php' );
                    # Build the page ------------------------------------------ *
                    # Content developers shouldn't touch anything above here.
                    # ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ EDIT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                    # page_name should equal your H1 title.
$mpo_parts->page_name         = 'Logout';
$mpo_parts->h1_title          = 'Logout';
$mpo_parts->link_title        = 'Logout';
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Home';
$mpo_parts->accessibility     = 'standard';
$mpo_parts->pagemenu          = 'home.left';
$mpo_parts->login_path        = '/login.php';
$mpo_session                  = new mpc_sessions();

                    # The notices in the left bar go here.--------------------- *
ob_start();
?>

<?php
$mpo_parts->notices = ob_get_contents();
ob_end_clean();
                    # The main content body of the page goes here. ------------ *
ob_start();
?>
<form method="post" action="./logout.php" name="logout" id="form_logout" enctype="application/x-www-form-urlencoded" class="login">
  <fieldset form="form_login" name="loginForm" id="form_set_login">
<?php
                    # If NOT logged in ---------------------------------------- *
if ($mpo_parts->status == 'public') {
?>
    <legend>Logout</legend>
    <div class="form_directions directions">
      <p class="center"><strong>You are not logged in.</strong></p>
      <p class="center">Use the <a href="/login.php">login page</a> if you want to log in.</p>
    </div>
  </fieldset>
</form>
<?php
                    # If log out successful ----------------------------------- *
} elseif ((!empty($_POST)) and ($_POST['logout'] == 'Log Out')) {
  require_once( $mpo_paths->template.$mpo_parts->template.'/_assets/php_widgets/login/logout.php' );
?>
    <legend>Success!</legend>
    <div class="form_directions directions">
      <p class="center"><strong>You have successfully logged out!!!</strong></p>
      <p class="center">Please close this browser window to close this session or <a href="<?= $mpo_parts->login_path; ?>">log in</a> again.</p>
    </div>
  </fieldset>
</form>
<?php
                    # If logged in -------------------------------------------- *
} else {
?>
    <legend>Logout</legend>
    <div class="form_directions directions center">
      <p>To log out please select the button below.</p>
    </div>
    <div class="field_container">
      <p>
        <input form="form_logout" type="submit" name="logout" value="Log Out" class="bigBtn" id="form_field_submit"/>
      </p>
    </div>
<?php } ?>
  </fieldset>
</form>
<?php
$mpo_parts->main_content = ob_get_contents();
ob_end_clean();
$page_elements = $mpo_parts->build_page();
echo ($twig->render($mpo_parts->template.$mpt_form_template, array('page'=>$page_elements['content'])));
?>
