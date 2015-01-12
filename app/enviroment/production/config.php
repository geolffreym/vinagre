<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-03-14
 * Time: 12:04 PM
 */
namespace enviroment;
//DB
define( 'DB_HOST', '' );
define( 'DB_USER', '' );
define( 'DB_PASS', '' );
define( 'DB_TABLE', '' );

//Mail
define( 'SES_USER', 'AKIAJ7JDS52XV5CLN7VQ' );
define( 'SES_PASSWORD', 'AnegzYehwmFBVAtP+bR/SMlYZue2Ad54qCVEAnz2eiPY' );
define( 'SES_HOST', 'ssl://email-smtp.us-east-1.amazonaws.com' );
define( 'SES_PORT', '443' );

//Memcached
define( 'MEMCACHED_SERVER', '' );
define( 'MEMCACHED_PORT', '' );

//CSRF Token
define( 'CSRF_TOKEN_NAME', 'csrf_session' );
define( 'CSRF_TOKEN_EXPIRE', time () + 8600 );

//Google Captcha
define( 'CAPTCHA_SERVER', "www.google.com" );
define( 'CAPTCHA_PUBLIC_KEY', "6Le6ndQSAAAAAN-8KRrp09ZOJIors5m5WxCktVh9" );
define( 'CAPTCHA_PRIVATE_KEY', "6Le6ndQSAAAAAMw4mHvoK8fmMHtSU7ylJIOANRX-" );