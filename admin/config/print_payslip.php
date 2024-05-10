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


    $sql_verify_employee = "SELECT ts.*, tp.reference_number, tp.StartDate,tp.EndDate
    FROM `total_salary` ts
    INNER JOIN tbl_payroll tp ON tp.payroll_id = ts.payroll_id
    WHERE ts.employee_id = $employeeKeyID AND tp.payroll_id = $PayrollList";
    $result = $conn->query($sql_verify_employee);
    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $startDate = date("F j, Y", strtotime($row['StartDate']));
        $endDate = date("F j, Y", strtotime($row['EndDate']));
       

        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-danger";
        $_SESSION['AlertMsg'] = "Employee is already in payroll from $startDate to $endDate";

        header('location: ../employee-payroll.php?id=' . $employeeKeyID);
        exit();
    } else {
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
    (`TotalSalary_id`, `basic_salary`, `overtime_hours`, `regular_overtime_rate`) 
    VALUES ($TotalSalary_id,'$basic_salary','$Overtime','$OvertimeRate')
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

        header('location: ../employee_payslip.php?id=' . $TotalSalary_id);
        exit();
    }
}
