<?php
include 'conn.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $coupon_id = $data['coupon_id'] ?? null;
    $coupon_value = $data['coupon_value'] ?? null;
    $end_date = $data['end_date'] ?? null;
    $start_date = $data['end_date'] ?? null;
    $usage_limit = $data['usage_limit'] ?? null;

    if ($coupon_id === null || $coupon_value === null || $end_date === null || $usage_limit === null) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT start_date FROM coupons WHERE coupon_id = :coupon_id");
    $stmt->bindParam(':coupon_id', $coupon_id, PDO::PARAM_INT);
    $stmt->execute();
    $start_date = $stmt->fetchColumn();

    if ($start_date) {
        if ($end_date < $start_date) {
            echo json_encode(['success' => false, 'message' => 'End date must be after the start date.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Start date not found.']);
        exit;
    }

    $sql = "UPDATE coupons 
            SET coupon_value = :coupon_value, 
                end_date = :end_date, 
                usage_limit = :usage_limit 
            WHERE coupon_id = :coupon_id";

    try {
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':coupon_value', $coupon_value);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':usage_limit', $usage_limit, PDO::PARAM_INT);
        $stmt->bindParam(':coupon_id', $coupon_id, PDO::PARAM_INT);

        $stmt->execute();
        
        echo json_encode(['success' => true, 'message' => 'Coupon updated successfully!', 'start_date' => $start_date]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
