<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 01-26-15
 * Time: 08:55 PM
 */

/** URL Processor
 * @param $_regex
 * @param $_controller
 * @param $params
 */
use core\App;
use core\interfaces\iController;

function url ( $_regex, $_controller )
{
    $_return        = object ( [ ] );
    $_return->regex = regex ( $_regex );
    if ( $_controller instanceof iController ) {
        $_return->uri        = $_SERVER[ 'REQUEST_URI' ];
        $_return->controller = getControllerUri ( $_return->uri );
        $_return->app        = $_controller;
    } else {
        $_return->dir = $_controller->dir;
        $_return->url = App::__load__ ( strtoupper ( $_controller->file ), $_return->dir, 'core\\uri\\' . $_controller->controller );
    }

    return $_return;
}

function getControllerUri ( $_dir )
{
    return explode ( '/', rtrim ( ltrim ( $_dir, '/' ), '/' ) )[ 0 ];
}

function append ( $_dir )
{
    $_dir     = str_replace ( '.', '/', $_dir );
    $_explode = explode ( '/', $_dir );
    $_dir     = 'controller/' . $_explode[ 0 ];

    if ( App::__exist__ ( 'URL', $_dir ) ) {
        return (object) [
            'controller' => $_explode[ 0 ],
            'file'       => $_explode[ 1 ],
            'dir'        => $_dir
        ];
    }

    return FALSE;
}

function redirect($url){
    App::__redirect__($url);
}