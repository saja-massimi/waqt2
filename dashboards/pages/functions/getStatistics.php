<?php
class Statistics {
    private $pdo;
    private $table;
    private $column;

    public function __construct($pdo, $table, $column) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->column = $column;
    }

    // Method to count rows based on a condition
    public function getCount($condition = '1=1',$operation="Count") {
        $query = "SELECT $operation($this->column) as count FROM $this->table WHERE $condition";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    // Method to generate the HTML card with statistics count
    public function renderStatisticsCard($title, $icon, $count) {
        return '
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">' . htmlspecialchars($title) . '</p>
                    <h5 class="font-weight-bolder mb-0">
                      ' . $count . '
                     
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="' . htmlspecialchars($icon) . ' text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>';
    }





   //start charts methods

   // Method to generate data for chart
   public function getChartData($labelColumn = 'user_address') {
    $query = "SELECT $labelColumn AS label, COUNT(user_id) AS value FROM $this->table WHERE role='customer' GROUP BY $labelColumn";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $labels = array_column($data, 'label');
    $values = array_column($data, 'value');

    return ['labels' => $labels, 'values' => $values];
}

// Method to render chart JavaScript
public function renderChartScript($chartId, $title, $backgroundColors) {
    $chartData = $this->getChartData();
    $labels = json_encode($chartData['labels']);
    $values = json_encode($chartData['values']);
    $colors = json_encode($backgroundColors);

    return "
    <script>
        var ctx = document.getElementById('$chartId');
        if (Chart.getChart('$chartId')) { // Check if a chart is already created
            Chart.getChart('$chartId').destroy(); // Destroy the existing chart
        }
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: $labels,
                datasets: [{
                    backgroundColor: $colors,
                    data: $values
                }]
            },
            options: {
                title: {
                    display: true,
                    text: '$title'
                }
            }
        });
    </script>";
}



    
// Method to get line chart data
public function getLineChartData() {
    
    $monthlySales = [];
    $currentYear = date('Y'); 

    
    for ($month = 1; $month <= 12; $month++) {
    
        $condition = "YEAR(created_at) = '$currentYear' AND MONTH(created_at) = '$month'";

        
        $monthlySales[] = $this->getCount($condition, "SUM");
    }

    return [
        'labels' => ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        'datasets' => [
            [
                'label' => 'Total Sales',
                'data' =>  $monthlySales,
                'borderColor' => '#cb0c9f',
                'tension' => 0.4,
                'borderWidth' => 3,
                'fill' => true,
            ]
        ]
    ];
}





// Method to render line chart JavaScript
public function renderLineChartScript($chartId) {
    $chartData = json_encode($this->getLineChartData());

    return "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('$chartId').getContext('2d');
            const gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);
            gradientStroke.addColorStop(1, 'rgba(203,12,159,0.2)');
            gradientStroke.addColorStop(0.2, 'rgba(72,72,176,0.0)');
            gradientStroke.addColorStop(0, 'rgba(203,12,159,0)');

            const chartData = $chartData;
            chartData.datasets[0].backgroundColor = gradientStroke;

            new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    interaction: { intersect: false, mode: 'index' },
                    scales: {
                        y: {
                            grid: { drawBorder: false, display: true, borderDash: [5, 5] },
                            ticks: { padding: 10, color: '#b2b9bf', font: { size: 11, family: 'Open Sans' } }
                        },
                        x: {
                            grid: { drawBorder: false, display: false },
                            ticks: { padding: 20, color: '#b2b9bf', font: { size: 11, family: 'Open Sans' } }
                        }
                    }
                }
            });
        });
    </script>";
}


}

