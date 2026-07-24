<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../config.php';

// Get category filter from query parameter
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build SQL query
$sql = "SELECT 
            m.id,
            m.name,
            m.price,
            m.description as 'desc',
            m.full_description as fullDesc,
            m.ingredients,
            m.image_url as img,
            c.slug as category,
            m.is_available
        FROM menu_items m
        JOIN categories c ON m.category_id = c.id
        WHERE m.is_available = 1";

$params = [];

// Add category filter
if ($category !== 'all') {
    $sql .= " AND c.slug = ?";
    $params[] = $category;
}

// Add search filter
if (!empty($search)) {
    $sql .= " AND (m.name LIKE ? OR m.description LIKE ?)";
    $searchTerm = '%' . $search . '%';
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

$sql .= " ORDER BY m.id ASC";

// Execute query
$queryResult = executeQuery($conn, $sql, $params);

if (!$queryResult['success']) {
    sendJSON([
        'success' => false,
        'message' => $queryResult['message']
    ], 500);
}

$result = $queryResult['result'];
$menuItems = [];

while ($row = $result->fetch_assoc()) {
    $menuItems[] = [
        'id' => (int)$row['id'],
        'name' => $row['name'],
        'category' => $row['category'],
        'price' => (float)$row['price'],
        'desc' => $row['desc'],
        'fullDesc' => $row['fullDesc'],
        'ingredients' => $row['ingredients'],
        'img' => $row['img']
    ];
}

sendJSON([
    'success' => true,
    'data' => $menuItems,
    'count' => count($menuItems)
]);

$conn->close();
?>