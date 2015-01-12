<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-07-14
 * Time: 02:25 PM
 */

namespace core\security;

class String
{
    public static function htmlEntity ( $_html )
    {
        return filter_var ( $_html, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    }

    public static function fileNameSanitize ( $_name )
    {
        return filter_var ( $_name, FILTER_SANITIZE_URL );
    }

    public static function passwordCrypt ( $_str, $_conf = [ 'cost' => 12 ] )
    {
        return password_hash ( $_str, PASSWORD_BCRYPT, $_conf );
    }

    public static function passwordVerify ( $_pass, $_hash )
    {
        return password_verify ( $_pass, $_hash );
    }
} 