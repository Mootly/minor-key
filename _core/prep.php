<?php
/**
  * Any code specific to prepping the system to return Web pages goes here..
  *
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */

# Init Twig ------------------------------------------------------------------- *
# Comment out the debug lines for production.
# Debug is used with <pre>{{ dump(var) }}<pre> to dump variables out

  $loader = new Twig_Loader_Filesystem($mko_paths->template);
  $twig   = new Twig_Environment($loader, array(
//    'debug' => true
  ));
//  $twig->addExtension(new Twig_Extension_Debug());

// end include file ----------------------------------------------------------- *
