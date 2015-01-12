<?php
namespace core\lib;
use core\Exception;

/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-30-14
 * Time: 07:01 PM
 * Required: geoip li -> apt-get install php5-geoip (Linux)
 */
class GeoIp
{
    private static $_ip = NULL;

    public function __construct ()
    {
        self::$_ip = self::getIp ();

    }

    public static function validateIp ( $ip )
    {
        return filter_var ( $ip, FILTER_VALIDATE_IP );
    }

    public static function setIp ( $ip = NULL )
    {
        if ( ! self::validateIp ( $ip ) ) {
            Exception::invalidIp ();
        }
        self::$_ip = $ip;
    }

    public static function getIp ()
    {
        return ! empty( $_SERVER[ "HTTP_CLIENT_IP" ] )
            ? $_SERVER[ "HTTP_CLIENT_IP" ] : $_SERVER[ "REMOTE_ADDR" ];
    }

    public static function getCompleteRecord ()
    {
        return geoip_record_by_name ( self::$_ip );
    }


    public static function getRegionCode ()
    {
        return geoip_region_by_name ( self::$_ip );
    }

    /**Devuelve, a partir de una combinación de código de país y de región, el nombre de región
     * @pais_code   String
     * @region_code String
     */
    public static function getRegionName ( $country_code = NULL, $region_code )
    {
        if ( ! isset( $country_code ) and ! isset( $region_code ) ) {
            throw new \Exception(
                "Code region needed"
            );
        }

        return geoip_region_name_by_code ( $country_code, $region_code );
    }

    /**Devuelve, a partir de una combinación de código de país y de región, el nombre de región
     * @pais_code   String
     * @region_code String
     */
    public static function get_time_zone ( $country_code = NULL, $region_code )
    {
        if ( ! isset( $country_code ) and ! isset( $region_code ) ) {
            throw new \Exception(
                "Code region needed"
            );
        }

        return geoip_time_zone_by_country_and_region ( $country_code, $region_code );
    }

    /**Obtiene la abreviación de dos letras del continente
     * @ip String
     */
    public static function getAbrvContinent ()
    {
        if ( ! self::validateIp ( self::$_ip ) ) {
            Exception::invalidIp ();
        }

        return geoip_continent_code_by_name ( self::$_ip );
    }

    /**Obtiene la abreviación de dos letras del país
     * @ip String
     */
    public static function getAbrvCountry ()
    {
        if ( self::validateIp ( self::$_ip ) ) {
            Exception::invalidIp ();
        }

        return geoip_country_code_by_name ( self::$_ip );
    }

    /**Obtiene la abreviación de tres letras del país
     * @ip String
     */
    public static function getAbrv3Country ()
    {
        if ( self::validateIp ( self::$_ip ) ) {
            $ip = self::$_ip;
        } else {
            Exception::invalidIp ();
        }

        return geoip_country_code3_by_name ( self::$_ip );
    }

    /**Obtiene el nombre del país completo
     * @ip String
     */
    public static function getCountryName ()
    {
        if ( self::validateIp ( self::$_ip ) ) {
            Exception::invalidIp ();
        }

        return geoip_country_name_by_name ( self::$_ip );
    }

    /**Obtiene el nombre del proveedor de servicios de Internet (ISP)
     * @ip String
     */
    public static function getIsp ()
    {
        if ( self::validateIp ( self::$_ip ) ) {
            Exception::invalidIp ();
        }

        return geoip_isp_by_name ( self::$_ip );
    }

    /**Obtiene el nombre del proveedor de servicios de Internet (ISP)
     * @ip String
     * GEOIP_UNKNOWN_SPEED -> Desconocido
     * GEOIP_DIALUP_SPEED -> Modem
     * GEOIP_CABLEDSL_SPEED -> Cable Adsl
     * GEOIP_CORPORATE_SPEED -> Corporativo
     */
    public static function getKindConnection ()
    {
        if ( self::validateIp ( self::$_ip ) ) {
            Exception::invalidIp ();
        }

        return geoip_isp_by_name ( self::$_ip );
    }

}
