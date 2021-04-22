<?php

namespace App\Controllers\Http;

use App\Facades\Http\Request;
use App\Facades\Url\Url;
use App\Model\Item;
use App\Model\Monster;
use App\Model\Npc;

class SearchController extends IndexController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $items = Item::select(['items.name', 'images.path', 'images.ext', 'images.hash'])
            ->leftJoin(['images', 'items.cid', '=', 'images.cid'])
            ->where(['items.name', 'like', '%'.$request->get('search').'%'])
            ->get();
        
        foreach ($items as $key => $item) {
            $items[$key]['type'] = 'item';
        }
        
        $monsters = Monster::select(['monsters.name', 'images.path', 'images.ext', 'images.hash'])
            ->leftJoin(['images', 'monsters.cid', '=', 'images.cid'])
            ->where(['monsters.name', 'like', '%'.$request->get('search').'%'])
            ->get();
    
        foreach ($monsters as $key => $item) {
            $monsters[$key]['type'] = 'monster';
        }
    
        $npc = Npc::select(['npcs.*'])
            ->where(['npcs.name', 'like', '%'.$request->get('search').'%'])
            ->get();
    
        foreach ($npc as $key => $item) {
            $npc[$key]['type'] = 'npc';
            $npc[$key]['link'] = Url::link($item['name']);
        }
        
       return $this->render(['data' => [...$items, ...$monsters, ...$npc]]);
    }
}
