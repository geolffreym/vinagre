<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-07-14
 * Time: 02:58 PM
 */

namespace core;

use core\interfaces\iController;

abstract class Controller implements iController
{

    public $Request = NULL;
    public $Method = NULL;
    public $Name = NULL;

    private static $_class = [ ];
    protected $_controller = NULL;
    protected $_model = NULL;
    protected $_loader = NULL;
    protected $_default_skull = NULL;

    public function __construct ()
    {

        $this->Method  = $_SERVER[ 'REQUEST_METHOD' ];
        $this->Name    = get_called_class ();
        $this->_loader = new Loader;
        $this->_loader->__init ( $this );

        if ( isset( $this->Session ) )
            $this->Session->__init ();

        if ( isset( $this->_model ) ) {
            if ( App::__exist__ ( $this->_model, 'model' ) )
                $this->_model = App::__instance__ ( $this->_model, 'model' );
        }

        if ( $this->Method === 'GET' ) {
            $this->_getTrigger ( $this->Request );
        } elseif ( $this->Method === 'POST' ) {
            $this->_postTrigger ( $_POST );
        } elseif ( $this->Method === 'PUT' ) {
            $this->_putTrigger ( $this->Request );
        } elseif ( $this->Method === 'DELETE' ) {
            $this->_deleteTrigger ( $this->Request );
        }

        //TODO PUT and DELETE http://stackoverflow.com/questions/12005790/how-to-receive-a-file-via-http-put-with-php

    }

    public function __init ( $_context = NULL )
    {
        return $this->renderToResponse ( $_context );
    }

    public static function asView ()
    {
        $_class = get_called_class ();
        if ( isset( self::$_class[ $_class ] ) )
            return self::$_class[ $_class ];

        if ( class_exists ( $_class ) ) {
            return ( self::$_class[ $_class ] = new $_class );
        }
    }


    private function _getTrigger ( &$GET )
    {
        if ( method_exists ( $this, 'get' ) ) {
            $this->get ( $GET );
        }
    }

    private function _postTrigger ( &$POST )
    {
        if ( method_exists ( $this, 'post' ) ) {
            $this->post ( $POST );
        }
    }

    private function _putTrigger ( &$PUT )
    {
        if ( method_exists ( $this, 'put' ) ) {
            $this->put ( $PUT );
        }
    }

    private function _deleteTrigger ( &$DELETE )
    {
        if ( method_exists ( $this, 'delete' ) ) {
            $this->delete ( $DELETE );
        }
    }


    protected function contextData ()
    {
        if ( method_exists ( $this, 'getContextData' ) ) {
            return $this->getContextData ();
        } else {
            return [ ];
        }
    }


    protected function _setSkull ( $_skull )
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