<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-04-14
 * Time: 12:26 PM
 */

namespace core;

use core\interfaces\iURL;

class URI
{
    private static $URI = NULL;
    private static $DIR = NULL;

    public function __construct ( $URI )
    {
        self::$URI = getControllerUri ( $URI );
        self::$DIR = 'enviroment/' . ENVIRONMENT;
    }

    public static function checkUri ()
    {
        Exception::create ( function () {
                return App::__exist__ ( 'URL', self::$DIR );
            }, Exception::getExceptionList ( 'core' )[ 'noURL' ]
        );

        $URL = App::__load__ ( 'URL', self::$DIR );

        return self::loadFileUrls ( $URL );
    }

    public static function loadFileUrls ( $URL )
    {

        Exception::create ( function () use ( $URL ) {
                return $URL instanceof iURL;
            }, Exception::getExceptionList ( 'core' )[ 'noURL' ]
        );

        self::$URI     = App::__exist__ ( self::$URI, 'controller' ) ? self::$URI : "";
        $urlCollection = $URL->getUrl ();

        if ( !empty( $urlCollection ) ) {
            foreach ( $urlCollection as $url ) {
                if ( @preg_match ( $url->regex, self::$URI, $_output ) ) {
                    if ( $url->url ) {
                        return $url->url;
                    }
                    self::error ();
                }
            }
        }

        self::error ();

        return FALSE;
    }

    private static function error ()
    {
        Common::error404 ( 'Page not found' );
    }
}