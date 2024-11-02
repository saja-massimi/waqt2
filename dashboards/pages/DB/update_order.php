<?php
include("./conn.php"); 

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['order_id']) || !isset($data['order_status'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$order_id = $data['order_id'];
$new_status = $data['order_status'];

$valid_statuses = ['pending', 'shipped', 'delivered', 'canceled'];
if (!in_array($new_status, $valid_statuses)) {
    echo json_encode(['success' => false, 'message' => 'Invalid order status']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE orders SET order_status = :new_status WHERE order_id = :order_id AND is_deleted = 0");
    $stmt->bindParam(':new_status', $new_status);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Order status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Order not found or status not changed']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

$pdo = null;
?>