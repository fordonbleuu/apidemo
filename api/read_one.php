<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config/database.php';
require_once 'objects/item.php';

$database = new Database();
$db = $database->getConnection();
$item = new Item($db);

$item->id = $_GET['id'] ?? die(json_encode(['message' => 'ID is required']));

if ($item->readOne()) {
    $item_data = [
        'id' => $item->id,
        'name' => $item->name,
        'description' => $item->description,
        'price' => $item->price,
        'category' => $item->category,
        'created_at' => $item->created_at,
        'updated_at' => $item->updated_at
    ];

    http_response_code(200);
    echo json_encode($item_data);
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Item not found']);
}
