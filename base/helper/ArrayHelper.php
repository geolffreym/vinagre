<?php
namespace core\helper;
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-12-14
 * Time: 12:21 PM
 */
class ArrayHelper
{
    public function __construct ()
    {
    }

    public static function range ( $_size )
    {
        for ( $i = 0 ;$i < intval ( $_size ) ;$i ++ ) {
            yield $i;
        }
    }

    public static function tourArray ( $_array )
    {
        foreach ( $_array as $key => $value ) {
            yield $_array[ $key ];
        }
    }

    public static function generatorToArray ( $_generator )
    {
        $_array = [ ];
        foreach ( $_generator as $k => $v ) {
            $_array[ $k ] = $v;
        }

        return $_array;
    }

} 