<?php
include "template/header.php";
include 'validation/employee-validation.php';
include "page-includes/sidebar.php";
include "page-includes/navbar.php";

// Function to sanitize user input
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}

$user_keyID = $_SESSION['user_info']['id'];
// Fetch data from database
$sql_FetchEmployee = "SELECT * FROM `tbl_employee_info` 
INNER JOIN tbl_employee_account ON tbl_employee_account.employee_id = tbl_employee_info.employee_id 
INNER JOIN tbl_job ON tbl_job.job_id = tbl_employee_info.job_id
INNER JOIN tbl_login_role ON tbl_login_role.login_role_id = tbl_employee_account.login_role_id
";

// Check if search query is set
if (isset($_GET['submit'])) {
    // Sanitize the input (prevent SQL injection)
    $search = sanitizeInput($_GET['search']);

    // Add WHERE clause to filter based on multiple columns
    $sql_FetchEmployee .= " WHERE lastname LIKE '%$search%'
                            OR firstname LIKE '%$search%'
                            OR middlename LIKE '%$search%'
                            OR department LIKE '%$search%'
                            OR hire_status LIKE '%$search%'";
}
$sql_FetchEmployee .=" AND tbl_employee_account.employee_id != $user_keyID";
$result = $conn->query($sql_FetchEmployee);
?>

<!-- Page content -->
<div class="main">
    <?php if (isset($_SESSION['AlertMsg'])) { ?>
        <div class="alert <?= $_SESSION['AlertColor'] ?> fade show" role="alert">
            <?= $_SESSION['AlertMsg'] ?>
        </div>
    <?php }
    unset($_SESSION['AlertMsg']); ?>
    <div class="container-fluid bg-light p-3 border">
        <h3 class="text-center">Employee Management</h3>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-sm-12 col-md-10">
                <form method="GET" action="">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Search Employees" aria-label="Search Employees" aria-describedby="button-employee-search">
                        <button class="btn btn-outline-secondary" type="submit" id="button-employee-search" name="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid bg-light p-3 border">
        <div class="mx-2 pb-3 d-flex justify-content-end">
            <a type="button" href="add_employee_account.php" class="btn btn-rounded btn-info"><i class="fa-solid fa-plus"></i> Add Employee</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee Name</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Login Role</th>
                        <th colspan="">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are any rows returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        $count = 1;
                        while ($row = $result->fetch_assoc()) {
                            $employeeName = $row['lastname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'];
                    ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= $employeeName; ?></td>
                                <td><?= $row['username'] ?></td>
                                <td>********</td>
                                <td><?= $row["login_role"]; ?></td>
                                <td>
                                    <a type="button" href="employee-details.php?id=<?= $row["employee_id"]; ?>" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="View Details"><i class="fa-regular fa-eye"></i></a>
                                    <a type="button" href="employee-payroll.php?id=<?= $row["employee_id"]; ?>" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Manage Employee Payroll"><i class="fa-solid fa-peso-sign text-danger"></i></a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="5" class="text-center">No employees found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include "template/footer.php";
?>