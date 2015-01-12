<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-07-14
 * Time: 10:10 AM
 */
namespace core;

require_once ( SETTING_PATH . '/core/Application.php' );

define( 'B_VERSION', '1.0' );


//////////////////BASIC REQUIRE//////////////////
//Common Class
App::__require__ ( 'Common', 'core' );

//////////////////CONFIG FILES//////////////////
if ( defined ( 'ENVIRONMENT' ) ) {
    if ( !App::__require__ ( 'config', 'enviroment/' . ENVIRONMENT ) ) {
        Common::error503 ( 'Not config file' );
    }

}


//////////////////INTERFACE//////////////////
App::__interface__ ( 'iURL', 'interface' );
App::__interface__ ( 'iController', 'interface' );
App::__interface__ ( 'iModel', 'interface' );
App::__interface__ ( 'iFactory', 'interface' );


//////////////////BASIC REQUIRE//////////////////

//Controller Class
App::__require__ ( 'URI', 'core' );

//Router Class
App::__require__ ( 'Router', 'core' );

//Exception Class
App::__require__ ( 'Exception', 'core' );

//Controller Class
App::__require__ ( 'Controller', 'core' );

//Model Class
App::__require__ ( 'Model', 'core' );

//Loader Class
App::__require__ ( 'Loader', 'core' );

//Config Class
App::__require__ ( 'Config', 'core' );

//Language Class
App::__load__ ( 'Language', 'core', 'core' );


//////////////////TIMEZONE//////////////////
if ( defined ( 'DEFAULT_TIME_ZONE' ) ) {
    date_default_timezone_set ( DEFAULT_TIME_ZONE );
}

//////////////////ENCODING//////////////////
if ( defined ( 'DEFAULT_ENCODING' ) ) {
    mb_http_output ( DEFAULT_CHARSET );
    mb_internal_encoding ( DEFAULT_CHARSET );
}

//////////////////GZIP//////////////////
if ( defined ( 'ACTIVE_GZIP' ) ) {
    if ( Config::findConfig ( 'GZIP', [ 'ACTIVE_GZIP' ] ) )
        substr_count ( $_SERVER[ 'HTTP_ACCEPT_ENCODING' ], 'gzip' ) ? ob_start ( 'ob_gzhandler' ) : ob_start ();
}

//////////////////ROUTING//////////////////
$URI = URI::checkURI ( $_SERVER[ 'REQUEST_URI' ] );
//var_dump($URI);die();
Router::matchRoute ( $URI );
Router::writeResponse ();