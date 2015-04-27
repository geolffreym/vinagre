<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 21/04/14
 * Time: 10:51
 * To change this template use File | Settings | File Templates.
 */
namespace core\helper;
class DateHelper
{

    //Return Days Array
    public static function getDayArray ()
    {
        return [ '', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun' ];
    }

    //Return Month Array
    public static function getMonthsArray ()
    {
        return [ '', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ];
    }

    /**Convierte fecha en unix date
     * @param $_date string
     * @return string
     */
    public static function unixTime ( $_date )
    {
        return strtotime ( $_date );
    }

    /**Devuelve la fecha en un object en formato de texto
     * @param $_date string
     * @return object
     */
    public static function dateFormat ( $_date = 'now' )
    {
        $_today   = new \DateTime();
        $_past    = new \DateTime( $_date );
        $_newTime = new \stdClass();

        $_monthsArray = self::getMonthsArray ();
        $_pastTime    = $_past->diff ( $_today );
        $_unixTime    = self::unixTime ( $_date );

        $_dayString   = date ( 'D', $_unixTime );
        $_monthString = $_monthsArray[ date ( 'n', $_unixTime ) ];
        $_yearInt     = date ( 'Y', $_unixTime );
        $_hourInt     = date ( 'h', $_unixTime );
        $_minutesInt  = date ( 'i', $_unixTime );
        $_secondsInt  = date ( 's', $_unixTime );
        $_meridian    = date ( 'a', $_unixTime );


        $_newTime->past->day     = $_pastTime->d;
        $_newTime->past->days    = $_pastTime->days;
        $_newTime->past->month   = $_pastTime->m;
        $_newTime->past->year    = $_pastTime->y;
        $_newTime->past->hour    = $_pastTime->h;
        $_newTime->past->minute  = $_pastTime->m;
        $_newTime->past->seconds = $_pastTime->s;

        $_newTime->date->day      = $_dayString;
        $_newTime->date->month    = $_monthString;
        $_newTime->date->year     = $_yearInt;
        $_newTime->date->hour     = $_hourInt;
        $_newTime->date->minute   = $_minutesInt;
        $_newTime->date->seconds  = $_secondsInt;
        $_newTime->date->meridian = $_meridian;

        $_newTime->date->complete = $_date;
        $_newTime->date->unix     = $_unixTime;

        return $_newTime;
    }

#TODO Fix time zone
//    /**Fix local Time to default time zone
//     * @param $_dates
//     * @param $_index
//     * @param $time_zone
//     * @throws String
//     * @return Array
//     * */
//    public static function fixTime ( $_dates, $_index = NULL, $time_zone = 'America/Mexico_City' )
//    {
//        $_diference     = 0x5460;
//        $_fix_strtotime = 0x6270;
//
//        if ( !is_array ( $_dates ) || !isset( $_index ) ) {
//            throw new \Exception(
//                'Array Needed and Index'
//            );
//        }
//
//        date_default_timezone_set ( $time_zone );
//        foreach ( $_dates as $k => $_date ) {
//
//            if ( !empty( $_date[ $_index ] ) ) {
//                $_date     = $_date[ $_index ];
//                $_fix_date = &$_dates[ $k ][ 'fix_date' ];
//            } elseif ( $k === $_index ) {
//                $_fix_date = &$_dates[ 'fix_date' ];
//            } else {
//                continue;
//            }
//
//            $_date_time = new \DateTime( $_date );
//            $_date      = $_date_time->format ( 'd-m-Y h:i:s' );
//
//            $_fix_date = [
//                'unix_date' => ( strtotime ( $_date ) + $_fix_strtotime ),
//                'time'      => $_time = time () - $_diference,
//                'format'    => $_date
//            ];
//        }
//
//        return $_dates;
//    }
}