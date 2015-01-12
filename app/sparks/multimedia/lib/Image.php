<?php

//TODO Recreating
class Image
{

    public function __construct ()
    {

    }
    /* public function set_directory($_directory)
     {
         parent::set_directory($_directory);
     }

     public function get_directory()
     {
         return $this->_directory;
     }

     public function get_file_properties()
     {
         return parent::get_file_properties();
     }

     public function get_image_size($_image_dir)
     {
         return getimagesize($_image_dir);
     }

     public function file_format($formato = NULL)
     {
         if (!isset($formato) || !is_array($formato)) {
             $formato = array("png", "gif", "jpg", "bmp", "jpeg");
         }
         return parent::file_format($formato);
     }

     public function crear_lienzo($ancho, $alto)
     {
         return imagecreate($ancho, $alto);
     }

     public function generar_imagen($max)
     {
         list($imagewidth, $imageheight, $imageType) = $this->obtener_propiedades();
         $image = $this->_directory;
         $tmax = $max;
         $scale = $tmax / $imagewidth;
         $imageType = $this->convertir_type_a_myme($imageType);
         if ($max <= 60) {
             if ($imagewidth > $imageheight) {
                 $newImageHeight = 60;
                 $newImageWidth = 60;
             } else {
                 $newImageWidth = ceil($imagewidth * $scale);
                 $newImageHeight = ceil($imageheight * $scale);
             }
         } else {
             $newImageWidth = ceil($imagewidth * $scale);
             $newImageHeight = ceil($imageheight * $scale);
         }
         $newImage = $this->crear_lienzo_color($newImageWidth, $newImageHeight);
         switch ($imageType) {
             case "image/gif":
                 $source = $this->crear_imagen_desde_gif($image);
                 break;
             case "image/pjpeg":
             case "image/jpeg":
             case "image/jpg":
                 $source = $this->crear_imagen_desde_jpg($image);
                 break;
             case "image/bmp":
                 $source = $this->crear_imagen_desde_bmp($image);
                 $negro = $this->asignar_color_rgb($newImage, 0, 0, 0);
                 $this->asignar_mezcla_de_color($newImage, false);
                 $this->guardar_canal_alfa($newImage, true);
                 $trans_layer_overlay = $this->crear_imagen_alpha($image, 220, 220, 220, 127);
                 $this->rellenar_lienzo($image, 0, 0, $trans_layer_overlay);
                 break;
             case "image/png":
                 $source = $this->crear_imagen_desde_png($image);
                 $negro = $this->asignar_color_rgb($newImage, 0, 0, 0);
                 $this->asignar_mezcla_de_color($newImage, false);
                 $this->guardar_canal_alfa($newImage, true);
                 $trans_layer_overlay = $this->crear_imagen_alpha($image, 220, 220, 220, 127);
                 $this->rellenar_lienzo($image, 0, 0, $trans_layer_overlay);
                 break;
         }
         imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $imagewidth, $imageheight);
         switch ($imageType) {
             case "image/gif":
                 imagegif($newImage, $image);
                 break;
             case "image/pjpeg":
             case "image/jpeg":
             case "image/jpg":
                 imagejpeg($newImage, $image, 90);
                 break;
             case "image/bmp":
                 imagewbmp($newImage, $image);
                 break;
             case "image/png":
             case "image/x-png":
                 imagepng($newImage, $image);
                 break;
         }

     }

     public function obtener_propiedades()
     {
         return getimagesize($this->_directory);
     }

     public function convertir_type_a_myme($tipo_de_imagen)
     {
         return image_type_to_mime_type($tipo_de_imagen);
     }

     public function crear_lienzo_color($ancho, $alto)
     {
         return imagecreatetruecolor($ancho, $alto);

     }

     public function crear_imagen_desde_gif($imagen_dir)
     {
         return imagecreatefromgif($imagen_dir);
     }

     public function crear_imagen_desde_jpg($imagen_dir)
     {

         return imagecreatefromjpeg($imagen_dir);
     }

     public function crear_imagen_desde_bmp($imagen_dir)
     {
         return imagecreatefromwbmp($imagen_dir);
     }

     public function asignar_color_rgb($lienzo, $rojo, $verde, $azul)
     {
         return imagecolorallocate($lienzo, $rojo, $verde, $azul);
     }

     public function asignar_mezcla_de_color($lienzo, $mezclar_boolean)
     {
         return imagealphablending($lienzo, $mezclar_boolean);

     }

     public function guardar_canal_alfa($lienzo, $mezclar_boolean)
     {
         return imagesavealpha($lienzo, $mezclar_boolean);
     }

     public function crear_imagen_alpha($lienzo, $rojo, $verde, $azul, $alpha)
     {
         return imagecolorallocatealpha($lienzo, $rojo, $verde, $azul, $alpha);
     }

     public function rellenar_lienzo($lienzo, $x, $y, $color)
     {
         return imagefill($lienzo, $x, $y, $color);
     }

     public function crear_imagen_desde_png($imagen_dir)
     {
         return imagecreatefrompng($imagen_dir);
     }*/

}