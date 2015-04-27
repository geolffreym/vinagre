<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 3/03/14
 * Time: 10:04
 * To change this template use Upload | Settings | Upload Templates.
 */

namespace core\db\mysql\model;

use core\App;
use core\Config;
use core\Exception;
use core\interfaces\db\iDBConnection;
use core\interfaces\db\iDBController;

App::__require__ ( 'DBConf', 'db/driver/mysql/model' );
App::__require__ ( 'DBConnection', 'db/driver/mysql/model' );
App::__require__ ( 'DBResult', 'db/driver/mysql/model' );
App::__require__ ( 'DBError', 'db/driver/mysql/model' );
App::__require__ ( 'DBServer', 'db/driver/mysql/model' );
App::__require__ ( 'DBTransaction', 'db/driver/mysql/model' );
App::__require__ ( 'DBBuilder', 'db/driver/mysql/model' );
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

        $this->DBConnection = new DBConnection( $this->DBConf, function ( iDBConnection $_connection ) {
                $this->DBError = new DBError( $_connection );

                Exception::create ( function () use ( $_connection ) {
                        return $_connection::isConnected ();
                    }, Exception::getExceptionList ( 'core' )[ 'cantConnectDB' ] . $this->DBError->getConnectionError ()
                );

                if ( Config::findConfig ( 'DB_CHARSET', [ 'DB_ENCODING' ] ) )
                    $_connection->setCharset ( DB_CHARSET );

                $this->DBResult      = new DBResult( $_connection );
                $this->DBBuilder     = new DBBuilder( $this->DBResult );
                $this->DBServer      = new DBServer( $_connection );
                $this->DBTransaction = new DBTransaction( $_connection );

            }
        );

    }

    final public function getDbConf ()
    {
        return $this->DBConf;
    }

    final public function getDbConnection ()
    {
        return $this->DBConnection;
    }

    final public function getDbResult ()
    {
        return $this->DBResult;
    }

    final public function getDbError ()
    {
        return $this->DBError;
    }

    final public function getDbTransaction ()
    {
        return $this->DBTransaction;
    }

    final public function getDbServer ()
    {
        return $this->DBServer;
    }

    final public function getDbBuilder ()
    {
        return $this->DBBuilder;
    }

}


