<?php
/**
  * Demo homepage.
  *
  * @copyright 2017 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */
                    # Call config to inti the application --------------------- *
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
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

<div id="contents">
  <pre>
  <?php var_dump($mpo_parts); ?>
  </pre>

  <section>
    <figure>
      <!-- <video id="my_video_1" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="640" height="360" data-setup='{}'> -->
      <video controls="controls" style="width: 100%;" preload="metadata" aria-describedby="full-descript">
        <source type="video/mp4" src="/sites/vidtest/best-of-cb.mp4" />
        <track src="/sites/vidtest/best-of-cb.srt" kind="subtitles" srclang="en" label="English" />
      </video>
      <figcaption>
        <p>Having trouble viewing the video in your browser?<br />
        <a href="/sites/vidtest/best-of-cb.mp4">Open the video directly in your media player</a>.</p>
      </figcaption>
    </figure>
  </section>
</div>

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
