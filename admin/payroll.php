<?php
include "template/header.php";
include 'validation/employee-validation.php';
include "page-includes/sidebar.php";
include "page-includes/navbar.php";

?>

<!-- Page content -->
<div class="main">
    <div class="container-fluid bg-light p-3">
        <h3 class="text-center">Payroll List</h3>
        <div class="mx-2 pb-3 d-flex justify-content-end">
            <a type="button" href="#" class="btn btn-rounded btn-info" data-bs-toggle="modal" data-bs-target="#AddPayrollModal">
                <i class="fa-solid fa-plus"></i> Add Payroll
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Reference Number</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Payroll Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <?php
                $sql_FetchPayroll = "SELECT * FROM `tbl_payroll`";
                $res = $conn->query($sql_FetchPayroll);

                if ($res->num_rows > 0) {
                    while ($payroll = $res->fetch_assoc()) {
                        // Display table rows based on filtered data
                ?>
                        <tbody>
                            <tr>
                                <td><?= $payroll['reference_number'] ?></td>
                                <td><?= $payroll['StartDate'] ?></td>
                                <td><?= $payroll['EndDate'] ?></td>
                                <td><?= $payroll['PayrollType'] ?></td>
                                <td>
                                    <a href="payroll-list.php?id=<?= $payroll['payroll_id'] ?>" type="button" class="btn btn-info"><i class="fa-solid fa-eye"></i></a>
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