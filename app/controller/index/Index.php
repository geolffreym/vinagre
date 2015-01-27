<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-03-14
 * Time: 12:12 PM
 */
use core\Controller;
use core\lib\Template;

//use \core\Language;

class Index extends Controller
{
    public $_default_skull = 'main/Index';

    public function __init(){
        return 'hola';
    }

    public function view(){
        return 'hi';
    }
    //public $_model = 'User';
}
