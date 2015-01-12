<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 3/03/14
 * Time: 10:04
 * To change this template use Upload | Settings | Upload Templates.
 */

namespace core\oracle\model;

use core\App;
use core\db\interfaces\iDBController;
use core\Exception;

App::__require__ ( 'DBConf', 'db/driver/oracle/model' );
App::__require__ ( 'DBConnection', 'db/driver/oracle/model' );
App::__require__ ( 'DBResult', 'db/driver/oracle/model' );
App::__require__ ( 'DBError', 'db/driver/oracle/model' );
App::__require__ ( 'DBServer', 'db/driver/oracle/model' );
App::__require__ ( 'DBTransaction', 'db/driver/oracle/model' );
App::__require__ ( 'DBBuilder', 'db/driver/oracle/model' );
App::__interface__ ( 'iDBController', 'db/interface' );

class DBController implements iDBController
{
    protected $DBConf = NULL;
    protected $DBConnection = NULL;
    protected $DBResult = NULL;
    protected $DBError = NULL;
    protected $DBTransaction = NULL;
    protected $DBServer = NULL;
    protected $DBBuilder = NULL;

    public function __construct ()
    {
        $this->DBConf = new DBConf;
        $this->DBConf->setHost ( DB_HOST );
        $this->DBConf->setUser ( DB_USER );
        $this->DBConf->setPass ( DB_PASS );
        $this->DBConf->setDatabase ( DB_DATABASE );
        $this->DBConf->setOptions ();

        $this->DBConnection = new DBConnection( $this->DBConf, function ( $_connection ) {
            $this->DBError = new DBError( $_connection );
            if ( $_connection->_is_connected ) {
                $this->DBBuilder     = new DBBuilder;
                $this->DBResult      = new DBResult( $_connection );
                $this->DBServer      = new DBServer( $_connection );
                $this->DBTransaction = new DBTransaction( $_connection );
            } else {
                Exception::cantConnectDB ( $this->DBError );
            }
        } );

    }

    public function getDbConf ()
    {
        return $this->DBConf;
    }

    public function getDbConnection ()
    {
        return $this->DBConnection;
    }

    public function getDbResult ()
    {
        return $this->DBResult;
    }

    public function getDbError ()
    {
        return $this->DBError;
    }

    public function getDbTransaction ()
    {
        return $this->DBTransaction;
    }

    public function getDbServer ()
    {
        return $this->DBServer;
    }

    public function getDbBuilder ()
    {
        return $this->DBBuilder;
    }

}


