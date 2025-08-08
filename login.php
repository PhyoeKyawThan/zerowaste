<?php
session_start();
error_reporting(0);
include("connection/connect.php");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $hashedPassword = md5($password);
        $loginquery = "SELECT * FROM users WHERE username='$username' AND password='$hashedPassword'";
        $result = mysqli_query($db, $loginquery);
        $row = mysqli_fetch_array($result);
        if (is_array($row)) {
            if ($row['account_status'] == 'Approved') {
                $check_restaurant = $db->query("SELECT * FROM restaurant WHERE user_id = " . (int) $_SESSION['user_id'] . "");
                if (mysqli_num_rows($check_restaurant) > 0) {
                    $res = mysqli_fetch_assoc($check_restaurant);
                    $_SESSION['rs_id'] = $res['rs_id'];
                    $_SESSION['rs_name'] = $res['title'];
                }
                $_SESSION["user_id"] = $row['u_id'];
                $_SESSION['user_name'] = $row['username'];
                $_SESSION['user_role'] = $row['role'];
                if ($row['role'] === 'shop') {
                    header("refresh:1;url=shop.php");
                } else {
                    header("refresh:1;url=index.php");
                }
                exit();
            }else{
                $message = "Your Account is under approval of our Admin.";
            }
        } else {
            $message = "Invalid Username or Password!";
        }
    } else {
        $message = "Please enter both username and password.";
    }
}

$title = "Login";
include 'parts/start.php';
?>

<style>
    body {
        background-image: url('images/img/pimg.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .login-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        padding: 40px 0;
    }

    .login-container {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 40px;
        width: 100%;
        max-width: 500px;
        margin: 50px auto;
    }

    .form-control {
        height: 45px;
        border-radius: 5px;
        border: 1px solid #ddd;
        padding-left: 15px;
        margin-bottom: 15px;
    }

    .form-control:focus {
        border-color: #f30;
        box-shadow: 0 0 0 0.2rem rgba(243, 0, 0, 0.25);
    }

    .btn-login {
        background-color: #5c4ac7;
        color: white;
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
        border-radius: 5px;
        font-size: 16px;
        width: 100%;
    }

    .btn-login:hover {
        background-color: #4a3ab5;
        transform: translateY(-2px);
    }

    .error-message {
        color: #f30;
        margin-bottom: 20px;
        text-align: center;
        font-weight: 500;
        padding: 10px;
        background-color: rgba(243, 0, 0, 0.1);
        border-radius: 5px;
    }

    .success-message {
        color: #28a745;
        margin-bottom: 20px;
        text-align: center;
        font-weight: 500;
        padding: 10px;
        background-color: rgba(40, 167, 69, 0.1);
        border-radius: 5px;
    }

    .page-title {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
        font-weight: 700;
        font-size: 28px;
    }

    .register-link {
        text-align: center;
        margin-top: 20px;
        color: #666;
    }

    .register-link a {
        color: #5c4ac7;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .login-container {
            padding: 30px 20px;
        }

        .page-title {
            font-size: 24px;
        }
    }
</style>

<div class="login-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="login-container">
                    <h2 class="page-title">Login to Your Account</h2>

                    <?php if (isset($message)) { ?>
                        <div class="error-message"><?php echo $message; ?></div>
                    <?php } ?>

                    <?php if (isset($success)) { ?>
                        <div class="success-message"><?php echo $success; ?></div>
                    <?php } ?>

                    <form action="" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-login">
                                <i class="fa fa-sign-in"></i> Login
                            </button>
                        </div>
                        <div class="register-link">
                            Not registered? <a href="registration.php">Create an account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'parts/end.php';
?>