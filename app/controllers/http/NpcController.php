<?php

namespace App\Controllers\Http;

use App\Facades\Url\Url;
use App\Model\Npc;

class NpcController extends IndexController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $npcs = [];
        $res  = Npc::select(['npcs.*'])
            ->join(['ct_npc_items as ct', 'ct.npc_id', '=', 'npcs.id'])
            ->join(['items as i', 'ct.item_cid', '=', 'i.cid'])
            ->group('npcs.name')
            ->get();
        
        foreach ($res as $npc) {
            $npcs[] = [
                'name' => $npc['name'],
                'link' => 'npc/show/'.$npc['id'].'/'.Url::link($npc['name'])
            ];
        }
        
        $this->render([
            'npcs' => $npcs
        ]);
    }
    
    public function show(int $id)
    {
        $items = Npc::select(['npcs.name', 'ct.price', 'ct.type', 'i.name', 'img.path', 'img.hash', 'img.ext'])
            ->leftJoin(['ct_npc_items as ct', 'ct.npc_id', '=', 'npcs.id'])
            ->leftJoin(['items as i', 'ct.item_cid', '=', 'i.cid'])
            ->leftJoin(['images as img', 'i.cid', '=', 'img.cid'])
            ->where(['npcs.id', '=', $id])
            ->order(['ct.price'])
            ->get();

        $name = Npc::select(['name'])->where(['id', '=', $id])->findOrFail();
        
        if ($name) {
            $this->render([
                'title' => 'Npc - '.$name['name'],
                'items' => $items
            ]);
        } else {
            $this->redirect('');
        }
    }
}
