<?php
/**
 * This is the root page for the Minor Key application. Everything hangs off it.
 *
 * This page handles three tasks and three tasks only:
 *  - Define top level constants that vary by installations.
 *  - Import the three processing modules:
 *     - init
 *     - grab
 *     - proc
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
 * @copyright 2016 Mootly Obviate
 * @package   minor_key
 *
 */

/* ---------------------------------------------------------
 * Application presets.
 */
define('SOME_CONSTANT', true);

/* ---------------------------------------------------------
 *Load the Minor Key processing environment.
 */
require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
require_once( dirname( __FILE__ ) . '/m_core/init.php' );
require_once( dirname( __FILE__ ) . '/m_core/grab.php' );
require_once( dirname( __FILE__ ) . '/m_core/proc.php' );

/* ---------------------------------------------------------
 *Load the master template module.
 */
if ( (isset($_REQUEST['async'])) AND ($_REQUEST['async'] == true) ) {
  require_once( dirname( __FILE__ ) . '/m_core/async_prep.php' );
} else {
  require_once( dirname( __FILE__ ) . '/m_core/prep.php' );
}

$loader = new Twig_Loader_Array(array(
    'index' => 'Hello {{ name }}!',
));
$twig = new Twig_Environment($loader);

echo $twig->render('index', array('name' => 'Fabien'));
?>
