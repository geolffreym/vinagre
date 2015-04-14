<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-03-14
 * Time: 12:13 PM
 */
namespace core\uri\index;

use core\App;
use core\interfaces\iURL;

App::__require__ ( 'Index', 'controller/index' );

class URL implements iURL
{
    public function getUrl ()
    {
        return [
            url ( '^$', \Index::asView () ),
            url ( '^(?<action>view)$', \IndexUser::asView () ), # Action in regexp cn be user to target a custom method in class
            url ( '^view/user$', \IndexUser::asView () )

        ];
    }
}
