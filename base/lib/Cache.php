<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 3/03/14
 * Time: 10:04
 * To change this template use Upload | Settings | Upload Templates.
 */
namespace core\lib;

use core\App;
use core\lib\interfaces\cache\iCacheController;
use core\lib\model\cache\CacheController;

App::__require__ ( 'CacheController', 'lib/model' );

class Cache extends CacheController implements iCacheController
{
    public static $Connection = NULL;
    public static $Result = NULL;
    public static $Error = NULL;
    public static $Util = NULL;

    public function __construct ()
    {
        parent::__construct ();
        self::$Connection = parent::getCacheConnection ();
        self::$Result     = parent::getCacheResult ();
        self::$Error      = parent::getCacheError ();
        self::$Util       = parent::getCacheUtil ();
    }
}


