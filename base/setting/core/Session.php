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
        session_write_close ();
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
        self::_openSession ();
        $_SESSION[ self::$_session_name ][ $_key ] = $_data;
        session_write_close ();
    }

    public function removeData ( $_key )
    {
        self::_openSession ();
        unset( $_SESSION[ self::$_session_name ][ $_key ] );
        session_write_close ();
    }

    public function getData ( $_key )
    {
        self::_openSession ();
        $_data = &$_SESSION[ self::$_session_name ][ $_key ];
        session_write_close ();

        return $_data;
    }

    public function appendData ( $_key, & $_data = [ ] )
    {
        self::_openSession ();
        if ( isset( $_SESSION[ self::$_session_name ][ $_key ] ) ) {
            $_SESSION[ self::$_session_name ][ $_key ][ ] = $_data;
        } else {
            self::setData ( $_key, $_data );
        }
        session_write_close ();
    }

    public function setCookie ( $_name, $_expire )
    {
        self::_openSession ();
        setcookie ( self::$_session_name, $_name, $_expire, '/' );
        session_write_close ();
    }

    public function destroy ()
    {
        self::_openSession ();
        session_unset ();
        if ( isset( $_COOKIE[ self::$_session_name ] ) ) {
            setcookie ( self::$_session_name, '', time () - 0xA410, '/' );
        }
        session_destroy ();
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