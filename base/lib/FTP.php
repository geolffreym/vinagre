<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-30-14
 * Time: 12:56 PM
 */
namespace core\lib;

use core\App;
use core\lib\interfaces\ftp\iFTPController;
use core\lib\model\ftp\FTPController;


App::__require__ ( 'FTPController', 'lib/model/' );

class FTP extends FTPController implements iFTPController
{
    public $Connection = NULL;
    public $Directory = NULL;
    public $File = NULL;

    public function __construct ()
    {
        parent::__construct ();
        $this->Connection = $this->FTPConnection;
        $this->Directory  = $this->FTPDirectory;
        $this->File       = $this->FTPFile;
    }
} 