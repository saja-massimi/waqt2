<!DOCTYPE html>
<html lang="en">

<?php require_once("../widgets/head.php"); ?>


<body>


    <?php
    require_once("../widgets/navbar.php");
    require_once('./models/Dbh.php');
    require_once('./models/profileModel.php');
    require_once('./models/orderModel.php');
    require_once('./models/couponModel.php');
    ?>

    <?php

    $user_id = $_SESSION['user'];

    if (!isset($user_id)) {
        header('Location: ../user_pages/login.php');
    }

    //get Profile Data from user
    $profileModel = new profileModel();
    $userData = $profileModel->getProfile($user_id);

    $firstname = explode(' ', $userData['user_name'])[0];
    $lastname = explode(' ', $userData['user_name'])[1];

    if ($userData['user_street'] == '' || $userData['user_country'] == '' || $userData['user_city'] == '') {
        echo "<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        Swal.fire({
            title: 'Incomplete Profile',
            text: 'Please fill all the address fields before proceeding.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-success',  // Green OK button
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './customer_profile.php'; 
            }
        });
    });
  </script>";
    }

    $orderModel = new orderModel();
    $currOrder = $orderModel->getCurrentOrder($user_id);

    $total = 0;
    $couponModel = new CouponModel();;

    ?>



    <div class="container-fluid">

        <div class="row">

            <!-- Shpiping Address -->
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class=" pr-3">Billing Address</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" placeholder="First Name" value="<?= $firstname ?>" readonly>
                            <input type="hidden">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" placeholder="Last Name" value="<?= $lastname ?>" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" placeholder="example@email.com" value="<?= $userData['user_email'] ?>" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" placeholder="+123 456 789" value="<?= $userData['user_phoneNum'] ?>" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Street</label>
                            <input class="form-control" type="text" placeholder="123 Street" readonly value="<?= $userData['user_street'] ?>" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <input class="form-control" type="text" placeholder="country" readonly value="<?= $userData['user_country'] ?>">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <select class="custom-select" disabled>
                                <option value="irbid" <?= $userData['user_city'] == 'irbid' ? 'selected' : '' ?>>Irbid</option>
                                <option value="jarash" <?= $userData['user_city'] == 'jarash' ? 'selected' : '' ?>>Jarash</option>
                                <option value="ajloun" <?= $userData['user_city'] == 'ajloun' ? 'selected' : '' ?>>Ajloun</option>
                                <option value="aqaba" <?= $userData['user_city'] == 'aqaba' ? 'selected' : '' ?>>al-'Aqaba</option>
                                <option value="madaba" <?= $userData['user_city'] == 'madaba' ? 'selected' : '' ?>>Madaba</option>
                                <option value="mafraq" <?= $userData['user_city'] == 'mafraq' ? 'selected' : '' ?>>al-Mafraq</option>
                                <option value="zarqa" <?= $userData['user_city'] == 'zarqa' ? 'selected' : '' ?>>al-Zarqa</option>
                                <option value="amman" <?= $userData['user_city'] == 'amman' ? 'selected' : '' ?>>Amman</option>
                                <option value="balqa" <?= $userData['user_city'] == 'balqa' ? 'selected' : '' ?>>al-Balqa</option>
                                <option value="karak" <?= $userData['user_city'] == 'karak' ? 'selected' : '' ?>>al-Karak</option>
                                <option value="tafileh" <?= $userData['user_city'] == 'tafileh' ? 'selected' : '' ?>>al-Tafilah</option>
                                <option value="maan" <?= $userData['user_city'] == 'maan' ? 'selected' : '' ?>>Ma'an</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="details">Additional Directions</label>
                            <textarea class="form-control" id="details" rows="3"></textarea>
                        </div>

                        <div class="col-md-12">

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="shipToDifferentAddress">
                                <label class="custom-control-label" for="shipToDifferentAddress">Ship to different address</label>
                            </div>

                            <div id="additionalAddressFields" class="mt-3"></div>



                        </div>
                    </div>
                </div>

            </div>

            <!-- Order Total -->
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="pr-3">Order Total</span></h5>
                <div id="coupon">
                    Coupon Code
                    <form class="mb-30" action="./controllers/couponController.php" method="POST" id="couponForm">
                        <div class="input-group">
                            <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code" name="coupon_code" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary bg-danger text-white" name="coupon">Apply Coupon</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="bg-light p-30 mb-5">
                    <h6 class='mb-3'>Products</h6>

                    <?php

                    foreach ($currOrder as $order) {
                        $total += $order['watch_price'] * $order['quantity'];
                    ?>
                        <div class='border-bottom'>
                            <div class='d-flex justify-content-between'>
                                <p style="font-size: 0.8rem;"> <?= $order['quantity']; ?> X </p>
                                <p style="font-size: 0.9rem;"><?= $order['watch_name'] ?></p>
                                <p style="font-size: 0.8rem;"><?= $order['watch_price'] * $order['quantity']; ?> JOD</p>

                            </div>
                        <?php } ?>
                        </div>

                        <div class="border-bottom pt-3 pb-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Subtotal</h6>
                                <h6><?= $total  ?> JOD</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <h6 class="font-weight-medium">5 JOD</h6>
                            </div>

                            <?php  ?>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium" name="copoun"></h6>
                                <h6 class="font-weight-medium" name="copoun_value"></h6>
                            </div>
                        </div>


                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <?php

                                ?>
                                <h5>Total</h5>
                                <h5 name="total" id="cartTotalItems"><?= $total + 5 ?> JOD</h5>

                            </div>
                        </div>
                </div>




                <div class="mb-5">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class=" pr-3">Payment</span></h5>

                    <div class="bg-light p-30">
                        <div class="form-group">
                            <!--Cash on delivery option-->


                            <form id="orderForm" method="POST">
                                <input type="hidden" name="order_user" value="<?= $user_id ?>">
                                <input type="hidden" name="order_total" value="<?= $total + 5 ?>">
                                <input type="hidden" name="order_address" value="<?= $userData['user_street'] . ', ' . $userData['user_city'] . ', ' . $userData['user_country'] ?>">
                                <input type="hidden" name="order_status" value="pending">
                                <input type="hidden" name="additional_address" value="">
                                <button type="submit" class="btn btn-success font-weight-bold  bg-success text-white w-100" name="order">Place Order</button>
                            </form>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>



    <!-- Bootstrap JS (including Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <script src="./checkout.js"></script>
</body>

</html>