<?php
/**
  * Handle database operations
  *
  * Database calls are abstracted to allow for cleaner code.
  *
  * Public Properties:
  *   None.
  * Methods:
  * @method bool    __construct(string, array)
  *   Connection type as string followed by array of parameters.
  * @method mixed   getstatus()
  *   The database will return a status array.
  *   The object will return an error string if there is no db return,
  * @method int     getqueryidx()
  *   Return the index position of the last query.
  *   Return -1 if no queries run
  * @method string  getdate(date,format)
  *   Return the date formatted for print as a string.
  * @method string  prepdate(date)
  *   Return the date formatted for storage in the database.
  * @method bool    close()
  *   Close the current database connection.
  * @method mixed   runquery(string, array, array)
  *   The database will return a results array.
  *   The object will return an error string if there is no db return,
  * @copyright 2017-2020 Mootly Obviate
  * @package   moosepress
  * --- Revision History ------------------------------------------------------ *
  * 2020-04-07 | Added MySQL handling
  * 2019-07-09 | Added revision log, cleaned code
  * --------------------------------------------------------------------------- */
class mpc_db {
  protected         $mp_conn;
  protected         $mp_callby          = '';
  protected         $_status            = '';
  protected         $querynum           = -1;
  protected         $querylist          = array();
  protected         $paramlist          = array();
  protected         $optionlist         = array();
  protected         $errorlist          = array();
  protected         $resultset          = array();
  protected         $result             = array();
  protected         $error              = array(
    'current'       => 'none',
    'connected'     => 'Connected.',
    'noerrors'      => 'No errors reported.',
    'conn01'        => 'Connection type not valid or not specified. Currently supported: sqlsrv, mysql',
    'conn02'        => 'Missing arguments: ',
    'conn03'        => 'The database name was not valid: ',
    'result1'       => 'No results returned for ',
  );
  protected         $feedback           = array(
    'success'       => 'There were no errors processing this request',
    'nodata'        => 'There was nothing found for this search.',
    'unknown'       => 'An unidentified error has occured while retrieving content for this page.',
  );
# *** END - property assignments ---------------------------------------------- *
#
# *** BEGIN constructor ------------------------------------------------------- *
/**
  * Constructor
  * @param  string  $callby Connection type.
  * @param  array   $args   Connection specific arguments.
  *   arg      PDO   sqlsrv
  *   ----------------------------------
  *   driver    x
  *   host      x      x
  *   dbname    x      x
  *   user      x      x
  *   pass      x      x
  * @return string
  */
  public function __construct($callby, $args) {
    // http://php.net/manual/en/book.sqlsrv.php
    $this->mp_callby = $callby;
    $this->_status   = '';
    $this->_status  .= array_key_exists('host', $args)   ? '' : ' host';
    $this->_status  .= array_key_exists('dbname', $args) ? '' : ' dbname';
    $this->_status  .= array_key_exists('user', $args)   ? '' : ' user';
    $this->_status  .= array_key_exists('pwd', $args)    ? '' : ' pass';
    if ($this->_status != '') {
      $this->_status= $this->error['conn02'].$this->_status;
    } else {
      switch ($this->mp_callby) {
      case 'sqlsrv':
        $this->mp_conn = sqlsrv_connect( $args['host'], array(
          "Database"     => $args['dbname'],
          "UID"          => $args['user'],
          "PWD"          => $args['pwd'],
          "CharacterSet" => "UTF-8"
        ));

        if( $this->mp_conn ) {
          $this->_status = $this->error['connected'];
        } else {
          $this->_status = sqlsrv_errors();
        }
      break;
      case 'mysql':
        $this->mp_conn = new mysqli($args['host'], $args['user'], $args['pwd'], $args['dbname']);
        if( $this->mp_conn ) {
          $this->_status = $this->error['connected'];
        } else {
          $this->_status = 'Connection failed: ' . mysqli_connect_error();
        }
        break;
      default:
        $this->_status = $this->error['conn01'];
        break;
      }
    }
    return true;
  }
# *** END - constructor ------------------------------------------------------- *
#
# *** BEGIN getstatus --------------------------------------------------------- *
/**
  * Return the status of the last call.
  * @return mixed
  *   the object will return a string
  *   the database will return an array
  */
  public function getstatus() {
    return $this->_status;
  }
# *** END - getstatus --------------------------------------------------------- *
#
# *** BEGIN getqueryidx ------------------------------------------------------- *
/**
  * Return the index position of the last query.
  * @return int
  *   -1 returned if no queries run
  */
  public function getqueryidx() {
    return $this->querynum;
  }
# *** END - getqueryidx ------------------------------------------------------- *
#
# *** BEGIN getdate ----------------------------------------------------------- *
/**
  * Format a date for printing.
  * @return bool
  */
  public function getdate($date, $format) {
    switch ($this->mp_callby) {
    case 'sqlsrv':
      return date_format($date, $format);
      break;
    case 'mysql':
      return date($format, strtotime($date));
      break;
    default:
      return date($format, strtotime($date));
      break;
    }
    return true;
  }
# *** END - getdate ----------------------------------------------------------- *
#
# *** BEGIN prepdate ---------------------------------------------------------- *
# *** Yes, it does nothing worthwhile. Just here for completeness.
/**
  * Format a date for the database.
  * @return bool
  */
  public function prepdate($date, $format) {
    switch ($this->mp_callby) {
    case 'sqlsrv':
      return date($format, strtotime($date));
      break;
    case 'mysql':
      return date($format, strtotime($date));
      break;
    default:
      return date($format, strtotime($date));
      break;
    }
    return true;
  }
# *** END - getdate ----------------------------------------------------------- *
#
# *** BEGIN close ------------------------------------------------------------- *
/**
  * Close this database connection.
  * @return bool
  */
  public function close() {
    switch ($this->mp_callby) {
    case 'sqlsrv':
      sqlsrv_close( $this->mp_conn );
      break;
    case 'mysql':
      mysqli_close( $this->mp_conn );
      break;
    default:
      $this->_status = $this->error['conn01'];
      break;
    }
    return true;
  }
# *** END - close ------------------------------------------------------------- *
#
# *** BEGIN runquery ---------------------------------------------------------- *
/**
  * Return the results of a query.
  * @param  string  $query    The parameterized query string.
  * @param  array   $params   An array of parameters.
  * @param  array   $options  An array of options.
  * @return multiple
  *   the object will return a string
  *   the database will return an array
  */
  public function runquery($query, $params, $options='') {
    $this->result                      = '';
    $this->querynum                   += 1;
    $this->querylist[$this->querynum]  = $query;
    switch ($this->mp_callby) {
    case 'sqlsrv':
      $this->optionlist[$this->querynum] = $options;
      $this->paramlist[$this->querynum]  = $params;
      $this->errorlist[$this->querynum]  = '';
      $this->resultset[$this->querynum]  = sqlsrv_query(
        $this->mp_conn,
        $this->querylist[$this->querynum],
        $this->paramlist[$this->querynum],
        $this->optionlist[$this->querynum]
      );
      if ($this->resultset[$this->querynum] === false ) {
        if ( sqlsrv_errors() != null ) {
          $this->_status = sqlsrv_errors();
        } else {
          $this->_status = $this->error['result1'] . $query;
        }
      } else {
        if (sqlsrv_has_rows($this->resultset[$this->querynum])) {
          $this->_status = $this->error['noerrors'];
          while( $row = sqlsrv_fetch_array($this->resultset[$this->querynum], SQLSRV_FETCH_ASSOC)) {
            $this->result[] = $row;
          }
          $this->_status = $this->error['noerrors'];
          return $this->result;
        } else {
          $this->_status = $this->error['result1'] . $query;
        }
      }
      break;
    case 'mysql':
      $this->typelist[$this->querynum]   = array_shift($params);
      foreach($params as $key=>$val) {
        $this->paramlist[$this->querynum][$key] = $val;
      }
      $t_conn       = $this->mp_conn;
      $t_query      = $t_conn->prepare($this->querylist[$this->querynum]);
      if ($this->typelist[$this->querynum]) {
        $t_query->bind_param($this->typelist[$this->querynum], ...$this->paramlist[$this->querynum]);
      }
      $t_query->execute();
      $this->resultset[$this->querynum] = $t_query->get_result();
      if (gettype($this->resultset[$this->querynum]) == 'boolean') {
        $this->result = $this->resultset[$this->querynum];
      } else {
        $this->result = $this->resultset[$this->querynum]->fetch_all(MYSQLI_ASSOC);
      }
      $this->_status = $this->error['noerrors'];
      return $this->result;
      break;
    default:
      $this->_status = $this->error['conn01'].$this->_status;
      break;
    }
    $this->errorlist[$this->querynum] = $this->_status;
    return $this->_status;
  }
# *** END - runquery ---------------------------------------------------------- *
}
// End mpc_db ----------------------------------------------------------------- *
