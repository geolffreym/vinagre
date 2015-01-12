<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-30-14
 * Time: 01:33 PM
 */
namespace core\lib\interfaces\ftp;

interface iFTPConf
{
    public static function setHost ( $_host );

    public static function setPort ( $_port );

    public static function setTimeOut ( $_timeout );

    public static function setUser ( $_user );

    public static function setPass ( $_pass );

    public static function getHost ();

    public static function getPort ();

    public static function getTimeOut ();

    public static function getUser ();

    public static function getPass ();
}