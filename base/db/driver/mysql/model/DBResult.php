<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 3/03/14
 * Time: 10:05
 * To change this template use Upload | Settings | Upload Templates.
 */

namespace core\db\mysql\model;

use core\App;
use core\Exception;
use core\interfaces\db\iDBConnection;
use core\interfaces\db\iDBResult;

App::__interface__ ( 'iDBResult', 'db/interface' );

final class DBResult implements iDBResult
{

    private static $_object;
    private static $_is_connected;
    private static $_connection;
    private static $_query = NULL;
    private static $_async = FALSE;

    /**Constructor de la clase
     * @param $DBConnection
     */
    public function __construct ( iDBConnection $DBConnection )
    {
        self::$_connection   = $DBConnection::getConnection ();
        self::$_is_connected = $DBConnection::isConnected ();
    }

    public static function __init ( iDBConnection $DBConnection )
    {
        if ( !isset( self::$_object ) ) {
            self::$_object = new self( $DBConnection );
        }

        return self::$_object;
    }

    public static function setQuery ( $_query )
    {
        asserts ( $_query, "Query Needed" );
        self::$_query = $_query;
    }

    public static function async ()
    {
        self::$_async = TRUE;
    }

    /**Retorna cantidad de filas
     * @param $_query
     * @param $_callback
     * @return object
     */
    public static function getNumRows ( $_query, $_callback = FALSE )
    {
        if ( self::$_is_connected ) {
            self::_queryImpose ( $_query, $_callback );
            asserts ( $_query, "Query Needed", self::$_query );

            return self::execute ( $_query, function ( $result )
                use ( $_callback ) {
                    if ( $result ) {
                        $res = $result->num_rows ();
                        $result->free ();

                        return App::__callback__ ( $_callback, $res );
                    }

                    return NULL;
                }
            );
        }

        return FALSE;
    }

    /**Retorna valores desde una consulta count(~)
     * @param $_query
     * @param $_callback
     * @return object
     */
    public static function getCount ( $_query, $_callback = FALSE )
    {
        if ( self::$_is_connected ) {
            self::_queryImpose ( $_query, $_callback );
            asserts ( $_query, "Query Needed", self::$_query );

            return self::execute ( $_query, function ( $result )
                use ( $_callback ) {
                    if ( $result ) {
                        $_count = [ ];
                        while ( ( $res = $result->fetch_row () ) ) {
                            $_count[ ] = $res[ 0 ];
                        }
                        $result->free ();

                        return App::__callback__ ( $_callback, $_count );
                    }

                    return NULL;
                }
            );
        }

        return FALSE;
    }


    /**Retorna la ejecucion de una multiquery select1,select2
     * @param $_query
     * @return Array
     * */
    public static function rowGroupMultiQuery ( $_query )
    {

        asserts ( $_query, "Query Needed", self::$_query );
        if ( self::$_connection->multi_query ( $_query ) ) {
            $array = [ ];
            do {
                if ( ( $result = self::$_connection->store_result () ) ) {
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
     * @return object
     */
    public static function execute ( $_query, $_callback )
    {
        if ( self::$_is_connected ) {

            //Async Mysql Queries?
            $_async = ( defined ( 'DB_ASYNC' ) && DB_ASYNC ) || self::$_async;
            self::_queryImpose ( $_query, $_callback );
            asserts ( $_query, "Query Needed", self::$_query );

            //Make Query
            $_query = self::$_connection->query (
                $_query,
                $_async ? MYSQLI_ASYNC : MYSQLI_USE_RESULT
            );

            //Is async?
            if ( !$_async ) {
                return App::__callback__ ( $_callback, $_query );
            } else {
                Exception::create ( function () {
                        return function_exists ( 'mysqlnd_conn_get_methods' );
                    }, 'MySqlNd driver needed to async queries'
                );
                // TODO pending async support. Available only with mysqlnd
                // TODO http://php.net/manual/en/book.mysqlnd.php

                $all_links = [ self::$_connection ];
                $processed = 0;
                do {
                    $links = $errors = $reject = [ ];

                    foreach ( $all_links as $link ) {
                        $links[ ] = $errors[ ] = $reject[ ] = $link;
                    }

                    if ( !mysqli_poll ( $links, $errors, $reject, 1 ) ) {
                        continue;
                    }

                    foreach ( $links as $link ) {
                        if ( $result = $link->reap_async_query () ) {
                            if ( $result ) {
                                $result->free ();
                                App::__callback__ ( $_callback, $result );
                            }
                        } else {
                            App::__callback__ ( $_callback, FALSE );
                        };
                        $processed ++;
                    }
                } while ( $processed < count ( $all_links ) );
            }
        }

        return NULL;
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
     * @return object
     */
    public static function row ( $_query, $_callback = FALSE )
    {
        if ( self::$_is_connected ) {
            self::_queryImpose ( $_query, $_callback );
            asserts ( $_query, "Query Needed", self::$_query );

            return self::execute ( $_query, function ( $result )
                use ( $_callback ) {
                    if ( $result ) {
                        $res = $result->fetch_assoc ();
                        $result->free ();

                        return App::__callback__ ( $_callback, $res );
                    }

                    return [ ];
                }
            );
        }

        return FALSE;
    }

    //Retorna informacion de la query
    public static function getQueryInfo ()
    {
        return self::$_connection->info;
    }

    /**Retoran datos multidimensional y asociativos
     * @param $_query
     * @param $_callback
     * @return object
     */
    public static function rowGroup ( $_query, $_callback = FALSE )
    {
        self::_queryImpose ( $_query, $_callback );
        asserts ( $_query, "Query Needed", self::$_query );
        if ( self::$_is_connected ) {
            return self::execute ( $_query, function ( $result )
                use ( $_callback ) {
                    if ( $result ) {
                        $_group = [ ];
                        while ( ( $res = $result->fetch_assoc () ) ) {
                            $_group[ ] = $res;
                        }
                        $result->free ();

                        return App::__callback__ ( $_callback, $_group );
                    }

                    return [ ];
                }
            );
        }

        return FALSE;
    }

    private static function _queryImpose ( &$_query, &$_callback )
    {
        if ( isFunction ( $_query ) ) {
            $_callback = $_query;
            $_query    = NULL;
        }
    }

}