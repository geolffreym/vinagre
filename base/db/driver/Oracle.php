<?php

namespace core\db\mysql\model;

use core\App;
use core\interfaces\db\iDBController;

App::__require__ ( 'DBController', 'db/driver/oracle/model' );

class Oracle extends DBController implements iDBController
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
        $this->Connection  = $this->DBConnection;
        $this->Result      = $this->DBResult;
        $this->Error       = $this->DBError;
        $this->Server      = $this->DBServer;
        $this->Builder     = $this->DBBuilder;
        $this->Transaction = $this->DBTransaction;
    }
}
