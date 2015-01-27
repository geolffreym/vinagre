<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-03-14
 * Time: 12:13 PM
 */
use core\interfaces\iURL;

class URL implements iURL
{
    public function getUrl ()
    {
        return [
            url ( '^$', append ( 'index.url' ) ),
            url ( '^test', append ( 'test.url' ) )
        ];
    }
}
