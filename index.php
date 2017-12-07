<?php
/**
 * This is the root page for the Minor Key application. Everything hangs off it.
 *
 * This page handles three tasks and three tasks only:
 *  - Defining top level constants that should not be the same across installations.
 *  - Importing the three processing modules:
 *     - init
 *     - grab
 *     - proc
 *  - Importing the master template module.
 * It should not contain any other code.
 *
 * The component separation is deliberate and is meant to enforce a specific sequence of steps.
 * A request is received from the client and the following steps occur:
 *  - request evaluation and computation:
 *    1. init - Core in initialized.
 *    2. grab - Request and accompanying data are retrieved.
 *    3. proc - Request data is processed and response data assembled.
 *  - response assembly and presentation
 *    4. prep - Response is prepared for presentation.
 *    5. send - Response is sent.
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
require( dirname( __FILE__ ) . '/m_core/init.php' );
require( dirname( __FILE__ ) . '/m_core/grab.php' );
require( dirname( __FILE__ ) . '/m_core/proc.php' );

/* ---------------------------------------------------------
 *Load the master template module.
 */
if ( $_GET['async'] == true ) {
  require( dirname( __FILE__ ) . '/m_core/async_prep.php' );
} else {
  require( dirname( __FILE__ ) . '/m_core/prep.php' );
}

?>
