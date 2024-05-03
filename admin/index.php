<?php
include "template/header.php";
include "page-includes/sidebar.php";
include "page-includes/navbar.php";
?>

<!-- Page content -->
<div class="main">
  <div class="container-fluid mt-3">
    <h6>TRACKING SYSTEM DASHBOARD</h6>
    <div class="col mx-4">
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

        <?php
        // Execute query to count occurrences of each status
        $sql_countStatus = "SELECT ts.Status, COUNT(*) AS count FROM tbl_trackinginformation tti
                            INNER JOIN tbl_trackingstatus ts ON tti.TrackingStatusID = ts.TrackingStatusID
                            GROUP BY ts.Status";
        $result_countStatus = mysqli_query($conn, $sql_countStatus);

        // Associative array to store counts of each status
        $statusCounts = array();

        // Populate status counts array
        if (mysqli_num_rows($result_countStatus) > 0) {
          while ($row = mysqli_fetch_assoc($result_countStatus)) {
            $statusCounts[$row['Status']] = $row['count'];
          }
        }
        // Function to get count of a status from the status counts array
        function getStatusCount($status)
        {
          global $statusCounts;
          return isset($statusCounts[$status]) ? $statusCounts[$status] : 0;
        }
        ?>

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
                <p class="text-uppercase">returned/cancelled</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php
include "template/footer.php";
?>