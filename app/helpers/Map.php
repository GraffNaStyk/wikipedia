<?php

namespace App\Helpers;

use App\Facades\Url\Url;
use App\Model\Page;

class Map
{
    public static function factory(): array
    {
        $maps = Page::select(['id', 'title'])
            ->where(['type', '=', 'map'])
            ->where(['is_active', '=', 1])
            ->get();
    
        foreach ($maps as $key => $map) {
            $maps[$key]['link'] = 'pages/show/'.$map['id'].'/'.Url::link($map['title']);
        }
    
        return (array) $maps;
    }
}
