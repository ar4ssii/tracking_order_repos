<?php
// Include necessary files
include 'customer-template/header.php';
include 'customer-validation/customer-validation.php';
include 'customer-template/navbar.php';

// Check if order ID is provided in the URL
if (isset($_GET['id'])) {
    // Sanitize input to prevent SQL injection
    $order_id = $_GET['id'];

    // Query to fetch order details and associated order items
    $query = "SELECT o.*, c.*, p.name AS product_name, oi.*, p.*
              FROM orders o
              INNER JOIN customers c ON o.customer_id = c.customer_id
              INNER JOIN order_item oi ON o.order_id = oi.order_id
              INNER JOIN product p ON oi.product_id = p.product_id
              WHERE o.order_id = $order_id";

    $result = $conn->query($query);

    // Check if the query executed successfully
    if ($result) {
?>
        <div class="container-fluid py-5 bg-light">
            <h1 class="text-center">Order Details for <?= 'OR' . $order_id ?> </h1>
            <div class="container col-lg-12 col-sm-12">
                <h5>Order Items</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rowNum = 1;
                            $OrderAmount = 0;
                            // Iterate over each row of the result set
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $rowNum++ ?></td>
                                    <td><?= $row['product_name'] ?></td>
                                    <td><?= $row['quantity_ordered'] ?></td>
                                    <td><?= $row['price'] ?></td>
                                </tr>
                            <?php
                                $OrderAmount += $row['price'] * $row['quantity_ordered'];
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <?php
            $sql_fetch_tracking_info = "SELECT 
        tti.TrackingNumber, tti.TrackingStatusID,tti.InitialDate, tti.OrderId, tti.DeliveryDate,
        ts.Status
        FROM tbl_trackinginformation AS tti
        INNER JOIN tbl_trackingstatus AS ts ON ts.TrackingStatusID = tti.TrackingStatusID        
        WHERE tti.OrderId = $order_id";
            $result_sql_fetch_tracking_info = $conn->query($sql_fetch_tracking_info);

            // Check if the query executed successfully
            if ($result_sql_fetch_tracking_info) {
                $count = 1;
                while ($fetch = $result_sql_fetch_tracking_info->fetch_assoc()) {

            ?>
                    <div class="container col-lg-12 col-sm-12">
                        <h5>Tracking Information</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Tracking Number</th>
                                        <th>Order Date</th>
                                        <th>Estimated Delivery Date</th>
                                        <?php if (isset($fetch['DeliveryDate'])) { ?>
                                            <th>Delivery Date</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $count++; ?></td>
                                        <td><?= $fetch['TrackingNumber'] ?></td>
                                        <td><?= date('F j, Y g:i a', strtotime($fetch['InitialDate'])) ?></td>
                                        <td><?= date('F j, Y g:i a', strtotime($fetch['InitialDate'] . ' +4 days')) ?></td>
                                        <?php if (isset($fetch['DeliveryDate'])) { ?>
                                            <td><?= date('F j, Y g:i a', strtotime($fetch['DeliveryDate'])) ?></td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <h5>Tracking Status</h5>
                        <div class="row px-5 py-2 mx-0 circles bg-white border">
                            <div class="col flex-center">
                                <i class="fa-regular <?php echo ($fetch['TrackingStatusID'] >= 1) ? 'green' : 'text-muted'; ?> fa-4x fa-circle-check"></i>
                                <p class="m-0">Pending</p>
                            </div>
                            <div class="col flex-center ">
                                <i class="fa-regular <?php echo ($fetch['TrackingStatusID'] >= 2) ? 'green' : 'text-muted'; ?> fa-4x fa-circle-check"></i>
                                <p class="m-0">Confirmed</p>
                            </div>
                            <div class="col flex-center">
                                <i class="fa-regular <?php echo ($fetch['TrackingStatusID'] >= 3) ? 'green' : 'text-muted'; ?> fa-4x fa-circle-check"></i>
                                <p class="m-0">In Transit</p>
                            </div>
                            <div class="col flex-center">
                                <i class="fa-regular <?php echo ($fetch['TrackingStatusID'] >= 4) ? 'green' : 'text-muted'; ?> fa-4x fa-circle-check px-4"></i>
                                <p class="m-0">Out for Delivery</p>
                            </div>
                            <div class="col flex-center">
                                <i class="fa-regular <?php
                                                        $statusClass = 'fa-circle-check text-muted'; // Default class
                                                        if ($fetch['TrackingStatusID'] == 6) {
                                                            $statusClass = 'fa-circle-xmark text-danger'; // If tracking ID is 6, set class to another-class
                                                        } elseif ($fetch['TrackingStatusID'] >= 5) {
                                                            $statusClass = 'green fa-circle-check'; // If tracking ID is 5 or greater, set class to green
                                                        }
                                                        echo $statusClass; // Output the class
                                                        ?> fa-4x px-4"></i>
                                <p class="m-0 px-4">Delivered</p>
                            </div>
                        </div>
                    </div>
            <?php  }
            } ?>

            <?php
            // Now, let's fetch payment details outside the loop
            $sql_getAmount = "SELECT * FROM payment_method WHERE order_id = $order_id";
            $paymentResult = $conn->query($sql_getAmount);

            // Check if the query executed successfully
            if ($paymentResult && $paymentResult->num_rows > 0) {
                $paymentRow = $paymentResult->fetch_assoc();
            ?>

                <div class="container col-lg-12 col-sm-12">
                    <h5>Fees and Breakdown</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-end">Order Amount:</td>
                                    <td><?= $OrderAmount ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-end">Transaction Fee:</td>
                                    <td><?= $paymentRow['transaction_fee'] ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-end">Total Amount:</td>
                                    <td><?= $OrderAmount + $paymentRow['transaction_fee'] ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-end">Payment Type/Method:</td>
                                    <td><?= $paymentRow['Type'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    <?php
            }
    ?>

<?php
    } else {
        // Query failed
        echo "Failed to retrieve order details.";
    }
} else {
    // Order ID not provided
    echo "Order ID not provided.";
}

// Include footer
include 'customer-template/footer.php';
?>