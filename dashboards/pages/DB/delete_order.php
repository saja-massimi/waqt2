<?php
include 'conn.php';

if (isset($_POST['order_id'])) {
    $order_id = urldecode($_POST['order_id']);
    
    $stmt = $pdo->prepare("UPDATE orders SET order_status = 'canceled', is_deleted = 1 WHERE order_id = :order_id");
    $stmt->execute([':order_id' => $order_id]);

    if ($stmt->rowCount()) {
        echo "Order status updated to canceled and marked as deleted successfully.";
    } else {
        echo "Failed to update order status or order not found.";
    }
}
?>
