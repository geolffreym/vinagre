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

class Test extends Controller
{
    public $_default_skull = 'main/Index';

    public function __init(){
        return 'soy test';
    }

    public function view(){
        return 'hi test';
    }
    //public $_model = 'User';
}
