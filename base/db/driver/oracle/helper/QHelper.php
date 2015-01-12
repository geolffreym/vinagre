<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-15-14
 * Time: 01:52 PM
 */
namespace core\db\oracle\helper;
use core\traits\DataStructure;

class QHelper
{
    use DataStructure;

    public function __construct ()
    {

    }

    public static function max ( $_attr, $_alias = 'MAX' )
    {
        return [
            'attr' => self::_group ( 'max', self::_array_cnv ( $_attr ) ) . self::_joined ( $_alias )
        ];
    }

    public static function min ( $_attr, $_alias = 'MIN' )
    {
        return [
            'attr' => self::_group ( 'min', self::_array_cnv ( $_attr ) ) . self::_joined ( $_alias )
        ];
    }

    public static function is_null ()
    {

    }

    public static function nested ( $Builder, $_alias = NULL )
    {
        return [
            'attr' => '(' . $Builder . ')' . ( isset( $_alias ) ? self::_joined ( $_alias ) : '' )
        ];
    }

    public static function concat ( $_args, $_alias = 'JOINED' )
    {
        $_concat = [ ];
        foreach ( $_args as $arg ) {
            $_concat[ ] = self::_array_cnv ( $arg );
        }

        return [
            'attr' => self::_group ( 'CONCAT', self::_implode_attr ( $_concat, ',' ) ) . self::_joined ( $_alias )
        ];
    }

    public static function lower ( $_attr, $_alias = 'LOWER' )
    {

        return [
            'attr' => self::_group ( 'LOWER', self::_array_cnv ( $_attr ) ) . self::_joined ( $_alias )
        ];
    }

    public static function in ( $_attr, $_values )
    {
        if ( is_array ( $_values ) ) {
            return [
                'attr' => $_attr . ' ' . self::_group ( 'IN', self::_implode_attr ( $_values, ' ,' ) )
            ];
        }
    }

    private static function _group ( $_name, $_content )
    {
        return $_name . '(' . $_content . ')';
    }

    private static function _joined ( $_alias )
    {
        return ' AS ' . $_alias;
    }

    //Array Convertion
    private static function _array_cnv ( $_attr )
    {
        if ( is_array ( $_attr ) ) {
            return $_attr[ 'attr' ];
        }

        return $_attr;
    }


    private static function _implode_attr ( $_attr, $_char = ',' )
    {
        if ( is_array ( $_attr ) ) {
            return implode ( $_char, $_attr );
        }

        return $_attr;
    }

} 