<?php
/**
 * Created by PhpStorm.
 * User: Geolffrey Mena
 * Date: 12-15-13
 * Time: 12:44 PM
 */
namespace core\security;

use core\Config;
use core\Session;

final class CSRFToken
{
    private static $_token = NULL;
    private static $_session = NULL;
    public static $_is_active_session = FALSE;
    private static $_session_name = CSRF_TOKEN_NAME;

    //Metodo Constructor
    public function __construct ( $_session = NULL )
    {

        $_sess_name     = isset( $_session ) ? $_session : self::$_session_name;
        self::$_session = new Session;
        self::$_session->setSessionName ( $_sess_name );

        if ( !self::$_session->exist ( $_sess_name ) ) {
            self::$_session->__init ($_sess_name);
        }

        self::$_is_active_session = self::$_session->isActive ();
    }

    //Ininializador de la clase
    public static function __init ( $_session_name = NULL )
    {
        return new self( $_session_name );
    }

    public static function isServiceActive ()
    {
        return Config::findConfig ( 'CSRF_TOKEN', [ 'CSRF_TOKEN_PROTECTION' ] );
    }

    //Muestra el nombre del token actual
    public static function getName ()
    {
        return self::$_session_name;
    }

    //Crea un nuevo token
    public static function create ()
    {
        return self::$_token = md5 ( uniqid () );
    }

    //Retorna el token actual
    public static function load ()
    {
        return self::$_session->getData ( 'token' );
    }

    /**Almacena el token en session
     * @param $_token string
     * @throws string
     * @return bool
     */
    public static function save ( $_token = NULL )
    {
        if ( isset( self::$_token ) ) {
            $_token = self::$_token;
        } elseif ( !isset( $_token ) && !isset( self::$_token ) ) {
            throw new \Exception(
                "Token Needed to save"
            );
        }

        self::$_is_active_session = TRUE;
        self::$_session->setData ( 'token', $_token );
        self::$_session->setCookie ( CSRF_TOKEN_COOKIE_NAME || self::$_session_name, CSRF_TOKEN_EXPIRE );
        //breakPoint($_SESSION);
    }

    //Destruye la session actual

    public static function destroy ()
    {
        self::$_session->destroy ();
    }

    //Elimina un token segun el nombre

    public static function clear ( $_key )
    {
        self::$_session->removeData ( $_key );
    }

    /**Valida los token
     * @param $_token string
     * @return bool
     */
    public static function validate ( $_token = NULL )
    {
        return self::$_session->getData ( 'token' ) == $_token;
    }

}