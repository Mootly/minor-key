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
  * @method string  getmenu(array)
  *   Return all links in a menu as an associative array of array[title] = URL.
  * @method bool    setmenu(string, array)
  *   Create a new menu.
  * @method string  getitem(string, array)
  *   The URL of a specific link.
  * @method bool    setitem(array)
  *   Create a new menu item.
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */
  class mkc_menus {
    protected $is_locked;
    public $menu = array();
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
    * Create a new menu
    * If instance is locked, only allow new menus.
    * @param  string  $name   The name of the menu to be created.
    * @param  array   $params A hash of properties to be set.
    *         permissions     string - view rights categories used by page.
    *         type            string - menu category.
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
      *         type            string - full URL or root relative.
      * @return array
      */
    // Return the value of a set component.
    public function getmenu($name, $params) {
      return $this->component[$property];
    }
  }
// End mkc_parts -------------------------------------------------------------- *
