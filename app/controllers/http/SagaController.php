<?php

namespace App\Controllers\Http;

use App\Facades\Http\Request;
use App\Model\Saga;

class SagaController extends IndexController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $res = Saga::select(['sagas.*', 'i.name as item', 'img.path', 'img.hash', 'img.ext'])
            ->leftJoin(['items as i', 'sagas.item', '=', 'i.cid'])
            ->leftJoin(['images as img', 'i.cid', '=', 'img.cid'])
            ->order(['sagas.order'])
            ->get();
    }
}
