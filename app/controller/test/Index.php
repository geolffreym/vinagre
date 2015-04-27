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
    public $Tpl = 'main/Index';
    public $Model = 'Information';

    public function get ()
    {
        Template::__init ( $this );
        Template::addRegion ( 'title' );
        Template::write ( 'title', 'Test' );

        return Template::render ();
    }

    public function getContextData ()
    {
        return [ "hola" => "baby" ];
    }

    public function post ()
    {
        return $this->Json->write ( [ 0, 1, 2, 3 ] );
    }

}
