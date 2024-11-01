<?php
class orderModel extends Dbh
{



    public function createOrder(
        $user_id,
        $order_total,
        $order_status,
        $order_address,
        $additional_address
    ) {
        $sql = "INSERT INTO `orders`( `user_id`, `order_total`, `order_status`, `order_address`, `extra_directions`) VALUES (?, ?, ?, ?, ?)";

        try {
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$user_id, $order_total, $order_status, $order_address, $additional_address]);

            return $this->connect()->lastInsertId();
        } catch (PDOException $e) {
            error_log("Failed to create order: " . $e->getMessage());
            return false;
        }
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
            c.user_id = :user_id
          AND
            ci.is_deleted = 0";


        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll();
    }


    function getOrderTotal($user_id)
    {
        $sql = "SELECT SUM(w.watch_price * ci.quantity) AS total_price
        FROM 
            carts c
        JOIN 
            cart_items ci ON c.cart_id = ci.cart_id
        JOIN 
            watches w ON ci.watch_id = w.watch_id
        WHERE 
            c.user_id = :user_id
        AND    
        ci.is_deleted = 0
            ";


        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetch()['total_price'];
    }

    public function addOrderItems($order_id, $watch_id, $quantity, $watch_price)
    {

        $sql = 'INSERT INTO `order_items`( `order_id`, `watch_id`, `quantity`, `price`) VALUES (?,?,?,?)';
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$order_id, $watch_id, $quantity, $watch_price]);
    }

    public function getOrderDetails($user_id)
    {
        $sql = "SELECT * FROM orders WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
}
