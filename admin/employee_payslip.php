<?php
include "template/header.php";
include 'validation/employee-validation.php';
include "page-includes/sidebar.php";
include "page-includes/navbar.php";

$TotalSalary_id = $_GET['id'];

$fetch_TotalSalary = "
SELECT 
ts.total_gross, ts.total_deduction,ts.total_salary,
tp.reference_number, tp.StartDate, tp.EndDate, tp.PayrollType,
sd.basic_salary,sd.thirteenth_month_pay,sd.overtime_hours,sd.regular_overtime_rate,
dd.absent_count,dd.absent_rate,dd.philhealth,dd.sss,dd.pagibig,
ei.firstname,ei.middlename,ei.lastname,ei.employee_id,
j.job_title, j.department, j.job_salary

FROM `total_salary` ts 
LEFT JOIN tbl_payroll tp ON tp.payroll_id = ts.payroll_id
LEFT JOIN salary_details sd ON sd.TotalSalary_id = ts.TotalSalary_id
LEFT JOIN deduction_details dd ON dd.salary_id = sd.salary_id
LEFT JOIN tbl_employee_info ei ON ei.employee_id = ts.employee_id
LEFT JOIN tbl_job j ON ei.job_id = j.job_id
WHERE ts.TotalSalary_id = $TotalSalary_id
";
$result = mysqli_query($conn, $fetch_TotalSalary);
?>

<!-- Page content -->
<div class="main">
    <div class="container-fluid bg-light p-3">
        <h3 class="text-center">Employee Payslip</h3>
        <br>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $FullName = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
            $StartDate = date("F j, Y", strtotime($row['StartDate']));
            $EndDate = date("F j, Y", strtotime($row['EndDate']));
        ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td colspan="2" class="text-white bg-secondary">Employee Information</td>
                    </tr>
                    <tr>
                        <td class="tr-title">Employee Number:</td>
                        <td><?= 'EMP' . $row['employee_id'] ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">Full Name:</td>
                        <td><?= $FullName ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">Position:</td>
                        <td><?= $row['job_title'] ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">Department:</td>
                        <td><?= $row['department'] ?></td>
                    </tr>

                    <tr>
                        <td colspan="2"  class="text-white bg-secondary">Payroll Details</td>
                    </tr>
                    <tr>
                        <td class="tr-title">Payroll Reference Number:</td>
                        <td><?= $row['reference_number'] ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">Payroll Date Range:</td>
                        <td><?= $StartDate . ' - ' . $EndDate ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">Payroll Type:</td>
                        <td><?= $row['PayrollType'] ?></td>
                    </tr>

                    <tr>
                        <td colspan="2"  class="text-white bg-secondary">Salary Details</td>
                    </tr>
                    <tr>
                        <td class="tr-title">Basic Salary:</td>
                        <td><?= number_format($row['basic_salary'], 2) ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">13th Month Pay:</td>
                        <td><?= number_format($row['thirteenth_month_pay'], 2) ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">Overtime Hours:</td>
                        <td><?= number_format($row['overtime_hours'],0) .' hrs' ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">Overtime Rate Per Hour:</td>
                        <td><?= number_format($row['regular_overtime_rate'], 2). '/hr' ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">Absent:</td>
                         <td><?= ($row['absent_count'] != 0) ? $row['absent_count'] : 'none' ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">Absent Rate:</td>
                        <td><?= number_format($row['absent_rate'], 2) ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">PhilHealth:</td>
                        <td><?= number_format($row['philhealth'], 2) ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">SSS:</td>
                        <td><?= number_format($row['sss'], 2) ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">Pag-ibig:</td>
                        <td><?= number_format($row['pagibig'], 2) ?></td>
                    </tr>

                    <tr>
                        <td class="tr-title">Total Gross Pay:</td>
                        <td><?= number_format($row['total_gross'], 2) ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">Total Deduction:</td>
                        <td><?= number_format($row['total_deduction'], 2) ?></td>
                    </tr>
                    <tr>
                        <td class="tr-title">Total Salary:</td>
                        <td><?= number_format($row['total_salary'], 2) ?></td>
                    </tr>

                </table>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<?php
include "template/footer.php";
?>