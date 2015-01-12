<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey Mena
 * Date: 06-15-13
 * Time: 02:56 PM
 * To change this template use Upload | Settings | Upload Templates.
 */
namespace core\oracle\model;

use core\App;
use core\db\interfaces\iDBConf;
use core\db\interfaces\iDBConnection;

App::__interface__ ( 'iDBConnection', 'db/interface' );


class DBConnection implements iDBConnection
{
    static $_object = NULL;
    public static $_connection = NULL;
    public $_is_connected = FALSE;

    /**Constructor de la clase*/
    public function __construct ( iDBConf $conf, $_callback )
    {
        self::$_connection = @new \MySqli();
        if ( ! self::$_connection->real_connect (
            $conf::getHost (),
            $conf::getUser (),
            $conf::getPass (),
            $conf::getDatabase (), NULL, NULL, MYSQLI_CLIENT_COMPRESS
        )
        ) {
            App::__callback__ ( $_callback, $this );

            return FALSE;
        }

        $_options = $conf::getOptions ();
        if ( $_options && ! empty( $_options ) ) {
            foreach ( $_options as $_name => $_option ) {
                if ( isset( $_option ) ) {
                    self::$_connection->options ( $_name, $_options );
                }
            }
        }

        $this->_is_connected = TRUE;
        App::__callback__ ( $_callback, $this );

        return $this->_is_connected;
    }

    public static function __init ( iDBConf $conf, $_callback )
    {
        if ( ! isset( self::$_object ) ) {
            self::$_object = new self( $conf, $_callback );
        }

        return self::$_object;
    }

    /**Retorna la conexion actual*/
    public static function getConnection ()
    {
        return self::$_connection;
    }

    /**Cambia la base de datos actual
     * @bd string
     */
    public static function switchDb ( $db )
    {
        if ( self::$_connection->select_db ( $db ) ) {
            return TRUE;
        }

        return FALSE;
    }

    /** Pocisiona el puntero en la tabla
     * @query    string
     * @pocision entero comprendido entre 0 y la cantidad total de filas
     */
    public static function switchPointer ( $query, $position )
    {
        if ( ! ( $result = self::$_connection->query ( $query ) ) ) {
            return FALSE;
        }

        return $result->data_seek ( $position );
    }

    public static function affectedRows ()
    {
        return self::$_connection->affected_rows;
    }

    /**Destructor de la clase*/
    public function __destruct ()
    {
        if ( $this->_is_connected ) {
            self::$_connection->close ();
            $this->_is_connected = FALSE;
        }
    }


}

