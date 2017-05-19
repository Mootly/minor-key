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
  *   to protect existing values.
  * @method array   setmenu(string, array)
  *   Create a new menu.
  * @method array  getmenu(string, array)
  *   Return all links in a menu as an associative array of array[title] = URL.
  * @method array  getlink(string, string, array)
  *   The URL of a specific link.
  * @method array    setlink(string, string, string, array)
  *   Create a new menu item.
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */
  class mkc_menus {
    protected $is_locked;
    protected $response = array();
    public $menu = array();
    /**
      * Constructor
      * If we lock the instance, values can be added but not changed.
      * To lock a path set, instantiate with true.
      * @param  bool $prot Are items locked from updating.
      * @return bool
      */
    public function __construct($prot=true) {
      $this->is_locked = $prot;
      $this->response['success'] = true;
      $this->response['content'] = '';
      return true;
    }
    /**
    * Create a or reset a menu
    * If instance is locked, only allow new menus.
    * @param  string  $name   The name of the menu to be created.
    * @param  array   $params A hash of properties to be set.
    *         permissions     string  - view rights categories used by page.
    *         type            string  - menu category.
    *         is_locked       bool    - whether to lock this menu.
    * @return bool
    */
    public function setmenu($name, $params) {
                    # if locked, block the update
      if ( (array_key_exists($name, $this->menu)) {
        $temp_action = 'update';
        if ( ($this->is_locked) ) {
          $this->response['success'] = false;
          $this->response['content'] = 'This menu set is locked. You can add new menus, but not update them.';
          return $this->response;
        } elseif  ($this->menu[$name]['is_locked'] ) {
          $this->response['success'] = false;
          $this->response['content'] = 'This menu set is locked. You can add links to it, but not modify the menu or the links it contains.';
          return $this->response;
        }
      } else {
        $temp_action = 'create';
      }
                    # make sure we have values to work with
      $temp_perms = $params['permissions'] ? : 'public';
      $temp_type  = $params['type'] ? : 'left sidebar';
      $temp_lock  = $params['is_locked'] ? : 'left sidebar';
                    # create / reset menu
      $this->menu[$name]              = array();
      $this->menu[$name]['perms']     = $temp_perms;
      $this->menu[$name]['type']      = $temp_type;
      $this->menu[$name]['is_locked'] = $temp_lock;
      $this->menu[$name]['links']     = array();
                    # return success
      $this->response['success'] = true;
      $this->response['content'] = 'The menu '.$name.' hase been '.$temp_action.'d.';
      return $this->response;
    }
    /**
      * Return an array of menu items.
      * @param  string  $name   The pseudoproperty name.
      * @param  array   $params A hash of the output properties.
      *         permissions     string - view rights categories used by page.
      *         sort            string - sort order of the results.
      * @return array
      */
    // Return the value of a set component.
    public function getmenu($name, $params) {
      if ( array_key_exists($name, $this->menu) ) {
        return $this->menu[$name]['links'];
      }
    }
    /**
    * Create a or edit a link
    * If a menu or link is locked, only allow new links.
    * @param  string  $name   The name of the menu to be created.
    * @param  array   $params A hash of properties to be set.
    *         permissions     string - view rights categories used by page.
    *         type            string - menu category.
    *         is_locked       bool    - whether to lock this menu.
    * @return bool
    */
    public function setmenu($name, $params) {
      $temp_perms   = $params['permissions'] ? : 'public';
      $temp_type    = $params['type'] ? : 'left sidebar';
      if (($this->is_locked) and (array_key_exists($name, $this->menu))) {
        $return false;
      }else {
        $this->menu[$name]           = array();
        $this->menu[$name]['perms']  = $temp_perms;
        $this->menu[$name]['type']   = $temp_type;
        $this->menu[$name]['links']  = array();
      }
      return true;
    }
    /**
      * Return an array of menu items.
      * @param  string  $name   The pseudoproperty name.
      * @param  array   $params A hash of the output properties.
      *         permissions     string - view rights categories used by page.
      *         sort            string - sort order of the results.
      * @return array
      */
    // Return the value of a set component.
    public function getmenu($name, $params) {
      return $this->menu[$name]['links'];
    }
  }
// End mkc_parts -------------------------------------------------------------- *
