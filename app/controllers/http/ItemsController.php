<?php

namespace App\Controllers\Http;

use App\Facades\Http\Request;

use App\Facades\Url\Url;
use App\Helpers\Items;
use App\Model\CtMonsterLoot;
use App\Model\CtNpcItem;
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
        $item = Item::select(['i.hash', 'i.path', 'i.ext', 'items.*', 'i.cid'])
            ->where(['items.name', '=', $name])
            ->leftJoin(['images as i', 'i.cid', '=', 'items.cid'])
            ->findOrFail();
        
        if ($item) {
            $item['weight'] = $item['weight'] / 100 . ' oz';
    
            $loot = CtMonsterLoot::select(['m.name', 'ct_monsters_loot.chance', 'i.hash', 'i.path', 'i.ext'])
                ->join(['monsters as m', 'm.id', '=', 'ct_monsters_loot.monster_id'])
                ->join(['images as i', 'i.cid', '=', 'm.cid'])
                ->where(['ct_monsters_loot.item_id', '=', $item['cid']])
                ->order(['ct_monsters_loot.chance'], 'desc')
                ->get();
    
            $sellable = CtNpcItem::select(['price', 'type', 'npcs.name', 'npcs.id as npc_id'])
                ->join(['npcs', 'npcs.id', '=', 'ct_npc_items.npc_id'])
                ->where(['ct_npc_items.item_cid', '=', $item['cid']])
                ->get();
            
            foreach ($sellable as $key => $sell) {
                $sellable[$key]['npc_link_name'] = Url::link($sell['name']);
            }
    
            return $this->render([
                'title' => 'Item - '.ucfirst($item['name']),
                'item' => Items::prepareForView(array_filter($item)),
                'loot' => $loot,
                'sellable' => $sellable
            ]);
        } else {
            $this->redirect('');
        }
    }
}
