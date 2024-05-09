<?php
include "template/header.php";
include "validation/admin-validation.php";
include "page-includes/sidebar.php";
include "page-includes/navbar.php";
date_default_timezone_set('Asia/Manila');
$currentDate = date("Y-m-d");
$id = $_SESSION['user_info']['id'];
?>

<!-- Page content -->
<div class="main">
    <div class="container-fluid bg-light p-3 border">
        <h3 class="text-center">Daily Attendance (DTR)</h3>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-sm-12 col-md-10 text-center">
                <h5 id="system-time" class="system-time-font"></h5>
                <div class="row d-flex justify-content-center">
                    <div class="col-6">
                        <form action="config/attendance.php" method="post">
                            <div class="d-grid gap-2 col-12 mx-auto">
                                <button type="submit" name="btn_timein" class="btn py-3 btn-lg btn-outline-success" <?= (isset($_SESSION['isTimein']) == true) ? 'disabled' : '' ?>>
                                    Time In
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-6">
                        <form action="config/attendance.php" method="post">
                            <div class="d-grid gap-2 col-12 mx-auto">
                                <button type="submit" name="btn_timeout" class="btn py-3 btn-outline-danger" <?= (isset($_SESSION['isTimeOut']) == true) ? 'disabled' : '' ?>>
                                    Time Out
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $sql = "SELECT * FROM `tbl_attendance` WHERE `employee_id` = '$id' AND `date` = '$currentDate' AND timeout is not null";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $_SESSION['isTimein'] = true;
            $_SESSION['isTimeOut'] = true;
        }
        ?>
        <div class="container my-5 py-3 text-center border rounded bg-white">
            <h6 class="text-start">Attendance Log</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Time-In</th>
                            <th>Time-Out</th>
                            <th>Status</th>
                            <th>Worktime Status</th>
                        </tr>
                    </thead>
                    <?php
                    $sql = "SELECT * FROM `tbl_employee_account` 
                INNER JOIN tbl_employee_info ON tbl_employee_account.employee_id = tbl_employee_info.employee_id
                INNER JOIN tbl_attendance ON tbl_employee_account.employee_id = tbl_attendance.employee_id
                INNER JOIN tbl_worktime_status ON tbl_worktime_status.worktime_status_id = tbl_attendance.worktime_status_id
                INNER JOIN tbl_status ON tbl_status.status_id = tbl_attendance.status_id
                WHERE tbl_employee_account.employee_id = $id";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        $timein = strtotime($row['timein']);
                        if ($row['timeout'] != null) {
                            $timeout = strtotime($row['timeout']);
                        }
                    ?>
                        <tbody>
                            <tr>
                                <td><?= $row['date'] ?></td>
                                <td class="text-capitalize"><?= $row['lastname'] . ' , ' . $row['firstname'] . ' ' . $row['middlename'] ?></td>
                                <td>
                                    <?= date('h:i A', $timein) ?>
                                </td>
                                <td>
                                    <?= ($row['timeout'] != null) ? date('h:i A', $timeout) : 'Pending..' ?>
                                </td>
                                <td>
                                    <?= $row['status'] ?>
                                </td>
                                <td>
                                    <?= $row['worktime_status'] ?>
                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/system-time.js"></script>
<?php
include "template/footer.php";  ?>