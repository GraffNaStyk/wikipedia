<?php

namespace App\Controllers\Admin;

use App\Facades\Http\Request;
use App\Helpers\Table;
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
        ],
        [
            'value' => 'separator',
            'text' => 'Separator'
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
        if (! $this->validate($request->all(), [
            'id' => 'required|int',
            'rows' => 'int|max:999',
            'cols' => 'int|max:99',
        ])) $this->sendError();
        
        if ($request->has('rows') && $request->has('cols')) {
            $request->set('data', json_encode(
                Table::prepareRowsAndCols(
                    $request->get('rows'),
                    $request->get('cols'),
                    (array) json_decode(PageComponent::select(['data'])->where(['id', '=', $request->get('id')])->findOrFail()['data'])
                )
            ));
        }
        
        PageComponent::update($request->all());
    
        $this->sendSuccess('Zaktualizowano poprawnie');
    }

    public function show(int $id)
    {

    }

    public function edit(int $id)
    {
        if ($component = PageComponent::where(['id', '=', $id])->findOrFail()) {
            $this->render(['component' => $component]);
        }
    }

    public function delete(int $id)
    {

    }
    
    public function setTableRows(int $id)
    {
        return $this->render(['id' => $id]);
    }
}
