<?php


class wishlistModel extends Dbh
{


    public function getWishlist($user_id)
    {
        $sql = "SELECT * FROM wishlist WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);
        $results = $stmt->fetchAll();
        return $results;
    }

    public function addWishlist($user_id, $product_id)
    {
        $sql = "INSERT INTO `wishlist` (`user_id`, `watch_id`) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$user_id, $product_id]); // Execute and return result of execution
    }


    public function deleteWishlist($user_id, $product_id)
    {
        $sql = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id, $product_id]);
    }

    public function checkWishlist($user_id, $product_id)
    {
        $sql = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id, $product_id]);
        $results = $stmt->fetchAll();
        return $results;
    }
}
