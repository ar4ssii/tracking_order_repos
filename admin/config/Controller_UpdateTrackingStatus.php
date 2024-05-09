<?php
session_start();
include 'dbcon.php';
date_default_timezone_set('Asia/Manila');


if (isset($_POST['btn_updateStatus'])) {
    $hiddenID = $_POST['hiddenID'];
    $UpdatedStatus = $_POST['UpdatedStatus'];
    $FromPost = $_POST['FromPost'];
    $ToPost = $_POST['ToPost'];
    
    // Calculate delivery date (current date + 4 days) only if UpdatedStatus is 2
    // if ($UpdatedStatus == 2) {
    //     $DeliveryDate = date('Y-m-d H:i:s', strtotime('+4 days'));

    $sql_UpdateStatus = "UPDATE tbl_trackinginformation SET TrackingStatusID = $UpdatedStatus, PostLocationID = $FromPost, DestinationPostID =  $ToPost WHERE TrackingID = '$hiddenID'";
    // } else {
    //     $sql_UpdateStatus = "UPDATE tbl_trackinginformation SET TrackingStatusID = $UpdatedStatus, PostLocationID = $FromPost, DestinationPostID =  $ToPost WHERE TrackingID = '$hiddenID'";
    // }

    $result = $conn->query($sql_UpdateStatus);

    if ($result === true) {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-success";
        $_SESSION['AlertMsg'] = "Status updated successfully!";
    } else {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-danger";
        $_SESSION['AlertMsg'] = "Status update failed";
    }

    // Redirect to the track-details page
    header('location: ../track-details.php?id=' . $hiddenID);
    exit();
}


if (isset($_POST['btn_deliver'])) {
    $KeyID = $_POST['KeyID'];
    $orderID = $_POST['orderID'];
    $rider_id = $_SESSION['user_info']['id'];
    $deliverUpdatedStatus = $_POST['deliverUpdatedStatus'];
    $DeliveryDate = date('Y-m-d H:i:s');

    $sql_DeliverUpdateStatus = "UPDATE tbl_trackinginformation SET TrackingStatusID = $deliverUpdatedStatus, Deliverydate = '$DeliveryDate', rider_id = $rider_id  WHERE TrackingID = '$KeyID'";
    $result = $conn->query($sql_DeliverUpdateStatus);
    if ($result === true) {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-success";
        $_SESSION['AlertMsg'] = "Status updated successfully!";

        
    } else {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-danger";
        $_SESSION['AlertMsg'] = "Status update failed";
    }
    header('location: ../deliver.php');
    exit();
}
