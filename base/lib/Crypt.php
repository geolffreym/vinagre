<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-19-14
 * Time: 06:09 PM
 */
namespace core\lib;
class Crypt
{
    private static $_encrypt = MCRYPT_BLOWFISH;

    public function setCrypt ( $_crypt = 'blowfish' )
    {
        switch ( $_crypt ) {
            default:
            case 'blowfish':
                self::$_encrypt = MCRYPT_BLOWFISH;
                break;
            case 'rc2':
                self::$_encrypt = MCRYPT_RC2;
                break;
            case 'rc6':
                self::$_encrypt = MCRYPT_RC6;
                break;
            case 'serpent':
                self::$_encrypt = MCRYPT_SERPENT;
                break;
            case 'gost':
                self::$_encrypt = MCRYPT_GOST;
                break;
        }
    }

    /** Return a key for encryption
     * @param $key     (string)
     * @param $content (string)
     * @param $format  -> http://php.net/manual/es/function.pack.php "Table Formats"
     * @return Array
     */
    public function getKey ( $key, $content, $format = "H*" )
    {
        $_key  = pack ( $format, hash ( $key, $content ) );
        $_size = strlen ( $_key );

        return [ 'key' => $_key, 'size' => $_size ];
    }

    /** Create a initialization vector
     * @param $_size (int bytes)
     * @return String
     */
    public function getIv ( $_size )
    {
        return mcrypt_create_iv ( $_size, MCRYPT_DEV_RANDOM );
    }

    /** Get the size of a initialization vector
     * @param $_descriptor (Descriptor)
     * @return Int (bytes)
     */
    public function getIvSize ( $_descriptor )
    {
        return mcrypt_enc_get_iv_size ( $_descriptor );
    }

    /** Get the size of a initialization vector mode CBC
     * @return Int (bytes)
     */
    public function getIvSizeByAlgorithm ()
    {
        return mcrypt_get_iv_size ( self::$_encrypt, MCRYPT_MODE_CBC );
    }

    /** Get the list of valid algorithms
     * @return Array
     */
    public function getAlgorithmValid ()
    {
        return mcrypt_list_algorithms ();
    }

    /**Get the algorithm name in use
     * @param $_descriptor (Descriptor)
     * @return String
     */
    public function getAlgorithmName ( $_descriptor )
    {
        return mcrypt_enc_get_algorithms_name ( $_descriptor );
    }

    /**Encript data
     * @param $_key                   (string)
     * @param $_content               (string)
     * @param $_initialization_vector (string)
     * @return Descriptor
     */
    public function encrypt ( $_key, $_content, $_initialization_vector = '12345678' )
    {
        return mcrypt_encrypt (
            self::$_encrypt,
            $_key,
            $_content,
            MCRYPT_MODE_CBC,
            $_initialization_vector
        );
    }


    /**Encript data
     * @param $_key                   (string)
     * @param $_crypt                 (encoded string)
     * @param $_initialization_vector (string)
     * @return Descriptor
     */
    public function decrypt ( $_key, $_crypt, $_initialization_vector = '12345678' )
    {
        return mcrypt_decrypt (
            self::$_encrypt,
            $_key,
            $_crypt,
            MCRYPT_MODE_CBC,
            $_initialization_vector
        );
    }

} 