<?php
include("./conn.php");

$order_id = $_GET['order_id'] ?? 0;

if ($order_id > 0) {
    $query = "
        SELECT o.order_address, o.created_at, oi.quantity, oi.price, w.watch_name 
        FROM orders o
        JOIN order_items oi ON o.order_id = oi.order_id
        JOIN watches w ON oi.watch_id = w.watch_id
        WHERE o.order_id = :order_id AND o.is_deleted IN (0, 1)
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $orderAddress = $items ? $items[0]['order_address'] : '';
    $orderDate = $items ? $items[0]['created_at'] : '';
    echo json_encode(['order_address' => $orderAddress,'order_date' => $orderDate, 'items' => $items]);
} else {
    echo json_encode(['error' => 'Invalid Order ID']);
}
?>
