<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 10/03/14
 * Time: 10:30
 * To change this template use Upload | Settings | Upload Templates.
 */
namespace core\interfaces;

interface iFactory
{

    public function create ( $fields );

    public function update ( $fields, $_is_procedure );

    public function get_fields ();

    public function get_error ();
}