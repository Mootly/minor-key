<?php
/**
  * Handle database operations
  *
  * Database calls are abstracted to allow for cleaner code.
  *
  * Public Properties:
  *   None.
  * Methods:
  * @method bool    __construct(mixed)
  *   Connection type as string followed by array of parameters.
  * @method string  __get(string)
  *   Return values from an array of pseudoproperties.
  * @method bool    __set(string, string)
  *   Add pseudo-properties to array with assigned values.
  * @method hash    build_list()
  *   Returns an associative array of paths.
  * @copyright 2017 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */
class mpc_db {
  protected         $mp_conn;
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
    'conn01'        => 'Connection type not valid or not specified. Currently supported: sqlsrv',
    'conn02'        => 'Missing arguments: ',
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
    $this->_status  = '';
    $this->_status  += array_key_exists('host', $args)   ? '' : ' host';
    $this->_status  += array_key_exists('dbname', $args) ? '' : ' dbname';
    $this->_status  += array_key_exists('user', $args)   ? '' : ' user';
    $this->_status  += array_key_exists('pwd', $args)    ? '' : ' pass';
    if ($this->_status != '') {
      $this->_status= $error['conn02'].$this->_status;
    } else {
      switch ($callby) {
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
# *** BEGIN close ------------------------------------------------------------- *
/**
  * Close this database connection.
  * @return bool
  */
  public function close() {
    sqlsrv_close( $this->mp_conn );
    return true;
  }
# *** END - close ------------------------------------------------------------- *
#
# *** BEGIN runquery ---------------------------------------------------------- *
/**
  * Return the results of a query.
  * @return multiple
  *   the object will return a string
  *   the database will return an array
  */
  public function runquery($query, $params, $options='') {
    $this->result                      = '';
    $this->querynum                   += 1;
    $this->querylist[$this->querynum]  = $query;
    $this->paramlist[$this->querynum]  = $params;
    $this->optionlist[$this->querynum] = $options;
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
        return $this->result;
      } else {
        $this->_status = $this->error['result1'] . $query;
      }
    }
    $this->errorlist[$this->querynum] = $this->_status;
    return $this->_status;
  }
# *** END - runquery ---------------------------------------------------------- *
}
// End mpc_db ----------------------------------------------------------------- *
