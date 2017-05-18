<?php
/**
  * Set our content elements
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
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */
  class mkc_parts {
    protected $is_locked;
    protected $component    = array();
    public $title_struct = ['page_name','section_name','site_name'];
    public $separator = ' | ';
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
      * Return the value of a pseudo property.
      * @param  string $property The pseudoproperty name.
      * @return string
      */
    // Return the value of a set component.
    public function __get($property) {
      return $this->component[$property];
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
        $this->component[$property] = $this->component[$property] ?? $value;
      }else {
        $this->component[$property] = $value;
      }
      return true;
    }
  }
// End mkc_parts -------------------------------------------------------------- *
