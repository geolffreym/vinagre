<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-10-14
 * Time: 02:53 PM
 */
namespace core\interfaces\db;
interface iDBTransaction
{
    public function __construct ( iDBConnection $DBConnection );

    public static function start_transaction ();

    public static function autocommit ( $_bool = FALSE );

    public static function commit ();

    public static function rollback ();

    public static function savePoint ( $_name );

    public static function rollbackFromPoint ( $_name );
}