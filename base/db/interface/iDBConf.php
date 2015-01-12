<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 3/03/14
 * Time: 9:40
 * To change this template use Upload | Settings | Upload Templates.
 */


namespace core\interfaces\db;

interface iDBConf
{
    public static function setHost ( $host );

    public static function setUser ( $user );

    public static function setPass ( $pass );

    public static function setDatabase ( $table );

    public static function getHost ();

    public static function getUser ();

    public static function getPass ();

    public static function getDatabase ();

    public static function setOptions ();

    public static function getOptions ();


}