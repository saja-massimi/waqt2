<?php
class BrandsTable {
    private $pdo;
    private $table;
    private $search;

    // Constructor to initialize PDO, table, role, and search term
    public function __construct($pdo, $table, $search = '') {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->search = $search;

    }

    // Fetch records based on table, role, and optional search filter
    private function fetchRecords() {
  
        $query = "SELECT * FROM $this->table where is_deleted=0 ";

        // If a search term is provided, include the LIKE filter
        if (!empty($this->search)) {
            $query .= " AND brand_name LIKE :search";
        }

        $stmt = $this->pdo->prepare($query);
        

        // Bind the search term with wildcard for LIKE if it's provided
        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $stmt->bindParam(':search', $searchTerm);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to generate the HTML table
    public function renderTable() {
        $brands = $this->fetchRecords();
        $html='';
        foreach ($brands as $brand) {
        $html .= '
<div class="col-xl-3 col-md-6 mb-xl-0 mb-4 ">
                  <div class="card card-blog card-plain border  p-2">
                    <div class="position-relative">
                      <a class="d-block shadow-xl border-radius-xl ">
                        <img src="../assets/products_img/'. $brand['brand_image'] .'" alt="img-blur-shadow" class=" img-fluid shadow border-radius-xl">
                      </a>
                    </div>
                    <div class="card-body px-1 pb-0 ">
                      
                   
                        <h5 class="d-flex align-items-center justify-content-center">
                          '. $brand['brand_name'] .'
                        </h5>
                  
                      
                      <div class="d-flex align-items-center justify-content-evenly">
  <button type="button" class="badge badge-sm bg-gradient-success border-0" onclick="brand_Edit('. $brand['brand_id'] .',\''. $brand['brand_name'] .'\')">Edit</button>
  <button type="button" class="badge badge-sm bg-gradient-danger border-0" onclick="brand_delete('. $brand['brand_id'] .')">Delete</button>
</div>

                    </div>
                  </div>
                </div>


        ';
        }
        return $html;
    }
}
