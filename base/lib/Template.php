<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-12-14
 * Time: 10:25 AM
 */
namespace core\lib;

use core\App;
use core\Common;
use core\interfaces\iController;

class Template
{
    private static $_parser = NULL;
    private static $_controller = NULL;
    private static $_regions = [
        'scripts' => [ ],
        'styles'  => [ ]
    ];


    public static function __init ( iController $_Controller )
    {
        self::$_controller = $_Controller;
    }

    public static function writeRegion ( $_region )
    {
        if ( isset( self::$_regions[ $_region ] ) )
            echo self::$_regions[ $_region ][ 'content' ];
    }

    public static function getVar ( $_var )
    {
        return isset( $GLOBALS[ 'my_vars' ][ $_var ] )
            ? $GLOBALS[ 'my_vars' ][ $_var ] : NULL;
    }

    public static function writeAssets ( $_assets, $type = 'js' )
    {
        foreach ( $_assets as $as ) {
            if ( $type == 'css' ) {
                self::_addCss ( $as );
            } else {
                self::_addJs ( $as );
            }
        }
    }

    public static function isRegion ( $_region )
    {
        return !empty( self::$_regions[ $_region ] );
    }

    public static function addRegion ( $_region )
    {
        if ( !isset( self::$_regions[ $_region ] ) )
            self::$_regions[ $_region ] = [ ];

    }

    /**Change Default Skull Template
     * @param $_skull
     */
    public static function setSkull ( $_skull )
    {
        if ( App::__exist__ ( $_skull . '.skull', 'view/skull/' ) ) {
            self::$_controller->_default_skull = $_skull;
        } else {
            Common::error503 ( 'Skull ' . $_skull . ' does\'t exist' );
        }
    }


    public static function setParser ( $_parser, $dir )
    {
        self::$_parser = App::__instance__ ( $_parser, $dir );
    }

    public static function write ( $region, $content )
    {
        if ( isset( self::$_regions[ $region ] ) ) {
            self::$_regions[ $region ][ 'content' ][ ] = $content;
        } else {
            Common::error503 ( "Cannot write to the '{$region}' region. The region is undefined." );
        }
    }

    public static function writeView ( $region, $view, $data = [ ], $dir = 'template' )
    {
        if ( isset( self::$_regions[ $region ] ) ) {
            if ( ( $content = App::__render__ ( $view . '.tpl', $data, $dir ) ) ) {
                self::write ( $region, $content );
            }
        } else {
            Common::error503 ( "Cannot write to the '{$region}' region. The region is undefined." );
        }
    }

    public static function render ( $region = NULL )
    {
        if ( isset( $region ) ) {
            $_data = self::_writeOutput ( $region );

            return self::$_controller->renderToResponse ( $_data );
        } else {
            $_data = [ ];
            if ( count ( self::$_regions ) > 0 ) {
                foreach ( self::$_regions as $k => $v ) {
                    $_data[ ] = self::_writeOutput ( $k );
                }
            }

            return self::$_controller->renderToResponse ( $_data );
        }

    }

    private static function  _addJs ( $_dir )
    {
        $js = '<script src="' . $_dir . '"></script>';
        self::write ( 'scripts', $js );
    }

    private static function  _addCss ( $_dir )
    {
        $css = '<link rel="stylesheet" type="text/css" href="' . $_dir . '" />';
        self::write ( 'styles', $css );
    }

    private static function _writeOutput ( $_region = NULL )
    {
        if ( !isset( self::$_regions[ $_region ] ) ) {
            return FALSE;
        }

        $_buffer                                 = self::$_regions[ $_region ];
        self::$_regions[ $_region ][ 'content' ] = '';
        if ( count ( $_buffer ) > 0 ) {
            foreach ( $_buffer[ 'content' ] as $_content ) {
                self::$_regions[ $_region ][ 'content' ] .= $_content;
            }
        }

        return self::$_regions;
    }
}