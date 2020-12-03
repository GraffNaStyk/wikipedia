<?php

namespace App\Controllers\Admin;

use App\Facades\Http\Request;
use App\Model\Page;
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
        Page::where(['id', '=', $request->get('id')])->update(['updated_at' => date('Y-m-d H:i:s')]);
        
        $this->sendSuccess('Dodano poprawnie');

    }

    public function update(Request $request)
    {
        if (! $this->validate($request->all(), [
            'id' => 'required|int',
        ])) $this->sendError();
        
        $request->set('data', json_encode($request->get('data'), JSON_UNESCAPED_UNICODE));

        PageComponent::update($request->all());
    
        $this->sendSuccess('Zaktualizowano poprawnie');
    }

    public function show(int $id)
    {

    }

    public function edit(int $id)
    {
        if ($component = PageComponent::where(['id', '=', $id])->findOrFail()) {
            $component['data'] = (array) json_decode($component['data'], true);
            $component['iterations'] = count($component['data']['cols']);

            if ($component['type'] === 'image') {
                $component['width'] = '570px';
            }
            $this->render($component);
        }
    }

    public function delete(int $id)
    {

    }
    
    public function active(int $active, int $id, int $pageId)
    {
        if ($active === 1) {
            $active = 0;
        } else {
            $active = 1;
        }
        
        PageComponent::where(['id', '=', $id])->update(['is_active' => $active]);
        Page::where(['id', '=', $pageId])->update(['updated_at' => date('Y-m-d H:i:s')]);
        $this->redirect('pages/edit/'.$pageId);
    }
}
