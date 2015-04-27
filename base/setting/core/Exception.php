<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-05-14
 * Time: 01:52 PM
 */
namespace core;

final class Exception
{
    private static $_exception_list = [ ];

    public static function create ( $try, $exception = '' )
    {
        try {
            if ( is_callable ( $try ) ) {
                if ( !$try() )
                    self::commit ( $exception );
            } else {
                self::commit ( 'First parameter, must be function' );
            }
        }
        catch ( \Exception $e ) {
            echo $e->getMessage ();
            die();
        }
    }

    public static function commit ( $_message )
    {
        throw new \Exception( $_message );
    }

    public static function getExceptionList ( $_list = 'core' )
    {
        return App::__require__ ( $_list, 'exceptions' )
            ? self::$_exception_list :
            [ ];
    }

    public static function setCollection ( $_collection = [ ] )
    {
        self::$_exception_list = $_collection;
    }

    public static function throwException ( $_name, $_list = 'core' )
    {
        //if ( empty( self::$_exception_list ) )
        if ( isset( self::getExceptionList ( $_list )[ $_name ] ) ) {
            self::commit ( self::$_exception_list[ $_name ] );
        }
    }

}