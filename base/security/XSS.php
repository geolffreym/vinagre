<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-07-14
 * Time: 01:55 PM
 */

namespace core\security;


class XSS
{
    public static function cleanString ( $_str )
    {
        return filter_var ( $_str, FILTER_SANITIZE_STRING );
    }

    public static function cleanURL ( $_url )
    {
        return filter_var ( $_url, FILTER_SANITIZE_URL );
    }
} 