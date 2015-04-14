<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-07-14
 * Time: 03:18 PM
 */

namespace core\interfaces;
interface iController
{
    public function __construct ();

    public function __init ();

    public static function asView ();

}