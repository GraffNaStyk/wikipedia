<?php

namespace App\Controllers\Http;

use App\Core\Controller;
use App\Facades\Parser\Movements;
use App\Facades\Parser\Spells;
use App\Model\Menu;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->set([
            'menu' => Menu::select(['name', 'images.path'])
                ->join(['images', 'icon_id', '=', 'images.id'])
                ->get(),
            'title' => 'Dashboard'
        ]);
        pd(Spells::parse(), true);
    }

    public function index()
    {
        return $this->render();
    }
}
