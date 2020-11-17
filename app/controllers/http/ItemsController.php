<?php

namespace App\Controllers\Http;

use App\Facades\Http\Request;

use App\Helpers\Items;
use App\Model\CtMonsterLoot;
use App\Model\Item;
use App\Model\Monster;

class ItemsController extends IndexController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index(string $type):void
    {
        $result = Items::prepare($type);
        
        if (! $result['items']) {
            $this->redirect('');
        }
        
        $this->render($result);
    }
    
    public function show(string $name)
    {
        $item = Item::select(['i.hash', 'i.path', 'i.ext', 'items.*'])->where(['items.name', '=', $name])
            ->leftJoin(['images as i', 'i.cid', '=', 'items.cid'])
            ->findOrFail();
    
        $item['weight'] = $item['weight'] / 100 . '.00 oz';

        $loot = CtMonsterLoot::select(['m.name', 'ct_monsters_loot.chance'])
            ->join(['monsters as m', 'm.id', '=', 'ct_monsters_loot.monster_id'])
            ->where(['ct_monsters_loot.item_id', '=', $item['cid']])
            ->order(['ct_monsters_loot.chance'], 'desc')
            ->get();
        
        return $this->render([
            'title' => 'Items',
            'item' => $item,
            'loot' => $loot
        ]);
    }
}
