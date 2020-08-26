<?php

require_once __DIR__ . '/../vendor/autoload.php';

$server = new \App\Server();

$server->middlewares([
    'auth' => \App\Http\Middleware\BasicAuth::class
]);

return $server;
