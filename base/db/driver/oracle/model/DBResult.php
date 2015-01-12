<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 3/03/14
 * Time: 10:05
 * To change this template use Upload | Settings | Upload Templates.
 */

namespace core\oracle\model;

use core\App;
use core\db\interfaces\iDBConnection;
use core\db\interfaces\iDBResult;

App::__interface__ ( 'iDBResult', 'db/interface' );

class DBResult implements iDBResult
{

    private static $_object;
    private static $_is_connected;
    private static $_connection;

    /**Constructor de la clase
     * @param $DBConnection
     */
    public function __construct ( iDBConnection $DBConnection )
    {
        self::$_connection   = $DBConnection::getConnection ();
        self::$_is_connected = $DBConnection->_is_connected;
    }

    public static function __init ( iDBConnection $DBConnection )
    {
        if ( ! isset( self::$_object ) ) {
            self::$_object = new self( $DBConnection );
        }

        return self::$_object;
    }

    /**Retorna cantidad de filas
     * @param $_query
     * @param $_callback
     * @return void
     */
    public static function getNumRows ( $_query, $_callback )
    {
        if ( self::$_is_connected ) {
            self::execute ( $_query, function ( $result )
                use ( $_callback ) {
                    $res = $result->num_rows ();
                    $result->free ();
                    App::__callback__ ( $_callback, $res );
                }
            );
        }

    }

    /**Retorna valores desde una consulta count(~)
     * @param $_query
     * @param $_callback
     * @return void
     */
    public static function getCount ( $_query, $_callback )
    {
        if ( self::$_is_connected ) {
            self::execute ( $_query, function ( $result )
                use ( $_callback ) {
                    $_count = [ ];
                    while ( ( $res = $result->fetch_row () ) ) {
                        $_count[ ] = $res[ 0 ];
                    }
                    $result->free ();
                    App::__callback__ ( $_callback, $_count );
                }
            );

        }
    }


    /**Retorna la ejecucion de una multiquery select1,select2
     * @param $_query
     * @return Array
     * */
    public static function rowGroupMultiQuery ( $_query )
    {
        if ( self::$_connection->multi_query ( $_query ) ) {
            $array = [ ];
            do {
                if ( $result = self::$_connection->store_result () ) {
                    while ( ( $row = $result->fetch_assoc () ) ) {
                        $array[ ] = $row;
                    }
                    $result->free ();
                }
            } while ( self::$_connection->next_result () );

            return $array;
        }

        return [ ];
    }

    //Retorna la ultima id insertada
    public static function getInsertId ()
    {
        return self::$_connection->insert_id;
    }

    /**Realiza una consulta asyncrona o syncrona
     * @param $_query
     * @param $_callback
     * @return void
     */
    public static function execute ( $_query, $_callback )
    {
        if ( self::$_is_connected ) {
            $_async = defined ( 'DB_ASYNC' ) && DB_ASYNC;
            $_query = self::$_connection->query ( $_query, $_async
                                                             ? MYSQLI_ASYNC : NULL
            );
            if ( ! $_async ) {
                App::__callback__ ( $_callback, $_query );
            } else {
                $all_links = array ( self::$_connection );
                $processed = 0;
                do {
                    $links = $errors = $reject = array ();
                    foreach ( $all_links as $link ) {
                        $links[ ] = $errors[ ] = $reject[ ] = $link;
                    }
                    if ( ! mysqli_poll ( $links, $errors, $reject, 1 ) ) {
                        continue;
                    }
                    foreach ( $links as $link ) {
                        if ( $result = $link->reap_async_query () ) {
                            App::__callback__ ( $_callback, $result );
                            if ( is_object ( $result ) )
                                $result->free ();
                        } else die( sprintf ( "MySQLi Error: %s", $link->error () ) );
                        $processed ++;
                    }
                } while ( $processed < count ( $all_links ) );
            }
        }
    }

    /**Prepara una consulta para evitar inyecciones SQL
     * @param $_string
     */
    public static function prepare ( $_string )
    {
        return self::$_connection->real_escape_string ( $_string );
    }

    /**Retorna un arreglo de datos de un fetch_assoc
     * @param $_query
     * @param $_callback
     * @return void
     */
    public static function row ( $_query, $_callback )
    {
        if ( self::$_is_connected ) {
            self::execute ( $_query, function ( $result )
                use ( $_callback ) {
                    App::__callback__ ( $_callback, $result->fetch_assoc () );
                    $result->free ();
                }
            );
        }

    }

    //Retorna informacion de la query
    public static function getQueryInfo ()
    {
        return self::$_connection->info;
    }

    /**Retoran datos multidimensional y asociativos
     * @param $_query
     * @param $_callback
     * @return void
     */
    public static function rowGroup ( $_query, $_callback )
    {
        self::execute ( $_query, function ( $result )
            use ( $_callback ) {
                $_group = [ ];
                while ( ( $res = $result->fetch_assoc () ) ) {
                    $_group[ ] = $res;
                }
                App::__callback__ ( $_callback, $_group );
                $result->free ();
            }
        );

    }

}