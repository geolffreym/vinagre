<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-11-14
 * Time: 11:00 AM
 */

use core\Loader;

//Basic Don't Change
Loader::libraries ( 'Template', 'Json' );
Loader::helpers ( 'Array' );
Loader::traits ( 'DataStructure', 'String' );

//Loader::spark ( 'Multimedia' ); //Loose Coupling