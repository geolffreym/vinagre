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

    private static function _makeUrl ( iURL $URL )
    {
        $_URL = explode ( '/', rtrim ( $URL->URI, '/' ) );

        return array_pop ( $_URL );
    }

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

    public static function getMatched ()
    {
        return self::$_matched;
    }

    public static function matchRoute ( iURL $URL )
    {
        foreach ( $URL->getUrl () as $Regex => $ValidURLS ) {
            $_Regex = '/' . $Regex . '/';
            if ( @preg_match ( $_Regex, rtrim ( $URL->URI, '/' ), $_output ) ) {

                Exception::create ( function () use ( $ValidURLS ) {
                        return $ValidURLS instanceof iController;
                    }, 'The instance of the ' . get_class ( $ValidURLS ) . ' must be ' . 'iDBController'
                );

                self::$_method               = $ValidURLS->Method;
                self::$_matched[ $URL->URI ] = $_Regex;

                if ( self::$_method !== 'POST' ) {
                    self::_queryParse ( $_output );

                    $ValidURLS->Request = $_request = (object) DataStructure::cleanNumericKeys ( $_output );
                    $_action            = isset( $_request->action )
                        ? $_request->action
                        : self::_makeUrl ( $URL );

                    self::$_response = method_exists ( $ValidURLS, $_action )
                        ? $ValidURLS->{$_action}() : $ValidURLS->__init ();
                }

                break;
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