<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-30-14
 * Time: 01:42 PM
 */
namespace core\lib\interfaces\ftp;

interface iFTPConnection
{
    public function __construct ( iFTPConf $FTPConf );

    public static function passive_mode ( $bool = FALSE );

    public static function get_connection ();

    public function __destruct ();
}