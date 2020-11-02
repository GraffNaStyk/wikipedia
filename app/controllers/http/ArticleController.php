<?php namespace App\Controllers\Http;

use App\Controllers\ControllerInterface;
use App\Facades\Http\Request;
use App\Model\Page;

class ArticleController extends IndexController implements ControllerInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    public function add()
    {

    }

    public function store(Request $request)
    {

    }

    public function update(Request $request)
    {

    }

    public function show(int $id)
    {
       $article = Page::where(['id', '=', $id])->first()->get();
       $article['content'] = json_decode($article['content'], true);
       return $this->render(['article' => $article]);
    }

    public function edit(int $id)
    {

    }

    public function delete(int $id)
    {

    }
}
