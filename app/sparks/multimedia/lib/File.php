<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 14/03/14
 * Time: 10:02
 * To change this template use File | Settings | File Templates.
 */

use multimedia\interfaces\iFile;

class File extends Multimedia implements iFile
{

    private $_name;
    private $_type;
    private $_size;
    private $_error = NULL;

    public function setFile ( $_file, $_file_name )
    {

        if ( ! is_array ( $_file ) ) {
            throw new \Exception(
                "File type needed"
            );
        }

        $_file = $_file[ $_file_name ];

        $this->_name      = $_file[ 'name' ];
        $this->_size      = $_file[ 'size' ];
        $this->_type      = $_file[ 'type' ];
        $this->_directory = $_file[ 'tmp_name' ];

        if ( isset( $_file[ 'error' ] ) ) {
            $this->_error = $_file[ 'error' ];
        }

        $this->_file       = $this;
    }

    public function getName ()
    {
        return $this->_name;
    }

    public function getDirectory ()
    {
        return $this->_directory;
    }

    public function getType ()
    {
        return $this->_type;
    }

    public function getSize ()
    {
        return $this->_size;
    }
}