<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 14/03/14
 * Time: 9:39
 * To change this template use File | Settings | File Templates.
 */
namespace multimedia\interfaces;

interface iFile
{

    public function setFile ( $_file, $_file_name );

    public function getName ();

    public function getDirectory ();

    public function getType ();

    public function getSize ();

}