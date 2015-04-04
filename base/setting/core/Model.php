<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 04-12-14
 * Time: 02:38 PM
 */
namespace core;

App::__require__ ( 'DataStructure', 'traits' );

use core\traits\DataStructure;
use core\interfaces\iModel;

abstract class Model implements iModel
{

    use DataStructure;

    static $_alias = [ ];
    private $_aliases = 'abcdefghijklmnopqrstuvwxyz';
    protected $db = NULL;
    protected $cache = NULL;
    protected $_fields = [ ];
    protected $_name = NULL;


    final public function __construct ()
    {
        $this->switchDb ( DB_DRIVER );
        $this->activeCache ( DB_CACHE );
        $this->_name = $this->getModelName ();

    }

    public function __toString ()
    {
        return $this->_name;
    }

   final public function __invoke ( $_attr )
    {
        return $this->getAlias () . '.' . $_attr;
    }

    final public function getModelName ()
    {
        return get_class ( $this );
    }

    /**Return Class Atributes
     * @return Array
     * */
    final public function getModelAttributes ()
    {
        $_attributes = get_class_vars ( $this->getModelName () );

        return [
            'keys'   => array_keys ( $_attributes ),
            'values' => array_values ( $_attributes )
        ];
    }

    /**Get model fields
     * @return Array
     */
    final public function getFields ()
    {
        $this->_fields = self::getModelAttributes ();
        $this->_fields = self::filterByMatch ( $this->_fields[ 'keys' ], '([\\_](\w)+[\\_])' );
        $this->_fields = self::replaceByMatch ( $this->_fields, '/[\\_]/', '', 1 );

        return $this->_fields;
    }

    /**Sanitaze fields
     * @param $fields
     * @return Array
     * */
    final public function prepareFields ( $fields )
    {
        $_new = [ ];
        foreach ( $fields as $key => $val ) {
            $_new[ $key ] = $this->db->Result->prepare ( $val );
        }

        return $_new;
    }

    final public function getAlias ()
    {
        $this->_aliases = $this->_generateAliases ();
        if ( !isset( self::$_alias[ $this->_name ] ) ) {
            self::$_alias[ $this->_name ] = $this->_aliases;
        }

        return self::$_alias[ $this->_name ];
    }

    //Return Error
    final public function error ()
    {
        return $this->db->Error->getErrorDescription ();
    }

    /**Validate Fields and verify the fields if exist in model
     * @param $field
     * @param $array
     * @return Array
     */
    final public function validateField ( $field, $array = FALSE )
    {
        $_fields = $this->getFields ();
        $_return = [ ];
        foreach ( $field as $f ) {
            if ( in_array ( $f, $_fields ) || isset( $f[ 'attr' ] ) ) {
                $_return[ ] = $f;
            }
        }

        return $array ? $_return : implode ( ',', $_return );

    }

    final public function switchDb ( $_driver )
    {
        switch ( $_driver ) {
            case 'mysql':
            case 'mysqli':
            default:
                $this->db = App::__load__ ( 'MySql', 'db/driver', 'core\\db\\mysql\\model' );
                break;
            case 'oci8':
                $this->db = App::__load__ ( 'Oracle', 'db/driver', 'core\\db\\oracle\\model' );
                break;
        }
    }

    final public function activeCache ( $_cache = True )
    {
        if ( $_cache ) {
            $this->cache = App::__load__ ( 'Cache', 'lib' );
        }
    }

    private function _generateAliases ()
    {
        return substr ( str_shuffle ( str_repeat ( $this->_aliases, 2 ) ), 0, 2 );
    }
}