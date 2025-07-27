<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Zero Waste Admin Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: #fefae0; 
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-container {
      max-width: 420px;
      margin: 80px auto;
      background: #ffffff;
      padding: 35px 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      border-top: 6px solid #6a994e;
    }

    .login-title {
      font-weight: 700;
      color: #6a994e;
      font-size: 1.8rem;
    }

    .login-title i {
      color: #bc4749;
    }

    .form-label {
      font-weight: 500;
    }

    .form-control:focus {
      box-shadow: none;
      border-color: #6a994e;
    }

    .btn-login {
      background-color: #6a994e;
      border: none;
    }

    .btn-login:hover {
      background-color: #52724f;
    }

    .food-note {
      font-size: 0.9rem;
      color: #8d99ae;
      margin-top: 15px;
    }
  </style>
</head>
<body>

<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$err = "";
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../../connection/connect.php';

    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password']));
    $query = mysqli_prepare($db, "SELECT * FROM admin WHERE username = ? AND password = ?");
    $query->bind_param('ss', $username , $password);
    $query->execute();
    $result = $query->get_result();
    $admin = $result->fetch_assoc();
    echo $username;
    if(isset($admin['adm_id'])){
        $_SESSION['adm_id'] = $admin['adm_id'];
        header("Location: /zerowaste/admin/");
        exit;
    }
  }
?>

<div class="login-container text-center">
  <div class="mb-4">
    <i class="fas fa-seedling fa-2x"></i>
    <h3 class="login-title mt-2">Zero Waste Admin</h3>
  </div>

  <form method="post" action="">
    <div class="form-group mb-3 text-start">
      <label for="username" class="form-label">Username</label>
      <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
    </div>

    <div class="form-group mb-4 text-start">
      <label for="password" class="form-label">Password</label>
      <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
    </div>

    <button type="submit" class="btn btn-login w-100 text-white">
      <i class="fas fa-sign-in-alt me-2"></i>Login
    </button>
  </form>

  <!-- <div class="food-note text-muted">
    <i class="fas fa-utensils me-1 text-danger"></i>
    Helping reduce food waste by donating over-prepared meals.
  </div> -->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
