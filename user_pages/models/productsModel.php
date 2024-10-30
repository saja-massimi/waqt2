<?php

class productsModel extends Dbh
{


    protected function getAllProducts()
    {
        $sql = "SELECT * FROM watches";
        $stmt = $this->connect()->prepare($sql);
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
}
