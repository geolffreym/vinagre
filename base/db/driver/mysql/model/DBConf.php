<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 3/03/14
 * Time: 9:42
 * To change this template use Upload | Settings | Upload Templates.
 */

namespace core\db\mysql\model;

use core\App;
use core\Config;
use core\interfaces\db\iDBConf;

App::__interface__ ( 'iDBConf', 'db/interface' );

final class DBConf implements iDBConf
{

    private static $host = NULL;
    private static $user = NULL;
    private static $pass = NULL;
    private static $table = NULL;
    private static $options = NULL;

    public static function setHost ( $host )
    {
        self::$host = $host;
    }

    public static function setUser ( $user )
    {
        self::$user = $user;
    }

    public static function setPass ( $pass )
    {
        self::$pass = $pass;
    }

    public static function setDatabase ( $table )
    {
        self::$table = $table;
    }

    public static function getHost ()
    {
        return self::$host;
    }

    public static function getUser ()
    {
        return self::$user;
    }

    public static function getPass ()
    {
        return self::$pass;
    }

    public static function getDatabase ()
    {
        return self::$table;
    }

    public static function setOptions ()
    {
        self::$options = [
            MYSQLI_OPT_CONNECT_TIMEOUT => Config::findConfig ( 'DB_TIMEOUT', [ 'DB_CONNECT_TIMEOUT' ] ) ? DB_CONNECT_TIMEOUT : NULL,
            MYSQLI_INIT_COMMAND        => Config::findConfig ( 'DB_INIT_COMMAND', [ 'DB_INIT_COMMAND' ] ) ? DB_INIT_COMMAND : NULL,
            MYSQLI_READ_DEFAULT_FILE   => Config::findConfig ( 'DB_READ', [ 'DB_READ_DEFAULT_FILE' ] ) ? DB_READ_DEFAULT_FILE : NULL
        ];
    }

    public static function getOptions ()
    {
        return self::$options;
    }

}