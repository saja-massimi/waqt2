<?php
include 'conn.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $coupon_name = $data['coupon_name'] ?? null;
    $coupon_value = $data['coupon_value'] ?? null;
    $start_date = $data['start_date'] ?? null;
    $end_date = $data['end_date'] ?? null;
    $usage_limit = $data['usage_limit'] ?? null;

    if ($coupon_name === null || $coupon_value === null || $start_date === null || $end_date === null || $usage_limit === null) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    $sql = "INSERT INTO coupons (coupon_name, coupon_value, start_date, end_date, usage_limit) 
            VALUES (:coupon_name, :coupon_value, :start_date, :end_date, :usage_limit)";

    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':coupon_name', $coupon_name);
        $stmt->bindParam(':coupon_value', $coupon_value);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':usage_limit', $usage_limit);

        $stmt->execute();
        
        echo json_encode(['success' => true, 'message' => 'Coupon added successfully!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
