<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$request_uri = $_SERVER['REQUEST_URI'];
$base_path = dirname($_SERVER['SCRIPT_NAME']);
$route = str_replace($base_path, '', parse_url($request_uri, PHP_URL_PATH));
$route = trim($route, '/');
$method = $_SERVER['REQUEST_METHOD'];

switch (true) {
    case ($route === 'api/items' && $method === 'GET'):
        require 'api/read.php';
        break;

    case (preg_match('/^api\/items\/(\d+)$/', $route, $matches) && $method === 'GET'):
        $_GET['id'] = $matches[1];
        require 'api/read_one.php';
        break;

    case ($route === 'api/items' && $method === 'POST'):
        require 'api/create.php';
        break;

    case ($route === 'api/items' && $method === 'PUT'):
        require 'api/update.php';
        break;

    case ($route === 'api/items' && $method === 'DELETE'):
        require 'api/delete.php';
        break;

    default:
        // Serve the frontend for non-API routes
        $frontend = __DIR__ . '/public/index.html';
        if (file_exists($frontend)) {
            header('Content-Type: text/html; charset=UTF-8');
            readfile($frontend);
            exit;
        }
        http_response_code(404);
        echo json_encode(['message' => 'Endpoint not found']);
        break;
}
