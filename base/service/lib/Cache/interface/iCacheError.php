<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 10-13-14
 * Time: 11:23 AM
 */
namespace core\lib\interfaces\cache;

interface iCacheError
{
    public function __construct ( iCacheConnection $cacheConnection );

    public function getError ();

    public function getErrorCode ();
}