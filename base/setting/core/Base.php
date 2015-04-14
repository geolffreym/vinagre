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

//Functions Util
App::__require__ ( 'Util', 'functions' );

//Functions Debug
App::__require__ ( 'Debug', 'functions' );

//Functions Route
App::__require__ ( 'Router', 'functions' );

//Functions Template
App::__require__ ( 'Template', 'functions' );

//Controller Class
App::__require__ ( 'URI', 'core' );

//Http Class
App::__require__ ( 'Http', 'core' );

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

//Session Class
App::__require__ ( 'Session', 'core' );

//Language Class
App::__require__ ( 'Language', 'core' );


////////////////SECURITY/////////////////////
//CSRFToken Class
App::__require__ ( 'CSRFToken', 'security' );


//////////////////TIMEZONE//////////////////
if ( Config::findConfig ( 'DEFAULT_TIME', [ 'DEFAULT_TIME_ZONE' ] ) ) {
    date_default_timezone_set ( DEFAULT_TIME_ZONE );
}

//////////////////ENCODING//////////////////
if ( Config::findConfig ( 'CHARSET', [ 'DEFAULT_CHARSET' ] ) ) {
    mb_http_output ( DEFAULT_CHARSET );
    mb_internal_encoding ( DEFAULT_CHARSET );
}

//////////////////GZIP//////////////////

if ( Config::findConfig ( 'GZIP', [ 'ACTIVE_GZIP' ] ) ) {
    substr_count ( $_SERVER[ 'HTTP_ACCEPT_ENCODING' ], 'gzip' ) ? ob_start ( 'ob_gzhandler' ) : ob_start ();
}


//////////////////ROUTING//////////////////
//URI Object
$URI    = new URI( $_SERVER[ 'REQUEST_URI' ] );
$Router = new Router;

$Router->matchRoute ( $URI->checkUri () );
$Router->writeResponse ();