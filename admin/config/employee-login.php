<?php
session_start();
include 'dbcon.php';

if (isset($_POST['btn-login'])) {

    // Sanitize user inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Prepare SQL statement
    $sql = "SELECT * FROM tbl_employee_account WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        // Fetch the row to get user information
        $row = $result->fetch_assoc();


        // Login successful
        $_SESSION['username'] = $username;
        $_SESSION['auth'] = true;

        $keyID = $row['employee_id'];

        $sql_FetchEmployeeInfo = "SELECT ei.*, lr.login_role, j.job_title, j.department FROM tbl_employee_info ei
        INNER JOIN tbl_employee_account ea ON ea.employee_id = ei.employee_id
        INNER JOIN tbl_login_role lr ON lr.login_role_id = ea.login_role_id
        INNER JOIN tbl_job j ON j.job_id = ei.job_id
         WHERE ea.employee_id = $keyID";
        $result_FetchEmployeeInfo = $conn->query($sql_FetchEmployeeInfo);

        if ($result_FetchEmployeeInfo) {
            $fetch = $result_FetchEmployeeInfo->fetch_assoc();
            // Store user information in session
            $_SESSION['user_info'] = [
                'role' => $row['login_role_id'],
                'role_name' => $fetch['login_role'],
                'id' => $fetch['employee_id'],
                'FullName' => $fetch['firstname'] . ' ' . $fetch['middlename'] . ' ' . $fetch['lastname'],
                'birthdate' => $fetch['birthdate'],
                'gender' => $fetch['gender'],
                'age' => $fetch['age'],
                'marital_status' => $fetch['marital_status'],
                'email' => $fetch['email'],
                'phone_num' => $fetch['phone_num'],
                'province' => $fetch['province'],
                'zip' => $fetch['zip'],
                'elem' => $fetch['elem'],
                'jhs' => $fetch['jhs'],
                'shs' => $fetch['shs'],
                'college' => $fetch['college']
            ];

            if($_SESSION['user_info']['role'] == 3){
                header("Location: ../deliver.php");
                exit();
            }else{
                header("Location: ../index.php");
                exit();
            }
            
        }
    } else {
        // Login failed
        
        header("Location: ../../index.php");
        exit();
    }
}
