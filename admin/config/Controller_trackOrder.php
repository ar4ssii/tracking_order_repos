<?php
session_start();
include 'dbcon.php';

if (isset($_POST['btn_trackOrderEnabled'])) {
    $keyID = $_POST['keyID'];

    // Check if OrderID already exists
    $checkOrderIDQuery = "SELECT COUNT(*) AS count FROM tbl_trackinginformation WHERE OrderID = $keyID";
    $checkOrderIDResult = $conn->query($checkOrderIDQuery);
    $row = $checkOrderIDResult->fetch_assoc();
    $orderExists = $row['count'] > 0;

    if ($orderExists) {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-danger";
        $_SESSION['AlertMsg'] = "This order is already being tracked. Tracking cannot be enabled.";
        header('location: ../order-details.php?id=' . $keyID);
        exit();
    }

    date_default_timezone_set('Asia/Manila');
    // Generate tracking number and other data
    $TrackingNumber =  'TN' . date('md') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    $TrackingStatusID = 1;
    $PostLocationID = 1;
    $InitialDate = date('Y-m-d H:i:s');

    // Insert tracking information
    $sql_EnableTracking = "INSERT INTO tbl_trackinginformation (TrackingNumber, OrderID, TrackingStatusID, PostLocationID, InitialDate) 
                            VALUES ('$TrackingNumber', $keyID, $TrackingStatusID, $PostLocationID, '$InitialDate')";
    $result = $conn->query($sql_EnableTracking);
    if ($result === true) {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-success";
        $_SESSION['AlertMsg'] = "Tracking enabled successfully!";
    } else {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-danger";
        $_SESSION['AlertMsg'] = "Failed to enable tracking.";
    }
    header('location: ../order-details.php?id=' . $keyID);
    exit();
}
