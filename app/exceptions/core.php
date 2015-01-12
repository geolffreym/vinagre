<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 12-12-14
 * Time: 12:12 PM
 */

$exception[ 'cantConnectDB' ]        = 'Error Connecting DB';
$exception[ 'noTransactionActive' ]  = 'Uninitialized transaction.';
$exception[ 'cantConnectFTP' ]       = 'Error Connecting FTP.';
$exception[ 'errorTemplateHandler' ] = 'Template cannot be handled.';
$exception[ 'badConfMemcached' ]     = 'Server Ip, Port and Weight needed to connect MemCached';
$exception[ 'invalidInstance' ]      = 'Server Ip, Port and Weight needed to connect MemCached';
$exception[ 'invalidIp' ]            = 'Valid Ip Needed';

\core\Exception::setCollection ( $exception );