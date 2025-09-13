<?php

$router->get('/', function () { return response()->json(['service'=>'product-service']); });

$router->group(['prefix' => 'products'], function () use ($router) {
    $router->get('/', 'ProductController@index');
    $router->get('{id}', 'ProductController@show');
    $router->post('/', 'ProductController@store');
    $router->put('{id}', 'ProductController@update');
    $router->delete('{id}', 'ProductController@destroy');
});
