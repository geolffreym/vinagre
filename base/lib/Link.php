<?php

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-30-14
 * Time: 06:32 PM
 */
namespace core\lib;
class Link
{

    private $_url = NULL;
    private $_cache = NULL;
    private $_return = NULL;
    private $_domain_position = NULL;
    private $_og = NULL;
    private $_flag = NULL;
    private $_valid_formats = [
        'png',
        'gif',
        'jpg',
        'jpeg',
        'bmp'
    ];
    private $_valid_domains = [
        '.net',
        '.com',
        '.org',
        '.info',
        '.es',
        '.nom',
        '.cat',
        '.biz',
        '.tv',
        '.tel',
        '.mobi',
        '.ws',
        '.be',
        '.co',
        '.uk',
        '.cu',
        '.cl',
        '.ni'
    ];

    /**Metodo constructor
     * @param $_url string
     * @param $www  bool
     * */
    public function __construct ( $_url, $www = FALSE )
    {
        $this->_url = $_url;
        if ( strstr ( $this->_url, 'www' ) and !strstr ( $this->_url, 'http' ) ) {
            $this->_url = "http://" . $this->_url;
        } else {
            if ( !strstr ( $this->_url, 'www' ) and strstr ( $this->_url, 'http' ) ) {
                $this->_url = explode ( '/', $this->_url );
                if ( $www ) {
                    $put         = 'www.';
                    $this->_flag = FALSE;
                } else {
                    $put         = '';
                    $this->_flag = TRUE;
                }
                $this->_url = $this->_url[ 0 ] . '//' . $put . $this->_url[ 2 ];
            }
        }

    }

    //Validar URL
    public function validateUrl ()
    {
        return filter_var ( $this->_url, FILTER_VALIDATE_URL );
    }

    //Obtener datos remotos
    public function getContent ()
    {
        $ac = curl_init ();
        curl_setopt ( $ac, CURLOPT_URL, $this->_url );
        curl_setopt ( $ac, CURLOPT_FOLLOWLOCATION, TRUE );
        curl_setopt ( $ac, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ac, CURLOPT_USERAGENT, "Mozilla/5.0" );
        curl_setopt ( $ac, CURLOPT_AUTOREFERER, TRUE );
        $this->_cache = curl_exec ( $ac );
        curl_close ( $ac );

        return $this->_cache;
    }

    /**Validar Dominio
     * @param $_domain string
     * @return bool
     */
    public function validateDomain ( $_domain )
    {
        foreach ( $this->_valid_domains as $v ) {
            $this->_domain_position = strpos ( $this->_url, $v );
            if ( strstr ( $_domain, $v ) ) {
                return TRUE;
            }
        }

        return FALSE;
    }

    //Obtiene la pocision del dominio en la URL
    public function getDomainPosition ()
    {
        return $this->_domain_position;
    }

    /**Establece el tipo de busqueda
     * @ogg  el tipo Open Graph
     * @meta el tipo Meta etiquetas
     */
    private function setType ()
    {
        if ( !isset( $this->_cache ) ) {
            return FALSE;
        }
        if ( strstr ( $this->_cache, '<meta property' ) != FALSE ) {
            $this->_og = TRUE;
        } else {
            $this->_og = FALSE;
        }

    }

    //IMAGENES
    /**Establece la posicion del formato para la busqueda de imagenes
     * @param $element string
     * @return string
     * */
    public function formatPosition ( $element )
    {
        foreach ( $this->_valid_formats as $f ) {
            if ( strpos ( $element, $f ) ) {
                $length  = strlen ( $f );
                $element = strpos ( $element, $f ) + $length;
                break;
            }

        }

        return $element;
    }

    /**Elimina / dobles de la URL
     * @in string
     */
    private function clearSlash ( $in )
    {
        return preg_replace ( '%([^:])([/]{2,})%', '\\1/', $in );
    }

    /**Busqueda de imagen para los que estan fuera del rango Og
     * Og tiene imagen por default
     */
    private function getImg ()
    {

        preg_match_all ( '/img src\=(.*)/', $this->_cache, $matches );
        $_replace = [ '>', '=', '"', 'src', '<', ' img ', 'img ' ];
        $_with    = [ '', '', '', '', '', '', '', '', '', '', '' ];
        $_return  = NULL;

        foreach ( $matches as $n ) {
            foreach ( $n as $r ) {
                if ( $r != '' ) {
                    $r = str_replace ( $_replace, $_with, $r );
                    $r = substr ( $r, 0, $this->formatPosition ( $r ) );

                    if ( !$this->validateDomain ( $r ) and !strstr ( $r, 'http:' ) ) {
                        $z = [ '..', ' ' ];
                        $w = [ '', '' ];
                        $r = str_replace ( $z, $w, $this->_url . '' . $r );
                    } else {
                        if ( $this->validateDomain ( $r ) and !strstr ( $r, 'http:' ) ) {
                            if ( !strstr ( $r, 'https:' ) ) {
                                $r = 'http://' . $r;
                            }
                        }
                    }
                    $img = getimagesize ( trim ( $r ) );
                    $q   = explode ( '"', $img[ 3 ] );
                    if ( $q[ 1 ] > 40 && $q[ 3 ] > 40 ) {
                        $_return[ ] = trim ( $r );
                    }
                    if ( sizeof ( $_return ) > 2 ) {
                        break;
                    }
                }
            }
        }
        $_rand         = rand ( 0, sizeof ( $_return ) );
        $this->_return = $this->clearSlash ( $_return[ $_rand ] );

    }

