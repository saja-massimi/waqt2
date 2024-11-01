<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../models/Dbh.php';
require_once '../models/orderModel.php';
require_once '../models/cartModel.php';
require_once '../models/profileModel.php';
require_once '../models/productsModel.php';
require_once '../controllers/productsController.php';

if (isset($_POST['order'])) {
    $user_id = $_SESSION['user'] ?? null;

    if (!$user_id) {
        echo json_encode([
            'status' => 'error',
            'message' => 'User not logged in. Please log in to place an order.'
        ]);
        exit;
    }

    $order_total = $_POST['order_total'] ?? null;
    $order_address = $_POST['order_address'] ?? null;

    if (!$order_total || !$order_address) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Required fields are missing.'
        ]);
        exit;
    }

    $orderModel = new orderModel();
    $cartModel = new cartModel();
    $productController = new productsController();

    $order_status = 'pending';
    $additional_address = $_POST['additional_address'] ?? '';

    $order_id = $orderModel->createOrder($user_id, $order_total, $order_status, $order_address, $additional_address);

    if ($order_id === false) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to place order. Please try again.'
        ]);
        exit;
    }


    $id = $orderModel->getLastOrderId();
    $cartID = $cartModel->getCartId($user_id);
    if ($cartID) {
        $products2 = $cartModel->getAllProductsInCart($cartID);

        foreach ($products2 as $product) {
            $productDetails = $cartModel->getWatchDetails($product['watch_id']);
            if ($productDetails) {
                $orderModel->addOrderItems(
                    $id,
                    $product['watch_id'],
                    $product['quantity'],
                    $productDetails['watch_price']
                );
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to add order item. Please try again.'
                ]);
                exit;
            }
        }
    }


    $cartID = $cartModel->getCartId($user_id);
    if ($cartID) {
        $products = $cartModel->getAllProductsInCart($cartID);
        foreach ($products as $product) {
            $product = $productController->productByID($product['watch_id']);
            if (!$cartModel->removeProductFromCart($cartID, $product['watch_id'])) {
                error_log("Failed to remove product with ID " . $product['watch_id'] . " from cart.");
            }
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Order has been placed successfully!',
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to send the request. Please try again.'
    ]);
    exit;
}
