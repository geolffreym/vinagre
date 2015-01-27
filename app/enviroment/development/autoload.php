<?php
/**
 * Created by PhpStorm.
 * User: gmena
 * Date: 07-11-14
 * Time: 11:00 AM
 */

use core\Loader;

//Basic Don't Change
Loader::libraries ( 'Session', 'Template', 'Json' );
Loader::security ( 'CSRFToken' ); // Require
Loader::helpers ( 'Array' );
Loader::traits ( 'DataStructure', 'String' );
//Loader::spark ( 'Multimedia' ); //Loose Coupling
Loader::db ( 'Q' );