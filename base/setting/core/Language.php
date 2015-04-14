<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-30-14
 * Time: 11:04 AM
 */

namespace core;

final class Language
{
    public static $_lang = DEFAULT_LANGUAGE;
    public static $_lang_array = [ ];


    public function __init ( $_lang = DEFAULT_LANGUAGE )
    {
        self::_getLang ( $_lang );
    }

    public static function changeLang ( $_lang )
    {
        self::$_lang = $_lang;
        self::_getLang ( self::$_lang );
    }

    private static function _getLang ( $_language )
    {
        App::__require__ ( $_language, 'language' );
    }

    public static function setCollection ( $lang )
    {
        self::$_lang_array = $lang;
    }

    public static function parseLang ( $index, $content = NULL )
    {
        if ( isset( self::$_lang_array[ $index ] ) ) {
            if ( isset( $content ) ) {
                return sprintf ( self::$_lang_array[ $index ], $content );
            } else {
                return self::$_lang_array[ $index ];
            }
        }

        return $content;
    }
} 