<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <style>
    body {
      background-color: #f8f9fa;
    }
    .register-container {
      position: relative;
      max-width: 500px;
      margin: 50px auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
      background-color: #ffffff;
      overflow: hidden;
    }
    .register-container:before {
      content: '';
      position: absolute;
      top: -50px;
      left: -50px;
      width: 100px;
      height: 200px;
      border-radius: 50%;
      background-color: #007bff;
      transform: rotate(45deg);
    }
    .register-container:after {
      content: '';
      position: absolute;
      bottom: -50px;
      right: -50px;
      width:100px;
      height: 200px;
      border-radius: 50%;
      background-color: #007bff;
      transform: rotate(45deg);
    }
    .register-container h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #007bff;
      position: relative;
      z-index: 1;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ced4da;
      border-radius: 5px;
      transition: all 0.3s ease;
    }
    .form-group input:focus {
      transform: scale(1.05);
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
    .btn-register {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      background-color: #007bff;
      color: #fff;
      border: none;
    }
    .btn-register:hover {
      background-color: #0056b3;
    }
    .text-center {
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Register</h2>
    <form>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Name" required>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Username" required>
      </div>
      <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Address" required>
      </div>
      <div class="form-group">
        <input type="tel" class="form-control" placeholder="Contact Number" required>
      </div>
      <button type="submit" class="btn btn-register">Register</button>
    </form>
    <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
