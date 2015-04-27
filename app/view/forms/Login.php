<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 08-10-14
 * Time: 10:40 AM
 */
use core\helper\FormHelper;
use core\Language;

$_form = [
    'form' => [
        'input'    => [
            [
                'name'        => 'name',
                'id'          => 'name',
                'type'        => 'text',
                'placeholder' => Language::parseLang ( 'form_full_name' ),
                'label'       => [
                    'for' => 'name'
                ]
            ],
            [ 'name' => 'mail', 'type' => 'text', 'placeholder' => Language::parseLang ( 'form_mail' ) ],
            [ 'name' => 'password', 'type' => 'password', 'placeholder' => Language::parseLang ( 'form_pass' ) ]
        ],
        'textarea' => [
            [ 'name' => 'culito', 'content' => "Aqui tu info" ],
            [ 'name' => 'culito', 'content' => "Aqui tu info" ]
        ],
        'select'   => [
            [ 'name'    => 'Juan',
              'options' => [
                  [ 'name' => 'my', 'content' => 'happy' ]
              ]
            ]
        ]
    ]
];

FormHelper::source ( 'Login', $_form );
