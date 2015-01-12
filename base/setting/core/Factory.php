<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 4/03/14
 * Time: 11:30
 * To change this template use Upload | Settings | Upload Templates.
 */

namespace core\lib;

use core\db\interfaces\iDBController;
use core\traits\DataStructure;
use interfaces\iFactory;

class Factory
{
    use DataStructure;

    private static $_factory = NULL;
    private static $_fields = NULL;

    public function __construct ( iFactory $Factory )
    {
        self::$_factory = $Factory;
    }

    public function error ()
    {
        return self::$_factory->get_error ();
    }

    public function fabricate ()
    {
        if ( empty( self::$_fields ) ) {
            throw new \Exception(
                'Es necesario los campos a guardar.'
            );
        }

        return self::$_factory->create ( self::$_fields );
    }

    public function amend ( $_is_procedure = FALSE )
    {
        if ( empty( self::$_fields ) ) {
            throw new \Exception(
                'Es necesario los campos a guardar.'
            );
        }

        return self::$_factory->update ( self::$_fields, $_is_procedure );
    }

    public function prepareFields ( iDBController $DBController, $fields )
    {
        $_new     = [ ];
        $db_query = $DBController->getDbResult ();

        foreach ( self::verifyFields ( $fields ) as $key => $val ) {
            $_new[ $key ] = $db_query->prepare_value ( $val );
        }
        self::$_fields = $_new;
    }

    public static function verifyFields ( $input_fields )
    {
        $a = self::$_factory->get_fields ();
        $a = self::filterByMatch ( $a, '.' );
        $a = self::replaceByMatch ( $a, '/^((\w)\\.)/', '' );

        return array_intersect_key ( array_reverse ( $input_fields ), $a );
    }

    public function getFields ()
    {
        return self::$_fields;
    }
}