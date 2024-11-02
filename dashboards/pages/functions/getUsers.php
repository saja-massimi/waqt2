<?php
class UserTable {
    private $pdo;
    private $table;
    private $role;
    private $search;
    private $state;
    private $condition;
    // Constructor to initialize PDO, table, role, and search term
    public function __construct($pdo, $table, $role, $search = '',$state=0,$condition='') {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->role = $role;
        $this->search = $search;
        $this->state = $state;
        $this->condition = $condition;
    }

    // Fetch records based on table, role, and optional search filter
    private function fetchRecords() {
        if($this->condition !=''){
            $this->condition =" AND user_email='".$this->condition."'";
            
        }
        $query = "SELECT * FROM $this->table WHERE role = :role AND isDeleted = $this->state $this->condition";

        // If a search term is provided, include the LIKE filter
        if (!empty($this->search)) {
            $query .= " AND (
                user_name LIKE :search OR 
                user_email LIKE :search OR 
                user_phoneNum LIKE :search OR 
                user_address LIKE :search OR
                user_createdDate LIKE :search
            )";
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':role', $this->role);

        // Bind the search term with wildcard for LIKE if it's provided
        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $stmt->bindParam(':search', $searchTerm);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to generate the HTML table
    public function renderTable($title,$flag,$account_role) {
        $users = $this->fetchRecords();
        
        $html = '
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>' . $title . ' users</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Names</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Creation</th>
                                        
                                       '.(($account_role=="superAdmin" && $this->condition =='') ? ' <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>' : '').'
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Edit</th>
                                        ' . (($this->condition =='') ? 
                                    '<th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Delete</th>' : '') . '
                                    </tr>
                                </thead>
                                <tbody>';

        foreach ($users as $user) {
            $html .= '
                                    <tr id="' . $user['user_email'] . '">
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">' . $user['user_name'] . '</h6>
                                                    <p class="text-xs text-secondary mb-0">' . $user['user_email'] . '</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">' . ($user['user_phoneNum'] ?? 'not added') . '</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">' . ($user['user_address'] ?? 'not added') . '</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">' . $user['user_createdDate'] . '</span>
                                        </td>
                                      
                                        
                                          
                                    ' . (($account_role == "superAdmin" && $this->condition =='') ? 
    '<td class="align-middle text-center form-switch">
        <input class="form-check-input ms-auto" type="checkbox" ' . 
        (($flag == 1) ? 'checked ' : '') . 
        'onchange="handleRoleChange(this, \'' . $user['user_email'] . '\')">
    </td>' : '') . '
                                


                                        <td class="align-middle text-center">
                                            <button onclick="UpdateRecord(\'' . $user['user_phoneNum'] . '\',\'' . $user['user_address'] . '\',\'' . $user['user_email'] . '\');" class="badge badge-sm bg-gradient-success border-0">
                                                Edit
                                            </button>
                                        </td>';
                                        if ($this->condition == '') {
                                        $html .= '
                                        <td class="align-middle text-center">
                                            <button onclick="deleteRecord(\'' . $user['user_email'] . '\');" class="badge badge-sm bg-gradient-danger border-0">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>';
                                        }
        }

        $html .= '
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }
}
