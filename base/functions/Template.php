<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 04-14-15
 * Time: 10:59 AM
 */
use core\security\CSRFToken;

function CSRFToken ()
{

    if ( CSRFToken::isServiceActive () ) {
        CSRFToken::create ();
        CSRFToken::save ();

        return CSRFToken::load ();
    }

    return '';

}
