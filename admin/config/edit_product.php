<?php
session_start();
include 'dbcon.php';

if (isset($_POST['btn_edit_p'])) {

    $product_id = $_POST['hiddenProductID'];
    $product_name = $_POST['product_name'];
    $product_desc = $_POST['product_desc'];
    $product_price = $_POST['product_price'];
    $product_stocks = $_POST['product_stocks'];

    $sql_updateProduct = "UPDATE product 
    SET name = ?, 
        description = ?, 
        price = ?, 
        quantity_in_stock = ? 
    WHERE product_id = ?";

$stmt = $conn->prepare($sql_updateProduct);
$stmt->bind_param("ssdii", $product_name, $product_desc, $product_price, $product_stocks, $product_id);

if ($stmt->execute()) {
$_SESSION['ActivateAlert'] = true;
$_SESSION['AlertColor'] = "alert-success";
$_SESSION['AlertMsg'] = "Product updated successfully!";
} else {
$_SESSION['ActivateAlert'] = true;
$_SESSION['AlertColor'] = "alert-danger";
$_SESSION['AlertMsg'] = "Failed to update product.";
}
$stmt->close(); // Close the prepared statement
$conn->close(); // Close the database connection
header('location: ../products.php');
exit();
}
