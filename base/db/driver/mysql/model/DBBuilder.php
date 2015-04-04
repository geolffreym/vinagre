<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-10-14
 * Time: 11:34 AM
 */

namespace core\db\mysql\model;

//use \core\db\interfaces\iDBBuilder;
use core\helper\ArrayHelper;
use core\traits\DataStructure;
use core\interfaces\db\iDBResult;
use core\interfaces\iModel;


final class DBBuilder // implements iDBBuilder
{
    use DataStructure;

    public $_query = [ ];
    public $_query_string = '';
    private $_aliases = [ ];

    private $DBResult = NULL;
    private $_temp_model = NULL;
    private $_models = [ ];
    private $_condition = [
        '!=',
        '=',
        'LIKE'
    ];
    private $_joins = [
        'INNER',
        'LEFT',
        'RIGHT'
    ];
    private $_logic_operator = [
        'AND',
        'OR'
    ];
    private $_alias = - 1;
    static $_clone = 0;

    public function __construct ( iDBResult $DBResult )
    {
        $this->DBResult = $DBResult;
    }

    //Query to string
    public function __toString ()
    {
        $_select = isset( $this->_query[ 'select' ] ) ? $this->_query[ 'select' ] : 'SELECT * ';
        $_from   = isset( $this->_query[ 'from' ] ) ? $this->_query[ 'from' ] : '';

        $this->_query_string = $_select . $_from;
        $this->_joinON ( 'join', 'on' );
        $this->_appendQuery ( 'join_on' );
        $this->_appendQuery ( 'group' );
        $this->_appendQuery ( 'where' );
        $this->_appendQuery ( 'order' );

        return $this->_query_string;

    }

    //Return Instance
    public function __instance ( iDBResult $DBResult )
    {
        return new self( $DBResult );

    }

    //Clone Object
    public function __clone ()
    {
        self::$_clone ++;
    }


    public function result ()
    {
        $this->DBResult->setQuery ( $this );

        return $this->DBResult;

    }

    /**Set select for query
     * @param $_model
     * @param $_attr
     * @return $this
     * */
    public function select ( iModel $_model, $_attr = '*' )
    {
        $this->_models[ ]  = $_model;
        $this->_temp_model = $_model;
        $this->_appendAttribute ( $_model, $_attr, TRUE );

        return $this;
    }

    /**Set from table for query
     * @param $_model
     * @return $this
     * */
    public function from ( $_model )
    {
        if ( $_model instanceof iModel ) {
            $_model                  = $this->_filterNameModel ( $_model );
            $this->_temp_model       = $_model;
            $this->_query [ 'from' ] = ' FROM ' . $_model;
        } elseif ( isset( $_model[ 'attr' ] ) ) {
            $this->_query [ 'from' ] = ' FROM ' . $_model[ 'attr' ];
        }

        return $this;
    }


    /**Set join in query
     * @param $_model
     * @param $_attr
     * @param $_type
     * @return $this
     * */
    public function join ( iModel $_model, $_attr = FALSE, $_type = NULL )
    {
        if ( is_string ( $_attr ) || isset( $_type ) ) {
            $_type = is_string ( $_attr )
                ? strtoupper ( $_attr )
                : strtoupper ( $_type );
            if ( !in_array ( $_type, $this->_joins ) ) {
                $_type = 'INNER';
            }
        } else {
            $_type = 'INNER';
        }

        if ( is_array ( $_attr ) ) {
            $this->values ( $_model, $_attr );
        } else {
            $this->_appendAliases ( $_model );

        }
        $this->_models[ ]          = $_model;
        $this->_temp_model         = $_model;
        $_model                    = $this->_filterNameModel ( $_model );
        $this->_query[ 'join' ][ ] = ' ' . $_type . '  OUTER JOIN ' . $_model;

        return $this;
    }

    /**Set values for table selected
     * @param $_model
     * @param $_attr
     * @return $this
     * */
    public function values ( iModel $_model, $_attr )
    {
        $this->_appendAttribute ( $_model, $_attr, TRUE );

        return $this;
    }

    /**Set on condition for join
     * @param $_attr
     * @param $_char {Like, =}
     * @param $_type {AND, OR}
     * @return $this
     * */
    public function on ( $_attr = [ ], $_char = '=', $_type = 'AND' )
    {
        if ( is_array ( $_attr ) ) {
            if ( !in_array ( $_char, $this->_condition ) ) {
                $_char = '=';
            }

            if ( !in_array ( $_type, $this->_logic_operator ) ) {
                $_type = 'AND';
            }
            $_attr                    = $this->_prepareValues ( $_attr );
            $_attr                    = $this->_joinAttr ( $_attr, $_char );
            $this->_query [ 'on' ][ ] = ' ON ' . $this->_implodeAttr ( $_attr, ' ' . $_type . ' ' );
        }

        return $this;
    }

    /**Set condition for query
     * @param $_attr
     * @param $_char {=,Like}
     * @param $_type {AND,OR}
     * @return $this
     * */
    public function where ( $_attr = [ ], $_char = '=', $_type = 'AND' )
    {
        if ( !in_array ( $_char, $this->_condition ) ) {
            $_char = '=';
        }

        if ( !in_array ( $_type, $this->_logic_operator ) ) {
            $_type = 'AND';
        }
        $_where = ' WHERE ';
        if ( !empty( $_attr[ 'attr' ] ) ) {
            $_where .= $_attr[ 'attr' ];
        } else {
            $_attr = $this->_prepareValues ( $_attr );
            $_attr = $this->_joinAttr ( $_attr, $_char );
            $_where .= $this->_implodeAttr ( $_attr, $_type );
        }
        $this->_query [ 'where' ][ ] = $_where;

        return $this;
    }

