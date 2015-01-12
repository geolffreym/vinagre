<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey Mena
 * Date: 06-15-13
 * Time: 02:56 PM
 * To change this template use File | Settings | File Templates.
 */
//TODO Recreating
namespace core\helper;
class ImageHelper
{

    /**Atributos*/
    private $_foto = NULL;
    private $_retorno = [ ];
    private $_directorioFoto = NULL;
    private $_anchoNuevo = 260;
    private $_altoActual;
    private $_anchoActual;
    private $_maxAncho = 0;
    private $_maxAlto = 0;

    /**Metodo Constructor*/
    public function __construct ( $foto = NULL )
    {
        if ( ! isset( $foto ) ) {
            throw new \Exception(
                'Es necesaria la imagen'
            );
        }

        parent::__construct ( $foto );
        $this->_foto = parent::get_file_properties ();

    }

    /**Establece el ancho nuevo de la fotografia
     * @ancho int
     */
    public function setAnchoFoto ( $ancho )
    {
        $this->_anchoNuevo = $ancho;
    }

    /**Establece el maximo ancho que puede tener la fotografia
     * @maxAncho int
     */
    public function setMaxAnchoFoto ( $maxAncho )
    {
        $this->_maxAncho = $maxAncho;
    }

    /**Establece el maximo alto que puede tener la fotografia
     * @maxAlto int
     */
    public function setMaxAltoFoto ( $maxAlto )
    {
        $this->_maxAncho = $maxAlto;
    }

    /**Retorna el directorio actual*/
    public function getDirectorioFoto ()
    {
        return $this->_directorioFoto;
    }

    /**Establece el nuevo directorio donde sera copiada la fotografia
     * @nuevoDirectorio int
     */
    public function setDirectorioFoto ( $nuevoDirectorio )
    {
        $this->_directorioFoto = $nuevoDirectorio;
    }

    /**Genera una fotografia en base a la configuracion dada*/
    public function crearFotografia ()
    {
        if ( parent::file_format () ) {
            list( $this->_anchoActual, $this->_altoActual ) = parent::get_image_size ( $this->_directory );
            if ( is_uploaded_file ( $this->_foto[ 'temp_dir' ] ) ) {
                if ( $this->_anchoActual > $this->_maxAncho or $this->_altoActual > $this->_maxAlto ) {
                    parent::generar_imagen ( $this->_anchoNuevo );
                } else {
                    parent::generar_imagen ( $this->_anchoActual );
                }
                if ( isset( $this->_directorioFoto ) ) {
                    parent::copy_file ( $this->_directorioFoto );
                } else {
                    throw new \Exception(
                        'Por favor establezca un directorio valido'
                    );
                }
                $this->_retorno[ 'foto' ] = str_replace ( BASE_MEDIA, '', '/' . $this->_directorioFoto );
            } else {
                $this->_retorno = array (
                    'error'   => "ERROR",
                    'mensaje' => "Error Subiendo Archivo"
                );
            }
        } else {
            $this->_retorno = array (
                'error'   => "FORMATO_INVALIDO",
                'mensaje' => "Seleccione un formato correcto .jpg | .gif | .bmp | .png "
            );
        }

    }

    public function outPut ()
    {
        return $this->_retorno;
    }

}
