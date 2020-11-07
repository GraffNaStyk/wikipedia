<?php

namespace App\Controllers\Http;

use App\Model\Page;
use App\Model\PageComponent;

class PagesController extends IndexController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }
    
    public function show(int $id)
    {
        $page = Page::where(['id', '=', $id])
            ->where(['is_active', '=', 1])
            ->where(['type', '<>', 'null'])
            ->findOrFail();
        
        if ($page) {
            $components = PageComponent::select(['type', 'data'])
                ->where(['page_id', '=', $id])
                ->where(['is_active', '=', 1])
                ->order(['order'])
                ->get();
    
            foreach ($components as $key => $component){
                $components[$key]['data'] = json_decode($component['data'], true);
                $components[$key]['iterations'] = count($components[$key]['data']['cols']);
            }
//            pd($components, true);
            return $this->render([
                'page' => $page,
                'components' => $components,
                'title' => $page['title']
            ]);
        } else {
            $this->redirect('');
        }
    }
}
