<?php
namespace core\cache\interfaces;
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 04-12-14
 * Time: 08:51 AM
 */
interface iCacheResult
{
    public function __construct ( iCacheConnection $CacheConnection );

    public static function expiration ( $exp );

    public static function newExpirationToKey ( $_key, $_time = 0 );

    public static function add ( $key = NULL, $value = NULL );

    public static function get ( $key = NULL );

    public static function validate ( $key );

    public static function replace ( $key, $value );

    public static function delete ( $key = NULL, $time = 0 );

    public static function show ();

    public static function clear ();
}