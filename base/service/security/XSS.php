<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-07-14
 * Time: 01:55 PM
 */

namespace core\security;

use core\Config;
use core\interfaces\iService;

final class XSS implements iService
{
    public static function htmlEntity ( $_html )
    {
        return filter_var ( $_html, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    }

    public static function cleanString ( $_str )
    {
        return filter_var ( $_str, FILTER_SANITIZE_STRING );
    }

    public static function cleanURL ( $_url )
    {
        return filter_var ( $_url, FILTER_SANITIZE_URL );
    }

    public static function cleanRequest ( &$_post )
    {
        foreach ( $_post as $k => $_post_fix ) {
            $_post[ $k ] = self::htmlEntity ( $_post_fix );
        }
    }

    public static function isServiceActive ()
    {
        return Config::findConfig ( 'XSS_GLOBAL', [ 'XSS_GLOBAL_PROTECTION' ] );
    }
} 