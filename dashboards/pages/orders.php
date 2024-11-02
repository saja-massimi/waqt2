<?php
include("./DB/conn.php"); 
include("./components/header.php");

class Database {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo; 
    }

    public function getOrders($search = '') {
        $query = "
            SELECT o.order_id, u.user_name, u.user_email, u.user_phoneNum, o.order_total, o.order_status, o.is_deleted
            FROM orders o
            JOIN users u ON o.user_id = u.user_id 
            WHERE o.is_deleted IN (0, 1)
        ";

        if (!empty($search)) {
            $query .= " AND (o.order_id LIKE :search OR u.user_name LIKE :search OR u.user_email LIKE :search)";
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

class OrderTable {
    private $orders;

    public function __construct($orders) {
        $this->orders = $orders;
    }

    public function renderShippedAndPending() {
        foreach ($this->orders as $row) {
            if ($row['order_status'] === 'shipped' || $row['order_status'] === 'pending') {
                echo "<tr>";
                echo "<td class='align-middle text-center'>{$row['order_id']}</td>";
                echo "<td class='align-middle text-center'>{$row['user_name']}</td>";
                echo "<td class='align-middle text-center'>{$row['user_email']}</td>";
                echo "<td class='align-middle text-center'>{$row['user_phoneNum']}</td>";
                echo "<td class='align-middle text-center'>{$row['order_total']}</td>";
                echo "<td class='align-middle text-center'><span class='badge " . $this->getStatusClass($row['order_status']) . "'>{$row['order_status']}</span></td>";
                echo "<td class='align-middle text-center'><button class='badge badge-sm bg-gradient-info border-0' onclick='viewOrder({$row['order_id']})'>View</button></td>";
                
                // Display buttons for edit and delete based on order status
                if ($row['order_status'] === 'shipped' || $row['order_status'] === 'pending') {
                    echo "<td class='align-middle text-center'><button class='badge badge-sm bg-gradient-success border-0' onclick='showEditOrderDialog(\"{$row['order_id']}\", \"{$row['order_status']}\")'>Edit State</button></td>";
                    echo "<td class='align-middle text-center'><button class='badge badge-sm bg-gradient-danger border-0' onclick='deleteOrder({$row['order_id']})'>Delete</button></td>";
                } else {
                    echo "<td class='align-middle text-center'></td>";
                    echo "<td class='align-middle text-center'></td>"; 
                }

                echo "</tr>";
            }
        }
    }

    public function renderDeliveredAndCanceled() {
        foreach ($this->orders as $row) {
            if ($row['order_status'] === 'delivered' || $row['order_status'] === 'canceled') {
                echo "<tr>";
                echo "<td class='align-middle text-center'>{$row['order_id']}</td>";
                echo "<td class='align-middle text-center'>{$row['user_name']}</td>";
                echo "<td class='align-middle text-center'>{$row['user_email']}</td>";
                echo "<td class='align-middle text-center'>{$row['user_phoneNum']}</td>";
                echo "<td class='align-middle text-center'>{$row['order_total']}</td>";
                echo "<td class='align-middle text-center'><span class='badge " . $this->getStatusClass($row['order_status']) . "'>{$row['order_status']}</span></td>";
                echo "<td class='align-middle text-center'><button class='badge badge-sm bg-gradient-info border-0' onclick='viewOrder({$row['order_id']})'>View</button></td>";
               
                echo "</tr>";
            }
        }
    }

    private function getStatusClass($status) {
        switch ($status) {
            case 'pending':
                return 'bg-warning text-white';
            case 'shipped':
                return 'bg-info text-white';
            case 'delivered':
                return 'bg-success text-white';
            case 'canceled':
                return 'bg-danger text-white';
            default:
                return '';
        }
    }
}

$search = $_POST["search"] ?? "";
$db = new Database($pdo); 
$orders = $db->getOrders($search);
$orderTable = new OrderTable($orders);
?>

<body class="g-sidenav-show bg-gray-100">
<?php
$parm = 'orders'; 
include("./components/aside.php");
?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php
    $nav = 'Orders'; 
    include("./components/nav.php");
    ?>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body px-4 pt-0 pb-2">
                        <div class="table-responsive p-0">
                        <h5 class="mt-3 ml-3">Pending And Shipped Order</h5>
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Email</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Phone</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">View</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Edit</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $orderTable->renderShippedAndPending(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body px-4 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <h5 class="mt-3 ml-3">Delivered And Canceled Order</h5>
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Email</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Phone</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">View</th>
                                        
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $orderTable->renderDeliveredAndCanceled(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<?php
include("./scripts/script_view.php");
include("./scripts/sweetalert_update_order.php");
include("./scripts/script_delete_order.php");
include("./scripts/aside_show_hide.php");
include("./scripts/pagenation.php");
?>

</body>
</html>
