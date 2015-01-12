<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 13/03/14
 * Time: 10:04
 * To change this template use Upload | Settings | Upload Templates.
 */
abstract class Multimedia
{

    protected $_directory;
    protected $_file;

    public function getDirectory ()
    {
        return $this->_directory;
    }

    public function getFileProperties ()
    {
        if ( ! empty( $this->_file ) ) {
            return array ( 'name'     => $this->_file->getName (),
                           'temp_dir' => $this->_file->getDirectory (),
                           'type'     => $this->_file->getType (),
                           'size'     => $this->_file->getSize (),
                           'object'   => $this->_file
            );
        } else {
            throw new \Exception( 'iFile Needed' );
        }
    }

    /**Convierte y devuelve el peso
     * @cantidad int bytes
     */
    public function getFileSize ( $bytes = NULL )
    {
        $mb = NULL;
        if ( isset( $bytes ) ) {
            $bytes = $bytes / 1024;
            if ( $bytes < 1024 ) {
                $mb = round ( $bytes, 2 ) . ' KB';
            } else {
                if ( $bytes >= 1024 ) {
                    $mb = round ( $bytes / 1024, 2 ) . ' MB';
                }
            }
            if ( intval ( $mb ) >= 1024 ) {
                $mb = round ( intval ( $mb / 1024 ), 2 ) . ' GB';
            }
        } else {
            throw new \Exception( 'Bytes needed' );
        }

        return $mb;
    }

    /**Busca y devuelve el formato
     * @formato_a_buscar Array
     */
    public function fileFormat ( $_needle )
    {
        if ( isset( $_needle ) and is_array ( $_needle ) and ! empty( $this->_file ) ) {
            $_get = end ( explode ( ".", strtolower ( $this->_file->getName () ) ) );
            if ( ! in_array ( $_get, $_needle ) ) {
                return FALSE;
            } else {
                return $_get;
            }
        } else {
            return FALSE;
        }
    }

    /**Copia Archivo
     * @destino string
     */
    public function copyFile ( $new_directory = NULL )
    {
        if ( ! isset( $new_directory ) and ! isset( $this->_directory ) ) {
            throw new \Exception( 'New directory needed' );
        }

        if ( copy ( $this->_directory, $new_directory ) ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**Establece directorio actual*/
    public function setDirectory ( $_directory = NULL )
    {
        if ( ! isset( $_directory ) ) {
            throw new \Exception( "Directory needed" );
        }
        $this->_directory = $_directory;
    }

    /**Mueve un archivo*/
    public function moveFile ( $_directory = NULL )
    {
        if ( ! isset( $_directory ) and ! isset( $this->_directory ) ) {
            throw new \Exception( 'New directory needed' );
        }
        if ( move_uploaded_file ( $this->_directory, $_directory ) ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}