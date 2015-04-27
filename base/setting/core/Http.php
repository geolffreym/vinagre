<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 04-14-15
 * Time: 08:44 AM
 */

namespace core;

abstract class Http
{
    protected $Server;

    public function __construct ()
    {
        $this->Server = object ( $_SERVER );
    }

    public function getHttpMethod ()
    {
        return $this->Server->REQUEST_METHOD;
    }

    public function getRemoteIp ()
    {
        return $this->Server->REMOTE_ADDR;
    }

    public function getUserAgent ()
    {
        return $this->Server->HTTP_USER_AGENT;
    }

    public function isPost ()
    {
        return $this->getHttpMethod () == 'POST';
    }

    public function isGet ()
    {
        return $this->getHttpMethod () == 'GET';
    }

    public function isAjax ()
    {
        return !empty( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] )
        && strtolower ( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) == 'xmlhttprequest';
    }

} 