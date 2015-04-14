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
            # Action ex: (?<action>[\w]),  in regexp can be used to target a custom method in class
            url ( '^$', \Index::asView () ),
            url ( '^view$', \IndexUser::asView () ),
            url ( '^view/user$', \IndexUser::asView () )

        ];
    }
}
