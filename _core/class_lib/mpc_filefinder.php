<?php
/**
  * A library of file finding tools for redirects and 404s.
  *
  * The search functions will only return hits for specified file types.
  *
  * This library does not do database searches, but can be extended to do so.
  *
  * Public properties:
  * @var    array   $status             The status of the redirect with longdesc.
  * @var    string  $targetCategory     The category of the target URI.
  * Methods:
  * @method string  __construct()       Returns current state of redirect from $status
  * @method array   explainStatus()     Returns a description of status codes.
  * @method array   getMatches()        Return result set from a PHP glob().
  * @method string  getTarget()         Return the string being searched for.
  * @method mixed   listValidExtensions()
  *                 List valid extensions allowed in search by category.
  * @method bool    search_blocked()    Check for whether this search should not be done.
  * @method bool    try_nameMismatch()  Check for simple filename mismatches.
  * Placeholders for instance specific DB calls:
  * @method NULL    try_redirects()     Check database for redirects.
  * @method false   flag_brokenlink()   Flag broken links for review.
  *
  * @copyright 2018 Mootly Obviate
  * @package   moosepress
  * --- Revision History ------------------------------------------------------ *
  * 2019-07-30 | Fixed root directory failing to redirect
  * 2019-07-09 | Added revision log, cleaned code
  * --------------------------------------------------------------------------- */
