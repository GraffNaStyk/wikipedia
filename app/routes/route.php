<?php
use App\Facades\Http\Router;

Router::group(['prefix' => 'admin', 'as' => 'App\Controllers\Admin', 'base' => 'login'], function () {

});

Router::post('login/index', 'Login/index');
Router::post('login', 'Login/index');
Router::get('logout', 'Logout/index');
Router::get('logout', 'Logout/index');

Router::run();
