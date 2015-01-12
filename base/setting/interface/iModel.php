<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-11-14
 * Time: 06:22 PM
 */

namespace core\interfaces;

interface iModel
{
    public function __construct ();

    public function __toString ();

    public function __invoke ( $_attr );

    public function getModelName ();

    public function getModelAttributes ();

    public function getFields ();

    public function prepareFields ( $fields );

    public function error ();

    public function getAlias ();

    public function validateField ( $field );
}

