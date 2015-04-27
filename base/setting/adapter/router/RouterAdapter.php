<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 4/27/15
 * Time: 12:00 PM
 */

namespace core\adapter;

use core\App;
use core\Router;
use core\traits\DataStructure;

App::__require__ ( 'Router', 'core' );

final class RouterAdapter extends Router
{
    protected function handleMethod ( &$ValidURLS, $_buffer )
    {
        //Parse Request
        $ValidURLS->app->Request += $_request = ( DataStructure::cleanNumericKeys ( $_buffer ) );

        //Handle Post
        if ( $this->isPost () ) {
            $this->filterRequest ( $_POST );
            $ValidURLS->app->Request = array_merge ( $_POST, $_request );
        }

        //Handle Get
        if ( $this->isGet () ) {
            $this->filterRequest ( $ValidURLS->app->Request );
        }

        parent::handleMethod ( $ValidURLS, $_request );
    }
} 