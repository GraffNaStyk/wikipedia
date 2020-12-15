<?php
use App\Facades\Http\Router;

Router::group(['prefix' => 'admin', 'as' => 'App\Controllers\Admin', 'base' => 'dash'], function () {
    Router::get('pages/components/add/{id}', 'PagesComponents@add');
    Router::get('pages/components/edit/{id}', 'PagesComponents@edit');
    Router::post('pages/components/store', 'PagesComponents@store');
    Router::post('pages/components/update', 'PagesComponents@update');
    Router::get('pages/components/active/{active}/{id}/{pageId}', 'PagesComponents@active');
    
    Router::get('pages/table/components/edit/{id}', 'TableComponent@edit');
    Router::post('pages/table/components/update', 'TableComponent@update');
    
    Router::get('images/set', 'Images@setImage');
    Router::post('images/set/current', 'Images@setImage');
    
    Router::get('images/find/{name}', 'Images@find');
});

Router::get('login/index', 'Login@index');
Router::get('login', 'Login@index');
Router::post('login/make', 'login@make');
Router::get('logout', 'Logout@index');
Router::get('logout', 'Logout@index');

Router::get('weapons/{type}', 'Weapons@index');
Router::get('items/show/{name}', 'Items@show');
Router::get('items/{type}', 'Items@index');
Router::get('monsters/show/{name}', 'Monsters@show');

Router::get('page/show/{id}/{link}', 'Pages@show');

Router::get('vocations/show/{name}', 'Vocations@show');

Router::get('monsters/{page}', 'monsters@index');

Router::post('search', 'Search@index');

Router::get('systems/task/daily', 'Systems@dailyTask');
Router::get('systems/task/extreme', 'Systems@extremeTask');
Router::get('systems/status', 'Systems@status');

Router::run();
