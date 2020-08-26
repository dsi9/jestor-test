<?php

$routes = new \App\Lib\Routes();

$routes->post('/api/login', 'App\Http\Controllers\LoginController::loginAction');

$routes->get('/api/todo-list', 'App\Http\Controllers\TodoListController::getAction', ['auth']);
$routes->get('/api/todo-list/:id', 'App\Http\Controllers\TodoListController::getAction', ['auth']);
$routes->post('/api/todo-list', 'App\Http\Controllers\TodoListController::postAction', ['auth']);
$routes->put('/api/todo-list/:id', 'App\Http\Controllers\TodoListController::putAction', ['auth']);
$routes->delete('/api/todo-list/:id', 'App\Http\Controllers\TodoListController::deleteAction', ['auth']);


return $routes;
