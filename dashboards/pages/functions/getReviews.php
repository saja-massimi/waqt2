<?php
class ReviewTable {
    private $pdo;
    private $table;
    private $search;

    public function __construct($pdo, $table, $search = '') {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->search = $search;
    }

    private function fetchRecords() {
        $query = "SELECT r.*, w.watch_name FROM $this->table r 
                  LEFT JOIN watches w ON r.watch_id = w.watch_id"; 

        if (!empty($this->search)) {
            $query .= " WHERE (
                r.user_email LIKE :search OR 
                r.review_text LIKE :search OR 
                r.created_at LIKE :search OR 
                r.rating LIKE :search
            )";
        }

        $stmt = $this->pdo->prepare($query);

        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $stmt->bindParam(':search', $searchTerm);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function renderTable() {
        $reviews = $this->fetchRecords();

        $html = '
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Reviews</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Review ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Email</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Review Text</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rating</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Watch Name</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>';

        foreach ($reviews as $review) {
            $watchName = !empty($review['watch_name']) ? htmlspecialchars($review['watch_name']) : 'N/A';
            $html .= '
                                    <tr id="' . htmlspecialchars($review['review_id']) . '">
                                        <td class="align-middle text-center">' . htmlspecialchars($review['review_id']) . '</td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">' . htmlspecialchars($review['user_email']) . '</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">' . htmlspecialchars($review['review_text']) . '</p>
                                        </td>
                                        <td class="align-middle text-center">';

            $rating = (int) htmlspecialchars($review['rating']);
            for ($i = 1; $i <= 5; $i++) {
                $html .= $i <= $rating ? '⭐' : '☆';
            }

            $html .= '</td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">' . $watchName . '</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">' . htmlspecialchars($review['created_at']) . '</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button onclick="confirmDelete(' . htmlspecialchars($review['review_id']) . ');" class="badge badge-sm bg-gradient-danger border-0">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>';
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
?>
