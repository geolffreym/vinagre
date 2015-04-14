<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey Mena
 * Date: 07-20-13
 * Time: 12:34 PM
 */
/**General FAQ*/
//Enviroment
define( 'ENVIRONMENT', 'development' );


//Error Reporting
switch ( ENVIRONMENT ) {
    case 'development':
        error_reporting ( E_ERROR );
        break;
    case 'production':
        error_reporting ( 0 );
        break;
    default:
        die( 'The environment is not defined' );
}

//App Path
$_Application = 'app';

//Public Path
$_Public = 'public';

//System Path
$_SystemPath = 'base';

//Estension path
$_ExtensionPath = 'extension';


define( 'SELF', pathinfo ( __FILE__, PATHINFO_BASENAME ) );
define( 'BASE_DIR', realpath ( rtrim ( $_SERVER[ 'DOCUMENT_ROOT' ], $_Public ) ) );
define( 'BASE_APP', BASE_DIR . '/' . $_Application );
define( 'BASE_PUBLIC', BASE_DIR . '/' . $_Public );
define( 'SYSTEM_PATH', BASE_DIR . '/' . $_SystemPath );
define( 'SETTING_PATH', BASE_DIR . '/' . $_SystemPath . '/setting' );
define( 'EXTENSION_PATH', BASE_DIR . '/' . $_ExtensionPath );

//Dir
if ( ! is_dir ( BASE_PUBLIC ) ) {
    header ( 'HTTP/1.1 503 Service Unavailable.', TRUE, 503 );
    die( 'Your system public path does not appear to be set correctly. Please open the following file and correct this: ' . SELF );
}

if ( ! is_dir ( BASE_APP ) ) {
    header ( 'HTTP/1.1 503 Service Unavailable.', TRUE, 503 );
    die( 'Your system application path does not appear to be set correctly. Please open the following file and correct this: ' . SELF );
}

//Basic Application Conf
require_once ( SETTING_PATH . '/core/Base.php' );
