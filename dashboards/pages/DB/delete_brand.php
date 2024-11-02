<?php
include 'conn.php';

if (isset($_POST['brand_id'])) {
    $brand_id = urldecode($_POST['brand_id']);
    $stmt = $pdo->prepare("UPDATE brandname SET is_deleted = 1 WHERE brand_id = :brand_id");
    $stmt->execute([':brand_id' => $brand_id]);

    if ($stmt->rowCount()) {
        echo "Brand marked as deleted successfully.";
    } else {
        echo "Failed to mark brand as deleted or brand not found.";
    }
}
?>
