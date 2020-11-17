<?php

namespace App\Controllers\Http;

use App\Facades\Http\Request;
use App\Model\Item;

class SearchController extends IndexController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $items = Item::select(['items.name', 'images.path', 'images.ext', 'images.hash'])
            ->leftJoin(['images', 'items.cid', '=', 'images.cid'])
            ->where(['items.name', 'like', '%'.$request->get('search').'%'])
            ->get();
        
       return $this->render(['items' => $items]);
    }
    
}
