<?php
include "template/header.php";
include 'validation/employee-validation.php';
include "page-includes/sidebar.php";
include "page-includes/navbar.php";

$employeeKeyID = $_GET['id'];

$sql_FetchEmployeePayroll = "
SELECT lastname,firstname,middlename,employee_id, job_title, department, job_salary
FROM `tbl_employee_info` ei
INNER JOIN tbl_job j ON ei.job_id = j.job_id
WHERE ei.employee_id = $employeeKeyID
";
$res_FetchEmployeePayroll = $conn->query($sql_FetchEmployeePayroll);

?>

<!-- Page content -->
<div class="main">
    <form action="config/print_payslip.php" method="post">
        <div class="container-fluid bg-light p-3">
            <h3 class="text-center">Employee Payroll</h3>
            <br>
            <input type="text" name="employeeKeyID" value="<?= $_GET['id'] ?>" id="employeeKeyID">
            <input type="text" name="presentDays" id="presentDays">
            <?php
            if (mysqli_num_rows($res_FetchEmployeePayroll) > 0) {
                // Loop through each row of data
                while ($employeePayroll = mysqli_fetch_assoc($res_FetchEmployeePayroll)) {
                    $FullName = $employeePayroll['lastname'] . ', ' . $employeePayroll['firstname'] . ' ' . $employeePayroll['middlename']; ?>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="">Full Name:</label>
                            <div class="input-group">
                                <input type="text" name="FullName" value="<?= $FullName ?>" readonly class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <label for="">Employee Number:</label>
                            <div class="input-group">
                                <input type="text" name="employeeNumber" value="<?= 'EMP' . $employeePayroll['employee_id'] ?>" readonly class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="">Job Title/Position:</label>
                            <div class="input-group">
                                <input type="text" name="JobPosition" value="<?= $employeePayroll['job_title'] ?>" readonly class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <label for="">Department:</label>
                            <div class="input-group">
                                <input type="text" name="Department" value="<?= $employeePayroll['department'] ?>" readonly class="form-control">
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row mb-2">
                        <!-- salary info col -->
                        <div class="col">
                            <div class="row bg-secondary p-2 text-white fw-bold mx-0 mb-2">
                                Salary Information
                            </div>
                            <div class="mb-2">
                                <?php
                                $sql_FetchPayroll = "SELECT * FROM `tbl_payroll`";
                                $res = $conn->query($sql_FetchPayroll);

                                if ($res->num_rows > 0) {
                                ?>
                                    <label for="">Select Payroll:</label>
                                    <div class="input-group">
                                        <select name="PayrollList" id="payrollList" class="form-control">
                                            <option value="" disabled selected>-- Select Payroll --</option>
                                            <?php while ($payroll = $res->fetch_assoc()) {
                                                $StartDate = date("F j, Y", strtotime($payroll['StartDate']));
                                                $EndDate = date("F j, Y", strtotime($payroll['EndDate']));
                                            ?>
                                                <option value="<?= $payroll['payroll_id'] ?>"><?= $StartDate . ' - ' . $EndDate ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php
                                } ?>
                            </div>
                            <div class="mb-2">
                                <label for="">Salary per Hour:</label>
                                <div class="input-group">
                                    <input type="text" name="SalaryPerHour" id="SalaryPerHour" value="<?= number_format($employeePayroll['job_salary'], 2) ?>" readonly class="form-control">
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="">13th Month Pay:</label>
                                <div class="input-group">
                                    <input type="text" name="Thirteenth" id="Thirteenth" required class="form-control">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col">
                                    <label for="">Total Hrs of Overtime:</label>
                                    <div class="input-group">
                                        <input type="text" name="Overtime" id="overtimeHours" required class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="">Overtime Rate:</label>
                                    <div class="input-group">
                                        <input type="text" name="OvertimeRate" id="OTRate" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- deductions col -->
                        <div class="col">
                            <div class="row bg-secondary p-2 text-white fw-bold mx-0 mb-2">
                                Deductions
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="">No. of Absent: </label>
                                    <div class="input-group">
                                        <input type="text" name="Absent" id="numOfAbsent" readonly class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="">Absent Rate:</label>
                                    <div class="input-group">
                                        <input type="text" name="AbsentRate" id="absentRate" readonly class="form-control">
                                    </div>
                                    <p class="text-end mx-2" style="font-size: xx-small;">Per Day</p>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="">PhilHealth:</label>
                                <div class="input-group">
                                    <input type="text" name="Philhealth" id="Philhealth" required class="form-control">
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="">SSS:</label>
                                <div class="input-group">
                                    <input type="text" name="SSS" id="SSS" required class="form-control">
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="">Pag-ibig:</label>
                                <div class="input-group">
                                    <input type="text" name="Pagibig" id="Pagibig" required class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- salary col -->
                        <div class="col">
                            <div class="row bg-secondary p-2 text-white fw-bold mx-0 mb-2">
                                Salary
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="">Gross Pay:</label>
                                    <div class="input-group">
                                        <input type="text" name="GrossPay" id="GrossPay" required class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="">Total Deduction:</label>
                                    <div class="input-group">
                                        <input type="text" name="TotalDeduction" id="TotalDeduction" required class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="">Total Salary:</label>
                                <div class="input-group">
                                    <input type="text" name="TotalSalary" id="TotalSalary" required class="form-control">
                                </div>
                            </div>
                            <div class="mb-2 d-flex justify-content-end">
                                <button class="btn btn-info" type="submit" name="btn_print">
                                    Print Payslip
                                </button>
                            </div>
                        </div>

                    </div>
            <?php }
            } ?>
        </div>
    </form>
</div>
<script>
    // Event listener for payroll selection
    document.getElementById("payrollList").addEventListener("change", function() {
        var payroll_id = this.value;
        var employee_id = document.getElementById('employeeKeyID').value;

        // Ajax call to get absences count and absent rate
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    document.getElementById("numOfAbsent").value = data.absences;
                    document.getElementById("absentRate").value = data.absentRate;
                    document.getElementById("overtimeHours").value = data.overtimeHours;
                    document.getElementById("presentDays").value = data.presentDays;

                    // Calculate gross pay
                    var regularRate = parseFloat(document.getElementById("SalaryPerHour").value);
                    var presentDays = parseInt(data.presentDays);
                    console.log("Present Days:", presentDays);
                    var normalPay = regularRate * 8 * presentDays; // Regular pay for normal hours
                    var overtimeRate = parseFloat(document.getElementById("OTRate").value);
                    var overtimePay = overtimeRate * data.overtimeHours; // Overtime pay
                    var grossPay = normalPay + overtimePay; // Total gross pay


                    // Display gross pay
                    document.getElementById("GrossPay").value = grossPay.toFixed(2);
                    calculateTotals();
                }
            }
        };
        xhr.open("GET", "config/get_absences.php?payroll_id=" + payroll_id + "&employee_id=" + employee_id, true);
        xhr.send();
    });

    // Event listener to calculate total deduction and total salary
    function calculateTotals() {
        var numOfAbsent = parseFloat(document.getElementById("numOfAbsent").value);
        var absentRate = parseFloat(document.getElementById("absentRate").value);

        // Parse optional fields with default values if they are provided
        var philhealth = parseFloat(document.getElementById("Philhealth").value) || 0;
        var pagibig = parseFloat(document.getElementById("Pagibig").value) || 0;
        var sss = parseFloat(document.getElementById("SSS").value) || 0;

        var Thirteenth = parseFloat(document.getElementById("Thirteenth").value) || 0;

        // Compute total deduction
        var totalDeduction = (numOfAbsent * absentRate) + philhealth + pagibig + sss;

        // Compute total salary
        var grossPay = parseFloat(document.getElementById("GrossPay").value) + Thirteenth;
        var totalSalary = grossPay - totalDeduction;

        // Set values for total deduction and total salary inputs
        document.getElementById("TotalDeduction").value = totalDeduction.toFixed(2);
        document.getElementById("TotalSalary").value = totalSalary.toFixed(2);
    }



    // Call calculateTotals function when any of the relevant inputs change
    document.getElementById("numOfAbsent").addEventListener("input", calculateTotals);
    document.getElementById("absentRate").addEventListener("input", calculateTotals);
    document.getElementById("Philhealth").addEventListener("input", calculateTotals);
    document.getElementById("Pagibig").addEventListener("input", calculateTotals);
    document.getElementById("SSS").addEventListener("input", calculateTotals);

    document.getElementById("payrollList").addEventListener("change", function() {
        var regularRate = parseFloat(document.getElementById("SalaryPerHour").value);
        // Retrieve overtime hours input
        var overtimeHours = parseFloat(this.value);
        console.log("Regular Rate:", regularRate);
        console.log("Overtime Hours:", overtimeHours);


        var overtimeRate = regularRate * 0.25;
        console.log("Overtime Rate:", overtimeRate);
        // Display overtime rate in the corresponding input field
        document.getElementById("OTRate").value = overtimeRate.toFixed(2);
    });
</script>




<?php
include "template/footer.php";
?>