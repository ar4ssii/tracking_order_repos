<?php
session_start();
include_once 'dbcon.php';
date_default_timezone_set('Asia/Manila');

$id = $_SESSION['user_info']['id'];
$currentDate = date("Y-m-d");
$currentTime = date("Y-m-d H:i:s");

// Define the job start time (9:00 AM in this example)
$jobStartTime = strtotime("09:30:00");
// Define the job end time (5:00 PM in this example)
$jobEndTime = strtotime("16:30:00");

// Define the cutoff time for marking an employee as absent (e.g., midnight)
$cutoffTime = strtotime("23:59:59");

if (isset($_POST['btn_timein'])) {

    $sql = "INSERT INTO `tbl_attendance`(`employee_id`, `date`, `timein`, `worktime_status_id`, `status_id`) 
    VALUES ('$id','$currentDate','$currentTime',0,";


    if (strtotime($currentTime) > $jobStartTime) {
        // Late
        $sql .= "2)"; // StatusID = 2 for "late"
    } else {
        // On time
        $sql .= "1)"; // StatusID = 1 for "present"
    }

    echo $sql;

    $result = $conn->query($sql);
    $_SESSION['attendanceID'] = $conn->insert_id;

    if ($result === true) {
        $_SESSION['message'] = "Time in successfully";
        $_SESSION['isTimein'] = true;
        header('location: ../user-attendance.php');
    }
}

if (isset($_POST['btn_timeout'])) {
    $attendanceID = $_SESSION['attendanceID'];

    $sql = "UPDATE `tbl_attendance` SET `timeout`='$currentTime' WHERE `attendance_id` = $attendanceID";
    $result = $conn->query($sql);

    $sql = "SELECT `timeout` FROM `tbl_attendance` WHERE `employee_id` = $id AND `date` = '$currentDate'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $timeout = strtotime($row['timeout']);

        // Calculate the work duration
        $workDuration = strtotime($currentTime) - $timeout;

        // Check if it's normal work time, overtime, or undertime
        if ($workDuration >= ($jobEndTime - $jobStartTime)) {
            $worktime_statusID = 2; // Overtime
        } elseif ($workDuration < ($jobEndTime - $jobStartTime)) {
            $worktime_statusID = 3; // Undertime
        } else {
            $worktime_statusID = 1; // Normal work time
        }

        $sql = "UPDATE `tbl_attendance` SET `worktime_status_id`= $worktime_statusID WHERE `employee_id` = $id AND `date` = '$currentDate'";
        $result = $conn->query($sql);
    }

    if ($result) {
        $_SESSION['message'] = "Time Out successfully";
        $_SESSION['isTimeOut'] = true;
         header('location: ../user-attendance.php');
    } else {
        $_SESSION['e_message'] = "Time In First";
         header('location: ../user-attendance.php');
    }
}