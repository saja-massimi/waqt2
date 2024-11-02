<?php
include("./DB/conn.php");
include("./functions/getStatistics.php");
include("./components/header.php");
?>
<body class="g-sidenav-show  bg-gray-100">
<?php
$parm = 'dashboard';
include("./components/aside.php");

?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php
$nav = 'Dashboard';
include("./components/nav.php");
?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        
      <?php
$table = 'orders'; 
$column = 'order_total';
$operation="SUM";
$statistics = new Statistics($pdo, $table, $column);
$count = $statistics->getCount("is_deleted = 0",$operation);
echo $statistics->renderStatisticsCard("Total Sales", "fas fa-dollar-sign", $count);


$table = 'users'; 
$column = 'user_id';
$operation="Count";
$statistics = new Statistics($pdo, $table, $column);
$count = $statistics->getCount("role = 'customer' AND isDeleted = 0",$operation);
echo $statistics->renderStatisticsCard("Customers", "fas fa-users", $count);

$table = 'orders'; 
$column = 'order_id';
$operation="Count";
$statistics = new Statistics($pdo, $table, $column);
$count = $statistics->getCount("is_deleted = 0",$operation);
echo $statistics->renderStatisticsCard("Orders", "fas fa-clipboard-list", $count);

$table = 'watches'; 
$column = 'watch_id';
$operation="Count";
$statistics = new Statistics($pdo, $table, $column);
$count = $statistics->getCount("is_deleted = 0",$operation);
echo $statistics->renderStatisticsCard("Products", "fas fa-box", $count);




      ?>
        
      
        
      </div>
     
      <div class="row mt-4">
        <div class="col-lg-5 mb-lg-0 mb-4">
        <div class="card ">
            <div class="card-header pb-0">
              <h6>Customers Governorates</h6>
              
            </div>
            <div class="card-body p-3">
            <?php
$statistics = new Statistics($pdo, 'users', 'user_id');

// Chart parameters
$chartId = 'myChart';
$title = 'User Address Distribution';
$backgroundColors = ['#b91d47', '#00aba9', '#2b5797', '#e8c3b9', '#1e7145'];

// Render and display the chart script
echo $statistics->renderChartScript($chartId, $title, $backgroundColors);
echo '<canvas id="myChart" style="max-width:350px;max-height:350px;" ></canvas>';
                     ?>
            </div>
          </div>
        </div>
       <div class="col-lg-7">
    <div class="card z-index-2">
        <div class="card-header pb-0">
            <h6>Sales Overview</h6>
        </div>
        <div class="card-body p-3">
            <div class="chart">
                <?php
                // Create an instance of Statistics
                $statistics = new Statistics($pdo, 'users', 'user_id');

                // Render and display the doughnut chart script
                $chartId = 'myChart';
                $title = 'Users Address Distribution';
                $backgroundColors = ["#b91d47", "#00aba9", "#2b5797", "#e8c3b9", "#1e7145"];
                echo $statistics->renderChartScript($chartId, $title, $backgroundColors);

                // Output the canvas for the line chart
                echo "<canvas id='chart-liness' class='chart-canvas' height='350'></canvas>";

                // Call the show method to get monthly sales data
                
$statisticss = new Statistics($pdo, 'orders', 'order_total');



                $lineChartId = 'chart-liness';
                echo $statisticss->renderLineChartScript($lineChartId);
                ?>
            </div>
        </div>
    </div>
</div>




 
     
      
    </div>
  </main>
 <?php
 include("./scripts/aside_show_hide.php");
 include("./scripts/pagenation.php");

 ?>
</body>
</html>