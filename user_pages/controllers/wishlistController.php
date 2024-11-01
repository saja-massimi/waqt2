<?php
require_once '../models/Dbh.php';
require_once '../models/wishlistModel.php';

session_start();

$wishlistModel = new wishlistModel();

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $product_id = $_POST['product_id'] ?? null;

    if (!$action || !$product_id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        exit;
    }

    switch ($action) {

        case 'fav':
            if ($wishlistModel->addWishlist($_SESSION['user'], $product_id)) {

                echo json_encode(['status' => 'success', 'message' => 'Product added to Wishlist']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to add product to Wishlist']);
            }
            break;


        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
