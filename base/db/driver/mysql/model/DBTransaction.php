<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-09-14
 * Time: 12:46 PM
 */

namespace core\db\mysql\model;

use core\App;
use core\Exception;
use core\interfaces\db\iDBConnection;
use core\interfaces\db\iDBTransaction;

App::__interface__ ( 'iDBTransaction', 'db/interface' );

final class DBTransaction implements iDBTransaction
{

    private static $_DBConnection;
    private static $_AutoCommit = FALSE;
    private static $_TransactionActive = FALSE;

    public function __construct ( iDBConnection $DBConnection )
    {
        self::$_DBConnection = $DBConnection->getConnection ();
    }

    public static function start_transaction ()
    {
        return self::$_TransactionActive = self::$_DBConnection->begin_transaction ();
    }

    public static function autocommit ( $_bool = FALSE )
    {
        if ( self::$_TransactionActive ) {
            self::$_AutoCommit = $_bool;
            self::$_DBConnection->autocomit ( $_bool );

            return self::$_TransactionActive;
        } else {
            Exception::throwException ( 'noTransactionActive' );
        }

        return FALSE;
    }

    public static function commit ()
    {
        if ( !self::$_AutoCommit ) {
            if ( self::$_TransactionActive ) {
                return self::$_DBConnection->commit ();
            } else {
                Exception::noTransactionActive ();
            }
        } else {
            return self::$_AutoCommit;
        }

        return FALSE;
    }

    public static function rollback ()
    {
        if ( self::$_TransactionActive ) {
            return self::$_DBConnection->rollback ();
        } else {
            return FALSE;
        }
    }

    public static function savePoint ( $_name )
    {
        if ( self::$_TransactionActive ) {
            return self::$_DBConnection->savepoint ( $_name );
        } else {
            return FALSE;
        }
    }

    public static function rollbackFromPoint ( $_name )
    {
        if ( self::$_TransactionActive ) {
            return self::$_DBConnection->release_savepoint ( $_name );
        } else {
            return FALSE;
        }
    }

} 