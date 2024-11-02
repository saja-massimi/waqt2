<?php


class productsController extends productsModel
{
    public function showAllProducts($search = '')
    {
        $results = $this->getAllProducts($search);

        if (!empty($results)) {
            return $results;
        } else {
            return "No products found.";
        }
    }

    public function AllBrands()
    {

        $results = $this->getAllBrands();

        if (!empty($results))
            return $results;
        else
            return "No Brands found.";
    }


    public function AllMaterials()
    {
        $results = $this->getAllMaterials();

        if (!empty($results)) {
            return $results;
        } else {
            return "No Material found.";
        }
    }

    public function getAllProductsCount()
    {
        $results = $this->getAllProducts();

        if (!empty($results)) {
            return count($results);
        } else {
            return "No products found.";
        }
    }

    public function productByID($id)
    {
        $results = $this->getProductById($id);

        if (!empty($results)) {
            return $results;
        } else {
            return "No product found.";
        }
    }
}
