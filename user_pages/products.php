<!DOCTYPE html>
<html lang="en">

<?php
require_once '../user_pages/models/dbh.php';
require_once '../user_pages/models/productsModel.php';
require_once '../user_pages/controllers/productsController.php';
$searchQuery = $_POST['search'] ?? "";

$products = new productsController();
$allProducts = $products->showAllProducts($searchQuery);
$brands = $products->AllBrands();
$materials = $products->AllMaterials();
$count = $products->getAllProductsCount();

$cat = $_GET['category'] ?? null;


?>

<?php include("../widgets/head.php"); ?>
<?php include("../widgets/chatbot-css.php"); ?>

<style>
    .product-item.list-view {
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 10px;
    }

    .product-item.list-view .product-img {
        width: 30%;
        margin-right: 20px;
    }

    .product-item.list-view .text-center a {
        font-size: 0.7em;
    }

    .product-item.list-view .text-center {
        text-align: left;
        width: 70%;

    }

    .product-item.list-view .d-flex {
        flex-direction: column;
        align-items: flex-start;
    }

    .product-item.list-view .product-action {
        margin-top: 10px;
    }
</style>

<body>


    <!-- Navbar Start -->
    <?php include("../widgets/navbar.php"); ?>
    <!-- Navbar End -->


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30 d-flex justify-content-between align-items-center">

                    <div class=" d-flex justify-content-between">
                        <a class="breadcrumb-item text-dark" href="./index.php">Home</a>
                        <span class="breadcrumb-item active">Watches List</span>
                    </div>
                    <form class="d-flex" action="" method="post">
                        <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-dark" type="submit" name="submit_search">Search</button>
                    </form>
                </nav>
            </div>
        </div>
    </div>

    <!-- Breadcrumb End -->


    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">

            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4" id="sidebar">

                <!-- Price Filter Start -->
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class=" pr-3">Filter by price</span>
                </h5>

                <div class="bg-light p-4 mb-30">
                    <div class="slider-label">Price: <span id="priceRangeValue">300 JD</span></div>
                    <input type="range" class="form-range" name="priceRange" id="priceRange" min="0" max="1000" value="300" step="10">
                    <input type="hidden" id="count" value=<?= $count ?>>
                </div>

                <!-- Price Filter End -->

                <!-- Category Filter Start -->
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class="pr-3">Filter by Category</span>
                </h5>
                <div class="bg-light p-4 mb-30">
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" name="category[]" class="custom-control-input" id="all" value="" <?php echo empty($cat) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="all">All Categories</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" name="category[]" class="custom-control-input" id="women" value="female" <?php echo $cat === 'women' ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="women">Women</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" name="category[]" class="custom-control-input" id="men" value="male" <?php echo $cat === 'men' ? 'checked' : ''; ?>>

                        <label class="custom-control-label" for="men">Men</label>
                    </div>
                </div>
                <!-- Category Filter End -->


                <!-- Brand Filter Start -->
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class=" pr-3">Filter by brand</span>
                </h5>
                <div class="bg-light p-4 mb-30">

                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" name="brand[]" class="custom-control-input" id="allBrands" value="all" checked>
                        <label class="custom-control-label" for="allBrands">All Brands</label>
                    </div>
                    <?php foreach ($brands as $brand): ?>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" name="brand[]" class="custom-control-input" id="<?php echo $brand['watch_brand']; ?>" value="<?php echo $brand['watch_brand']; ?>">
                            <label class="custom-control-label" for="<?php echo $brand['watch_brand']; ?>"><?php echo $brand['watch_brand']; ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Brand Filter End -->

                <!-- Strap Material Filter Start -->
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class=" pr-3">Filter by Strap Material</span>
                </h5>
                <div class="bg-light p-4 mb-30">

                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" name="material[]" class="custom-control-input" id="allMaterials" value="all" checked>
                        <label class="custom-control-label" for="allMaterials">All Materials</label>
                    </div>
                    <?php foreach ($materials as $material): ?>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" name="material[]" class="custom-control-input" id="<?php echo $material['strap_material']; ?>" value="<?php echo $material['strap_material']; ?>">
                            <label class="custom-control-label" for="<?php echo $material['strap_material']; ?>"><?php echo $material['strap_material']; ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Strap Material Filter End -->



            </div>
            <!-- Shop Sidebar End -->



            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">

                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <button class="btn btn-sm btn-light" id="show_normal"><i class="fa fa-th-large"></i></button>
                                <button class="btn btn-sm btn-light ml-2" id="show_line"><i class="fa fa-bars"></i></button>
                                <?= "Your Search: " . $searchQuery; ?>
                                <input type="hidden" id="search_result" value="<?= $searchQuery ?>">
                            </div>

                            <div class="ml-2">
                                <div class="btn-group ">
                                    <button type="button" id="sortButton" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Sort By</button>
                                    <div class="dropdown-menu dropdown-menu-right" id="sort">
                                        <a class="dropdown-item" href="#" data-sort="latest">Latest</a>
                                        <a class="dropdown-item" href="#" data-sort="oldest">Oldest</a>
                                        <a class="dropdown-item" href="#" data-sort="high">Highest Price</a>
                                        <a class="dropdown-item" href="#" data-sort="low">Lowest Price</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="productList" class="row">
                    </div>

                    <div class="col-12">
                        <nav>
                            <ul class="pagination justify-content-center" id="pagination">

                                <li class="page-item disabled"><a class="page-link" href="#">Previous</span></a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->


        </div>
    </div>
    <!-- Shop End -->



    <?php include("../widgets/chatbot.php"); ?>
    <!-- Footer Start -->
    <?php include '../widgets/footer.php'; ?>
    <!-- Footer End -->

    <script src="./fliteringProducts.js"></script>
    <script src="./addToCart.js"></script>


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>



    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../js/main.js"></script>
    <?php include("./chatbot.php"); ?>

</body>

</html>