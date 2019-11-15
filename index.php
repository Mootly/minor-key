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
    <?php var_dump(htmlspecialchars(strip_tags("https://ocfs.ny.gov/main/childcare/news/index.php?\"><script>_q_q=')('</script>&page=7"), ENT_QUOTES | ENT_HTML5, 'UTF-8')); ?>
    <?php var_dump(htmlspecialchars(strip_tags("https://ocfs.ny.gov/main/childcare/news/index.php?\"><script>_q_q=')('</script>&page=7"), ENT_QUOTES | ENT_HTML5, 'UTF-8')); ?>
    <?php var_dump(htmlspecialchars(strip_tags('https://ocfs.ny.gov/main/childcare/news/index.php?%22%3e%3cqss%3e=&page=7'), ENT_QUOTES | ENT_HTML5, 'UTF-8')); ?>
    <?php var_dump($_SERVER['ORIG_PATH_INFO']); ?>
    <?php var_dump($_SERVER['PATH_INFO']); ?>
    <?php var_dump($_SERVER['PHP_SELF']); ?>
    <?php var_dump($_SERVER['SCRIPT_NAME']); ?>
    <?php var_dump($_SERVER['URL']); ?>
    <?php var_dump(htmlspecialchars($t_result)); ?>
  </pre>

<?php echo($t_result); ?>

<script type="text/javascript">
let hashy = '#';
for (x=1; x<=7; x++) {
  console.log(hashy.repeat(x));
}
// for (x=1;x<=100;x++) console.log((x%3?'':'fizz')+(x%5?'':'buzz')||x);
let sqsz = 11;
let sqblock = 'X';
let sqblank = ' ';
let thiscol = sqblock;
let thisset = '';
for (x=0; x<sqsz; x++) {
  let thisrow = thiscol;
  thisset = '';
  for (y=0; y<sqsz; y++) {
    thisrow = thisrow == sqblock ? sqblank : sqblock;
    thisset = thisset + thisrow;
  }
  console.log(thisset);
  thiscol = thiscol == sqblock ? sqblank : sqblock;
}

</script>
<!-- *** end contents ********************************************************* -->
<?php
                    # ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ EDIT ABOVE ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
                    # Content developers shouldn't touch anything below here.
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
                      // Submit to template generator --------------------------- *
mpf_renderPage($mpo_parts->template.$mpt_['default'].$mpt_['suffix'], $mpo_parts);
?>
