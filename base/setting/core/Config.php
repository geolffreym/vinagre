<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 08-09-14
 * Time: 03:04 PM
 */

namespace core;

class Config
{
    static $_config = [ ];

    public static function findConfig ( $_name, $_conf )
    {
        if ( !isset( self::$_config[ $_name ] ) ) {
            if ( count ( $_conf ) === count ( self::getConfig ( $_conf ) ) ) {
                self::$_config[ $_name ] = $_conf;
            } else {
                return FALSE;
            }
        }

        return self::$_config[ $_name ];
    }

    public static function getConfig ( $_find = [ ] )
    {
        if ( !is_array ( $_find ) ) {
            Common::error503 ( 'Config Array Needed' );
        }
        $_constant = get_defined_constants ( TRUE )[ 'user' ];
        $_return   = [ ];
        foreach ( $_find as $value ) {
            if ( isset ( $_constant[ $value ] ) ) {
                $_return[ $value ] = $_constant[ $value ];
            }
        }

        return $_return;
    }

} 