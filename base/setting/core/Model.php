<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 04-12-14
 * Time: 02:38 PM
 */
namespace core;

App::__require__ ( 'DataStructure', 'traits' );

use core\interfaces\db\iDBAdapter;
use core\interfaces\iModel;
use core\traits\DataStructure;

abstract class Model implements iModel
{

    use DataStructure;

    static $_alias = [ ];
    private $_aliases = 'abcdefghijklmnopqrstuvwxyz';
    protected $db = NULL;
    protected $cache = NULL;
    protected $_fields = [ ];
    protected $_name = NULL;


    public function __construct ()
    {
        $this->db    = App::__instance__ ( 'Db', 'db/adapter', 'core\\adapter\\db', $this );
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
            $_new[ $this->__invoke ( $key ) ] = $val instanceof iDBAdapter
                ? $val->query () : $this->db->prepare ( $val );
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


    private function _generateAliases ()
    {
        return substr ( str_shuffle ( str_repeat ( $this->_aliases, 2 ) ), 0, 2 );
    }
}