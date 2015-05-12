<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-15-14
 * Time: 10:16 AM
 */

use core\Model;

class TestA extends Model
{
    public $_id_;
}


class TestModel extends Model
{
    public $_id_; //By convention the model attributes must be named as _attr_
    public $_id_test_; //By convention the model attributes must be named as _attr_

    public function getId ()
    {
        $testA = new TestA();
        $testA = $testA->db->get ( [ 'id' => 2 ] );

        echo $this->db->get ( [ 'id_test' => $testA ] )->values ( 'id' )->query ();
    }

}