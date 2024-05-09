<?php
include 'customer-template/header.php';
include 'customer-validation/customer-validation.php';
include 'customer-template/navbar.php';
?>
<div class="container-fluid py-5 bg-light">
    <?php if (isset($_SESSION['AlertMsg'])) { ?>
        <div class="alert <?= $_SESSION['AlertColor'] ?> fade show" role="alert">
            <?= $_SESSION['AlertMsg'] ?>

        </div>
    <?php }
    unset($_SESSION['AlertMsg']); ?>
    <h1 class="text-center">Order Transactions </h1>
    <div class="container col-lg-12 col-sm-12">
        <div class="table-responsive">
            <?php
            $current_user_id = $_SESSION['user_info']['id'];
            
            $table_query = "SELECT DISTINCT
            orders.order_id AS order_id,
            orders.order_date AS order_date,
            MAX(tbl_trackingstatus.Status) AS status
        FROM 
            orders 
        LEFT JOIN 
            tbl_trackinginformation ON orders.order_id = tbl_trackinginformation.OrderID
        LEFT JOIN 
            tbl_trackingstatus ON tbl_trackinginformation.TrackingStatusID = tbl_trackingstatus.TrackingStatusID 
        WHERE 
            orders.customer_id = $current_user_id
        GROUP BY 
            orders.order_id
        ORDER BY 
            order_date DESC
        ";

            $result = $conn->query($table_query);
            $rowNum = 1;
            // Check if there are any rows returned
            if ($result->num_rows > 0) {
            ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th style="width: 200px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Iterate over each row of the result set
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?= $rowNum ?></td>
                                <td><?= date('F j, Y g:i a', strtotime($row['order_date'])) ?></td>
                                <td><?= 'OR' . $row['order_id'] ?></td>
                                <td><?= $row['status'] ?></td>
                                <td><a href="transaction-details.php?id=<?= $row['order_id'] ?>" type="button" class="btn btn-info">View Details</a></td>
                            </tr>
                        <?php $rowNum++;
                        }  ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="container">
                    <p class="text-center">No transactions yet. To place order, tap the Order tab.</p>
                </div>
            <?php  } ?>
        </div>
    </div>
</div>

<?php include 'customer-template/footer.php'; ?>