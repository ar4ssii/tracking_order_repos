<?php
session_start();
$_SESSION['form_values'] = $_POST;
include 'dbcon.php';

if (isset($_POST['btn_save_employee'])) {

    // tbl_employee_account
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $login_role_id = $_POST['login_role_id'];

    // tbl_employee_info
    $extensionname = isset($_POST['extensionname']) ? $_POST['extensionname'] : "";
    $firstname = $_POST['firstname'];
    $middlename = isset($_POST['midd$middlename']) ? $_POST['midd$middlename'] : "";
    $lastname = $_POST['lastname'].' '. $extensionname;
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $marital_status = $_POST['marital_status'];
    $email = $_POST['email'];
    $phone_num = $_POST['phone_num'];
    $province = $_POST['province'];
    $zip = $_POST['zip'];
    $elem = $_POST['elem'];
    $jhs = $_POST['jhs'];
    $shs = $_POST['shs'];
    $college = $_POST['college'];

    // tbl_job
    $job_title = $_POST['job_title'];
    $department = $_POST['department'];
    $hire_date = $_POST['hire_date'];
    $hire_status = $_POST['hire_status'];
    $job_salary = $_POST['job_salary'];

    // confirm password
    if ($password === $confirm_password) {  //proceed to verify username

        // username verification
        $sql_username_verify = "SELECT username FROM tbl_employee_account WHERE username = '$username'";
        $result = $conn->query($sql_username_verify);
        if ($result->num_rows > 0) {   //may username na kaparehas
            $_SESSION['ActivateAlert'] = true;
            $_SESSION['AlertColor'] = "alert-danger";
            $_SESSION['AlertMsg'] = "Username is already taken";
            header('location: ../add_employee_account.php');
            exit();
        } else { //walang kaparehas, proceed to inserting credentials

            // insert employee account
            $sql_insertAccount = "INSERT INTO tbl_employee_account(username,password,login_role_id)
                                  VALUES ('$username', '$password', '$login_role_id')";
            $result_insertAccount = $conn->query($sql_insertAccount);
            if ($result_insertAccount === true) { // insert employee account success

                // Get the auto-generated employee_id
                $employee_id = $conn->insert_id;

                // insert job info
                $sql_insertJobInfo = "INSERT INTO tbl_job(job_title,department,hire_date,hire_status,job_salary)
                                        VALUES ('$job_title', '$department', '$hire_date', '$hire_status', '$job_salary')";
                $result_insertJobInfo = $conn->query($sql_insertJobInfo);

                if ($result_insertJobInfo === true) { // insert job info success

                    // Get the auto-generated job_id
                    $job_id = $conn->insert_id;

                    // insert employee info
                    $sql_insertEmployeeInfo = "INSERT INTO `tbl_employee_info`(`employee_id`, `job_id`, `firstname`, `middlename`, `lastname`, `birthdate`, `gender`, `age`, `marital_status`, `email`, `phone_num`, `province`, `zip`, `elem`, `jhs`, `shs`, `college`) 
                    VALUES ($employee_id,$job_id,'$firstname','$middlename','$lastname','$birthdate','$gender',$age,'$marital_status','$email','$phone_num','$province','$zip','$elem','$jhs','$shs','$college')";
                    $result_insertEmployeeInfo = $conn->query($sql_insertEmployeeInfo);

                    if ($result_insertEmployeeInfo == true) { // insert employee info success
                        $_SESSION['ActivateAlert'] = true;
                        $_SESSION['AlertColor'] = "alert-success";
                        $_SESSION['AlertMsg'] = "New Account Created Successfully!";
                    } else { // insert employee info failed
                        $_SESSION['ActivateAlert'] = true;
                        $_SESSION['AlertColor'] = "alert-danger";
                        $_SESSION['AlertMsg'] = "Failed to Create A New Account.";
                    }
                    header('location: ../employee_management.php');
                    exit();
                } else { // insert job info failed
                    $_SESSION['ActivateAlert'] = true;
                    $_SESSION['AlertColor'] = "alert-danger";
                    $_SESSION['AlertMsg'] = "Failed to Insert Job Info.";
                    header('location: ../add_employee_account.php');
                    exit();
                }
            } else { // insert employee account failed
                $_SESSION['ActivateAlert'] = true;
                $_SESSION['AlertColor'] = "alert-danger";
                $_SESSION['AlertMsg'] = "Failed to Insert Employee Account.";
                header('location: ../add_employee_account.php');
                exit();
            }
        }
    } else {   //go back to add_employee bc they are not matched
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-danger";
        $_SESSION['AlertMsg'] = "Confirming Passwords Do Not Matched";
        header('location: ../add_employee_account.php');
        exit();
    }
}
