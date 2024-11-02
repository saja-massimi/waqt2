<?php
class contactTable {
    private $pdo;
    private $table;
    private $search;
    
    // Constructor to initialize PDO, table, role, and search term
    public function __construct($pdo, $table,$search = '') {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->search = $search;
        
    }

    // Fetch records based on table, role, and optional search filter
    private function fetchRecords() {
        $query = "SELECT * FROM $this->table ";

        // If a search term is provided, include the LIKE filter
        if (!empty($this->search)) {
            $query .= "
                WHERE name LIKE :search OR 
                email LIKE :search OR 
                subject LIKE :search OR 
                message LIKE :search OR
                created_at LIKE :search
            ";
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
        $contacts = $this->fetchRecords();
        
        $html = '
        
         <div class="col-12 col-xl-6 mt-3">
          <div class="card h-100">
            <div class="card-header pb-0">
              <h6>Contact form Messages</h6>
              <b>Your search: </b>'.$this->search.'<br>
            </div>
            <div class="card-body p-3">
              

              ';
              foreach ($contacts as $contact) {
              $html .='
              <div class="timeline timeline-one-side">
                <div class="timeline-block mb-3">

                  <div class="timeline-content">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">'.$contact['id'].') '. $contact['subject'] .' - '. $contact['email'].'</h6>
                    <p class="text-secondary font-weight-bold  mt-1 mb-0">From: '. $contact['name'] .'</p>
                    <p class="text-dark text-sm font-weight-bold mb-0">'. nl2br($contact['message']).'</p>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">'. $contact['created_at'] .'</p>
                  </div>
                </div>
                 </div>
                ';
              }
                $html.='
               
             
            </div>
          </div>
        </div>
        
       
        
      </div>';




        return $html;
    }
}
