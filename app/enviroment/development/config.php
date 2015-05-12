<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-03-14
 * Time: 12:03 PM
 */
namespace enviroment;

//LANGUAGE
define( 'DEFAULT_LANGUAGE', 'en_EN' );

//ENCODING
define( 'DEFAULT_CHARSET', 'UTF-8' );

//Time
define( 'DEFAULT_TIME_ZONE', 'America/Managua' );

//GZIP
define( 'ACTIVE_GZIP', TRUE );


//DEFAULT ERROR PAGES
define( 'DEFAULT_404_PAGE', 'error404.tpl' );
define( 'DEFAULT_500_PAGE', 'error505.tpl' );

//DB (Db Install needed)
define( 'DB_HOST', 'localhost' );
define( 'DB_USER', 'root' );
define( 'DB_PASS', 'gmena5289' );
define( 'DB_DATABASE', 'mydb' );
define( 'DB_DRIVER', 'mysqli' );
define( 'DB_ASYNC', FALSE );
define( 'DB_CHARSET', 'UTF-8' );

//Valid for mysqli -> http://php.net/manual/en/mysqli.options.php
define( 'DB_CONNECT_TIMEOUT', 5000 );
define( 'DB_INIT_COMMAND', 'SET NAMES utf8' );
define( 'DB_READ_DEFAULT_FILE', '' );


//SESSION
define( 'SESS_NAME', 'vinagre_session' );
define( 'SESS_EXPIRE', 60 ); // Default 180 Minutes (10800 Seconds)
define( 'SESS_CACHE', 'public' );
//http://php.net/manual/es/function.session-cache-limiter.php

/////////////////////SERVICES//////////////////
//CSRF Token
define( 'CSRF_TOKEN_PROTECTION', TRUE );
define( 'CSRF_TOKEN_NAME', 'csrf_session' );
define( 'CSRF_TOKEN_COOKIE_NAME', 'csrf_session' );
define( 'CSRF_TOKEN_EXPIRE', time () + 8600 );

//XSS
define( 'XSS_GLOBAL_PROTECTION', TRUE );

//Mail
define( 'MAIL_ACTIVE', FALSE );
define( 'MAIL_DRIVER', 'amazon' );
define( 'MAIL_USER', '' );
define( 'MAIL_PASSWORD', '' );
define( 'MAIL_HOST', '' );
define( 'MAIL_PORT', '443' );

//FTP
define( 'FTP_ACTIVE', FALSE );
define( 'FTP_HOST', 'localhost' );
define( 'FTP_PORT', 21 );
define( 'FTP_TIMEOUT', 90 );
define( 'FTP_USER', '' );
define( 'FTP_PASS', '' );

//Cached (Install Needed)
define( 'CACHE_ACTIVE', FALSE );
define( 'CACHE_DRIVER', 'memcached' );
define( 'CACHE_SERVER', '' ); //Separate with coma if you need different host
define( 'CACHE_PORT', '' ); //Separate with coma the ports equivalents to servers
define( 'CACHE_WEIGHT', '' ); //Separate with coma the weight (memory) equivalents to servers

