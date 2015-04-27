<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 08-10-14
 * Time: 11:44 AM
 */
namespace core\lib\interfaces\ftp;
interface iFTPController
{
    public function __construct ();

    public function getFtpConnection ();

    public function getFtpConf ();

    public function getFtpDirectory ();

    public function getFtpFile ();
}