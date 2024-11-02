<?php
include("./DB/conn.php"); 
include("./functions/getBrands.php");
include("./components/header.php");





?>

<body class="g-sidenav-show bg-gray-100">
<?php
$parm = 'brands';
include("./components/aside.php");
?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php
    $nav = 'Brands';
    include("./components/nav.php");
    ?>
    <div class="container-fluid py-4">
    
        

    <div class="col-12 mt-4">
          <div class="card mb-4">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-1">Brands</h6>
          
            </div>
            <div class="card-body p-3">
            <?php
            $search =  $_POST["search"] ?? "";

            echo "<b>Your search: </b>".$search."<br><br>";?>
              <div class="row">
                <?php

$tableRenderer = new BrandsTable($pdo, 'brandname', $search,'');
echo $tableRenderer->renderTable();
?>
                
                
                <div onclick="brand_add()" class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                  <div class="card h-100 card-plain border">
                    <div class="card-body d-flex flex-column justify-content-center text-center">
                      <a href="javascript:;">
                        <i class="fa fa-plus text-secondary mb-3"></i>
                        <h5 class=" text-secondary"> New project </h5>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


    </div>










        
</main>





<?php


include("./scripts/script_brand.php");
include("./scripts/sweetalert.php");
include("./scripts/aside_show_hide.php");
?>
</body>
</html>
