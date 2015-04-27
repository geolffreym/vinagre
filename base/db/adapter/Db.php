<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 4/27/15
 * Time: 9:55 AM
 */

namespace core\adapter\db;

use core\App;

# TODO Crear adaptador que integre DBBuilder y DBResult similar a django ORM (filter, get, etc..)
class Db
{

    private $_db = NULL;

    public function __construct ()
    {
        $this->_db = $this->switchDb ( DB_DRIVER );
    }

    final public function switchDb ( $_driver )
    {
        switch ( $_driver ) {
            case 'mysql':
            case 'mysqli':
            default:
                return App::__load__ ( 'MySql', 'db/driver', 'core\\db\\mysql\\model' );
                break;
            case 'oci8':
                return App::__load__ ( 'Oracle', 'db/driver', 'core\\db\\oracle\\model' );
                break;
        }
    }


} 