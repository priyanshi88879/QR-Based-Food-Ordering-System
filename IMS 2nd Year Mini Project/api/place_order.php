<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config.php';

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJSON([
        'success' => false,
        'message' => 'Only POST method is allowed'
    ], 405);
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    sendJSON([
        'success' => false,
        'message' => 'Invalid JSON input'
    ], 400);
}

// Validate required fields
if (!isset($input['tableNumber']) || !isset($input['items']) || empty($input['items'])) {
    sendJSON([
        'success' => false,
        'message' => 'Table number and items are required'
    ], 400);
}

$tableNumber = $input['tableNumber'];
$items = $input['items'];

// Calculate totals
$subtotal = 0;
$orderItems = [];

foreach ($items as $item) {
    if (!isset($item['id']) || !isset($item['quantity'])) {
        sendJSON([
            'success' => false,
            'message' => 'Invalid item data'
        ], 400);
    }
    
    // Get item details from database
    $sql = "SELECT id, name, price FROM menu_items WHERE id = ? AND is_available = 1";
    $result = executeQuery($conn, $sql, [$item['id']]);
    
    if (!$result['success'] || $result['result']->num_rows === 0) {
        sendJSON([
            'success' => false,
            'message' => 'Item not found or unavailable'
        ], 404);
    }
    
    $menuItem = $result['result']->fetch_assoc();
    $itemSubtotal = $menuItem['price'] * $item['quantity'];
    $subtotal += $itemSubtotal;
    
    $orderItems[] = [
        'menu_item_id' => $menuItem['id'],
        'quantity' => $item['quantity'],
        'price' => $menuItem['price'],
        'subtotal' => $itemSubtotal
    ];
}

// Calculate GST (5%)
$gstAmount = round($subtotal * 0.05, 2);
$grandTotal = $subtotal + $gstAmount;

// Start transaction
$conn->begin_transaction();

try {
    // Insert order
    $sql = "INSERT INTO orders (table_number, total_amount, gst_amount, grand_total, status) 
            VALUES (?, ?, ?, ?, 'pending')";
    $result = executeQuery($conn, $sql, [$tableNumber, $subtotal, $gstAmount, $grandTotal]);
    
    if (!$result['success']) {
        throw new Exception('Failed to create order');
    }
    
    $orderId = $conn->insert_id;
    
    // Insert order items
    foreach ($orderItems as $orderItem) {
        $sql = "INSERT INTO order_items (order_id, menu_item_id, quantity, price, subtotal) 
                VALUES (?, ?, ?, ?, ?)";
        $result = executeQuery($conn, $sql, [
            $orderId,
            $orderItem['menu_item_id'],
            $orderItem['quantity'],
            $orderItem['price'],
            $orderItem['subtotal']
        ]);
        
        if (!$result['success']) {
            throw new Exception('Failed to add order items');
        }
    }
    
    // Commit transaction
    $conn->commit();
    
    sendJSON([
        'success' => true,
        'message' => 'Order placed successfully',
        'data' => [
            'orderId' => $orderId,
            'tableNumber' => $tableNumber,
            'subtotal' => $subtotal,
            'gst' => $gstAmount,
            'total' => $grandTotal,
            'status' => 'pending',
            'estimatedTime' => '20-25 minutes'
        ]
    ]);
    
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    
    sendJSON([
        'success' => false,
        'message' => 'Failed to place order: ' . $e->getMessage()
    ], 500);
}

$conn->close();
?>