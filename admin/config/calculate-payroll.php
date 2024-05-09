<?php
session_start();
include 'dbcon.php';

if (isset($_POST['btn_calculate_payroll'])) {
    $StartDate = $_POST['StartDate'];
    $EndDate = $_POST['EndDate'];
    $PayrollType = $_POST['PayrollType'];
    $reference_number = $_POST['reference_number'];

    $sql_fetchAbsent = "
    SELECT employee_id, date, timein, timeout, status 
    FROM `tbl_attendance` a
    INNER JOIN tbl_status s ON s.status_id = a.status_id
    WHERE a.date >= '$StartDate' AND a.date <= '$EndDate'
    AND a.status_id = 2
    ";
}
