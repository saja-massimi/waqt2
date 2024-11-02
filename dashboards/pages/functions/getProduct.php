<?php
class Database {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo; 
    }

    public function getWatches($search = '') {
        $query = "SELECT * FROM watches WHERE is_deleted = 0";
        if (!empty($search)) {
            $query .= " AND ( watch_name LIKE :search OR 
            watch_description LIKE :search OR 
            watch_price LIKE :search OR 
            watch_category LIKE :search OR 
            watch_brand LIKE :search OR 
            quantity LIKE :search OR 
            watch_model LIKE :search OR 
            strap_material LIKE :search OR 
            created_at LIKE :search)";
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

class WatchTable {
    private $watches;
    private $imageBaseUrl;

    public function __construct($watches, $imageBaseUrl) {
        $this->watches = $watches;
        $this->imageBaseUrl = $imageBaseUrl;
    }

    public function render() {
        if ($this->watches) {
            foreach ($this->watches as $row) {
                echo "<tr>";
                echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>{$row['watch_name']}</p></td>";
                echo "<td><p class='text-xs font-weight-bold mb-0' style='white-space: nowrap; width: 100px; overflow: hidden;text-overflow: ellipsis; '>{$row['watch_description']}</p></td>";
                echo "<td class='align-middle text-center text-sm'><p class='text-xs font-weight-bold mb-0'>{$row['watch_price']}</p></td>";
                echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>{$row['watch_category']}</p></td>";
                echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>{$row['quantity']}</p></td>";
                echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>{$row['watch_brand']}</p></td>";
                echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>{$row['watch_model']}</p></td>";
                echo "<td class='align-middle text-center'><p class='text-xs font-weight-bold mb-0'>{$row['strap_material']}</p></td>";
                echo "<td class='align-middle text-center'><img src='{$this->imageBaseUrl}{$row['watch_img']}' alt='Watch Image' style='width: 50px; height: auto;'></td>";
                echo "<td class='align-middle text-center'><span class='text-secondary text-xs font-weight-bold'>{$row['created_at']}</span></td>";
                echo "<td class='align-middle text-center'><button class='badge badge-sm bg-gradient-success border-0' onclick='showEditDialog(\"{$row['watch_id']}\", \"{$row['watch_name']}\", \"{$row['watch_description']}\", \"{$row['watch_price']}\", \"{$row['watch_category']}\", \"{$row['watch_brand']}\", \"{$row['watch_model']}\", \"{$row['strap_material']}\", \"{$this->imageBaseUrl}{$row['watch_img']}\", \"{$row['quantity']}\")'>Edit</button></td>";
                echo "<td class='align-middle text-center'><button class='badge badge-sm bg-gradient-danger border-0' onclick='deleteWatch(\"{$row['watch_id']}\")'>Delete</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11' class='text-center'>No watches found</td></tr>";
        }
    }
}
?>