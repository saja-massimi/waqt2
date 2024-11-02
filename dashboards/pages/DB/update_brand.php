<?php
include 'conn.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $brand_id = $data['brand_id'] ?? null;

    if ($brand_id) {
        $brand_name = $data['brand_name'] ?? null;
        $brand_img = null;

        if (isset($_FILES['brand_image']) && $_FILES['brand_image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
            $fileType = $_FILES['brand_image']['type'];

            if (in_array($fileType, $allowedTypes)) {
                $imageExtension = pathinfo($_FILES['brand_image']['name'], PATHINFO_EXTENSION);
                $newImageName = 'brand_' . date('Ymd_His') . '.' . $imageExtension; 
                $uploadPath = '../../assets/products_img/' . $newImageName;

                if (move_uploaded_file($_FILES['brand_image']['tmp_name'], $uploadPath)) {
                    $brand_img = $newImageName;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error moving the uploaded file.']);
                    exit;
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid image type.']);
                exit;
            }
        }

        $sql = "UPDATE brandname 
                SET brand_name = :brand_name" . ($brand_img ? ", brand_image = :brand_image" : "") . " 
                WHERE brand_id = :brand_id";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':brand_name', $brand_name);
            if ($brand_img) {
                $stmt->bindParam(':brand_image', $brand_img);
            }
            $stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);
            $stmt->execute();
            echo json_encode(['success' => true, 'message' => 'Brand updated successfully!']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'brand_id is required for updating the record.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
