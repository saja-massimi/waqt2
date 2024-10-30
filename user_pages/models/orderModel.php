<?php
class orderModel extends Dbh{



    public function createOrder(
        $user_id,$order_total ,$order_status,$order_address
        ){
        $sql = "INSERT INTO orders (user_id, order_total, order_status,order_address) VALUES (?, ?, ?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id, $order_total, $order_status,$order_address]);
    }

    public function addOrderItem($order_id, $product_id, $quantity){
        $sql = "INSERT INTO orders (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$order_id, $product_id, $quantity]);
    }

    public function getLastOrderId(){
        $sql = "SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch()['order_id'];
    }
}