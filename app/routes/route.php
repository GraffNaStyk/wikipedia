<?php
use App\Facades\Http\Router;

Router::group(['prefix' => 'admin', 'as' => 'App\Controllers\Admin', 'base' => 'login'], function () {
    Router::get('pages/components/add/{id}', 'PagesComponents/add');
    Router::get('pages/components/edit/{id}', 'PagesComponents/edit');
    Router::post('pages/components/store', 'PagesComponents/store');
    Router::post('pages/components/update', 'PagesComponents/update');
    
    Router::get('pages/components/set/table/{id}', 'PagesComponents/setTableRows');
});

Router::get('login/index', 'Login/index');
Router::get('login', 'Login/index');
Router::post('login/make', 'login/make');
Router::get('logout', 'Logout/index');
Router::get('logout', 'Logout/index');

Router::get('weapons/{type}', 'Weapons/index');
Router::get('items/{type}', 'Items/index');

Router::get('page/show/{id}/{link}', 'Pages/show');

Router::get('vocations/show/{name}', 'Vocations/show');

Router::get('monsters/{page}', 'monsters/index');

Router::run();
