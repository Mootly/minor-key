<?php
class mpc_redirects {
/**
  * A library of redirect tools
  *
  * Public Properties:
  * @var    array   $status             The status of the redirect with longdesc.
  * @var    string  $queryStr           The value of the query string.
  * @var    string  $requestStr         The value of the requesting URL.
  * Methods:
  * @method string  __construct()       Returns current state of redirect from $status
  * @copyright 2018 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */
  public    $status = array();
  protected $findType;
  public    $requestStr;
                    # $statusTypes includes descriptions and suggestions        *
  protected $statusTypes = array(
                    # Process states                                            *
    'not found'     => [ 'not found',
      'The requested page, document, or asset was not found. Check for redirect. This is the default value and should enver be returned as a status'
      ],
    'mismatch'      => [ 'mismatch',
      'A possible match was found but the file types are not consistent. Check the database or other resource for matches.'
      ],
    'multiple'      => [ 'multiple',
      'Multiple possible files were found. Ask user to confirm the result.'
      ],
    'search'        => [ 'search',
      'No simple matches found in the directory containing the target URL. Check the database or other resource for matches.'
      ],
                    # Final states                                              *
    '404 success'   => [ '404 success',
      'The address being searched for matches the current URL. IF it is the 404 page, let the user know they successfully found the 404 page.'
      ],
    'confirm'       => [ 'confirm',
      'A potentional match was found, but there were problems that could not be programmatically resolved. Ask user to confirm the result.'
      ],
    'no match'      => [ 'no match',
      'No matches were found. Refer user to a search page or other search resource.'
      ],
    'no search'     => [ 'no search',
      'No information was provided to search against. IF this ia 404 page, redirect to root.'
      ],
    'success'       => ['success',
      'Successful match found. Redirect user.'
      ],
  );
                    # our list of valid extensions                              *
                    # redirects only allowed to these types                     *
                    # this was built while migrating a site off .Net            *
                    # you may want to extend this list                          *
                    # note that glob() stops working with too many              *
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
  protected $validExtString;

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
  * @param  string  $redirect_type      The type of redirect. Currently only sees 404.
  * @param  string  $page_query         A string representing the URL to be processed.
  * @return array
  */
  public function __construct($redirect_type='404', $page_query='') {
                    # init our properties
    $this->status             = $this->statusTypes['not found'];
    $this->findType           = $redirect_type;
    $this->validExtString     = implode(',', $this->validExtTypes);
                    # *** get our search URL ---------------------------------- *
                    # cascade order:
                    # - 1 - $page_query
                    # - 2 - $_SERVER['QUERY_STRING']
                    # - 3 - $_SERVER['REQUEST_URI']
                    # - 4 - none - set status to 'no search' and exit
    if (!empty($page_query)) {
    } elseif (!empty($_SERVER['QUERY_STRING'])) {
    } elseif (!empty($_SERVER['REQUEST_URI'])) {
    } else {
      $this->status = $this->statusTypes['no search'];

    }
                    # *** SPECIAL CASE ---------------------------------------- *
                    # if looking for current page on 404 call, abort now
    if (($this->findType == '404') && ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF'])) {
      $this->status = $this->statusTypes['404 success'];
      return $this->status[0];
    }

    return $this->status[0];
  }
# *** END __construct --------------------------------------------------------- *
}
// End mpc_redirects ---------------------------------------------------------- *
