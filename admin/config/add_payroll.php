<?php
session_start();
include 'dbcon.php';
date_default_timezone_set('Asia/Manila');

$btn_add_payroll = $_POST['btn_add_payroll'];
$StartDate = $_POST['StartDate'];
$EndDate = $_POST['EndDate'];
$PayrollType = $_POST['PayrollType'];
$reference_number =  'REF' . date('md') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

if (isset($btn_add_payroll)) {
    $sql_InsertNewPayroll = "INSERT INTO `tbl_payroll`(`reference_number`, `StartDate`, `EndDate`, `PayrollType`) VALUES ('$reference_number','$StartDate','$EndDate','$PayrollType')";
    $result_InsertNewPayroll = $conn->query($sql_InsertNewPayroll);
    if ($result_InsertNewPayroll === true) {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-success";
        $_SESSION['AlertMsg'] = "Payroll Added successfully!";
    } else {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-danger";
        $_SESSION['AlertMsg'] = "Failed to Add Payroll.";
    }
    header('location: ../payroll.php');
    exit();
}
