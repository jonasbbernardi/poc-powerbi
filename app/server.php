<?php

include_once __DIR__ . '/routes/Router.php';
include_once __DIR__ . '/routes/StaticHandler.php';
include_once __DIR__ . '/routes/routes.php';

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_method = $_SERVER['REQUEST_METHOD'];

if (!$router->dispatch($request_method, $request_uri)) {
    StaticHandler::handle($request_uri);
}