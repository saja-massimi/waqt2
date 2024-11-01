<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once('../models/Dbh.php');
require_once('../models/couponModel.php');
require_once('../models/orderModel.php');

if (!isset($_SESSION['user'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'User session not set.'
    ]);
    exit;
}

if (isset($_POST['coupon'])) {
    $couponModel = new CouponModel();
    $coupon = trim($_POST['coupon_code']);

    if (!empty($coupon)) {
        if ($couponModel->checkCoupon($coupon)) {
            $discountPercentage = $couponModel->getCouponValue($coupon);
            $couponModel->updateCouponUsage($coupon);

            $order = new OrderModel();
            $total = $order->getOrderTotal($_SESSION['user']);
            $discountAmount = $total * $discountPercentage;
            $newTotal = $total - $discountAmount;

            echo json_encode([
                'status' => 'success',
                'discount' => $discountPercentage,
                'discounted_total' => $newTotal
            ]);
            exit;
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Coupon is invalid'
            ]);
            exit;
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Please enter a coupon code.'
        ]);
        exit;
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No coupon code submitted.'
    ]);
    exit;
}
