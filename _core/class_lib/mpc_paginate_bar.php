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
  * Broken out so it isn't redone every time one is called.
  * max_run is not the full bar. The maximum number of pages lists is n+2.
  * Max spaces is n+8: first prev 1 ... 4 5 _6_ 7 8 ... n next last
  * Recommend responsive styling
  * Tablet: remove 4 to cap bar at n+4: first prev 4 5 _6_ 7 8 next last
  * Phone: remove all number links to cap bar at 5: first prev _6_ next last
  * @param  string  $count    The number of elements to break in into pages.
  * @param  array   $params   A hash of properties to be set.
  *         type              string  - how to paginate: get, post, script.
  *         per_page          integer - number included per page.
  *         curr_page         integer - number of the page we are currently on.
  *         direction         string  - (asc)ending or (desc)ending.
  *         max_run           integer - maximum number of consecutive buttons in bar.
  *         firstlast         boolean - whether to include first and last buttons.
  *         userecnum         boolean - use record numbers instead of page numbers.
  *         compress          boolean - whether to serve up with ellipses.
  *         overlap           boolean - overlap first and last records.
  * @return array
  *         success           bool    - was the call successful.
  *         content           string  - results or error message.
  */
  public function setposition($count, $params) {
    $this->props['url_path']  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $this->props['url_query'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    parse_str($this->props['url_query'], $t_url_query);
    unset($t_url_query['page']);
    $this->props['url_query'] = http_build_query($t_url_query);
    if (strlen($this->props['url_query'])) {
      $this->props['url_query'] = $this->props['url_query'].'&';
    }
    $this->props['url']       = $this->props['url_path'].'?'.$this->props['url_query'];
    $this->props['url_frag']  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_FRAGMENT);
    if (strlen($this->props['url_frag'])) {
      $this->props['url_frag'] = '#'.$this->props['url_frag'];
    }
                    # make sure we have values to work with                     *
                    # because children should default to parent setting         *
    $this->props['count']     = $count                      ? : 0;
    $this->props['type']      = $params['type']             ? : 'get';
    $this->props['per_page']  = $params['per_page']         ? : 32;
    $this->props['curr_page'] = $params['curr_page']        ? : 1;
    $this->props['direction'] = $params['direction']        ? : 'asc';
    $this->props['max_run']   = $params['max_run']          ? : 5;
    $this->props['firstlast'] = $params['firstlast']        ? : false;
    $this->props['userrecnum']= $params['userrecnum']       ? : false;
                    # for the above, okay to override thing that == false       *
                    # for the below, false is a legal value                     *
    $this->props['overlap']   = array_key_exists('overlap', $params)  ? $params['overlap'] : true;
    $this->props['compress']  = array_key_exists('compress', $params) ? $params['compress'] : true;
                    # Set our computed working variables ---------------------- *
    $this->props['offset'] = $this->props['overlap'] ? 1 : 0;
    $this->props['page_step'] = $this->props['overlap'] ? $params['per_page'] - 1 : $params['per_page'];
                    # If there are not enought pages, disable ellipses -------- *
                    # Remember to test for zero ------------------------------- *
    $this->props['page_ct']   = ceil($this->props['count'] / $this->props['page_step']);
    $this->props['page_ct']   = $this->props['page_ct'] ? $this->props['page_ct'] : 1;
    if ($this->props['page_ct'] <= ($this->props['max_run']+2)) {
      $this->props['max_run'] = (int)$this->props['page_ct'];
      $this->props['compress']= false;
      $this->props['low_run'] = 1;
      $this->props['high_run']= (int)$this->props['page_ct'];
    } else {
      $this->props['low_run'] = $this->props['curr_page']-floor($this->props['max_run']/2);
      $this->props['high_run']= $this->props['curr_page']+floor($this->props['max_run']/2);
      if ($this->props['low_run'] < 1) {
        $this->props['low_run'] = 1;
        $this->props['high_run'] = $this->props['low_run'] + $this->props['max_run'] -1;
      }
      if ($this->props['max_run'] % 2 == 0) { $this->props['high_run'] -= 1; }
      if ($this->props['high_run'] > $this->props['page_ct']) {
        $this->props['high_run'] = $this->props['page_ct'];
        $this->props['low_run'] = $this->props['high_run'] - $this->props['max_run'] + 1;
      }
    }
                  # If using record numbers, compute these ------------------ *
    if ($this->props['userrecnum']) {
      $this->props['curr_rec'] = ($this->props['page_step'] * ($this->props['curr_page'] - 1)) + 1;
    }
                    # error out now if bad values submitted ------------------- *
    if ($this->props['count'] < 1) {
      $this->response['success']        = false;
      $this->response['content']        = $this->error['data02'];
      return $this->response;
    } else {
      return $this->props;
    }
  }
