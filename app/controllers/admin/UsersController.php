<?php namespace App\Controllers\Admin;

use App\Controllers\ControllerInterface;
use App\Facades\Faker\Hash;
use App\Facades\Http\Request;
use App\Model\User;

class UsersController extends DashController implements ControllerInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    public function add()
    {
        return $this->render();
    }

    public function store(Request $request)
    {
        if (! $this->validate($request->all(), [
            'name' => 'string|min:4|max:10|required|unique:'.User::class,
            'email' => 'email|required|unique:'.User::class,
            'password' => 'string|required|min:6|max:12',
        ])) {
            $this->sendError();
        }
        
        $request->set('password', Hash::crypt($request->get('password')));
        
        User::insert($request->all());
        $this->sendSuccess('Użytkownik dodany');
    }

    public function update(Request $request)
    {

    }

    public function show(int $id)
    {

    }

    public function edit(int $id)
    {

    }

    public function delete(int $id)
    {

    }
}
