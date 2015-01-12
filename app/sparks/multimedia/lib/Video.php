<?php

//TODO Recreating
class Video
{

    public function __construct ()
    {

    }
//    /**Main*/
//    private $_archivo;
//    /**Video*/
//    private $_formato = 'ogv';
//    private $_codec = 'libtheora';
//    private $_tamano = '600X400';
//    private $_calidad = null;
//    private $_nombre = null;
//    private $_propiedades;
//    private $_rendimiento = 16;
//    private $_vbitrate = null;
//    private $_fps = 25;
//    protected $_nuevodirectorio = null;
//    /**Audio*/
//    private $_noaudio = false;
//    private $_codec_audio = 'libvorbis';
//    private $_abitrate = 128;
//
//    /**Heredadas*/
////    public function __construct($archivo)
////    {
////        $this->_archivo = $archivo;
////        parent::__construct($this->_archivo, 'video');
////        $this->_propiedades = parent::obtener_propiedades_archivo();
////        $this->_nuevodirectorio = $this->_directorio;
////    }
//
//    public function set_directorio($directorio)
//    {
//        parent::set_directorio($directorio);
//        $this->_nuevodirectorio = $directorio;
//    }
//
//    public function ver_directorio()
//    {
//        return $this->_directorio;
//    }
//
//    public function obtener_propiedades_archivo()
//    {
//        return parent::obtener_propiedades_archivo();
//    }
//
//    public function valida_formato()
//    {
//        $formato = array("flv", "mp4", "f4v", "avi", "wmv", 'webm');
//        return parent::valida_formato($formato);
//
//    }
//
//    public function obtener_formato($formato_a_buscar = NULL)
//    {
//        if (!isset($formato_a_buscar) || !is_array($formato_a_buscar)) {
//            $formato_a_buscar = array("flv", "mp4", "f4v", 'wmv', 'avi', 'webm');
//        }
//        return parent::obtener_formato($formato_a_buscar);
//    }
//
//    /**Rendimiento*/
//    public function set_rendimiento($int = null)
//    {
//        if (!isset($int)) {
//            return false;
//        }
//        $this->_rendimiento = $int;
//    }
//
//    /**Audio Conf*/
//    public function set_audio_bitrate($bitrate)
//    {
//        if (!isset($bitrate)) {
//            return false;
//        }
//        $this->_abitrate = $bitrate;
//    }
//
//    public function get_audio_bitrate()
//    {
//        return $this->_abitrate;
//    }
//
//    public function no_audio($bool)
//    {
//        if (!isset($bool)) {
//            return false;
//        }
//        $this->_noaudio = $bool;
//    }
//
//    /**Format Conf*/
//    public function set_nuevo_formato($formato)
//    {
//        if (!isset($formato)) {
//            return false;
//        }
//        $formato_actual = $this->obtener_formato();
//        $this->_formato = $formato;
//        $this->_nuevodirectorio = str_replace(
//            $formato_actual, $this->_formato, $this->_nuevodirectorio
//        );
//        $this->switch_codec();
//    }
//
//    public function ver_formato_actual()
//    {
//        return $this->_formato;
//    }
//
//    /**Quality Conf
//     * OGV ->
//     * -qscale:v – video quality. Range is 0–10, where 10 is highest quality. 5–7 is a good range to try. If you omit -qscale:v (or the alias -q:v) then ffmpeg will use the default -b:v 200k which will most likely provide a poor quality output.
//     * -qscale:a – audio quality. Range is 0–10, where 10 is highest quality. 3–6 is a good range to try. Default is -qscale:a 3.
//     */
//    public function set_calidad($calidad)
//    {
//        if (!isset($calidad) and $calidad <= 10) {
//            return false;
//        } else {
//            $calidad = 7;
//        }
//        $this->_calidad = $calidad;
//    }
//
//    public function get_calidad()
//    {
//        return $this->_calidad;
//    }
//
//    /**Tamaño Video*/
//    public function set_size($ancho = null, $alto = null)
//    {
//        if (!isset($ancho) || !isset($alto)) {
//            return false;
//        }
//        $this->_tamano = $ancho . 'X' . $alto;
//    }
//
//    /**Propiedades FFMPEG video*/
//    public function set_video_bitrate($bitrate)
//    {
//        if (!isset($bitrate)) {
//            return false;
//        }
//        $this->_vbitrate = $bitrate;
//    }
//
//    public function set_fps($fps)
//    {
//        if (!isset($fps)) {
//            return false;
//        }
//        $this->_fps = $fps;
//    }
//
//    public function get_video_bitrate()
//    {
//        /**
//         * (50 MB * 8192 [convertir MB a kilobits]) / 600 secgundos = ~683 kilobits/s bitrate total
//         * 683k - 128k (bitrate audio) = 555k video bitrate
//         */
//        if (isset($this->_vbitrate)) {
//            return $this->_vbitrate;
//        } else {
//            $video = $this->get_propiedades_video();
//            $kilobytes = round($this->_propiedades['tamano'] / 1024);
//            $peso = round($kilobytes / 1024);
//            $vbitrate = round(($peso * $kilobytes) / intval($video['totalduration']));
//            return $vbitrate - $this->_abitrate;
//
//        }
//    }
//
//    public function get_propiedades_video()
//    {
//        $shell = shell_exec('ffmpeg -i ' . $this->_directorio . ' 2>&1');
//        preg_match_all('/([a-z]+)([ \t]+)(:)(.*)([^a-zA-Z$])/', $shell, $match);
//        return Tools::arrayKeyMatchValue($match[0], ':');
//    }
//
//    /**Info Video*/
//    public function ver_nombre_video()
//    {
//        return $this->_nombre;
//    }
//
//    public function cambiar_nombre_video($antes, $nuevo)
//    {
//        $this->_nombre = str_replace(' ', '_', $nuevo . '.' . $this->obtener_formato());
//        $this->_nuevodirectorio = str_replace($antes, $this->_nombre, $this->_directorio);
//    }
//
//    public function clear_original()
//    {
//        unlink($this->_directorio);
//    }
//
//    /**Codec Conf*/
//    private function switch_codec()
//    {
//        switch ($this->_formato) {
//            case 'ogv':
//                $this->_codec = 'libtheora';
//                $this->_codec_audio = 'libvorbis';
//                break;
//            case 'webm':
//                $this->_codec = 'libvpx';
//                $this->_codec_audio = 'libvorbis';
//                break;
//            case 'mp4':
//                $this->_codec = 'libx264';
//                $this->_codec_audio = 'mp3';
//                break;
//            default:
//                throw new Exception('Los formato permitidos a convertir son ogg,webm,mp4');
//                break;
//
//        }
//    }
//
//    public function convertir_video()
//    {
//        $formato_actual = $this->obtener_formato();
//        if ($this->_formato == $formato_actual) {
//            return false;
//        }
//        $comando = 'ffmpeg -i ';
//        $comando .= $this->_directorio;
//        $comando .= ' -vcodec ' . $this->_codec;
//        $comando .= !isset($this->_calidad) ? ' -b:v ' . $this->get_video_bitrate() . 'k ' : ' -qscale:v ' . $this->_calidad;
//        $comando .= $this->_noaudio ? ' -an ' : ' -acodec ' . $this->_codec_audio;
//        $comando .= !isset($this->_calidad) ? ' -b:a ' . $this->_abitrate . 'k ' : ' -qscale:a ' . ceil($this->_calidad / 2);
//        $comando .= ' -r ' . $this->_fps;
//        $comando .= ' -s ' . $this->_tamano;
//        $comando .= ' -threads ' . $this->_rendimiento;
//        $comando .= ' ' . $this->_nuevodirectorio;
//        return shell_exec($comando);
//    }

}