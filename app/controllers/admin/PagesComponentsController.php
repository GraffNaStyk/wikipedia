<?php

namespace App\Controllers\Admin;

use App\Facades\Http\Request;
use App\Model\PageComponent;

class PagesComponentsController extends DashController
{
    protected array $components = [
        [
            'value' => 'table',
            'text' => 'Tabela'
        ],
        [
            'value' => 'text',
            'text' => 'Tekst'
        ]
    ];
    
    public function __construct()
    {
        parent::__construct();
    }

    public function add(int $id)
    {
        $this->render([
            'components' => $this->components,
            'id' => $id
        ]);
    }

    public function store(Request $request)
    {
        if (! $this->validate($request->all(), [
            'type' => 'required|string',
            'page_id' => 'required|int'
        ])) $this->sendError();
        
        PageComponent::insert($request->all());
        
        $this->sendSuccess('Dodano poprawnie');

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
