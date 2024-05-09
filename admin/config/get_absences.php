<?php
session_start();
include 'dbcon.php';

// Get the payroll_id and employee_id from the request
$payroll_id = $_GET['payroll_id'];
$employee_id = $_GET['employee_id'];

// Fetch payroll details including StartDate and EndDate
$sql_GetPayrollDetails = "SELECT * FROM `tbl_payroll` WHERE payroll_id = $payroll_id";
$res_GetPayrollDetails = $conn->query($sql_GetPayrollDetails);

if ($res_GetPayrollDetails->num_rows > 0) {
    $payrollDetails = $res_GetPayrollDetails->fetch_assoc();
    $startDate = $payrollDetails['StartDate'];
    $endDate = $payrollDetails['EndDate'];

    // Fetch employee's present days within the payroll period
    $sql_GetPresentDays = "
    SELECT COUNT(*) AS presentDays 
    FROM `tbl_attendance` 
    WHERE employee_id = $employee_id 
    AND date BETWEEN '$startDate' AND '$endDate' 
    AND status_id = 1";
    $res_GetPresentDays = $conn->query($sql_GetPresentDays);

    if ($res_GetPresentDays->num_rows > 0) {
        $presentDaysData = $res_GetPresentDays->fetch_assoc();
        $presentDays = $presentDaysData['presentDays'];

        // Fetch employee's absences count within the payroll period
        $sql_GetAbsences = "SELECT COUNT(*) AS absences, j.job_salary FROM `tbl_attendance` a INNER JOIN tbl_employee_info ei ON a.employee_id = ei.employee_id INNER JOIN tbl_job j ON j.job_id = ei.job_id WHERE a.employee_id = $employee_id AND a.date BETWEEN '$startDate' AND '$endDate' AND a.status_id = 3";
        $res_GetAbsences = $conn->query($sql_GetAbsences);

        if ($res_GetAbsences->num_rows > 0) {
            $absencesData = $res_GetAbsences->fetch_assoc();
            $absences = $absencesData['absences'];

            // Calculate absent rate based on job salary (assuming 8 hours per day)
            $jobSalary = $absencesData['job_salary'];
            $absentRate = $jobSalary * 8; // Assuming 8 hours per day

            // Fetch employee's time in and time out records within the payroll period
            $sql_GetTimeRecords = "SELECT timein, timeout FROM `tbl_attendance` WHERE employee_id = $employee_id AND date BETWEEN '$startDate' AND '$endDate'";
            $res_GetTimeRecords = $conn->query($sql_GetTimeRecords);

            $overtimeHours = 0;

            // Calculate overtime hours for each day
            while ($row = $res_GetTimeRecords->fetch_assoc()) {
                $timeIn = $row['timein'];
                $timeOut = $row['timeout'];

                // Calculate the time difference between time in and time out
                $timeDiff = strtotime($timeOut) - strtotime($timeIn);

                // Convert the time difference to hours
                $totalHoursWorked = $timeDiff / (60 * 60);

                // Check if the total hours worked exceed 8 hours
                if ($totalHoursWorked > 8) {
                    // Calculate overtime hours
                    $overtimeHours += $totalHoursWorked - 8;
                }
            }

            // Return data as JSON
            $data = array(
                'presentDays' => $presentDays,
                'absences' => $absences,
                'absentRate' => $absentRate,
                'overtimeHours' => $overtimeHours
            );
            echo json_encode($data);
        } else {
            // If no absences found, return empty data
            echo json_encode(array('presentDays' => 0, 'absences' => 0, 'absentRate' => 0, 'overtimeHours' => 0));
        }
    } else {
        // If no present days found, return empty data
        echo json_encode(array('presentDays' => 0, 'absences' => 0, 'absentRate' => 0, 'overtimeHours' => 0));
    }
} else {
    // If no payroll details found, return empty data
    echo json_encode(array('presentDays' => 0, 'absences' => 0, 'absentRate' => 0, 'overtimeHours' => 0));
}
