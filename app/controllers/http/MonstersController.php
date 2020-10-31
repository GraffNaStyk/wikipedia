<?php

namespace App\Controllers\Http;

use App\Model\CtMonsterLoot;
use App\Model\Monster;

class MonstersController extends IndexController
{
    const PER_PAGE = 25;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $monsters = Monster::select(['name', 'health', 'experience', 'id'])
            ->order(['health', 'experience'], 'desc')
            ->where(['experience', '<>', 0])
            ->get();

        foreach ($monsters as $key => $monster) {
            $items = CtMonsterLoot::select(['i.name', 'chance', 'img.path', 'img.hash', 'i.description'])
                ->join(['items as i', 'i.cid', '=', 'item_id'])
                ->join(['images as img', 'i.cid', '=', 'img.cid'])
                ->where(['monster_id', '=', $monster['id']])
                ->get();
            
            if (empty($items)) {
                unset($monsters[$key]);
            } else {
                
                usort($items, function ($a, $b) {
                    return $a['chance'] < $b['chance'];
                });
                
                $monsters[$key]['loot'] = $items;
            }
        }
        $this->render(['monsters' => $monsters]);
    }
}
