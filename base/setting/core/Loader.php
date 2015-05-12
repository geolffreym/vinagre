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
    private static $_interfaces = [ ];
    private static $_sparks = [ ];
    private static $_instance = NULL;

    private static $_libraries_dir = 'lib';
    private static $_interfaces_dir = 'interface';
    private static $_helper_dir = 'helper';
    private static $_traits_dir = 'traits';
    private static $_sparks_dir = 'sparks';

    public function __construct ()
    {

    }

    public function __init ( iController &$controller )
    {
        self::$_libraries_dir  = 'lib';
        self::$_interfaces_dir = 'interface';

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
        if ( count ( $_load ) > 0 ) {
            foreach ( $_load as $lib ) {
                $_dir = $_dir . '/' . strtolower ( $lib );
                if ( App::__require__ ( $lib, $_dir ) ) {
                    self::$_libraries_dir  = $_dir . '/lib';
                    self::$_interfaces_dir = $_dir . '/interface';
                    App::__require__ ( 'autoload', $_dir . '/config', TRUE );

                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    public function autoloader ( iController &$controller )
    {
        if ( !App::__require__ ( 'autoload', 'enviroment/' . ENVIRONMENT, TRUE ) ) {
            Common::error503 ( 'Not auto loader file found' );
        }

        $this->_dinamicProperty ( self::$_libraries, self::$_libraries_dir, $controller, 'core\\lib' );
        $this->_dinamicRequire ( self::$_helpers, self::$_helper_dir, 'Helper' );
        $this->_dinamicInterfaces ( self::$_interfaces, self::$_interfaces_dir );
        $this->_dinamicRequire ( self::$_traits, self::$_traits_dir );

        if ( $this->_dinamicSparks ( self::$_sparks, self::$_sparks_dir ) ) {
            $this->_dinamicInterfaces ( self::$_interfaces, self::$_interfaces_dir );
            $this->_dinamicProperty ( self::$_libraries, self::$_libraries_dir, $controller, 'core\\sparks\\lib' );
        }


    }

    public static function libraries ( ...$args )
    {
        self::$_libraries = $args;
    }

    public static function helpers ( ...$args )
    {
        self::$_helpers = $args;
    }

    public static function traits ( ...$args )
    {
        self::$_traits = $args;
    }

    public static function interfaces ( ...$args )
    {
        self::$_interfaces = $args;
    }

    public static function spark ( ...$args )
    {
        self::$_sparks = $args;
    }
} 