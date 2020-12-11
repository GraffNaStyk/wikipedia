<?php

namespace App\Controllers\Http;

use App\Facades\Http\Request;
use App\Helpers\Pagination;
use App\Helpers\Session;
use App\Model\CtMonsterLoot;
use App\Model\Monster;

class MonstersController extends IndexController
{
    protected array $filters = [
        [
            'text' => 'hp',
            'value' => 'health'
        ],
        [
            'text' => 'experience',
            'value' => 'experience'
        ]
    ];
    
    protected array $orders = [
        [
            'text' => 'ascending',
            'value' => 'asc'
        ],
        [
            'text' => 'descending',
            'value' => 'desc'
        ]
    ];
    
    public function __construct()
    {
        parent::__construct();
        $this->set(['title' => 'Monsters']);
    }

    public function index(int $page=1)
    {
        if ($page < 0) {
            $page = 1;
        }
        
        $monsters = Monster::select([
            'monsters.name', 'monsters.health', 'monsters.experience', 'monsters.id', 'i.hash', 'i.path', 'i.ext'
        ])
        ->leftJoin(['images as i', 'i.cid', '=', 'monsters.cid'])
        ->where(['experience', '<>', 0])
            ->limit(self::PER_PAGE)
            ->order(['health', 'experience'], 'desc')
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

        $this->render([
            'monsters' => $monsters,
            'filters'  => $this->filters,
            'orders'   => $this->orders,
            'page'     => $page
        ]);
    }
    
    public function show(string $name)
    {
        $monster = Monster::select(['monsters.*', 'i.ext', 'i.path', 'i.hash'])
            ->where(['monsters.name', '=', $name])
            ->join(['images as i', 'i.cid', '=', 'monsters.cid'])
            ->findOrFail();
        
        if ($monster) {
            $loot = CtMonsterLoot::select(['i.name', 'chance', 'img.path', 'img.hash', 'i.description', 'img.ext'])
                ->join(['items as i', 'i.cid', '=', 'item_id'])
                ->join(['images as img', 'i.cid', '=', 'img.cid'])
                ->where(['monster_id', '=', $monster['id']])
                ->where(['i.name', '<>', 'backpack'])
                ->order(['ct_monsters_loot.chance'], 'desc')
                ->get();
            
            return $this->render([
                'title' => 'Monster - '.ucfirst($monster['name']),
                'monster' => $monster,
                'loot' => $loot
            ]);
        } else {
            $this->redirect('');
        }
    }
}
