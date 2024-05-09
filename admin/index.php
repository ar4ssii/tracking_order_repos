<?php
include "template/header.php";
include 'validation/rider-validation.php';
include "page-includes/sidebar.php";
include "page-includes/navbar.php";

// Execute SQL query to fetch sales data with month and sum of sales by month
$sql = "SELECT MONTH(o.order_date) AS OrderMonth, SUM(pm.Amount + pm.transaction_fee) AS TotalSales 
        FROM payment_method pm
        INNER JOIN tbl_trackinginformation tti ON tti.OrderID = pm.order_id
        INNER JOIN orders o ON o.order_id = pm.order_id
        WHERE tti.TrackingStatusID = 5
        GROUP BY MONTH(o.order_date)";

$result = mysqli_query($conn, $sql);

// Initialize arrays for sales labels and data
$salesLabels = [];
$salesData = [];

// Populate sales labels and data arrays
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    // Get the month name from the numeric month
    $monthName = date("F", mktime(0, 0, 0, $row['OrderMonth'], 1));
    $salesLabels[] = $monthName;

    // Store total sales for each month
    $salesData[] = $row['TotalSales'];
  }
}
?>

<!-- Page content -->
<div class="main">
  <div class="container-fluid mt-3">
    <h6>TRACKING SYSTEM DASHBOARD</h6>
    <div class="col mx-4">
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

        <a href="track.php" style="text-decoration: none;">
          <div class="col">
            <div class="card h-100 shadow border-warning-left">
              <div class="row m-0 py-3 align-items-center">
                <div class="col-4">
                  <i class="fa-solid fa-clock display-3 text-warning"></i>
                </div>
                <div class="col-8 text-end">
                  <h1 class="display-2 text-warning"><?php echo getStatusCount('PENDING'); ?></h1>
                  <p class="text-uppercase">Pending FOR Approval</p>
                </div>
              </div>
            </div>
          </div>
        </a>
        <div class="col">
          <div class="card h-100 shadow border-info-left">
            <div class="row m-0 py-3 align-items-center">
              <div class="col-4">
                <i class="fa-solid fa-check-to-slot display-3 text-info"></i>
              </div>
              <div class="col-8 text-end">
                <h1 class="display-2 text-info"><?php echo getStatusCount('CONFIRMED'); ?></h1>
                <p class="text-uppercase">cONFIRMED</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card h-100 shadow border-primary-left">
            <div class="row m-0 py-3 align-items-center">
              <div class="col-4">
                <i class="fa-solid fa-truck-arrow-right display-3 text-primary"></i>
              </div>
              <div class="col-8 text-end">
                <h1 class="display-2 text-primary"><?php echo getStatusCount('IN TRANSIT'); ?></h1>
                <p class="text-uppercase">IN TRANSIT</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card h-100 shadow border-secondary-left">
            <div class="row m-0 py-3 align-items-center">
              <div class="col-4">
                <i class="fa-solid fa-truck-fast display-3 text-secondary"></i>
              </div>
              <div class="col-8 text-end">
                <h1 class="display-2 text-secondary"><?php echo getStatusCount('OUT FOR DELIVERY'); ?></h1>
                <p class="text-uppercase">OUT FOR DELIVERY</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card h-100 shadow border-success-left">
            <div class="row m-0 py-3 align-items-center">
              <div class="col-4">
                <i class="fa-solid fa-box display-3 text-success"></i>
              </div>
              <div class="col-8 text-end">
                <h1 class="display-2 text-success"><?php echo getStatusCount('DELIVERED'); ?></h1>
                <p class="text-uppercase">delivered</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card h-100 shadow border-danger-left">
            <div class="row m-0 py-3 align-items-center">
              <div class="col-4">
                <i class="fa-solid fa-ban display-3 text-danger"></i>
              </div>
              <div class="col-8 text-end">
                <h1 class="display-2 text-danger"><?php echo getStatusCount('RETURNED'); ?></h1>
                <p class="text-uppercase">returned/ cancelled</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <div class="container-fluid py-3">
    <div class="col mx-4">
      <!-- charts -->
      <div class="chart">
        <div class="row">
          <div class="col-lg-6 pr-lg-2 chart-grid">
            <div class="card shadow text-center card_border">
              <div class="card-header chart-grid__header">
                Sales Chart
              </div>
              <div class="card-body">
                <!-- bar chart -->
                <div id="container">
                  <canvas id="salesChart" width="400" height="200"></canvas>
                </div>
                <!-- //bar chart -->
              </div>

            </div>
          </div>
          <!-- //charts -->

          <?php
          $sql_countOrders = "SELECT COUNT(*) AS count FROM orders";
          $result_countOrders = mysqli_query($conn, $sql_countOrders);

          // Check if there are any rows returned
          if (mysqli_num_rows($result_countOrders) > 0) {
            // Fetch the result row
            $countOrders = mysqli_fetch_assoc($result_countOrders);
          ?>
            <div class="col-lg-6 pl-lg-2 chart-grid">
              <a href="orders.php" style="text-decoration: none;">
                <div class="card shadow text-center card_border">
                  <div class="card-header chart-grid__header">
                    Total Orders
                  </div>
                  <div class="card-body">
                    <h1 class="display-2"><?php echo $countOrders['count']; ?></h1>
                  </div>
                </div>
              </a>
            </div>

          <?php }
          ?>
        </div>
      </div>

    </div>
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Sales data from PHP
  const salesLabels = <?php echo json_encode($salesLabels); ?>;
  const salesData = <?php echo json_encode($salesData); ?>;

  // Sales data
  const salesChartData = {
    labels: salesLabels,
    datasets: [{
      label: 'Sales',
      data: salesData,
      backgroundColor: 'rgba(54, 162, 235, 0.2)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 1
    }]
  };

  // Bar chart configuration
  const ctx = document.getElementById('salesChart').getContext('2d');
  const salesChart = new Chart(ctx, {
    type: 'bar',
    data: salesChartData,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<?php
include "template/footer.php";
?>