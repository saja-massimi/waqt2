<?php
include("./DB/conn.php"); 
include("./components/header.php");

class Database {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo; 
    }

    public function getCoupons($search = '') {
        $query = "SELECT * FROM coupons WHERE is_deleted IN (0, 1)";
        if (!empty($search)) {
            $query .= " AND (coupon_value LIKE :search OR coupon_name LIKE :search OR start_date LIKE :search OR end_date LIKE :search)";
        }
        $stmt = $this->conn->prepare($query);

        if (!empty($search)) {
            $searchTerm = '%' . $search . '%';
            $stmt->bindParam(':search', $searchTerm);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function close() {
        $this->conn = null; 
    }
}

class CouponTable {
    private $coupons;
    private $title;
    private $start;
    private $end;

    public function __construct($coupons, $title) {
        $this->coupons = $coupons;
        $this->title = $title;
        $this->start = '<div class="col-12">
                <div class="card mb-4">
                    <div class="card-body px-4 pb-2">
                        <div class="table-container mb-4 ">
                            <h5>' . htmlspecialchars($this->title) . '</h5>
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Coupon Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Coupon Value</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Start Date</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">End Date</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usage Limit</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Edit</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>';
        $this->end = '</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>';
    }

    private function renderRow($row, $isDeleted = false, $isFinished = false) {
        echo "<tr>";
        echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>" . htmlspecialchars($row['coupon_name']) . "</p></td>";
        echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>" . htmlspecialchars($row['coupon_value']) . "</p></td>";
        echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>" . htmlspecialchars($row['start_date']) . "</p></td>";
        echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>" . htmlspecialchars($row['end_date']) . "</p></td>";
        echo "<td class='align-middle text-center'><span class='text-secondary text-xs font-weight-bold'>" . htmlspecialchars($row['created_at']) . "</span></td>";
        echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>" . htmlspecialchars($row['usage_limit']) . "</p></td>";

        if ($isDeleted) {
            echo "<td class='align-middle text-center' colspan='2'><span class='text-danger'>Deleted</span></td>";
        } elseif ($isFinished) {
            echo "<td class='align-middle text-center' colspan='2'><span class='text-danger'>Finished</span></td>";
        } else {
            echo "<td class='align-middle text-center'><button class='badge badge-sm bg-gradient-success border-0' onclick='showEditCouponDialog(\"{$row['coupon_id']}\", \"" . htmlspecialchars($row['coupon_value']) . "\", \"" . htmlspecialchars($row['start_date']) . "\", \"" . htmlspecialchars($row['end_date']) . "\", \"" . htmlspecialchars($row['usage_limit']) . "\")'>Edit</button></td>";
            echo "<td class='align-middle text-center'><button class='badge badge-sm bg-gradient-danger border-0' onclick='deleteCoupon(\"{$row['coupon_id']}\")'>Delete</button></td>";
        }
        echo "</tr>";
    }

    public function renderActive() {
        $currentDate = date('Y-m-d');
        echo $this->start;
        foreach ($this->coupons as $row) {
            if ($row['is_deleted'] == 0 && ($row['usage_limit'] > 0 && $row['end_date'] >= $currentDate)) {
                $this->renderRow($row);
            }
        }
        echo $this->end;
    }

    public function renderFinishedAndDeleted() {
        $currentDate = date('Y-m-d');
        echo $this->start;
        foreach ($this->coupons as $row) {
            if ($row['is_deleted'] == 1) {
                $this->renderRow($row, true);
            } elseif ($row['usage_limit'] == 0 || $row['end_date'] < $currentDate) {
                $this->renderRow($row, false, true);
            }
        }
        echo $this->end;
    }
}

$search = $_POST["search"] ?? "";
$db = new Database($pdo); 
$coupons = $db->getCoupons($search);
$couponTable = new CouponTable($coupons, "Active Coupons");
$couponTable1 = new CouponTable($coupons, "Expired Coupons");


?>

<body class="g-sidenav-show bg-gray-100">
<?php
$parm = 'coupons';
include("./components/aside.php");
?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php
    $nav = 'Coupons';
    include("./components/nav.php");
    ?>
    <div class="container-fluid py-4">
    <?php echo "<b>Your search: </b>" . htmlspecialchars($search) . "<br><br>";  ?>
        <div class="row">
            
            <?php $couponTable->renderActive(); ?>
            <?php $couponTable1->renderFinishedAndDeleted(); ?>
        </div>
    </div>
</main>
<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2" 
       style="background:linear-gradient(310deg, #17ad37 0%, #98ec2d 100%)" 
       onclick="showAddCouponDialog()">
        <i class="fa fa-plus" aria-hidden="true"></i>
    </a>
</div>

<?php

include("./scripts/sweetalert_update_coupon.php");
include("./scripts/script_delete_coupon.php");
include("./scripts/script_add_coupon.php");
include("./scripts/sweetalert.php");
include("./scripts/aside_show_hide.php");
include("./scripts/pagenation.php");
?>
</body>
</html>
