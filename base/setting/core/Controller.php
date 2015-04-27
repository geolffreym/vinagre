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

class Controller implements iController
{

    public $Name = NULL;
    public $Request = [ ];
    protected $Session = NULL;
    protected $Model = NULL;
    protected $Tpl = NULL;

    private $_language = NULL;

    private $_loader = NULL;
    private static $_class = [ ];

    // protected $_controller = NULL;

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
       // $this->Session->regenerate();
        $this->Session->__init ();

        //Init CSRF Token if active
        if ( CSRFToken::isServiceActive () ) {
            CSRFToken::__init ();
        }

        //Init Model
        if ( isset( $this->Model ) ) {
            if ( App::__exist__ ( $this->Model, 'model' ) )
                $this->Model = App::__instance__ ( $this->Model, 'model' );
        }
    }

    public function __toString ()
    {
        return $this->Name;
    }

    public function __init ( $_context = [] )
    {
        return $this->renderToResponse ( $_context );
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
        $this->Tpl = $_skull;
    }

    public function renderToResponse ( $_context = [ ] )
    {

        if ( !empty( ( $n_context = $this->contextData () ) ) )
            $_context += $n_context;

        if ( !empty( $this->Tpl ) ) {
            if ( ( $_template = App::__render__ ( $this->Tpl . '.tpl', $_context ) ) ) {
                return [ 'template' => $_template ];
            } else {
                Common::error503 ( $this->Tpl . ' does\'t exist.' );
            }
        }

        return FALSE;
    }
}