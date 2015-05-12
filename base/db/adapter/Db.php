<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 4/27/15
 * Time: 9:55 AM
 */

namespace core\adapter\db;

use core\App;
use core\interfaces\db\iDBAdapter;
use core\interfaces\iModel;

App::__require__ ( 'iDBAdapter', 'db/interface' );

# TODO Crear adaptador que integre DBBuilder y DBResult similar a django ORM (filter, get, etc..)
class Db implements iDBAdapter
{
    public $_db = NULL;
    private $_model = NULL;
    private $_query = NULL;

    final public function __construct ( iModel $Model )
    {
        $this->_model = $Model;
        $this->_db    = $this->switchDb ( DB_DRIVER );
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

    final public function filter ( $_filter )
    {

    }

    final public function get ( $_filter = NULL )
    {
        $this->_query = $this->_db->Builder
            ->select ( $this->_model )
            ->from ( $this->_model );

        $this->_handleCondition ( $_filter );

        return $this;
    }

    final public function values ( ...$_values )
    {
        if ( isset( $this->_query ) )
            $this->_db->Builder->values ( $this->_model, $_values );

        return $this;
    }

    final public function query ()
    {
        return $this->_query;
    }


    final public function prepare ( $_field )
    {
        return $this->_db->Result->prepare ( $_field );
    }

    final private function _handleCondition ( $_filter = NULL )
    {
        if ( isset( $_filter ) ) {
            if ( isset( $this->_query ) ) {
                $this->_query->where ( $_filter );
            }
        }

    }


}