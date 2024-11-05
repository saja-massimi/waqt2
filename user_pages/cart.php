<!DOCTYPE html>
<html lang="en">

<?php require_once("../widgets/head.php"); ?>

<body>
    <?php
    require_once("../widgets/navbar.php");
    require_once '../user_pages/models/Dbh.php';
    require_once '../user_pages/models/cartModel.php';

    $cartModel = new cartModel();


    $cartID = $cartModel->getCartId($_SESSION['user']);
    $products = $cartModel->getAllProductsInCart($cartID);

    $total = 0;
    ?>

    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php foreach ($products as $product):
                            $product_id = $product['watch_id'];
                            $productDetails = $cartModel->getWatchDetails($product_id);
                            $total += $productDetails['watch_price'] * $product['quantity'];
                        ?>
                            <tr>
                                <td class="align-middle">
                                    <img src="../../Project/dashboards/assets/products_img/<?= htmlspecialchars($productDetails['watch_img']) ?>" alt="" style="width: 50px;">
                                    <div><?= htmlspecialchars($productDetails['watch_name']) ?></div>
                                </td>
                                <td class="align-middle"><?= htmlspecialchars($productDetails['watch_price']) ?> JOD</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <!-- Decrease Quantity -->
                                        <button class="btn btn-sm btn-danger text-white adjust-quantity" data-action="decrease" data-product-id="<?= $product_id ?>" data-quantity="<?= $product['quantity'] ?>">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <input type="text" class="form-control form-control-sm  qun border-0 text-center" id="quantity-<?= $product_id ?>" value="<?= $product['quantity'] ?>" readonly>
                                        <!-- Increase Quantity -->
                                        <button class=" btn btn-sm btn-danger text-white adjust-quantity" data-action="increase" data-product-id="<?= $product_id ?>" data-quantity="<?= $product['quantity'] ?>">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="align-middle"><?= htmlspecialchars($productDetails['watch_price'] * $product['quantity']) ?> JOD</td>
                                <!-- Delete Product -->
                                <td class="align-middle">
                                    <button class="btn btn-sm btn-warning text-white adjust-quantity" data-action="delete" data-product-id="<?= $product_id ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">

                </form>
                <h5 class="section-title position-relative text-uppercase mb-3"><span class=" pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 class="price"><?= htmlspecialchars($total) ?> JOD</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">5 JOD</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5><?= htmlspecialchars($total + 5) ?> JOD</h5>
                        </div>
                        <a href="./checkout.php">
                            <button class="btn btn-block btn-primary bg-danger text-white font-weight-bold my-3 py-3" name="checkout">Proceed To Checkout</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->

    <?php include("../widgets/footer.php"); ?>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.adjust-quantity').on('click', function(e) {
                e.preventDefault();
                const action = $(this).data('action');
                const productId = $(this).data('product-id');
                const quantity = $(this).data('quantity');

                $.ajax({
                    type: 'POST',
                    url: '../user_pages/controllers/cartController.php',
                    data: {
                        action: action,
                        product_id: productId,
                        quantity: quantity
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>

    <!-- JavaScript Libraries -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>

</body>

</html>