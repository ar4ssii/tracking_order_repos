<?php
include "template/header.php";
include 'validation/employee-validation.php';
include "page-includes/sidebar.php";
include "page-includes/navbar.php";

// Function to sanitize user input
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}

$user_keyID = $_SESSION['user_info']['id'];
// Fetch data from database
$sql_FetchClient = "SELECT 
c.name AS CustomerName, 
c.contact_information AS CustomerContactNumber, 
c.address AS CustomerAddress, 
c.username,
c.customer_id AS id, 
COUNT(o.order_id) AS TotalOrders
FROM 
`customers` c
LEFT JOIN 
orders o ON c.customer_id = o.customer_id
";

// Check if search query is set
if (isset($_GET['submit'])) {
    // Sanitize the input (prevent SQL injection)
    $search = sanitizeInput($_GET['search']);

    // Add WHERE clause to filter based on multiple columns
    $sql_FetchClient .= " WHERE c.name LIKE '%$search%'
                            OR c.address LIKE '%$search%'
                            OR c.username LIKE '%$search%'
                            OR c.contact_information LIKE '%$search%'
                            ";
}
$sql_FetchClient .=" GROUP BY c.customer_id";
$result = $conn->query($sql_FetchClient);
?>

<!-- Page content -->
<div class="main">
    <?php if (isset($_SESSION['AlertMsg'])) { ?>
        <div class="alert <?= $_SESSION['AlertColor'] ?> fade show" role="alert">
            <?= $_SESSION['AlertMsg'] ?>
        </div>
    <?php }
    unset($_SESSION['AlertMsg']); ?>
    <div class="container-fluid bg-light p-3 border">
        <h3 class="text-center">Client/Customer Management</h3>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-sm-12 col-md-10">
                <form method="GET" action="">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Search Client" aria-label="Search Client" aria-describedby="button-client-search">
                        <button class="btn btn-outline-secondary" type="submit" id="button-client-search" name="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid bg-light p-3 border">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Delivery Address</th>
                        <th>Contact Number</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Total Orders</th>
                        <th colspan="">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are any rows returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        $count = 1;
                        while ($row = $result->fetch_assoc()) {

                    ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= $row['CustomerName']; ?></td>
                                <td><?= $row['CustomerAddress']; ?></td>
                                <td><?= $row['CustomerContactNumber']; ?></td>
                                <td><?= $row['username']; ?></td>
                                <td>********</td>
                                <td><?= $row['TotalOrders']; ?></td>
                                <td>
                                    <a type="button" href="client-details.php?id=<?= $row["id"]; ?>" class="btn btn-info"><i class="fa-solid fa-user-pen"></i></a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="8" class="text-center">No clients found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include "template/footer.php";
?>