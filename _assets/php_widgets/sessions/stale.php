<?php
/**
  * Form clear widget for session contention.
  *
  * Generate a query form to determne whether the current form should be reset
  * because of session contention.
  * After $_POST is set, it can be included or called with an AJAX call.
  *
  * Public Properties:
  * @var    string  $status             The reported status of the session.
  * @var    string  $reason             The reason it is stale.
  * @var    array   $session            Session variables to clear.
  *                                     'all' for full session clear.
  *
  * @copyright 2019 Mootly Obviate - See /LICENSE.md
  * @package   moosepress
  * --- Revision History ------------------------------------------------------- *
  * 2019-07-09 | Added revision log, cleaned code
  * --------------------------------------------------------------------------- */

function stale_session($status, $reason = 'form', $session = NULL) {
                    # --------------------------------------------------------- *
                    # Stale form notice --------------------------------------- *
  ob_start();
  ?>
  <div id="reply-notice">
    <div class="notice">
      <form method="get" action="<?= $_SERVER['PHP_SELF']; ?>" name="unstale" id="form_unstale">
        <fieldset form="form_unstale" name="unstale_btn" id="form_unstale_btn">
          <legend>This form is stale.</legend>
          <div class="form_directions directions">
            <p>This may be because you didn't log out of a previous session, a previous form submission was not completed properly, or the page was accidentally reloaded. For security and submission tracking purposes, this form cannot be edited when stale.</p>
            <p>To clear this form so it can be used, please reset the form.</p>
          </div>
          <div class="field_container">
            <input form="form_unstale" type="hidden" value="clear" name="clear_session" id="form_unstale_text">
            <p class="center fullWidth"><input form="form_unstale" type="submit" value="Reset Form" class="bigBtn" id="form_unstale_btn"></p>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
  <?php
  $msgStaleForm     = ob_get_clean();
  ob_end_clean();
                    # --------------------------------------------------------- *
                    # Stale session notice ------------------------------------ *
  ob_start();
  ?>
  <div id="reply-notice">
    <div class="notice">
      <form method="post" action="<?= $_SERVER['PHP_SELF']; ?>" name="unstale" id="form_unstale">
        <fieldset form="form_unstale" name="unstale_btn" id="form_unstale_btn">
          <legend>Your current login session is stale.</legend>
          <div class="form_directions directions">
            <p>For security purposes, this login session can no longer be used with this page.</p>
            <p>Please <a href="/logout.php">log out</a> and log back in again.</p>
          </div>
        </fieldset>
      </form>
      <p></p>
    </div>
  </div>
  <?php
  $msgStaleSession  = ob_get_clean();
  ob_end_clean();
                    # --------------------------------------------------------- *
                    # replies for stale sessions                                *
  if ($status == 'stale') {
    if ($reason == 'form') {
      return ($msgStaleForm);
    } elseif ($reason == 'session') {
      return ($msgStaleSEssion);
  }
                    # --------------------------------------------------------- *
                    # clear specifid session variables                          *
  } else if ($status == 'clear') {
    if ($session == 'all') {
      session_unset();
    } elseif (is_array($session)) {
      foreach ($session as $key => $tElem) { unset($_SESSION[$tElem]); }
    }
    unset($_SESSION['session_status']);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
  }
}
?>
