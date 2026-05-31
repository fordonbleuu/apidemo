<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config/database.php';
require_once 'objects/item.php';

$database = new Database();
$db = $database->getConnection();
$item = new Item($db);

$data = json_decode(file_get_contents('php://input'));

if (!empty($data->id) && !empty($data->name) && isset($data->price)) {
    $item->id = $data->id;
    $item->name = $data->name;
    $item->description = $data->description ?? '';
    $item->price = $data->price;
    $item->category = $data->category ?? 'General';

    if ($item->update()) {
        http_response_code(200);
        echo json_encode(['message' => 'Item updated successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Unable to update item']);
    }
} else {
    http_response_code(400);
    echo json_encode(['message' => 'Incomplete data. ID, name, and price are required.']);
}
