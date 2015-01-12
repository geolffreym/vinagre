<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 18/02/14
 * Time: 10:33
 * To change this template use Upload | Settings | Upload Templates.
 */
use core\App;
use core\Model;

App::__require__ ( 'Information', 'model' );

class User extends Model
{
    public $_id_;
    public $_name_;

    public function getId ()
    {
        $Nested = clone $this->db->Builder;
        $Real   = clone $this->Builder;

        $Q            = new QHelper;
        $_information = new Information;

        $Nested
            ->select ( $_information, [ 'name' ] )
            ->from ( $_information );

        echo $Real
            ->select ( $this, [ 'id', $Q->max ( $this( 'id' ) ), $Q->lower ( $Q->concat ( [ $_information( 'name' ), $_information( 'name' ) ] ) ) ] )
            ->from ( $Q->nested ( $Nested, $_information->getAlias () ) )
            ->join ( $_information, [ 'name' ] )
            ->on ( [ $_information( 'id' ) => $this( 'id' ) ] )
            ->group ( [ $_information( 'name' ) ] )
            ->where ( $Q->in ( $_information( 'id' ), [ 5, 6 ] ) )
            ->order ( [ $_information( 'id' ), $this( 'id' ) ] )->result ();

    }

}