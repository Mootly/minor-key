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
    protected $mp_conn;
    protected $_status  = '';
    protected $query    = array();
    protected $results  = array();
    protected $error    = array(
      'current' => 'none',
      'success' => 'Connected.',
      'conn01'  => 'Connection type not valid or not specified. Currently supported: sqlsrv',
      'conn02'  => 'Missing arguments: ',
    );
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
      $_status      = '';
      $_status     += array_key_exists('host', $args)   ? '' : ' host';
      $_status     += array_key_exists('dbname', $args) ? '' : ' dbname';
      $_status     += array_key_exists('user', $args)   ? '' : ' user';
      $_status     += array_key_exists('pass', $args)   ? '' : ' pass';
      if ($_status != '') {
        $_status = $error['conn02'].$errresult.;
      } else {
        switch ($callby) {
        case 'sqlsrv':
          $mp_conn  = sqlsrv_connect( $args['host'], array( "Database"=>$args['dbname'], "UID"=>$args['user'], "PWD"=>$args['pass']));
          if( $mp_conn ) {
            $_status = $error['success'];
          }else{
            $_status = sqlsrv_errors();
          }
          break;
        default:
          $_status  = $error['conn01'];
          break;
        }
      }
      return $_status;
    }
                    /**
                      * Return the value of asset path.
                      * @param  string $property The pseudoproperty name.
                      * @return string
                      */
    public function __get($property) {
      return $this->path[$property];
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
        $this->path[$property] = $this->path[$property] ?? $value;
      }else {
        $this->path[$property] = $value;
      }
      return true;
    }
                    /**
                      * Returns an associative array of paths.
                      * @return hash
                      */
    public function build_list() {
      return $this->path;
    }

  }
// End mpc_paths -------------------------------------------------------------- *
