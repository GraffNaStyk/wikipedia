<?php

namespace App\Controllers\Http;

use App\Core\Controller;
use App\Facades\Parser\Monsters;
use App\Facades\Url\Url;
use App\Model\Npc;
use App\Model\Page;
use App\Model\Vocation;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->set([
            'menu' => $this->createLinks(),
            'title' => 'Dashboard - last added',
            'vocations' => Vocation::order(['name'], 'asc')->all(),
            'last_added' => $this->createLastAdded(),
            'last_updated' => $this->createLastUpdated(),
            'npc' => Npc::count()['total']
        ]);
    }

    public function index()
    {
        return $this->render();
    }
    
    public function createLinks()
    {
        $return = [];
        $pages = Page::select(['id', 'title', 'type'])
            ->where(['is_active', '=', 1])
            ->get();
        
        foreach ($pages as $page) {
            $return[$page['type']][] = [
              'link' => 'pages/show/'.$page['id'].'/'.Url::link($page['title']),
              'title' => ucfirst($page['title'])
            ];
        }
        
        return $return;
    }
    
    public function createLastAdded()
    {
        $return = [];
        $pages = Page::select(['id', 'title', 'type', 'created_at'])
            ->where(['is_active', '=', 1])
            ->order(['created_at'], 'desc')
            ->limit(3)
            ->get();
    
        foreach ($pages as $page) {
            $return[] = [
                'link' => 'pages/show/'.$page['id'].'/'.Url::link($page['title']),
                'title' => ucfirst($page['title']),
                'date' => $page['created_at']
            ];
        }
        
        return $return;
    }
    
    public function createLastUpdated()
    {
        $return = [];
        $pages = Page::select(['id', 'title', 'type', 'updated_at'])
            ->where(['is_active', '=', 1])
            ->order(['updated_at'], 'desc')
            ->limit(3)
            ->get();
        
        foreach ($pages as $page) {
            $return[] = [
                'link' => 'pages/show/'.$page['id'].'/'.Url::link($page['title']),
                'title' => ucfirst($page['title']),
                'date' => $page['updated_at']
            ];
        }
        
        return $return;
    }
}
