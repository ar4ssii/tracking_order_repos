<?php
session_start();
include '..\..\admin\config\dbcon.php';
$_SESSION['form_values'] = $_POST;


$login_role_id = 4;

$name = $_POST['name'];
$address = $_POST['address'];
$contact_information = $_POST['contact_information'];
$username = $_POST['username'];
$password = $_POST['password'];
$ConfirmPassword = $_POST['ConfirmPassword'];

if (isset($_POST['btn-register'])) {

    if ($password == $ConfirmPassword) {

        $sql_verifyUsername = "SELECT username FROM customers WHERE username = '$username'";
        $result_verifyUsername = $conn->query($sql_verifyUsername);

        if ($result_verifyUsername->num_rows == 1) {
            $_SESSION['ActivateAlert'] = true;
            $_SESSION['AlertColor'] = "alert-danger";
            $_SESSION['AlertMsg'] = "Username is Already Taken.";
        } else {

            $sql_Register = "INSERT INTO customers(name, address, contact_information,username, password, login_role_id)
            VALUES('$name','$address','$contact_information','$username','$password',$login_role_id)";
            $result_Register = $conn->query($sql_Register);

            if ($result_Register == TRUE) {
                $_SESSION['ActivateAlert'] = true;
                $_SESSION['AlertColor'] = "alert-success";
                $_SESSION['AlertMsg'] = "Registration Success! You may now <a href=".'login.php'.">login</a> with your newly created account.";
            } else {
                $_SESSION['ActivateAlert'] = true;
                $_SESSION['AlertColor'] = "alert-danger";
                $_SESSION['AlertMsg'] = "Error in Registration.";
            }
        }
    } else {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-danger";
        $_SESSION['AlertMsg'] = "Password do not match.";
    }

    header("Location: ../register.php");
    $conn->close();
}
