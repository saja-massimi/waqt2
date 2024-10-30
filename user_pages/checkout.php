<?php require_once("../widgets/head.php"); ?>
<?php require_once("../widgets/navbar.php"); ?>

<?php

if (isset($_POST['checkout'])) {

    session_start();
    $user_id = $_SESSION['user'];

    if (!isset($user_id)) {
        header('Location: ../user_pages/login.php');
    }
    $orderModel = new orderModel();

    $profileModel = new profileModel();
    print_r($profileModel->getProfile($user_id));
}
?>

<div>
    Coupun Code
    <form class="mb-30" action="">
        <div class="input-group">
            <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
            <div class="input-group-append">
                <button class="btn btn-primary bg-danger text-white">Apply Coupon</button>
            </div>
        </div>
</div>

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>First Name</label>
                        <input class="form-control" type="text" placeholder="John">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Last Name</label>
                        <input class="form-control" type="text" placeholder="Doe">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>E-mail</label>
                        <input class="form-control" type="text" placeholder="example@email.com">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Mobile No</label>
                        <input class="form-control" type="text" placeholder="+123 456 789">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Line 1</label>
                        <input class="form-control" type="text" placeholder="123 Street">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Line 2</label>
                        <input class="form-control" type="text" placeholder="123 Street">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Country</label>
                        <select class="custom-select">
                            <option selected>United States</option>
                            <option>Afghanistan</option>
                            <option>Albania</option>
                            <option>Algeria</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>City</label>
                        <input class="form-control" type="text" placeholder="New York">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>State</label>
                        <input class="form-control" type="text" placeholder="New York">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>ZIP Code</label>
                        <input class="form-control" type="text" placeholder="123">
                    </div>
                    <div class="col-md-12 form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="newaccount">
                            <label class="custom-control-label" for="newaccount">Create an account</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="shipto">
                            <label class="custom-control-label" for="shipto" data-toggle="collapse" data-target="#shipping-address">Ship to different address</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse mb-5" id="shipping-address">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Shipping Address</span></h5>
                <div class="bg-light p-30">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" placeholder="John">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" placeholder="Doe">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" placeholder="example@email.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" placeholder="+123 456 789">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input class="form-control" type="text" placeholder="123 Street">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" type="text" placeholder="123 Street">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <select class="custom-select">
                                <option selected>United States</option>
                                <option>Afghanistan</option>
                                <option>Albania</option>
                                <option>Algeria</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input class="form-control" type="text" placeholder="New York">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <input class="form-control" type="text" placeholder="New York">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input class="form-control" type="text" placeholder="123">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom">
                    <h6 class="mb-3">Products</h6>
                    <div class="d-flex justify-content-between">
                        <p>Product Name 1</p>
                        <p>$150</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Product Name 2</p>
                        <p>$150</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Product Name 3</p>
                        <p>$150</p>
                    </div>
                </div>
                <div class="border-bottom pt-3 pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6>$150</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium">$10</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5>$160</h5>
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Payment</span></h5>
                <div class="bg-light p-30">
                    <div class="form-group">
                        <div class="">
                            <button type="button" class="btn btn-primary bg-warning text-white font-weight-bold my-2 py-3 w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">Paypal</button>
                            <?php include "paymentvalid.php" ?>
                            <!-- Modal for PayPal Payment -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100 text-warning bg-dark" id="exampleModalLabel " style="color: yellow; font-weight: 800;">
                    PayPal Payment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="paymentForm" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" id="typeText" name="cardNumber" class="form-control" minlength="16" maxlength="16" placeholder="Card Number" required>
                        <small style="color:red;"><?= $errors['cardNumber'] ?? ''; ?></small>
                    </div>
                    <div class="mb-3">
                        <input type="text" id="typeName" name="nameOnCard" class="form-control" placeholder="Name on Card" required>
                        <small style="color:red;"><?= $errors['nameOnCard'] ?? ''; ?></small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" id="typeExp" name="expiration" class="form-control" minlength="5" maxlength="7" placeholder="Expiration (MM/YY)" required>
                            <small style="color:red;"><?= $errors['expiration'] ?? ''; ?></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="password" id="typeCvv" name="cvv" class="form-control" minlength="3" maxlength="3" placeholder="CVV" required>
                            <small style="color:red;"><?= $errors['cvv'] ?? ''; ?></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-warning text-white " data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary bg-danger text-white" name="submitBtn">Submit Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<div class="form-group">
    <div class="custom-control">
        <button type="button" class="btn btn-primary font-weight-bold  bg-danger text-white">Paypal</button>
        <button class="btn btn-primary font-weight-bold  bg-danger text-white">Place Order</button>

    </div>
</div>
</div>

</div>
</div>





<?php include("../widgets/footer.php"); ?>