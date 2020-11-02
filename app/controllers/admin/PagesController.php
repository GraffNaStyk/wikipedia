<?php

namespace App\Controllers\Admin;

use App\Controllers\ControllerInterface;
use App\Facades\Http\Request;
use App\Helpers\Session;
use App\Model\Page;
use App\Model\PageComponent;

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
        if(!$this->validate($request->all(), [
            'title' => 'required|min:10'
        ])) $this->sendError();
        
        Page::insert([
            'title' => $request->get('title'),
            'created_by' => $this->user['id']
        ]);
        
        $this->sendSuccess('Strona dodana', 'pages/edit/'.Page::lastId());
    }
    
    public function update(Request $request)
    {
    
    }
    
    public function show(int $id)
    {
    
    }
    
    public function edit(int $id)
    {
        $page = Page::where(['id', '=', $id])
            ->findOrFail();

        if (!$page) {
            $this->redirect('pages');
        }

        $components = PageComponent::where(['page_id', '=', $id])
            ->order(['order'])
            ->get();
        
        foreach ($components as $key => $component) {
            $components[$key]['data'] = (array) json_decode($component['data'], true);
        }

        $this->render([
            'page' => $page,
            'components' => $components
        ]);
    }
    
    public function delete(int $id)
    {
    
    }
}