    /**Set order for query
     * @param $_attr
     * @param $_type {DESC, ASC}
     * @return $this
     * */

    public function order ( $_attr = [ ], $_type = 'DESC' )
    {
        $this->_query [ 'order' ][ ] = ' ORDER BY ' . $this->_implodeAttr ( $_attr, ',' ) . ' ' . $_type . ' ';

        return $this;
    }

    /**Set group for query
     * @param $_attr
     * @param $_type {,}
     * @return $this
     * */
    public function group ( $_attr = [ ], $_type = ',' )
    {
        $this->_query [ 'group' ][ ] = ' GROUP BY ' . $this->_implodeAttr ( $_attr, $_type );

        return $this;
    }

    /**Join On with JOIN
     * @param $_a {JOIN Index Array}
     * @param $_b {ON Index Array}
     * @return void
     * */
    private function _joinON ( $_a, $_b )
    {
        if ( isset( $this->_query[ $_a ] ) && isset( $this->_query[ $_b ] ) ) {
            if ( ( count ( $this->_query[ $_a ] ) > 0 ) && ( count ( $this->_query[ $_b ] ) > 0 ) ) {
                $this->_query[ 'join_on' ] = ArrayHelper::generatorToArray (
                    $this->mergeByChar ( $this->_query[ $_a ], $this->_query[ $_b ], ' ' )
                );
            }
        }
    }

    /**Add query string to main Query
     * @param $_index {index of array}
     * @return void
     * */
    private function _appendQuery ( $_index )
    {
        if ( isset( $this->_query[ $_index ] ) ) {
            if ( count ( $this->_query[ $_index ] ) > 0 ) {
                foreach ( $this->_query[ $_index ] as $_elem ) {
                    $this->_query_string .= $_elem;
                }
            }
        }

    }

    /**Add aliases to attribute or table in query
     * @param $_model
     * @return void
     * */
    private function _appendAliases ( iModel $_model )
    {
        $this->_alias ++;
        $this->_aliases[ ] = $_model->getAlias ();
    }

    /**Implode elements of array
     * @param $_attr {Array}
     * @param $_char
     * @return Array
     * */
    private function _implodeAttr ( $_attr = [ ], $_char = ',' )
    {
        if ( is_array ( $_attr ) ) {
            return implode ( $_char, $_attr );
        }

        return $_attr;
    }

    /**Avoid Injections
     * @param $_attr
     * @return Array
     * */
    private function _prepareValues ( $_attr = [ ] )
    {
        if ( isset( $this->_temp_model ) ) {
            return $this->_temp_model->prepareFields ( $_attr );
        }

        return $_attr;
    }

    /**Join attr key=value for  query
     * @param $_model_attr
     * @param $_char
     * @return Array
     * */
    private function _joinAttr ( $_model_attr = [ ], $_char = '=' )
    {
        if ( is_array ( $_model_attr ) ) {
            return ArrayHelper::generatorToArray ( $this->mergeKeyValue ( $_model_attr, ' ' . $_char . ' ' ) );
        }

        return $_model_attr;
    }

    /**Filter valid attributes in model
     * @param $_model
     * @param $_attr
     * @param $_array {is array?}
     * @return Array
     * */
    private function _filterAttributeModel ( iModel $_model, $_attr, $_array = FALSE )
    {
        if ( is_array ( $_attr )
        ) {
            $_attr = $_model->prepareFields ( $_attr );
            $_attr = $_model->validateField ( $_attr, $_array );

            return $this->_findAliases ( $_attr );
        }

        return $this->_findAliases ( $_attr );
    }


    /**Fin model Name
     * @param $_model
     * @return String {Model name with respective alias}
     * */
    private function _filterNameModel ( iModel $_model )
    {
        $_name = $_model->getModelName ( $_model );

        return $this->_findAliases ( $_name, FALSE );
    }

    /**Append Attribute to query correspondient model
     * @param $_model
     * @param $_attr
     * @param $_array {is array?}
     * @return $this
     * */
    private function _appendAttribute ( iModel $_model, $_attr, $_array = TRUE )
    {
        $this->_appendAliases ( $_model );
        $_attr = $this->_filterAttributeModel ( $_model, $_attr, $_array );
        if ( isset( $this->_query[ 'select' ] ) ) {
            $this->_query[ 'select' ] .= ',' . $this->_implodeAttr ( $_attr );
        } else {
            $this->_query[ 'select' ] = 'SELECT ' . $this->_implodeAttr ( $_attr );
        }
    }

    /**Set aliases for query
     * @param $_attr
     * @param $_pre {alias before elemento or after}
     * @return String
     * */
    private function _findAliases ( $_attr = [ ], $_pre = TRUE )
    {
        if ( isset( $this->_aliases[ $this->_alias ] ) ) {
            $_alias = $this->_aliases[ $this->_alias ];
            if ( is_array ( $_attr ) ) {
                foreach ( $_attr as $k => $v ) {
                    if ( isset( $v[ 'attr' ] ) ) {
                        $_attr[ $k ] = $v[ 'attr' ];
                    } else {
                        $_attr[ $k ] = ( $_pre ? $_alias . '.' . $v : $v . ' ' . $_alias );
                    }
                }
            } else {
                $_attr = ( $_pre ? $_alias . '.' . $_attr : $_attr . ' ' . $_alias );
            }

        }

        return $_attr;
    }
} 