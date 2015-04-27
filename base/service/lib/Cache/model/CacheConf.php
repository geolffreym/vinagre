<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 04-12-14
 * Time: 08:15 AM
 */

namespace core\lib\model\cache;

use core\lib\interfaces\cache\iCacheConf;

class CacheConf implements iCacheConf
{
    private static $host = NULL;
    private static $port = NULL;
    private static $weight = NULL;
    private static $conf = [
        \Memcached::OPT_COMPRESSION          => TRUE,
        \Memcached::OPT_DISTRIBUTION         => \Memcached::DISTRIBUTION_CONSISTENT,
        \Memcached::OPT_NO_BLOCK             => TRUE,
        \Memcached::OPT_CONNECT_TIMEOUT      => 0x64,
        \Memcached::OPT_POLL_TIMEOUT         => 0x64,
        \Memcached::OPT_SERVER_FAILURE_LIMIT => 1,
        \Memcached::OPT_TCP_NODELAY          => TRUE,
        \Memcached::OPT_LIBKETAMA_COMPATIBLE => TRUE
    ];

    public static function setConf ( $conf )
    {
        self::$conf = array_merge ( self::$conf, $conf );
    }

    public static function setHost ( $host )
    {
        self::$host = $host;
    }

    public static function setPort ( $port )
    {
        self::$port = $port;
    }

    public static function setWeight ( $weight )
    {
        self::$weight = $weight;
    }

    public static function getHost ()
    {
        return self::$host;
    }

    public static function getPort ()
    {
        return self::$port;
    }

    public static function getWeight ()
    {
        return self::$weight;
    }

    public static function getConf ()
    {
        return self::$conf;
    }

} 