<?php
include "template/header.php";
include "page-includes/sidebar.php";
include "page-includes/navbar.php";
?>

<div class="main">
    <?php if (isset($_SESSION['AlertMsg'])) { ?>
        <div class="alert <?= $_SESSION['AlertColor'] ?> fade show" role="alert">
            <?= $_SESSION['AlertMsg'] ?>

        </div>
    <?php }
    unset($_SESSION['AlertMsg']); ?>
    <div class="container-fluid p-3 mb-2 border">

        <?php
        $keyID = $_GET['id'];
        $sql_DisplayTracks = "SELECT tti.*, ts.Status, pl_current.PostName AS CurrentPostName, 
                            CASE WHEN tti.DestinationPostID IS NOT NULL THEN pl_destination.PostName ELSE 'N/A' END AS DestinationPostName
                    FROM tbl_trackinginformation tti
                    INNER JOIN tbl_trackingstatus ts ON tti.TrackingStatusID = ts.TrackingStatusID
                    INNER JOIN tbl_postlocations pl_current ON tti.PostLocationID = pl_current.PostLocationID
                    LEFT JOIN tbl_postlocations pl_destination ON tti.DestinationPostID = pl_destination.PostLocationID
                    WHERE tti.TrackingID = $keyID";

        $result = mysqli_query($conn, $sql_DisplayTracks);

        if (mysqli_num_rows($result) > 0) {
            // Loop through each row of data
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <div class="table-responsive">
                    <div class="container-fluid mb-2 d-flex justify-content-between align-items-end">
                        <h6>Tracking Information</h6>
                        <div>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updateStatusModal_<?= $row['TrackingID'] ?>">Update Status</button>
                        </div>
                    </div>
                    <?php include 'modals/UpdateTrackingStatus.php'; ?>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="tr-title">Tracking Number:</td>
                                <td><?= $row['TrackingNumber'] ?></td>
                            </tr>

                            <tr>
                                <td class="tr-title">Initial Tracking Date:</td>
                                <td><?= date('m/d/Y H:i', strtotime($row['InitialDate'])) ?></td>
                            </tr>
                            <?php if($row['DeliveryDate'] != NULL){ ?>
                            <tr>
                                <td class="tr-title">Estimated Delivery Date:</td>
                                <td><?= date('m/d/Y', strtotime($row['DeliveryDate'])) ?></td>
                            </tr>
                            <?php } ?>

                            <tr>
                                <td class="tr-title">Tracking Status:</td>
                                <td>
                                    <?= $row['Status'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="tr-title">Tracking Location:</td>
                                <td><?= $row['CurrentPostName'] ?></td>
                            </tr>
                            <?php if ($row['TrackingStatusID'] != 1) { ?>
                                <tr>
                                    <td class="tr-title">Destination Post Location:</td>
                                    <td><?= $row['DestinationPostName'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
                <div class="container-fluid p-3 mb-2 border">

                    <div class="row">
                        <!-- progress bar here -->
                    </div>

                    <div class="row px-5 circles">
                        <div class="col flex-center">
                            <i class="fa-regular <?php echo ($row['TrackingStatusID'] >= 1) ? 'green' : 'text-muted'; ?> fa-4x fa-circle-check"></i>
                            <p class="m-0">Pending</p>
                        </div>
                        <div class="col flex-center ">
                            <i class="fa-regular <?php echo ($row['TrackingStatusID'] >= 2) ? 'green' : 'text-muted'; ?> fa-4x fa-circle-check"></i>
                            <p class="m-0">Confirmed</p>
                        </div>
                        <div class="col flex-center">
                            <i class="fa-regular <?php echo ($row['TrackingStatusID'] >= 3) ? 'green' : 'text-muted'; ?> fa-4x fa-circle-check"></i>
                            <p class="m-0">In Transit</p>
                        </div>
                        <div class="col flex-center">
                            <i class="fa-regular <?php echo ($row['TrackingStatusID'] >= 4) ? 'green' : 'text-muted'; ?> fa-4x fa-circle-check"></i>
                            <p class="m-0">Out for Delivery</p>
                        </div>
                        <div class="col flex-center">
                            <i class="fa-regular <?php
                                                    $statusClass = 'fa-circle-check text-muted'; // Default class
                                                    if ($row['TrackingStatusID'] == 6) {
                                                        $statusClass = 'fa-circle-xmark text-danger'; // If tracking ID is 6, set class to another-class
                                                    } elseif ($row['TrackingStatusID'] >= 5) {
                                                        $statusClass = 'green fa-circle-check'; // If tracking ID is 5 or greater, set class to green
                                                    }
                                                    echo $statusClass; // Output the class
                                                    ?> fa-4x"></i>
                            <p class="m-0">Delivered</p>
                        </div>
                    </div>
                </div>
        <?php }
        } ?>

        <?php
        $sql_DisplayOrder = "SELECT oi.*,
         p.name AS product_name,
         p.price AS product_price,
         o.order_date, 
         o.total_amount,
         c.name AS customer_name,
         c.address AS customer_address,
         c.contact_information AS contact_information
        FROM order_item oi
        INNER JOIN product p ON p.product_id = oi.product_id
        INNER JOIN orders o ON o.order_id = oi.order_id
        INNER JOIN customers c ON c.customer_id = o.customer_id
        WHERE o.order_id = $keyID";
        $result = mysqli_query($conn, $sql_DisplayOrder);

        if (mysqli_num_rows($result) > 0) {
            // Loop through each row of data
            while ($order = mysqli_fetch_assoc($result)) {
        ?>
                <div class="container-fluid p-3 mb-2 border">
                    <div class="container-fluid mb-2 d-flex justify-content-between align-items-end">
                        <h6>Order Information</h6>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="tr-title">Order Date:</td>
                                    <td><?= date('m/d/Y H:i', strtotime($order['order_date'])) ?></td>
                                </tr>
                                <tr>
                                    <td class="tr-title">Order Number:</td>
                                    <td>
                                        <a type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#seeCustomerModal_<?= $order['order_id'] ?>">
                                            <?= 'ORN' . $order['order_id'] ?>
                                        </a>
                                        <?php include 'modals/seeCustomerModal.php'; ?>
                                    </td>

                                </tr>
                                <tr>
                                    <td class="tr-title">Order Items:</td>
                                    <td>
                                        <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#seeOrderItemsModal_<?= $order['order_id'] ?>">
                                            View Order Items
                                        </button>
                                        <?php include 'modals/seeOrderItemsModal.php'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tr-title">Total Amount of Order:</td>
                                    <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


    </div>
<?php
            }
        } else {
            echo 'no records found';
        } ?>



</div>



<?php
unset($_SESSION['ActivateAlert']);
include "template/footer.php";
?>