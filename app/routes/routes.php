<?php

include_once __DIR__ . '/../services/token.service.php';

$router = new Router();

$router->addRoute('GET', '/token', function () {
    header('Content-Type: application/json');
    try{
        $tokenService = new TokenService();
        $credentials = $tokenService->getCredentials();
        echo json_encode($credentials);
    } catch (Exception $error) {
        echo json_encode([
            'status' => 'error',
            'message' => $error->getMessage()
        ]);
    }
});
