<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 3/03/14
 * Time: 9:25
 * To change this template use Upload | Settings | Upload Templates.
 */
namespace core\interfaces\db;
interface iDBConnection
{
    public function __construct ( iDBConf $conf, $_callback );

    public static function isConnected ();

    public static function getConnection ();

    public static function switchDb ( $db );

    public static function switchPointer ( $query, $position );

    public static function affectedRows ();

    public static function setCharset ( $charset );

    public function __destruct ();

}