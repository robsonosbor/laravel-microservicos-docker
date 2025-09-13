<?php

$router->get('/', function () { return response()->json(['service'=>'order-service']); });
$router->group(['prefix' => 'orders'], function () use ($router) {
    $router->post('/', 'OrderController@create');
});
