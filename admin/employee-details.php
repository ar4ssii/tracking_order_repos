<?php
include "template/header.php";
include 'validation/employee-validation.php';
include "page-includes/sidebar.php";
include "page-includes/navbar.php";
?>
<?php
$EmployeeKeyID = $_GET['id'];

$sql_fetch_employee_info = "
SELECT ei.*,j.* FROM tbl_employee_info ei
INNER JOIN tbl_job j ON j.job_id = ei.job_id
WHERE employee_id = $EmployeeKeyID;
";
$result_fetch_employee_info = mysqli_query($conn, $sql_fetch_employee_info);

if (mysqli_num_rows($result_fetch_employee_info) > 0) {
    // Loop through each row of data
    while ($employee = mysqli_fetch_assoc($result_fetch_employee_info)) {
$FullName = $employee['lastname'] .', '.$employee['firstname'].' '.$employee['middlename'];
?>

        <!-- Page content -->
        <div class="main">
            <div class="container-fluid bg-light p-3 border">
                <h3 class="text-center">Employee Information</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Full Name:</td>
                                <td><?= $FullName ?></td>
                            </tr>
                            <tr>
                                <td>Job Position:</td>
                                <td><?= $employee['job_title'] ?></td>
                            </tr>
                            <tr>
                                <td>Department:</td>
                                <td><?= $employee['department'] ?></td>
                            </tr>
                            <tr>
                                <td>Hire Date:</td>
                                <td><?=  date('m/d/Y', strtotime($employee['hire_date'])) ?></td>
                            </tr>
                            <tr>
                                <td>Hire Status:</td>
                                <td><?= $employee['hire_status'] ?></td>
                            </tr>
                            <tr class="text-center fw-bold">
                                <td colspan="2">Contact Information</td>
                            </tr>
                            <tr>
                                <td>Cellphone Number:</td>
                                <td><?= $employee['phone_num'] ?></td>
                            </tr>
                            <tr>
                                <td>Email Address:</td>
                                <td><?= $employee['email'] ?></td>
                            </tr>
                            <tr>
                                <td>Home Address:</td>
                                <td><?= $employee['province'] .' '. $employee['zip'] ?></td>
                            </tr>
                            <tr class="text-center fw-bold">
                                <td colspan="2">Personal Information</td>
                            </tr>
                            <tr>
                                <td>Birthdate</td>
                                <td><?=  date('m/d/Y', strtotime($employee['birthdate'])) ?></td>
                            </tr>
                            <tr>
                                <td>Gender:</td>
                                <td><?= $employee['gender'] ?></td>
                            </tr>
                            <tr>
                                <td>Age:</td>
                                <td><?= $employee['age'] ?></td>
                            </tr>
                            <tr>
                                <td>Marital Status:</td>
                                <td><?= $employee['marital_status'] ?></td>
                            </tr>
                            <tr class="text-center fw-bold">
                                <td colspan="2">Educational Background</td>
                            </tr>
                            <tr>
                                <td>Elementary:</td>
                                <td><?= $employee['elem'] ?></td>
                            </tr>
                            <tr>
                                <td>Junior High School:</td>
                                <td><?= $employee['jhs'] ?></td>
                            </tr>
                            <tr>
                                <td>Senior High School:</td>
                                <td><?= $employee['shs'] ?></td>
                            </tr>
                            <tr>
                                <td>College:</td>
                                <td><?= $employee['college'] ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

<?php }
} ?>
<?php
include "template/footer.php"; ?>