<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 08-10-14
 * Time: 11:23 AM
 */

namespace core\lib\model\ftp;

use core\App;
use core\Exception;
use core\lib\interfaces\ftp\iFTPController;

App::__require__ ( 'FTPConf', 'lib/FTP/model' );
App::__require__ ( 'FTPConnection', 'lib/FTP/model' );
App::__require__ ( 'FTPDirectory', 'lib/FTP/model' );
App::__require__ ( 'FTPFile', 'lib/FTP/model' );
App::__interface__ ( 'iFTPController', 'lib/FTP/interface' );

class FTPController implements iFTPController
{
    protected $FTPConf = NULL;
    protected $FTPConnection = NULL;
    protected $FTPDirectory = NULL;
    protected $FTPFile = NULL;

    public function __construct ()
    {
        $this->FTPConf = new FTPConf;
        $this->FTPConf->setHost ( FTP_HOST );
        $this->FTPConf->setPort ( FTP_PORT );
        $this->FTPConf->setTimeOut ( FTP_TIMEOUT );
        $this->FTPConf->setUser ( FTP_USER );
        $this->FTPConf->setPass ( FTP_PASS );

        $this->FTPConnection = new FTPConnection( $this->FTPConf, function ( $_connection ) {
                if ( $_connection->_connected ) {
                    $this->FTPDirectory = new FTPDirectory( $_connection );
                    $this->FTPFile      = new FTPFile( $_connection );
                } else {
                    Exception::throwException ( 'cantConnectFTP' );
                }
            }
        );
    }

    public function getFtpConnection ()
    {
        return $this->FTPConnection;
    }

    public function getFtpConf ()
    {
        return $this->FTPConf;
    }

    public function getFtpDirectory ()
    {
        return $this->FTPDirectory;
    }

    public function getFtpFile ()
    {
        return $this->FTPFile;
    }
} 