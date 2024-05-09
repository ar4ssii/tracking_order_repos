<?php
// Assuming dbcon.php includes database connection code

session_start();
include 'dbcon.php';
date_default_timezone_set('Asia/Manila');

$currentDate = date("Y-m-d");

if (isset($_POST['btn_print'])) {
    $employeeKeyID = $_POST['employeeKeyID'];
    $presentDays = $_POST['presentDays'];
    $PayrollList = $_POST['PayrollList'];
    $SalaryPerHour = $_POST['SalaryPerHour'];
    $Thirteenth = $_POST['Thirteenth'] ?? 0;
    $Overtime = $_POST['Overtime'] ?? 0;
    $OvertimeRate = $_POST['OvertimeRate'] ?? 0;
    $Absent = $_POST['Absent'];
    $AbsentRate = $_POST['AbsentRate'];
    $Philhealth = $_POST['Philhealth'] ?? 0;
    $SSS = $_POST['SSS'] ?? 0;
    $Pagibig = $_POST['Pagibig'] ?? 0;
    $GrossPay = $_POST['GrossPay'];
    $TotalDeduction = $_POST['TotalDeduction'];
    $TotalSalary = $_POST['TotalSalary'];

    // Insert total salary record and get the inserted ID
    $sql_InsertTotal = "INSERT INTO `total_salary`
    (`payroll_id`, `total_gross`, `total_deduction`, `total_salary`, `date`, `employee_id`) 
    VALUES ($PayrollList,'$GrossPay','$TotalDeduction','$TotalSalary','$currentDate',$employeeKeyID)";
    if ($conn->query($sql_InsertTotal) === TRUE) {
        $TotalSalary_id = $conn->insert_id; // Get the last inserted ID
    } else {
        // Handle error
        echo "Error: " . $sql_InsertTotal . "<br>" . $conn->error;
    }

    // Calculate basic salary
    $basic_salary = $presentDays * ($SalaryPerHour * 8);

    // Insert salary details
    $sql_salary_details = "
    INSERT INTO `salary_details`
    (`TotalSalary_id`, `basic_salary`, `thirteenth_month_pay`, `overtime_hours`, `regular_overtime_rate`) 
    VALUES ($TotalSalary_id,'$basic_salary','$Thirteenth','$Overtime','$OvertimeRate')
    ";
    if ($conn->query($sql_salary_details) === FALSE) {
        // Handle error
        echo "Error: " . $sql_salary_details . "<br>" . $conn->error;
    }

    // Insert deduction details
    $sql_deduction_details = "
    INSERT INTO `deduction_details`(`absent_count`, `absent_rate`,  `philhealth`, `sss`, `pagibig`, `salary_id`) 
    VALUES ($Absent,'$AbsentRate','$Philhealth','$SSS','$Pagibig',$TotalSalary_id)
    ";
    if ($conn->query($sql_deduction_details) === FALSE) {
        // Handle error
        echo "Error: " . $sql_deduction_details . "<br>" . $conn->error;
    }

    header('location: ../employee_payslip.php?id='.$TotalSalary_id);
    exit();
}
