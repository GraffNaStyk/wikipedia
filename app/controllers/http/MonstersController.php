<?php

namespace App\Controllers\Http;

use App\Helpers\Pagination;
use App\Model\CtMonsterLoot;
use App\Model\Monster;

class MonstersController extends IndexController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(int $page=1)
    {
        if ($page < 0) {
            $page = 1;
        }
        
        $monsters = Monster::select(['name', 'health', 'experience', 'id'])
            ->order(['health', 'experience'], 'desc')
            ->where(['experience', '<>', 0])
            ->limit(self::PER_PAGE)
            ->offset(($page-1)*self::PER_PAGE)
            ->get();
        
        Pagination::make(
            Monster::where(['experience', '<>', 0])->count()['total'],
            $page,
            'monsters/'
        );
        
        foreach ($monsters as $key => $monster) {
            $items = CtMonsterLoot::select(['i.name', 'chance', 'img.path', 'img.hash', 'i.description', 'img.ext'])
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
