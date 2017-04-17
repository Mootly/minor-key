<?php
/**
  * This is the init script for the Minor Key application. Everything starts here.
  *
  * This page handles three tasks and three tasks only:
  *  - Define top level constants that vary by installations.
  *  - Import three processing modules:
  *  - Importing the master template module.
  * It should not contain any other code.
  *
  * The component separation is deliberate and is meant to enforce a specific sequence of steps.
  * A request is received from the client and the following steps occur:
  *  - request evaluation and computation:
  *    1. init - Initialize core.
  *    2. grab - Retrieve requests and accompanying data.
  *    3. proc - Process request data and gather response data.
  *  - response assembly and presentation
  *    4. prep - Use the template to prepare response for presentation.
  *    5. send - Send response.
  *
  *  All core code has been written with this undirectional flow.
  *  This is enforced by encapsulation and an expection that a particular type of object will be passed each step of the way.
  *
  * https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/
  * https://github.com/phpDocumentor/fig-standards/blob/master/proposed/phpdoc.md
  * https://en.wikipedia.org/wiki/PHPDoc
  * https://www.drupal.org/node/1354
  * https://css-tricks.com/sass-style-guide/
  *
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  *
  */

/** ---------------------------------------------------------
  * Application presets.
  */
define('MC_PSEP', '/');
define('MC__DIR__', dirname(__FILE__,2));

/** --------------------------------------------------------
  * Set our core paths.
  */
if (!isset($mc_paths)) { $mc_paths = array(); }
$mc_paths['classlib'] = $mc_paths['classlib'] ?? MC__DIR__ . '/m_core/class_lib';
$mc_paths['core']     = $mc_paths['core']     ?? MC__DIR__ . '/m_core';
$mc_paths['vendor']   = $mc_paths['vendor']   ?? MC__DIR__ . '/vendor';

/** --------------------------------------------------------
  * Tell PHP where our class library is.
  */
function __autoload($classname) {
  include $mc_paths['classlib'] . MC_PSEP . strtolower($classname) . '.php';
}

/* ---------------------------------------------------------
 *Load the Minor Key processing environment.
 */
require_once( $mc_paths['vendor'] . '/autoload.php' );
require_once( $mc_paths['core']   . '/grab.php' );
require_once( $mc_paths['core']   . '/proc.php' );

/* ---------------------------------------------------------
 *Load the master template module.
 */
 if ( (isset($_REQUEST['async'])) AND ($_REQUEST['async'] == true) ) {
   require_once( $mc_paths['core'] . '/async_prep.php' );
 } else {
   require_once( $mc_paths['core'] . '/prep.php' );
 }

?>
