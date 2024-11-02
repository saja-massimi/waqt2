<?php
include 'conn.php';

if (isset($_POST['watch_id'])) {
    $watch_id = urldecode($_POST['watch_id']);
    $stmt = $pdo->prepare("UPDATE watches SET is_deleted = 1 WHERE watch_id = :watch_id");
    $stmt->execute([':watch_id' => $watch_id]);

    if ($stmt->rowCount()) {
        echo "Watch marked as deleted successfully.";
    } else {
        echo "Failed to mark watch as deleted or watch not found.";
    }
}
?>
