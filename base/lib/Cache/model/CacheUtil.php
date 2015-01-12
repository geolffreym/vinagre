<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 08-18-14
 * Time: 10:41 AM
 */

namespace core\lib\model\cache;


class CacheUtil
{
    private static $_key = NULL;

    /**Create Key
     * @param $str
     * @return string
     */
    public static function createKey ( $str )
    {
        return ( self::$_key = substr ( md5 ( $str ), 0, 0xF ) );
    }

    /** Get Key
     * @return null
     */
    public static function getKey ()
    {
        return self::$_key;
    }

    /** Get valid expiration Time
     * @param null $_time
     * @return int|null
     */
    public static function validExpirationTime ( $_time = NULL )
    {
        return !isset( $_time )
            ? 0 : $_time > 0x278D00
                ? 0x278D00 : $_time;
    }

} 