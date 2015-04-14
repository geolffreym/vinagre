<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-17-14
 * Time: 06:05 PM
 */
namespace core\lib;
class Json
{
    private static $_option = JSON_PRETTY_PRINT;
    private static $_conf = [
        'pretty'  => JSON_PRETTY_PRINT,
        'numeric' => JSON_NUMERIC_CHECK,
        'html'    => JSON_HEX_TAG,
        'amp'     => JSON_HEX_AMP,
        'apos'    => JSON_HEX_APOS,
        'quote'   => JSON_HEX_QUOT,
        'force'   => JSON_FORCE_OBJECT
    ];

    public static function writeAt ( $_string )
    {
        if ( isset( self::$_conf[ $_string ] ) )
            self::$_option = self::$_conf[ $_string ];
    }

    public static function writeSecure ( $_array, $_type = NULL )
    {
        if ( !isset( $_type ) )
            $_type = self::$_option;

        return 'while(1);' . json_encode ( $_array, $_type );
    }

    public static function write ( $_array, $_type = NULL )
    {
        if ( !isset( $_type ) )
            $_type = self::$_option;

        return json_encode ( $_array, $_type );
    }

    public static function read ( $_array, $_assoc = TRUE )
    {
        return json_decode ( $_array, $_assoc );
    }

    public static function getError ()
    {
        return json_last_error_msg ();
    }


} 