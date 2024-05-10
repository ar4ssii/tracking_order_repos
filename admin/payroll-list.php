<?php
include "template/header.php";
include 'validation/employee-validation.php';
include "page-includes/sidebar.php";
include "page-includes/navbar.php";

$payroll_id = $_GET['id'];

// Fetch the payroll information
$sql_FetchPayroll_Info = "
SELECT 
    reference_number, StartDate, EndDate, PayrollType
FROM 
    `tbl_payroll`
WHERE 
    payroll_id = $payroll_id
";
$result = $conn->query($sql_FetchPayroll_Info);

// Check if payroll information exists
if ($result->num_rows > 0) {
    $payroll_Info = $result->fetch_assoc();
    $reference_number = $payroll_Info['reference_number'];
    $StartDate = date("F j, Y", strtotime($payroll_Info['StartDate']));
    $EndDate = date("F j, Y", strtotime($payroll_Info['EndDate']));
    $PayrollType = $payroll_Info['PayrollType'];
?>

    <!-- Page content -->
    <div class="main">
        <div class="container-fluid bg-light p-3">
            <h3 class="text-center">Payroll <?= $reference_number ?></h3>
            <h5 class="text-center"><?= $StartDate . ' - ' . $EndDate ?></h5>
            <h6 class="text-center"><?= $PayrollType ?></h6>

            <?php
            // Fetch and display employee information
            $sql_FetchPayroll_List = "
        SELECT 
            ts.TotalSalary_id, ts.total_gross,ts.total_deduction,ts.total_salary, ei.employee_id, ei.firstname, ei.middlename, ei.lastname
        FROM 
            `tbl_payroll` tp 
        INNER JOIN total_salary ts ON ts.payroll_id = tp.payroll_id
        INNER JOIN tbl_employee_info ei ON ei.employee_id = ts.employee_id
        WHERE 
            tp.payroll_id = $payroll_id
        ";
            $res = $conn->query($sql_FetchPayroll_List);
            ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Employee Number</th>
                            <th>Employee Name</th>
                            <th>Gross Pay</th>
                            <th>Deductions</th>
                            <th>Total Salary</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($res->num_rows > 0) {
                            while ($payroll_List = $res->fetch_assoc()) {
                                $FullName = $payroll_List['lastname'] . ', ' . $payroll_List['firstname'] . ' ' . $payroll_List['middlename'];
                        ?>
                                <tr>
                                    <td><?= 'EMP' . $payroll_List['employee_id'] ?></td>
                                    <td><?= $FullName ?></td>
                                    <td><?= number_format($payroll_List['total_gross'], 2) ?></td>
                                    <td><?= number_format($payroll_List['total_deduction'], 2) ?></td>
                                    <td><?= number_format($payroll_List['total_salary'], 2) ?></td>
                                    <td>
                                        <a type="button" href="employee_payslip.php?id=<?= $payroll_List['TotalSalary_id'] ?>" class="btn btn-info"><i class="fa-solid fa-eye"></i></a>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="4" class="text-center">No Employees listed in this payroll.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>

<?php
} else {
    echo "Payroll information not found.";
}

include "template/footer.php";
?>