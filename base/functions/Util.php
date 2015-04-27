<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 01-26-15
 * Time: 08:49 PM
 */
use core\Common;

/**Wrap string
 * @param $string
 * @param wrap
 * @return String
 */
function wrapStr ( $string, $wrap )
{
    return $wrap . $string . $wrap;
}


/**Assertion function
 * @param $_valid
 * @param $_message
 * @param $_optional
 * @return void
 */
function asserts ( &$_valid, $_message, $_optional = NULL )
{
    if ( empty( $_valid ) && empty( $_optional ) ) {
        Common::error503 ( $_message );
    } elseif ( !empty( $_optional ) ) {
        $_valid = $_optional;
    }
}

function isFunction ( $_function )
{
    return is_callable ( $_function );
}

function regex ( $Regex )
{
    return is_string ( $Regex )
        ? '/' . str_replace ( '/', '\/', $Regex ) . '/' : FALSE;
}

function str ( $_str )
{
    return (string) $_str;
}

function int ( $_str )
{
    return intval ( $_str );
}

function float ( $_param )
{
    return floatval ( $_param );
}

function object ( $_param )
{
    return is_array ( $_param )
        ? (object) $_param : FALSE;
}
