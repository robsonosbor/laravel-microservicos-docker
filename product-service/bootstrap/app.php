<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

$app = new Laravel\Lumen\Application(dirname(__DIR__));

if (env('WITH_ELOQUENT', false)) {
    $app->withEloquent();
}
$app->withFacades();

$app->routeMiddleware([
    'auth.token' => App\Http\Middleware\TokenMiddleware::class,
]);

$app->router->group(['namespace' => 'App\Http\Controllers'], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
