<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-11-14
 * Time: 12:02 PM
 */

namespace core;

use core\interfaces\iController;

final class Loader
{
    private static $_libraries = [ ];
    private static $_helpers = [ ];
    private static $_traits = [ ];
    private static $_database = [ ];
    private static $_interfaces = [ ];
    private static $_sparks = [ ];
    private static $_security = [ ];
    private static $_instance = NULL;
    private static $_security_dir = 'security';
    private static $_libraries_dir = 'lib';
    private static $_interfaces_dir = 'interface';
    private static $_helper_dir = 'helper';
    private static $_database_dir = 'db/driver/';
    private static $_traits_dir = 'traits';
    private static $_sparks_dir = 'sparks';

    public function __construct ()
    {

    }

    public function __init ( iController &$controller )
    {
        $this->autoloader ( $controller );

        if ( !isset( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function _dinamicProperty ( $_load, $_dir, $controller, $namespace = NULL )
    {
        if ( count ( $_load ) > 0 ) {
            foreach ( $_load as $lib ) {
                $controller->{$lib} = App::__load__ ( $lib, $_dir, $namespace );
            }
        }
    }

    private function _dinamicInterfaces ( $_load, $_dir )
    {
        if ( count ( $_load ) > 0 ) {
            foreach ( $_load as $interface ) {
                App::__interface__ ( $interface, $_dir );
            }
        }
    }

    private function _dinamicRequire ( $_load, $_dir, $_suffix = '' )
    {
        if ( count ( $_load ) > 0 ) {
            foreach ( $_load as $lib ) {
                App::__require__ ( $lib . $_suffix, $_dir );
            }
        }
    }

    private function _dinamicSparks ( $_load, $_dir )
    {
        if ( count ( self::$_sparks ) > 0 ) {
            foreach ( $_load as $lib ) {
                $_dir = $_dir . '/' . strtolower ( $lib );
                if ( App::__require__ ( $lib, $_dir ) ) {
                    self::$_libraries_dir  = $_dir . '/lib';
                    self::$_interfaces_dir = $_dir . '/interface';
                    App::__require__ ( 'autoload', $_dir . '/config' );

                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    private function _switchDriver ( $_driver )
    {
        switch ( $_driver ) {
            case 'oci8':
                return 'oci8';
                break;
            case 'mysql':
            case 'mysqli':
            default:
                return 'mysql';
                break;
        }
    }

    public function autoloader ( iController &$controller )
    {
        if ( !App::__require__ ( 'autoload', 'enviroment/' . ENVIRONMENT ) ) {
            Common::error503 ( 'Not auto loader file found' );
        }

        $this->_dinamicProperty ( self::$_libraries, self::$_libraries_dir, $controller, 'core\\lib' );
        $this->_dinamicRequire ( self::$_helpers, self::$_helper_dir, 'Helper' );
        $this->_dinamicRequire ( self::$_database, self::$_database_dir . self::_switchDriver ( DB_DRIVER ) . '/helper', 'Helper' );
        $this->_dinamicInterfaces ( self::$_interfaces, self::$_interfaces_dir );
        $this->_dinamicRequire ( self::$_traits, self::$_traits_dir );
        $this->_dinamicRequire ( self::$_security, self::$_security_dir );

        self::$_libraries  = [ ];
        self::$_interfaces = [ ];
        if ( $this->_dinamicSparks ( self::$_sparks, self::$_sparks_dir ) ) {
            $this->_dinamicInterfaces ( self::$_interfaces, self::$_interfaces_dir );
            $this->_dinamicProperty ( self::$_libraries, self::$_libraries_dir, $controller, 'core\\lib' );
        }


    }

    public static function libraries ()
    {
        self::$_libraries += func_get_args ();
    }

    public static function helpers ()
    {
        self::$_helpers += func_get_args ();
    }

    public static function traits ()
    {
        self::$_traits += func_get_args ();
    }

    public static function interfaces ()
    {
        self::$_interfaces += func_get_args ();
    }

    public static function security ()
    {
        self::$_security += func_get_args ();
    }


    public static function db ()
    {
        self::$_database += func_get_args ();
    }

    public static function spark ()
    {
        self::$_sparks += func_get_args ();
    }
} 