<?php
require_once '../models/Dbh.php';
require_once '../models/cartModel.php';

session_start();

$cartModel = new cartModel();

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
} else {
    $cartID = $cartModel->getCartId($_SESSION['user']);
    if (!$cartID) {
        echo json_encode(['status' => 'error', 'message' => 'Unable to retrieve or create a cart']);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $product_id = $_POST['product_id'] ?? null;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : null;

    if (!$action || !$product_id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        exit;
    }

    switch ($action) {
        case 'set':
            if ($cartModel->addProductWithQuantity($cartID, $product_id, $quantity)) {
                echo json_encode(['status' => 'success', 'message' => 'Quantity set']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to set quantity']);
            }
            break;
        case 'increase':
            if ($cartModel->getWatchQuantity($product_id) <= $quantity) {
                exit;
            } else {
                $newQuantity = $quantity + 1;
                if ($cartModel->updateProductQuantity($cartID, $product_id, $newQuantity)) {
                    echo json_encode(['status' => 'success', 'message' => 'Quantity increased']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to increase quantity']);
                }
            }

            break;

        case 'decrease':

            $newQuantity = max(1, $quantity - 1);
            if ($cartModel->updateProductQuantity($cartID, $product_id, $newQuantity)) {
                echo json_encode(['status' => 'success', 'message' => 'Quantity decreased']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to decrease quantity']);
            }
            break;
        case 'add':
            if ($cartModel->addProductToCart($cartID, $product_id)) {

                echo json_encode(['status' => 'success', 'message' => 'Product added to cart']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to add product to cart']);
            }
            break;

        case 'delete':
            if ($cartModel->removeProductFromCart($cartID, $product_id)) {
                echo json_encode(['status' => 'success', 'message' => 'Product removed from cart']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to remove product from cart']);
            }
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
