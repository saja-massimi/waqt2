<?php
include("./DB/conn.php");
include("./functions/getUsers.php");
include("./components/header.php");
?>
<body class="g-sidenav-show  bg-gray-100">
<?php
$parm = 'users';
include("./components/aside.php");

?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php
$nav = 'Users';
include("./components/nav.php");
?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
    <?php
    $searchTerm=$_POST["search"] ?? "";
$searchEmail=$user_email ?? "";
// Render the admin table with search filtering
echo "<b>Your search: </b>".$searchTerm."<br><br>";
$tableRendererAdmin = new UserTable($pdo, 'users', $user_role, $searchTerm,0,$searchEmail);
echo $tableRendererAdmin->renderTable("Your Account",1,$user_role);
if($user_role=="superAdmin"){
$tableRendererAdmin = new UserTable($pdo, 'users', 'admin', $searchTerm,0,"");
echo $tableRendererAdmin->renderTable("admin",1,$user_role);
}
// Render the customer table with search filtering
$tableRendererCustomer = new UserTable($pdo, 'users', 'customer', $searchTerm,0,"");
echo $tableRendererCustomer->renderTable("customer",0,$user_role);




    ?>
    </div>
  </main>
  <?php
include("./scripts/sweetalert.php");
include("./scripts/aside_show_hide.php");
include("./scripts/pagenation.php");
?>
 </body>
</html>