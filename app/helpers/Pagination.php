<?php

namespace App\Helpers;

use App\Core\Controller;
use App\Facades\Http\View;

class Pagination
{
    public static function make(int $total, int $page, string $url)
    {
        View::set([
            'pagination' => [
                'url' => $url,
                'prev'  => (int) ($page-1),
                'next'  => (int) ($page+1),
                'pages' => (int) ceil($total / Controller::PER_PAGE),
                'page' => (int) $page
            ]
        ]);
    }
}
