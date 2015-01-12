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

    //public $_model = 'User';

    public function __init ()
    {
        Template::__init ( $this );
        Template::addRegion ( 'header' );
        Template::addRegion ( 'title' );
        Template::write ( 'title', '22-24' );
        Template::writeAssets ( [ '/assets/js/test.js' ], 'js' );
        Template::writeView ( 'header', 'index/Index', [ 'happy' => 'hola' ] );

        return Template::render ();
    }

    public function view ()
    {
        var_dump ( $this->Request );
    }

}
