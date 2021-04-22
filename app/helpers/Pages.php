<?php

namespace App\Helpers;

use App\Facades\Url\Url;
use App\Model\Page;

class Pages
{
    public static function createLastAdded(): array
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
    
    public static function createLastUpdated(): array
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
