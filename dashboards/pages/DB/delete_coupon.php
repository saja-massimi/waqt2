<?php
include 'conn.php';

if (isset($_POST['coupon_id'])) {
    $coupon_id = urldecode($_POST['coupon_id']);
    $stmt = $pdo->prepare("UPDATE coupons SET is_deleted = 1 WHERE coupon_id = :coupon_id");
    $stmt->execute([':coupon_id' => $coupon_id]);

    if ($stmt->rowCount()) {
        echo "Coupon marked as deleted successfully.";
    } else {
        echo "Failed to mark coupon as deleted or coupon not found.";
    }
}
?>
