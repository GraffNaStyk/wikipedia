<?php

namespace App\Helpers;

use App\Facades\Url\Url;
use App\Model\Page;

class System
{
    public static function factory(): array
    {
        $systems = Page::select(['id', 'title'])
            ->where(['type', '=', 'system'])
            ->where(['is_active', '=', 1])
            ->get();
    
        foreach ($systems as $key => $system) {
            $systems[$key]['link'] = 'pages/show/'.$system['id'].'/'.Url::link($system['title']);
        }
    
        return (array) $systems;
    }
}
