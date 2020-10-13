<?php namespace App\Controllers\Http;

use App\Core\Controller;
use App\Facades\Http\Request;
use App\Facades\Url\Url;
use App\Helpers\Session;
use App\Model\User;

class LogoutController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        Session::destroy();
        $this->redirect('');
    }
    
}
