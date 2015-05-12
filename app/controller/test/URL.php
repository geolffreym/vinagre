<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-03-14
 * Time: 12:13 PM
 */
namespace core\uri\test;

use core\App;
use core\interfaces\iURL;

App::__require__ ( 'Test', 'controller/test' );

class URL implements iURL
{
    public function getUrl ()
    {
        return [
            url ( '^$', \Test::asView () ),
//            url ( '^(?<action>view)', \Test::asView () ),
        ];
    }
}
