<?php
namespace core\lib\interfaces\cache;
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 04-12-14
 * Time: 08:15 AM
 */
interface iCacheConf
{
    public static function setConf ( $conf );

    public static function setHost ( $host );

    public static function setPort ( $port );

    public static function setWeight ( $weight );

    public static function getHost ();

    public static function getPort ();

    public static function getConf ();

    public static function getWeight ();

}