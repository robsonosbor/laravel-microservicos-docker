<?php

$router->get('health', 'GatewayController@health');

$router->group(['middleware' => 'auth.token'], function () use ($router) {
    $router->get('products[/{path:.*}]', 'GatewayController@products');
    $router->post('products[/{path:.*}]', 'GatewayController@products');
    $router->put('products[/{path:.*}]', 'GatewayController@products');
    $router->delete('products[/{path:.*}]', 'GatewayController@products');

    $router->get('orders[/{path:.*}]', 'GatewayController@orders');
    $router->post('orders[/{path:.*}]', 'GatewayController@orders');
});
