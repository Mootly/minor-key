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
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  *
  */

/** --------------------------------------------------------------------------- *
  * Application presets.
  */
  define('MC_PSEP', '/');
  define('MC__DIR__', dirname(__FILE__,2));

/** --------------------------------------------------------------------------- *
  * Set our core paths
  *.
  * This uses an array masquerading as properties because cleaner code.
  * This lives here because it has to be called before the script knows where
  * our object library is.
  *
  * Public Properties:
  *   None.
  * Methods:
  * @method bool    __construct(bool)
  *   On instantiation, can be passed boolean to determine whether to protecte
  *   existing values.
  * @method string  __get(string)
  *   Return valeus from an array of pseudoproperties.
  * @method bool    __set(string, string)
  *   Add pseudoproperties to array with assigned values.
  */
  class cd_paths {
    protected $is_locked;
    protected $path = array();
    /**
      * If we lock the instance, values can be added but not changed.
      * To lock a path set, instantiate with true.
      * @param  bool $prot Are items locked from updating.
      * @return bool
      */
    public function __construct($prot=false) {
      $this->is_locked = $prot;
      return true;
    }
    /**
      * Return the value of a property.
      * @param  string $property The pseudoproperty name.
      * @return string
      */
    // Return the value of a set path.
    public function __get($property) {
      return $this->path[$property];
    }
    /**
      * Set a pseudo property to a value.
      * If instance is locked, only allow new properties,
      * not updates.
      * @param  string $property  The pseudoproperty name.
      * @param  string $value     The value to be assigned.
      * @return bool
      */
    public function __set($property, $value) {
      if ($this->is_locked) {
        $this->path[$property] = $this->path[$property] ?? $value;
      }else {
        $this->path[$property] = $value;
      }
      return true;
    }
  }
  if (!isset($mc_paths)) { $mc_paths = new cd_paths(true); }
  $mc_paths->classlib = MC__DIR__ . '/m_core/class_lib';
  $mc_paths->core     = MC__DIR__ . '/m_core';
  $mc_paths->vendor   = MC__DIR__ . '/vendor';
/** --------------------------------------------------------------------------- *
  * Tell PHP where our class library is.
  */
  function __autoload($classname) {
    include $mc_paths->classlib . MC_PSEP . strtolower($classname) . '.php';
  }

/** --------------------------------------------------------------------------- *
  *Load the Minor Key processing environment.
  */
  require_once( $mc_paths->vendor . '/autoload.php' );
  require_once( $mc_paths->core   . '/grab.php' );
  require_once( $mc_paths->core   . '/proc.php' );

/** --------------------------------------------------------
  *Load the master template module.
  */
  if ( (isset($_REQUEST['async'])) AND ($_REQUEST['async'] == true) ) {
   require_once( $mc_paths->core . '/async_prep.php' );
  } else {
   require_once( $mc_paths->core . '/prep.php' );
  }
?>
