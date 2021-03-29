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
  * @method mixed   __get(mixed)
  *   Return sanitized values from pseudoproperties from string or array.
  * @method bool    __set(string, string)
  *   Add pseudo-properties to array with assigned values.
  * @method string    clean_url(string, string [, string])
  *   Returns a santized copy of the current URL.
  * @method strings   cleaner(string [,bool [,bool [,bool]]])
  *   Sanitized values. Broken out to standard process across all methods
  * @method mixed     get_as(mixed)
  *   Returns values sanitized as specified from string or array.
  * @method string    lock()
  *   Locks existing values from being overwritten. Lock is on by default.
  * @method string    unlock()
  *   Unlocks existing values so they can be being overwritten.
  * @copyright 2019-2020 Mootly Obviate
  * @package   moosepress
  * --- Revision History ------------------------------------------------------ *
  * 2020-04-08 | Added ability to handle arrays.
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
# *** BEGIN clean ------------------------------------------------------------- *
/**
  * Clean up our any input data.
  * Two override flags:
  * - $keepCR       - set to true for textarea fields
  * - $keepHTML     - set to true for code entry fields
  * - $useRaw       - set to true for WYSIWYG fields
  * Each flag set to true is more of a potential security threat
  * Method prevents any scripts from being submitted. This cannot be overridden.
  * No flags should be set to true for anything to be returned as a query param
  *
  * @return bool
  */
  public function cleaner($fVal, $keepCR = false, $keepHTML = false, $useRaw = false) {
    $workingStr     = $fVal;
                    // set to $keepCR to true to preserve special characters
                    // we should only keep carriage returns for textarea fields
                    // and should only be used with post
    if (!$keepCR) { $workingStr = preg_replace('~[[:cntrl:]]~', ' ', $workingStr); }
                    // set $keepHTML to true not strip HTML tags.
                    // server side scripting tags will stipp be stripped
                    // special characters will still be escaped unless
                    // $useRaw == true
    if ($keepHTML) {
      $workingStr   = preg_replace(
        array('~<(\?|\%)\=?(php)?~', '~(\%|\?)>~'),
        array('',''),
        $workingStr
      );
    } else { $workingStr = strip_tags($workingStr); }
                    // raw strings should only be for WYSIWYG entry fields
                    // will still strip out script tags
                    // don't want to clean up, don't use this method.
    if ($useRaw) {
      $t_domObj     = new DOMDocument();
      $t_domObj->loadHTML($workingStr);
      $t_scrList    = $t_domObj->getElementsByTagName('script');
      for ($i = 0; $i < $t_scrList->length; $i++) {
        $t_scrList->item($i)->parentNode->removeChild($t_scrList->item($i));
      }
      $workingStr   = $t_domObj->saveHTML();
    } else { $workingStr = htmlspecialchars($workingStr, ENT_QUOTES | ENT_HTML5, 'UTF-8'); }
    return $workingStr;
  }
# *** END - clean ------------------------------------------------------------- *
#
# *** BEGIN __get ------------------------------------------------------------- *
/**
  * Return the default sanitized version of the value.
  * Currently only works on strings and arrays, which is all the data we should
  * be getting from user forms anyway.
  * @param  string  $fname              The variable name.
  * @return string
  */
  public function __get($fname) {
    if (isset($this->value[$fname])) {
      if (gettype($this->value[$fname]) == 'array') {
        $this->clean[$fname] = $this->value[$fname];
        array_walk_recursive($this->clean[$fname], array($this, 'cleaner'));
      } else {
        $this->clean[$fname] = $this->cleaner($this->value[$fname]);
      }
      return $this->clean[$fname];
    } else {
      return false;
    }
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
        $this->clean[$fname] = $this->cleaner($this->value[$fname]);
    }
    return $this->clean[$fname];
  }
# *** END - get_as ------------------------------------------------------------ *
#
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
