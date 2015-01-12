<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 3/03/14
 * Time: 10:22
 * To change this template use Upload | Settings | Upload Templates.
 */
namespace core\interfaces\db;
interface iDBResult
{
    public function __construct ( iDBConnection $DBConnection );

    public static function setQuery ( $_query );

    public static function async ();

    public static function getNumRows ( $_query, $_callback );

    public static function getCount ( $_query, $_callback );

    public static function execute ( $_query, $_callback );

    public static function getQueryInfo ();

    public static function rowGroupMultiQuery ( $_query );

    public static function getInsertId ();

    public static function prepare ( $_string );

    public static function row ( $_query, $_callback );

    public static function rowGroup ( $_query, $_callback );


}