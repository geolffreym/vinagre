<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 04-14-15
 * Time: 08:56 AM
 */

namespace core\lib;


class Shortcuts
{
    public static function passwordCrypt ( $_str, $_conf = [ 'cost' => 12 ] )
    {
        return password_hash ( $_str, PASSWORD_BCRYPT, $_conf );
    }

    public static function passwordVerify ( $_pass, $_hash )
    {
        return password_verify ( $_pass, $_hash );
    }
} 