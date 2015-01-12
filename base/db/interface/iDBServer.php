<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-10-14
 * Time: 02:55 PM
 */
namespace core\interfaces\db;
interface iDBServer
{
    public function __construct ( iDBConnection $DBConnection );

    public static function ping ();

    public static function debug ();

    public static function hostInfo ();

    public static function serverInfo ();

    public static function getMysqlVersion ();

    public static function getThreadId ();

    public static function kill ( $_thread = NULL );

    public static function setCharset ();
}