<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-09-14
 * Time: 12:21 PM
 */

namespace core\db\mysql\model;

use core\App;
use core\interfaces\db\iDBConnection;
use core\interfaces\db\iDBError;

App::__interface__ ( 'iDBError', 'db/interface' );

class DBError implements iDBError
{

    private static $_DBConnection;

    public function __construct ( iDBConnection $DBConnection )
    {
        self::$_DBConnection = $DBConnection->getConnection ();
    }

    public static function getConnectionError ()
    {
        return self::$_DBConnection->connect_error;
    }

    public static function getConnectionErrorCode ()
    {
        return self::$_DBConnection->connect_errno;
    }

    public static function getErrorCode ()
    {
        return self::$_DBConnection->errno;
    }

    public static function getErrorDescription ()
    {
        return self::$_DBConnection->error;
    }

    //Retorna el error de Mysql en la ultima query
    public static function getErrorList ()
    {
        return self::$_DBConnection->error_list;
    }
} 