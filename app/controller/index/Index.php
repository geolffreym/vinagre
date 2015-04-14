<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-03-14
 * Time: 12:12 PM
 */
use core\Controller;
use core\lib\Template;

class Index extends Controller
{
    public $_default_skull = 'main/Index';
}


class IndexUser extends Controller
{
    public $_default_skull = 'main/Index';

    public function __init ()
    {
        Template::__init ( $this );
        Template::addRegion ( 'title' );
        Template::write ( 'title', 'Index' );
        breakPoint ( $this );

        return Template::render ();
    }

    public function get ()
    {
        // breakPoint(CSRFToken ());
        redirect ( '/test' );
    }

    public function post ()
    {
        breakPoint ( $this );

        return $this->Json->writeSecure ( [ 'a' => 1 ] );
    }
}