<?php
namespace core\lib\interfaces\cache;
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 04-12-14
 * Time: 08:48 AM
 */

interface iCacheConnection
{
    public function __construct ( iCacheConf $CacheConf, $_callback );

    public static function setConf ( iCacheConf $CacheConf );

    public static function isConnected ();

    public static function getConnection ();

    public static function getStatus ();

}