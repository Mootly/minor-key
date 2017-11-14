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
  * @method array  __get(string)
  *   Return values from an array of pseudoproperties.
  * @method bool    __set(string, string)
  *   Add pseudo-properties to array with assigned values.
  * @method array  title()
  *   Returns the title of the page.
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */
  class mkc_parts {
    protected $is_locked;
    protected $temp_status;
    protected $component  = array();
    protected $response   = array();
    protected $error      = array(
      'current' => 'none',
      'none'    => 'Success.',
      'title01'  => 'No title provided for page.',
      'build01'  => 'Error constructing page.',
    );
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
/**
  * Return the value of a pseudo property.
  * @param  string $property The pseudoproperty name.
  * @return array
  *         success         bool    - was the call successful.
  *         content         string  - results or error message.
  */
    public function __get($property) {
      return $this->component[$property];
    }
/**
  * Return the <title> of the page.
  * Defaults if not set:
  * - $mko_parts->title_struct  = ['page_name','section_name','site_name'];
  * - $mko_parts->separator     = ' | ';
  * - $mko_parts->page_name     = ''
  * - $mko_parts->section_name  = ''
  * - $mko_parts->site_name     = ''
  * If page, section, site name and page title are all blank, an error will be thrown.
  * If a page title has already been specified, ti will not overwrite it.
  * @return array
  *         success         bool    - was the call successful.
  *         content         string  - results or error message.
  */
    public function build_title() {
      $this->component['page_title']    = $this->component['page_title']  ??  '';
      if ($this->component['page_title'] == '') {
        $this->title_struct  = $this->title_struct ?? ['page_name','section_name','site_name'];
        $this->separator     = $this->separator    ??  ' | ';
        $this->component['page_name']     = $this->component['page_name']     ??  '';
        $this->component['section_name']  = $this->component['section_name']  ??  '';
        $this->component['site_name']     = $this->component['site_name']     ??  '';
        foreach ($this->title_struct as $temp_el) {
          if ($this->component[$temp_el] != '') {
            if ($this->component['page_title'] != '') {
              $this->component['page_title'] = $this->component['page_title'].$this->separator;
            }
            $this->component['page_title'] = $this->component['page_title'].($this->component[$temp_el]);
          }
        }
      }
      if ($this->component['page_title'] == '') {
        $this->response['success'] = false;
        $this->response['content'] = $this->error['title01'];
      } else {
        $this->response['success'] = true;
        $this->response['content'] = $this->component['page_title'];
      }
      return $this->response;
    }
/**
  * Returns an array of page parts.
  * Builds the apge title if it is not already done.
  * Beyond that, this is a no frills data dump of all page comonents stored in
  * the object, including potential interim values. See docs for a list of the
  * core components.
  * @return array
  *         success         bool    - was the call successful.
  *         content         string  - results or error message.
  */
    public function build_page() {
      $temp_status = self::build_title();
      if ($this->component['page_title'] == '') {
        $this->response['success'] = false;
        $this->response['content'] = $this->error['build01'];
      } else {
        $this->response['success'] = true;
        $this->response['content'] = $this->component;
      }
      return $this->response;
    }
  }
// End mkc_parts -------------------------------------------------------------- *