# *** END - setposition ------------------------------------------------------- *
#

# *** BEGIN makebar ----------------------------------------------------------- *
/**
  * Create a pagination toolbar
  * Classes:
  *  - div.paginator
  *    - div.btn page-firstlast page-first page-last nolink
  *    - div.btn page-prevnext page-prev page-next nolink
  *    - div.btn page-link page-first page-last current nolink
  * @param  string  $classes  Space separated list of classes names
  * @return array
  *         success           bool    - was the call successful.
  *         content           string  - results or error message.
  */
  public function makebar($classes = '') {
                    # make sure we have values to work with                     *
                    # because children should default to parent setting         *
    $this->props['classes']   = $classes ? : '';

    ob_start();
                    # === BEGIN BAR =========================================== #
?>
    <div class="paginator <?= $this->props['classes']; ?>">
<?php               # first page button --------------------------------------- *
    if (($this->props['firstlast']) && ($this->props['compress'])) {
      if ($this->props['curr_page'] == 1) { ?>
      <div class="btn page-firstlast page-first nolink"><span>First</span></div>
<?php } else { ?>
      <div class="btn page-firstlast page-first"><a href="<?= $this->props['url'].'page=1'; ?>"><span>First</span></a></div>
<?php } }           # prev page button ---------------------------------------- *
      if ($this->props['curr_page'] == 1) { ?>
      <div class="btn page-prevnext page-prev nolink"><span>Prev</span></div>
<?php } else { ?>
      <div class="btn page-prevnext page-prev"><a href="<?= $this->props['url'].'page='.($this->props['curr_page']-1); ?>"><span>Prev</span></a></div>
<?php }             # page 1 button  ------------------------------------------ *
    if ($this->props['low_run'] > 1) {
      if ($this->props['curr_page'] == 1) { ?>
      <div class="btn page-link first current nolink"><span>1</span></div>
<?php } else { ?>
      <div class="btn page-link first"><a href="<?= $this->props['url'].'page=1'; ?>"><span>1</span></a></div>
<?php }  }           # ellipses check ------------------------------------------ *
    if (($this->props['compress']) && ($this->props['low_run'] > 2)) { ?>
      <div class="btn ellipses nolink"><span>&hellip;</span></div>
<?php }             # page numbers -------------------------------------------- *
    for ($i=$this->props['low_run']; $i<=$this->props['high_run']; $i++) {
      if ($this->props['curr_page'] == $i) { ?>
      <div class="btn current nolink"><span><?= $i ?></span></div>
<?php } else { ?>
      <div class="btn page-link"><a href="<?= $this->props['url'].'page='.$i; ?>"><span><?= $i ?></span></a></div>
<?php } }             # ellipses check ------------------------------------------ *
    if (($this->props['compress']) && ($this->props['high_run'] < $this->props['page_ct']-1)) { ?>
      <div class="btn ellipses nolink"><span>&hellip;</span></div>
<?php }             # page n:max button --------------------------------------- *
    if ($this->props['high_run'] < $this->props['page_ct']) {
      if ($this->props['curr_page'] == $this->props['page_ct']) { ?>
      <div class="btn page-link last current nolink"><span><?= $this->props['page_ct']; ?></span></div>
<?php } else { ?>
      <div class="btn page-link last"><a href="<?= $this->props['url'].'page='.$this->props['page_ct']; ?>"><span><?= $this->props['page_ct']; ?></span></a></div>
<?php } }           # page next button                                         *
      if ($this->props['curr_page'] == $this->props['page_ct']) { ?>
      <div class="btn page-prevnext page-next nolink"><span>Next</span></div>
<?php } else { ?>
      <div class="btn page-prevnext page-next"><a href="<?= $this->props['url'].'page='.($this->props['curr_page']+1); ?>"><span>Next</span></a></div>
<?php }             # last page button                                          *
    if (($this->props['firstlast']) && ($this->props['compress'])) {
      if ($this->props['curr_page'] == $this->props['page_ct']) { ?>
      <div class="btn page-firstlast page-last nolink"><span>Last</span></div>
<?php } else { ?>
      <div class="btn page-firstlast page-last"><a href="<?= $this->props['url'].'page='.$this->props['page_ct']; ?>"><span>Last</span></a></div>
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
# *** BEGIN getbar ----------------------------------------------------------- *
/**
  * Create a pagination toolbar
  * Classes:
  *  - div.paginator
  *    - div.btn page-firstlast page-first page-last nolink
  *    - div.btn page-prevnext page-prev page-next nolink
  *    - div.btn page-link page-first page-last current nolink
  * @param  string  $classes  Space separated list of classes names
  * @return array
  *         success           bool    - was the call successful.
  *         content           string  - results or error message.
  */
  public function getbar() {
    return $this->bar;
  }

}
// End mpc_paginate_bar ------------------------------------------------------- *
