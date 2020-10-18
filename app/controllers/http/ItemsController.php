<?php

namespace App\Controllers\Http;

use App\Facades\Http\Request;

use App\Helpers\Items;

class ItemsController extends IndexController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index(string $type):void
    {
        $result = Items::prepare($type);
        
        if (! $result['items']) {
            $this->redirect('');
        }
        
        $this->render($result);
    }

    public function add()
    {

    }

    public function store(Request $request)
    {

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
