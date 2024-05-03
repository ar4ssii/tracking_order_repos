<?php
include "template/header.php";
include "page-includes/sidebar.php";
include "page-includes/navbar.php";

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $getID = $_GET['id'];
    $sql_fetchOrderDetails = "SELECT o.*, c.*, c.name as customerName, oi.*, p.*
                                    FROM 
                                        orders o
                                    INNER JOIN 
                                        customers c ON o.customer_id = c.customer_id
                                    INNER JOIN 
                                        order_item oi ON o.order_id = oi.order_id
                                    INNER JOIN 
                                        product p ON oi.product_id = p.product_id WHERE o.order_id = $getID";

    $result = mysqli_query($conn, $sql_fetchOrderDetails);

    if (mysqli_num_rows($result) > 0) {
        // Loop through each row of data
        while ($order = mysqli_fetch_assoc($result)) {
?>
            <div class="main">
                <?php if (isset($_SESSION['AlertMsg'])) { ?>
                    <div class="alert <?= $_SESSION['AlertColor'] ?> fade show" role="alert">
                        <?= $_SESSION['AlertMsg'] ?>
                    </div>
                <?php }unset($_SESSION['AlertMsg']); ?>

                <div class="container-fluid p-3 mb-2 border">
                    <div class="container-fluid mb-2">
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
                                    <td><?= 'ORN' . $order['order_id'] ?></td>
                                </tr>
                                <tr>
                                    <td class="tr-title">Order Items:</td>
                                    <td>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Item Name</th>
                                                        <th>Price</th>
                                                        <th>Qty</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $totalAmount = 0;
                                                    $index = 1;
                                                    mysqli_data_seek($result, 0); // Reset result pointer
                                                    while ($orderItem = mysqli_fetch_assoc($result)) {
                                                        $subtotal = $orderItem['price'] * $orderItem['quantity_ordered'];
                                                        $totalAmount += $subtotal;
                                                    ?>
                                                        <tr>
                                                            <td><?= $index++ ?></td>
                                                            <td><?= $orderItem['name'] ?></td>
                                                            <td>₱<?= number_format($orderItem['price'], 2) ?></td>
                                                            <td><?= $orderItem['quantity_ordered'] ?></td>
                                                            <td>₱ <?= number_format($subtotal, 2) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tr-title">Total Amount of Order:</td>
                                    <td>₱<?= number_format($totalAmount, 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="container-fluid p-3 mb-2 border">
                    <div class="table-responsive">
                        <h6>Customer Information</h6>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="tr-title">Customer Name:</td>
                                    <td><?= $order['customerName'] ?></td>
                                </tr>
                                <tr>
                                    <td class="tr-title">Delivery Address:</td>
                                    <td><?= $order['delivery_address'] ?></td>
                                </tr>
                                <tr>
                                    <td class="tr-title">Contact Number:</td>
                                    <td><?= $order['contact_information'] ?></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
<?php

        }
    }
} else {
    echo "Order ID is not provided.";
}

unset($_SESSION['ActivateAlert']);
include "template/footer.php";
?>