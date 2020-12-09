<?php

namespace App\Controllers\Admin;

use App\Facades\Http\Request;
use App\Facades\Url\Url;
use App\Model\Page;
use App\Model\PageComponent;

class PagesController extends DashController
{
    protected array $types = [
        [
            'value' => 'quest',
            'text' => 'Quest'
        ],
        [
            'value' => 'map',
            'text' => 'Mapa'
        ],
        [
            'value' => 'tutorial',
            'text' => 'Tutorial'
        ],
        [
            'value' => 'saga',
            'text' => 'Saga'
        ],
        [
            'value' => 'system',
            'text' => 'Systems'
        ],
    ];
    
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        if (! empty($request->all())) {
            $pages = Page::select('*');

            if ($request->has('title')) {
                $pages->where(['title', 'like', '%'.$request->get('title').'%']);
            }
            
            if ($request->has('type')) {
                $pages->where(['type', '=', $request->get('type')]);
            }
            
            $pages = $pages->get();
        } else {
            $pages = Page::all();
        }
        
        return $this->render([
            'pages' => $pages,
            'types' => $this->types,
            'search' => $request->all(),
        ]);
    }
    
    public function add()
    {
        return $this->render(['types' => $this->types]);
    }
    
    public function store(Request $request)
    {
        if (!$this->validate($request->all(), [
            'title' => 'required|min:4',
            'type' => 'required'
        ])) $this->sendError();
        
        Page::insert([
            'title' => $request->get('title'),
            'created_by' => $this->user['id'],
            'type' => $request->get('type'),
            'is_active' => 0
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
    
        $page['link'] = Url::link($page['title']);

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
    
    public function active(int $active, int $id)
    {
        if ($active === 1) {
            $active = 0;
        } else {
            $active = 1;
        }
        
        Page::where(['id', '=', $id])->update(['is_active' => $active]);
        $this->redirect('pages');
    }
}
