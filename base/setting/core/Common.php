<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-07-14
 * Time: 10:03 AM
 */
namespace core;
class Common
{
    public static function error500 ( $_message )
    {
        header ( 'HTTP/1.1 500 Internal Server Error.', TRUE, 500 );
        die( $_message );
    }

    public static function error503 ( $_message )
    {
        header ( 'HTTP/1.1 503 Service Unavailable.', TRUE, 503 );
        die( $_message );
    }

    public static function error404 ( $_message )
    {
        header ( 'HTTP/1.1 404 Page Not Found.', TRUE, 404 );
        die( $_message );
    }
}
