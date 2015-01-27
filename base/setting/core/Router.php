<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-04-14
 * Time: 01:03 PM
 */

namespace core;

use core\interfaces\iController;
use core\interfaces\iURL;
use core\traits\DataStructure;

class Router
{
    private static $_method = 'GET';
    private static $_matched = [ ];
    private static $_response = NULL;

    private static function _queryParse ( &$_output )
    {
        if ( isset( $_output[ 'query' ] ) ) {
            parse_str ( str_replace ( '?', '', $_output[ 'query' ] ), $arr );
            $_output[ 'query' ] = (object) $arr;
        }
    }

    private static function _isValidTemplate ()
    {
        if ( isset( self::$_response[ 'template' ] ) ) {
            return self::$_response[ 'template' ];
        } elseif ( is_string ( self::$_response ) ) {
            return self::$_response;
        }

        return NULL;
    }

    private static function appendUri ( &$ValidURLS )
    {
        $ValidURLS->uri = App::__exist__ ( $ValidURLS->controller, 'controller' )
            ? str_replace ( $ValidURLS->controller, '', strtolower ( $ValidURLS->uri ) )
            : $ValidURLS->uri;
        $ValidURLS->uri = ltrim ( $ValidURLS->uri, '/' );
    }

    public static function getMatched ()
    {
        return self::$_matched;
    }

    public static function matchRoute ( iURL $URL )
    {
        foreach ( $URL->getUrl () as $ValidURLS ) {
            $_Regex = $ValidURLS->regex;
            self::appendUri ( $ValidURLS );
            //breakPoint ( $ValidURLS );
            if ( isset( $ValidURLS->app ) ) {
                if ( @preg_match ( $_Regex, rtrim ( $ValidURLS->uri, '/' ), $_output ) ) {
                    Exception::create ( function () use ( $ValidURLS ) {
                            return $ValidURLS->app instanceof iController;
                        }, 'The instance of the ' . get_class ( $ValidURLS ) . ' must be ' . 'iController'
                    );

                    self::$_method                     = $ValidURLS->app->Method;
                    self::$_matched[ $ValidURLS->uri ] = $_Regex;

                    if ( self::$_method !== 'POST' ) {
                        self::_queryParse ( $_output );
                        $ValidURLS->appRequest = $_request = (object) DataStructure::cleanNumericKeys ( $_output );
                        $_action               = isset( $_request->action )
                            ? $_request->action
                            : FALSE;

                        self::$_response = method_exists ( $ValidURLS->app, $_action )
                            ? $ValidURLS->app->{$_action}() : $ValidURLS->app->__init ();
                    }

                    break;
                }
            }

        };
    }


    public static function writeResponse ()
    {
        $_is_template = self::_isValidTemplate ();
        if ( isset( $_is_template ) ) {
            echo $_is_template;
        } elseif ( is_null ( $_is_template ) && self::$_method === 'GET' ) {
            Common::error404 ( 'Page not found' );
        }
    }


}