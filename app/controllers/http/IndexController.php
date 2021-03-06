<?php

namespace App\Controllers\Http;

use App\Core\Controller;
use App\Helpers\Map;
use App\Helpers\Pages;
use App\Helpers\System;
use App\Model\Achievement;
use App\Model\Npc;
use App\Model\Vocation;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::boot();
        $this->boot();
    }
    
    public function boot()
    {
        $this->set([
            'title' => 'Dashboard - last added',
            'vocations' => Vocation::order(['name'], 'asc')->all(),
            'last_added' => Pages::createLastAdded(),
            'last_updated' => Pages::createLastUpdated(),
            'npc' => Npc::count()['total'],
            'achievements' => Achievement::all(),
            'systems' => System::factory(),
            'maps' => Map::factory(),
            'tutorials' => ''
        ]);
    }

    public function index()
    {
        return $this->render();
    }
}
