<?php
include "template/header.php";
include "page-includes/sidebar.php";
include "page-includes/navbar.php";

?>

<!-- Page content -->
<div class="main">
    <div class="container-fluid bg-light p-3 border">
        <h3 class="text-center">Ordering System</h3>

    </div>
    <br>
    <div class="container-fluid bg-light p-3 border">
        <div class="row">
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date & Time</th>
                        <th>Order Number</th>
                        <th>Order Tracking Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $RowCount = 0;
                    try {
                        require_once 'config/fetch_order_api.php';

                        // Check if data was fetched successfully
                        if ($dataArray === false) {
                            throw new Exception("Failed to fetch data from the API.");
                        } else {
                            // Loop through each order
                            foreach ($dataArray as $orderId => $orderInfo) {
                                $APIorderID =  $orderInfo['order_id'];
                                $sql_LookOrderNum = "SELECT OrderID FROM tbl_trackinginformation  WHERE OrderID = $APIorderID";
                                $result = mysqli_query($conn, $sql_LookOrderNum);
                                $trackingInfo = mysqli_fetch_assoc($result);

                                // Display tracking status
                                if ($trackingInfo) {
                                    $trackingStatus = 'Tracked';
                                } else {
                                    $trackingStatus = "Untracked";
                                }

                    ?>
                                <tr>
                                    <td><?= ++$RowCount ?></td>
                                    <td><?= date('m/d/Y H:i', strtotime($orderInfo['order_date'])) ?></td>
                                    <td><?= 'ORN' . $orderInfo['order_id'] ?></td>
                                    <td>
                                        <?= $trackingStatus ?>
                                    </td>
                                    <td><a type="button" href="order-details.php?id=<?= $orderInfo['order_id'] ?>" class="btn btn-info text-white">View</a></td>
                                </tr>
                    <?php }
                        }
                    } catch (Exception $e) {
                        echo '<tr><td colspan="4">' . $e->getMessage() . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php
include "template/footer.php";
?>