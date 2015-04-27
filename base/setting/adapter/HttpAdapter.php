<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 4/27/15
 * Time: 11:02 AM
 */

namespace core\adapter;


use core\App;
use core\Common;
use core\Config;
use core\Http;
use core\security\CSRFToken;

abstract class HttpAdapter extends Http
{
    public function filterRequest ( &$_request )
    {
        if ( $this->isPost () ) {
            if ( CSRFToken::isServiceActive () ) {
                if ( !isset( $_request[ 'csrf_token' ] ) )
                    Common::error503 ( 'Undefined CSRF Token' );

                if ( !CSRFToken::validate ( $_request[ 'csrf_token' ] ) )
                    Common::error503 ( 'Invalid Token' );

            }
        }


        if ( Config::findConfig ( 'XSS_GLOBAL', [ 'XSS_GLOBAL_PROTECTION' ] ) ) {
            $_xss = App::__load__ ( 'XSS', 'security', 'core\\security' );
            $_xss->cleanRequest ( $_request );
        }

    }
} 