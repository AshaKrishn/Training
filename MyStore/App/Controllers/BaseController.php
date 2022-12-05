<?php

namespace StoreApp\Controllers;

use StoreApp\Helpers\Helper;
use StoreApp\Helpers\DbHelper;

class BaseController
{
    public $helper;
    public $dbHelper;
    public function __construct()
    {
        $this->helper = new Helper();
        $this->dbHelper = new DbHelper();  
    }
}