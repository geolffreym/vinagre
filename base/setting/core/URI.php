<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-04-14
 * Time: 12:26 PM
 */

namespace core;

class URI
{
    private static $URI = NULL;
    private static $DIR = NULL;

    public static function checkURI ( $URI )
    {
        self::$URI = ltrim ( $URI, '/' );

        return self::loadURLDir ( explode ( '/', self::$URI )[ 0 ] );
    }

    public static function loadURLDir ( $DIR )
    {
        self::$DIR = ( !empty( $DIR ) && App::__exist__ ( $DIR, 'controller' ) )
            ? $DIR : DEFAULT_CONTROLLER;

        self::$DIR = 'controller/' . self::$DIR;

        return self::loadFileUrls ( self::$DIR );
    }

    public static function loadFileUrls ( $DIR )
    {
        $_CLASS = App::__load__ ( 'URL', $DIR );

        if ( !$_CLASS ) {
            Common::error404 ( 'Not ' . self::$URI . ' controller found' );
        } else {
            $_CLASS->URI = self::$URI;

            return $_CLASS;
        }

        return FALSE;
    }
}