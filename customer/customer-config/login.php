<?php
session_start();
include '..\..\admin\config\dbcon.php';

if (isset($_POST['btn-login'])) {

    // Sanitize user inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Prepare SQL statement
    $sql = "SELECT * FROM customers WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful
        $_SESSION['username'] = $username;
        $_SESSION['auth'] = true;

        // Fetch the row to get user information
        $row = $result->fetch_assoc();

        // Store user information in session
        $_SESSION['user_info'] = [
            'role' => $row['login_role_id'],
            'id' => $row['customer_id'],
            'name' => $row['name'],
            'contact_information' => $row['contact_information'],
            'address' => $row['address']
        ];

        header("Location: ../index.php");
        exit();
    } else {
        // Login failed
        $_SESSION['error'] = "Incorrect username or password.";
        header("Location: ../login.php");
        exit();
    }
}
