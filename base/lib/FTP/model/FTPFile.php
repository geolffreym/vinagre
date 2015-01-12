<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-31-14
 * Time: 10:01 AM
 */

namespace core\lib\model\ftp;

use core\App;
use core\lib\interfaces\ftp\iFTPConnection;

class FTPFile
{
    public static $_connection = NULL;

    public function __construct ( iFTPConnection $FTPConnection )
    {
        self::$_connection = $FTPConnection->get_connection ();
    }

    /**Reserva espacio para que un archivo sea cargado
     * @param $_file_dir {string}
     * @param $_callback {function}
     */
    public static function alloc ( $_file_dir, $_callback )
    {
        ftp_alloc ( self::$_connection, filesize ( $_file_dir ), $result );
        App::__callback__ ( $_callback, $result );
    }

    /**Caga un archivo
     * @param $to        {string}
     * @param $from      {string}
     * @param $_callback {function}
     * @param $mode      {integer}
     */
    public static function up ( $to, $from, $_callback, $mode = FTP_BINARY )
    {
        App::__callback__ ( $_callback, ftp_put ( self::$_connection, $to, $from, $mode ) );
    }

    public static function down ( $to, $from, $_callback, $mode = FTP_BINARY )
    {
        App::__callback__ ( $_callback, ftp_get ( self::$_connection, $to, $from, $mode ) );
    }

    public static function delete ( $path, $_callback )
    {
        App::__callback__ ( $_callback, ftp_delete ( self::$_connection, $path ) );
    }
}