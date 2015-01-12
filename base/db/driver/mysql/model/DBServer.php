<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-09-14
 * Time: 01:57 PM
 */

namespace core\db\mysql\model;

use core\App;
use core\interfaces\db\iDBConnection;
use core\interfaces\db\iDBServer;

App::__interface__ ( 'iDBServer', 'db/interface' );

class DBServer implements iDBServer
{
    private static $DBConnection = NULL;

    public function __construct ( iDBConnection $DBConnection )
    {
        self::$DBConnection = $DBConnection->getConnection ();
    }

    public static function ping ()
    {
        return self::$DBConnection->ping ();
    }

    public static function debug ()
    {
        return self::$DBConnection->debug ();
    }

    public static function hostInfo ()
    {
        return self::$DBConnection->host_info ();
    }

    public static function serverInfo ()
    {
        return self::$DBConnection->server_info ();
    }

    public static function getMysqlVersion ()
    {
        return self::$DBConnection->client_version;
    }

    public static function getThreadId ()
    {
        return self::$DBConnection->thread_id;
    }

    public static function kill ( $_thread = NULL )
    {
        if ( ! isset( $_thread ) ) {
            $_thread = self::getThreadId ();
        }

        return self::$DBConnection->kill ( $_thread );
    }

    public static function setCharset ()
    {
        return self::$DBConnection->set_charset ();
    }

} 