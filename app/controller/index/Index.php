<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-03-14
 * Time: 12:12 PM
 */
use core\Controller;

//use \core\Language;

class Index extends Controller
{
    public $_default_skull = 'main/Index';
}


class IndexUser extends Controller
{
    public $_default_skull = 'main/Index';

    public function __init ()
    {
        return 'nalga';
    }
}