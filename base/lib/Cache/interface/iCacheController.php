<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 3/03/14
 * Time: 10:56
 * To change this template use Upload | Settings | Upload Templates.
 */

namespace core\lib\interfaces\cache;
interface iCacheController
{
    public function __construct ();

    public function getCacheConf ();

    public function getCacheConnection ();

    public function getCacheResult ();

    public function getCacheUtil ();

    public function getCacheError ();

}