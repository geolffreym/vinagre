<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-12-14
 * Time: 10:25 AM
 */
namespace core;
final class Session
{
    private static $_session_name = NULL;

    public function __toString ()
    {
        return session_encode ();
    }

    public function __init ( $_session_name = FALSE )
    {
        self::_openSession ();
        self::$_session_name = $_session_name ? $_session_name : SESS_NAME;
        session_cache_limiter ( SESS_CACHE );
        //session_name ( self::$_session_name );
        $_SESSION[ self::$_session_name ] = [ ];
    }

    public function regenerate ()
    {
        self::_openSession ();

        $old_session_id   = session_id ();
        $old_session_data = $_SESSION;

        session_regenerate_id ();
        $new_session_id = session_id ();

        session_id ( $old_session_id );
        session_destroy ();

        session_id ( $new_session_id );

        $_SESSION                  = $old_session_data;
        $_SESSION[ 'regenerated' ] = time ();

        session_write_close ();
    }

    public function setSessionName ( $_name )
    {
        self::$_session_name = $_name;
    }

    public static function exist ( $_name )
    {
        self::_openSession ();

        return isset( $_SESSION[ $_name ] );
    }

    public function isActive ()
    {
        return !$this->_isExpired ( SESS_EXPIRE );
    }


    public function setData ( $_key, & $_data = [ ] )
    {
        $_SESSION[ self::$_session_name ][ $_key ] = $_data;
    }

    public function removeData ( $_key )
    {
        unset( $_SESSION[ self::$_session_name ][ $_key ] );
    }

    public function getData ( $_key )
    {
        $_data = &$_SESSION[ self::$_session_name ][ $_key ];

        return $_data;
    }

    public function appendData ( $_key, & $_data = [ ] )
    {
        if ( isset( $_SESSION[ self::$_session_name ][ $_key ] ) ) {
            $_SESSION[ self::$_session_name ][ $_key ][ ] = $_data;
        } else {
            self::setData ( $_key, $_data );
        }
    }

    public function setCookie ( $_name, $_expire )
    {
        setcookie ( session_name (), $_name, $_expire, '/' );
    }

    public function destroy ()
    {
        session_unset ();
        if ( isset( $_COOKIE[ session_name () ] ) ) {
            setcookie ( session_name (), '', time () - 0xA410, '/' );
        }
        session_destroy ();
    }

    public function decode ( $_encoded )
    {
        return session_decode ( $_encoded );
    }

    private function _isExpired ( $_expire )
    {
        if ( !isset( $_SESSION[ 'regenerated' ] ) ) {
            $_SESSION[ 'regenerated' ] = time ();
            session_cache_expire ( ( $_expire / 0x3C ) );

            return FALSE;
        }

        $expiry_time = time () - ( session_cache_expire () * 0x3C );

        if ( $_SESSION[ 'regenerated' ] <= $expiry_time ) {
            return TRUE;
        }

        return FALSE;
    }

    private static function _openSession ()
    {
        if ( session_status () !== PHP_SESSION_ACTIVE ) session_start ();
    }
}