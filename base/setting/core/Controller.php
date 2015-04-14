<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-07-14
 * Time: 02:58 PM
 */

namespace core;

use core\interfaces\iController;
use core\security\CSRFToken;

abstract class Controller implements iController
{

    public $Name = NULL;
    public $Request = NULL;
    protected $Session = NULL;

    private $_language = NULL;
    private static $_class = [ ];

    protected $_controller = NULL;
    protected $_model = NULL;
    protected $_loader = NULL;
    protected $_default_skull = NULL;

    final public function __construct ()
    {

        $this->Name = get_called_class ();

        // Init Loader /core
        $this->_loader = new Loader;
        $this->_loader->__init ( $this );

        //Init Language /core
        $this->_language = new Language;
        $this->_language->__init ();

        //Init Session /lib
        $this->Session = new Session();

        //Init CSRF Token if active
        if ( CSRFToken::isServiceActive () ) {
            CSRFToken::__init ();
        }

        //Init Model
        if ( isset( $this->_model ) ) {
            if ( App::__exist__ ( $this->_model, 'model' ) )
                $this->_model = App::__instance__ ( $this->_model, 'model' );
        }
    }

    public function __init ( $_context = NULL )
    {
        return $this->renderToResponse ( $_context );
    }


    public function filterPost ( &$_post )
    {

        if ( CSRFToken::isServiceActive () ) {
            if ( !isset( $_post[ 'csrf_token' ] ) )
                Common::error503 ( 'Undefined CSRF Token' );

            if ( !CSRFToken::validate ( $_post[ 'csrf_token' ] ) )
                Common::error503 ( 'Invalid Token' );

        }

        if ( Config::findConfig ( 'XSS_GLOBAL', [ 'XSS_GLOBAL_PROTECTION' ] ) ) {
            $_xss = App::__load__ ( 'XSS', 'security', 'core\\security' );
            $_xss->cleanRequest ( $_post );
        }

    }

    public static function asView ()
    {
        $_class = get_called_class ();
        if ( isset( self::$_class[ $_class ] ) )
            return self::$_class[ $_class ];

        // if ( class_exists ( $_class ) ) {
        return ( self::$_class[ $_class ] = new $_class );
        //}
    }

    protected function contextData ()
    {
        if ( method_exists ( $this, 'getContextData' ) ) {
            return $this->getContextData ();
        } else {
            return [ ];
        }
    }


    protected function setSkull ( $_skull )
    {
        $this->_default_skull = $_skull;
    }

    public function renderToResponse ( $_context = NULL )
    {
        $_context = !isset( $_context )
            ? $this->contextData () : $_context;

        if ( !empty( $this->_default_skull ) ) {
            if ( ( $_template = App::__render__ ( $this->_default_skull . '.skull', $_context ) ) ) {
                return [ 'template' => $_template ];
            } else {
                Common::error503 ( $this->_default_skull . ' does\'t exist.' );
            }
        }

        return FALSE;
    }
}