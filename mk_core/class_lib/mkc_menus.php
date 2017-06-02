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
    public $menu        = array();
    protected $response = array();
    protected $temp     = array();
    protected $error    = array(
      'current' => 'none',
      'none'    => 'Success.',
      'data01'  => 'Invalid menu name.',
      'data02'  => 'Invalid link name.',
      'data03'  => 'Invalid URL.',
      'data04'  => 'Invalid parameter.',
      'lock01'  => 'Menu is locked.',
      'lock02'  => 'Link is locked.',
    );
/**
  * Constructor
  * If we lock the instance, values can be added but not changed.
  * To lock a path set, instantiate with true.
  * @param  bool $prot Are items locked from updating.
  * @return bool
  */
    public function __construct($prot=true) {
      $this->is_locked = $prot;
      $error['current'] = 'lock01';
      $this->response['success'] = true;
      $this->response['errorcode'] = $error['current'];
      $this->response['content'] = $error[$error['current']];
      return true;
    }
/**
  * Create or reset a menu
  * If instance is locked, only allow new menus.
  * @param  string  $name   The name of the menu to be created.
  * @param  array   $params A hash of properties to be set.
  *         permissions     string  - view rights categories used by page.
  *         type            string  - menu category.
  *         classes         string  - space separated litt of classes names
  *         is_locked       bool    - whether to lock this menu.
  * @return array
  *         success         bool    - was the call successful.
  *         content         string  - results or error message.
  */
    public function setmenu($name, $params) {
      if ( (array_key_exists($name, $this->menu)) ) {
        $this->temp['action'] = 'update';
                    # if locked, block the update
        if ( ($this->is_locked) or ($this->menu[$name]['is_locked']) ) {
          $this->response['success']    = false;
          $this->response['content']    = $error[$error['lock01']];
          return $this->response;
        }
      } else {
        $this->temp['action'] = 'create';
      }
                    # make sure we have values to work with
                    # is_locked - set default: true, but menu default: false
                    # because children should default to parent setting
      $this->temp['perms']    = $params['permissions']  ? : 'public';
      $this->temp['type']     = $params['type']         ? : 'left sidebar';
      $this->temp['classes']  = $params['classes']      ? : '';
      $this->temp['lock']     = $params['is_locked']    ? : false;
                    # create / reset menu
      $this->menu[$name]              = array();
      $this->menu[$name]['perms']     = $this->temp['perms'];
      $this->menu[$name]['type']      = $this->temp['type'];
      $this->menu[$name]['classes']   = $this->temp['classes'];
      $this->menu[$name]['is_locked'] = $this->temp['lock'];
      $this->menu[$name]['links']     = array();
                    # return success
      $this->response['success'] = true;
      $this->response['content'] = 'The menu '.$name.' hase been '.$temp_action.'d.';
      $this->temp = array();            # clean up after yourself
      return $this->response;
    }
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
* @return array
*         success         bool    - was the call successful.
*         content         string  - results or error message.
*/
    public function setlink($name, $params) {
      $temp_perms   = $params['permissions'] ? : 'public';
      $temp_type    = $params['type'] ? : 'left sidebar';
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
    public function getlink($name, $params) {
      return $this->menu[$name]['links'];
    }
  }
// End mkc_parts -------------------------------------------------------------- *
