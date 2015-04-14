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

    public function __init ()
    {
        Template::__init ( $this );

        Template::addRegion ( 'title' );
        Template::write ( 'title', 'Test' );

        return Template::render ();
    }
}
