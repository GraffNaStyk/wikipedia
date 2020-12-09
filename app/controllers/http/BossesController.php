<?php

namespace App\Controllers\Http;

use App\Model\Boss;

class BossesController extends IndexController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->set(['title' => 'Bosses']);
    }
    
    public function index()
    {
        $bosses = Boss::select(['bosses.*', 'img.path', 'img.hash', 'img.ext', 'm.id as mosnter_id'])
            ->leftJoin(['monsters as m', 'm.name', '=', 'bosses.name'])
            ->leftJoin(['images as img', 'img.cid', '=', 'm.cid'])
            ->order(['min_lvl'])
            ->get();
    
        foreach ($bosses as $key => $boss) {
            $bosses[$key]['link'] = 'monsters/show/'.trim($boss['name']);
        }
        
        return $this->render([
            'bosses' => $bosses
        ]);
    }
}
