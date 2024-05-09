<?php
include 'customer-template/header.php';
include 'customer-template/navbar.php';
?>

<link rel="stylesheet" href="customer-assets/css/login-style.css">
<div class="login-container">
  <h2>Login</h2>
  <form action="customer-config/login.php" method="post">
    <div class="form-group">
      <input type="text" class="form-control" name="username" placeholder="Username" required>
    </div>
    <div class="form-group">
      <input type="password" class="form-control" name="password" placeholder="Password" required>
    </div>
    <button type="submit" name="btn-login" class="btn btn-login">Login</button>
  </form>
  <p class="text-center mt-3">Don't have an account? <a href="register.php">Register</a></p>
  <?php if (isset($_SESSION['AlertMsg'])) { ?>
    <div class="alert <?= $_SESSION['AlertColor'] ?> fade show" role="alert">
      <?= $_SESSION['AlertMsg'] ?>

    </div>
  <?php }
  unset($_SESSION['AlertMsg']); ?>
</div>


<?php
include 'customer-template/footer.php'; ?>