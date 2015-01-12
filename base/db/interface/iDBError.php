<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-09-14
 * Time: 12:30 PM
 */
namespace core\interfaces\db;

interface iDBError
{
    public function __construct ( iDBConnection $DBConnection );

    public static function getConnectionError ();

    public static function getConnectionErrorCode ();

    public static function getErrorCode ();

    public static function getErrorDescription ();

    public static function getErrorList ();
}