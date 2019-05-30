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
  * @method hash    get_asset()
  *   Returns a string with the correct path for the target asset.
  * @method hash    get_widget()
  *   Returns a string containing the widget to be included.
  * @copyright 2017 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */
class mpc_paths {
  protected $is_locked;
  protected $path = array();
                    # our list of valid extensions                              *
                    # redirects only allowed to these types                     *
                    # this was built while migrating a site off .Net            *
                    # you may want to extend this list                          *
                    # note that glob() stops working with too many              *
  protected $validExtStr;
  protected $validExtTypes = array(
    'content'       => 'htm,html,inc,php,txt',
    'document'      => 'doc,docx,dot,dotx,rtf,pdf,pps,ppt,pptx,xls,xlsm,xlsx,xlt,xltm,xltx',
    'image'         => 'jpg,jpeg,gif,png,svg',
    'style'         => 'css',
    'script'        => 'js',
    'video'         => 'avi,mov,mp4,mpg,mpeg,wmv,sbv,srt,sub,vtt',
    'widget'        => 'inc,php,asp,aspx,cfm,cfml',
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
    return $this->path[$property];
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
      $this->path[$property] = $this->path[$property] ?? $value;
    }else {
      $this->path[$property] = $value;
    }
    return true;
  }
# *** END - __set ------------------------------------------------------------- *
#
# *** BEGIN build_list -------------------------------------------------------- *
/**
  * Returns an associative array of paths.
  * @return hash
  */
  public function build_list() {
    return $this->path;
  }
# *** END - build_list -------------------------------------------------------- *
#
# *** BEGIN get_asset --------------------------------------------------------- *
/**
  * Returns a URI as a string.
  * @return string
  */
  public function get_asset($type, $name, $embed=false) {
    $t_found        = false;
    $t_target_path  = './';
    return $this->path;
  }
# *** END - get_asset --------------------------------------------------------- *
#
# *** BEGIN get_widget -------------------------------------------------------- *
/**
  * Returns ablock of content as a string.
  * @return string
  */
  public function get_widget($name) {
    return $this->path;
  }
# *** END - get_widget -------------------------------------------------------- *
}
// End mpc_paths -------------------------------------------------------------- *
