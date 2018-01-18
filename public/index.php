<?php

require_once '../vendor/autoload.php';


use Phroute\Phroute\RouteCollector;


$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

$route = $_GET['route'] ?? "/";

$router = new RouteCollector();

$router->get('/',['\App\Controllers\HomeController', 'getIndex']);
$router->post('/',['\App\Controllers\HomeController', 'postIndex']);


$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

$method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$response = $dispatcher->dispatch($method, $route);

// Print out the value returned from the dispatched function
echo $response;
