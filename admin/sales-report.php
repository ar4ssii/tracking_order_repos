<?php
include "template/header.php";
include 'validation/employee-validation.php';
include "page-includes/sidebar.php";
include "page-includes/navbar.php";

// Initialize variables for start date and end date
$startValue = "";
$endValue = "";

// Check if start date and end date are set in the URL
if (isset($_GET['startDate'])) {
    $startValue = $_GET['startDate'];
}
if (isset($_GET['endDate'])) {
    $endValue = $_GET['endDate'];
}
?>

<!-- Page content -->
<div class="main">
    <div class="container-fluid bg-light p-3">
        <h3 class="text-center">Sales Report</h3>
        <form action="" method="get">
            <div class="row mb-2">
                <div class="col-lg-2">
                </div>
                <div class="col-lg-4">
                    <label for="">Start Date:</label>
                    <div class="input-group">
                        <input type="date" name="startDate" required class="form-control" value="<?= $startValue ?>">
                    </div>
                </div>
                <div class="col-lg-4">
                    <label for="">End Date:</label>
                    <div class="input-group">
                        <input type="date" name="endDate" required class="form-control" value="<?= $endValue ?>">
                    </div>
                </div>
                <div class="col-lg-2 d-flex align-items-end">
                    <button class="btn btn-info" type="submit" name="sales-search">Search</button>
                </div>
            </div>
        </form>

        <?php
        // Check if the form is submitted
        if (isset($_GET['sales-search'])) {
            // Retrieve and sanitize the input data
            $startDate = $_GET['startDate'];
            $endDate = $_GET['endDate'];
            // Perform validation on the dates if required

            // Query the database to fetch sales data within the specified date range
            $query = "SELECT tti.TrackingNumber, o.order_date,o.order_id,c.name AS CustomerName,pm.Amount, pm.transaction_fee
            FROM tbl_trackinginformation tti
            INNER JOIN orders o ON o.order_id = tti.OrderID
            INNER JOIN customers c ON c.customer_id = o.customer_id
            INNER JOIN payment_method pm ON pm.order_id = tti.OrderID
            WHERE tti.TrackingStatusID = 5 AND o.order_date 
            BETWEEN '$startDate' AND '$endDate' + INTERVAL 1 DAY";
            $result = mysqli_query($conn, $query);

            // Check if there are any results
            if (mysqli_num_rows($result) > 0) { ?>
                <div class="table-responsive mt-5">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Tracking Number</th>
                                <th>Customer Name</th>
                                <th>Order Date</th>
                                <th>Order Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) {
                                $TotalAmount = $row['Amount'] + $row['transaction_fee'];
                            ?>
                                <tr>
                                    <td><?= 'OR' . $row['order_id']; ?></td>
                                    <td><?= $row['TrackingNumber']; ?></td>
                                    <td><?= $row['CustomerName']; ?></td>
                                    <td><?= $row['order_date']; ?></td>
                                    <td>₱<?= number_format($TotalAmount, 2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else {
                // No sales data found within the specified date range
                echo "<div class='alert alert-info'>No sales found within the specified date range.</div>";
            }
        } else { ?>
            <div class="alert alert-info">Input date range for result.</div>
        <?php  }
        ?>
    </div>
</div>

<?php
include "template/footer.php";
?>