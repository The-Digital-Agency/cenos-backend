<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/route-list', function () {
    $routeCollect = [];
    foreach (Route::getRoutes() as $value) {
        $valObject = [
            'HTTP Method' => $value->methods()[0],
            'Route' => 'http://' . request()->getHttpHost() . '/' . $value->uri(),
            'Action' => $value->getActionName()
        ];
        array_push($routeCollect, $valObject);
    }
    return $routeCollect;
});
