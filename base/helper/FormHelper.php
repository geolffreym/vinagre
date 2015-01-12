<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 08-10-14
 * Time: 10:46 AM
 */
namespace core\helper;
use core\App;
use core\Common;

class FormHelper
{
    private static $_source = [ ];

    public static function getForm ( $_name )
    {
        if ( App::__exist__ ( $_name, 'view/forms/' ) ) {
            App::__require__ ( $_name, 'view/forms/' );

            return self::getSource ( $_name );
        } else {
            Common::error503 ( 'Form ' . $_name . ' does\'t exist' );
        }

        return [ ];
    }

    public static function source ( $_name, $_array )
    {
        if ( is_array ( $_array ) ) {
            self::$_source[ $_name ] = $_array;
        }
    }

    public static function getSource ( $_name )
    {
        return self::$_source[ $_name ];
    }
}