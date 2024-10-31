<?php
class orderModel extends Dbh
{



    public function createOrder(
        $user_id,
        $order_total,
        $order_status,
        $order_address
    ) {
        $sql = "INSERT INTO orders (user_id, order_total, order_status,order_address) VALUES (?, ?, ?,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id, $order_total, $order_status, $order_address]);
    }

    public function addOrderItem($order_id, $product_id, $quantity)
    {
        $sql = "INSERT INTO orders (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$order_id, $product_id, $quantity]);
    }

    public function getLastOrderId()
    {
        $sql = "SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch()['order_id'];
    }

    public function getOrders($user_id)
    {
        $sql = "SELECT * FROM orders WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }

    public function getCurrentOrder($user_id)
    {
        $sql = "SELECT 
            ci.cart_item_id,
            w.watch_id,
            w.watch_name,
            w.watch_price,
            ci.quantity,
            (w.watch_price * ci.quantity) AS total_price
        FROM 
            carts c
        JOIN 
            cart_items ci ON c.cart_id = ci.cart_id
        JOIN 
            watches w ON ci.watch_id = w.watch_id
        WHERE 
            c.user_id = :user_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll();
    }
}
