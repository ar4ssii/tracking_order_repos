<?php
session_start();
include 'dbcon.php';

if (isset($_POST['add_product'])) {

    $product_name = $_POST['product_name'];
    $product_desc = $_POST['product_desc'];
    $product_price = $_POST['product_price'];
    $product_stocks = $_POST['product_stocks'];

    $sql_addProduct = "INSERT INTO product(name, description, price, quantity_in_stock) 
                    VALUES('$product_name','$product_desc',$product_price,$product_stocks)";
    $result = $conn->query($sql_addProduct);
    if ($result === true) {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-success";
        $_SESSION['AlertMsg'] = "Tracking enabled successfully!";
    } else {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-danger";
        $_SESSION['AlertMsg'] = "Failed to enable tracking.";
    }
    header('location: ../products.php');
    exit();
}
