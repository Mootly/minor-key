<?php
/**
  * Data cleaner for form data. Also accepts individual values.
  *
  * We use an array masquerading as properties because cleaner code.
  *
  * Public Properties:
  *   None.
  * Methods:
  * @method bool    __construct(hash)
  *   On instantiation, passed an associative array of values to be sanitized.
  *   If the array is omitted, use __set to populate.
  * @method string  __get(string)
  *   Return default sanitized values from an array of pseudoproperties.
  * @method bool    __set(string, string)
  *   Add pseudo-properties to array with assigned values.
  * @method string    get_as(string, string [, string])
  *   Returns values sanitized as specified.
  * @method string    clean_url(string, string [, string])
  *   Returns a santized copy of the current URL.
  * @method string    lock()
  *   Locks existing values from being overwritten. Lock is on by default.
  * @method string    unlock()
  *   Unlocks existing values so they can be being overwritten.
  * @copyright 2019 Mootly Obviate
  * @package   moosepress
  * --- Revision History ------------------------------------------------------ *
  * 2019-08-02 | Created.
  * --------------------------------------------------------------------------- */
class mpc_datacleaner {
  protected $is_locked;
  protected $value = array();
  protected $clean = array();
# *** END - property assignments ---------------------------------------------- *
#
# *** BEGIN constructor ------------------------------------------------------- *
/**
  * Constructor
  * If we lock the instance, values can be added but not changed.
  * To lock a path set, call obj->lock() after instantiation.
  * @param  hash    $values             Array of variables to sanitize.
  * @return bool
  */
  public function __construct($fields) {
    $this->is_locked= true;
    foreach($fields as $key => $val) { $this->value[$key] = $val; }
    return true;
  }
# *** END - constructor ------------------------------------------------------- *
#
# *** BEGIN __get ------------------------------------------------------------- *
/**
  * Return the default sanitized version of the value.
  * @param  string  $fname              The variable name.
  * @return string
  */
  public function __get($fname) {
    return htmlspecialchars(strip_tags($this->value[$fname]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
  }
# *** END - __get ------------------------------------------------------------- *
#
# *** BEGIN __set ------------------------------------------------------------- *
/**
  * Set a pseudo property to a value.
  * If instance is locked, only allow new properties.
  * @param  string  $fname              The pseudoproperty name.
  * @param  string  $value              The value to be assigned.
  * @return bool
  */
  public function __set($fname, $value) {
    if ($this->is_locked) {
      $this->value[$fname] = $this->value[$fname] ?? $value;
    }else {
      $this->value[$fname] = $value;
    }
    return true;
  }
# *** END - __set ------------------------------------------------------------- *
#
# *** BEGIN lock -------------------------------------------------------------- *
/**
  * Lock our existing values from overwriting.
  * @return bool
  */
  public function lock() {
    $this->is_locked = true;
    return true;
  }
# *** END - lock -------------------------------------------------------------- *
#
# *** BEGIN unlock ------------------------------------------------------------ *
/**
  * Unlock our existing values to permit overwriting.
  * @return bool
  */
  public function unlock() {
    $this->is_locked = false;
    return true;
  }
# *** END - unlock ------------------------------------------------------------ *
#
# *** BEGIN get_as ------------------------------------------------------------ *
/**
  * Returns a perform a specific sanitizing on a string.
  * @return mixed
  */
  public function get_as($type, $fname, $params='') {
    switch($type) {
      case 'int':   # force to integer - no parameters                          *
        $this->clean[$fname] = (int) $this->value[$fname];
        break;
      case 'float': # force to float - no parameters                            *
        $this->clean[$fname] = (float) $this->value[$fname];
        break;
      default:      # same as __GET                                             *
        $this->clean[$fname] = htmlspecialchars(strip_tags($this->value[$fname]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
    return $this->clean[$fname];
  }
# *** END - get_as ------------------------------------------------------------ *
# *** BEGIN clean_url --------------------------------------------------------- *
/**
  * Returns a sanatized URl.
  * Use suffix to determine where to break the string. Everything after that
  * will be discarded.
  * @return mixed
  */
  public function clean_url($url, $suffix, $store='') {
    return false;
  }
# *** END - get_as ------------------------------------------------------------ *
}
// End mpc_paths -------------------------------------------------------------- *
