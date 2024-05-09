<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/index-style.css">
</head>

<body>

  <div class="login-container">
    <h2>System Login</h2>
    <form action="admin/config/employee-login.php" method="post">
      <div class="form-group">
        <input type="text" class="form-control" name="username" placeholder="Username" required>
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
      </div>
      <button type="submit" name="btn-login" class="btn btn-login">Login</button>
    </form>

    
  </div>



</body>

</html>