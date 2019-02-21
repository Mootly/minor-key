<?php
/**
  * Set menu links
  *
  * Defined the properties of menus on the site.
  *
  * Public Properties:
  *   None.
  * Methods:
  * @method bool    __construct(bool)
  *   On instantiation, can be passed boolean to determine whether
  *   to protect initial values.
  * @method array   makebar(integer, array)
  *   Create a new pagination bar.
  * @method array   getbar(string)
  *   Return the pagination bar.
  * @method array   getselect(string)
  *   Return the pagination dropdown select menu.
  * @method array   checkerr()
  *   Return any processing errors.
  * @copyright 2017 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */
class mpc_paginate_bar {
  protected $bar;
  protected $props;
  protected $select;
  protected $response = array();
  protected $error  = array(
    'current'       => 'none',
    'none'          => 'Success.',
    'data01'        => 'Invalid parameter.',
    'lock01'        => 'Toolbar is is locked.',
    'proc01'        => 'There was an error processing tihs request.',
  );
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
  public function __construct() {
    $this->response['success']          = true;
    $this->response['content']    = 'Instantiated.';
    return true;
  }
# *** END - constructor ------------------------------------------------------- *
#
# *** BEGIN setmenu ----------------------------------------------------------- *
/**
  * Create or reset a menu
  * If instance is locked, only allow new menus.
  * @param  string  $count  The number of elements to break in into pages.
  * @param  array   $params A hash of properties to be set.
  *         type            string  - how to paginate: get, post, script.
  *         per_page        integer - number included per page.
  *         overlap         integer - overlap first and last records.
  *         direction       integer - (asc)ending or (desc)ending.
  *         classes         string  - space separated list of classes names
  * @return array
  *         success         bool    - was the call successful.
  *         content         string  - results or error message.
  */
  public function makebar($count, $params) {
                    # make sure we have values to work with                     *
                    # because children should default to parent setting         *
    $this->props['type']      = $params['type']       ? : 'get';
    $this->props['per_page']  = $params['per_page']   ? : 32;
    $this->props['overlap']   = $params['overlap']    ? : 'true';
    $this->props['direction'] = $params['direction']  ? : 'asc';
    $this->props['classes']   = $params['classes']    ? : '';
    ob_start();
                    # === BEGIN BAR =========================================== #
                    # === END BAR ============================================= #
    $this->bar      = ob_get_clean();
    ob_end_clean();

                  # return success
    $this->response['success']          = true;
    $this->response['content']          = $this->bar;
    return $this->response;
  }
# *** END - setmenu ----------------------------------------------------------- *
#
# *** BEGIN getlist ----------------------------------------------------------- *
/**
  * Return an array of menu items.
  * @param  string  $name   The pseudoproperty name.
  * @param  array   $params A hash of the output properties.
  *         permissions     string - view rights categories used by page.
  *         sort            string - sort order of the results.
  * @return array
  *         success         bool    - was the call successful.
  *         content         string  - results or error message.
  */
  public function getlist($name, $params) {
    if ( array_key_exists($name, $this->menu) ) {
      return $this->menu[$name]['links'];
    }
  }
# *** END - getlist ----------------------------------------------------------- *
#
# *** BEGIN setlink ----------------------------------------------------------- *
/**
* Create or edit a link
* If a menu or link is locked, only allow new links.
* @param  string  $name   The name of the menu to be created.
* @param  array   $params A hash of properties to be set.
*         permissions     string - view rights categories used by page.
*         type            string - menu category.
*         is_locked       bool    - whether to lock this menu.
* @return array
*         success         bool    - was the call successful.
*         content         string  - results or error message.
*/
  public function setlink($name, $params) {
    $temp_perms     = $params['permissions'] ? : 'public';
    $temp_type      = $params['type'] ? : 'left sidebar';
    if (($this->is_locked) and (array_key_exists($name, $this->menu))) {
      return false;
    }else {
      $this->menu[$name]           = array();
      $this->menu[$name]['perms']  = $temp_perms;
      $this->menu[$name]['type']   = $temp_type;
      $this->menu[$name]['links']  = array();
    }
    return true;
  }
# *** END - setlink ----------------------------------------------------------- *
}
// End mpc_parts -------------------------------------------------------------- *