class mpc_filefinder {
  public    $status;          # Current search status (see $statusTypes).
  public    $targetCategory;  # The category of the target URI.
  protected $automode;        # Whether to automate redirects.
  protected $globResult;      # The result of a PHP glob search.
  protected $globTarget;      # The url as being served to PHP glob().
  protected $pathArray;       # The path to find exploded.
  protected $seachType;       # The type of search to be performed.
  protected $targetURI;       # The raw url to find.
  protected $targetPath;      # The cleaned up verson of the url to find.
  protected $uriArray;        # The url to find exploded.
                    # our list of regexes                                       *
                    # ones using variables set at invocation time not included  *
  protected $regexPattern = array(
    'date'          => '/(%\d{2})?\d{1,4}\D\d{1,2}\D\d{1,4}/',
    'nonchars'      => '/((%\d{2})|(\s)|_|\-|\.)/',
    'compact'       => '/\*+/',
  );
                    # protected paths                                           *
                    # these automatically fail                                  *
                    # array is fragements merged into an OR'd regex on init     *
  protected $blockedPaths;
  protected $blockedPathArray = array(
    'admin'         => '\/admin\/',
    'core'          => '^\/_core',
    'cgi'           => 'cgi(_|-)?bin',
    'executables'   => '\.(cgi|exe)$',
    'phishing'      => '^\/niet\d+',
    'phptools'      => 'phpmy',
    'sql'           => '\/(my)?sql\/',
    'templates'     => '^\/_templates',
    'vendors'       => '^\/_vendors',
    'wordpress'     => 'wp-(include|login|content|admin)',
  );
                    # our list of valid extensions                              *
                    # redirects only allowed to these types                     *
                    # this was built while migrating a site off .Net            *
                    # you may want to extend this list                          *
                    # note that glob() stops working with too many              *
  protected $validExtStr;
  protected $validExtTypes = array(
    'webpage'       => 'asp,aspx,cfm,htm,html,php',
    'document'      => 'doc,docx,dot,dotx,rtf',             # odt,ott,
    'pdf'           => 'pdf',
    'slideshow'     => 'pps,ppt,pptx',                      # odp,odt,
    'spreadsheet'   => 'xls,xlsm,xlsx,xlt,xltm,xltx',       # ods,ots,
    'images'        => 'jpg,jpeg,gif,png,svg',
    'video'         => 'avi,mov,mp4,mpg,mpeg,wmv',          # asx,flv,wvx,
    'subtitles'     => 'sbv,srt,sub,vtt',
  );
                    # $statusTypes includes descriptions and suggestions.       *
                    # There are three types of status: process, final, error.   *
                    # When a process status is returned, keep looking.          *
                    # Once a final status has been returned, stop looking.      *
                    # The key / first item redundancy it to self-document       *
                    # without extra hoop jumping to return a key / value pair   *
  protected $statusTypes = array(
                    # Process states                                            *
    'not found'     => [ 'not found', 'process',
      'The requested page, document, or asset was not found. Check for redirect. This is the default value and should never be returned as a final status except by the constructor.'
      ],
    'mismatch'      => [ 'mismatch', 'process',
      'A possible match was found but the file types are not consistent. The application should check the database or other resource for clarifying matches.'
      ],
    'multiple'      => [ 'multiple', 'process',
      'Multiple possible file matches were found. The application should check the database or other resource for refining matches.'
      ],
    'search'        => [ 'search', 'process',
      'No simple matches found in the directory containing the target URL. The application should check the database or other resource for matches.'
      ],
                    # Final states                                              *
    '404 success'   => [ '404 success', 'final',
      'The address being searched for matches the current URL. If it is the 404 page, let the user know they successfully found the 404 page.'
      ],
    'confirm'       => [ 'confirm', 'final',
      'A potentional match was found, but there were problems that could not be programmatically resolved, for instance a file type mismatch or multiple results. Ask the user to confirm the result.'
      ],
    'no match'      => [ 'no match', 'final',
      'No matches were found. Refer user to a search page or other search resource.'
      ],
    'no search'     => [ 'no search', 'final',
      'No information was provided to search against. fF this is a 404 page, redirect to root.'
      ],
    'success'       => ['success', 'final',
      'Successful match found. Redirect user.'
      ],
                    # Error states                                              *
    'invalid status'=> [ 'invalid status', 'error',
      'The status code provided does not exists. Run explain with no argument for a complete list of status codes.'
      ],
  );
# *** END - property declarations --------------------------------------------- *
#
# *** BEGIN __construct ------------------------------------------------------- *
/**
  * Constructor
  *
  * Init our values and grab our server variables.

  * If the redirect type is '404', make sure the current page is not searching
  * for itself.
  *
  * If the page query value is provided
  *
  * Parameters
  * @param  string  $find_type          The type of redirect. Currently only sees 404.
  * @param  string  $page_query         A string representing the URL to be processed.
  * @return string
  */
  public function __construct($auto_mode=false, $find_type='404', $page_query='') {
                    # init our properties
    $this->automode           = $auto_mode;
    $this->status             = $this->statusTypes['not found'][0];
    $this->seachType          = $find_type;
    $this->validExtStr        = implode(',', $this->validExtTypes);
    $this->blockedPaths       = '/('.implode(')|(', $this->blockedPathArray).')/i';
                    # *** get our search URL ---------------------------------- *
                    # cascade order:                                            *
                    # - 1 - $page_query                                         *
                    # - 2 - $_SERVER['QUERY_STRING']                            *
                    # - 3 - $_SERVER['REQUEST_URI']                             *
                    # - 4 - none - set status to 'no search' and exit           *
                    #       this should never happen                            *
    if (!empty($page_query)) {
      $this->targetURI                  = $page_query;
    } elseif (!empty($_SERVER['QUERY_STRING'])) {
                    # epxlode returns array of query string components          *
                    #   0 - error code, 1 - url                                 *
                    # only return two in case there are semicolons in url       *
      $this->targetURI                  = (explode( ';', $_SERVER['QUERY_STRING'], 2 ))[1];
    } elseif (!empty($_SERVER['REQUEST_URI'])) {
      $this->targetURI                  = $_SERVER['REQUEST_URI'];
    } else {
      $this->status                     = $this->statusTypes['no search'][0];
    }
                    # return array of URL components                            *
                    # scheme, host, port, path                                  *
    $this->uriArray                     = parse_url($this->targetURI);
                    # return array of filename components                       *
                    # dirname, basename, extension, filename                    *
                    # so we can test suffixes
    $this->pathArray                    = pathinfo($this->uriArray['path']);
    if ($this->pathArray['dirname'] == '\\') { $this->pathArray['dirname'] = ''; }
                    # if no extension, fix pathing for pathinfo bug             *
    if (!isset($this->pathArray['extension'])) {
      $this->pathArray['dirname']       = $this->pathArray['dirname'].MP_PSEP.$this->pathArray['filename'];
      $this->pathArray['filename']      = '';
      $this->pathArray['category']      = 'directory';
      $this->targetPath                 = $this->pathArray['dirname'];
                    # if looking for default page                               *
    } elseif (in_array(strtolower($this->pathArray['filename']), array('default', 'index'))) {
      $this->pathArray['category']      = 'directory';
      $this->pathArray['filename']      = '';
      $this->targetPath                 = $this->pathArray['dirname'].MP_PSEP.$this->pathArray['filename'];
                    # if looking for named page                                 *
    } else {
      $this->targetPath                 = $this->pathArray['dirname'].MP_PSEP.$this->pathArray['filename'];
                    # returning an array, so make sure to string it             *
      $this->pathArray['category']      = preg_grep(
        '/(^|\W)'.$this->pathArray['extension'].'($|\W)/',
        $this->validExtTypes
      );
      if (!empty($this->pathArray['category'])) {
        reset($this->pathArray['category']);
        $this->pathArray['category']    = key($this->pathArray['category']);
      } else {
        $this->pathArray['category']    = 'invalid';
      }
    }
                      # these are going to get rewritten for glob()               *
    $this->pathArray['globFilename']    = $this->pathArray['filename'];
    $this->pathArray['globDirname']     = $this->pathArray['dirname'];
    $this->targetCategory               = $this->pathArray['category'];
                    # *** SPECIAL CASES --------------------------------------- *
                    # check for system paths                                    *
    if (preg_match($this->blockedPaths,$this->targetPath)) {
      $this->pathArray['category']      = 'system';
      $this->status                     = $this->statusTypes['no search'][0];
    }
                    # if looking for current page on 404 call, abort now        *
                    # 404 success will (or should) block try methods            *
    if ($_SERVER['REQUEST_URI'] == $_SERVER['SCRIPT_NAME']) {
      if ($this->seachType == '404') {
        $this->status                   = $this->statusTypes['404 success'][0];
      } else {
        $this->status                   = $this->statusTypes['no search'][0];
      }
    }
  }
# *** END - __construct ------------------------------------------------------- *
#
# *** BEGIN explainStatus ----------------------------------------------------- *
/**
  * Explain the returned status.
  *
  * Returns the description of the requested status.
  * If none requested, returns the entire status array.
  *
  * Parameters
  * @param  string  $status_code        The status to be explained.
  * @return array
  */
  public function explainStatus($status_code='') {
    if (empty($status_code)) {
      return $this->statusTypes;
    } elseif(array_key_exists($status_code,$this->statusTypes)) {
      return $this->statusTypes[$status_code];
    } else {
      return $this->statusTypes['invalid status'];
    }
  }
# *** END - explainStatus ----------------------------------------------------- *
#
# *** BEGIN getMatches -------------------------------------------------------- *
/**
  * Return result set from a PHP glob().
  *
  * Using a get to ensure these values are only set through the constructor.
  *
  * Parameters
  * @return array
  */
  public function getMatches() {
    return $this->globResult;
  }
# *** END - getMatches -------------------------------------------------------- *
#
# *** BEGIN getTarget --------------------------------------------------------- *
/**
  * Return the string being searched for.
  *
  * Using a get to ensure these values are only set through the constructor.
  * Defaults to the cleaned up path, but can also return the raw URI.
  *
  * Parameters
  * @param  string  $version            The value to be returned (path | url).
  * @return string
  */
  public function getTarget($version='path') {
    if (($version == 'url') || ($version == 'uri')) {
      return $this->targetURI;
    } else {
      return $this->targetPath;
    }
  }
# *** END - getTarget --------------------------------------------------------- *
#
# *** BEGIN listValidExtensions ----------------------------------------------- *
/**
  * List valid extensions allowed in search by category.
  *
  * Returns a list of extensions by requested category.
  * If none requested, returns the entire extension array.
  *
  * Parameters
  * @param  string  $ext_cat            The extention category to be listed.
  * @return mixed
  */
  public function listValidExtensions($ext_cat='') {
    if (empty($ext_cat)) {
      return $this->validExtTypes;
    } elseif(array_key_exists($ext_cat,$this->validExtTypes)) {
      return $this->validExtTypes[$ext_cat];
    } else {
      return 'The extension requested is not a valid extension to search on.';
    }
  }
# *** END - listValidExtensions ----------------------------------------------- *
#
# *** BEGIN search_blocked ---------------------------------------------------- *
/**
  * Check for whether this search should not be done.                           *
  * @return bool
  */
  protected function search_blocked() {
                    # reasons to not be here                                    *
                    # status is public, so also check category for system files *
    if (in_array($this->status, ['no search','404 success'])) { return true; }
    if ($this->pathArray['category'] == 'system') { return true; }
    return false;
  }
# *** END - search_blocked ---------------------------------------------------- *
#
# *** BEGIN try_nameMismatch -------------------------------------------------- *
/**
  * Check for simple filename mismatches.
  *
  * If auto, redirect.
  * If clean includes date, autoredirect will be ignored.
  *
  * Parameters
  * @param  string  $clean              Comma spearated list of what to clean.
  * @return array
  */
  public function try_nameMismatch($ignore='suffix') {
    if ($this->search_blocked()) { return NULL; }
    // echo('<pre>');
    // var_dump($this->pathArray);
    // echo('<pre>');
    // die();
                    # if path is flagged as a directory file, try that first    *
    if ($this->pathArray['category'] == 'directory') {
      if ($this->pathArray['filename'] == '') {
        $this->globTarget = ltrim($this->pathArray['dirname'], '/').MP_PSEP.'{default,index}';
        $this->globTarget = MP_ROOT.$this->globTarget .'.{'.$this->validExtTypes['webpage'].'}';
        $this->globResult = glob( $this->globTarget, GLOB_BRACE );
      }
      if (!$this->globResult || (count($this->globResult) == 0 )) {
        $this->pathArray['category']    = 'invalid';
      }
    }
    if (!$this->globResult || (count($this->globResult) == 0 )) {
      $this->pathArray['globFilename']  = $this->pathArray['filename'];
                    # clean up space characters                                 *
      if (strpos($ignore, 'spaces') !== false) {
        $this->pathArray['globFilename'] = preg_replace(
          $this->regexPattern['nonchars'],
          '*',
          $this->pathArray['globFilename']
        );
      }
                    # clean up dates                                            *
      if (strpos($ignore, 'dates') !== false) {
        $this->pathArray['globFilename'] = preg_replace(
          $this->regexPattern['date'],
          '*',
          $this->pathArray['globFilename']
        );
      }
      $this->globTarget   = ltrim($this->pathArray['dirname'], '/').MP_PSEP.$this->pathArray['globFilename'];
      if ((strpos($ignore, 'suffix') !== false) || ($this->pathArray['extension'] == '')) {
        $this->globTarget = MP_ROOT.$this->globTarget .'.{'.$this->validExtStr.'}';
      } else {
        $this->globTarget = MP_ROOT.$this->globTarget .'.'.$this->pathArray['extension'];
      }
      $this->globResult   = glob( $this->globTarget, GLOB_BRACE );
    }
                    # review our results                                        *
    if (!$this->globResult || (count($this->globResult) == 0 )) { $this->status = 'search'; }
                    # this is our success condition                             *
    elseif (count($this->globResult) == 1) { $this->status = 'success'; }
    else { $this->status = 'multiple'; }
                    # if success run again with just the matched category       *
    if (($this->status == 'success')
    && (!(in_array($this->pathArray['category'], ['directory','invalid'])))) {
      $this->globTarget     = ltrim($this->targetPath, '/');
      $this->globTarget     = MP_ROOT.$this->globTarget .'.{'.$this->validExtTypes[$this->pathArray['category']].'}';
      array_push($this->globResult, glob( $this->globTarget, GLOB_BRACE ));
      if (empty($this->globResult[1])) { $this->status = 'confirm'; }
    }
                    # success overrides                                         *
    if ($this->status == 'success') {
      if (strpos($ignore, 'dates') !== false) { $this->status = 'confirm'; }
      $t_globArray = pathinfo($this->globResult[0]);
                    # get the category of our file extension                    *
      if ($t_globArray['extension'] == '') {
        $t_globArray['category']        = 'directory';
      } else {
        $t_globArray['category']        = preg_grep(
          '/(^|\W)'.$t_globArray['extension'].'($|\W)/',
          $this->validExtTypes
        );
        if (!empty($t_globArray['category'])) {
          reset($t_globArray['category']);
          $t_globArray['category']      = key($t_globArray['category']);
        } else {
          $t_globArray['category']      = 'invalid';
        }
      }
      if (!(in_array($this->pathArray['category'], ['directory','invalid']))) {
        if ($t_globArray['category'] != $this->pathArray['category']) {
          $this->status = 'confirm';
        }
      }
    }
                    # if auto and success, redirect                             *
    if ($this->automode && ($this->status == 'success')) {
                    # this is now a scrap variable, so overwrite it             *
                    # for directory/index file , correct to canonical           *
      if ($this->pathArray['category'] == 'directory') {
        $this->targetURI = $this->pathArray['dirname'];
      } else {
        $this->targetURI = MP_PSEP.str_replace(MP_ROOT,'',$this->globResult[0]);
      }
                    # fix empty string when root directory call                 *
      if ($this->targetURI == '') { $this->targetURI = '/'; }
                    # *** REDIRECT to found page ------------------------------ #
      header('Location: '.$this->targetURI);                                    #
                    # *** REDIRECT to found page ------------------------------ #
    }
    foreach($this->globResult as $t_key=>$t_item) {
      if (!empty($t_item)) {
        $this->globResult[$t_key] = MP_PSEP.ltrim(str_replace(MP_ROOT,'',$t_item), '/');
      }
    }
    return $this->globResult;
  }
# *** END - try_nameMismatch -------------------------------------------------- *
#
# *** BEGIN try_redirects ----------------------------------------------------- *
/**
  * Check the database for redirect information.
  *
  * This is a placeholder stub for use in an extends.
  */
  public function try_redirects() { return NULL; }
# *** END - try_redirects ----------------------------------------------------- *
#
# *** BEGIN flag_brokenlink --------------------------------------------------- *
/**
  * Flag broken links for review.
  *
  * This is placeholder stub for extends.
  */
  public function flag_brokenlink() { return false; }
# *** END - flag_brokenlink --------------------------------------------------- *
}
// End mpc_filefinder --------------------------------------------------------- *
