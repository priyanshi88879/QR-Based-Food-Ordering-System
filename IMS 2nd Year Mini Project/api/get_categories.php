<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../config.php';

$sql = "SELECT id, name, slug, icon FROM categories ORDER BY id ASC";

$result = executeQuery($conn, $sql);

if (!$result['success']) {
    sendJSON([
        'success' => false,
        'message' => $result['message']
    ], 500);
}

$categories = [];
while ($row = $result['result']->fetch_assoc()) {
    $categories[] = [
        'id' => (int)$row['id'],
        'name' => $row['name'],
        'slug' => $row['slug'],
        'icon' => $row['icon']
    ];
}

sendJSON([
    'success' => true,
    'data' => $categories
]);

$conn->close();

?>