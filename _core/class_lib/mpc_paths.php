<?php
/**
  * Set our core paths
  *
  * We use an array masquerading as properties because cleaner code.
  *
  * Public Properties:
  *   None.
  * Methods:
  * @method bool    __construct(bool)
  *   On instantiation, can be passed boolean to determine whether
  *   to protect existing values.
  * @method string  __get(string)
  *   Return values from an array of pseudoproperties.
  * @method bool    __set(string, string)
  *   Add pseudo-properties to array with assigned values.
  * @method hash    build_list()
  *   Returns an associative array of paths.
  * @copyright 2017 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */
  class mpc_paths {
    protected $is_locked;
    protected $path = array();
                    /**
                      * Constructor
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
                      * Return the value of asset path.
                      * @param  string $property The pseudoproperty name.
                      * @return string
                      */
    public function __get($property) {
      return $this->path[$property];
    }
                    /**
                      * Set a pseudo property to a value.
                      * If instance is locked, only allow new properties.
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
                    /**
                      * Returns an associative array of paths.
                      * @return hash
                      */
    public function build_list() {
      return $this->path;
    }

  }
// End mpc_paths -------------------------------------------------------------- *
