<?php
/**
  * Demo homepage.
  *
  * @copyright 2017 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */
                    # Call config to inti the application --------------------- *
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
// $mpo_paginator = new mpc_paginate_bar();
$t_count = 700;
$t_params['type']       = 'get';
$t_params['per_page']   = 32;
$t_params['curr_page']  = 5;
$t_params['direction']  = 'desc';
$t_params['max_run']    = 5;
$t_params['firstlast']  = true;
$t_params['overlap']    = true;
$t_params['compress']   = true;
// $t_result = $mpo_paginator->setposition($t_count, $t_params);
// $t_result = $mpo_paginator->makebar();
// $t_result = $mpo_paginator->getbar();
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
// require_once( $mpo_paths->php_widgets.'/video_components.php' );
                    # The main content body of the page is developed here.      *
                    # You can iterate across the two ob_ functions to create    *
                    # more page parts.                                          *
                    # Each part must be defined in the receiving template       *
                    # to be used.                                               *
ob_start();
?>
<p class="para">This is a <b>Test</b>!</p>
<p class="para">This is only a <b>Test</b>!</p>
<p class="para">This is still a <b>Test</b>!</p>
<p class="para2">This is still a <b>Test</b>!</p>
<?php
$passRaw    = false;
$keepCR     = true;
$keepHTML   = true;
?>
<pre>
<script>
z = document.querySelectorAll('.para2')
console.log(z);
x = document.querySelectorAll('.para')
console.log(x);
y = [];
x.forEach ((ElC, key) => { y[key]  = ElC.getBoundingClientRect().top; });
console.log(y);

</script>
</pre>

<div class="sunset"></div>

<script type="text/javascript">
// *** BRAIN CLEANING EXERCISES
// *** FIZZBUZZ
// for (x=1;x<=100;x++) console.log((x%3?'':'fizz')+(x%5?'':'buzz')||x);

let   el_topLinkDiv       =  document.createElement('div');
      el_topLinkDiv.className = 'top-link';
let   el_topLinkA         =  document.createElement('a');
      el_topLinkA.title   = 'Back to Top';
      el_topLinkA.href    = '#top';
      el_topLinkA.innerHTML = '<span>[top]</span>';
      el_topLinkDiv.appendChild(el_topLinkA);
let   v_tocList = document.querySelector('.sunset');
v_tocList.appendChild(el_topLinkDiv);
let   el_tocLinkList       =  document.createElement('ul');
      el_tocLinkList.className = 'jumpto';
      // c_tocTarget.parentNode.insertBefore(el_topLinkDiv, c_tocTarget.nextSibling);
      v_tocList.parentNode.insertBefore(el_tocLinkList, v_tocList.nextSibling);

</script>
<!-- *** end contents ********************************************************* -->
<?php
                    # ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ EDIT ABOVE ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
                    # Content developers shouldn't touch anything below here.
$mpo_parts->main_content = ob_get_contents();
ob_end_clean();

                      // Submit to template generator --------------------------- *
mpf_renderPage($mpo_parts->template.$mpt_['default'].$mpt_['suffix'], $mpo_parts);
?>
