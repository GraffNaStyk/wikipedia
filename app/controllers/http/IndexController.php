<?php namespace App\Controllers\Http;

use App\Core\Controller;
use App\Facades\Parser\Items;
use App\Model\Menu;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->set([
            'menu' => Menu::select(['name', 'images.path'])
                ->join(['images', 'icon_id', '=', 'images.id'])
                ->get()
        ]);
        
        Items::parse();
        
    }

    public function index()
    {
        return $this->render();
    }
}
