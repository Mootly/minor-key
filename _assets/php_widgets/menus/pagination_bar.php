<?php
/**
  * Create a pagination bar.
  *
  * Invoke after config and setting variables. Will build $mpo_parts->crumbs.
  * <div id="breadcrumb-box">
  *   <a href="link">label</a>
  *   <i class="fa fa-iconname"></i>
  *   ...
  *   <i class="fa fa-iconname"></i>
  *   <span class="position">Current Page</span>
  * </div>
  *
  * @copyright 2019 Mootly Obviate - See /LICENSE.md
  * @package   moosepress
  * --------------------------------------------------------------------------- */
  function paginate($tot_count, $per_page_count=32, $bar_style='default', $repeat_last=true, $add_dropdown = false, $add_firstlast= false) {
    ob_start();
                    # === BEGIN BAR =========================================== #
                    # === END BAR ============================================= #
    $page_bar = ob_get_clean();
    ob_end_clean();

    return $page_bar;
  }
?>
