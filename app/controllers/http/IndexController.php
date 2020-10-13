<?php namespace App\Controllers\Http;

use App\Core\Controller;
use App\Db\Db;
use App\Model\Config;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->render();
    }
}
