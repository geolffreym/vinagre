<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 3/03/14
 * Time: 10:56
 * To change this template use Upload | Settings | Upload Templates.
 */

namespace core\interfaces\db;
interface iDBController
{
    public function __construct ();

    public function getDbConf ();

    public function getDbConnection ();

    public function getDbResult ();

    public function getDbError ();

    public function getDbTransaction ();

    public function getDbServer ();

    public function getDbBuilder ();
}