<?php
namespace core\lib;

use core\helper\ArrayHelper;
use core\traits\DataStructure;

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 08-09-14
 * Time: 02:08 PM
 */
class Form
{
    use DataStructure;

    private static $_container_input = NULL;
    private static $_class_input = NULL;
    private static $_placeholder_input = NULL;
    private static $_form = [ "<form " ];


    public static function form ( $_params = [ ] )
    {
        if ( isset( $_params[ 'input_in' ] ) ) {
            $_container             = explode ( '.', $_params[ 'input_in' ] );
            self::$_container_input = [ 'container' => $_container[ 0 ], 'class' => $_container[ 1 ] ];
        }

        if ( isset( $_params[ 'input_class' ] ) ) {
            self::$_class_input = $_params[ 'input_class' ];
        }

        if ( isset( $_params[ 'input_placeholder' ] ) ) {
            if ( is_array ( $_params[ 'input_placeholder' ][ 'placeholder' ] ) )
                self::$_placeholder_input = $_params[ 'input_placeholder' ][ 'placeholder' ];
        }


        self::$_form [ ] = self::_merge ( $_params );
        self::$_form [ ] = " >\n";


        if ( isset( $_params[ 'csrf_token' ] ) ) {
            self::input ( [ 'name' => 'token', 'type' => 'hidden', 'value' => $_params[ 'csrf_token' ] ] );
        }

        if ( isset( $_params[ 'honey_pot' ] ) ) {
            self::input ( [ 'name' => 'honeypot', 'type' => 'text', 'style' => 'display:none', 'value' => "" ] );
        }

        if ( isset( $_params[ 'input_fields' ][ 'form' ] ) ) {
            if ( is_array ( $_params[ 'input_fields' ][ 'form' ] ) ) {
                foreach ( $_params[ 'input_fields' ][ 'form' ] as $k => $_input ) {
                    self::_proccesComponent ( $k, $_input );
                }
            }
        }

        if ( isset( $_params[ 'auto_make' ] ) ) {
            self::make ();
        }

    }


    public static function make ()
    {
        self::$_form [ ] = "</form>";

        echo join ( "", self::$_form );
    }

    public static function input ( $_params = [ ], $_append = TRUE )
    {
        self::_boxStart ( $_input );
        self::_label ( $_params, $_input );
        $_input .= "<input ";

        $_input .= self::_merge ( $_params );
        $_input = self::_classControl ( $_params, $_input );
        $_input = self::_placeholderControl ( $_params, $_input );

        $_input .= " /> \n";

        self::_boxEnd ( $_input );
        if ( $_append )
            self::$_form [ ] = $_input;

        return $_input;

    }

    private static function _label ( $_params = [ ], &$_input )
    {
        if ( isset( $_params[ 'label' ] ) ) {
            $_input .= self::label ( $_params[ 'label' ], FALSE );
        }
    }

    public static function label ( $_params = [ ], $append = TRUE )
    {
        $_label = "<label ";
        $_label .= self::_merge ( $_params );
        $_label .= " >" . ( isset( $_params[ 'content' ] ) ? $_params[ 'content' ] : '' ) . "</label>\n";
        if ( $append )
            self::$_form[ ] = $_label;

        return $_label;

    }

    public static function textarea ( $_params = [ ] )
    {

        self::_boxStart ( $_input );
        self::_label ( $_params, $_input );

        $_input .= "<textarea ";

        $_input .= self::_merge ( $_params );
        $_input = self::_classControl ( $_params, $_input );
        $_input = self::_placeholderControl ( $_params, $_input );

        $_input .= " >" . ( isset( $_params[ 'content' ] ) ? $_params[ 'content' ] : '' ) . "</textarea> \n";

        self::_boxEnd ( $_input );

        self::$_form [ ] = $_input;


        return $_input;
    }

    public static function select ( $_params = [ ] )
    {
        self::_boxStart ( $_input );
        self::_label ( $_params, $_input );
        $_options = $_params[ 'options' ];

        $_input .= "<select ";

        $_input .= self::_merge ( $_params );
        $_input = self::_classControl ( $_params, $_input );
        $_input = self::_placeholderControl ( $_params, $_input );

        $_input .= " >";

        self::_options ( $_options, $_input );

        $_input .= '</select>';

        self::_boxEnd ( $_input );
        self::$_form [ ] = $_input;

        return $_input;
    }

    public static function _options ( $_params = [ ], &$_input )
    {
        if ( !empty( $_params ) ) {
            $_input .= self::options ( $_params, FALSE );
        }
    }

    public static function options ( $_params = [ ], $append = TRUE )
    {
        $_option = "";
        foreach ( $_params as $opt ) {
            $_option .= "<option ";
            $_option .= self::_merge ( $opt );
            $_option .= " >" . ( isset( $opt[ 'content' ] ) ? $opt[ 'content' ] : '' ) . "</option>\n";
        }

        if ( $append )
            self::$_form[ ] = $_option;

        return $_option;
    }

    public function _object ()
    {
        return $this;
    }

    private static function _proccesComponent ( $type, $data )
    {
        foreach ( $data as $elem ) {
            self::$type( $elem );
        }

    }

    private static function _classControl ( $_params = [ ], $_input )
    {

        if ( isset( self::$_class_input ) && !isset( $_params[ 'class' ] ) ) {
            return $_input .= ' class="' . self::$_class_input . '"';
        }

        return $_input;
    }

    private static function _boxStart ( &$_input )
    {

        $_input = isset( self::$_container_input )
            ? '<' . self::$_container_input[ 'container' ] . " class='" . self::$_container_input[ 'class' ] . "'>\n"
            : '';
    }

    private static function _boxEnd ( &$_input )
    {
        $_input .= isset( self::$_container_input )
            ? '</' . self::$_container_input[ 'container' ] . '>'
            : '';
    }

    private static function _placeholderControl ( $_params, $_input )
    {
        if ( isset( self::$_placeholder_input ) ) {
            if ( isset( $_params[ 'name' ] ) ) {
                if ( isset( self::$_placeholder_input[ $_params[ 'name' ] ] ) && !isset( $_params[ 'placeholder' ] ) ) {
                    return $_input .= ' placeholder= ' . self::$_placeholder_input[ $_params[ 'name' ] ];
                }
            }
        }

        return $_input;
    }


    private static function _merge ( $_params = NULL )
    {
        $_properties = NULL;

        if ( is_array ( $_params ) ) {
            unset( $_params[ 'auto_make' ] );
            unset( $_params[ 'label' ] );
            unset( $_params[ 'content' ] );
            unset( $_params[ 'honey_pot' ] );
            unset( $_params[ 'csrf_token' ] );
            unset( $_params[ 'input_in' ] );
            unset( $_params[ 'options' ] );
            unset( $_params[ 'input_class' ] );
            unset( $_params[ 'input_fields' ] );
            unset( $_params[ 'input_placeholder' ] );
            $_properties = ArrayHelper::generatorToArray ( self::mergeKeyValue ( $_params, ' = ' ) );
            $_properties = implode ( ' ', $_properties );
        }

        return $_properties;

    }
}