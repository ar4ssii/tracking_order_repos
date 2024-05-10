<?php
include "template/header.php";
include 'validation/admin-validation.php';
include "page-includes/sidebar.php";
include "page-includes/navbar.php";

$employeeID = $_SESSION['user_info']['id'];

?>

<!-- Page content -->
<div class="main">
    <div class="container-fluid bg-light p-3">
        <h3 class="text-center">Payslip List</h3>
        <h6 class="text-center">EM<?= $employeeID ?></h6>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Reference Number</th>
                        <th>Date Range</th>
                        <th>Gross Salary</th>
                        <th>Deductions</th>
                        <th>Total Salary</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <?php
                $sql_FetchPayroll = "SELECT 
                ts.TotalSalary_id, ts.total_gross,ts.total_deduction,ts.total_salary, 
                ei.employee_id, ei.firstname, ei.middlename, ei.lastname,
                tp.reference_number,tp.StartDate,tp.EndDate
                FROM 
                    `tbl_payroll` tp 
                INNER JOIN total_salary ts ON ts.payroll_id = tp.payroll_id
                INNER JOIN tbl_employee_info ei ON ei.employee_id = ts.employee_id
                WHERE ei.employee_id = $employeeID";
                $res = $conn->query($sql_FetchPayroll);

                if ($res->num_rows > 0) {
                    while ($payslip = $res->fetch_assoc()) {
                        // Display table rows based on filtered data
                        $StartDate = date("F j, Y", strtotime($payslip['StartDate']));
                        $EndDate = date("F j, Y", strtotime($payslip['EndDate']));
                ?>
                        <tbody>
                            <tr>
                                <td><?= $payslip['reference_number'] ?></td>
                                <td><?= $StartDate . ' - ' . $EndDate ?></td>
                                <td><?= $payslip['total_gross'] ?></td>
                                <td><?= $payslip['total_deduction'] ?></td>
                                <td><?= $payslip['total_salary'] ?></td>
                                <td>
                                    <a href="employee_payslip.php?id=<?= $payslip['TotalSalary_id'] ?>" type="button" class="btn btn-info"><i class="fa-solid fa-eye"></i></a>
                                </td>
                            </tr>
                        </tbody>
                <?php }
                } ?>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="AddPayrollModal" tabindex="-1" aria-labelledby="AddPayrollModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="AddPayrollModalLabel">Add New Payroll</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="config/add_payroll.php" method="post">
                <div class="modal-body">
                    <div class="col mb-2">
                        <label for="">Start Date:</label>
                        <div class="input-group">
                            <input type="date" name="StartDate" required class="form-control">
                        </div>
                    </div>
                    <div class="col mb-2">
                        <label for="">End Date:</label>
                        <div class="input-group">
                            <input type="date" name="EndDate" id="" required class="form-control">
                        </div>
                    </div>
                    <div class="col mb-2">
                        <label for="">Payroll Type:</label>
                        <div class="input-group">
                            <select name="PayrollType" id="" class="form-control">
                                <option value="MONTHLY">MONTHLY</option>
                                <option value="SEMI-MONTHLY">SEMI-MONTHLY</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btn_add_payroll" class="btn btn-primary">Create Payroll</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include "template/footer.php";
?>