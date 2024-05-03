<?php
include "template/header.php";
include "page-includes/sidebar.php";
include "page-includes/navbar.php";
unset($_SESSION['form_values']);

// // Function to sanitize user input
// function sanitizeInput($input)
// {
//     return htmlspecialchars(trim($input));
// }

// // Fetch data from database
// $sql_FetchProducts = "SELECT * FROM product";
// if (isset($_GET['submit'])) {
//     // Sanitize the input
//     $search = sanitizeInput($_GET['search']);

//     // Add a WHERE clause to filter based on multiple columns
//     $sql_FetchProducts .= " WHERE name LIKE '%$search%'
//                             OR description LIKE '%$search%'
//                             OR price LIKE '%$search%'";
// }
// $result = mysqli_query($conn, $sql_FetchProducts);
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
        <h3 class="text-center">Employees</h3>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-sm-12 col-md-10">
                <form method="GET" action="">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Search Employees" aria-label="Search Employees" aria-describedby="button-product-search">
                        <button class="btn btn-outline-secondary" type="submit" id="button-product-search" name="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid bg-light p-3 border">
        <div class="row">

        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>Hire Status</th>
                        <th colspan="">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_FetchEmployee = "SELECT * FROM `tbl_employee_info` INNER JOIN tbl_employee_account ON tbl_employee_account.employee_id = tbl_employee_info.employee_id INNER JOIN tbl_job ON tbl_job.job_id = tbl_employee_info.job_id";
                    $result = $conn->query($sql_FetchEmployee);

                    // Check if there are any rows returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        $count = 1;
                        while ($row = $result->fetch_assoc()) {
                            $employeeName = $row['lastname'].', '.$row['firstname'].' '. $row['middlename'];
                    ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= $employeeName; ?></td>
                                <td><?= $row["department"]; ?></td>
                                <td><?= $row["hire_status"]; ?></td>
                                <td><button class="btn btn-info">View Details</button></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="5">No employees found.</td>
                        </tr>
                    <?php  } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="add-button-container">
        <a type="button" href="add_employee_account.php" class="btn btn-rounded btn-info"><i class="fa-solid fa-plus"></i> Add Employee</button>
    </div>
</div>

<?php
include "template/footer.php";
?>