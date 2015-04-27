<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 3/03/14
 * Time: 10:04
 * To change this template use Upload | Settings | Upload Templates.
 */

namespace core\lib\model\cache;

use core\App;
use core\Config;
use core\Exception;
use core\lib\interfaces\cache\iCacheConnection;
use core\lib\interfaces\cache\iCacheController;
use core\traits\DataStructure;

App::__require__ ( 'CacheConf', 'lib/Cache' );
App::__require__ ( 'CacheConnection', 'lib/Cache' );
App::__require__ ( 'CacheError', 'lib/Cache' );
App::__require__ ( 'CacheResult', 'lib/Cache' );
App::__require__ ( 'CacheUtil', 'lib/Cache' );
App::__interface__ ( 'iCacheController', 'lib/Cache/interface' );

class CacheController implements iCacheController
{

    use DataStructure;

    protected $CacheConf = NULL;
    protected $CacheConnection = NULL;
    protected $CacheResult = NULL;
    protected $CacheError = NULL;
    protected $CacheUtil = NULL;
    private $Config = [ 'MEMCACHED_PORT', 'MEMCACHED_WEIGHT', 'MEMCACHED_SERVER' ];

    public function __construct ()
    {
        $this->CacheConf = new CacheConf;
        if ( $this->_flushConstant ( 'MEMCACHED' ) ) {
            $_host   = $this->_makeHost ();
            $_port   = $this->_makePort ();
            $_weight = $this->_makeWeight ();

            if ( is_array ( $_host ) && is_array ( $_port ) && is_array ( $_port ) ) {
                $this->CacheConf->setHost ( self::arrayDistribute ( $_host, $_port, $_weight ) );
            } else {
                $this->CacheConf->setHost ( $_host );
                $this->CacheConf->setPort ( $_port );
                $this->CacheConf->setWeight ( $_weight );
            }

            $this->CacheConnection = new CacheConnection( $this->CacheConf, function ( iCacheConnection $_connection ) {
                    if ( $_connection::isConnected () ) {
                        $this->CacheResult = new CacheResult( $_connection );
                        $this->CacheError  = new CacheError( $_connection );
                        $this->CacheUtil   = new CacheUtil;
                    }
                }
            );

        } else {
            Exception::throwException ( 'badConfMemcached' );
        }

    }

    public function getCacheConf ()
    {
        return $this->CacheConf;
    }

    public function getCacheConnection ()
    {
        return $this->CacheConnection;
    }

    public function getCacheResult ()
    {
        return $this->CacheResult;
    }

    public function getCacheUtil ()
    {
        return $this->CacheUtil;
    }

    public function getCacheError ()
    {
        return $this->CacheError;
    }

    private function _makeHost ()
    {
        return $this->_make ( MEMCACHED_SERVER );
    }

    private function _makePort ()
    {
        return $this->_make ( MEMCACHED_PORT );
    }

    private function _makeWeight ()
    {
        return $this->_make ( MEMCACHED_WEIGHT );
    }

    private function _make ( $_constant )
    {
        if ( strstr ( ',', $_constant ) ) {
            return explode ( ',', $_constant );
        } else {
            return $_constant;
        }
    }

    private function _flushConstant ( $_constant )
    {
        return Config::findConfig ( $_constant, $this->Config );
    }
}


