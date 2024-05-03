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
$sql_FetchProducts = "SELECT * FROM product";
if (isset($_GET['submit'])) {
    // Sanitize the input
    $search = sanitizeInput($_GET['search']);

    // Add a WHERE clause to filter based on multiple columns
    $sql_FetchProducts .= " WHERE name LIKE '%$search%'
                            OR description LIKE '%$search%'
                            OR price LIKE '%$search%'";
}
$result = mysqli_query($conn, $sql_FetchProducts);
?>

<!-- Page content -->
<div class="main">
    <?php if (isset($_SESSION['AlertMsg'])) { ?>
        <div class="alert <?= $_SESSION['AlertColor'] ?> fade show" role="alert">
            <?= $_SESSION['AlertMsg'] ?>
        </div>
    <?php } unset($_SESSION['AlertMsg']); ?>
    <div class="container-fluid bg-light p-3 border">
        <h3 class="text-center">Products</h3>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-sm-12 col-md-10">
                <form method="GET" action="">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Search Products" aria-label="Search Products" aria-describedby="button-product-search">
                        <button class="btn btn-outline-secondary" type="submit" id="button-product-search" name="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
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
                        <th>Product</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Available Stocks</th>
                        <th colspan="">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="config/add_product.php" method="post">
                        <tr>
                            <td>#</td>
                            <td><input type="text" name="product_name" placeholder="product name" class="form-control"></td>
                            <td><input type="text" name="product_desc" placeholder="product description" class="form-control"></td>
                            <td><input type="number" name="product_price" placeholder="product price per qty" class="form-control"></td>
                            <td><input type="number" name="product_stocks" placeholder="product stock number" class="form-control"></td>
                            <td colspan=""><button class="btn btn-success" name="add_product">Add Product</button></td>
                        </tr>
                    </form>
                    <?php
                    $RowCount = 0;
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row of data
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <form action="config/edit_product.php" method="post">
                                <tr>
                                    <td><?= ++$RowCount ?></td>
                                    <td><input type="text" name="product_name" value="<?= $row['name'] ?>" class="form-control"></td>
                                    <td><input type="text" name="product_desc" value="<?= $row['description'] ?>" class="form-control"></td>
                                    <td><input type="text" name="product_price" value="<?= $row['price'] ?>" class="form-control"></td>
                                    <td><input type="text" name="product_stocks" value="<?= $row['quantity_in_stock'] ?>" class="form-control"></td>
                                    
                                    <td><button class="btn btn-warning" name="btn_edit_p" value="<?= $row['product_id'] ?>" type="submit">Edit</button><input type="hidden" name="hiddenProductID" value="<?= $row['product_id'] ?>"></td>
                                    
                                </tr>
                            </form>
                    <?php }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No product found.</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php
include "template/footer.php";
?>