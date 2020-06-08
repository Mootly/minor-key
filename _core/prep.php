<?php
/**
  * Any code specific to prepping the system to return Web pages goes here..
  *
  * @copyright 2017 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */

# Init Twig ------------------------------------------------------------------- *
# Comment out the debug lines for production.
# Debug is used with <pre>{{ dump(var) }}<pre> to dump variables out
  $loader = new Twig_Loader_Filesystem($mpo_paths->template);
  $twig   = new Twig_Environment($loader, array(
   // 'debug' => true
  ));
 // $twig->addExtension(new Twig_Extension_Debug());
// https://stackoverflow.com/questions/18678522/how-can-i-minify-html-with-twig
// end include file ----------------------------------------------------------- *