    //CONTENIDO
    //Obtiene la informacion de las paginas mediante busqueda de patrones
    private function _noOg ()
    {
        if ( $this->validateUrl () ) {
            preg_match_all ( '/(meta name="description" content\=(.*)|\<(.*)\<\/title\>)/', $this->_cache, $matches );

            $_return   = NULL;
            $_replace  = [ '>', '/', 'meta', 'content', '=', '"', 'name', '<' ];
            $_with     = [ '', '', '', '', '', '', '', '', '', '', '' ];
            $_check_in = [ 'title', 'description' ];

            foreach ( $matches as $n ) {
                foreach ( $n as $r ) {
                    if ( $r != '' ) {
                        foreach ( $_check_in as $c ) {
                            if ( strpos ( $r, $c ) ) {

                                $r             = str_replace ( $_replace, $_with, $r );
                                $_return[ $c ] = str_replace ( $_check_in, $_with, $r );

                            }
                        }
                    }
                }
            }
            $this->validateDomain ( $this->_url );
            $url_enlace = $this->_url;

            if ( strlen ( $this->_url ) > ( $this->_domain_position + 4 ) and $this->_domain_position != FALSE ) {
                $this->_url = substr ( $this->_url, 0, $this->_domain_position + 4 );
            }

            $_cut               = isset( $_return[ 'title' ][ 50 ] )
                ? 170 : 110;
            $_return[ 'title' ] = isset( $_return[ 'title' ][ 100 ] )
                ? substr ( $_return[ 'title' ], 0, 80 ) : $_return[ 'title' ];

            $_return[ 'enlace' ]      = $url_enlace;
            $_return[ 'url' ]         = $this->_url;
            $_return[ 'og' ]          = FALSE;
            $_return[ 'description' ] = ucfirst ( strtolower ( substr ( $_return[ 'description' ], 0, $_cut ) ) );
            $this->_return            = $_return;
        } else {
            $this->_return = NULL;
        }
    }

    //Obtiene la informacion de las paginas mediante Open Graph
    private function _og ()
    {
        if ( $this->validateUrl () ) {
            $i       = $index = 0;
            $_return = [ ];
            $match   = [
                'property="og:description"',
                '>',
                'property="og:title"',
                '>',
                'property="og:image"',
                '>'
            ];

            while ( $i <= 6 ) {
                if ( strstr ( $this->_cache, $match[ $i ] ) ) {
                    $_begin  = strstr ( $this->_cache, $match[ $i ] );
                    $_middle = strpos ( $_begin, $match[ $i ] );
                    $_end    = strpos ( $_begin, $match[ $i + 1 ] );
                    $_data   = substr ( $_begin, $_middle, $_end );

                    if ( $i < 1 ) {
                        $index = 'description';
                    } else {
                        if ( $i == 2 ) {
                            $index = 'title';
                        } else {
                            if ( $i == 4 ) {
                                $index = 'imagen';
                            }
                        }
                    }

                    $_data             = explode ( '"', $_data );
                    $temp              = $_data[ 3 ];
                    $_return[ $index ] = $temp;

                }
                $i = $i + 2;
            }
            $this->validateDomain ( $this->_url );
            $url_link = $this->_url;

            if ( strlen ( $this->_url ) > ( $this->_domain_position + 4 ) and $this->_domain_position != FALSE ) {
                $this->_url = substr ( $this->_url, 0, $this->_domain_position + 4 );
            }

            $_cut               = isset( $_return[ 'title' ][ 50 ] )
                ? 170 : 110;
            $_return[ 'title' ] = isset( $_return[ 'title' ][ 100 ] )
                ? substr ( $_return[ 'title' ], 0, 80 ) : $_return[ 'title' ];

            $_return[ 'url' ]         = $this->_url;
            $_return[ 'enlace' ]      = $url_link;
            $_return[ 'og' ]          = TRUE;
            $_return[ 'description' ] = ucfirst ( strtolower ( substr ( $_return[ 'description' ], 0, $_cut ) ) );
            $this->_return            = $_return;
        } else {
            $this->_return = NULL;
        }
    }

    //Output
    public function getUrl ()
    {
        $this->getContent ();
        if ( $this->setType () ) {
            if ( $this->_og ) {
                $this->_og ();
            } else {
                $this->_noOg ();
            }
            if ( $this->_return[ 'title' ] == '' && $this->_flag ) {
                $new           = new self( $this->_url, TRUE );
                $this->_return = $new->getUrl ();
            }
        };


        return $this->_return;
    }

    //Getting images
    public function getImage ()
    {
        $this->getContent ();
        if ( $this->setType () ) {
            $this->getImg ();
        }

        return $this->_return;
    }


}