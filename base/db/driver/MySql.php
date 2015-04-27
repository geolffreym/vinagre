<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Geolffrey
 * Date: 3/03/14
 * Time: 10:04
 * To change this template use Upload | Settings | Upload Templates.
 */

namespace core\db\mysql\model;

use core\App;
use core\interfaces\db\iDBController;

App::__require__ ( 'DBController', 'db/driver/mysql/model' );

class MySql extends DBController implements iDBController
{
    public $Connection = NULL;
    public $Result = NULL;
    public $Error = NULL;
    public $Transaction = NULL;
    public $Server = NULL;
    public $Builder = NULL;

    public function __construct ()
    {
        parent::__construct ();
        $this->Connection  = parent::getDbConnection ();
        $this->Result      = parent::getDbResult ();
        $this->Error       = parent::getDbError ();
        $this->Server      = parent::getDbServer ();
        $this->Builder     = parent::getDbBuilder ();
        $this->Transaction = parent::getDbTransaction ();
    }

}


