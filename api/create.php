<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config/database.php';
require_once 'objects/item.php';

$database = new Database();
$db = $database->getConnection();
$item = new Item($db);

$data = json_decode(file_get_contents('php://input'));

if (!empty($data->name) && isset($data->price)) {
    $item->name = $data->name;
    $item->description = $data->description ?? '';
    $item->price = $data->price;
    $item->category = $data->category ?? 'General';

    if ($item->create()) {
        http_response_code(201);
        echo json_encode(['message' => 'Item created successfully', 'id' => $item->id]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Unable to create item']);
    }
} else {
    http_response_code(400);
    echo json_encode(['message' => 'Incomplete data. Name and price are required.']);
}
