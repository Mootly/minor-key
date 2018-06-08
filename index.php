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
$mpo_parts->accessibility = 'standard';
$mpo_parts->bodyclasses   = 'final';
// $mpo_parts->pagemenu = 'docs.general';
require_once( $mpo_paths->php_widgets.'menus/simple_crumbs.php' );
$mpo_styles               = new mpc_paths();
$mpo_styles->mediashim    = 'https://afarkas.github.io/webshim/js-webshim/minified/shims/styles/shim.css';
$mpo_styles->mediabase    = '/_vendors/ghinda/acornmediaplayer/acornmediaplayer.base.css';
$mpo_styles->mediatheme   = '/_vendors/ghinda/acornmediaplayer/themes/access/acorn.access.css';
$mpo_scripts              = new mpc_paths();
$mpo_scripts->customui    = '/_vendors/jquery/jquery-ui.min.js';
$mpo_scripts->mediaplayer = '/_vendors/ghinda/acornmediaplayer/jquery.acornmediaplayer.js';
$mpo_scripts->mediatrigger= '/_vendors/ghinda/trigger.js';
                    # The main content body of the page is developed here.      *
                    # You can iterate across the two ob_ functions to create    *
                    # more page parts.                                          *
                    # Each part must be defined in the receiving template       *
                    # to be used.                                               *
ob_start();
                    # ↓↓↓ EDIT CONTENT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ ***
?>

<section>
  <figure>
    <video controls="controls" style="width: 100%;" poster="/_assets/testvid/images/tos-poster.jpg" preload="metadata" aria-describedby="full-descript">
      <source type="video/webm" src="/_assets/testvid/tears_of_steel.webm" />
      <!-- <source type="video/mp4" src="https://acornmedia.herokuapp.com/media/tears_of_steel_480.mp4" /> -->

      <track src="/_assets/testvid/subs/TOS-arabic.srt" kind="subtitles" srclang="ar" label="Arabic" />
      <track src="/_assets/testvid/subs/TOS-japanese.srt" kind="subtitles" srclang="jp" label="Japanese" />
      <track src="/_assets/testvid/subs/TOS-english.srt" kind="subtitles" srclang="en" label="English" />
      <track src="/_assets/testvid/subs/TOS-turkish.srt" kind="subtitles" srclang="tr" label="Turkish" />
      <track src="/_assets/testvid/subs/TOS-ukrainian.srt" kind="subtitles" srclang="uk" label="Ukrainian" />

      You can download Tears of Steel at <a href="http://mango.blender.org/">mango.blender.org</a>.
    </video>
    <figcaption id="full-descript">
      <p><em>"Tears of Steel"</em> was realized with crowd-funding by users of the open source 3D creation tool <a href="http://www.blender.org">Blender</a>. Target was to improve and test a complete open and free pipeline for visual effects in film - and to make a compelling sci-fi film in Amsterdam, the Netherlands. </p>
      <p>(CC) Blender Foundation - <a href="http://www.tearsofsteel.org">http://www.tearsofsteel.org</a></p>
    </figcaption>
  </figure>
</section>

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
