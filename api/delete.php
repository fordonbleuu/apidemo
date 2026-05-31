<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config/database.php';
require_once 'objects/item.php';

$database = new Database();
$db = $database->getConnection();
$item = new Item($db);

$data = json_decode(file_get_contents('php://input'));

if (!empty($data->id)) {
    $item->id = $data->id;

    if ($item->delete()) {
        http_response_code(200);
        echo json_encode(['message' => 'Item deleted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Unable to delete item']);
    }
} else {
    http_response_code(400);
    echo json_encode(['message' => 'ID is required']);
}
