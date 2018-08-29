<?php
class mpc_filefinder {
/**
  * A library of file finding tools for redirects and 404s.
  *
  * The search functions will only return hits for specified file types.
  *
  * This library does not do database searches, but can be extended to do so.
  *
  * Public Properties:
  * @var    array   $status             The status of the redirect with longdesc.
  * @var    string  $queryStr           The value of the query string.
  * @var    string  $requestStr         The value of the requesting URL.
  * Methods:
  * @method string  __construct()       Returns current state of redirect from $status
  * @method array   explainStatus()     Returns a description of status codes.
  * @copyright 2018 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */
  public    $targetCategory;  # The category of the file.
  public    $targetURI;       # The url to find.
  public    $targetPath;      # The cleaned up verson of the url to find.
  public    $status;          # Current search status (see $statusTypes).
  protected $seachType;       # The type of search to be performed.
  protected $uriArray;        # The url to find exploded.
  protected $pathArray;       # The path to find exploded.
                    # $statusTypes includes descriptions and suggestions.       *
                    # There are three types of status: process, final, error.   *
                    # When a process status is returned, keep looking.          *
                    # Once a final status has been returned, stop looking.      *
                    # The key / first item redundancy it to self-document       *
                    # without extra hoop jumping to return a key / value pair   *
  protected $statusTypes = array(
                    # Process states                                            *
    'not found'     => [ 'not found', 'process',
      'The requested page, document, or asset was not found. Check for redirect. This is the default value and should enver be returned as a status'
      ],
    'mismatch'      => [ 'mismatch', 'process',
      'A possible match was found but the file types are not consistent. Check the database or other resource for matches.'
      ],
    'multiple'      => [ 'multiple', 'process',
      'Multiple possible files were found. Ask user to confirm the result.'
      ],
    'search'        => [ 'search', 'process',
      'No simple matches found in the directory containing the target URL. Check the database or other resource for matches.'
      ],
                    # Final states                                              *
    '404 success'   => [ '404 success', 'final',
      'The address being searched for matches the current URL. IF it is the 404 page, let the user know they successfully found the 404 page.'
      ],
    'confirm'       => [ 'confirm', 'final',
      'A potentional match was found, but there were problems that could not be programmatically resolved. Ask user to confirm the result.'
      ],
    'no match'      => [ 'no match', 'final',
      'No matches were found. Refer user to a search page or other search resource.'
      ],
    'no search'     => [ 'no search', 'final',
      'No information was provided to search against. IF this ia 404 page, redirect to root.'
      ],
    'success'       => ['success', 'final',
      'Successful match found. Redirect user.'
      ],
                    # Error states                                              *
    'invalid status'=> [ 'invalid status', 'error',
      'The status code provided does not exists. Run explain with no argument for a complete list of status codes.'
      ],
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
    'movie'         => 'avi,mov,mp4,mpg,mpeg,wmv',          # asx,flv,wvx,
    'subtitles'     => 'sbv,srt,sub,vtt',
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
  public function __construct($find_type='404', $page_query='') {
                    # init our properties
    $this->status                       = $this->statusTypes['not found'][0];
    $this->seachType                    = $find_type;
    $this->validExtStr                  = implode(',', $this->validExtTypes);
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
      $this->status                     = $this->statusTypes['no search'];
    }
                    # return array of URL components                            *
                    #   scheme, host, port, path                                *
    $this->uriArray                     = parse_url($this->targetURI);
                    # return array of filename components                       *
                    # dirname, basename, extension, filename                    *
    $this->pathArray                    = pathinfo($this->uriArray['path']);
    $this->pathArray['dirname']         = ltrim($this->pathArray['dirname'],'\\');
    $this->targetPath = $this->pathArray['dirname'].MP_PSEP.$this->pathArray['filename'];
                    # get the category of our file extension                    *
                    # directory, invalid, one of the $mpv_404_vExt keys         *
    if ($this->pathArray['extension'] == '') {
      $this->pathArray['category']      = 'directory';
    } else {
      $this->pathArray['category']      = preg_grep(
        '/(^|\W)'.$this->pathArray['extension'].'($|\W)/',
        $this->validExtTypes
      );
      if (is_array($this->pathArray['category'])) {
        reset($this->pathArray['category']);
        $this->pathArray['category']    = key($this->pathArray['category']);
      } else {
        $this->pathArray['category']    = 'invalid';
      }
    }
    $this->targetCategory               = $this->pathArray['category'];

                    # *** SPECIAL CASE ---------------------------------------- *
                    # if looking for current page on 404 call, abort now
    if (($this->seachType == '404') && ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF'])) {
      $this->status                     = $this->statusTypes['404 success'][0];
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
}
// End mpc_filefinder --------------------------------------------------------- *
