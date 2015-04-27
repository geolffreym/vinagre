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
use core\Http;
use core\security\CSRFToken;
use core\security\XSS;

App::__require__ ( 'Http', 'core' );

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


        if ( XSS::isServiceActive () ) {
            XSS::cleanRequest ( $_request );
        }

    }
} 