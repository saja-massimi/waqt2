<?php

require_once '../models/Dbh.php';
require_once '../models/orderModel.php';
require_once '../models/cartModel.php';
require_once '../models/profileModel.php';


if (isset($_POST['checkout'])) {

    session_start();
    $user_id = $_SESSION['user'];

    if (!isset($user_id)) {
        header('Location: ../user_pages/login.php');
    }
    $orderModel = new orderModel();

    $profileModel = new profileModel();
    print_r($profileModel->getProfile($user_id));



    // //delete the cart items
    // $cartModel = new cartModel();
    // $cartID = $cartModel->getCartId($user_id);
    // $products = $cartModel->getAllProductsInCart($cartID);
    // foreach ($products as $product) {
    //     $cartModel->removeProductFromCart($cartID, $product['watch_id']);
    // }



    //  //get Address from user

    // $profile = $profileModel->getProfile($user_id);
    // print_r($profile);
    // //create the order
    // $order_total = $_POST['order_total'];
    // $order_status = 'pending';
    // $order_address = $profile['user_address'];
    // $orderModel->createOrder($user_id, $order_total, $order_status, $order_address);

    // //get the order id
    // $order_id = $orderModel->getLastOrderId();


    // header('Location: ../user_pages/orders.php');
} else {
    header('Location: ../user_pages/cart.php');
}
