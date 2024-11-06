<?php
session_start();
require_once '../user_pages/models/Dbh.php';
require_once '../user_pages/models/cartModel.php';

$response = ['wishlist_count' => 0, 'cart_count' => 0];

if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'];
    $dbconnection = new Dbh();

    // Get wishlist count
    $query = "SELECT COUNT(*) AS total_number FROM `wishlist` WHERE `user_id` = :user_id";
    $pdo = $dbconnection->connect();
    $statement = $pdo->prepare($query);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $response['wishlist_count'] = $result['total_number'] ?? 0;

    // Get cart count
    $cartModel = new cartModel();
    $cartID = $cartModel->getCartId($user_id);
    $cartTotal = $cartModel->getCartItemsCount($cartID);
    $response['cart_count'] = $cartTotal['count'] ?? 0;
}

echo json_encode($response);
