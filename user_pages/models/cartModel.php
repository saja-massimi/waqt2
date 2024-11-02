<?php

class cartModel extends Dbh
{


     public function getCartId($user_id)
     {
          $pdo = $this->connect();
          $cart_query = "SELECT * FROM carts WHERE user_id = ?";
          $cart_stmt = $pdo->prepare($cart_query);
          $cart_stmt->execute([$user_id]);
          $cart_result = $cart_stmt->fetch();
          return $cart_result['cart_id'];
     }

     public function addProductToCart($cartID, $product_id)
     {
          $pdo = $this->connect();

          $check_query = "SELECT * FROM cart_items WHERE cart_id = ? AND watch_id = ? AND is_deleted = 0";
          $check_stmt = $pdo->prepare($check_query);
          $check_stmt->execute([$cartID, $product_id]);
          $existingProduct = $check_stmt->fetch();

          if ($existingProduct) {
               if ($this->getWatchQuantity($product_id) <= $existingProduct['quantity']) {
                    return false;
               }
               $update_query = "UPDATE cart_items SET quantity = quantity + 1 WHERE cart_id = ?  AND watch_id = ?";
               $update_stmt = $pdo->prepare($update_query);
               return $update_stmt->execute([$cartID, $product_id]);
          } else {
               $cart_query = "INSERT INTO cart_items (cart_id, watch_id, quantity) VALUES (?, ?, ?)";
               $cart_stmt = $pdo->prepare($cart_query);
               return $cart_stmt->execute([$cartID, $product_id, 1]);
          }
     }

     public function addProductWithQuantity($cartID, $product_id, $quantity)
     {
          $pdo = $this->connect();

          $check_query = "SELECT * FROM cart_items WHERE cart_id = ? AND watch_id = ? AND is_deleted = 0";
          $check_stmt = $pdo->prepare($check_query);
          $check_stmt->execute([$cartID, $product_id]);
          $existingProduct = $check_stmt->fetch();

          if ($existingProduct) {
               if ($this->getWatchQuantity($product_id) <= $existingProduct['quantity']) {
                    return false;
               }
               $update_query = "UPDATE cart_items SET quantity = quantity + ? WHERE cart_id = ?  AND watch_id = ?";
               $update_stmt = $pdo->prepare($update_query);
               return $update_stmt->execute([$quantity, $cartID, $product_id]);
          } else {
               $cart_query = "INSERT INTO cart_items (cart_id, watch_id, quantity) VALUES (?, ?, ?)";
               $cart_stmt = $pdo->prepare($cart_query);
               return $cart_stmt->execute([$cartID, $product_id, $quantity]);
          }
     }

     public function getAllProductsInCart($cartID)
     {
          $pdo = $this->connect();
          $cart_query = "SELECT * FROM cart_items WHERE cart_id = ? AND is_deleted = 0";
          $cart_stmt = $pdo->prepare($cart_query);
          $cart_stmt->execute([$cartID]);
          return $cart_stmt->fetchAll();
     }

     public function getWatchDetails($watch_id)
     {
          $pdo = $this->connect();
          $product_query = "SELECT * FROM watches WHERE watch_id = ? AND is_deleted = 0";
          $product_stmt = $pdo->prepare($product_query);
          $product_stmt->execute([$watch_id]);

          return $product_stmt->fetch();
     }

     public function removeProductFromCart($cartID, $product_id)
     {
          $pdo = $this->connect();
          $cart_query = "UPDATE  cart_items SET is_deleted =1 WHERE cart_id = ? AND watch_id = ?";
          $cart_stmt = $pdo->prepare($cart_query);
          return $cart_stmt->execute([$cartID, $product_id]);
     }

     public function updateProductQuantity($cartID, $product_id, $quantity)
     {
          $pdo = $this->connect();
          $cart_query = "UPDATE cart_items SET quantity = ? WHERE cart_id = ? AND watch_id = ?";
          $cart_stmt = $pdo->prepare($cart_query);
          return $cart_stmt->execute([$quantity, $cartID, $product_id]);
     }

     public function getAllProductsInCartForCheckout($cartID)
     {
          $pdo = $this->connect();
          $cart_query = "SELECT * FROM cart_items WHERE cart_id = ? AND is_deleted = 0";
          $cart_stmt = $pdo->prepare($cart_query);
          $cart_stmt->execute([$cartID]);
          return $cart_stmt->fetchAll();
     }

     public function clearCart($cartID)
     {
          $pdo = $this->connect();
          $cart_query = "UPDATE cart_items SET is_deleted = 1 WHERE cart_id = ?";
          $cart_stmt = $pdo->prepare($cart_query);
          return $cart_stmt->execute([$cartID]);
     }

     public function getCartTotal($cartID)
     {
          $pdo = $this->connect();
          $cart_query = "SELECT SUM(w.watch_price * ci.quantity) as total FROM cart_items ci JOIN watches w ON ci.watch_id = w.watch_id WHERE ci.cart_id = ?";
          $cart_stmt = $pdo->prepare($cart_query);
          $cart_stmt->execute([$cartID]);
          return $cart_stmt->fetch();
     }

     public function getCartItemsCount($cartID)
     {
          $pdo = $this->connect();
          $cart_query = "SELECT COUNT(*) as count FROM cart_items WHERE cart_id = ? AND  is_deleted = 0";
          $cart_stmt = $pdo->prepare($cart_query);
          $cart_stmt->execute([$cartID]);
          return $cart_stmt->fetch();
     }

     public function getProductQuantity($cartID, $product_id)
     {
          $pdo = $this->connect();
          $cart_query = "SELECT quantity FROM cart_items WHERE cart_id = ? AND watch_id = ?";
          $cart_stmt = $pdo->prepare($cart_query);
          $cart_stmt->execute([$cartID, $product_id]);
          return $cart_stmt->fetch()['quantity'];
     }

     public function getWatchQuantity($product_id)
     {
          $pdo = $this->connect();
          $product_query = "SELECT quantity FROM watches WHERE watch_id = ?";
          $product_stmt = $pdo->prepare($product_query);
          $product_stmt->execute([$product_id]);
          return $product_stmt->fetch()['quantity'];
     }
}
