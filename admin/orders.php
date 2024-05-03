<?php
include "template/header.php";
include "page-includes/sidebar.php";
include "page-includes/navbar.php";

// Function to sanitize user input
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}

// Fetch data from database
$sql_FetchOrder = "SELECT * FROM orders INNER JOIN customers ON orders.customer_id = customers.customer_id";
$result = mysqli_query($conn, $sql_FetchOrder);
?>

<!-- Page content -->
<div class="main">
    <div class="container-fluid bg-light p-3 border">
        <h3 class="text-center">Ordering System</h3>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-sm-12 col-md-10">
                <form method="GET" action="">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Search" aria-label="Search" aria-describedby="button-search">
                        <button class="btn btn-outline-secondary" type="submit" id="button-search" name="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>
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
                        <th>Customer Name</th>
                        <th>Customer Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $RowCount = 0;
                    if (isset($_GET['submit'])) {
                        // Search logic
                        $search = sanitizeInput($_GET['search']);
                        $sql_FetchOrder .= " WHERE name LIKE '%$search%'
                                            OR address LIKE '%$search%'
                                            OR order_date LIKE '%$search%'
                                            OR delivery_address LIKE '%$search%'
                                            ORDER BY order_date DESC "; // Add more columns as needed
                    }
                    $result = mysqli_query($conn, $sql_FetchOrder);

                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row of data
                        while ($orderInfo = mysqli_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td><?= ++$RowCount ?></td>
                                <td><?= date('m/d/Y H:i', strtotime($orderInfo['order_date'])) ?></td>
                                <td><?= 'ORN' . $orderInfo['order_id'] ?></td>
                                <td><?= $orderInfo['name'] ?></td>
                                <td><?= $orderInfo['address'] ?></td>
                                <td><a type="button" href="order-details.php?id=<?= $orderInfo['order_id'] ?>" class="btn btn-info text-white">View</a></td>
                            </tr>
                            <?php }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No order information found.</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php
include "template/footer.php";
?>