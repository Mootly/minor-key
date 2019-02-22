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
  * @method array   setposition(integer, array)
  *   Create a new pagination dataset.
  * @method array   makebar(string)
  *   Create a new pagination bar.
  * @method array   makeselect(string)
  *   Create a new pagination drop down selector.
  * @method array   getposition()
  *   Return the the current page number and record number.
  * @method array   getbar()
  *   Return the pagination bar.
  * @method array   getselect()
  *   Return the pagination dropdown select menu.
  * @method array   checkerr()
  *   Return any processing errors (returns the last response data set).
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
    'success01'     => 'Success.',
    'success02'     => 'Instantiated.',
    'data01'        => 'Invalid parameter.',
    'data02'        => 'Number of records to paginate not provided.',
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
    $this->response['content']          = $this->error['success02'];
    return true;
  }
# *** END - constructor ------------------------------------------------------- *
#
# *** BEGIN setposition ------------------------------------------------------- *
/**
  * Create a pagination dataset for making toolbars and drop downs.
  * Broken otu so it isn't redone every time one is called.
  * @param  string  $count    The number of elements to break in into pages.
  * @param  array   $params   A hash of properties to be set.
  *         type              string  - how to paginate: get, post, script.
  *         per_page          integer - number included per page.
  *         curr_page         integer - number of the page we are currently on.
  *         direction         string  - (asc)ending or (desc)ending.
  *         max_run           integer - maximum number of consecutive buttons in bar.
  *         firstlast         boolean - whether to include first and last buttons.
  *         compress          boolean - whether to serve up with ellipses.
  *         overlap           boolean - overlap first and last records.
  * @return array
  *         success           bool    - was the call successful.
  *         content           string  - results or error message.
  */
  public function setposition($count, $params) {
                    # make sure we have values to work with                     *
                    # because children should default to parent setting         *
    $this->props['count']     = $count                ? : 0;
    $this->props['type']      = $params['type']       ? : 'get';
    $this->props['per_page']  = $params['per_page']   ? : 32;
    $this->props['curr_page'] = $params['curr_page']  ? : 1;
    $this->props['direction'] = $params['direction']  ? : 'asc';
    $this->props['max_run']   = $params['max_run']    ? : 5;
    $this->props['firstlast'] = $params['firstlast']  ? : false;
                    # for the above, okay to override thing that == false       *
                    # for the below, false is a legal value                     *
    $this->props['overlap']   = array_key_exists('overlap', $params)  ? $params['overlap'] : true;
    $this->props['compress']  = array_key_exists('compress', $params) ? $params['compress'] : true;
                    # Set our computed working variables ---------------------- *
    $this->props['offset'] = $this->props['overlap'] ? 1 : 0;
    $this->props['page_step'] = $this->props['overlap'] ? $params['per_page'] - 1 : $params['per_page'];
    $this->props['page_ct']   = ceil($this->props['count'] / $this->props['page_step']);
    $this->props['curr_rec']  = ($this->props['page_step'] * ($this->props['curr_page'] - 1)) + 1;
    if ($this->props['page_ct'] <= ($this->props['max_run']+2)) {
      $this->props['max_run']           = $this->props['page_ct'];
      $this->props['compress']          = false;
    }

                    # error out now if bad values submitted
    if ($this->props['count'] < 1) {
      $this->response['success']        = false;
      $this->response['content']        = $this->error['data02'];
      return $this->response;
    }
  }
# *** END - setposition ------------------------------------------------------- *
#

# *** BEGIN makebar ----------------------------------------------------------- *
/**
  * Create a pagination toolbar
  * @param  string  $classes  Space separated list of classes names
  * @return array
  *         success           bool    - was the call successful.
  *         content           string  - results or error message.
  */
  public function makebar($classes) {
                    # make sure we have values to work with                     *
                    # because children should default to parent setting         *
    $this->props['classes']   = $classes ? : '';

    ob_start();
                    # === BEGIN BAR =========================================== #
?>
<div class="paginator <?= $this->props['classes']; ?>">
<?php
                    # first page button                                         *
    if (($this->props['firstlast']) && ($this->props['compress'])) {
      if ($this->props['curr_page'] == 1) { ?>
  <div class="btn page-firstlast page-first nolink"><span>First</span></div>
<?php } else { ?>
  <div class="btn page-firstlast page-first"><a href="<?= $_SERVER['PHP_SELF'].'?page='.$this->props['curr_page']; ?>"><span>First</span></a></div>
<?php } }
                    # prev page button                                          *
?>
<div class="btn page-prevnext page-prev"><a href="<?= $_SERVER['PHP_SELF'].'?page='.($this->props['curr_page']-1); ?>"><span>Prev</span></a></div>
<?php
                    # next page button                                          *
?>
<div class="btn page-prevnext page-prev"><a href="<?= $_SERVER['PHP_SELF'].'?page='.($this->props['curr_page']+1); ?>"><span>Next</span></a></div>
<?php
                    # last page button                                         *
    if (($this->props['firstlast']) && ($this->props['compress'])) {
      if ($this->props['curr_page'] == $this->props['page_ct']) { ?>
    <div class="btn page-firstlast page-last nolink"><span>Last</span></div>
  <?php } else { ?>
  <div class="btn page-firstlast page-last"><a href="<?= $_SERVER['PHP_SELF'].'?page='.$this->props['page_ct']; ?>"><span>Last</span></a></div>
<?php } }?>
</div>
<?php
                    # === END BAR ============================================= #
    $this->bar      = ob_get_clean();
    ob_end_clean();

                  # return success
    $this->response['success']          = true;
    $this->response['content']          = $this->bar;
    return $this->response;
  }
# *** END - makebar ----------------------------------------------------------- *
#
}
// End mpc_paginate_bar ------------------------------------------------------- *
