<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey Mena
 * Date: 06-15-13
 * Time: 02:56 PM
 * To change this template use Upload | Settings | Upload Templates.
 */
namespace core\db\mysql\model;

use core\App;
use core\interfaces\db\iDBConf;
use core\interfaces\db\iDBConnection;

App::__interface__ ( 'iDBConnection', 'db/interface' );


final class DBConnection implements iDBConnection
{
    static $_object = NULL;
    private static $_connection = NULL;
    private static $_is_connected = FALSE;

    /**Constructor de la clase
     * @param $conf
     * @param $_callback
     */
    public function __construct ( iDBConf $conf, $_callback )
    {
        self::$_connection = @new \MySqli();
        if ( !self::$_connection->real_connect (
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
        if ( $_options && !empty( $_options ) ) {
            foreach ( $_options as $_name => $_option ) {
                if ( isset( $_option ) ) {
                    self::$_connection->options ( $_name, $_options );
                }
            }
        }

        self::$_is_connected = TRUE;
        App::__callback__ ( $_callback, $this );

        return self::$_is_connected;
    }


    public static function isConnected ()
    {
        return self::$_is_connected;
    }

    /**Retorna la conexion actual*/
    public static function getConnection ()
    {
        return self::$_connection;
    }

    /**Cambia la base de datos actual
     * @param $db
     * @return bool
     */
    public static function switchDb ( $db )
    {
        if ( self::$_connection->select_db ( $db ) ) {
            return TRUE;
        }

        return FALSE;
    }

    /** Pocisiona el puntero en la tabla
     * @param $query    string
     * @param $position int comprendido entre 0 y la cantidad total de filas
     * @return bool
     */
    public static function switchPointer ( $query, $position )
    {
        if ( !( $result = self::$_connection->query ( $query ) ) ) {
            return FALSE;
        }

        return $result->data_seek ( $position );
    }

    public static function affectedRows ()
    {
        return self::$_connection->affected_rows;
    }

    public static function setCharset ( $charset )
    {
        return self::$_connection->query ( 'SET CHARACTER SET "' . $charset . '"' );
    }

    /**Destructor de la clase*/
    public function __destruct ()
    {
        if ( self::$_is_connected ) {
            self::$_connection->close ();
            self::$_is_connected = FALSE;
        }
    }


}

