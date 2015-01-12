<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey Mena
 * Date: 07-03-13
 * Time: 09:15 PM
 * To change this template use File | Settings | File Templates.
 */
namespace core\helper;

//TODO Recreating

class VideoHelper
{
    private $server;
    private $propVideo = NULL;
    private $retorno = NULL;

    /**Constructor de la clase
     * @video FILE
     */
    public function __construct ( $video )
    {
        $this->server = new GestorORM();
        parent::__construct ( $video );
        $this->propVideo = parent::obtener_propiedades_archivo ();
    }

    /**Establece directorio del video
     * @dir string
     */
    public function setDirectorio ( $dir )
    {
        parent::set_directorio ( $dir );
    }

    /**Devuelve el directorio del video*/
    public function getDirectorio ()
    {
        return $this->_directorio;
    }

    /**Devuelve el peso del video*/
    public function getPeso ()
    {
        return parent::obtener_peso ( $this->propVideo[ 'tamano' ] );
    }

    /**Cambia el nombre del video
     * @actual string
     * @nuevo  string
     */
    public function cambiarNombre ( $actual, $nuevo )
    {
        parent::cambiar_nombre_video ( $actual, $nuevo );
    }

    /**Cambia el formato al video
     * @formato
     */
    public function cambiarFormato ( $formato )
    {
        parent::set_nuevo_formato ( $formato );
    }

    /**Cambiar el tamaño del video
     * @ancho int
     * @alto @int
     */
    public function cambiarTamano ( $ancho, $alto )
    {
        parent::set_size ( $ancho, $alto );
    }

    /**Establece la calidad del video Rango 10 (Mejor Calidad) - 0(Calidad Baja)
     * @int int
     */
    public function establecerCalidad ( $calidad )
    {
        parent::set_calidad ( $calidad );
    }

    /**Retorna el nombre del video*/
    public function verNombre ()
    {
        return parent::ver_nombre_video ();
    }

    /**Convierte el video*/
    public function convertirVideo ()
    {
        if ( is_uploaded_file ( $this->propVideo[ 'dir_temp' ] ) ) {
            if ( parent::valida_formato () ) {
                parent::convertir_video ();
                $this->retorno = array ( 'control' => 1 );
            } else {
                $this->retorno = array (
                    "dato"    => "Seleccione un formato correcto  .flv | .mp4 | .f4v | .avi | .wmv | .webm ",
                    'control' => 0
                );
            }
        } else {
            $this->retorno = array (
                'dato'    => "Por favor seleccione un video.",
                'control' => 0
            );
        }
    }

    /**Salida del proceso*/
    public function outPut ()
    {
        return $this->retorno;
    }
}