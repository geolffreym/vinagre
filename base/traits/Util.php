<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 01-09-15
 * Time: 11:47 AM
 */
namespace core\traits;

use core\Common;

trait Util
{
    public static function assert ( &$_valid, $_message, $_optional = NULL )
    {
        if ( empty( $_valid ) && empty( $_optional ) ) {
            Common::error503 ( $_message );
        } elseif ( !empty( $_optional ) ) {
            $_valid = $_optional;
        }
    }


    public static function str ( $_str )
    {
        return (string) $_str;
    }

    public static function int ( $_str )
    {
        return intval ( $_str );
    }

    public static function arrayToObject ( $_array = [ ] )
    {
        return (object) $_array;
    }

    public static function objectToArray ( $_object )
    {
        return (array) $_object;
    }


    public static function isFunction ( $_function )
    {
        return is_callable ( $_function );
    }

}