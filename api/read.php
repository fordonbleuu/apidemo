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

$stmt = $item->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $items_arr = [];
    $items_arr['items'] = [];

    while ($row = $stmt->fetch()) {
        $item_data = [
            'id' => $row['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => $row['price'],
            'category' => $row['category'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        ];

        $items_arr['items'][] = $item_data;
    }

    http_response_code(200);
    echo json_encode($items_arr);
} else {
    http_response_code(200);
    echo json_encode(['items' => []]);
}
