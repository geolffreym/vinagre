<?php
namespace core\traits;
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 04-26-14
 * Time: 02:07 PM
 */
trait Strings
{

    /**Comprime el texto
     * ZLIB_ENCODING_RAW
     * ZLIB_ENCODING_GZIP
     * ZLIB_ENCODING_DEFLATE
     * @param $_data
     * @param $_quality
     * @param $_type
     * @return Boolean
     */
    public static function compressText ( $_data, $_quality = 9, $_type = ZLIB_ENCODING_GZIP )
    {
        return zlib_encode ( $_data, $_quality, $_type );
    }

    /**Descomprime texto zlib_encode
     * @param $_data
     * @return Boolean
     */
    public static function uncompressText ( $_data )
    {
        return zlib_decode ( $_data );
    }

    public static function serialize ( $_data )
    {
        return serialize ( $_data );
    }

    public static function unserialize ( $_data )
    {
        return unserialize ( $_data );
    }

    //Retorna Arreglo de los dias de la semana

    /**Limpia caracteres especiales
     * @str string
     */
    public static function cleanUrl ( $str )
    {
        $_sanitized = filter_var ( $str, FILTER_SANITIZE_URL );

        return $_sanitized
            ? $_sanitized : $str;
    }

    /**Limpia cadena de guiones, barras, o cualquier otro caracter
     * @str string
     */
    public static function cleanStr ( $str )
    {
        $str = utf8_decode ( $str );
        $a   = [ '*', ' ', '-', '^', '%', '#', '@', '!', '+', '{', '}', '\\', '~', ',', '>', '<', 'á', 'ç', 'é', 'í', 'ñ', 'ó', 'ú', 'ý', '©', '®' ];
        $b   = [ '', '_', '_', '', '', '', '', '', '', '', '', '', '', '', '', '', 'a', 'c', 'e', 'i', 'n', 'o', 'u', 'y', '&copy;', '&reg' ];

        return str_replace ( $a, $b, $str );
    }

    /**Procesa cadena quitando espacios en blanco, codificacion UTF
     * y dando mayuscula a cada palabra inicial
     * @param $_string
     * @return String
     */
    public static function trimUcwordsDecode ( $_string )
    {
        return utf8_decode ( trim ( ucwords ( $_string ) ) );
    }

    /**Encapsula cadena
     * @param $string
     * @param wrap
     * @return String
     */
    public static function wrap ( $string, $wrap )
    {
        return $wrap . $string . $wrap;
    }

    /**Recorta texto
     * @texto  string
     * @limite integer
     */
    public static function truncateText ( $texto, $limite )
    {
        if ( strlen ( $texto ) > $limite ) {
            $texto = substr ( $texto, 0, $limite );
        }

        return $texto;
    }

    //Genera un prefijo encriptado y lo devuelve
    public static function generatePrefix ( $prefijo = '' )
    {
        return md5 ( uniqid ( $prefijo ) );
    }

}