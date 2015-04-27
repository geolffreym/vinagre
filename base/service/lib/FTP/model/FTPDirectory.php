<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-30-14
 * Time: 01:41 PM
 */

namespace core\lib\model\ftp;

use core\App;
use core\lib\interfaces\ftp\iFTPConnection;

class FTPDirectory
{
    public static $_connection = NULL;

    public function __construct ( iFTPConnection $FTPConnection )
    {
        self::$_connection = $FTPConnection->get_connection ();
    }

    public static function goDir ( $_dir, $_callback )
    {
        App::__callback__ ( $_callback, ftp_chdir ( self::$_connection, $_dir ) );
    }

    public static function goBack ()
    {
        ftp_cdup ( self::$_connection );
    }

    public static function ls (
        $_dir,
        $_callback,
        $_recursive = FALSE
    )
    {
        App::__callback__ ( $_callback, ftp_rawlist ( self::$_connection, $_dir, $_recursive ) );
    }

    public static function create ( $_dir, $_callback )
    {
        App::__callback__ ( $_callback, ftp_mkdir ( self::$_connection, $_dir ) );
    }

    public static function remove ( $_dir, $_callback )
    {
        App::__callback__ ( $_callback, ftp_rmdir ( self::$_connection, $_dir ) );

    }
}