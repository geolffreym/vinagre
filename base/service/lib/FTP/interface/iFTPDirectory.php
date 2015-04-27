<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-31-14
 * Time: 09:58 AM
 */
namespace core\lib\interfaces\ftp;

interface iFTPDirectory
{
    public function __construct ( iFTPConnection $FTPConnection );

    public static function go_to ( $_dir, $_callback );

    public static function go_back ();

    public static function ls ( $_dir, $_callback, $_recursive = FALSE );

    public static function create ( $_dir, $_callback );

    public static function remove ( $_dir, $_callback );
}