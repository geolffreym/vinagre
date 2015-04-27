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

        return '<input type="hidden" value="' . CSRFToken::load () . '" name="csrf_token">';
    }

    return '';

}

function getVar ( $_var )
{
    return isset( $GLOBALS[ 'my_vars' ][ $_var ] )
        ? $GLOBALS[ 'my_vars' ][ $_var ] : NULL;
}
