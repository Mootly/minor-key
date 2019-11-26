<?php
/* === Password Hash Generator ================================================ *
 * copyright 2018 - Mootly Obviate
 * --- Revision History ------------------------------------------------------- *
 * 2018-05-01 | First build.
 * ---------------------------------------------------------------------------- */
                    # Kick out the unbelievers
if(empty($_POST)) { header('Location: ./'); }
                    # Call config to init the application                       *
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
#
# --- Receive our data -------------------------------------------------------- *
#
$formData     = $_POST;
$t_pwdhash    = password_hash($formData['password'], PASSWORD_DEFAULT);
# --- Generate the form to send ----------------------------------------------- *
#
ob_start();
?>
<style type="text/css">
  @media print {
    @page {
      margin: 1.0in;
    }
  #reply-box {
    background-color: rgb(255,255,255);
    margin: 1.0em auto;
    padding: 0;
    border: 1px solid rgb(32,36,37);
    position: relative;
    display: block;
  }
}
</style>
  <div id="reply-box">
    <p>The password <b><?= $formData['password']; ?></b> hashes to <b><?= $t_pwdhash; ?></b>
  </div>
<?php
$msgPrint = ob_get_clean();
ob_end_clean();
echo ($msgPrint);
?>
