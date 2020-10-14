<?php
namespace App\Controllers\Http;

use App\Core\Controller;
use App\Facades\Faker\Hash;
use App\Facades\Http\Request;
use App\Helpers\Session;
use App\Model\User;

class LoginController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        return $this->render();
    }

    public function make(Request $request)
    {
        if (! $this->validate($request->all(), $this->rules())) {
            $this->sendError();
        }
        
        if ($user = User::where(['name', '=', $request->get('name')])
            ->join(['rights', 'id', '=', 'rights.user_id'])
            ->findOrFail()
        ) {
            if (Hash::verify($request->get('password'), $user['password'])) {
                Session::set(['user' => $user]);
                $this->sendSuccess('Zalogowano poprawnie');
            }

            $this->sendError('Niepoprawne dane');
        }
    }
    
    private function rules(): array
    {
        return [
            'password' => 'required|min:4',
            'username' => 'required'
        ];
    }
}
