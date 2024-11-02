<?php

class productsModel extends Dbh
{


    protected function getAllProducts($search = '')
    {
        $sql = "SELECT * FROM watches";
        if (!empty($search)) {
            $sql .= " WHERE watch_name LIKE :search OR watch_description LIKE :search";
        }

        $stmt = $this->connect()->prepare($sql);
        if (!empty($search)) {
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : [];
    }
    protected function getBrands()
    {
        $sql = "SELECT DISTINCT watch_brand FROM watches";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : [];
    }

    protected function getAllBrands()
    {

        $sql = "SELECT DISTINCT watch_brand FROM watches";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : [];
    }

    protected function getAllMaterials()
    {
        $sql = "SELECT DISTINCT strap_material FROM watches";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : [];
    }

    public function getAllProductsCount()
    {
        $sql = "SELECT COUNT(*) FROM watches";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchColumn();

        return $result ? $result : 0;
    }

    public function getProductById($id)
    {
        $sql = "SELECT * FROM watches WHERE watch_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : [];
    }
    

    
}
