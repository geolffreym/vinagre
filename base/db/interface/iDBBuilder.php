<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-11-14
 * Time: 02:01 PM
 */

namespace core\interfaces\db;

use core\interfaces\iModel;

interface iDBBuilder
{

    public function __construct ( iDBResult $DBResult );

    public function result ();

    public function __toString ();

    public function __instance ();

    public function __clone ();

    public function select ( iModel $_model, $_attr = '*' );

    public function from ( $_model );

    public function join ( iModel $_model, $_attr = FALSE, $type = NULL );

    public function values ( iModel $_model, $_attr );

    public function on ( $_attr = [ ], $_char = '=', $_type = 'AND' );

    public function where ( $_attr = [ ], $_char = '=', $_type = 'AND' );

    public function order ( $_attr = [ ], $_type = 'DESC' );

    public function group ( $_attr = [ ], $_type = ',' );

}