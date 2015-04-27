<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 10-13-14
 * Time: 11:02 AM
 */

namespace core\lib\model\cache;


use core\lib\interfaces\cache\iCacheConnection;
use core\lib\interfaces\cache\iCacheError;

class CacheError implements iCacheError
{

    private static $CacheConnection = NULL;

    public function __construct ( iCacheConnection $cacheConnection )
    {
        self::$CacheConnection = $cacheConnection::getConnection ();

    }

    public function getError ()
    {
        return self::$CacheConnection->getResultCode ();

    }

    public function getErrorCode ()
    {
        return self::$CacheConnection->getResultMessage ();
    }
} 