<?php

namespace App\Controllers\Admin;

use App\Controllers\ControllerInterface;
use App\Facades\Http\Request;
use App\Helpers\Session;
use App\Model\Article;

class PagesController extends DashController implements ControllerInterface
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
        $this->render();
    }
    
    public function store(Request $request)
    {
        pd($request->all());
        Article::insert([
            'title' => 'Test tabela',
            'content' => json_encode($request->all()),
            'type' => 'table',
            'created_by' => Session::get('user.id')
        ]);
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
    
    public function table(int $nr)
    {
        return $this->render(['nr' => $nr]);
    }
    
    public function text(int $nr)
    {
        return $this->render(['nr' => $nr]);
    }
}
