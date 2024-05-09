<?php
session_start();
include 'dbcon.php';

if (isset($_POST['btn_edit_client'])) {

    $customer_id = $_POST['ClientHiddenKey'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact_information = $_POST['contact_information'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql_updateCustomer = "UPDATE customers 
    SET name = ?, 
        address = ?, 
        contact_information = ?, 
        username = ?, 
        password = ?
    WHERE customer_id = ?";

    $stmt = $conn->prepare($sql_updateCustomer);
    $stmt->bind_param("sssssi", $name, $address, $contact_information, $username, $password, $customer_id);

    if ($stmt->execute()) {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-success";
        $_SESSION['AlertMsg'] = "Client Information updated successfully!";
    } else {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-danger";
        $_SESSION['AlertMsg'] = "Failed to update client info.";
    }
    $stmt->close(); // Close the prepared statement
    $conn->close(); // Close the database connection
    header('location: ../client-management.php');
    exit();
}
