<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-07-14
 * Time: 10:03 AM
 */
namespace core;
final class Common
{
    public static function error500 ( $_message )
    {
        header ( 'HTTP/1.1 500 Internal Server Error.', TRUE, 500 );
        if ( Config::findConfig ( 'DEFAULT_500', [ 'DEFAULT_500_PAGE' ] ) ) {
            if ( App::__exist__ ( DEFAULT_500_PAGE, 'view/template/error' ) ) {
                echo App::__render__ ( DEFAULT_500_PAGE, [ ], 'template/error' );
                die();
            }
        }
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
        if ( Config::findConfig ( 'DEFAULT_404', [ 'DEFAULT_404_PAGE' ] ) ) {
            if ( App::__exist__ ( DEFAULT_404_PAGE, 'view/template/error' ) ) {
                echo App::__render__ ( DEFAULT_404_PAGE, [ ], 'template/error' );
                die();
            }

        }
        die( $_message );
    }

    /**Redirect Url
     * @param $_url
     * */
    public static function redirect ( $_url )
    {
        header ( 'HTTP/1.1 307 Temporary Redirect.', TRUE, 404 );
        header ( 'Location:' . $_url, 30 );
    }
}
