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

//GZIP
define( 'ACTIVE_GZIP', TRUE );


//DEFAULT ERROR PAGES
define( 'DEFAULT_404_PAGE', 'error404.tpl' );
define( 'DEFAULT_500_PAGE', 'error404.tpl' );

//DB (Db Install needed)
define( 'DB_HOST', 'localhost' );
define( 'DB_USER', 'root' );
define( 'DB_PASS', 'gmena5289' );
define( 'DB_DATABASE', 'posgrado' );
define( 'DB_DRIVER', 'mysqli' );
define( 'DB_CACHE', FALSE );
define( 'DB_ASYNC', TRUE );
define( 'DB_CHARSET', 'UTF-8' );
define( 'DB_CONNECT_TIMEOUT', 5000 );
define( 'DB_INIT_COMMAND', '' );
define( 'DB_READ_DEFAULT_FILE', '' );


//Mail
define( 'MAIL_USER', '' );
define( 'MAIL_PASSWORD', '' );
define( 'HOST_HOST', '' );
define( 'MAIL_PORT', '443' );

//Memcached (Install Needed)
define( 'MEMCACHED_SERVER', '' ); //Separate with coma if you need different host
define( 'MEMCACHED_PORT', '' ); //Separate with coma the ports equivalents to servers
define( 'MEMCACHED_WEIGHT', '' ); //Separate with coma the weight (memory) equivalents to servers

//CSRF Token
define( 'CSRF_TOKEN_PROTECTION', FALSE );
define( 'CSRF_TOKEN_NAME', 'csrf_session' );
define( 'CSRF_TOKEN_COOKIE_NAME', 'csrf_session' );
define( 'CSRF_TOKEN_EXPIRE', time () + 8600 );

//SESSION
define( 'SESS_NAME', 'b_session' );
define( 'SESS_EXPIRE', 0X2A30 ); // Default 180 (10800 Seconds) Minutes
define( 'SESS_CACHE', 'public' );

//XSS
define( 'XSS_GLOBAL_PROTECTION', FALSE );

//Time
define( 'DEFAULT_TIME_ZONE', 'America/Managua' );

//Controller Directory
define( 'DEFAULT_CONTROLLER', 'index' );


//FTP
define( 'FTP_HOST', 'localhost' );
define( 'FTP_PORT', 21 );
define( 'FTP_TIMEOUT', 90 );
define( 'FTP_USER', '' );
define( 'FTP_PASS', '' );


//Google Captcha
define( 'CAPTCHA_SERVER', "" );
define( 'CAPTCHA_PUBLIC_KEY', "" );
define( 'CAPTCHA_PRIVATE_KEY', "" );