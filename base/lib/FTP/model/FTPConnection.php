<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-30-14
 * Time: 01:30 PM
 */

namespace core\lib\model\ftp;

use core\App;
use core\lib\interfaces\ftp\iFTPConf;

class FTPConnection
{
    private static $_connection = NULL;
    private static $_login = NULL;
    private static $_connected = FALSE;

    public function __construct ( iFTPConf $FTPConf, $_callback )
    {
        if ( !( self::$_connection = ftp_connect (
            $FTPConf->getHost (),
            $FTPConf->getPort (),
            $FTPConf->getTimeOut ()
        )
        )
        ) {
            App::__callback__ ( $_callback, $this );

            return FALSE;
        } elseif ( ( self::$_login = ftp_login (
            self::$_connection,
            $FTPConf->getUser (),
            $FTPConf->getPass ()
        )
        )
        ) {
            self::$_connected = TRUE;
        }

        App::__callback__ ( $_callback, $this );

        return self::$_connected;
    }

    public static function passiveMode ( $bool = FALSE )
    {
        return ftp_pasv ( self::$_connection, $bool );
    }

    public static function getConnection ()
    {
        return self::$_connection;
    }

    public function __destruct ()
    {
        ftp_close ( self::$_connection );
    }

} 