<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-30-14
 * Time: 12:57 PM
 */

namespace core\lib\model\ftp;

use core\lib\interfaces\ftp\iFTPConf;

class FTPConf implements iFTPConf
{
    private static $_host = 'localhost';
    private static $_port = 21;
    private static $_timeout = 90;
    private static $_user = NULL;
    private static $_pass = NULL;

    public static function setHost ( $_host )
    {
        self::$_host = $_host;
    }

    public static function setPort ( $_port )
    {
        self::$_port = $_port;
    }

    public static function setTimeOut ( $_timeout )
    {
        self::$_timeout = $_timeout;
    }

    public static function setUser ( $_user )
    {
        self::$_user = $_user;
    }

    public static function setPass ( $_pass )
    {
        self::$_pass = $_pass;
    }

    public static function getHost ()
    {
        return self::$_host;
    }

    public static function getPort ()
    {
        return self::$_port;
    }

    public static function getTimeOut ()
    {
        return self::$_timeout;
    }

    public static function getUser ()
    {
        return self::$_user;
    }

    public static function getPass ()
    {
        return self::$_pass;
    }

} 