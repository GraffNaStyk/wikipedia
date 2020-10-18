<?php
use App\Facades\Http\Router;

Router::group(['prefix' => 'admin', 'as' => 'App\Controllers\Admin', 'base' => 'login'], function () {

});

Router::get('login/index', 'Login/index');
Router::get('login', 'Login/index');
Router::post('login/make', 'login/make');
Router::get('logout', 'Logout/index');
Router::get('logout', 'Logout/index');

Router::get('weapons/{type}', 'Weapons/index');
Router::get('items/{type}', 'Items/index');

Router::get('article/show/{id}', 'Article/show');

Router::run();
