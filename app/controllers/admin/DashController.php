<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Auth;
use App\Facades\Http\Request;
use App\Facades\Http\View;
use App\Helpers\Storage;
use App\Model\User;

class DashController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        View::layout('admin');
        Auth::guard();
    }

    public function index()
    {
        return View::render(['users' => User::all()]);
    }
}
