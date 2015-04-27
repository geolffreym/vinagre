<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 04-11-14
 * Time: 07:48 PM
 */
namespace core;

final class App
{
    private static $_class = [ ];
    private static $_loaded_class = [ ];

    //Auto Invoke Class
    public function __invoke ()
    {
        return [ BASE_APP, SYSTEM_PATH, SETTING_PATH ];
    }

    /**Verify Files
     * @param $_class
     * @param $_dir
     * @return Bool
     **/
    public static function __exist__ ( $_class, $_dir )
    {
        $_exist = FALSE;
        foreach ( ( new self() )->__invoke () as $_PATH ) {
            $dir  = $_PATH . '/' . $_dir . '/' . $_class;
            $file = $dir . '.php';
            if ( file_exists ( $file ) ) {
                $_exist = $file;
                break;
            } elseif ( is_dir ( $dir ) ) {
                $_exist = $_dir;
                break;
            }
        }

        return $_exist;
    }

    /**Load App Files
     * @param $_class
     * @param $_dir
     * @param $_namespace
     * @return Array
     **/
    public static function __load__ ( $_class, $_dir, $_namespace = NULL )
    {
        if ( isset( self::$_class[ $_class ] ) ) {
            return self::$_class[ $_class ];
        }

        if ( ( $_exist_ = self::__exist__ ( $_class, $_dir ) ) ) {
            return self::__instance__ ( $_class, $_dir, $_namespace );
        } else {
            return FALSE;
        }

    }

    public static function __instance__ ( $_class, $_dir, $_namespace = NULL, $_param = FALSE )
    {
        if ( self::__require__ ( $_class, $_dir ) ) {
            // if ( !class_exists ( $_class ) ) {
            $_namespace = isset( $_namespace ) ? $_namespace . '\\' . $_class : $_class;

            return $_param ? new $_namespace( $_param ) : new $_namespace;
            // }

        }

        return FALSE;
    }

    public static function __require__ ( $_file, $_dir, $_overwrite = FALSE )
    {
        if ( ( $_exist = self::__exist__ ( $_file, $_dir ) ) ) {
            self::__loaded__ ( $_file, $_exist );
            if ( $_overwrite ) {
                @require ( $_exist );
            } else {
                @require_once ( $_exist );
            }

            return $_exist;
        }

        return FALSE;
    }

    /**Load App Interfaces
     * @param $_interface
     * @param $_dir
     * @return Bool
     **/
    public static function __interface__ ( $_interface, $_dir )
    {
        if ( ( $_exist = self::__require__ ( $_interface, $_dir ) ) ) {
            if ( !interface_exists ( $_interface ) ) {
                return $_exist;
            }
        }

        return FALSE;
    }

    public static function __loaded__ ( $_class, $_dir )
    {
        if ( !empty( $_class ) ) {
            self::$_loaded_class[ $_class ] = $_dir;
        }

        return self::$_loaded_class;
    }

    /**Render View
     * @param $view
     * @param $data
     * @param $dir
     * @param $flush
     * @return String
     */
    public static function __render__ ( $view, $data = [ ], $dir = 'skull', $flush = FALSE )
    {
        if ( ( $_exist = self::__exist__ ( $view, 'view/' . $dir ) ) ) {
            self::__vars__ ( $data );
            //var_dump($GLOBALS);
            if ( @ob_start () ) {
                @include ( $_exist );
                if ( $flush ) {
                    return @ob_get_flush ();
                } else {
                    return @ob_get_clean ();
                }
            } else {
                Exception::throwException ( 'errorTemplateHandler' );
            };

        }

        return FALSE;

    }

    private static function __vars__ ( $data )
    {
        if ( !isset( $GLOBALS[ 'my_vars' ] ) ) {
            $GLOBALS[ 'my_vars' ] = [ ];
        }
        if ( isset( $data ) ) {
            $GLOBALS[ 'my_vars' ] += ( $data );
        }
    }


    public static function __callback__ ( $_callback, $_param )
    {
        if ( !empty( $_callback ) && isFunction ( $_callback ) ) {
            return $_callback( $_param );
        }

        return $_param;
    }

}

