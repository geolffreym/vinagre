<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 04-12-14
 * Time: 08:51 AM
 */

namespace core\lib\model\cache;

use core\lib\interfaces\cache\iCacheConnection;
use core\lib\interfaces\cache\iCacheResult;

class CacheResult implements iCacheResult
{

    private static $_expiration = 0x1B58;
    private static $_connection;

    /**Constructor de la clase
     * @param $CacheConnection
     */
    public function __construct ( iCacheConnection $CacheConnection )
    {
        self::$_connection = $CacheConnection::getConnection ();
    }

    /**Establece expiración de los registro*
     * @param $exp
     */
    public static function expiration ( $exp )
    {
        self::$_expiration = $exp;
    }

    /**Agrega registro a Memcached*
     * @param $key
     * @param $value
     * @param $_overwrite
     * @return Boolean, String
     */
    public static function add ( $key = NULL, $value = NULL, $_overwrite = FALSE )
    {
        if ( !isset( $value ) || !isset( $key ) ) {
            return FALSE;
        }

        if ( !self::validate ( $key ) ) {
            return self::$_connection->add ( $key, $value, self::$_expiration );
        } elseif ( $_overwrite ) {
            self::$_connection->delete ( $key, 0 );

            return self::add ( $key, $value );
        } else {
            return FALSE;
        }

    }

    /** Renew Time on key
     * @param $_key
     * @param $_time
     */
    public static function newExpirationToKey ( $_key, $_time = 0 )
    {
        return self::$_connection->touch ( $_key, $_time );
    }

    /**Obtiene un objeto del cache*
     * @param $key
     * @return Boolean, Array
     */
    public static function get ( $key = NULL )
    {
        if ( self::validate ( $key ) ) {
            return self::$_connection->get ( $key );
        } else {
            return FALSE;
        }
    }

    /**Valida si existe o no un elemento
     * @param $key
     * @return Boolean
     */
    public static function validate ( $key )
    {
        if ( self::$_connection->get ( $key ) ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /** Replace Key
     * @param $key
     * @param $value
     */
    public static function replace ( $key, $value )
    {
        self::$_connection->replace ( $key, $value, self::$_expiration );
    }

    /**Elimina un registro
     * @param $key
     * @param $time
     * @return String
     */
    public static function delete ( $key = NULL, $time = 0 )
    {
        if ( self::validate ( $key ) ) {
            if ( self::$_connection->delete ( $key, $time ) ) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return 'No existe el registro a eliminar';
        }
    }

    //Muestra todos los registro
    public static function show ()
    {
        return self::$_connection->fetchAll ();
    }

    //Limpia la cache
    public static function clear ()
    {
        return self::$_connection->flush ();
    }


} 