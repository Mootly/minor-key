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
  * --------------------------------------------------------------------------- */
                    # Receive our data ---------------------------------------- *

function stale_session($status, $reason = 'form', $session = NULL) {
  ob_start();
  ?>
  <div id="reply-notice">
    <div class="notice">
      <p>This form is stale.</p>
      <p>This may be because a previous form submission was not completed properly or the page was accidentally reloaded. To clear this form so it can be used, please select the button below.</p>
    </div>
  </div>

  <?php
  $msgStaleForm     = ob_get_clean();
  ob_end_clean();
  ob_start();
  ?>
  <div id="reply-notice">
    <div class="notice">
      <p>Your current login session is stale.</p>
      <p>Please log out and log back in again.</p>

    </div>
  </div>
  <?php
  $msgStaleSession  = ob_get_clean();
  ob_end_clean();
                    # replies for stale sessions                                *
  if ($status == 'stale') {
    if ($reason == 'form') {
      return ($msgStaleForm);
    } elseif ($reason == 'session') {
      return ($msgStaleSEssion);
  }
                    # clear specifid session variables                          *
  } else if ($status == 'clear') {
    if ($session == 'all') {
      session_unset();
    } elseif (is_array($session)) {
      foreach ($session as $key => $tElem) { unset($_SESSION[$tElem]); }
    }
  }
}

?>
