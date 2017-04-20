<?php
/** --------------------------------------------------------------------------- *
  * This is the init script for the Minor Key application.
  *
  * Component separation and processing order:
  * - request evaluation and computation:
  *   1. init - Initialize core.
  *   2. grab - Retrieve requests and accompanying data.
  *   3. proc - Process request data and gather response data.
  * - response assembly and presentation
  *   4. prep - Use the template to prepare response for presentation.
  *   5. send - Send response.
  * All core code has been written with this unidirectional flow.
  * This is enforced by encapsulation and an expection that a particular
  * type of object will be passed each step of the way.
  *
  * Naming conventions
  * The following prefixes are reserved for use by core code.
  * - MCO_    - constants
  * - mc_     - class definitions
  * - mo_     - object instances
  * - mv_     - variables
  * - mf_     - functions
  * - mpre_   - user defined function to run before a function of the same name
  * - mpost_  - user defined function to run after a function of the same name
  *
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */

/** --------------------------------------------------------------------------- *
  * Application presets.
  */
  define('MCO_PSEP', '/');
  define('MCO__DIR__', dirname(__FILE__,2));

/** --------------------------------------------------------------------------- *
  * Set our core paths
  *.
  * Class lives here because it has to be called before the script
  * knows where our object library is.
  * We use an array masquerading as properties because cleaner code.
  *
  * Public Properties:
  *   None.
  * Methods:
  * @method bool    __construct(bool)
  *   On instantiation, can be passed boolean to determine whether
  *   to protect existing values.
  * @method string  __get(string)
  *   Return valeus from an array of pseudoproperties.
  * @method bool    __set(string, string)
  *   Add pseudoproperties to array with assigned values.
  * --------------------------------------------------------------------------- */
  class mc_paths {
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
// ***** End cd_paths                                                           *
  if (!isset($mo_paths)) { $mo_paths = new mc_paths(true); }
  $mo_paths->classlib = MCO__DIR__ . '/m_core/class_lib';
  $mo_paths->core     = MCO__DIR__ . '/m_core';
  $mo_paths->vendor   = MCO__DIR__ . '/vendor';
  if(defined('DEF_TEMPLATE')) {
    $mo_paths->template = MCO__DIR__ . DEF_TEMPLATE .'/' ;

  } elseif (defined('DEF_PREFIX')) {
    $mo_paths->template = MCO__DIR__ . '/templates/'. DEF_PREFIX .'/' ;

  } else {
    $mo_paths->template = MCO__DIR__ . '/templates/minorkey/' ;
  }
/** --------------------------------------------------------------------------- *
  * Tell PHP where our class library is.
  */
  function __autoload($classname) {
    include $mo_paths->classlib . MCO_PSEP . strtolower($classname) . '.php';
  }

/** --------------------------------------------------------------------------- *
  *Load any components needed by third party modules.
  */
  require_once( $mo_paths->vendor . '/autoload.php' );

/** --------------------------------------------------------------------------- *
  *Load the Minor Key processing environment.
  */
  require_once( $mo_paths->core   . '/grab.php' );
  require_once( $mo_paths->core   . '/proc.php' );

/** --------------------------------------------------------------------------- *
  *Load the master templating module.
  */
  if ( (isset($_REQUEST['async'])) AND ($_REQUEST['async'] == true) ) {
   require_once( $mo_paths->core . '/async_prep.php' );
  } else {
   require_once( $mo_paths->core . '/prep.php' );
  }
?>
