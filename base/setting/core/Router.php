<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-04-14
 * Time: 01:03 PM
 */

namespace core;


use core\adapter\HttpAdapter;
use core\interfaces\iURL;
use core\interfaces\iController;

App::__require__ ( 'HttpAdapter', 'adapter/http' );


class Router extends HttpAdapter
{

    private static $_method = 'GET';
    private static $_matched = [ ];
    private static $_response = NULL;


    private function _isValidTemplate ()
    {
        if ( isset( self::$_response[ 'template' ] ) ) {
            return self::$_response[ 'template' ];
        } elseif ( !empty ( self::$_response ) ) {
            return self::$_response;
        }

        return NULL;
    }

    private function appendUri ( &$ValidURLS )
    {
        $ValidURLS->uri = App::__exist__ ( $ValidURLS->controller, 'controller' )
            ? str_replace ( $ValidURLS->controller, '', strtolower ( $ValidURLS->uri ) )
            : $ValidURLS->uri;
        $ValidURLS->uri = ltrim ( $ValidURLS->uri, '/' );

        //Give query string support
        if ( ( @preg_match ( regex ( '\?.*' ), $ValidURLS->uri, $buffer ) ) ) {
            $ValidURLS->uri = str_replace ( $buffer[ 0 ], '', $ValidURLS->uri );

            //Parsing Query String
            parse_str ( str_replace ( '?', '', $buffer[ 0 ] ), $buffer );
            $ValidURLS->app->Request = $buffer;
        }
    }

    protected function handleMethod ( &$ValidURLS, $_request )
    {

        //Assign Request to Controller
        $ValidURLS->app->Request             = object ( $ValidURLS->app->Request );
        $ValidURLS->app->Request->httpMethod = $this->getHttpMethod ();
        $ValidURLS->app->Request->isAjax     = $this->isAjax ();
        $ValidURLS->app->Request->remoteIp   = $this->getRemoteIp ();
        $ValidURLS->app->Request->userAgent  = $this->getUserAgent ();

        $_action = isset( $_request->action )
            ? $_request->action
            : strtolower ( $this->getHttpMethod () );

        //Process response
        self::$_response = method_exists ( $ValidURLS->app, $_action )
            ? $ValidURLS->app->{$_action}()
            : $ValidURLS->app->__init ();
    }

    public function getMatched ()
    {
        return self::$_matched;
    }

    public function matchRoute ( iURL $URL )
    {
        foreach ( $URL->getUrl () as $ValidURLS ) {

            Exception::create ( function () use ( $ValidURLS ) {
                    return !empty($ValidURLS->app) && $ValidURLS->app instanceof iController;
                }, 'The instance of the ' . get_class ( $ValidURLS ) . ' must be ' . 'iController'
            );


            self::appendUri ( $ValidURLS );

            $_Regex = $ValidURLS->regex;
            $_Uri   = $ValidURLS->uri;

            if ( isset( $ValidURLS->app ) ) {
                if ( !@preg_match ( $_Regex, rtrim ( $_Uri, '/' ), $_buffer ) ) continue;
                self::$_matched[ $ValidURLS->uri ] = $_Regex;
                $this->handleMethod ( $ValidURLS, $_buffer );
                break;

            }

        };
    }


    public function writeResponse ()
    {
        $_is_template = $this->_isValidTemplate ();
        if ( isset( $_is_template ) ) {
            echo $_is_template;
        } elseif ( is_null ( $_is_template ) && self::$_method === 'GET' ) {
            Common::error404 ( 'Page not found' );
        }
    }


}