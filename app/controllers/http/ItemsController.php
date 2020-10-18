<?php

namespace App\Controllers\Http;

use App\Facades\Http\Request;

class ItemsController extends IndexController
{
    private array $map = [
        'helmets' => 'Helmet',
        'armors' => 'Armor',
        'legs' => 'Leg',
        'boots' => 'Boots',
        'belts' => 'Belt',
        'robes' => 'Robe'
    ];
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index(string $type)
    {
        if (! isset($this->map[$type])) {
            $this->redirect('');
        }
        
        $model = app('model-provider').$this->map[$type];
        
        $this->render([
            'items' => $model::select('*')
                ->where(['armor', '<>', '0'])
                ->order('armor')
                ->get(),
            'title' => ucfirst($type)
        ]);
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
