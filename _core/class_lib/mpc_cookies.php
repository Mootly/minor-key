<?php
/**
  * Set our cookies
  *
  * We use an array to be encoded as a JSON blob in the cookie.
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
  * @method hash    read()
  *   Returns an associative array of cookie values.
  * @method string  build()
  *   Returns a JSON string for the cookie.
  * @method bool    write()
  *   Writes the cookie to standard IO.
  * @copyright 2018 Mootly Obviate
  * @package   moosepress
  * --- Revision History ------------------------------------------------------ *
  * 2019-07-09 | Added revision log, cleaned code
  * --------------------------------------------------------------------------- */
class mpc_cookies {
  protected $is_locked;
  protected $cookieset = array();
# *** END - property assignments ---------------------------------------------- *
#
# *** BEGIN constructor ------------------------------------------------------- *
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
# *** END - constructor ------------------------------------------------------- *
#
# *** BEGIN __get ------------------------------------------------------------- *
/**
  * Return the value of asset path.
  * @param  string $property The pseudoproperty name.
  * @return string
  */
  public function __get($property) {
    return $this->cookieset[$property];
  }
# *** END - __get ------------------------------------------------------------- *
#
# *** BEGIN __set ------------------------------------------------------------- *
/**
  * Set a pseudo property to a value.
  * If instance is locked, only allow new properties.
  * @param  string $property  The pseudoproperty name.
  * @param  string $value     The value to be assigned.
  * @return bool
  */
  public function __set($property, $value) {
    if ($this->is_locked) {
      $this->cookieset[$property] = $this->cookieset[$property] ?? $value;
    }else {
      $this->cookieset[$property] = $value;
    }
    return true;
  }
# *** END - __set ------------------------------------------------------------- *
#
# *** BEGIN read -------------------------------------------------------------- *
/**
  * Returns an associative array of paths.
  * @return hash
  */
  public function read() {
    return $this->cookieset;
  }
# *** END - read -------------------------------------------------------------- *
#
# *** BEGIN build ------------------------------------------------------------- *
/**
  * Build our cookie string.
  * @return
  */
  public function build() {
    return true;
  }
# *** END - build ------------------------------------------------------------- *
#
# *** BEGIN write ------------------------------------------------------------- *
/**
  * Write our cookie string.
  * @return
  */
  public function write() {
    return true;
  }
# *** END - write ------------------------------------------------------------- *
}
// End mpc_cookies ------------------------------------------------------------ *
