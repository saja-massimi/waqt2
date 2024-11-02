<?php
include("./DB/conn.php"); 
include("./functions/getProduct.php");
include("./components/header.php");



$search =  $_POST["search"] ?? "";
$db = new Database($pdo); 
$watches = $db->getWatches($search);
$watchTable = new WatchTable($watches, '../assets/products_img/');


?>

<body class="g-sidenav-show bg-gray-100">
<?php
$parm = 'products';
include("./components/aside.php");
?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php
    $nav = 'Watches';
    include("./components/nav.php");
    ?>
    <div class="container-fluid py-4">
    <?php echo "<b>Your search: </b>".$search."<br><br>";?>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                  
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="myTable"  class=" table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Watch Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Brand</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Model</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Strap Material</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Edit</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $watchTable->render(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2" 
       style="background:linear-gradient(310deg, #17ad37 0%, #98ec2d 100%);" 
       onclick="showAddDialog()">
        <i class="fa fa-plus" aria-hidden="true"></i>
    </a>
</div>

<?php
include("./scripts/sweetalert_update.php");
include("./scripts/script_delete.php");
include("./scripts/script_add.php");
include("./scripts/sweetalert.php");
include("./scripts/aside_show_hide.php");
include("./scripts/pagenation.php");
?>








</body>
</html>
