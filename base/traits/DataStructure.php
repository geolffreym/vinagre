<?php
/**
 * User: Geolffrey Mena
 * Date: 05-18-13
 * Time: 02:47 PM
 * To change this template use Upload | Settings | Upload Templates.
 */
namespace core\traits;

use core\helper\ArrayHelper;
use RecursiveArrayIterator;
use RecursiveCallbackFilterIterator;
use RecursiveRegexIterator;
use RegexIterator;

trait DataStructure
{

    /**Fragmenta un arreglo en arreglos independientes
     * */
    public static function fragmentArray ( $array )
    {
        if ( !is_array ( $array ) ) {
            return [ ];
        }

        /**
         * foreach ($array as list($a, $b)) {
         * // $a contiene el primer elemento del array interior,
         * // y $b contiene el segundo elemento.
         * echo "A: $a; B: $b\n";
         * }
         */

        return ArrayHelper::tourArray ( $array );
    }

    /* public static function array_list($_array, $_list)
     {
         foreach ($_array as $key => $_list) {

         }
     }*/


    public static function compactArray ( $_array )
    {
        if ( !is_array ( $_array ) ) {
            return FALSE;
        }

        $_new      = new RecursiveArrayIterator( $_array );
        $_iterator = new RecursiveCallbackFilterIterator( $_new, function ( $current ) {
                if ( !empty( $current ) ) {
                    return TRUE;
                }

                return FALSE;
            }
        );

        return iterator_to_array ( $_iterator );
    }


    public static function mergeKeyValue ( $_array, $_delimiter = '' )
    {
        if ( !is_array ( $_array ) ) {
            yield [ ];
        }
        foreach ( $_array as $key => $value ) {
            yield $n[ $key ] = $key . $_delimiter . ( is_string ( $value )
                    ? "\"" . $value . "\"" : $value );
        }
    }


    /**Une los elementos de un arreglo con los elementos de otro separados por un caracter
     * @param $a
     * @param $b
     * @param $s
     */
    public static function mergeByChar ( $a, $b, $s = ' = ' )
    {
        if ( !is_array ( $a ) || !is_array ( $b ) ) {
            yield [ ];
        }

        foreach ( $a as $k => $v ) {
            if ( isset( $b[ $k ] ) ) {
                yield $v . $s . ( is_string ( $b[ $k ] )
                        ? "\"" . $b[ $k ] . "\"" : $b[ $k ] );
            } else {
                yield $v;
            }
        }
    }

    /**Filter Array by value match
     * @param @array
     * @param $match
     * @return Array
     */
    public static function filterByMatch ( $array, $match = '_' )
    {

        if ( !is_array ( $array ) ) {
            return [ ];
        }

        $_new      = new RecursiveArrayIterator( $array );
        $_iterator = new RecursiveCallbackFilterIterator( $_new, function ( $current ) use ( $match ) {
                return preg_match ( '/' . $match . '/', $current ) === 1;
            }
        );

        return iterator_to_array ( $_iterator );
    }

    /**Replace Array Value by regex match
     * @param $array
     * @param $match
     * @param $replace
     * @return Array
     * */
    public static function replaceByMatch ( $array, $match = '/[_]/', $replace = "." )
    {
        if ( !is_array ( $array ) ) {
            return [ ];
        }
        $_new                  = new RecursiveArrayIterator( $array );
        $iterator              = new RegexIterator( $_new, $match, RecursiveRegexIterator::REPLACE );
        $iterator->replacement = $replace;

        return iterator_to_array ( $iterator );
    }

    /**Genera un arreglo asociativo, basandose en los valores, separando
     * los valores por un delimitador y estableciendo key=>valor
     * @param $array     Array
     * @param $delimiter String
     */
    public static function matchExplode ( $array, $delimiter = ':' )
    {
        if ( !is_array ( $array ) ) {
            yield [ ];
        }

        foreach ( $array as $q ) {
            $temp = explode ( $delimiter, $q );
            if ( !empty( $temp[ 0 ] ) && !empty( $temp[ 1 ] ) ) {
                yield $array[ trim ( $temp[ 0 ] ) ][ ] = $temp[ 1 ];
            }
        }
    }

    /**Genera un arreglo asociativo, dejando como llave el valor de un elemento contenido en el arreglo,
     * conteniendo el resto de elementos hermanos
     * @param $array Array
     * @param $key   String
     */
    public static function groupByKey ( $array = NULL, $key = NULL )
    {
        if ( !is_array ( $array ) || !isset( $key ) ) {
            yield [ ];
        }

        foreach ( $array as $k => $q ) {
            if ( $k !== $key ) {
                yield $_new[ trim ( $array[ $k ][ $key ] ) ][ ] = $array[ $k ];
            }
        }
    }

    public static function cleanNumericKeys ( $array = NULL )
    {
        foreach ( $array as $k => $v ) {
            if ( is_int ( $k ) ) {
                unset( $array[ $k ] );
            }
        }

        return $array;
    }

    public static function arrayDistribute ()
    {
        $_new_array = [ ];
        foreach ( func_get_args () as $k => $_args ) {
            if ( !is_array ( $_args ) )
                continue;

            foreach ( $_args as $_join ) {
                $_new_array[ $k ][ ] = $_join[ $k ];
                break;
            }

        }

        return $_new_array;
    }

    /**Establece estrictamente en el orden del mandatory las llaves
     * del arreglo y reemplaza los elementos que no existen como 'NULL'
     * @param $_mandatory
     * @param $_array
     * @param $_default
     * @return Array
     * */
    public static function mandatoryOrder ( $_mandatory, $_array, $_default = 'NULL' )
    {
        if ( !is_array ( $_mandatory ) || !isset( $_array ) ) {
            yield [ ];
        }

        foreach ( $_mandatory as $k => $v ) {
            if ( isset( $_array[ $v ] ) ) {
                yield $new_array[ $v ] = $_array[ $v ];
            } else {
                yield $new_array[ $v ] = $_default;
            }
        }

    }

}