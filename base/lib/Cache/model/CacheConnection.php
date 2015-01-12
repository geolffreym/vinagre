<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 04-12-14
 * Time: 08:38 AM
 */

namespace core\lib\model\cache;

use core\App;
use core\lib\interfaces\cache\iCacheConf;
use core\lib\interfaces\cache\iCacheConnection;

class CacheConnection implements iCacheConnection
{
    static $object = NULL;
    private static $is_connected = FALSE;

    public function __construct ( iCacheConf $CacheConf, $_callback )
    {
        self::$_memcached = new \Memcached;
        self::$_memcached->setOptions ( $CacheConf->getConf () );


        if ( !is_array ( $CacheConf->getHost () ) ) :
            $this->$is_connected = self::$_memcached->addServer ( $CacheConf->getHost (), $CacheConf->getPort (), $CacheConf->getWeight () );
        else :
            $this->$is_connected = self::$_memcached->addServers ( $CacheConf->getHost () );
        endif;

        App::__callback__ ( $_callback, $this );
    }


    public static function isConnected ()
    {
        return self::$is_connected;
    }

    public static function setConf ( iCacheConf $CacheConf )
    {
        self::$_memcached->setOptions ( $CacheConf->getConf () );
    }

    public static function getConnection ()
    {
        return self::$_memcached;
    }

    public static function getStatus ()
    {
        return self::$_memcached->getStats ();
    }
}

