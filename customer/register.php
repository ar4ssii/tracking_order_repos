<?php 
session_start(); 

$name = $address = $contact_information = $username = "";

if (isset($_SESSION['form_values'])) {
    $form_values = $_SESSION['form_values'];

    $name = isset($form_values['name']) ? $form_values['name'] : '';
    $address = isset($form_values['address']) ? $form_values['address'] : '';
    $contact_information = isset($form_values['$contact_information']) ? $form_values['$contact_information'] : '';
    $username = isset($form_values['$username']) ? $form_values['$username'] : '';

    unset($_SESSION['form_values']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="customer-assets/css/register-style.css">
</head>

<body class="register-body">
    <div class="register-container">
        <h2>Register</h2>
        <?php if (isset($_SESSION['AlertMsg'])) { ?>
            <div class="alert <?= $_SESSION['AlertColor'] ?> fade show" role="alert">
                <?= $_SESSION['AlertMsg'] ?>

            </div>
        <?php }
        unset($_SESSION['AlertMsg']); ?>
        <form method="post" action="customer-config/customer-register.php">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Name" name="name" value="<?= $name ?>" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Address" name="address" value="<?= $address ?>" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Contact Number" name="contact_information" value="<?= $contact_information ?>" required>
            </div>
            <hr>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Create Username" name="username" value="<?= $username ?>" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Create Password" name="password" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm Password" name="ConfirmPassword" required>
            </div>

            <button type="submit" name="btn-register" class="btn btn-register">Register</button>
        </form>
        <br>
        <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
        
    </div>
</body>

</html>