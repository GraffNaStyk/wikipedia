<?php

namespace App\Controllers\Http;

use App\Model\Page;

class PagesController extends IndexController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }
    

    public function show(int $id)
    {
       $article = Page::where(['id', '=', $id])->first()->get();
       pd($article);
       $article['content'] = json_decode($article['content'], true);
       return $this->render(['article' => $article]);
    }
}
