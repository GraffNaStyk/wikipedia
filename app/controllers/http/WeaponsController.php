<?php

namespace App\Controllers\Http;

use App\Facades\Http\Request;

class WeaponsController extends IndexController
{
    private array $map = [
        'swords' => 'Sword',
        'balls' => 'Ball',
        'glovers' => 'Glover',
        'bands' => 'Band',
        'belts' => 'Belt'
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
                ->where(['attack', '<>', '0'])
                ->order('attack')
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
