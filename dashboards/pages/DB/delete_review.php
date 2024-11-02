<?php
include('conn.php');

if (isset($_POST['review_id'])) {
    $review_id = $_POST['review_id'];
    $stmt = $pdo->prepare("DELETE FROM reviews WHERE review_id = :review_id");
    $stmt->bindParam(':review_id', $review_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Review deleted successfully!";
    } else {
        echo "Error deleting review.";
    }
} else {
    echo "No review ID provided.";
}
?>
